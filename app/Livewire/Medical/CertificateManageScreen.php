<?php

namespace App\Livewire\Medical;

//use App\Models\TOffer\Attachment;
//use App\Models\TOffer\Offer;
//use App\Models\TOffer\OfferLine;
//use App\Rules\Currency;
//use App\Traits\OfferAttributesTrait;
use App\Enums\Medical\PreventionType;
use App\Enums\Medical\SalutationType;
use App\Models\Medical\Activity;
use App\Models\Medical\Certificate;
use App\Models\Medical\Prevention;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Validator;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class CertificateManageScreen extends Component
{
    use WithFileUploads;

    public Certificate $certificate;
    public Collection $inputs;
    public $updateMode = false;
    public $updateSuccess = false;
    public $attachments = [];

    protected $listeners = ['setEmployerData', 'removeInput'];

    private const string REQUIRED_MESSAGE = 'Dieses Feld muss ausgefüllt werden.';
    private const string NUMERIC_MESSAGE = 'Dieses Feld muss eine Zahl sein.';
    private const string REQUIRED_WITH_MESSAGE = 'Dieses Feld muss ausgefüllt werden, wenn ein Genehmiger ausgewählt wurde.';

    protected array $messages = [
        'offer.discount.required'                        => self::REQUIRED_MESSAGE,

        'inputs.*.device_weight.numeric'                => self::NUMERIC_MESSAGE,

        'inputs.*.prices.*.price'                       => self::REQUIRED_MESSAGE,
        'inputs.*.prices.*.type'                        => self::REQUIRED_MESSAGE,
    ];

    protected function rules():array
    {
        return [
            // Offer head data
            'certificate.certificate_number'          => 'required',
            'certificate.issue_date'                  => 'required',
            'certificate.examination_date'            => 'required',

            // Employee
            'certificate.employee_salutation'                    => 'nullable|max:191',
            'certificate.employee_title'                         => 'nullable',
            'certificate.employee_first_name'                    => 'nullable',
            'certificate.employee_middle_name'                   => 'nullable',
            'certificate.employee_last_name'                     => 'nullable|numeric',
            'certificate.employee_birthday'                      => 'nullable',

            // Employer
            'certificate.employer_name'                 => 'required',
            'certificate.employer_contact_person'                 => 'required',
            'certificate.employer_street'               => 'nullable|max:191',
            'certificate.employer_house_number'         => 'nullable|max:191',
            'certificate.employer_city'                 => 'nullable|max:191',
            'certificate.employer_postcode'             => 'nullable',
            'certificate.employer_phone'                         => 'nullable',
            'certificate.employer_mobile'                        => 'nullable',

            // Preventions
            'inputs.*.prices'                   => 'nullable',
            'inputs.*.prices.*.price'           => 'required',
            'inputs.*.prices.*.type'            => 'required',
            'inputs.*.prices.*.rental_period'   => 'required',

            'attachments.*'                     => 'max:12288',

        ];
    }

    public function mount(): void
    {
        $this->loadItems();
    }

    private function loadItems(): void
    {
        $preventions = collect($this->certificate->preventions->toArray());

        $this->fill(['inputs' => $preventions]);
    }

    public function setEmployerData($employer): void
    {
        $this->certificate->employer_name = $employer['name'] ?? null;
        $this->certificate->employer_contact_person = $employer['contact_person'] ?? null;
        $this->certificate->employer_address = $employer['address'] ?? null;
        $this->certificate->employer_street = $employer['street'] ?? null;
        $this->certificate->employer_house_number = $employer['house_number'] ?? null;
        $this->certificate->employer_postcode = $employer['postcode'] ?? null;
        $this->certificate->employer_city = $employer['city'] ?? null;
        $this->certificate->employer_phone = $employer['phone'] ?? null;
        $this->certificate->employer_mobile = $employer['mobile'] ?? null;

        // TODO:: Add email to the 'employer' table
        //$this->certificate->employer_email = $employer['mail'] ?? null;
    }


    public function addInput(): void
    {
        $this->inputs->push(['id' => 0]);
        $this->dispatch('preventionAdded', lastIndex: $this->inputs->keys()->last());
    }

    public function removeInput($key): void
    {
        $itemToDelete = $this->inputs->get($key);

        // removing item from datatable.
        if($itemToDelete['id']){
            Prevention::find($itemToDelete['id'])->delete();
        }

        // removing from the page
        $this->inputs->pull($key);
    }

    public function copyInput($key): void
    {
        // getting the selected line
        $clone = $this->inputs->get($key);

        // setting db id to null to create as new when saving
        $clone['id'] = 0;

        // pushing into the inputs
        $this->inputs->push($clone);
        $this->dispatch('preventionCopied', lastIndex: $this->inputs->keys()->last());
    }


    public function getFieldID($key, $name, $prefix='inputs'): string
    {
        return join(".", [$prefix, $key, $name]);
    }

    private function getSectionsWithError(array $data): array
    {
        $errorsCollection = collect($this->getErrorBag())->keys();

        $data['inputsWithErrors'] = $errorsCollection->map(function($name) {
            return preg_replace('/[^0-9]/', '', $name);
        })->unique();

        $data['employerWithErrors'] = $errorsCollection->contains(function ($value, $key) {
            return \Str::contains($value, 'certificate.employer_');
        });
        return $data;
    }


    public function updatedCertificateIssueDate($value): void
    {
        $value ?: $this->certificate->issue_date = null;
        $this->validateOnly('certificate.issue_date');
    }

    public function updatedCertificateExaminationDate($value): void
    {
        $value ?: $this->certificate->examination_date = null;
        $this->validateOnly('certificate.examination_date');
    }

    public function submit($print=false): void
    {
        $this->updateSuccess = false;

        // validation
        $this->validate();

        /* //saving attached files.

            foreach ($this->attachments as $attachment)
        {
            $path = $this->offer->getAttachmentFolder();
            $attachment = TemporaryUploadedFile::createFromLivewire($attachment['tmpFilename']);

            $fileName = now()->timestamp . '_' . $attachment->getClientOriginalName();
            $fullPath = $path . '/' . $fileName;
            $attachment->storeAs($path, $fileName, 'twap');

            $attachment = new Attachment;
            $attachment->path = $fullPath;
            $this->offer->attachments()->save($attachment);
        }
        */


        // saving the entities
        $this->saveCertificateAndPreventions();

        // refreshing the data
        $this->certificate->refresh();
        $this->loadItems();

        // resetting file attachment
        //$this->attachments = [];

        // success message
        $this->updateSuccess = true;
        Session::flash('success', __('Speichern erfolgreich.'));

        // if save and print was clicked
        if($print){
            $this->redirect(route('medical.printCertificate', $this->certificate));
        }
    }

    public function saveCertificateAndPreventions(): void
    {
        // validation
        $this->validate();

        // saving offer & lines
        $this->certificate->save();
        if($this->inputs->count() > 0)
        {
            foreach ($this->inputs as $input)
            {
                $this->certificate->preventions()->updateOrCreate(['id'=> $input['id']], $input);
            }
        }

        // success message
        $this->dispatch('toast:alert', message: 'Speichern erfolgreich!', title: 'Success', status: 1);
    }

//    public function downloadFile($attachment)
//    {
//        $attachedFile = Attachment::find($attachment);
//        return $attachedFile->downloadFile();
//    }

    public function render(): view
    {
        // Errors
        if(collect($this->getErrorBag())->count()>0){
            $this->dispatch('toast:alert', message: 'Please fix errors to save!', title: 'Error', status: 2);
        }

        // Dropdown options
        $data['activityOptions']            = Activity::all()->pluck('name', 'id')->toArray();
        $data['preventionTypeOptions']      = PreventionType::options();
        $data['salutationTypeOptions']      = SalutationType::options();

        // getting sections with error to show validation symbol in card header
        $data = $this->getSectionsWithError($data);

        return view('livewire.medical.certificate-manage-screen', $data);
    }
}
