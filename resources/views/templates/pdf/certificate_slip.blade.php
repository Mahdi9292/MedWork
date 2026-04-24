<!DOCTYPE html>
<html>
<head>
    <link href="{{ asset('assets/css/pdf.css') }}" rel="stylesheet">
    <style>
        @page {
            size: auto;
            margin-left: 1.5cm;
            header: page-header;
            footer: page-footer;
        }

        @page :first {
            header: page-header;
            margin-header:5mm;
            margin-top: 45mm;
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

<div class="content">
    <div class="title-section mt-4">
        <div class="mb-1">
            <span class="font-size-13 fw-bold">
                {{__('Vorsorgebescheinigung')}}
            </span>

                <em>{{ $isEmployer ? '(Arbeitgeber/in)' : '(Arbeitnehmer/in)' }}</em>

        </div>
        <div class="font-size-8">
           <em>{{__('nach § 6 Absatz 3 Nr. 3 der Verordnung zur arbeitsmedizinischen Vorsorge')}}</em>
        </div>
        <div class="font-size-9 text-end mt-2">
            {{__('Bescheinigung Nr.')}}: {{ $certificate->certificate_number }} <br>
            {{ __('Datum') }}: {{ formatDate($certificate->issue_date) }}<br>
            {{ __('Ort') }}: {{ $certificate->issue_location ?: __('Brake') }}
        </div>
    </div>

    <div class="mb-4 font-size-9">
        {{ $certificate->employee_salutation ? ($certificate->employee_salutation == \App\Enums\Medical\SalutationType::ST_MR ? __('Proband') : __('Probandin')) : __('Proband/in') }}<br>
        <span class="fw-bold">{{$certificate->employee_salutation?->label()}} {{$certificate->employee_first_name}} {{$certificate->employee_last_name}}</span><br>
        {{__('Geburtsdatum')}}: {{ formatDate($certificate->employee_birthday) }}<br>
        {{__('beschäftigt bei')}}: {{$certificate->employer_name}}<br>
        {{__('Anschrift des Arbeitgebers')}}: {{ $certificate->employer_address ?: $certificate->employer_street . ' ' . $certificate->employer_house_number . ', ' . $certificate->employer_postcode . ' ' . $certificate->employer_city}}<br><br>
        <span class="fw-bold">{{__('Untersuchungsdatum')}}: {{ formatDate($certificate->examination_date) }}</span>
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
    </div>

    <div class="mt-15 font-size-9" style="width: 100%; clear: both; page-break-inside: avoid;">
        <div style="width: 50%; margin-left: auto; margin-right: 0; text-align: center; color: #2e5da7; font-weight: bold; line-height: 1.2;">

            <div style="position: relative; z-index: 1;">
                <div>{{__('Unterschrift: Dr. med. Majid Taghvaei')}}</div>
                <div>{{__('Facharzt für Arbeitsmedizin')}}</div>
            </div>

            @if($certificate->signed)
                <div style="position: relative; z-index: 2; margin-top: -80px;">
                    <img src="{{ asset('assets/img/brand/stamp_and_signature.jpg') }}" style="width: 160px; transform: rotate(-2deg); opacity: 0.9; mix-blend-mode: multiply; pointer-events: none;">
                </div>
            @endif
        </div>
    </div>
</div>

</body>
</html>
