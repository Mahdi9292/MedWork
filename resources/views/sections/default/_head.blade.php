<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!-- Primary Meta Tags -->
<title>MedWork</title>
<meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
<meta name="title" content="Volt - Free Bootstrap 5 Admin Dashboard">
<meta name="author" content="Themesberg">
<meta name="description" content="Volt Pro is a Premium Bootstrap 5 Admin Dashboard featuring over 800 components, 10+ plugins and 20 example pages using Vanilla JS.">
<meta name="keywords" content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, themesberg, themesberg dashboard, themesberg admin dashboard">

<!-- Favicon -->
<link rel="apple-touch-icon" sizes="120x120" href="{{ asset('/assets/img/favicon/apple-touch-icon.png') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/assets/img/favicon/favicon-32x32.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/assets/img/favicon/favicon-16x16.png') }}">
<link rel="manifest" href="{{ asset('/assets/img/favicon/site.webmanifest') }}">
<link rel="mask-icon" href="{{ asset('/assets/img/favicon/safari-pinned-tab.svg') }}" color="#ffffff">
<link rel="shortcut icon" href="{{ asset('/assets/img/favicon/favicon.ico') }}">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-config" content="{{ asset('/assets/img/favicon/browserconfig.xml') }}">
<meta name="theme-color" content="#ffffff">

<!-- Volt CSS -->
{{--<link type="text/css" href="{{ asset('assets/css/volt.css') }}" rel="stylesheet">--}}

<!-- NOTICE: You can use the _analytics.html partial to include production code specific code & trackers -->
<!-- Global site tag (gtag.js) - Google Analytics -->

<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

<!-- livewire styles -->
@livewireStyles

@vite(['resources/css/app.css', 'resources/js/app.js'])

@yield('styles')
@stack('styles')
