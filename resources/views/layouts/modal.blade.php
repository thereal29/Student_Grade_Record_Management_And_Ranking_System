<div class="modal fade" id="school_year" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
        <div class="modal-header p-2" style="background-color: #05300e; color:#fff;">
            <h5 class="modal-title" style="color:#fff;" id="exampleModalLabel">Select School Year</h5>
        </div>        
        <div class="modal-body">
        @if(auth()->user()->role == 'Administrator')
        <form action="{{ route('admin.dashboard') }}" class="form-horizontal" method="POST">
        @else
        <form action="{{ action('App\Http\Controllers\TeacherController\DashboardController@index') }}" class="form-horizontal" method="POST">
        @endif
        @csrf
            <div class="form-group">
                <select name="schoolyear" id="schoolyears" class="syselect1" data-width="100%" required>
                <option value="" selected disabled>Please Select</option>
                @foreach($sy as $s_y)
                <option class="font-weight-bold" value="{{ $s_y['from_year'] }}">S.Y. {{$s_y->from_year.'-'.$s_y->to_year}}</option>
                @endforeach
                </select>
            </div>
            
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Select</button>
        </div>
        </form>
        </div>
    </div>
</div>

<div class="modal fade" id="changeSY" role="dialog" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
        <div class="modal-header p-2" style="background-color: #05300e; color:#fff;">
            <h5 class="modal-title" style="color:#fff;" id="exampleModalLabel">Select School Year</h5>
        </div>      
        <div class="modal-body">
        @if(auth()->user()->role == 'Administrator')
        <form action="{{ action('App\Http\Controllers\AdminController\DashboardController@index') }}" class="form-horizontal" method="POST">
        @else
        <form action="{{ action('App\Http\Controllers\TeacherController\DashboardController@index') }}" class="form-horizontal" method="POST">
        @endif
        @csrf
            <div class="form-group">
                <select name="schoolyear" id="schoolyear" class="syselect2" data-width="100%" required>
                <option value="" selected disabled>Please Select</option>
                @foreach($sy as $s_y)
                    <option class="font-weight-bold" value="{{ $s_y['from_year'] }}">S.Y. {{$s_y->from_year.'-'.$s_y->to_year}}</option>
                @endforeach
                </select>
            </div>
            
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Select</button>
        </div>
        </form>
        </div>
    </div>
</div>

<!-- Add New Curriculum Modal -->
<div class="modal fade" id="addnewcurriculum" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-success bg-gradient text-white">
        <h5 class="modal-title" id="exampleModalLabel">Subject Details</h5>
      </div>
      
      <div class="modal-body">
      <form action="#" id="addCurriculum" class="form-horizontal" method="POST">
      @csrf
        <div class="form-row">
            <div class="form-group col-md-12">
                <label class="col-xs-5 control-label" for="subjectname">Subject Code</label>  
                <input id="subjectcode" class="form-control" name="subjectcode" placeholder="Ex. Subject I" required="">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label class="col-xs-5 control-label" for="subjectname">Description</label>  
                <input id="subjectdesc" class="form-control" name="subjectdesc" placeholder="Subject Name and Description" required="">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label class="col-xs-5 control-label" for="subjectname">Credits</label>  
                <input id="credits" class="form-control" name="credits" type="number" step="0.01" placeholder="Credits" required="">
            </div>
            <div class="form-group col-md-6">
                <label class="col-xs-5 control-label mb-0" for="gradelevel">Grade Level</label>  
                <select name="gradelevel" id="gradelevel" class="form-control selectpicker mt-0" required>
                <option value="" selected></option>
                <option class="font-weight-bold" value="Grade 7">Grade 7</option>
                <option class="font-weight-bold" value="Grade 8">Grade 8</option>
                <option class="font-weight-bold" value="Grade 9">Grade 9</option>
                <option class="font-weight-bold" value="Grade 10">Grade 10</option>
                <option class="font-weight-bold" value="Grade 11">Grade 11</option>
                <option class="font-weight-bold" value="Grade 12">Grade 12</option>
                </select>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary closeBTN" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary add_curriculum">Add</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Curriculum Modal -->
<div class="modal fade" id="editcurriculum" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-success bg-gradient text-white">
        <h5 class="modal-title" id="exampleModalLabel">Subject Details</h5>
      </div>
      
      <div class="modal-body">
      <form action="#" id="editCurriculum" class="form-horizontal" method="POST">
      @csrf
        <div class="form-row">
            <div class="form-group col-md-12">
                <input type="hidden" name="cur_id" id="cur_id">
                <label class="col-xs-5 control-label" for="subjectname">Subject Code</label>  
                <input id="editsubjectcode" class="form-control" name="subjectcode" placeholder="Ex. Subject I" required="">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label class="col-xs-5 control-label" for="subjectname">Description</label>  
                <input id="editsubjectdesc" class="form-control" name="subjectdesc" placeholder="Subject Name and Description" required="">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label class="col-xs-5 control-label" for="subjectname">Credits</label>  
                <input id="editcredits" class="form-control" name="credits" type="number" step="0.01" placeholder="Credits" required="">
            </div>
            <div class="form-group col-md-6">
                <label class="col-xs-5 control-label" for="gradelevel">Grade Level</label>  
                <select name="editgradelevel" id="editgradelevel" class="form-select d-flex" required>
                <option value="" selected></option>
                <option value="Grade 7">Grade 7</option>
                <option value="Grade 8">Grade 8</option>
                <option value="Grade 9">Grade 9</option>
                <option value="Grade 10">Grade 10</option>
                <option value="Grade 11">Grade 11</option>
                <option value="Grade 12">Grade 12</option>
                </select>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary edit_curriculum">Update</button>
      </div>
      </form>
    </div>
  </div>
</div>

@foreach($sy as $SY)
    <!-- Edit School Year -->
    <div class="modal fade" id="editSY{{$SY->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit School Year</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>      
        <div class="modal-body">
        <form action="{{ url('/admin/edit_school_year', $SY->id)}}" class="form-horizontal" method="POST">
        @csrf
            <div class="form-group">
                <label class="col-xs-5 control-label" for="school_year"></label>
                <input id="school_year" class="form-control" name="school_year" value="{{$SY->from_year}} - {{$SY->to_year}}" disabled>
            </div>
            <div class="form-group">
                <label class="col-xs-5 control-label" for="quarter"></label>
                <input id="quarter" class="form-control" name="school_year" value="{{$SY->quarter}}" disabled>
            </div> 
            <div class="form-group">
                <label class="col-xs-5 control-label" for="status">Default?</label>
                <select name="status" id="status" class="form-select d-flex">
                    @if($SY->isCurrent == 1)
                    <option value="1" selected>Yes</option>
                    <option value="0">No</option>
                    @else
                    <option value="0" selected>No</option>
                    <option value="1">Yes</option>
                    @endif
                </select>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
        </form>
        </div>
    </div>
    </div>
@endforeach

<!-- Add New Co Curricular Modal -->
<div class="modal fade" id="editcocurricular" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-success bg-gradient text-white">
        <h5 class="modal-title" id="exampleModalLabel">Co Curricular Details</h5>
      </div>
      
      <div class="modal-body">
      <form  action="#" id="editCocurricular" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group text-center type">
                <label class="col-xs-5 control-label" for="typeCoCurricular">Type of Activity</label>  
                
                <select id="typedit" name="typeCoCurricularselect" class="form-select" data-placeholder="Select Type of Activity">
                    <option value=""></option>
                    @foreach($categories as $type)
                    <option value="{{$type['id']}}">{{$type->type_of_activity}}</option>
                    @endforeach
                </select>
                <div class="typeerror col-md-12 text-orange">
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group text-center">
                        <label class="col-xs-12 control-label" for="subTypeCoCurricular">Sub Type</label>  
                        
                        <select id="subTypeedit" name="subTypeedit" class="form-select">              
                        </select>
                        <div class="subtypeerror col-md-12 text-orange">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group text-center">
                        <label class="col-xs-12 control-label" for="subTypeCoCurricular">Sub Type Point</label>  
                        <input type="number" class="form-control" name="STpoint" id="STpoint" step="0.01">
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group text-center">
                        <label class="col-xs-12 control-label" for="awardscopeCoCurricular">Award Or Scope</label>  
                        
                        <select id="awardscopeedit" name="awardscopeedit" class="form-select">
                        </select>
                        <div class="awardscopeerror col-md-12 text-orange">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group text-center">
                        <label class="col-xs-12 control-label" for="subTypeCoCurricular">Award Or Scope Point</label>  
                        <input type="number" class="form-control" name="ASpoint" id="ASpoint" step="0.01">
                    </div>
                </div>
            </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary save_cocurricular">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>

