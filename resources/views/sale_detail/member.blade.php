{{-- <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default">
    Launch Default Modal
</button> --}}

<div class="modal fade" id="modal-member">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Pilih Member</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-bordered table-member">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Telephone</th>
                            <th>Address</th>
                            <th><i class="fas fa-cog"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($member as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->telephone }}</td>
                                <td>{{ $item->address }}</td>
                                <td>
                                    <a href="#"
                                        onclick="selectMember('{{ $item->id }}', '{{ $item->code }}')"
                                        class="btn btn-info btn-sm"><i class="fas fa-check-circle"></i>
                                        Select</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
