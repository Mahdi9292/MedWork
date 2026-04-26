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
        Rechnung an: {{ $invoice->receiver_name }}<br>
        {{$invoice->receiver_street}} {{$invoice->receiver_house_number}}<br>
        {{$invoice->receiver_postcode}} {{$invoice->receiver_city}}<br><br>
        <strong>Rechnung Nr.: {{ $invoice->invoice_number }}</strong>
    </div>

    <div class="mb-2">Leistungen:</div>

    <table class="table-border w-100p font-size-9">
        <thead>
            <tr>
                <th class="w-5p p-1 text-center">Pos.</th>
                <th class="p-1 text-center">Leistung</th>
                @if($hasDescription)
                    <th class="p-1 text-center">Beschreibung</th>
                @endif
                <th class="w-15p p-1 text-center">Datum</th>
                <th class="w-10p p-1 text-center">{{ $invoice->invoice_type?->label() ?: $invoice->invoice_type_other }}</th>
                <th class="w-10p p-1 text-center">Einzelpreis</th>
                <th class="w-10p p-1 text-center">Gesamtpreis</th>
            </tr>
        </thead>
        <tbody>
        @foreach($invoice->invoiceItems as $index=>$item)
            <tr>
                <td class="text-center p-1">{{ $index+1 }}</td>
                <td class="ps-2 p-1">{{ $item->itemType?->name ?: $item->item_type_other }}</td>
                @if($hasDescription)
                    <td class="font-size-8 {{$item->description?'': 'text-center'}}">{{ $item->description ?: '—' }}</td>
                @endif
                <td class="text-center p-1">{{ formatDate($item->serving_date)}}</td>

                @if($invoice->invoice_type == \App\Enums\Finance\InvoiceType::QT_EMPLOYEE)
                    <td class="text-center p-1">{{ $item->employee_name ?: '' }} </td>

                @elseif($invoice->invoice_type == \App\Enums\Finance\InvoiceType::QT_PERSON)
                    <td class="text-center p-1">{{ $item->quantity ?: '' }} </td>

                @else
                    <td class="text-center p-1">{{ formatNumber(parseNumber($item->amount))}} </td>
                @endif

                <td class="text-center p-1">{{ $item->unit_price }} €</td>
                <td class="text-end pe-2 p-1">{{ formatNumber($item->getNetPrice()) }} €</td>
            </tr>
        @endforeach

        <tr>
            <td colspan="{{ $hasDescription ? 6 : 5 }}" class="text-end pe-2 p-1 fw-bold">Gesamt Netto</td>
            <td class="text-end pe-2 p-1 fw-bold">{{ formatNumber($invoice->totalNetItemAmount()) }} €</td>
        </tr>
        </tbody>
    </table>

    @if(count($invoice->invoiceTravelExpenses) > 0)
        <div class="mb-2 mt-5">Fahrkosten:</div>
        <table class="table-border w-100p font-size-9">
            <thead>
            <tr>
                <th class="w-5p p-1 text-center">Pos.</th>
                <th class="w-5p p-1 text-center">Von</th>
                <th class="p-1 text-center">Nach</th>
                <th class="p-1 text-center">Fahrtart</th>
                <th class="w-15p p-1 text-center">Datum</th>
                <th class="w-10p p-1 text-center">Strecke(KM)</th>
                <th class="w-10p p-1 text-center">Preis pro KM</th>
                <th class="w-10p p-1 text-center">Gesamtpreis</th>
            </tr>
            </thead>
            <tbody>
            @foreach($invoice->invoiceTravelExpenses as $index=>$travelExpense)
                <tr>
                    <td class="text-center p-1">{{ $index+1 }}</td>
                    <td class="ps-2 p-1">{{ $travelExpense->start_location }}</td>
                    <td class="ps-2 p-1">{{ $travelExpense->destination }}</td>
                    <td class="ps-2 p-1">{{ $travelExpense->trip_type?->label() }}</td>
                    <td class="text-center p-1">{{ formatDate($travelExpense->travel_date)}}</td>
                    <td class="text-center p-1">{{ $travelExpense->distance }} KM</td>
                    <td class="text-center p-1">{{ $travelExpense->price_per_km }} €</td>
                    <td class="text-end pe-2 p-1">{{ formatNumber(parseNumber($travelExpense->price_per_km) * parseNumber($travelExpense->distance))}} €</td>
                </tr>
            @endforeach

            <tr>
                <td colspan="{{ 7 }}" class="text-end pe-2 p-1 fw-bold">Gesamt Netto</td>
                <td class="text-end pe-2 p-1 fw-bold">{{ formatNumber($invoice->totalNetTravelExpenseAmount()) }} €</td>
            </tr>
            </tbody>
        </table>
    @endif

    <div class="mt-4 float-start" style="width: 250px;">
        <table class="w-100p border-0 font-size-10">
            <tr>
                <td>Netto:</td>
                <td class="text-end">{{ formatNumber($invoice->getTotalNetAmount()) }} €</td>
            </tr>
            @if($invoice->value_added_tax !== 0)
                <tr>
                    <td class="fw-bold">MwSt ({{ $invoice->value_added_tax ?? 19 }}%):</td>
                    <td class="text-end">{{ formatNumber($invoice->getTaxAmount()) }} €</td>
                </tr>
            @endif
            <tr class="border-top-0">
                <td class="fw-bold">Rechnungsbetrag:</td>
                <td class="text-end fw-bold">{{ formatNumber($invoice->getTotalGrossAmount()) }} €</td>
            </tr>
        </table>
    </div>

    <div style="clear: both;"></div>

    <div class="mt-15 font-size-10">
        Zahlungsbedingungen: Bitte überweisen Sie den Rechnungsbetrag innerhalb von 10 Tagen ohne Abzug auf das angegebene Konto.
    </div>
</div>

</body>
</html>
