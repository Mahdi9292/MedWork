@section('styles')
    @parent

    @include('components.datatable.styles')
@endsection

@section('pageScripts')
    @parent

    @include('components.datatable.scripts')

    <script type="text/javascript">

        let table = null;

        $(function () {

            // TODO:: Compatibility for URLs returning from AJAX calls with connect portal.
            // connect portal token global variable. Defined by connect portal directly in header tag.
            // Please don't remove. This is a work around for connect portal to work with ajax.
            if (typeof ur_baseurl === 'undefined') {
                ur_baseurl = '';
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    'CP-TOKEN': ur_baseurl
                }
            });

            // to add customer parameters to ajax call
            function ajaxData(){
                @isset($additionalAttributes)
                    return {!! $additionalAttributes !!}
                @endisset
            }

            @if ($slot->isNotEmpty())
                {!! $slot !!}
            @else
                table = $('.jsDataTable').DataTable({
                    processing: true,
                    serverSide: true,
                    stateSave: true,
                    stateDuration: 0,
                    responsive: {!! $responsive !!},
                    scrollX: true,
                    @if($scrollY)
                        scrollY: {!! $scrollY !!},
                    @endif
                    scrollCollapse: true,
                    colReorder: true,
                    fixedHeader: {!! $fixedHeader !!},
                    autoWidth: {!! $autoWidth !!},
                    lengthChange: false,
                    iDisplayLength: {{ $pageLength }},
                    @if($lengthMenu)
                        lengthMenu: [{!! $lengthMenu !!}, {!! $lengthMenu !!}],
                    @endif
                    ajax: {
                        url:"{!! $ajaxURL !!}",
                        type:"POST",
                        data: function ( d ) {
                            $.extend(d,ajaxData());
                        },
                    },
                    dom: 'Bfrtip',
                    @if(isset($buttons))
                        {!! Str::remove(['<script>', '</script>', 'DataTable(({', '}))'], $buttons);  !!},
                    @else
                        buttons: [
                            @if($exportButtons)
                                {
                                    extend:    'copyHtml5',
                                    text:      '<i class="fas fa-copy"></i>',
                                    titleAttr: 'Copy Data',
                                    className: 'btn-offwhite'
                                },
                                {
                                    extend:    'excelHtml5',
                                    text:      '<i class="fas fa-file-excel"></i>',
                                    titleAttr: 'Export to Excel',
                                    className: 'btn-offwhite',
                                },
                                {
                                    extend:    'csvHtml5',
                                    text:      '<i class="fas fa-file-csv"></i>',
                                    titleAttr: 'Export to CSV',
                                    className: 'btn-offwhite'
                                },
                                {
                                    extend:    'pdfHtml5',
                                    text:      '<i class="fas fa-file-pdf"></i>',
                                    titleAttr: 'Export to PDF',
                                    className: 'btn-offwhite',
                                    exportOptions: {
                                        columns: ':visible',
                                    }
                                },
                            @endif
                            {
                                extend:    'colvis',
                                text:      '<i class="fas fa-columns"></i>',
                                titleAttr: 'Hide Columns',
                                className: 'btn-offwhite'
                            },
                            {
                                extend:    'pageLength',
                                text:      '<i class="fas fa-chevron-circle-down"></i>',
                                titleAttr: 'Items Per Page',
                                className: 'btn-offwhite'
                            },
                        ],
                    @endif

                    language: {
                        "processing": '{{ __('Bitte Warten') }}',
                        "url": "{{ asset('/assets/vendor/datatables/js/German.json') }}"
                    },
                    columns: [
                        @isset($columns)
                            {!! $columns !!},
                        @endisset
                        @if($cols)
                            @foreach ($cols as $col)
                                {
                                    data: "{{ $col['data'] }}",
                                    name: "{{ $col['name'] }}",
                                    orderable: {!! $col['orderable'] ?? 'true' !!},
                                    searchable: {!! $col['searchable'] ?? 'true' !!},
                                },
                            @endforeach
                        @endif
                        @if($hasActionCol)
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                        @endif
                    ],
                    "columnDefs": [
                        @if($hasActionCol)
                            { className: "text-end-td", "targets": [ -1 ]},
                            { responsivePriority: 101, targets: -1 },
                        @endif
                        { responsivePriority: 100, targets: {{ $priorityCol }} },
                        @if(isset($columnDefinitions))
                            {!! Str::remove(['<script>', '</script>', 'DataTable(', ')'], $columnDefinitions);  !!}
                        @endif
                    ],
                    @isset($customOptions)
                        {!! Str::remove(['<script>', '</script>', 'DataTable(({', '}))'], $customOptions);  !!},
                    @endisset
                });
            @endif

            @if(isset($postScript))
                {!! Str::remove(['<script>', '</script>'], $postScript);  !!}
            @endif
        });

    </script>

@endsection
