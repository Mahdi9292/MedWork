<?php

namespace App\Livewire\Medical;

use App\Models\Medical\Certificate;
use App\Models\Medical\Prevention;
use Illuminate\Support\Collection;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CertificateManageForm extends Form
{
    public ?Certificate $certificate;

    // Certificate Properties
    #[Validate('nullable')]
    public $certificate_number;

    #[Validate('nullable|date')]
    public $issue_date;
    #[Validate('nullable|date')]
    public $examination_date;
    #[Validate('nullable')]
    public $employer_comment_id;
    #[Validate('nullable')]
    public $employee_comment_id;
    #[Validate('nullable')]
    public $employer_comment;
    #[Validate('nullable')]
    public $employee_comment;

    // Employee Properties
    #[Validate('nullable')]
    public $employee_salutation;
    #[Validate('nullable')]
    public $employee_title;
    #[Validate('nullable')]
    public $employee_first_name;
    #[Validate('nullable')]
    public $employee_last_name;
    #[Validate('nullable|date')]
    public $employee_birthday;

    // Employer Properties
    #[Validate('required')]
    public $employer_name;
    #[Validate('nullable')]
    public $employer_contact_person;
    #[Validate('nullable')]
    public $employer_address;
    #[Validate('nullable|max:191')]
    public $employer_street;
    #[Validate('nullable|max:191')]
    public $employer_house_number;
    #[Validate('nullable|max:191')]
    public $employer_city;
    #[Validate('nullable')]
    public $employer_postcode;
    #[Validate('nullable')]
    public $employer_phone;
    #[Validate('nullable')]
    public $employer_mobile;
    #[Validate('nullable|email')]
    public $employer_email;

    // Nested Preventions
    #[Validate(['inputs.*.activity_id' => 'nullable', 'inputs.*.prevention_type' => 'nullable', 'inputs.*.next_appointment_date' => 'required'])]
    public ?Collection $inputs;

    public function setCertificate(Certificate $certificate): void
    {
        $inputs = collect($certificate->preventions?->toArray());
        $this->certificate = $certificate;
        $this->inputs = $inputs ?: collect();

        // Certificate
        $this->certificate_number = $certificate->certificate_number;
        $this->issue_date = $certificate->issue_date;
        $this->examination_date = $certificate->examination_date;
        $this->employer_comment_id = $certificate->employer_comment_id;
        $this->employee_comment_id = $certificate->employee_comment_id;
        $this->employer_comment = $certificate->employer_comment;
        $this->employee_comment = $certificate->employee_comment;

        // Employee
        $this->employee_salutation = $certificate->employee_salutation;
        $this->employee_title = $certificate->employee_title;
        $this->employee_first_name = $certificate->employee_first_name;
        $this->employee_last_name = $certificate->employee_last_name;
        $this->employee_birthday = $certificate->employee_birthday;

        // Employer
        $this->employer_name = $certificate->employer_name;
        $this->employer_contact_person = $certificate->employer_contact_person;
        $this->employer_address = $certificate->employer_address;
        $this->employer_street = $certificate->employer_street;
        $this->employer_house_number = $certificate->employer_house_number;
        $this->employer_city = $certificate->employer_city;
        $this->employer_postcode = $certificate->employer_postcode;
        $this->employer_phone = $certificate->employer_phone;
        $this->employer_mobile = $certificate->employer_mobile;
        $this->employer_email = $certificate->employer_email;

    }

    public function store(): void
    {
        // validation
        $this->validate();

        // saving certificate & preventions
        $this->certificate = $this->certificate->create(
            $this->except(['certificate', 'inputs'])
        );

        if($this->inputs->count() > 0)
        {
            foreach ($this->inputs as $input)
            {
                $this->certificate->preventions()->updateOrCreate(['id'=> $input['id']], $input);
            }
        }
    }

    public function update(): void
    {
        // validation
        $data = $this->validate();

        $this->certificate->fill($data);
        $this->certificate->save();

        if($this->inputs->count() > 0)
        {
            foreach ($this->inputs as $input)
            {
                $this->certificate->preventions()->updateOrCreate(['id'=> $input['id']], $input);
            }
        }
    }
}
