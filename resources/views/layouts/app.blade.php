<!DOCTYPE html>
<html lang="en">
{{--<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">--}}

<head>
    @section('header')
        @include('sections.default._head')
    @show
</head>
<body>

{{--@include('sections.default._environment-bar')--}}

@include('sections.default._nav')

@section('sidebar')
    @include('sections.default._sidenav')
@show

<main class="content">
    @section('topbar')
        @include('sections.default._topbar')
    @show

    @yield('content')
    @yield('modals')
    @yield('canvas')

    @section('footer')
        @include('sections.default._footer')
    @show
</main>

@section('scripts')
    @include('sections.default._scripts')
@show

</body>
</html>
