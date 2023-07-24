@extends('layouts.master')
@section('title')
    Purchase Transaction
@endsection

@push('css')
    <style>
        .show-pay {
            font-size: 5em;
            text-align: center;
            height: 100px;
        }

        .show-counted {
            padding: 10px;
            background: #f0f0f0;
        }

        .table-purchase tbody tr:last-child {
            display: none;
        }

        @media(max-width:768px) {
            .show-pay {
                font-size: 3em;
                height: 70px;
                padding-top: 5px;
            }
        }
    </style>
@endpush

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Purchase Transaction</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <table>
                    <tr>
                        <td>Supplier</td>
                        <td>: {{ $supplier->name }}</td>
                    </tr>
                    <tr>
                        <td>Telephone</td>
                        <td>: {{ $supplier->telephone }}</td>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td>: {{ $supplier->address }}</td>
                    </tr>
                </table>
            </div>


            <!-- /.card-header -->
            <div class="card-body">

                <form action="" method="post" class="form-product">
                    @csrf
                    <div class="form-group row">
                        <label class="col-lg-1">Code Product</label>
                        <div class="col-lg-5">
                            <div class="input-group">
                                <input type="hidden" name="id_purchase" id="id_purchase" value="{{ $id_purchase }}">
                                <input type="hidden" name="id_product" id="id_product">
                                <input type="text" name="code" class="form-control" id="product_code">
                                <div class="input-group-append">
                                    <button onclick="showProduct()" class="btn btn-outline-info" type="button"
                                        id="button-addon2"><i class="fas fa-arrow-right"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <table class="table table-bordered table-striped table-purchase">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th width="10%">Amount</th>
                            <th>Subtotal</th>
                            <th><i class="fas fa-cog"></i></th>
                        </tr>
                    </thead>
                </table>

                <div class="row mt-3">
                    <div class="col-lg-8">
                        <div class="show-pay bg-info"></div>
                        <div class="show-counted"></div>
                    </div>
                    <div class="col lg-4">
                        <form action="{{ route('purchase.store') }}" class="form-purchase" method="post">
                            @csrf
                            <input type="hidden" name="id_purchase" value="{{ $id_purchase }}">
                            <input type="hidden" name="total" id="total">
                            <input type="hidden" name="total_item" id="total_item">
                            <input type="hidden" name="pay" id="pay">

                            <div class="form-group row">
                                <label class="col-lg-2 control-label">Total</label>
                                <div class="col-lg-8">
                                    <input type="text" id="totalrp" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 control-label">Discount</label>
                                <div class="col-lg-8">
                                    <input type="number" name="discount" id="discount" class="form-control"
                                        value="{{ $discount }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 control-label">Pay</label>
                                <div class="col-lg-8">
                                    <input type="text" id="payrp" class="form-control">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary btn-sm float-right btn-save"><i class="fas fa-save"></i>
                        Save Transaction</button>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
@endsection

@includeIf('purchase_detail.product')

@push('scripts')
    <script>
        let table, table2;

        $(function() {
            table = $('.table-purchase').DataTable({
                    processing: true,
                    responsive: true,
                    // lengthChange: false,
                    autoWidth: false,
                    // buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"]
                    buttons: false,
                    ajax: {
                        url: '{{ route('purchase_detail.data', $id_purchase) }}'
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            searchable: false,
                            sortable: false
                        },
                        {
                            data: 'code_product'
                        },
                        {
                            data: 'name_product'
                        },
                        {
                            data: 'purchase_price'
                        },
                        {
                            data: 'amount'
                        },
                        {
                            data: 'subtotal'
                        },
                        {
                            data: 'action',
                            searchable: false,
                            sortable: false
                        },
                    ],
                    dom: 'Brt',
                    bSort: false
                })
                .on('draw.dt', function() {
                    loadForm($('#discount').val());
                });

            table2 = $('.table-product').DataTable();

            $(document).on('input', '.quantity', function() {
                // console.log($(this).val());
                let id = $(this).data('id');
                let amount = parseInt($(this).val());

                if (amount < 1) {
                    $(this).val(1);
                    alert('the amount cant be less than 1');
                    return;
                }

                if (amount > 10000) {
                    $(this).val(10000);
                    alert('the amount cant be more than 10000');
                    return;
                }

                $.post(`{{ url('/purchase_detail') }}/${id}`, {
                        '_token': $('[name=csrf-token]').attr('content'),
                        '_method': 'put',
                        'amount': amount
                    })
                    .done((res) => {
                        $(this).on('mouseout', function() {
                            table.ajax.reload(function() {
                                loadForm($('#discount').val());
                            });
                        })
                    }).fail((err) => {
                        alert('cant store data!');
                        return;
                    })
            })

            $(document).on('input', '#discount', function() {
                if ($(this).val() == "") {
                    $(this).val(0).select();
                }

                loadForm($(this).val());
            })

            $('.btn-save').on('click', function() {
                $('.form-purchase').submit();
            })
        })

        function showProduct() {
            $('#modal-product').modal('show');
        }

        function hideProduct() {
            $('#modal-product').modal('hide');
        }

        function selectProduct(id, code) {
            $('#id_product').val(id);
            $('#product_code').val(code);
            hideProduct();
            addProduct();
        }

        function addProduct() {
            $.post('{{ route('purchase_detail.store') }}', $('.form-product').serialize())
                .done((res) => {
                    $('#product_code').focus();
                    table.ajax.reload(function() {
                        loadForm($('#discount').val());
                    })
                }).fail((err) => {
                    console.log('err: ', err);
                    alert('cant store data!');
                    return;
                })
        }

        function deleteData(url) {
            if (confirm('Sure delete this data?')) {
                $.post(url, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'delete'
                }).done((res) => {
                    table.ajax.reload(function() {
                        loadForm($('#discount').val());
                    })
                }).fail((err) => {
                    alert('Cant delete data!');
                    return;
                })
            }
        }

        function loadForm(discount = 0) {
            $('#total').val($('.total').text());
            $('#total_item').val($('.total_item').text());

            $.get(`{{ url('/purchase_detail/loadform/') }}/${discount}/${$('.total').text()}`)
                .done(res => {
                    $('#totalrp').val('Rp. ' + res.totalrp)
                    $('#payrp').val('Rp. ' + res.payrp)
                    $('#pay').val(res.pay)
                    $('.show-pay').text('Rp. ' + res.payrp)
                    $('.show-counted').text(res.terbilang)
                }).fail(err => {
                    alert('unable to display data!');
                    return;
                })
        }
    </script>
@endpush
