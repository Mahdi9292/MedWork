import './bootstrap';

// Theme css Volt Pro
import "../sass/volt.scss";

import "../sass/dropzone.scss";

// TMHDE Custom Styles
import "../sass/tmhde.scss";

import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

import { Toast, TOAST_STATUS, TOAST_THEME, TOAST_PLACEMENT } from "bootstrap-toaster";
window.Toast = Toast;

// Sweet Alert2 JS & CSS (Auto Include)
import Swal from 'sweetalert2';
window.Swal = Swal;

// File Pond. @Deprecated since dropzone.
//import * as FilePond from 'filepond';
//import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
//FilePond.registerPlugin(FilePondPluginImagePreview);
//window.FilePond = FilePond;

// TomSelect. must be loaded before Alpine to void browser
// undefined error.
import TomSelect from "tom-select";
window.TomSelect = TomSelect

// importing Alpine and Livewire manually as we need sort plugin which is not
// loaded by default with Livewire.
import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import sort from '@alpinejs/sort'
Alpine.plugin(sort)
Livewire.start()

// Alpine JS -- included with livewire V3
//import Alpine from 'alpinejs'
//window.Alpine = Alpine
//Alpine.start()

import flatpickr from "flatpickr";
import German  from "flatpickr/dist/l10n/de" // Please don't remove
flatpickr.localize(flatpickr.l10ns.de);
window.flatpickr = flatpickr;

import './../../vendor/power-components/livewire-powergrid/dist/powergrid'
import './../../vendor/power-components/livewire-powergrid/dist/bootstrap5.css'

// Apex Charts JS & CSS (Auto Include)
import ApexCharts from 'apexcharts'
window.ApexCharts = ApexCharts;


