<div class="modal fade" id="modal-form">
    <div class="modal-dialog">
        <form action="{{ route('report.index') }}" method="get" class="form-horizontal">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Report Period</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Start Date:</label>
                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                            <input type="text" name="start_date" id="start_date"
                                class="form-control datetimepicker-input" data-target="#reservationdate"
                                value="{{ request('start_date') }}" required />
                            <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>End Date:</label>
                        <div class="input-group date" id="reservationdate2" data-target-input="nearest">
                            <input type="text" name="end_date" id="end_date"
                                class="form-control datetimepicker-input" data-target="#reservationdate2"
                                value="{{ request('end_date') }}" required />
                            <div class="input-group-append" data-target="#reservationdate2"
                                data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
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
