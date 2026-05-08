<!DOCTYPE html>
<html>
<head>
    <link href="{{ asset('assets/css/pdf.css') }}" rel="stylesheet">
    <style>
        @page {
            size: auto;
            margin-left: 1.5cm;
            margin-header:5mm;
            margin-top: 45mm;
            font-family: frutiger;
            header: page-header;
            footer: page-footer;
        }

        @page :first {
            header: page-header;
            margin-header:5mm;
            margin-top: 45mm;
            margin-bottom: 20mm;
            margin-left: 1.5cm;
            font-family: frutiger;
        }
        table {
            page-break-inside: auto;
        }
        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }
        thead {
            display: table-header-group; /* Repeats header on every page */
        }
        .table-border {
            width: 100%;
            table-layout: fixed; /* Ensures the table stays within 100% width */
            border-collapse: collapse;
        }
    </style>
</head>
<body>

@include('templates.pdf.header')
@include('templates.pdf.footer')

<div class="content mt-1">
    <table style="width: 100%; border: 0; margin-bottom: 0;">
        <tr>
            <td style="width: 55%; vertical-align: top;">
                <table>
                    <tr>
                        <td>
                            <strong>
                                @if(!$isEmployer) {{ __('Persönlich/Vertraulich') }} - <em>{{__('Arbeitnehmer/in') }}</em>
                                @else {{ __('Bescheinigung für den Arbeitgeber') }}
                                @endif
                            </strong>
                        </td><br><br>
                    </tr>
                    <tr>
                        <td>
                            @if($isEmployer)
                                <span class="fw-bold">{{ __('Beschäftigte Person') }}:</span>
                            @endif
                            <span> {{$certificate->employee_salutation?->label()}} {{$certificate->employee_first_name}} {{$certificate->employee_last_name}}</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="font-size-8">
                            <span class="fw-bold">{{__('beschäftigt bei')}}:</span>
                            <span> {{$certificate->employer_name}}</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="font-size-8">
                            <span class="fw-bold">{{__('Anschrift des Arbeitgebers')}}:</span>
                            <span> {{$certificate->employer_address}}</span>
                        </td>
                    </tr>
                </table>
            </td>
            <td style="width: 45%; vertical-align: top;">
                <table style="text-align: right; width: 100%; border: 0;" class="font-size-9">
                    <tr>
                        <td><strong>{{__('Bescheinigung Nr.')}}: {{ $certificate->certificate_number }}</strong></td>
                    </tr>
                    <tr>
                        <td>{{ __('Datum') }}: {{ formatDate($certificate->issue_date) }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('Ort') }}: {{ $certificate->issue_location ?: __('Brake') }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <div class="title-section mt-10">
        <div class="mb-1">
            <span class="font-size-12 fw-bold">
                {{__('Vorsorgebescheinigung')}}
            </span>
            <em>{{ $isEmployer ? '(Arbeitgeber/in)' : '(Arbeitnehmer/in)' }}</em>
        </div>
        <div class="font-size-8">
            <em>{{__('nach § 6 Absatz 3 Nr. 3 der Verordnung zur arbeitsmedizinischen Vorsorge')}}</em>
        </div>
    </div>

    <div class="mt-4 mb-4">
        <table class="font-size-9" style="width: 100%; border: 0;">
            <tr>
                <td style="width: 150px;" class="fw-bold">{{ $certificate->employee_salutation ? ($certificate->employee_salutation == \App\Enums\Medical\SalutationType::ST_MR ? __('Proband') : __('Probandin')) : __('Proband/in') }}:</td>
                <td>{{$certificate->employee_salutation?->label()}} {{$certificate->employee_first_name}} {{$certificate->employee_last_name}}</td>
            </tr>
            <tr>
                <td class="fw-bold">{{__('Geburtsdatum')}}:</td>
                <td>{{ formatDate($certificate->employee_birthday) }}</td>
            </tr>
            <tr>
                <td class="fw-bold">{{__('Untersuchungsdatum')}}:</td>
                <td>{{ formatDate($certificate->examination_date) }}</td>
            </tr>
        </table>
    </div>

    <div class="mb-1 fw-bold font-size-10">{{__('Vorsorgen')}}:</div>

    <table class="table-border w-100p font-size-9">
        <thead>
        <tr>
            <th class="p-1 text-center" style="width: 20px;">{{__('Nr.')}}</th>
            <th class="p-1 text-start ps-2">{{__('Anlass/ Tätigkeit')}}</th>
            <th class="p-1 text-center">{{__('Art der Vorsorge')}} <em><small>{{__('gemäß ArbMedVV')}}</small></em></th>
            <th class="w-20p p-1 text-center">{{__('Nächster Termin')}}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($certificate->preventions as $index => $prevention)
            <tr>
                <td class="text-center p-1 align-middle">{{ $index+1 }}</td>
                <td class="ps-2 p-1 align-middle">{{$prevention->activity?->former_name ? $prevention->activity?->former_name . '-' : ''}} {{ $prevention?->activity?->name }}</td>
                <td class="ps-2 p-1 align-middle">{{ $prevention->preventionType?->name }}</td>
                <td class="text-center p-1 align-middle">{{ formatDate($prevention->next_appointment_date) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="mt-2" style="page-break-inside: avoid;">
        <div class="fw-bold mb-1">{{__('Bemerkungen/ Empfehlungen')}}:</div>
        <div class="font-size-8" style="text-align: justify;">
            <ul>

            <li>{{ $isEmployer ? $certificate->employer_comment : $certificate->employee_comment }}</li>
            @if(count($comments) >0)
                @foreach($comments as $comment)
                   <li>{{ $comment }}</li>
                @endforeach
            @endif
            </ul>
        </div>

        <div class="mt-10 font-size-9" style="width: 100%; clear: both; page-break-inside: avoid;">
            <div style="width: 50%; margin-left: auto; margin-right: 0; text-align: center; color: #2e5da7; font-weight: bold; line-height: 1.2;">

                <div style="position: relative; z-index: 1; margin-bottom: -80px">
                    <div>{{__('Unterschrift: Dr. med. Majid Taghvaei')}}</div>
                    <div>{{__('Facharzt für Arbeitsmedizin')}}</div>
                </div>

                @if($certificate->signed)
                    <div style="position: relative; z-index: 2; ">
                        <img src="{{ asset('assets/img/brand/stamp_and_signature.png') }}" style="width: 160px; transform: rotate(-2deg); opacity: 0.9; mix-blend-mode: multiply; pointer-events: none;">
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

</body>
</html>
