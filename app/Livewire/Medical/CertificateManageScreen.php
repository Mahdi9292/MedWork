<?php

namespace App\Livewire\Medical;

use App\Enums\Medical\PreventionType;
use App\Enums\Medical\SalutationType;
use App\Models\Medical\Activity;
use App\Models\Medical\Certificate;
use App\Models\Medical\Comment;
use App\Models\Medical\Prevention;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;
use Throwable;

class CertificateManageScreen extends Component
{
    use WithFileUploads;

    public Certificate $certificate;
    public CertificateManageForm $certificateManageForm;
    public Collection $inputs;
    public $updateMode = false;

    protected $listeners = ['setEmployerData', 'removeInput'];

    private const string nullable_MESSAGE = 'Dieses Feld muss ausgefüllt werden.';
    private const string NUMERIC_MESSAGE = 'Dieses Feld muss eine Zahl sein.';
    private const string nullable_WITH_MESSAGE = 'Dieses Feld muss ausgefüllt werden, wenn ein Genehmiger ausgewählt wurde.';

    protected array $messages = [

    ];

    public function mount($certificate): void
    {
        $this->certificateManageForm->setCertificate($certificate);
        $this->loadItems();
    }

    private function loadItems(): void
    {
        $preventions = collect($this->certificate->preventions->toArray());

        $this->fill(['inputs' => $preventions]);
    }

    public function setEmployerData($employer): void
    {
        $this->certificateManageForm->employer_name = $employer['name'] ?? null;
        $this->certificateManageForm->employer_contact_person = $employer['contact_person'] ?? null;
        $this->certificateManageForm->employer_address = $employer['address'] ?? null;
        $this->certificateManageForm->employer_street = $employer['street'] ?? null;
        $this->certificateManageForm->employer_house_number = $employer['house_number'] ?? null;
        $this->certificateManageForm->employer_postcode = $employer['postcode'] ?? null;
        $this->certificateManageForm->employer_city = $employer['city'] ?? null;
        $this->certificateManageForm->employer_phone = $employer['phone'] ?? null;
        $this->certificateManageForm->employer_mobile = $employer['mobile'] ?? null;
        $this->certificateManageForm->employer_email = $employer['mail'] ?? null;
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

    /**
     * @throws Throwable
     */
    public function submit($print=false): void
    {
        $this->certificateManageForm->inputs = $this->inputs;

        if(!$this->updateMode){
            $this->certificateManageForm->store();
            $this->certificate = $this->certificateManageForm->certificate;

            $this->redirect(route('medical.certificates.edit', $this->certificate));
        }else{
            $this->certificateManageForm->update();
        }

        // success message
        $this->dispatch('toast:alert', message: 'Speichern erfolgreich!', title: 'Success', status: 1);

        // refreshing the data
        $this->certificate->refresh();
        $this->loadItems();

        // if save and print was clicked
        if($print){
            $this->redirect(route('medical.printCertificate', [$this->certificate, Certificate::DOWNLOAD_TYPE_ZIP]));
        }
    }

    public function render(): view
    {
        // Errors
        if(collect($this->getErrorBag())->count()>0){
            $this->dispatch('toast:alert', message: 'Please fix errors to save!', title: 'Error', status: 2);
        }

        // Dropdown options
        $data['activityOptions']            = Activity::all()->pluck('name', 'id')->toArray();
        $data['employerCommentOptions']     = Comment::employer()->pluck('content', 'id')->toArray();
        $data['employeeCommentOptions']     = Comment::employee()->pluck('content', 'id')->toArray();
        $data['preventionTypeOptions']      = PreventionType::options();
        $data['salutationTypeOptions']      = SalutationType::options();

        // getting sections with error to show validation symbol in card header
        $data = $this->getSectionsWithError($data);

        return view('livewire.medical.certificate-manage-screen', $data);
    }
}
