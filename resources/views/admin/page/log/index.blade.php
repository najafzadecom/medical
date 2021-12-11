@extends('admin.layout.app')
@section('title', 'Loqlar')
@section('content')
    <!-- Content area -->
    <div class="content">
        <div class="card">
            <div class="card-header bg-transparent header-elements-inline py-0">
                <h6 class="card-title py-3">Loqlar</h6>
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
                    <th><input type="text" name="description" id="description" class="form-control" placeholder=""></th>
                    <th><input type="text" name="causer" id="causer" class="form-control" placeholder=""></th>
                    <th><input type="text" name="subject" id="subject" class="form-control" placeholder=""></th>
                </tr>
                <tr>
                    <th width="150">ID</th>
                    <th>Açıqlama</th>
                    <th>İstifadəçi</th>
                    <th>Subyekt</th>
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
                    },
                    scrollX: true,
                });

                // Apply custom style to select
                $.extend($.fn.dataTableExt.oStdClasses, {
                    "sLengthSelect": "custom-select"
                });

                $('.data-table').DataTable({
                    ajax: {
                        url: "{{ route('log.index') }}",
                        type: 'GET',
                        data: function (d) {
                            d.primary_key = $('#primary_key').val();
                            d.causer = $('#causer').val();
                        }
                    },
                    columns: [
                        {data: 'id', name: 'id'},
                        {data: 'description', name: 'description'},
                        {data: 'causer.name', name: 'causer'},
                        {data: 'subject', name: 'subject', orderable: true, searchable: true},
                    ],
                    search: {
                        "regex": true
                    }
                });

                $('.data-table').DataTable().draw(true);

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

        $('#primary_key').on('keyup change clear', function(){
            $('.data-table').DataTable().draw(true);
        });


    </script>
@endsection
