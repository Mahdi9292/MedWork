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
            margin-top: 25mm;
            font-family: frutiger;
        }
    </style>
</head>
<body>

@include('templates.pdf.header')
@include('templates.pdf.footer')

<table class="w-100p ms-2 table-layout-fixed">
    <tbody>
    <tr class="">
        <td class="fw-bold min-width-8">{{ __('Lieferanschrift') }}</td>
        <td class="fw-bold">{{ __('Absenderanschrift') }}</td>
    </tr>


    <tr>
        <td class="h-30 align-top"> HALLO 1 </td>
        <td class="h-30 align-top">HALLO 2 </td>
    </tr>




    <tr>
        <td class="align-top">
            <table>
                <tbody>
                <tr>
                    <td class="align-top h-100"><h2>{{ __('Abholschein') }}</h2></td>
                </tr>
                </tbody>
            </table>
        </td>
        <td>
            <table>
                <tbody>
                <tr>
                    <td class="fw-bold">{{ __('LieferscheinNr. /Datum') }}</td>
                    <td> {{ now()->format('d.m.Y') }}</td>
                </tr>
                <tr>
                    <td class="fw-bold">{{ __('LieferscheinNr. /Datum') }}</td>
                    <td> {{ now()->format('d.m.Y') }}</td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>

<div class="border h-115 headerWithBackground">
    <table class="w-100p font-size-9">
        <tbody>
        <tr>
            <th class="w-32p text-start font-size-8-5">RENT CENTER </th>
            <th class="w-32p text-start font-size-8-5">{{ __('Ausführende Spedition') }}</th>
            <th class="text-start font-size-8-5">{{ __('Sonstige Informationen für die Lieferung') }}:</th>
        </tr>
        <tr>
            <td class="font">FIRST NAME und LAST NAME</td>
            <td>{{ __('Selbstabholer') }}</td>
            <td>
                <span class="fw-bold">{{ __('Transportpriorität') }}</span>: IT IS HIGH
            </td>
        </tr>
        <tr>
            <td> </td>
            <td class="align-top"><span class="fw-bold">{{ __('Abholdatum') }}:</span> <span class="fw-bold">PICKUP DATE </span></td>
            <td rowspan="3"> STRING LIMIT </td>
        </tr>
        <tr>
            <td class="align-top"><span class="fw-bold">{{ __('Telefon') }}:</span> TELEFON </td>
            <td class="align-top"><span class="fw-bold">{{ __('Lieferdatum') }}:</span> LIEFER </td>
        </tr>
        <tr>
            <td class="align-top" colspan="2"><span class="fw-bold">{{ __('Email') }}:</span> E-MAIL </td>
        </tr>
        </tbody>
    </table>
</div>
<div class="border border-top-0 border-bottom-0" style="height: 360px;">
    <table class="w-70p ms-4">
        <tbody>
        <tr>
            <td class="w-250">{{ __('Marke') }}</td>
            <td class="w-350">HALLO 4 </td>
        </tr>
        <tr>
            <td>{{ __('Gerätetyp') }}</td>
            <td>TYPE  </td>
        </tr>
        </tbody>
    </table>
</div>

<div class="border border-top-0 ps-3 pe-3">
    <table class="table-border w-100p font-size-7">
        <tbody>
        <tr>
            <td class="w-15p">{{ __('Datum') }}</td>

            <td class="text-center">{{ __('Unterschrift / Druckschrift Spedition - KFZ Kennz.') }}</td>
            <td class="text-center">
                {{  __('Stempel - Unterschrift / Druckschrift ') }}
            </td>
        </tr>
        </tbody>
    </table>


    <span class="fw-bold font-size-6">{{ __('Sendung in einwandfreiem Zustand und vollzählig erhalten.') }}</span>
    <br>
    <span class="font-size-6">{{ __('Bitte melden Sie sich unter 0800 287378423, wenn die nächste FEM4.004-Prüfung (UVV) oder Wartung fällig wird (vgl. Aufkleber auf dem Gerät).') }}</span>
    <br>
    <span class="font-size-6">{{ __('Hinweis: Unsere Transporte werden durch LKW (~40 Tonnen) vorgenommen. Falls eine Anlieferung/Abholung mit einem solchen Fahrzeug bei Ihnen nicht möglich sein sollte, setzen Sie sich bitte mit uns in Verbindung.') }}</span>
</div>

</body>
</html>
