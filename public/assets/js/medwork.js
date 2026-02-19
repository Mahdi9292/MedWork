/*
=========================================================
* TMHDE JS
=========================================================

* Copyright TMHDE 2021 (https://toyota-forklifts.eu)
* Author: Ehsan Farooqi (https://github.com/eafarooqi)

=========================================================
*/

"use strict";

d.addEventListener("DOMContentLoaded", function (event) {

    // initialization functions
    initChoiceDropDown();                  // choice Dropdown init
    initBootstrapValidation();             // Bootstrap 5 Validation init
    initAjaxCheckbox();                    // ajax checkbox init
    initCustomerSelect();                  // Livewire customer select init
    initM3CustomerSelect();                // Livewire M3 customer select init
    initM3TcrmCustomerSelect();            // Livewire M3 & TCRM customer select init
    initSalesmanSelect();                  // Livewire customer select init
    initLifterSelect();                    // Livewire lifter select init
    initDoConfirmation();                  // action confirmation popup
    initLivewireAlerts();                  // livewire alerts
    initScrollTo();                        // scroll page to given location
    initHideAfterX();                      // hide element automatically after x seconds
    initRemoveValidationClassesAfterX();   // hide validation classes automatically after x seconds
    initLivewireHideAfter();               // run hideAfter event for livewire
    initBackToTopButton();                 // enable the back to top button
    initShowUserProfile();                 // load user profile modal
    initBootstrapToolTip();                // Bootstrap Tooltip
    initTableTopScrollBarWithStickyHeader();               // Table top scroll bar
    connectPortalTokenToLivewire();        // make all Urls with CP class connect portal compatible.

    // Custom Functions
    sidebarActiveJs()                       // making the menu active as a fallback if active class cant be added in php.
});

document.addEventListener('shown.bs.modal', (e) => {
    initBootstrapToolTip();
});

// #################### Initialization Functions ########################

// reset filters on js datatable
function resetFilters(tableName=''){
    if (typeof table !== 'undefined') {
        yadcf.exResetAllFilters(table);
    }

    // clearing All filters from Livewire power grid
    if(tableName){
        Livewire.dispatch('pg:resetGrid-'+tableName);
    }
}

// refresh/reload js datatable data with ajax
function reloadJSDataTable() {
    if(table){
        table.ajax.reload();
    }
}

// Choice.js Dropdown
function initChoiceDropDown() {
    let allChoices = d.querySelectorAll('.choice');
    [].forEach.call(allChoices, function(choice) {
        const choices = new Choices(choice, {
                removeItemButton: true,
            }
        );
    });
}

// Bootstrap 5 Validation
function initBootstrapValidation(){
    const forms = document.querySelectorAll('.requires-validation')
    Array.from(forms)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })
}

// Ajax Checkbox
function initAjaxCheckbox(element)
{
    document.querySelector(".content").addEventListener('click', function (e) {

        // check whether ajax-checkbox is present on the page
        if (e.target.classList.contains('ajax-checkbox'))
        {

            let parent = e.target.closest('.ajax-checkbox-wrapper');
            if(parent.querySelector(".chk-loader") !== null) {
                parent.querySelector(".chk-loader").classList.remove("d-none");
                parent.querySelector(".chk-error-indicator").classList.add("d-none");
            }

            fetch(e.target.getAttribute('data-url'), {
                method: 'POST',
                body: JSON.stringify({
                    params: e.target.getAttribute('data-params'),
                    checked:e.target.checked
                }),
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')['content'],
                    'Content-type': 'application/json; charset=UTF-8',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            }).then(function (response) {
                // The API call was successful!
                if(parent.querySelector(".chk-loader") !== null) {
                    parent.querySelector(".chk-loader").classList.add("d-none");
                }

                if (response.ok)
                {
                    // reloading js data table plugin
                    if(e.target.getAttribute('data-reload-table')){
                        reloadJSDataTable();
                    }

                    if(e.target.getAttribute('data-success-url')){
                        window.open(e.target.getAttribute('data-success-url'), '_blank');
                    }

                    return response.json();
                } else {
                    return Promise.reject(response);
                }
            }).then(function (data) {
                // This is the JSON from our response
                //console.log(data);
            }).catch(function (err) {
                // There was an error
                if(parent.querySelector(".chk-error-indicator") !== null) {
                    parent.querySelector(".chk-error-indicator").classList.remove("d-none");
                }

                console.error('Something went wrong.', err);
            });
        }
    });
}

// Customer Select
function initCustomerSelect() {
    if (typeof Livewire === "undefined") {
        return false;
    }

    Livewire.on('customerSelected', data => {
        if(data.customer)
        {
            // throwing livewire event for livewire component
            let eventName = data.eventName || 'setCustomerData';
            Livewire.dispatch(eventName, {customer: data.customer});

            let fields = data.fields;
            let customer = data.customer;

            // setting fields for non livewire page
            setValueById(valueOrDefault(fields.id, 'customer_id'), valueOrDefault(customer.customerid));                    // customer id ->  Empfänger/Absender ID
            setValueById(valueOrDefault(fields.name, 'customer_name'), valueOrDefault(customer.name));                      // customer name ->  Empfänger/Absender name
            setValueById(valueOrDefault(fields.first_name, 'customer_first_name'), valueOrDefault(customer.firstname));     // customer firstname ->  Empfänger/Absender Vorname
            setValueById(valueOrDefault(fields.last_name, 'customer_contact'), valueOrDefault(customer.lastname));          // customer lastname ->  Empfänger/Absender Nachname/Ansprechpartner
            setValueById(valueOrDefault(fields.street, 'customer_street'), valueOrDefault(customer.street));                // customer street ->  Empfänger/Absender Straße
            setValueById(valueOrDefault(fields.postcode, 'customer_postcode'), valueOrDefault(customer.postcode));          // customer postcode ->  Empfänger/Absender PLZ
            setValueById(valueOrDefault(fields.city, 'customer_city'), valueOrDefault(customer.city));                      // customer city ->  Empfänger/Absender Stadt
            setValueById(valueOrDefault(fields.mail, 'customer_email'), valueOrDefault(customer.mail));                     // customer Email ->  Empfänger/Absender eMail
            setValueById(valueOrDefault(fields.phone, 'customer_phone'), valueOrDefault(customer.phone));                   // customer Phone ->  Empfänger/Absender Tel
            setValueById(valueOrDefault(fields.mobile, 'customer_mobile'), valueOrDefault(customer.mobile));                // customer Mobile ->  Empfänger/Absender Mobile
            setValueById(valueOrDefault(fields.salesman_email, 'salesman_email'), valueOrDefault(customer.salesman_email)); // Attached salesman Email ->  Empfänger/Absender salesman Email
        }
    })
}

// M3 Customer Select
function initM3CustomerSelect() {
    if (typeof Livewire === "undefined") {
        return false;
    }

    Livewire.on('m3CustomerSelected', data => {
        if(data.customer)
        {
            // throwing livewire event for livewire component
            let eventName = data.eventName || 'setM3CustomerData';
            Livewire.dispatch(eventName, {data: data});

            let fields = data.fields;
            let customer = data.customer;

            // setting fields for non livewire page
            setValueById(valueOrDefault(fields.id, 'customer_id'), valueOrDefault(customer.customer_id));
            setValueById(valueOrDefault(fields.company_name, 'customer_company'), valueOrDefault(customer.customer_company));
            setValueById(valueOrDefault(fields.street, 'customer_street'), valueOrDefault(customer.customer_street));
            setValueById(valueOrDefault(fields.postcode, 'customer_postcode'), valueOrDefault(customer.customer_postcode));
            setValueById(valueOrDefault(fields.central_phone, 'customer_central_phone'), valueOrDefault(customer.customer_central_phone));
            setValueById(valueOrDefault(fields.vat_number, 'customer_vat_number'), valueOrDefault(customer.customer_vat_number));
            setValueById(valueOrDefault(fields.m3_contact_person, 'customer_m3_contact_person'), valueOrDefault(customer.customer_m3_contact_person));
            setValueById(valueOrDefault(fields.city, 'customer_city'), valueOrDefault(customer.customer_city));
            setValueById(valueOrDefault(fields.salesman, 'salesman'), valueOrDefault(customer.salesman));
        }
    })
}

// M3 & TCRM Customer Select
function initM3TcrmCustomerSelect() {
    if (typeof Livewire === "undefined") {
        return false;
    }

    Livewire.on('m3TcrmCustomerSelected', data => {
        if(data.customer)
        {
            // throwing livewire event for livewire component
            let eventName = data.eventName || 'setM3TcrmCustomerData';
            Livewire.dispatch(eventName, {data: data});

            let fields = data.fields;
            let customer = data.customer;

            // setting fields for non livewire page
            setValueById(valueOrDefault(fields.customer_m3_number, 'm3_customer_number'), valueOrDefault(customer.customer_m3_number));
            setValueById(valueOrDefault(fields.customer_tcrm_id, 'customer_tcrm_id'), valueOrDefault(customer.customer_tcrm_id));
            setValueById(valueOrDefault(fields.customer_company, 'customer_company'), valueOrDefault(customer.customer_company));
        }
    })
}

// Salesman Select
function initSalesmanSelect() {
    if (typeof Livewire === "undefined") {
        return false;
    }

    Livewire.on('salesmanSelected', data => {
        if(data.salesman)
        {
            // throwing livewire event for livewire component
            Livewire.dispatch('setSalesmanData', {salesman: data.salesman});

            let fields = data.fields;
            let salesman = data.salesman;

            // setting fields
            setValueById(valueOrDefault(fields.salesman, 'salesman'), valueOrDefault(salesman.salesPerson));                                // salesman -> Verkäufer
            setValueById(valueOrDefault(fields.region, 'region'), valueOrDefault(salesman.region));                                         // region -> Gebiet
            setValueById(valueOrDefault(fields.area_sales_manager, 'area_sales_manager'), valueOrDefault(salesman.areaSalesManager));       // area_sales_manager -> Gebietsleiter
            setValueById(valueOrDefault(fields.region_sales_manager, 'region_sales_manager'), valueOrDefault(salesman.regionSalesManager)); // region_sales_manager -> TSC
            setValueById(valueOrDefault(fields.team_salesman, 'team_salesman'), valueOrDefault(salesman.team));                             // team_salesman -> Team
            setValueById(valueOrDefault(fields.salesman_email, 'salesman_email'), valueOrDefault(salesman.salesmanEMail));                  // salesman_email ->  eMail Verkäufer
            setValueById(valueOrDefault(fields.sales_assistant_email, 'sales_assistant_email'), valueOrDefault(salesman.teamMail));         // sales_assistant_email ->   email Vertriebsassistenz
            setValueById(valueOrDefault(fields.responsible_id, 'responsible_id'), valueOrDefault(salesman.responsiblePerson));              // responsible_id
            setValueById(valueOrDefault(fields.m3_salesman_no, 'm3salesman_nr'), valueOrDefault(salesman.m3SalesmanCode), 'html');     // m3salesman_nr ->    M3-Verkäufer-Nr.
        }
    })
}

// Lifter Select
function initLifterSelect() {
    if (typeof Livewire === "undefined") {
        return false;
    }

    Livewire.on('lifterSelected', data => {
        if(data.lifter)
        {
            // throwing livewire event for livewire component
            Livewire.dispatch('setLifterData', {lifter: data});
            let fields = data.fields;
            let lifter = data.lifter;

            setValueById(valueOrDefault(fields.innoId, 'innoid'), valueOrDefault(lifter.innoid));                             // innoid -> GeräteID
            setValueById(valueOrDefault(fields.serialNumber, 'serial_number'), valueOrDefault(lifter.serialnr));              // serial_number -> SerienNr
            setValueById(valueOrDefault(fields.m3Status, 'm3_status'), valueOrDefault(lifter.status));                        // m3_status -> M3-Status
            setValueById(valueOrDefault(fields.model, 'model'), valueOrDefault(lifter.model));                                // model -> Modell
            setValueById(valueOrDefault(fields.deviceType, 'device_type'), valueOrDefault(lifter.ingroup));                   // device_type -> Gerätetyp
            setValueById(valueOrDefault(fields.brand, 'brand'), valueOrDefault(lifter.brand));                                // brand -> Marke
            setValueById(valueOrDefault(fields.batteryCapacity, 'battery_capacity'), valueOrDefault(lifter.battcapaci));      // battery_capacity -> Batteriekapazität
            setValueById(valueOrDefault(fields.operatingHours,'operating_hours'), valueOrDefault(lifter.hours));              // operating_hours -> Betriebsstunden M3
            setValueById(valueOrDefault(fields.batterySerial, 'battery_serial'), valueOrDefault(lifter.battserial));          // battery_serial -> BatterieSerNr
            setValueById(valueOrDefault(fields.chargerCap, 'charger_cap'), valueOrDefault(lifter.chargercap));                // charger_cap -> Ladegerät (old - obsolete)
            setValueById(valueOrDefault(fields.charger, 'charger'), valueOrDefault(lifter.charger));                          // charger -> Ladegerät
            setValueById(valueOrDefault(fields.liftHigh, 'lift_high'), valueOrDefault(lifter.lifthigh));                      // lift_high -> Hubhöhe
            setValueById(valueOrDefault(fields.forkLength, 'fork_length'), valueOrDefault(lifter.forklength));                // fork_length -> Gabellänge
            setValueById(valueOrDefault(fields.forks, 'forks'), valueOrDefault(lifter.forks));                                // forks -> Forks
            setValueById(valueOrDefault(fields.mast, 'mast'), valueOrDefault(lifter.mast));                                   // mast -> Hubgerüst
            setValueById(valueOrDefault(fields.liftCap, 'lift_cap'), valueOrDefault(lifter.liftcap));                         // lift_cap -> Nenntragfähigkeit
            setValueById(valueOrDefault(fields.minHeight, 'min_height'), valueOrDefault(lifter.minheight));                   // min_height -> Bauhöhe
            setValueById(valueOrDefault(fields.warehouse, 'warehouse'), valueOrDefault(lifter.warehouse));                    // warehouse -> Lager
            setValueById(valueOrDefault(fields.location, 'location'), valueOrDefault(lifter.location));                       // location -> Lagerplatz
            setValueById(valueOrDefault(fields.freeLift, 'free_lift'), valueOrDefault(lifter.freelift));                      // free_lift -> Freihub
            setValueById(valueOrDefault(fields.owner, 'owner'), valueOrDefault(lifter.owner));                                // owner -> StandortM3
            setValueById(valueOrDefault(fields.batteryBrand, 'battery_brand'), valueOrDefault(lifter.battbrand));             // battery_brand -> HerstellerBatterie
            setValueById(valueOrDefault(fields.chargerBrand, 'charger_brand'), valueOrDefault(lifter.chargerbrand));          // charger_brand -> HerstellerLadegerät
            setValueById(valueOrDefault(fields.deviceWeight, 'device_weight'), valueOrDefault(lifter.weight));                // device_weight -> GeräteGewicht
            setValueById(valueOrDefault(fields.chassisWidth, 'chassis_width'), valueOrDefault(lifter.chassiwidth));           // chassis_width -> Chassisbreite
            setValueById(valueOrDefault(fields.machineLength, 'machine_length'), valueOrDefault(lifter.machinelength));       // machine_length -> Maschinenlänge

            setValueById(valueOrDefault(fields.chargerSerialNumber, 'charger_serial_number'), valueOrDefault(lifter.chargerserialnumber)); // charger_serial_number -> LadegerätSerNr
        }
    })
}

// Delete confirmation popup
function initDoConfirmation(){
    document.body.addEventListener( 'click', function ( event ) {
        if( event.target.classList.contains('doWithConfirmation') || (event.target.parentNode && event.target.parentNode.classList.contains('doWithConfirmation'))) {

            event.preventDefault();
            let ele = null;

            if(event.target.parentNode.classList.contains('doWithConfirmation')){
                ele = event.target.parentNode;
            } else {
                ele = event.target;
            }

            // displaying confirmation popup
            Swal.fire({
                title: ele.dataset.confirmTitle || 'Löschen Bestätigen',
                text: ele.dataset.confirmText || "Dieser Vorgang kann nicht rückgängig gemacht werden.",
                cancelButtonText: ele.dataset.confirmCancelButtonText || "Cancel",
                showCancelButton: true,
                confirmButtonText: ele.dataset.buttonText || 'löschen'
            }).then((result) => {

                if (result.isConfirmed) {
                    if(ele.tagName == 'A'){
                        // if anchor
                        window.location.href = ele.getAttribute('href');
                    }else if(ele.tagName == 'BUTTON') {
                        // if form
                        ele.closest('form').submit();
                    }
                }
            });
        };
    });
}

// livewire sweet alerts
function initLivewireAlerts() {

    // Modal
    const SwalModal = (icon, title, html) => {
        Swal.fire({
            icon,
            title,
            html,
            confirmButtonText: 'close',
        })
    }

    // Confirm
    const SwalConfirm = (icon, title = 'Löschen Bestätigen', html = 'Dieser Vorgang kann nicht rückgängig gemacht werden.', confirmButtonText = "löschen", method, params, callback, width='32em') => {
        Swal.fire({
            icon,
            title,
            html,
            width: width,
            showCancelButton: true,
            confirmButtonText,
            cancelButtonText: 'Abbrechen',
        }).then(result => {
            if (result.isConfirmed) {
                return Livewire.dispatch(method, params)
            }

            if (callback) {
                return Livewire.dispatch(callback)
            }
        })
    }

    // Alert
    const SwalAlert = (icon = 'info', title = 'Completed successfully!', timeout = 7000) => {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-right',
            showConfirmButton: false,
            showCloseButton: false,
            timer: timeout,
            backdrop: false,
            didOpen: toast => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon,
            title
        })
    }

    // Livewire events
    // document.addEventListener('livewire:load', function () {

    Livewire.on('swal:modal', data => {
        SwalModal(data.icon, data.title, data.text)
    })

    Livewire.on('swal:confirm', data => {
        SwalConfirm(data.icon, data.title, data.text, data.confirmButtonText, data.method, data.params, data.callback, data.width)
    })

    Livewire.on('swal:alert', data => {
        SwalAlert(data.icon, data.title, data.timeout)
    })

    Livewire.on('toast:alert', data => {
        showToast(data.message, data.title, data.status)
    })

    // T-Flow History Modal
    Livewire.on('tflow:showLineHistoryModal', (data) => {
        new bootstrap.Modal(document.getElementById('tflowLineHistoryModal'), {
            keyboard: true
        }).show();
    })

    // T-Invoice History Modal
    Livewire.on('tinvoice:loadInvoiceHistory', (data) => {
        new bootstrap.Modal(document.getElementById('tinvoiceInvoiceHistoryModal'), {
            keyboard: true
        }).show();

        // to reset the modal on closing.
        let tinvoiceHistoryModalEl = document.getElementById('tinvoiceInvoiceHistoryModal')
        tinvoiceHistoryModalEl.addEventListener('hide.bs.modal', function (event) {
            Livewire.dispatch('tinvoice:closeHistoryModal');
        })
    })

    // T-CDC History Modal
    Livewire.on('tcdc:loadTicketHistory', data => {
        new bootstrap.Modal(document.getElementById('tcdcTicketHistoryModal'), {
            keyboard: true
        }).show();

        // to reset the modal on closing.
        let tcdcHistoryModalEl = document.getElementById('tcdcTicketHistoryModal')
        tcdcHistoryModalEl.addEventListener('hide.bs.modal', function (event) {
            Livewire.dispatch('tcdc:closeHistoryModal');
        })
    })

    // T-CDC Comment Modal
    Livewire.on('tcdc:loadTicketComment', data => {
        new bootstrap.Modal(document.getElementById('tcdcTicketCommentModal'), {
            keyboard: true
        }).show();

        // to reset the modal on closing.
        let tcdcCommentModalEl = document.getElementById('tcdcTicketCommentModal')
        tcdcCommentModalEl.addEventListener('hide.bs.modal', function (event) {
            Livewire.dispatch('tcdc:closeCommentModal');
        })
    })

    // OrderBook History Modal
    Livewire.on('orderbook:loadOrderHistory', data => {
        new bootstrap.Modal(document.getElementById('orderbookOrderHistoryModal'), {
            keyboard: true
        }).show();

        // to reset the modal on closing.
        let orderbookHistoryModalEl = document.getElementById('orderbookOrderHistoryModal')
        orderbookHistoryModalEl.addEventListener('hide.bs.modal', function (event) {
            Livewire.dispatch('orderbook:closeHistoryModal');
        })
    })

    // User Profile Modal
    Livewire.on('user:showProfileModal', (data) => {
        new bootstrap.Modal(document.getElementById('UserProfileModal'), {
            keyboard: true
        }).show();
    })

    // T-Time Expense Entry Receipt Modal
    Livewire.on('ttime:showExpenseEntryReceiptForm', data => {
        new bootstrap.Modal(document.getElementById('ttimeExpenseEntryReceiptFormModal'), {
            keyboard: true
        }).show();

        // to reset the modal on closing.
        let ttimeExpenseEntryReceiptModalEl = document.getElementById('ttimeExpenseEntryReceiptFormModal')
        ttimeExpenseEntryReceiptModalEl.addEventListener('hide.bs.modal', function (event) {
            Livewire.dispatch('ttime:closeExpenseEntryReceiptModal');
        })
    })

    // Close Bootstrap Modal
    Livewire.on('twap:closeBootstrapModal', (data) => {

        // getting Bootstrap Modal Element
        let myModalEl = document.getElementById(data.id)
        if(myModalEl) {
            let bsModal = bootstrap.Modal.getInstance(myModalEl)

            // closing given bootstrap modal
            bsModal.hide();
        }
    })

    //})
}

// scroll page to the given location
function initScrollTo(){
    if(window.location.hash) {
        let hash = window.location.hash.substring(1);

        if(hash == 'sBottom'){
            window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' })
        }
        else if(hash == 'sTop'){
            window.scrollTo({ top: 0, behavior: 'smooth' })
        } else {
            let element =  document.getElementById(hash);
            if (typeof(element) != 'undefined' && element != null)
            {
                element.scrollIntoView({ behavior: 'smooth', block: 'end'});
            }
        }
    }
}

// hide element automatically after x seconds
function initHideAfterX(){
    const elements = document.querySelectorAll('.hideAfter')
    Array.from(elements)
        .forEach(function (element) {
            let hideAfter = element.dataset.secondsToShow || 5;
            setTimeout(() => {

                // removes element from DOM
                element.style.display = 'none';

            }, hideAfter * 1000); // 👈️ time in milliseconds
        })
}

// hide validation classes automatically after x seconds
function initRemoveValidationClassesAfterX(){
    const elements = document.querySelectorAll('.removeValidationAfter')
    Array.from(elements)
        .forEach(function (element) {
            let hideAfter = element.dataset.secondsToShow || 5;
            setTimeout(() => {

                // hide validation classes class
                element.classList.remove('is-valid');

            }, hideAfter * 1000); // 👈️ time in milliseconds
        })
}

// listen to livewire hideAfter event
function initLivewireHideAfter(){
    if (typeof Livewire !== "undefined") {
        Livewire.on('hideAfter', data => {
            initHideAfterX();
            initRemoveValidationClassesAfterX();
        })
    }
}

function initBackToTopButton(){
    let backToTopButton = document.getElementById("btn-back-to-top");

    if(backToTopButton)
    {
        // When the user scrolls down 20px from the top of the document, show the button
        window.onscroll = function () {
            scrollFunction(backToTopButton);
        };
        backToTopButton.addEventListener("click", backToTop);
    }
}

function initBootstrapToolTip()
{
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
}

function initTableTopScrollBarWithStickyHeader() {
    const top = document.querySelector('.table-scroll-top');
    const topInner = document.querySelector('.table-scroll-top-inner');
    const main = document.querySelector('.table-scroll-main');
    const stickyHost = document.querySelector('.table-sticky-head'); // add <div class="table-sticky-head"></div> above .table-scroll-main

    if (!top || !topInner || !main || !stickyHost) return;

    const table = main.querySelector('table');
    const thead = table?.querySelector('thead');
    if (!table || !thead) return;

    // Build sticky header (clone THEAD)
    stickyHost.innerHTML = `
        <div class="table-sticky-head-inner">
            <table class="${table.className}">
                ${thead.outerHTML}
            </table>
        </div>
    `;

    const stickyInner = stickyHost.querySelector('.table-sticky-head-inner');
    const stickyTable = stickyHost.querySelector('table');

    let lock = false;

    function syncTopWidth() {
        topInner.style.width = main.scrollWidth + 'px';
    }

    function syncStickyGeometry() {
        const rect = main.getBoundingClientRect();
        stickyHost.style.left = rect.left + 'px';
        stickyHost.style.width = rect.width + 'px';
    }

    function syncStickyColumnWidths() {
        const realThs = table.querySelectorAll('thead th');
        const stickyThs = stickyTable.querySelectorAll('thead th');
        if (!realThs.length || realThs.length !== stickyThs.length) return;

        for (let i = 0; i < realThs.length; i++) {
            const w = realThs[i].getBoundingClientRect().width;
            stickyThs[i].style.width = w + 'px';
        }
    }

    function syncStickyTableWidth() {
        // Ensure sticky table scroll range matches the real table
        stickyTable.style.width = table.getBoundingClientRect().width + 'px';
    }

    function updateStickyVisibility() {
        // Show sticky header only when page-scrolled past real header, but still within table height
        const rect = table.getBoundingClientRect();
        const stickyHeight = stickyHost.getBoundingClientRect().height || 0;
        const shouldShow = rect.top < 0 && rect.bottom > stickyHeight + 5;
        stickyHost.style.display = shouldShow ? 'block' : 'none';
    }

    function syncAllSizes() {
        syncTopWidth();
        syncStickyGeometry();
        syncStickyColumnWidths();
        syncStickyTableWidth();
        // keep horizontal alignment
        stickyInner.scrollLeft = main.scrollLeft;
    }

    // ---- Scroll syncing (top <-> main <-> sticky) ----
    top.addEventListener('scroll', () => {
        if (lock) return;
        lock = true;
        main.scrollLeft = top.scrollLeft;
        stickyInner.scrollLeft = top.scrollLeft;
        lock = false;
    });

    main.addEventListener('scroll', () => {
        if (lock) return;
        lock = true;
        top.scrollLeft = main.scrollLeft;
        stickyInner.scrollLeft = main.scrollLeft;
        lock = false;
    });

    stickyInner.addEventListener('scroll', () => {
        if (lock) return;
        lock = true;
        main.scrollLeft = stickyInner.scrollLeft;
        top.scrollLeft = stickyInner.scrollLeft;
        lock = false;
    });

    // ---- Init ----
    // Ensure sticky starts hidden (CSS should also set display:none by default)
    stickyHost.style.display = 'none';

    syncAllSizes();
    updateStickyVisibility();

    // ---- Resize / scroll / dynamic changes ----
    window.addEventListener('resize', () => {
        syncAllSizes();
        updateStickyVisibility();
    });

    window.addEventListener('scroll', () => {
        syncStickyGeometry();
        updateStickyVisibility();
    });

    const ro = new ResizeObserver(() => {
        syncAllSizes();
        updateStickyVisibility();
    });
    ro.observe(main);
    ro.observe(table);
}


// used to re-initiate datepicker in js datatable
// not running by default. should only be run after ajax or with livewire
// for re-initializing
function initDatePicker(){
    let datePickers = [].slice.call(d.querySelectorAll('[data-datepicker-live]'))
    datePickers.map(function (el) {
        let datePicker = new Datepicker(el, {
            buttonClass: 'btn',
            language:'de',
            calendarWeeks: true,
            autohide: true,
            title:el.getAttribute('data-date-title') ? el.getAttribute('data-date-title') : '',
        });

        // livewire event if datepicker is getting used in livewire component
        if(el.getAttribute('data-livewire-event')) {
            el.addEventListener('changeDate', function (e) {
                let livewireComponentID = el.closest('.livewire-datePicker').getAttribute('wire:id');
                let lw_component = Livewire.find(livewireComponentID);
                lw_component.call(el.getAttribute('data-livewire-event'), e.target.value);
            });
        }

        return datePicker;
    })
}

/**
 * show bootstrap toast
 *
 * @param {string} message Actual message.
 * @param {string} title The title of toast
 * @param {number} status 1:Success, 2:Danger, 3:Warning, 4:Info
 * @return {number}
 */
function showToast(message, title='', status = 1){

    Toast.setPlacement(TOAST_PLACEMENT.BOTTOM_RIGHT);
    Toast.setTheme(TOAST_THEME.DARK);
    //Toast.setMaxCount(1);
    //Toast.enableQueue(false);

    let configs = {
        animation: false,
        title: title,
        message: message || '',
        status: status,
        timeout: 3000,
    }
    Toast.create(configs);
}

function initShowUserProfile(){
    document.body.addEventListener('click', function (e) {
        if( e.target.classList.contains('showUserProfile')) {
            Livewire.dispatch('user:loadUserProfile');
        };
    });
}

// #################### Custom Functions ########################

// fallback function/hack to keep the sidebar sub items active
// if not already done from php
function sidebarActiveJs(){
    let subActive = document.querySelector('.sub-active') !== null;
    if(subActive) {
        document.querySelector('.sub-active').closest('.sidebarNav > li').classList.add('active');
        document.querySelector('.sub-active').closest('.multi-level').classList.add('show');
    }
}

// set html element value or text by id.
function setValueById(eleId, value, type='input'){
    if (document.getElementById(eleId)) {
        if(type === 'html'){
            document.getElementById(eleId).innerHTML = value
        } else {
            document.getElementById(eleId).value = value
        }
    }
}

// function to return value or default provided
// can be used to format values.
function valueOrDefault(value, defaultValue=''){
    return value || defaultValue;
}

function scrollFunction(backToTopButton) {
    if (
        document.body.scrollTop > 20 ||
        document.documentElement.scrollTop > 20
    ) {
        backToTopButton.style.display = "block";
    } else {
        backToTopButton.style.display = "none";
    }
}

function backToTop() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}

// bootstrap collapse: one the given collapse by id
function openOne(index)
{
    let myCollapse = document.getElementById('panelsStayOpen-collapse'+index);
    if(myCollapse) {
        let vac = new bootstrap.Collapse(myCollapse);
        if(vac) { vac.show(); }
    }

    // scrolling to the new added item
    let scrollEle = document.getElementById('panelsStayOpen-heading'+index);
    if(scrollEle) {
        setTimeout(() => {
            scrollEle.scrollIntoView({behavior: 'smooth', 'block': 'start', 'inline': 'start'});
        }, 300);
    }
}

// bootstrap collapse: close all present on the page
function closeAll() {
    [].slice.call(document.querySelectorAll('.collapse')).map(function (collapseEl) {
        let collapse = bootstrap.Collapse.getInstance(collapseEl);
        if(collapse) {
            collapse.hide();
        }
    })
}


/**
 * @deprecated Since new Connect portal. Not required anymore
 *
 * extract connect portal token out of global variable
 * defined by connect portal js in Head tag
 */
function getCPToken(prefix = '') {
    // connect portal token global variable. Defined by connect portal directly in header tag.
    // This is a workaround for connect portal to work with ajax OR JS.
    // Returns the connect portal token.

    if (typeof ur_baseurl === 'undefined' || !ur_baseurl) {
        return '';
    }

    let token = ur_baseurl;

    // extracting token out of connect portal base_url
    // removing first slash
    if(token.charAt(0) === '/') {
        token = token.slice(1).trim();
    }

    // extracting token out of string.
    return prefix + token.split('/')[0];
}

/**
 * @deprecated Since new Connect portal. Not required anymore
 */
function connectPortalURLConversion(url)
{
    // getting connect portal token
    let cpToken = getCPToken("/");

    if(!url || !cpToken){
        return url;
    }

    return cpToken + url;
}

/**
 * @deprecated Since new Connect portal. Not required anymore
 */
function connectPortalTokenToLivewire()
{
    // dispatching CP Token for any livewire component.
    Livewire.dispatch('setCPToken', { cp: getCPToken() });
}

