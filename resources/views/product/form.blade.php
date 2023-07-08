{{-- <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default">
    Launch Default Modal
</button> --}}

<div class="modal fade" id="modal-form">
    <div class="modal-dialog">
        <form action="" method="post" class="form-horizontal">
            @csrf
            @method('post')

            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Product Name</label>
                        <input type="text" name="name" class="form-control" required autofocus>
                        <span class="help-block with-errors"></span>
                    </div>
                    <div class="form-group">
                        <label>Product Category</label>
                        <select name="category_id" class="form-control" required>
                            <option value="">-- Choose Category --</option>
                            @foreach ($category as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
                            @endforeach
                        </select>
                        <span class="help-block with-errors"></span>
                    </div>
                    <div class="form-group">
                        <label>Brand</label>
                        <input type="text" name="brand" class="form-control">
                        <span class="help-block with-errors"></span>
                    </div>
                    <div class="form-group">
                        <label>Purchase Price</label>
                        <input type="number" name="purchase_price" class="form-control" required>
                        <span class="help-block with-errors"></span>
                    </div>
                    <div class="form-group">
                        <label>Selling Price</label>
                        <input type="number" name="selling_price" class="form-control" required>
                        <span class="help-block with-errors"></span>
                    </div>
                    <div class="form-group">
                        <label>Discount</label>
                        <input type="number" name="discount" class="form-control" value="0">
                        <span class="help-block with-errors"></span>
                    </div>
                    <div class="form-group">
                        <label>Stock</label>
                        <input type="number" name="stock" class="form-control" required value="0">
                        <span class="help-block with-errors"></span>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-sm btn-primary">Save</button>
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
