<div class="modal fade" id="modal-form">
    <div class="modal-dialog">
        <form action="{{}}" method="post" class="form-horizontal" enctype="multipart/form-data">
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
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" required autofocus>
                        <span class="help-block with-errors"></span>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                        <span class="help-block with-errors"></span>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                        <span class="help-block with-errors"></span>
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="form-control" data-match="#password" required>
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
