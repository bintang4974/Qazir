@extends('layouts.master')
@section('title')
    Income Report {{ tanggal_indonesia($startDate, false) }} - {{ tanggal_indonesia($endDate, false) }}
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Report</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <button onclick="updatePeriod()" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Change
                    Period</button>
                {{-- <a href="{{ route('report.export_pdf', [$startDate, $endDate]) }}" target="_blank"
                    class="btn btn-info btn-sm"><i class="fas fa-plus"></i> Export PDF</a> --}}
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Date</th>
                            <th>Sale</th>
                            <th>Purchase</th>
                            <th>Expenditure</th>
                            <th>Income</th>
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

@includeIf('report.form')

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
                    url: '{{ route('report.data', [$startDate, $endDate]) }}'
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
                        data: 'sale'
                    },
                    {
                        data: 'purchase'
                    },
                    {
                        data: 'expenditure'
                    },
                    {
                        data: 'income'
                    },
                ],
                dom: 'Brt',
                bSort: false,
                bPaginate: false
            });

            $('#reservationdate').datetimepicker({
                format: 'YYYY-MM-DD',
                autoclose: true
            });
            $('#reservationdate2').datetimepicker({
                format: 'YYYY-MM-DD',
                autoclose: true
            });
        })

        function updatePeriod() {
            $('#modal-form').modal('show');
        }
    </script>
@endpush
