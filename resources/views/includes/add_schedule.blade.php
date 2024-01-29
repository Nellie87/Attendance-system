<!-- Add -->
<div class="modal fade" id="addnew">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Set a New Schedule</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body text-left">
                <form class="form-horizontal" method="POST" action="{{ route('schedule.store') }}">
                @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                    @csrf
                   
                    <!--
                    <div class="form-group">
                        <label for="time_in" class="col-sm-3 control-label">Time In</label>
                        <div class="bootstrap-timepicker">
                            <input type="time" class="form-control timepicker" id="time_in" name="time_in" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="time_out" class="col-sm-3 control-label">Time Out</label>
                        <div class="bootstrap-timepicker">
                            <input type="time" class="form-control timepicker" id="time_out" name="time_out" required>
                        </div>
                    </div> -->
                    <!-- New Fields for Fellowship and Leader -->
                    <div class="form-group">
                        <label for="fellowship" class="col-sm-3 control-label">Fellowship</label>
                        <input type="text" class="form-control" id="fellowship" name="fellowship" placeholder="Enter Fellowship">
                    </div>
                    <div class="form-group">
                        <label for="leader" class="col-sm-3 control-label">Leader</label>
                        <input type="text" class="form-control" id="leader" name="leader" placeholder="Enter Leader">
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-6 control-label">Estates <i>{separate with dashes}</i></label>
                        <div class="bootstrap-timepicker">
                            <input type="text" placeholder="Enter estates included" class="form-control timepicker" id="name" name="slug">
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-save"></i> Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
