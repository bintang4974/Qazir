{{-- <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default">
    Launch Default Modal
</button> --}}

<div class="modal fade" id="modal-product">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Pilih Product</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-bordered table-product">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Purchase Price</th>
                            <th><i class="fas fa-cog"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($product as $key => $item)
                            <tr>
                                <td width="5%">{{ $key + 1 }}</td>
                                <td><span class="badge badge-secondary">{{ $item->code }}</span></td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->purchase_price }}</td>
                                <td>
                                    <a href="#"
                                        onclick="selectProduct('{{ $item->id }}', '{{ $item->code }}')"
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
