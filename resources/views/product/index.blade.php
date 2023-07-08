@extends('layouts.master')
@section('title')
    Product
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Product</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <button onclick="addForm('{{ route('product.store') }}')" class="btn btn-primary btn-sm"><i
                        class="fas fa-plus"></i> Tambah</button>
                <button onclick="deleteSelected('{{ route('product.delete_selected') }}')" class="btn btn-danger btn-sm"><i
                        class="fas fa-trash"></i> Delete</button>
                <button onclick="printBarcode('{{ route('product.print_barcode') }}')" class="btn btn-info btn-sm"><i
                        class="fas fa-barcode"></i> Barcode</button>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form action="" method="post" class="form-product">
                    @csrf
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><input type="checkbox" name="select_all" id="select_all"></th>
                                <th width="5%">No</th>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Brand</th>
                                <th>Purchase Price</th>
                                <th>Selling Price</th>
                                <th>Discount</th>
                                <th>Stock</th>
                                <th><i class="fas fa-cog"></i></th>
                            </tr>
                        </thead>
                    </table>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
    @includeIf('product.form')
@endsection


@push('scripts')
    <script>
        let table;

        $(function() {
            table = $('.table').DataTable({
                processing: true,
                responsive: true,
                // lengthChange: false,
                autoWidth: false,
                // buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"]
                ajax: {
                    url: '{{ route('product.data') }}'
                },
                columns: [{
                        data: 'select_all'
                    },
                    {
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'code'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'category'
                    },
                    {
                        data: 'brand'
                    },
                    {
                        data: 'purchase_price'
                    },
                    {
                        data: 'selling_price'
                    },
                    {
                        data: 'discount'
                    },
                    {
                        data: 'stock'
                    },
                    {
                        data: 'action',
                        searchable: false,
                        sortable: false
                    },
                ]
            });

            $('#modal-form').validator().on('submit', function(e) {
                if (!e.preventDefault()) {
                    $.ajax({
                        type: 'post',
                        url: $('#modal-form form').attr('action'),
                        data: $('#modal-form form').serialize()
                    }).done((res) => {
                        $('#modal-form').modal('hide');
                        table.ajax.reload();
                    }).fail((err) => {
                        console.log(err);
                        alert('cant store data!');
                        return;
                    })
                }
            })

            $('[name=select_all]').on('click', function() {
                $(':checkbox').prop('checked', this.checked);
            })
        })

        function addForm(url) {
            $('#modal-form').modal('show');
            $('#modal-form .modal-title').text('Add Product');

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('post');
            $('#modal-form [name=name]').focus();

        }

        function editForm(url) {
            $('#modal-form').modal('show');
            $('#modal-form .modal-title').text('Edit Product');

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('put');
            $('#modal-form [name=name]').focus();

            $.get(url).done((res) => {
                $('#modal-form [name=category_id]').val(res.category_id);
                $('#modal-form [name=name]').val(res.name);
                $('#modal-form [name=brand]').val(res.brand);
                $('#modal-form [name=purchase_price]').val(res.purchase_price);
                $('#modal-form [name=discount]').val(res.discount);
                $('#modal-form [name=selling_price]').val(res.selling_price);
                $('#modal-form [name=stock]').val(res.stock);
            }).fail((err) => {
                alert('Cant show data!');
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

        function deleteSelected(url) {
            if ($('input:checked').length > 1) {
                if (confirm('Sure delete this data?')) {
                    $.post(url, $('.form-product').serialize())
                        .done((res) => {
                            table.ajax.reload()
                        })
                        .fail((err) => {
                            alert('Cant delete data!')
                            return
                        })
                }
            } else {
                alert('select the data to be deleted!');
                return
            }
        }

        function printBarcode(url) {
            if ($('input:checked').length < 1) {
                alert('select the data to be printed!');
                return
            } else if (($('input:checked').length < 3)) {
                alert('select minimun 3 data!');
                return
            } else {
                $('.form-product').attr('action', url).attr('target', '_blank').submit()
            }
        }
    </script>
@endpush
