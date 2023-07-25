@extends('layouts.master')
@section('title')
    List Sale
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">List Sale</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered table-striped table-sale">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Date</th>
                            <th>Member Code</th>
                            <th>Total Item</th>
                            <th>Total Price</th>
                            <th>Discount</th>
                            <th>Total Pay</th>
                            <th>Cashier</th>
                            <th><i class="fas fa-cog"></i></th>
                        </tr>
                    </thead>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
@endsection

@includeIf('sale.detail')

@push('scripts')
    <script>
        let table, table1;

        $(function() {
            table = $('.table-sale').DataTable({
                processing: true,
                responsive: true,
                // lengthChange: false,
                autoWidth: false,
                // buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"]
                ajax: {
                    url: '{{ route('sale.data') }}'
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
                        data: 'member_code'
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
                        data: 'cashier'
                    },
                    {
                        data: 'action',
                        searchable: false,
                        sortable: false
                    },
                ]
            });

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
                        data: 'selling_price'
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
