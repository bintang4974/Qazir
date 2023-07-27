@extends('layouts.master')
@section('title')
    Category
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Category</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <button onclick="addForm('{{ route('category.store') }}')" class="btn btn-primary btn-sm"><i
                        class="fas fa-plus"></i> Tambah</button>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Category Name</th>
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

@includeIf('category.form')

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
                    url: '{{ route('category.data') }}'
                },
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'name'
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
                        alert('cant store data!');
                        return;
                    })
                }
            })
        })

        function addForm(url) {
            $('#modal-form').modal('show');
            $('#modal-form .modal-title').text('Add Category');

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('post');
            $('#modal-form [name=name]').focus();

        }

        function editForm(url) {
            $('#modal-form').modal('show');
            $('#modal-form .modal-title').text('Edit Category');

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('put');
            $('#modal-form [name=name]').focus();

            $.get(url).done((res) => {
                $('#modal-form [name=name]').val(res.name);
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
    </script>
@endpush
