<!-- Add -->
<!-- Add this in the head section of your HTML -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<div class="modal fade" id="addnew">

    <div class="modal-dialog">
        <div class="modal-content">
        
            <div class="modal-header">
            <h5 class="modal-title"><b>Add New Employee</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>

            </div>

            
            <div class="modal-body">

     <div class="card-body text-left">

                    <form method="post" action="{{ route('employees.store') }}" enctype="multipart/form-data">
       <!-- Add the following snippet inside your form -->
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
                        <div class="form-group">


                            <label for="name">Name <i>{without any space & at least 3 characters}</i></label>
                            <input type="text" class="form-control" placeholder="Enter a Employee name [hyphen accepted]" id="name" name="name"
                                required />
                        </div>
                        <div class="form-group">
                            <label for="position">Position <i>{without any space & at least 3 characters}</i></label>
                            <input type="text" class="form-control" placeholder="Enter Employee's Position [hyphen accepted]" id="position" name="position"
                                required />
                        </div>

                        
                        <div class="form-group">
                            <label for="contact" class="col-sm-3 control-label">Contact</label>


                            <input type="tel" class="form-control" id="contact" name="contact">

                        </div>
                       
                        <div class="form-group">
                            <label for="fellowship" class="col-sm-3 control-label">Fellowship</label>


                            <select class="form-control" id="fellowship" name="fellowship" required>
                                <option value="" selected>- Select -</option>
                                @foreach($schedules as $schedule)
                                <option value="{{$schedule->fellowship}}">{{$schedule->fellowship}}  </option>
                                @endforeach

                            </select>

                        </div>


                        <div class="form-group">    
                            <div>
                               

                           <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-save"></i> Save</button>

                                <button type="reset" class="btn btn-danger waves-effect m-l-5" data-dismiss="modal">Cancel</button>
                                
                            </div>
                        </div>
                 
                        </form>

                </div>
            </div>

        </div>

    </div>
</div>
</div>