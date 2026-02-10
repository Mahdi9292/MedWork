@section('styles')
    @parent

    @include('components.datatable.styles')
@endsection

@section('pageScripts')
    @parent

    @include('components.datatable.scripts')

    <script type="text/javascript">
        $(function () {
            let table = null;
            @if ($slot->isNotEmpty())
                {!! $slot !!}
            @else

                table = $('.jsDataTable').DataTable({
                    fixedHeader: true,
                    scrollX: true,
                    keys: true,
                    stateSave: true,
                    stateDuration: 0,
                    colReorder: true,
                    lengthChange: false,
                    autoWidth: true,
                    @if($lengthMenu)
                        lengthMenu: [{!! $lengthMenu !!}, {!! $lengthMenu !!}],
                    @endif
                    dom: 'Bfrtip',
                    @if(isset($buttons))
                        {!! Str::remove(['<script>', '</script>', 'DataTable(({', '}))'], $buttons);  !!},
                    @else
                        buttons: [
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
                                className: 'btn-offwhite'
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
                                className: 'btn-offwhite'
                            },
                            {
                                extend:    'colvis',
                                text:      '<i class="fas fa-columns"></i>',
                                titleAttr: 'Export to PDF',
                                className: 'btn-offwhite'
                            },
                            {
                                extend:    'pageLength',
                                text:      '<i class="fas fa-chevron-circle-down"></i>',
                                titleAttr: 'Export to PDF',
                                className: 'btn-offwhite'
                            },
                        ],
                    @endif
                    @isset($customOptions)
                        {!! Str::remove(['<script>', '</script>', 'DataTable(({', '}))'], $customOptions);  !!},
                    @endisset
                });
            @endif

            @if ($selectableRow ?? null)
                $('.jsDataTable tbody').on( 'click', 'tr', function () {
                    if ( $(this).hasClass('selected') ) {
                        $(this).removeClass('selected');
                    }
                    else {
                        table.$('tr.selected').removeClass('selected');
                        $(this).addClass('selected');
                    }
                } );
            @endif
        });
    </script>

@endsection
