<div>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <x-template.breadcrumb :activePage="$updateMode ? __('Rechnung ändern') : __('Rechnung erstellen')" :links="[
                    ['key' => config('constants.APPLICATIONS.FINANCE.TITLE'), 'url' => url('finance')],
                    ['key' => __('Rechnungen'), 'url' => route('finance.invoices.index')]
                ]" />
            <h2 class="h4">{{ __('Rechnung') }} <span><em><small class="text-muted"> {{$updateMode ? '(' . $invoice->invoice_number . ')' : ''}}</small></em></span> </h2>
        </div>

        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group ms-2 ms-lg-3">
                <a href="{{ route('finance.invoices.index') }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-times-circle"></i> {{ __('Schließen') }}</a>
                @if($updateMode)
                    <a href="{{ route('finance.printInvoice', $invoice->id) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-print"></i> {{ __('drucken') }}</a>
                @endif
                <a wire:click="submit" class="btn btn-sm btn-outline-primary"><i class="fas fa-save"></i> {{ $updateMode ? __('Speichern') : __('Erstellen') }}</a>
            </div>
        </div>

    </div>

    <x-template.notification :show-errors="true" />



    {{-- BELOW STILL REMAINING --}}

    <form wire:submit="submit">

        <div class="row">
            <div class="col-12 mb-4">
                <div class="card border-light shadow-sm components-section">
                    <div class="card-header">
                        <i class="fas fa-building me-2 text-primary"></i>
                        {{ __('Rechnung Empfänger') }} <span><em><small class="text-muted"> {{$updateMode ? '(' . $invoice->receiver_name . ')' : ''}}</small></em></span>
                        @if($receiverWithErrors)
                            <i class="fas fa-exclamation-circle text-danger ms-3"></i>
                        @endif
                    </div>
                    <div class="card-body collapse show pb-0 pt-0" id="collapseReceiver" wire:ignore.self>
                        <div class="row pt-4 pb-4">
                            <div class="col-sm-8">
                                <div>
                                    <livewire:medical.employer-search wire:key="employer-{{ uniqid($invoice->id) }}" :fields="collect([
                                            //'id'=> 'customer_id',
                                            'name' => 'receiver_name',
                                            'contact_person' => 'receiver_contact_person',
                                            'street' => 'receiver_street',
                                            'house_number' => 'receiver_house_number',
                                            'city' => 'receiver_city',
                                            'postcode' => 'receiver_postcode',
                                            'phone' => 'receiver_phone',
                                            'email' => 'receiver_email',
                                            ])">
                                    </livewire:medical.employer-search>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <x-form.input id="receiver_name" name="invoiceManageForm.receiver_name"  wire:model="invoiceManageForm.receiver_name" :label="__('Empfänger Name')" :labelClass="'col-sm-3'" :disable-autofill="true" />
                                    <x-form.input id="receiver_contact_person" name="invoiceManageForm.receiver_contact_person"  wire:model="invoiceManageForm.receiver_contact_person" :label="__('Empfänger zusatz')" :labelClass="'col-sm-3'" :disable-autofill="true" />
                                    <x-form.input id="receiver_street" name="invoiceManageForm.receiver_street"  wire:model="invoiceManageForm.receiver_street" :label="__('Straße')" :labelClass="'col-sm-3'" :disable-autofill="true" />
                                    <x-form.input id="receiver_house_number" name="invoiceManageForm.receiver_house_number"  wire:model="invoiceManageForm.receiver_house_number" :label="__('Haus Nr.')" :labelClass="'col-sm-3'" :disable-autofill="true" />
                                </div>
                                <div class="col-sm-6">
                                    <x-form.input id="receiver_city" name="invoiceManageForm.receiver_city"  wire:model="invoiceManageForm.receiver_city" :label="__('Stadt')" :labelClass="'col-sm-3'" :disable-autofill="true" />
                                    <x-form.input id="receiver_postcode" name="invoiceManageForm.receiver_postcode"  wire:model="invoiceManageForm.receiver_postcode" :label="__('PLZ')" :labelClass="'col-sm-3'" :disable-autofill="true" />
                                    <x-form.input id="receiver_phone" name="invoiceManageForm.receiver_phone"  wire:model="invoiceManageForm.receiver_phone" :label="__('Tel.')" :labelClass="'col-sm-3'" :disable-autofill="true" />
                                    <x-form.input id="receiver_email" name="invoiceManageForm.receiver_email"  wire:model="invoiceManageForm.receiver_email" :label="__('E-Mail')" :labelClass="'col-sm-3'" :disable-autofill="true" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="card-title mb-0">
                            {{ __('Rechnungsdaten') }}
                            @if($updateMode)
                                <small class="text-muted ms-2 fw-light fs-6">({{ __('Nr.: ') . $invoice->invoice_number }})</small>
                            @endif
                        </h5>
                    </div>

                    <div class="card-body p-4">
                        <div class="row g-4">
                            <div class="col-sm-8">
                                @if($updateMode)
                                    <x-form.input name="invoiceManageForm.certificate_number" wire:model="invoiceManageForm.certificate_number" :label="__('Rechnung Nr.')" :labelClass="'col-sm-4'" disabled />
                                @endif

                                <x-form.input name="invoiceManageForm.value_added_tax" wire:model="invoiceManageForm.value_added_tax" :label="__('MwSt in %')" :trailingAddon="'%'" :labelClass="'col-sm-4'" />
                                <x-form.flat-pickr name="invoiceManageForm.invoice_date" wire:model="invoiceManageForm.invoice_date" :label="__('Rechnungsdatum')" :labelClass="'col-sm-4'" :week-numbers="true" :allow-input="true" />
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div id="preventions" class="card border-0 shadow-sm mb-4" x-data="{ openMain: true }">
            <div class="card-header bg-white border-bottom py-2 px-3 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center flex-grow-1 py-1" @click="openMain = !openMain" style="cursor: pointer;">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chevron-right me-2 text-muted" :class="openMain ? 'fa-rotate-90' : ''" style="font-size: 0.9rem; transition: transform 0.2s;"></i>
                        <i class="fa-solid fa-file-pen me-2 text-primary"></i>
                        {{ __('Vorsorgen') }}
                    </h5>
                </div>

                <div class="d-flex align-items-center">
                    <div wire:loading wire:target="addInput" class="me-2 mt-1">
                        <img src="{{ asset('assets/img/ajax-loader1.gif') }}" />
                    </div>
                    <button type="button" class="btn btn-sm btn-primary sim-add-btn" @click="openMain = true" wire:click.prevent.stop="addInput" title="{{ __('hinzufügen') }}">
                        <i class="fas fa-plus-circle"></i>
                    </button>
                </div>
            </div>

            <div id="collapsePreventionsMain" x-show="openMain">
                <div class="card-body p-4 bg-light bg-opacity-50">

                    <x-template.notification />

                    @foreach($inputs as $inputId => $input)
                        <div class="card mb-3 shadow-sm border-light" wire:key="prevention-item-{{ $inputId }}" x-data="{ openItem: true }">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center py-2 px-3">
                                <div class="d-flex align-items-center flex-grow-1" @click="openItem = !openItem" style="cursor: pointer;">
                                    <h6 class="mb-0 fw-semibold text-dark">
                                        <i class="fas fa-chevron-right me-2 text-muted" :class="openItem ? 'fa-rotate-90' : ''" style="font-size: 0.8rem; transition: transform 0.2s;"></i>
                                        {{ $inputId + 1 . '.' }} {{ __('Vorsorge') }}
                                        @if($inputsWithErrors->contains($inputId))
                                            <i class="fas fa-exclamation-circle text-danger ms-3"></i>
                                        @endif
                                    </h6>
                                </div>

                                <div class="d-flex align-items-center">
                                    <button wire:click.prevent.stop="$dispatch('swal:confirm', {{ collect(['method' => 'removeInput', 'params' => [$inputId] ]) }})" class="btn btn-sm btn-light border text-muted py-1 px-2 me-2"><i class="fas fa-trash-alt"></i> {{ __('löschen') }}</button>
                                    <button wire:click.prevent.stop="copyInput({{$inputId}})" class="btn btn-sm btn-light border text-muted py-1 px-2"><i class="fas fa-copy"></i> {{ __('kopieren') }}</button>
                                    <div wire:loading wire:target="copyInput, removeInput" class="ms-2">
                                        <img src="{{ asset('assets/img/ajax-loader1.gif') }}" />
                                    </div>
                                </div>
                            </div>

                            <div id="collapsePrevention{{ $inputId }}" x-show="openItem">
                                <div class="card-body p-4">
                                    <div class="row">
                                        <div class="col-sm-10">
                                            <x-form.select name="inputs.{{$inputId}}.activity_id" wire:model.live="inputs.{{$inputId}}.activity_id" :label="__('Tätigkeit/ Anlass')" :options="$activityOptions" :nullRowText="__('Keine Angaben')" :labelClass="'col-sm-3'"  />
                                            <x-form.select name="inputs.{{$inputId}}.prevention_type_id" wire:model.live="inputs.{{$inputId}}.prevention_type_id" :label="__('Art der Vorsorge')" :options="$preventionTypeOptions" :nullRowText="__('Keine Angaben')" :labelClass="'col-sm-3'"  />
                                            <x-form.flat-pickr name="inputs.{{$inputId}}.next_appointment_date" wire:model="inputs.{{$inputId}}.next_appointment_date" :label="__('Nächster Termin')" :labelClass="'col-sm-3'" :week-numbers="true" :allow-input="true" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>

                <div class="card-footer border-top p-3 bg-white">
                    <button type="button" class="btn btn-primary sim-add-btn" @click="openMain = true" wire:click.prevent.stop="addInput"><i class="fas fa-plus"></i> {{ __('hinzufügen') }}</button>
                    <div wire:loading wire:target="addInput" class="ms-2 mt-1">
                        <img src="{{ asset('assets/img/ajax-loader1.gif') }}" />
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12 mb-4">
                <div class="card border-light shadow-sm components-section">
                    <div class="card-footer border-success p-2 footer-light">

                        @if($updateMode)
                            <a class="btn btn-secondary float-end" wire:click="submit(true)">
                                <i class="fas fa-print"></i>
                                {{ __('Speichern und drucken') }}
                            </a>
                        @endif

                        <button class="btn btn-secondary float-end me-2">
                            <i class="fas fa-save"></i>
                            {{ $updateMode ? __('Speichern'):__('Erstellen') }}
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
