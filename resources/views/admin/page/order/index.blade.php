@extends('admin.layout.app')
@section('title', 'Sifarişlər')
@section('content')
    <!-- Content area -->
    <div class="content">
        <div class="card">
            <div class="card-header">
                <input class="form-control" type="text" name="order_id" id="order_id" value="" placeholder="Barkod oxuyucu" autofocus>
            </div>
            <div class="card-header bg-transparent header-elements-inline py-0">
                <h6 class="card-title py-3">Sifarişlər</h6>
                <div class="header-elements">
                    @can('order-create')
                        <a href="{{ route('order.create') }}" class="btn btn-success"><i class="icon-plus2"></i> Yeni</a>
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
                    <th><input type="text" name="number" id="number" class="form-control" placeholder=""></th>
                    <th><input type="text" name="date" id="date" class="form-control" placeholder=""></th>
                    <th><input type="text" name="temperature" id="temperature" class="form-control" placeholder=""></th>
                    <th><input type="text" name="sample_type" id="sample_type" class="form-control" placeholder=""></th>
                    <th><input type="text" name="order_number" id="order_number" class="form-control" placeholder=""></th>
                    <th><input type="text" name="country" id="country" class="form-control" placeholder=""></th>
                    <th><input type="text" name="package" id="package" class="form-control" placeholder=""></th>
                    <th><input type="text" name="weight" id="weight" class="form-control" placeholder=""></th>
                    <th><input type="text" name="production_date" id="production_date" class="form-control" placeholder=""></th>
                    <th><input type="text" name="expire_date" id="expire_date" class="form-control" placeholder=""></th>
                    <th><input type="text" name="release_date" id="release_date" class="form-control" placeholder=""></th>
                    <th><input type="text" name="customer" id="customer" class="form-control" placeholder=""></th>
                    <th></th>
                    <th></th>
                </tr>
                <tr>
                    <th width="150">ID</th>
                    <th>Laboratoriyada nümunənin qeydiyyat nömrəsi</th>
                    <th>Nümunənin qəbul tarixi/vaxtı</th>
                    <th>Nümunənin laboratoriyaya daxil olma zamanı temperaturu</th>
                    <th>Məktubun Nömrəsi, nümunənin növü</th>
                    <th>Sifariş №</th>
                    <th>Ölkə</th>
                    <th>Qablaşdırma</th>
                    <th>Nümunənin miqdarı</th>
                    <th>Nümunənin istehsal tarixi</th>
                    <th>Nümunənin son istifadə tarixi</th>
                    <th>Sınaq protokolunun çıxma tarixi</th>
                    <th>Sifarişçi</th>
                    <th>BARCODE</th>
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
        var input = document.getElementById("order_id");
        input.addEventListener("keyup", function(event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                window.location.href = 'order/'+input.value+'/edit';
            }
        });

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
                        url: "{{ route('order.index') }}",
                        type: 'GET',
                        data: function (d) {
                            d.primary_key = $('#primary_key').val();
                            d.number = $('#number').val();
                            d.date = $('#date').val();
                            d.temperature = $('#temperature').val();
                            d.sample_type = $('#sample_type').val();
                            d.order_number = $('#order_number').val();
                            d.country = $('#country').val();
                            d.package = $('#package').val();
                            d.weight = $('#weight').val();
                            d.production_date = $('#production_date').val();
                            d.expire_date = $('#expire_date').val();
                            d.release_date = $('#release_date').val();
                            d.customer = $('#customer').val();
                        }
                    },
                    columns: [
                        {data: 'id', name: 'id'},
                        {data: 'number', name: 'number'},
                        {data: 'date', name: 'date'},
                        {data: 'temperature', name: 'temperature'},
                        {data: 'sample_type', name: 'sample_type'},
                        {data: 'order_number', name: 'order_number'},
                        {data: 'country', name: 'country'},
                        {data: 'package', name: 'package'},
                        {data: 'weight', name: 'weight'},
                        {data: 'production_date', name: 'production_date'},
                        {data: 'expire_date', name: 'expire_date'},
                        {data: 'release_date', name: 'release_date'},
                        {data: 'customer', name: 'customer'},
                        {data: 'barcode', name: 'barcode'},
                        {data: 'action', name: 'action', orderable: true, searchable: true},
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

        $('#title, #primary_key, #status, #customer, #book, #date').on('keyup change clear', function(){
            $('.data-table').DataTable().draw(true);
        });


    </script>
@endsection
