@extends('layouts.master')
@section('title')
    Purchase
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Purchase</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <button onclick="addForm()" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> New Transaction</button>
                @empty(!session('id_purchase'))
                    <a href="{{ route('purchase_detail.index') }}" class="btn btn-info btn-sm"><i class="fas fa-plus"></i>
                        Transaction Active</a>
                @endempty
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered table-striped table-purchase">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Date</th>
                            <th>Supplier</th>
                            <th>Total Item</th>
                            <th>Total Price</th>
                            <th>Discount</th>
                            <th>Total Pay</th>
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

@includeIf('purchase.supplier')
@includeIf('purchase.detail')

@push('scripts')
    <script>
        let table, table1;

        $(function() {
            table = $('.table-purchase').DataTable({
                processing: true,
                responsive: true,
                // lengthChange: false,
                autoWidth: false,
                // buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"]
                ajax: {
                    url: '{{ route('purchase.data') }}'
                },
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'date'
                    },
                    {
                        data: 'supplier'
                    },
                    {
                        data: 'total_item'
                    },
                    {
                        data: 'total_price'
                    },
                    {
                        data: 'discount'
                    },
                    {
                        data: 'payment'
                    },
                    {
                        data: 'action',
                        searchable: false,
                        sortable: false
                    },
                ]
            });

            $('.table-supplier').DataTable();
            table1 = $('.table-detail').DataTable({
                processing: true,
                bsort: false,
                dom: 'Brt',
                columns: [{
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
                        data: 'purchase_price'
                    },
                    {
                        data: 'amount'
                    },
                    {
                        data: 'subtotal'
                    },
                ]
            });
        })

        function addForm() {
            $('#modal-supplier').modal('show');
        }

        function showDetail(url) {
            $('#modal-detail').modal('show');

            table1.ajax.url(url);
            table1.ajax.reload();
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
