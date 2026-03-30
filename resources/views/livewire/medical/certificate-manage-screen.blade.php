<div>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <x-template.breadcrumb :activePage="$updateMode ? __('Bescheinigung ändern') : __('Bescheinigung erstellen')" :links="[
                    ['key' => config('constants.APPLICATIONS.MEDICAL.TITLE'), 'url' => url('medical')],
                    ['key' => __('Bescheinigungen'), 'url' => route('medical.certificates.index')]
                ]" />
            <h2 class="h4">{{ __('Bescheinigung') }}</h2>
        </div>

        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group ms-2 ms-lg-3">
                <a href="{{ route('medical.certificates.index') }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-times-circle"></i> {{ __('Schließen') }}</a>
                @if($updateMode)
                    <a href="{{ route('medical.printCertificate', $certificate->id) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-print"></i> {{ __('drucken') }}</a>
                @endif
                <a wire:click="submit" class="btn btn-sm btn-outline-primary"><i class="fas fa-save"></i> {{ $updateMode ? __('Speichern') : __('Erstellen') }}</a>
            </div>
        </div>

    </div>

    <x-template.notification :show-errors="true" />

    <form wire:submit="submit">

        <div class="row">
            <div class="col-12 mb-4">
                <div class="card border-light shadow-sm components-section">
                    <div class="card-header">
                        {{ __('Arbeitgeber') }}
                        @if($employerWithErrors)
                            <i class="fas fa-exclamation-circle text-danger ms-3"></i>
                        @endif
                    </div>
                    <div class="card-body collapse show pb-0 pt-0" id="collapseEmployer" wire:ignore.self>
                        <div class="row pt-4 pb-4">
                            <div class="col-sm-8">
                                <div>
                                    <livewire:medical.employer-search wire:key="employer-{{ uniqid($certificate->id) }}" :fields="collect([
                                            //'id'=> 'customer_id',
                                            'name' => 'employer_name',
                                            'contact_person' => 'employer_contact_person',
                                            'address' => 'employer_address',
                                            'street' => 'employer_street',
                                            'house_number' => 'employer_house_number',
                                            'city' => 'employer_city',
                                            'postcode' => 'employer_postcode',
                                            'phone' => 'employer_phone',
                                            'mobile' => 'employer_mobile',
                                            'email' => 'employer_email',
                                            ])">
                                    </livewire:medical.employer-search>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <x-form.input id="employer_name" name="certificate.employer_name"  wire:model="certificate.employer_name" :label="__('Arbeitgeber')" :labelClass="'col-sm-3'" />
                                    <x-form.input id="employer_contact_person" name="certificate.employer_contact_person"  wire:model="certificate.employer_contact_person" :label="__('Ansprechpartner')" :labelClass="'col-sm-3'" />
                                    <x-form.input id="employer_address" name="certificate.employer_address"  wire:model="certificate.employer_address" :label="__('Adresse (Arbeitgeber)')" :labelClass="'col-sm-3'" />
                                    <x-form.input id="employer_street" name="certificate.employer_street"  wire:model="certificate.employer_street" :label="__('Straße (Arbeitgeber)')" :labelClass="'col-sm-3'"  />
                                    <x-form.input id="employer_house_number" name="certificate.employer_house_number"  wire:model="certificate.employer_house_number" :label="__('Hausnummer (Arbeitgeber)')" :labelClass="'col-sm-3'"  />

                                </div>
                                <div class="col-sm-6">
                                    <x-form.input id="employer_city" name="certificate.employer_city"  wire:model="certificate.employer_city" :label="__('Ort (Arbeitgeber)')" :labelClass="'col-sm-3'" />
                                    <x-form.input id="employer_postcode" name="certificate.employer_postcode"  wire:model="certificate.employer_postcode" :label="__('PLZ (Arbeitgeber)')" :labelClass="'col-sm-3'" />
                                    <x-form.input id="employer_phone" name="certificate.employer_phone"  wire:model="certificate.employer_phone" :label="__('Telefonnummer (Arbeitgeber)')" :labelClass="'col-sm-3'" />
                                    <x-form.input id="employer_mobile" name="certificate.employer_mobile"  wire:model="certificate.employer_mobile" :label="__('Mobilnummer (Arbeitgeber)')" :labelClass="'col-sm-3'" />
                                    <x-form.input id="employer_email" name="certificate.employer_email"  wire:model="certificate.employer_email" :label="__('E-Mail (Arbeitgeber)')" :labelClass="'col-sm-3'" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 mb-4">
                <div class="card border-light shadow-sm components-section">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-2">
                                {{ __('Arbeitnehmer') }} {{$updateMode ? '-' . __('Arbeitnehmer') . ':' .  $certificate->employee_lastname : ''}}
                            </div>
                        </div>
                    </div>
                    <div class="card-body collapse show pb-0 pt-0" id="collapseEmployee">
                        <div class="row pt-4 pb-4">
                            <div class="col-sm-8">
                                <x-form.select name="certificate.employee_salutation" wire:model.live="certificate.employee_salutation" :label="__('Anrede')" :options="$salutationTypeOptions" :labelClass="'col-sm-3'"  />
                                <x-form.input name="certificate.employee_title" wire:model="certificate.employee_title" :label="__('Titel')" :labelClass="'col-sm-3'" />
                                <x-form.input name="certificate.employee_first_name" wire:model="certificate.employee_first_name" :label="__('Vorname')" :labelClass="'col-sm-3'" />
                                <x-form.input name="certificate.employee_middle_name" wire:model="certificate.employee_middle_name" :label="__('Zweiter Vorname')" :labelClass="'col-sm-3'" />
                                <x-form.input name="certificate.employee_last_name" wire:model="certificate.employee_last_name" :label="__('Nachname')" :labelClass="'col-sm-3'" />
                                <x-form.flat-pickr name="certificate.employee_birthday" wire:model="certificate.employee_birthday" :label="__('Geburtsdatum')" :labelClass="'col-sm-3'" :week-numbers="true" :allow-input="true" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 mb-4">
                <div class="card border-light shadow-sm components-section">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-2">
                                {{ __('Bescheinigungsdaten') }} {{$updateMode ? '-' . __('Bescheinigung Nr.') . ':' .  $certificate->certificate_number : ''}}
                            </div>
                        </div>
                    </div>
                    <div class="card-body collapse show pb-0 pt-0" id="collapseCertificate">
                        <div class="row pt-4 pb-4">
                            <div class="col-sm-8">
                                @if($updateMode)
                                    <x-form.input name="certificate.certificate_number" wire:model="certificate.certificate_number" :label="__('Bescheinigung Nr.')" :labelClass="'col-sm-3'" disabled />
                                @endif

                                <x-form.input name="certificate.employer_comment" wire:model="certificate.employer_comment" :label="__('Arbeitgeber Kommentar')" :labelClass="'col-sm-3'" />
                                <x-form.select name="certificate.employer_comment_id" wire:model.live="certificate.employer_comment_id" :label="__('Arbeitgeber Kommentar Auswählen')" :options="$employerCommentOptions" :nullRowText="__('Keine Angaben')" :labelClass="'col-sm-3'"  />

                                <x-form.input name="certificate.employee_comment" wire:model="certificate.employee_comment" :label="__('Arbeitnehmer Kommentar')" :labelClass="'col-sm-3'" />
                                <x-form.select name="certificate.employee_comment_id" wire:model.live="certificate.employee_comment_id" :label="__('Arbeitnehmer Kommentar Auswählen')" :options="$employeeCommentOptions" :nullRowText="__('Keine Angaben')" :labelClass="'col-sm-3'"  />

                                <x-form.flat-pickr name="certificate.issue_date" wire:model="certificate.issue_date" :label="__('Erstellungsdatum')" :labelClass="'col-sm-3'" :week-numbers="true" :allow-input="true" />
                                <x-form.flat-pickr name="certificate.examination_date" wire:model="certificate.examination_date" :label="__('Untersuchungsdatum')" :labelClass="'col-sm-3'" :week-numbers="true" :allow-input="true" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="preventions" class="card">
            <div class="card-header header-light">
                <h5 class="float-start">{{ __('Vorsorgen') }}</h5>

                <button type="button" class="btn btn-sm btn-primary float-end sim-add-btn" wire:click.prevent="addInput" title="{{ __('hinzufügen') }}">
                    <i class="fas fa-plus-circle"></i>
                </button>

                <div wire:loading wire:target="addInput" class="float-end me-1 mt-1">
                    <img  src="{{ asset('assets/img/ajax-loader1.gif') }}" />
                </div>
            </div>

            <div class="card-body">

                <x-template.notification />

                    @foreach($inputs as $inputId => $input)
                        <div class="card mb-1">
                            <h5 class="d-flex card-header">
                                <div class="title-body">
                                    {{ $inputId +1 . '.' }} {{ __('Vorsorge') }}
                                    @if($inputsWithErrors->contains($inputId))
                                        <i class="fas fa-exclamation-circle text-danger ms-3"></i>
                                    @endif
                                </div>
                                @if($inputs[$inputId]['id'])
                                    <div class="d-flex ms-auto">

                                    </div>
                                @endif

                                <div class="col-12 col-lg-7 col-md-7">
                                    <div class="float-end">
                                        {{--<button class="btn btn-offwhite"><i class="fas fa-save"></i> {{ __('Speichern') }}</button>--}}
                                        <button wire:click.prevent="$dispatch('swal:confirm', {{ collect(['method' => 'removeInput', 'params' => [$inputId] ]) }})" class="btn btn-offwhite"><i class="fas fa-trash-alt"></i> {{ __('löschen') }}</button>
                                        <button wire:click.prevent="copyInput({{$inputId}})" class="btn btn-offwhite"><i class="fas fa-copy"></i> {{ __('kopieren') }}</button>
                                    </div>
                                    <div wire:loading wire:target="copyInput, removeInput" class="me-1 mt-1 float-end">
                                        <img  src="{{ asset('assets/img/ajax-loader1.gif') }}" />
                                    </div>
                                </div>
                            </h5>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 col-lg-12">
                                            <div class="card border-0 shadow">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-sm-10">
                                                            <x-form.select name="inputs.{{$inputId}}.activity_id" wire:model.live="inputs.{{$inputId}}.activity_id" :label="__('Tätigkeit/ Anlass')" :options="$activityOptions" :nullRowText="__('Keine Angaben')" :labelClass="'col-sm-3'"  />
                                                            <x-form.select name="inputs.{{$inputId}}.prevention_type" wire:model.live="inputs.{{$inputId}}.prevention_type" :label="__('Art der Vorsorge')" :options="$preventionTypeOptions" :nullRowText="__('Keine Angaben')" :labelClass="'col-sm-3'"  />
                                                            <x-form.flat-pickr name="inputs.{{$inputId}}.next_appointment_date" wire:model="inputs.{{$inputId}}.next_appointment_date" :label="__('Nächster Termin')" :labelClass="'col-sm-3'" :week-numbers="true" :allow-input="true" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    @endforeach

            </div>

            <div class="card-footer border-success p-2 footer-light">
                <button type="button" class="btn btn-primary sim-add-btn" wire:click.prevent="addInput"><i class="fas fa-plus"></i> {{ __('hinzufügen') }}</button>
                <div wire:loading wire:target="addInput" class="ms-1 mt-1">
                    <img  src="{{ asset('assets/img/ajax-loader1.gif') }}" />
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12 mb-4">
                <div class="card border-light shadow-sm components-section">
                    <div class="card-footer border-success p-2 footer-light">
                        <a class="btn btn-secondary float-end" wire:click="submit(true)">
                            <i class="fas fa-print"></i>
                            {{ __('speichern und drucken') }}
                        </a>
                        <button class="btn btn-secondary float-end me-2">
                            <i class="fas fa-save"></i>
                            {{ __('speichern') }}
                        </button>

                        <div wire:loading wire:target="submit" class="me-2 mt-1 float-end">
                            <img src="{{ asset('assets/img/ajax-loader1.gif') }}" />
                        </div>

                        @if(collect($this->getErrorBag())->count()>0)
                            <div class="me-2 mt-1 float-end">
                                <img  src="{{ asset('assets/img/error-loader.gif') }}" />
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
