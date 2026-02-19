<!-- Vanilla JS Datepicker -->
<script src="{{ asset('assets/vendor/vanillajs-datepicker/dist/js/datepicker.min.js')}}"></script>

<!-- Choices.js -->
<script src="{{ asset('/assets/vendor/choices.js/public/assets/scripts/choices.min.js') }}"></script>

<!-- Volt JS -->
<script src="{{ asset('assets/js/volt.js')}}"></script>

<!-- Jquery script -->
<script src="{{ asset('assets/js/jquery-3.6.1.min.js') }}"></script>
<script src="{{ asset('/assets/vendor/vanillajs-datepicker/dist/js/locales/de.js') }}"></script>

<!-- TMHDE JS -->
<script src="{{ asset('/assets/js/medwork.js') }}"></script>

<!-- Livewire scripts -->
@livewireScriptConfig

<!-- Jquery script -->
<script src="{{ asset('assets/js/jquery-3.6.1.min.js') }}"></script>

<!-- Select2 script -->
<script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>

@yield('pageScripts')
@stack('pageScripts')
