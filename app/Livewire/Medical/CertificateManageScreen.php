<?php

namespace App\Livewire\Medical;

//use App\Models\TOffer\Attachment;
//use App\Models\TOffer\Offer;
//use App\Models\TOffer\OfferLine;
//use App\Rules\Currency;
//use App\Traits\OfferAttributesTrait;
use App\Models\Medical\Certificate;
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

    public Certificate $offer;
    public Collection $inputs;
    public $updateMode = false;
    public $updateSuccess = false;
    public $attachments = [];

    protected $listeners = ['setEmployerData', 'removeInput'];

    private const string REQUIRED_MESSAGE = 'Dieses Feld muss ausgefüllt werden.';
    private const string NUMERIC_MESSAGE = 'Dieses Feld muss eine Zahl sein.';
    private const string REQUIRED_WITH_MESSAGE = 'Dieses Feld muss ausgefüllt werden, wenn ein Genehmiger ausgewählt wurde.';

    protected array $messages = [
        'offer.approval_date.required_with'             => self::REQUIRED_WITH_MESSAGE,
        'offer.discount.numeric'                        => self::NUMERIC_MESSAGE,

        'inputs.*.device_weight.numeric'                => self::NUMERIC_MESSAGE,
        'inputs.*.quantity.integer'                     => self::NUMERIC_MESSAGE,
        'inputs.*.serial_number.required'               => self::REQUIRED_MESSAGE,
        'inputs.*.brand.required'                       => self::REQUIRED_MESSAGE,
        'inputs.*.model.required'                       => self::REQUIRED_MESSAGE,
        'inputs.*.operating_condition_id'               => self::REQUIRED_MESSAGE,
        'inputs.*.premium_rental_plus_id'               => self::REQUIRED_MESSAGE,
        'inputs.*.prices.*.price'                       => self::REQUIRED_MESSAGE,
        'inputs.*.prices.*.type'                        => self::REQUIRED_MESSAGE,
        'inputs.*.prices.*.rental_period'               => self::REQUIRED_MESSAGE,
    ];

    protected function rules():array
    {
        return [
            // Offer head data
            'certificate.certificate_number'          => 'required',
            'certificate.issue_date'                  => 'required',
            'certificate.examination_date'            => 'required|max:191',

            // Employee
            'certificate.employee_salutation'                    => 'nullable|max:191',
            'certificate.employee_title'                         => 'nullable',
            'certificate.employee_first_name'                    => 'nullable',
            'certificate.employee_middle_name'                   => 'nullable',
            'certificate.employee_last_name'                     => 'nullable|numeric',
            'certificate.employee_birthday'                      => 'nullable',

            // Employer
            'certificate.employer_name'                   => 'required_with:offer.approver',
            'certificate.employer_street'               => 'nullable|max:191',
            'certificate.employer_house_number'         => 'nullable|max:191',
            'certificate.employer_city'                 => 'nullable|max:191',
            'certificate.employer_postcode'             => 'nullable',
            'certificate.employer_phone'                         => 'nullable',
            'certificate.employer_mobile'                        => 'nullable',

            'attachments.*'                     => 'max:12288',

            // Employee
            'inputs.*.brand'                    => 'required|max:191',
            'inputs.*.device_type'              => 'nullable',
            'inputs.*.model'                    => 'required|max:191',
            'inputs.*.serial_number'            => 'nullable|max:191',
            'inputs.*.lift_cap'                 => 'nullable',
            'inputs.*.device_weight'            => 'nullable',
            'inputs.*.mast'                     => 'nullable',
            'inputs.*.lift_high'                => 'nullable',
            'inputs.*.free_lift'                => 'nullable',
            'inputs.*.fork_length'              => 'nullable',
            'inputs.*.battery_capacity'         => 'nullable',
            'inputs.*.charger'                  => 'nullable',
            'inputs.*.other_equipment'          => 'nullable',
            'inputs.*.delivery_cost'            => ['nullable', new Currency],
            'inputs.*.return_delivery_cost'     => ['nullable', new Currency],
            'inputs.*.accessory'                => 'nullable',
            'inputs.*.accessory_price'          => 'nullable',
            'inputs.*.comment'                  => 'nullable',
            'inputs.*.operating_condition_id'   => 'required',
            'inputs.*.premium_rental_plus_id'   => 'required',
            'inputs.*.surcharge'                => 'nullable',
            'inputs.*.quantity'                 => 'required|integer',

            // prices
            'inputs.*.prices'                   => 'nullable',
            'inputs.*.prices.*.price'           => 'required',
            'inputs.*.prices.*.type'            => 'required',
            'inputs.*.prices.*.rental_period'   => 'required',
        ];
    }

    public function mount(): void
    {
        $this->loadItems();
    }

    private function loadItems(): void
    {
        $offerLines = collect($this->offer->lines->toArray());

        $offerLines = $offerLines->map(function($offerLine) {
            $offerLine['delivery_cost'] = formatNumber(($offerLine['delivery_cost'] ?? null), Null);
            $offerLine['return_delivery_cost'] = formatNumber(($offerLine['return_delivery_cost'] ?? null), Null);
            $offerLine['prices'] = $offerLine['prices'] ?: [];
            return $offerLine;
        });

        $this->fill(['inputs' => $offerLines]);
    }

    public function setCustomerData($customer): void
    {
        $this->offer->sender_id = $customer['customerid'] ?? null;
        $this->offer->customer_name = $customer['name'] ?? null;
        $this->offer->customer_name_2 = $customer['name2'] ?? null;
        $this->offer->customer_first_name = $customer['firstname'] ?? null;
        $this->offer->customer_last_name = $customer['lastname'] ?? null;
        $this->offer->customer_street = $customer['street'] ?? null;
        $this->offer->customer_postcode = $customer['postcode'] ?? null;
        $this->offer->customer_city = $customer['city'] ?? null;
        $this->offer->customer_phone = $customer['phone'] ?? null;
        $this->offer->customer_mobile = $customer['mobile'] ?? null;
        $this->offer->customer_mail = $customer['mail'] ?? null;
        $this->offer->customer_location = $customer['location'] ?? null;
    }

    public function setLifterData($lifter): void
    {
        $this->inputs = $this->inputs->map(function ($item, $key) use ($lifter) {
            if($key == $lifter['key'])
            {
                $data = $lifter['lifter'];

                $item['inno_id']            = $data['innoid'] ?? '';
                $item['serial_number']      = $data['serialnr'] ?? '';
                $item['model']              = $data['model'] ?? '';
                $item['device_type']        = $data['ingroup'] ?? '';
                $item['brand']              = $data['brand'] ?? '';
                $item['battery_capacity']   = $data['battcapaci'] ?? '';
                $item['charger']            = $data['charger'] ?? '';
                $item['lift_high']          = $data['lifthigh'] ?? '';
                $item['fork_length']        = $data['forklength'] ?? '';
                $item['mast']               = $data['mast'] ?? '';
                $item['lift_cap']           = $data['liftcap'] ?? '';
                $item['min_height']         = $data['minheight'] ?? '';
                $item['free_lift']          = $data['freelift'] ?? '';
                $item['device_weight']      = $data['weight'] ?? '';
            }

            return $item;
        });
    }

    public function addInput(): void
    {
        $this->inputs->push(['id' => 0, 'prices' => collect([[]])]);
        $this->dispatch('offerLineAdded', lastIndex: $this->inputs->keys()->last());
    }

    public function removeInput($key): void
    {
        $itemToDelete = $this->inputs->get($key);

        // removing item from datatable.
        if($itemToDelete['id']){
            OfferLine::find($itemToDelete['id'])->delete();
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
        $this->dispatch('offerLineCopied', lastIndex: $this->inputs->keys()->last());
    }

    public function addPreis($inputKey): void
    {
        $this->inputs = $this->inputs->map(function ($item, $key) use ($inputKey) {
            if($key == $inputKey)
            {
                $prices = collect($item['prices']);
                $prices->push([]);
                $item['prices'] = $prices;
            }

            return $item;
        });
    }

    public function removePrice($inputKey, $priceKey): void
    {
        $this->inputs = $this->inputs->map(function ($item, $key) use ($inputKey, $priceKey) {
            if($key == $inputKey)
            {
                $prices = collect($item['prices']);
                $prices->pull($priceKey);
                $item['prices'] = $prices;
            }

            return $item;
        });
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

        $data['customerWithErrors'] = $errorsCollection->contains(function ($value, $key) {
            return \Str::contains($value, 'offer.customer_');
        });

        return $data;
    }

    /**
     * customer validation for deep nested array.
     * default validation is not working for deep nested arrays.
     * can be removed in after livewire V3 Upgrade if working fine.
     *
     * @return void
     */
    private function validatePrices(): void
    {
        $this->withValidator(function (Validator $validator) {
            $validator->after(function ($validator)
            {
                foreach ($this->inputs as $key => $input)
                {
                    $prices = collect($input['prices']);
                    $prices->each(function ($item, $priceKey) use ($validator, $key) {

                        if(!$item){
                            return true;
                        }

                        if(!isset($item['price'])){
                            $validator->errors()->add(sprintf('inputs.%d.prices.%s.price', $key, $priceKey), 'Dieses Feld muss ausgefüllt werden.');
                        }

                        if(!isset($item['type'])){
                            $validator->errors()->add(sprintf('inputs.%d.prices.%s.type', $key, $priceKey), 'Dieses Feld muss ausgefüllt werden.');
                        }

                        if(!isset($item['rental_period'])){
                            $validator->errors()->add(sprintf('inputs.%d.prices.%s.rental_period', $key, $priceKey), 'Dieses Feld muss ausgefüllt werden.');
                        }

                        if(isset($item['price']) && (in_array(trim($item['price']), ['.', ',']) || !preg_match('/^[0-9.,\s]*$/', $item['price']))){
                            $validator->errors()->add(sprintf('inputs.%d.prices.%s.price', $key, $priceKey), 'ungültiges Zahlenformat!');
                        }
                    });
                }
            });
        })->validate();
    }

    public function updatedOfferApprovalDate($value): void
    {
        $value ?: $this->offer->approval_date = null;
        $this->validateOnly('offer.approval_date');
    }

    public function submit($print=false): void
    {
        $this->updateSuccess = false;

        // validation
        $this->validate();
        $this->validatePrices();

        // saving attached files.
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

        // saving the entities
        $this->saveOfferAndLines();

        // refreshing the data
        $this->offer->refresh();
        $this->loadItems();

        // resetting file attachment
        $this->attachments = [];

        // success message
        $this->updateSuccess = true;
        Session::flash('success', __('Speichern erfolgreich.'));

        // if save and print was clicked
        if($print){
            $this->redirect(route('toffer.offers.printOffer', $this->offer));
        }
    }

    public function saveOfferAndLines(): void
    {
        // validation
        $this->validate();

        // saving offer & lines
        $this->offer->save();
        if($this->inputs->count() > 0)
        {
            foreach ($this->inputs as $input)
            {
                $this->offer->lines()->updateOrCreate(['id'=> $input['id']], $input);
            }
        }

        // success message
        $this->dispatch('toast:alert', message: 'Speichern erfolgreich!', title: 'Success', status: 1);
    }

    public function downloadFile($attachment)
    {
        $attachedFile = Attachment::find($attachment);
        return $attachedFile->downloadFile();
    }

    public function render(): view
    {
        // Errors
        if(collect($this->getErrorBag())->count()>0){
            $this->dispatch('toast:alert', message: 'Please fix errors to save!', title: 'Error', status: 2);
        }

        // Dropdown options
        $data = Offer::getAttributeOptions();

        // getting sections with error to show validation symbol in card header
        $data = $this->getSectionsWithError($data);

        return view('livewire.t-offer.offer-edit-screen', $data);
    }
}
