@extends('layouts.master')
@section('title')
    Purchase Transaction
@endsection

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
                            <th>Amount</th>
                            <th>Subtotal</th>
                            <th><i class="fas fa-cog"></i></th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
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
                ]
            });

            table2 = $('.table-product').DataTable();
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
                    table.ajax.reload()
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
                    table.ajax.reload()
                }).fail((err) => {
                    alert('Cant delete data!');
                    return;
                })
            }
        }
    </script>
@endpush
