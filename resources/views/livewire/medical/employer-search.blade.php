<div>
    <div class="row">
        <div class="col-11">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Kunden suchen" aria-label="Kunden suchen" wire:model="searchTerm" wire:keydown.debounce.1000ms="doSearch" />
                <button class="input-group-control btn btn-outline-primary btn-border-gray m-0" type="button" wire:click="doSearch">{{ __('Suche') }}</button>
                <span class="input-group-text text-gray-600 @if($searchCount>0)tmh-bg-green @elseif($searchCount===0 && $searchTerm) tmh-bg-light-red @endif"><span class="badge bg-primary m-0">{{ $searchCount }}</span></span>
                <button class="input-group-control btn btn-outline-primary btn-border-gray m-0 dropdown-toggle p-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    {{ __('Ergebnisse') }}
                    <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>

                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <div class="table-dropdown">
                            <table class="table table-centered table-nowrap mb-0 rounded">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="border-0">{{ __('Arbeitgeber') }}</th>
                                        <th class="border-0">{{ __('Ansprechpartner') }}</th>
                                        <th class="border-0">{{ __('Adresse') }}</th>
                                        <th class="border-0">{{ __('Aktion') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if($employers)
                                    @foreach($employers as $employer)
                                        <tr class="border-bottom-gray">
                                            {{--    <td class="p-2 mw-150 border-0"><a href="#" class="text-primary fw-bold">{{ $contact->customer?->customer_number }}</a> </td>--}}
                                            <td class="p-2 fw-bold d-flex align-items-center wrap mw-500 border-0">
                                                {{ $employer->name }}
                                            </td>
                                            <td class="p-2 wrap mw-300 border-0">
                                                {{ $employer->contact_person }}
                                            </td>
                                            <td class="p-2 align-middle text-center mw-150 wrap border-0">
                                                {{ $employer->address }}
                                            </td>
                                            <td class="p-2 align-middle border-0">
                                                <button class="btn btn-sm btn-pill btn-outline-primary m-0" type="button" wire:click="employerSelected({{$employer->id ?? 0}})">{{ __('Übernehmen') }}</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="form-text font-small mb-3 ms-2">
                <i class="fas fa-question-circle"></i>
                {{ __('Suchformat: ID  Name  Strasse  PLZ  Stadt  $Ansprechpartner') }}
            </div>
        </div>
        <div class="col-1">
            @if($maximumRecordsInfo)
                <span class="badge bg-warning text-dark"> {{ __('Maximum of 100 Employers shown') }}</span>
            @endif
        </div>
    </div>
</div>
