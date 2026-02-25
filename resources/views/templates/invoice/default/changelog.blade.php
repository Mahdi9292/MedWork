@extends('templates.administration.base')

@section('content')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <x-template.breadcrumb :activePage="__('Changelog')" :links="[['key' => config('constants.APPLICATIONS.ORDERBOOK.TITLE'), 'url' => url('orderbook')]]" />
            <h2 class="h4">{{ __('Changelog') }}</h2>
            <p class="mb-0"></p>
        </div>
    </div>

    <div class="card border-0 shadow mb-5">
        <div class="card-body">
            <div class="row text-gray">

                <div class="col-12 col-lg-10 col-xl-10 scrollspy-changelog" data-bs-spy="scroll" data-bs-target="#toc-changelog" data-bs-offset="0" data-bs-smooth-scroll="true" tabindex="0">
                    <x-base.changelog id="id30" title="3.0 (15.01.2026)">
                        <ul>
                            <li>Ablage der Dateien</li>
                            <li>Umbenennung von Dateien</li>
                            <li>Neues Feld Kreditlimit</li>
                            <li>Warnfeld - Doppelte Aufträge</li>
                            <li>Informationsfluss "Service" an Serviceleiter</li>
                            <li>Informationsfluss „Auftrag Stornierung“ an Service Leiter</li>
                            <li>Neue Benachrichtigung-Pop-ups</li>
                            <li>Untermenü „SL-Aufträge“ im Bereich Aufträge</li>
                            <li>Live-Bearbeitung von Kommentaren und Status in der SL-Ansicht</li>
                            <li>Untermenü „Service Leiter“ im Bereich „System“</li>
                            <li>Untermenü „Service Leiter Ort“ im Bereich „System“</li>
                            <li>Vermeidung von Mehrfachklicks</li>
                            <li>Technische Optimierungen</li>
                        </ul>
                    </x-base.changelog>

                    <x-base.changelog id="id242" title="2.4.2 (11.09.2025)">
                        <ul>
                            <li>SASU UPDATES</li>
                            <ul>
                                <li>Spalten verschieben - Region</li>
                                <li>Status Übersetzung</li>
                                <li>Neue Auftrags-Übersicht - Region</li>
                            </ul>
                        </ul>
                    </x-base.changelog>

                    <x-base.changelog id="id241" title="2.4.1 (18.06.2025)">
                        <ul>
                            <li>SASU UPDATES</li>
                            <ul>
                            {{-- <li>Zugang für Händler (Neue Ansicht für Händler)</li>--}}
                                <li>Mehrere Aufträge in Einzel-E-Mails an den Kunden senden</li>
                                <li>Erweiterbare Boxen mit ∨ / ∧ kennzeichnen</li>
                                <li>Auftrag stornieren und Neu setzen</li>
                                <li>Auftragsverlauf (durch Stornieren und Neu setzen)</li>
                                <li>Fixierung der ersten Zeile in Listenansichten</li>
                            </ul>
                        </ul>
                    </x-base.changelog>

                    <x-base.changelog id="id23" title="2.3 (07.11.2024)">
                        <ul>
                            <li>SASU UPDATES</li>
                            <ul>
                                <li>Editable columns</li>
                                <li>Searchable Dropdown</li>
                                <li>New editable comment column in Region tab</li>
                                <li>Starter Option removed from I-Site field</li>
                                <li>Activate arrows for the date fields in the list view</li>
                                <li>Automatically link salespersons with responsible persons</li>
                                <li>Add M3 Order Status Low and High columns with filter option in list view</li>
                                <li>Set order creator name with creation date</li>
                            </ul>
                        </ul>
                    </x-base.changelog>

                    <x-base.changelog id="id22" title="2.2 (07.02.2022)">
                        <ul>
                            <li>Migrated to laravel</li>
                            <li>Load all the trucks from OTT</li>
                            <li>List the trucks under each corresponding Order</li>
                            <li>Highlight orders based on workshop date and delivery due date</li>
                            <li>Email and Copy options</li>
                            <li>Editable checkbox in data listing</li>
                        </ul>
                    </x-base.changelog>

                    <x-base.changelog id="id21" title="2.1 (19.03.2021)">
                        <ul>
                            <li>Orderbook Responsible person field</li>
                            <li>History feature for fields</li>
                            <li>Code refactoring</li>
                            <li>Merged M3 & OTT file import command</li>
                        </ul>
                    </x-base.changelog>

                    <x-base.changelog id="id20" title="2.0 (13.02.2020)">
                        <ul>
                            <li>New fields added to order entity</li>
                            <li>New Orisa field</li>
                            <li>New CF Aufträge</li>
                        </ul>
                    </x-base.changelog>

                    <x-base.changelog id="id13" title="1.3 (27.04.2017)">
                        <ul>
                            <li>copy function</li>
                            <li>dataTable service added</li>
                            <li>Add & edit Meta data</li>
                            <li>Added createdAt & updatedAt columns</li>
                        </ul>
                    </x-base.changelog>

                    <x-base.changelog id="id10" title="1.0 (26.08.2016)">
                        <ul>
                            <li>Initial release</li>
                        </ul>
                    </x-base.changelog>

                </div>
                <div class="col-12 col-lg-2 col-xl-2">
                    <div class="bd-toc mt-4 mb-5 my-md-0 ps-xl-3 mb-lg-5 text-muted">
                        <strong class="d-block h6 my-2 pb-2 border-bottom">On this page</strong>
                        <div id="toc-changelog" class="d-flex flex-column toc-changelog fw-lighter">
                            <a href="#id30">3.0 (15.01.2026)</a>
                            <a href="#id242">2.4.2 (11.09.2025)</a>
                            <a href="#id241">2.4.1 (18.06.2025)</a>
                            <a href="#id23">2.3 (07.11.2024)</a>
                            <a href="#id22">2.2 (07.02.2022)</a>
                            <a href="#id21">2.1 (19.03.2021)</a>
                            <a href="#id20">2.0 (13.02.2020)</a>
                            <a href="#id13">1.3 (27.04.2017)</a>
                            <a href="#id10">1.0 (26.08.2016)</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <button
        type="button"
        class="btn btn-tmhde btn-floating btn-lg"
        id="btn-back-to-top"
    >
        <i class="fas fa-arrow-up"></i>
    </button>

@endsection


