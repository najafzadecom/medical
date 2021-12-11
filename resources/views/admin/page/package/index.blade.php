@extends('admin.layout.app')
@section('title', 'Qablaşdırma')
@section('content')
    <!-- Content area -->
    <div class="content">
        <div class="card">
            <div class="card-header bg-transparent header-elements-inline py-0">
                <h6 class="card-title py-3">Paketlər</h6>
                <div class="header-elements">
                    @can('package-create')
                        <a href="{{ route('package.create') }}" class="btn btn-success"><i class="icon-plus2"></i> Yeni</a>
                    @endcan
                </div>
            </div>

            @if(session('message'))
                <div class="alert alert-success border-0 alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
                    {{ session('message') }}
                </div>
            @endif

            <table class="table table-xs table-striped table-bordered table-hovered data-table">
                <thead>
                <tr>
                    <th><input type="number" name="primary_key" id="primary_key" class="form-control" placeholder="ID"></th>
                    <th><input type="text" name="name" id="name" class="form-control" placeholder="Adı"></th>
                    <th></th>
                </tr>
                <tr>
                    <th width="150">ID</th>
                    <th>Adı</th>
                    <th width="100"><i class="icon-grid"></i></th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>

        </div>
    </div>
    <!-- /content area -->

    <script type="text/javascript">
        let Datatables = function() {

            let _componentDatatableButtons = function() {
                if (!$().DataTable) {
                    console.warn('Warning - datatables.min.js is not loaded.');
                    return;
                }

                $.extend($.fn.dataTable.defaults, {
                    processing: true,
                    serverSide: true,
                    searching: false,
                    buttons: {
                        buttons: [
                            {extend: 'copy', text: '<i class="icon-copy4"></i> Kopyala'},
                            {extend: 'excel', text: '<i class="icon-file-excel"></i> Excel'},
                            {extend: 'print', text: '<i class="icon-printer2"></i> Çap et', autoPrint: false},
                        ],
                        dom: {
                            button: {
                                className: 'btn btn-light'
                            }
                        },
                    },
                    autoWidth: false,
                    dom: '<"datatable-header"fBl><"datatable-scroll-wrap"t><"datatable-footer"ip>',
                    "language":{
                        "sEmptyTable":"Tabloda məlumat tapılmadı",
                        "sInfo":"_START_ ilə _END_ arasında _TOTAL_ qədər məlumat göstərilir",
                        "sInfoEmpty":"0 -ilə 0 arasında 0 qədər məlumat göstərilir",
                        "sInfoFiltered":"(cəmi _MAX_ məlumat filterləndi)",
                        "sInfoPostFix":"","sInfoThousands":",",
                        "sLengthMenu":"<span>Göstər:</span> _MENU_ ",
                        "sLoadingRecords":"Yüklənir...",
                        "sProcessing":"Qenerasiya olunur...",
                        "sSearch":"Axtar:",
                        "sZeroRecords":"Uyğun məlumat tapılmadı","oPaginate":{"sFirst":"Birinci","sLast":"Sonuncu","sNext":"Növbəti","sPrevious":"Əvvəlki"},"oAria":{"sSortAscending":": sütunu artan sıralamaq üçün aktivləşdirin","sSortDescending":": sütunu azalan sıralamaq üçün aktivləşdirin"}
                    }
                });

                // Apply custom style to select
                $.extend($.fn.dataTableExt.oStdClasses, {
                    "sLengthSelect": "custom-select"
                });

                $('.data-table').DataTable({
                    ajax: {
                        url: "{{ route('package.index') }}",
                        type: 'GET',
                        data: function (d) {
                            d.name = $('#name').val();
                            d.primary_key = $('#primary_key').val();
                        }
                    },
                    columns: [
                        {data: 'id', name: 'id'},
                        {data: 'name', name: 'name'},
                        {data: 'action', name: 'action', orderable: true, searchable: true},
                    ]
                });

            };

            return {
                init: function() {
                    _componentDatatableButtons();
                }
            }
        }();

        document.addEventListener('DOMContentLoaded', function() {
            Datatables.init();
        });

        $('#name, #primary_key').on('keyup change clear', function(){
            $('.data-table').DataTable().draw(true);
        });
    </script>
@endsection
