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
            margin-header:5mm;
            margin-top: 55mm;
            font-family: frutiger;
        }
    </style>
</head>
<body>

@include('templates.pdf.header')
@include('templates.pdf.footer')

<div class="mt-4">
    <div class="mb-4">
        Rechnung an: {{ $invoice->name }}<br>
        {{$invoice->street}} {{$invoice->house_number}}<br>
        {{$invoice->postcode}} {{$invoice->city}}<br><br>
        <strong>Rechnung Nr.: {{ $invoice->invoice_number }}</strong>
    </div>

    <div class="mb-2">Leistungen:</div>

    <table class="table-border w-100p font-size-9">
        <thead>
            <tr>
                <th class="w-15p p-1 text-center">Pos.</th>
                <th class="p-1 text-center">Leistung</th>
                <th class="w-20p p-1 text-center">Datum</th>
                <th class="w-15p p-1 text-center">Menge</th>
                <th class="w-20p p-1 text-center">
                    Einzelpreis(€)<br>/<span style="text-decoration: underline; color: #003366;">Gesamt(€)</span>
                </th>
            </tr>
        </thead>
        <tbody>
        @foreach($invoice->services as $index=>$service)
            <tr>
                <td class="text-center p-1">{{ $index+1 }}</td>
                <td class="ps-2 p-1">{{ $service->service_type->label() ?: $service->service_title }}</td>
                <td class="text-center p-1">{{ formatDate($service-> service_date)}}</td>
                <td class="text-center p-1">{{ $service->quantity }} Stunden</td>
                <td class="text-end pe-2 p-1">{{ formatNumber(parseNumber($service->unit_price) * $service->quantity->value)}}</td>
            </tr>
        @endforeach

        <tr>
            <td colspan="4" class="text-end pe-2 p-1 fw-bold">Gesamt Netto</td>
            <td class="text-end pe-2 p-1 fw-bold">{{ formatNumber($invoice->getTotalNetPrice()) }} €</td>
        </tr>
        </tbody>
    </table>

    <div class="mt-4 float-start" style="width: 250px;">
        <table class="w-100p border-0 font-size-10">
            <tr>
                <td>Netto:</td>
                <td class="text-end">{{ formatNumber($invoice->getTotalNetPrice()) }} €</td>
            </tr>
            <tr>
                <td class="fw-bold">MwSt (19%):</td>
                <td class="text-end">{{ formatNumber($invoice->getTaxPrice()) }} €</td>
            </tr>
            <tr class="border-top-0">
                <td class="fw-bold">Rechnungsbetrag:</td>
                <td class="text-end fw-bold">{{ formatNumber($invoice->getTotalGrossPrice()) }} €</td>
            </tr>
        </table>
    </div>

    <div style="clear: both;"></div>

    <div class="mt-15 font-size-10">
        Zahlungsbedingungen: Bitte überweisen Sie den Rechnungsbetrag innerhalb von 10 Tagen ohne Abzug auf das oben angegebene Konto.
    </div>
</div>

</body>
</html>
