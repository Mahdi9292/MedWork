<!DOCTYPE html>
<html lang="en">

    <head>
        @section('header')
            @include('sections.default._head')
        @show
    </head>
    <body>

{{--        @include('sections.default._environment-bar')--}}

        @include('sections.default._nav')

        <main class="content m-0">
            @section('topbar')
                @include('sections.default._topbar', ['hideSidebar' => 'true'])
            @show

            @yield('content')

            @section('footer')
                @include('sections.default._footer')
            @show
        </main>

        @section('scripts')
            @include('sections.default._scripts')
        @show

    </body>
</html>
