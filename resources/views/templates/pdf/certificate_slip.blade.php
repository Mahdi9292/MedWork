<!DOCTYPE html>
<html>
<head>
    <link href="{{ asset('assets/css/pdf.css') }}" rel="stylesheet">
    <style>
        @page {
            size: auto;
            header: page-header;
            footer: page-footer;
        }

        @page :first {
            header: page-header;
            margin-header:10mm;
            margin-top: 55mm;
            font-family: frutiger;
        }
    </style>
</head>
<body>

@include('templates.pdf.header')
@include('templates.pdf.footer')

<div class="content">
    <div class="title-section mt-4 mb-4">
        <div class="font-size-15 fw-bold mb-1">Vorsorgebescheinigung</div>
        <div class="font-size-11">
            nach § 6 Absatz 3 Nr. 3 der Verordnung zur arbeitsmedizinischen Vorsorge
        </div>
    </div>

    <div class="mb-4 font-size-10">
        {{ $certificate->salutation == \App\Enums\Medical\SalutationType::ST_MR ? __('Proband') : __('Probandin') }}<br>
        <span class="fw-bold">{{$certificate->salutation?->label()}} {{$certificate->first_name}} {{$certificate->last_name}}</span><br>
        Geburtsdatum: {{ formatDate($certificate->birthday) }}<br>
        beschäftigt bei: {{$certificate->employed_at}}<br>
        Anschrift des Arbeitgebers: {{$certificate->employer_street}} {{$certificate->employer_house_number}}, {{$certificate->employer_postcode}} {{$certificate->employer_city}}<br><br>
        <span class="fw-bold">Schein Nr.: {{ $certificate->certificate_number }}</span>
    </div>

    <div class="mb-2 fw-bold font-size-10">Vorsorgen:</div>

    <table class="table-border w-100p font-size-9">
        <thead>
        <tr>
            <th class="w-5p p-1 text-center">Nr.</th>
            <th class="p-1 text-start ps-2">Anlass / Tätigkeit</th>
            <th class="p-1 text-center">Art der Vorsorge gemäß ArbMedVV</th>
            <th class="w-20p p-1 text-center">Nächster Termin</th>
        </tr>
        </thead>
        <tbody>
        @foreach($certificate->preventions as $index => $prevention)
            <tr>
                <td class="text-center p-1 align-middle">{{ $index+1 }}</td>
                <td class="ps-2 p-1 align-middle">{{ $prevention->activity?->code }} - {{ $prevention?->activity?->name }}</td>
                <td class="ps-2 p-1 align-middle">{{ $prevention->prevention_type?->label() }}</td>
                <td class="text-center p-1 align-middle">{{ formatDate($prevention->next_appointment_date) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="mt-8 font-size-10">
        <div class="fw-bold mb-1">Bemerkungen / Empfehlungen:</div>
        <div style="text-align: justify;">
            Bitte stellen Sie sich mit den zugesendeten Laborwerten bei Ihrem Hausarzt vor.
            Ihre Leberwerte sowie Ihr Bleispiegel im Körper sind nicht in Ordnung.
            Bitte senden Sie mir anschließend die fachärztlichen Befunde zu.
        </div>
    </div>

    <div class="mt-12 font-size-10">
        <strong>{{ __('Ort') }}: Brake, {{ __('Datum') }}: {{ formatDate($certificate->issue_date) }}</strong>
    </div>

    <div class="mt-20">
        <table class="w-100p border-0">
            <tr>
                <td class="w-30p"></td>

                <td class="w-70p text-center font-size-10 fw-bold" style="color: #2e5da7; white-space: nowrap;">
                    <div class="mb-2">
                        Unterschrift: Dr. med. Majid Taghvaei
                    </div>
                    <div>
                        Facharzt für Arbeitsmedizin
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>

</body>
</html>
