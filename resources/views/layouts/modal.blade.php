<div class="modal fade" id="school_year" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
        <div class="modal-header p-2" style="background-color: #05300e; color:#fff;">
            <h5 class="modal-title" style="color:#fff;" id="exampleModalLabel">Select School Year</h5>
        </div>        
        <div class="modal-body">
        @if(auth()->user()->role == 'Super Administrator' || auth()->user()->role == 'Administrator')
        <form action="{{ route('admin.dashboard') }}" class="form-horizontal" method="POST">
        @elseif(auth()->user()->role == 'Honors and Awards Committee' || auth()->user()->role == 'Guidance Facilitator')
        <form action="{{ route('staff.dashboard') }}" class="form-horizontal" method="POST">
        @else
        <form action="{{ action('App\Http\Controllers\TeacherController\DashboardController@index') }}" class="form-horizontal" method="POST">
        @endif
        @csrf
            <div class="form-group">
                <select name="schoolyear" id="schoolyears" class="syselect1" data-width="100%" required>
                <option value="" selected disabled>Please Select</option>
                @if(auth()->user()->role == 'Super Administrator' || auth()->user()->role == 'Administrator')
                <option class="font-weight-bold" value="Show All">Show All Data</option>
                @endif
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
        @if(auth()->user()->role == 'Super Administrator' || auth()->user()->role == 'Administrator')
        <form action="{{ route('admin.dashboard') }}" class="form-horizontal" method="POST">
        @elseif(auth()->user()->role == 'Honors and Awards Committee' || auth()->user()->role == 'Guidance Facilitator')
        <form action="{{ route('staff.dashboard') }}" class="form-horizontal" method="POST">
        @else
        <form action="{{ action('App\Http\Controllers\TeacherController\DashboardController@index') }}" class="form-horizontal" method="POST">
        @endif
        @csrf
            <div class="form-group">
                <select name="schoolyear" id="schoolyear" class="syselect2" data-width="100%" required>
                <option value="" selected disabled>Please Select</option>
                @if(auth()->user()->role == 'Super Administrator' || auth()->user()->role == 'Administrator')
                <option class="font-weight-bold" value="Show All">Show All Data</option>
                @endif
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
<div class="modal custom-modal fade" id="addnewcurriculum" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header p-2" style="background-color: #05300e; color:#fff;">
            <h5 class="modal-title" style="color:#fff;" id="exampleModalLabel">Subject Details</h5>
        </div>   
      
      <div class="modal-body">
      <form action="#" id="addSubject" class="form-horizontal" method="POST">
      @csrf
        <div class="row">
            <div class="form-group col-md-3">
                <label class="col-xs-5 control-label" for="subjectname">Subject Code</label>  
                <input id="subjectcode" class="form-control" name="subjectcode" placeholder="Ex. Subject I" required="">
            </div>
            <div class="form-group col-md-9">
                <label class="col-xs-5 control-label" for="subjectname">Description</label>  
                <input id="subjectdesc" class="form-control" name="subjectdesc" placeholder="Subject Name and Description" required="">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-2">
                <label class="col-xs-5 control-label" for="subjectname">Credits</label>  
                <input id="credits" class="form-control" name="credits" type="number" step="0.01" placeholder="Credits" required="">
            </div>
            <div class="form-group col-md-4">
                <label class="col-xs-5 control-label" for="gradelevel">Grade Level</label>  
                <select name="gradelevel" id="subject-gradelevel" class="form-control add-subject" data-width="100%" required data-placeholder="Select Grade Level">
                    <option></option>
                    <option value="Grade 7" {{ old('grade_level') == 'Grade 7' ? "selected" :"Grade 7"}}>Grade 7</option>
                    <option value="Grade 8" {{ old('grade_level') == 'Grade 8' ? "selected" :"Grade 8"}}>Grade 8</option>
                    <option value="Grade 9" {{ old('grade_level') == 'Grade 9' ? "selected" :"Grade 9"}}>Grade 9</option>
                    <option value="Grade 10" {{ old('grade_level') == 'Grade 10' ? "selected" :"Grade 10"}}>Grade 10</option>
                    <option value="Grade 11" {{ old('grade_level') == 'Grade 11' ? "selected" :"Grade 11"}}>Grade 11</option>
                    <option value="Grade 12" {{ old('grade_level') == 'Grade 12' ? "selected" :"Grade 12"}}>Grade 12</option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label class="col-xs-5 control-label" for="gradelevel">Faculty</label>  
                <select name="faculty" id="addsubjectfaculty" class="form-select d-flex add-subject" data-placeholder="Select Faculty"  required>
                    <option></option>
                    @foreach($list_faculty as $faculty)
                    <option value="{{$faculty->fid}}" {{ old('faculty') == '$faculty->fid' ? "selected" :''}}>{{$faculty->university_number.' - '.$faculty->lastname.', '.$faculty->firstname}}</option>
                    @endforeach
                </select>
                <span class="invalid-feedback-faculty col-12 text-error d-flex" role="alert">
                </span>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="modal-btn">
            <div class="row">
                <div class="col-6">
                    <button type="submit" class="btn btn-primary paid-continue-btn add_curriculum">Add</button>
                </div>
                <div class="col-6">
                    <button type="button" class="btn btn-primary paid-cancel-btn closeBTN" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Curriculum Modal -->
<div class="modal custom-modal fade" id="editcurriculum" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header p-2" style="background-color: #05300e; color:#fff;">
            <h5 class="modal-title" style="color:#fff;" id="exampleModalLabel">Class Details</h5>
        </div>
      <div class="modal-body">
      <form action="#" id="editCurriculum" class="form-horizontal" method="POST">
      @csrf
        <div class="row">
            <div class="form-group col-md-3">
                <input type="hidden" name="cur_id" id="cur_id">
                <label class="col-xs-5 control-label" for="subjectname">Subject Code</label>  
                <input id="editsubjectcode" class="form-control" name="subject_code" placeholder="Ex. Subject I" readonly required="">
                <span class="invalid-feedback-subject_code col-12 text-error d-flex" role="alert">
                </span>
            </div>
            <div class="form-group col-md-9">
                <label class="col-xs-5 control-label" for="subjectname">Description</label>  
                <input id="editsubjectdesc" class="form-control" name="subject_description" placeholder="Subject Name and Description" readonly required="">
                <span class="invalid-feedback-subject_description col-12 text-error d-flex" role="alert">
                </span>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-2">
                <label class="col-xs-5 control-label" for="subjectname">Credits</label>  
                <input id="editcredits" class="form-control" name="credits" type="number" step="0.01" placeholder="Credits" readonly required="">
                <span class="invalid-feedback-credits col-12 text-error d-flex" role="alert">
                </span>
            </div>
            <div class="form-group col-md-4">
                <label class="col-xs-5 control-label" for="gradelevel">Grade Level</label>  
                <select name="grade_level" id="editgradelevel" class="form-select d-flex edit-subject" data-placeholder="Select Grade Level"  required>
                    <option></option>
                    <option value="Grade 7" {{ old('grade_level') == 'Grade 7' ? "selected" :"Grade 7"}}>Grade 7</option>
                    <option value="Grade 8" {{ old('grade_level') == 'Grade 8' ? "selected" :"Grade 8"}}>Grade 8</option>
                    <option value="Grade 9" {{ old('grade_level') == 'Grade 9' ? "selected" :"Grade 9"}}>Grade 9</option>
                    <option value="Grade 10" {{ old('grade_level') == 'Grade 10' ? "selected" :"Grade 10"}}>Grade 10</option>
                    <option value="Grade 11" {{ old('grade_level') == 'Grade 11' ? "selected" :"Grade 11"}}>Grade 11</option>
                    <option value="Grade 12" {{ old('grade_level') == 'Grade 12' ? "selected" :"Grade 12"}}>Grade 12</option>
                </select>
                <span class="invalid-feedback-grade_level col-12 text-error d-flex" role="alert">
                </span>
            </div>
            <div class="form-group col-md-6">
                <label class="col-xs-5 control-label" for="gradelevel">Faculty</label>  
                <select name="faculty" id="subject_handler" class="form-select d-flex edit-subject" data-placeholder="Select Faculty"  required>
                    <option></option>
                    @foreach($list_faculty as $faculty)
                    <option value="{{$faculty->fid}}" {{ old('faculty') == '$faculty->fid' ? "selected" :''}}>{{$faculty->university_number.' - '.$faculty->lastname.', '.$faculty->firstname}}</option>
                    @endforeach
                </select>
                <span class="invalid-feedback-faculty col-12 text-error d-flex" role="alert">
                </span>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="modal-btn">
            <div class="row">
                <div class="col-6">
                    <button type="submit" class="btn btn-primary paid-continue-btn edit_curriculum">Update</button>
                </div>
                <div class="col-6">
                    <button type="button" class="btn btn-primary paid-cancel-btn closeBTN" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Section Modal -->
<div class="modal custom-modal fade" id="editsectionmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
  <div class="modal-dialog" role="document">
  <div class="modal-content">
        <div class="modal-header p-2" style="background-color: #05300e; color:#fff;">
            <h5 class="modal-title" style="color:#fff;" id="exampleModalLabel">Class Advisory Details</h5>
        </div>  
      <div class="modal-body">
      <form action="#" id="editSection" class="form-horizontal" method="POST">
      @csrf
        <div class="row">
            <div class="form-group col-md-6">
                <label class="col-xs-5 control-label" for="grade_level">Grade Level</label>  
                <select name="grade_level" id="editsectionlevel" class="form-select d-flex edit-section" data-placeholder="Select Grade Level"  required>
                    <option></option>
                    <option value="Grade 7" {{ old('grade_level') == 'Grade 7' ? "selected" :"Grade 7"}}>Grade 7</option>
                    <option value="Grade 8" {{ old('grade_level') == 'Grade 8' ? "selected" :"Grade 8"}}>Grade 8</option>
                    <option value="Grade 9" {{ old('grade_level') == 'Grade 9' ? "selected" :"Grade 9"}}>Grade 9</option>
                    <option value="Grade 10" {{ old('grade_level') == 'Grade 10' ? "selected" :"Grade 10"}}>Grade 10</option>
                    <option value="Grade 11" {{ old('grade_level') == 'Grade 11' ? "selected" :"Grade 11"}}>Grade 11</option>
                    <option value="Grade 12" {{ old('grade_level') == 'Grade 12' ? "selected" :"Grade 12"}}>Grade 12</option>
                </select>
                <span class="invalid-feedback-grade_level col-12 text-error d-flex" role="alert">
                </span>
            </div>
            <div class="form-group col-md-6">
                <input type="hidden" name="sec_id" id="sec_id">
                <label class="col-xs-5 control-label" for="subjectname">Section</label>  
                <input id="editsection" class="form-control" name="section" readonly required="">
                <span class="invalid-feedback-section col-12 text-error d-flex" role="alert">
                </span>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-12">
                <label class="col-xs-5 control-label" for="faculty">Faculty</label>  
                <select name="faculty" id="editfaculty" class="form-select d-flex edit-section" data-placeholder="Select Faculty"  required>
                    <option></option>
                    @foreach($list_faculty as $faculty)
                    <option value="{{$faculty->fid}}" {{ old('faculty') == '$faculty->fid' ? "selected" :''}}>{{$faculty->university_number.' - '.$faculty->lastname.', '.$faculty->firstname}}</option>
                    @endforeach
                </select>
                <span class="invalid-feedback-faculty col-12 text-error d-flex" role="alert">
                </span>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="modal-btn">
            <div class="row">
                <div class="col-6">
                    <button type="submit" class="btn btn-primary paid-continue-btn update_section">Update</button>
                </div>
                <div class="col-6">
                    <button type="button" class="btn btn-primary paid-cancel-btn closeBTN" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Add Section Modal -->
<div class="modal custom-modal fade" id="addnewsectionmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header p-2" style="background-color: #05300e; color:#fff;">
            <h5 class="modal-title" style="color:#fff;" id="exampleModalLabel">Class Advisory Details</h5>
        </div>
      <div class="modal-body">
      <form action="#" id="addSection" class="form-horizontal" method="POST">
      @csrf
        <div class="row">
            <div class="form-group col-md-6">
                <label class="col-xs-5 control-label" for="grade_level">Grade Level</label>  
                <select name="grade_level" id="addsectionlevel" class="form-select d-flex add-section" data-placeholder="Select Grade Level"  required>
                    <option></option>
                    <option value="Grade 7" {{ old('grade_level') == 'Grade 7' ? "selected" :"Grade 7"}}>Grade 7</option>
                    <option value="Grade 8" {{ old('grade_level') == 'Grade 8' ? "selected" :"Grade 8"}}>Grade 8</option>
                    <option value="Grade 9" {{ old('grade_level') == 'Grade 9' ? "selected" :"Grade 9"}}>Grade 9</option>
                    <option value="Grade 10" {{ old('grade_level') == 'Grade 10' ? "selected" :"Grade 10"}}>Grade 10</option>
                    <option value="Grade 11" {{ old('grade_level') == 'Grade 11' ? "selected" :"Grade 11"}}>Grade 11</option>
                    <option value="Grade 12" {{ old('grade_level') == 'Grade 12' ? "selected" :"Grade 12"}}>Grade 12</option>
                </select>
                <span class="invalid-feedback-grade_level col-12 text-error d-flex" role="alert">
                </span>
            </div>
            <div class="form-group col-md-6">
                <input type="hidden" name="sec_id" id="sec_id">
                <label class="col-xs-5 control-label" for="subjectname">Section</label>  
                <input id="editsection" class="form-control" name="section" placeholder="Enter Section" required="">
                <span class="invalid-feedback-section col-12 text-error d-flex" role="alert">
                </span>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-12">
                <label class="col-xs-5 control-label" for="faculty">Faculty</label>  
                <select name="faculty" id="addfaculty" class="form-select d-flex add-section" data-placeholder="Select Faculty"  required>
                    <option></option>
                    @foreach($list_faculty as $faculty)
                    <option value="{{$faculty->fid}}" {{ old('faculty') == '$faculty->fid' ? "selected" :''}}>{{$faculty->university_number.' - '.$faculty->lastname.', '.$faculty->firstname}}</option>
                    @endforeach
                </select>
                <span class="invalid-feedback-faculty col-12 text-error d-flex" role="alert">
                </span>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="modal-btn">
            <div class="row">
                <div class="col-6">
                    <button type="submit" class="btn btn-primary paid-continue-btn add_section">Add</button>
                </div>
                <div class="col-6">
                    <button type="button" class="btn btn-primary paid-cancel-btn closeBTN" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
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


<!-- Edit Staff User -->
<div class="modal custom-modal fade" id="editstaffuser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
    <div class="modal-header p-2" style="background-color: #05300e; color:#fff;">
        <h5 class="modal-title" style="color:#fff;" id="exampleModalLabel">Staff Information</h5>
      </div>
      
      <div class="modal-body">
      <form action="#" id="editStaff" class="form-horizontal" method="POST">
      @csrf
        <div class="row  pt-3">
        <input type="hidden" name="staff_id" id="staff_id">
            <div class="col-12 col-sm-4">
                <div class="form-group local-forms">
                    <label>First Name <span class="login-danger">*</span></label>
                    <input type="text" id="first_name_staff" class="form-control @error('first_name') is-invalid @enderror" name="first_name" style="text-transform: capitalize;" placeholder="Enter First Name" value="{{ old('first_name') }}">
                        <span class="invalid-feedback-firstname col-12 text-error d-flex" role="alert">
                        </span>
                </div>
            </div>
            <div class="col-12 col-sm-4">
                <div class="form-group local-forms">
                    <label>Middle Name</label>
                    <input type="text" id="middle_name_staff" class="form-control @error('middle_name') is-invalid @enderror" name="middle_name" style="text-transform: capitalize;" placeholder="Enter Middle Name" value="{{ old('middle_name') }}">
                        <span class="invalid-feedback-middlename col-12 text-error d-flex" role="alert">
                        </span>
                </div>
            </div>
            <div class="col-12 col-sm-4">
                <div class="form-group local-forms">
                    <label>Last Name <span class="login-danger">*</span></label>
                    <input type="text" id="last_name_staff" class="form-control @error('last_name') is-invalid @enderror" name="last_name" style="text-transform: capitalize;" placeholder="Enter Last Name" value="{{ old('last_name') }}">
                        <span class="invalid-feedback-lastname col-12 text-error d-flex" role="alert">
                        </span>
                </div>
            </div>
            <div class="col-12 col-sm-4">
                <div class="form-group local-forms">
                    <label>University Number <span class="login-danger">*</span></label>
                    <input id="university_number_staff" class="form-control @error('university_number') is-invalid @enderror" type="number" onKeyPress="if(this.value.length==12) return false;" name="university_number" placeholder="Enter University Number" value="{{ old('lrn_number') }}">
                        <span class="invalid-feedback-universitynumber col-12 text-error d-flex" role="alert">
                        </span>
                </div>
            </div>
            <div class="col-12 col-sm-4">
                <div class="form-group local-forms">
                    <label>Gender <span class="login-danger">*</span></label>
                    <select id="gender_staff" class="form-control select  @error('gender') is-invalid @enderror" name="gender" data-placeholder="Select Gender">
                        <option></option>
                        <option value="Female" {{ old('gender') == 'Female' ? "selected" :"Female"}}>Female</option>
                        <option value="Male" {{ old('gender') == 'Male' ? "selected" :""}}>Male</option>
                    </select>
                        <span class="invalid-feedback-gender col-12 text-error d-flex" role="alert">
                        </span>
                </div>
            </div>
            <div class="col-12 col-sm-4">
                <div class="form-group local-forms">
                    <label>E-Mail <span class="login-danger">*</span></label>
                    <input id="email_staff" class="form-control @error('email') is-invalid @enderror" type="email" name="email" placeholder="Enter Email Address" value="{{ old('email') }}">
                        <span class="invalid-feedback-email col-12 text-error d-flex" role="alert">
                        </span>
                </div>
            </div>
            <div class="col-12 col-sm-3">
                <div class="form-group local-forms">
                    <label>Phone <span class="login-danger">*</span></label>
                    <input id="phone_staff" class="form-control @error('phone_number') is-invalid @enderror" onKeyPress="if(this.value.length==12) return false;" type="number" name="phone_number" placeholder="Enter Phone Number" value="{{ old('phone_number') }}">
                    <span class="invalid-feedback-phone col-12 text-error d-flex" role="alert"> 
                    </span>
                </div>
            </div>
            <div class="col-12 col-sm-4">
                <div class="form-group local-forms">
                    <label>Home Address <span class="login-danger">*</span></label>
                    <input id="home_address_staff" type="text" class="form-control @error('home_address') is-invalid @enderror" name="home_address" style="text-transform: capitalize;" placeholder="Enter Home Address" value="{{ old('home_address') }}">
                    <span class="invalid-feedback-homeaddress col-12 text-error d-flex" role="alert">
                    </span>
                </div>
            </div>
            <div class="col-12 col-sm-4">
                <div class="form-group local-forms">
                    <label>Staff Role <span class="login-danger">*</span></label>
                    <select id="staff_role_staff" class="form-control select  @error('staff_role') is-invalid @enderror" name="staff_role" data-placeholder="Select Role">
                        <option></option>
                        @if(auth()->user()->role == 'Super Administrator')
                        <option value="2" {{ old('staff_role') == '2' ? "selected" :"Administrator"}}>Administrator</option>
                        @endif
                        <option value="3" {{ old('staff_role') == '3' ? "selected" :"Honors and Awards Committee"}}>Honors and Awards Committee</option>
                        <option value="4" {{ old('staff_role') == '4' ? "selected" :"Guidance Facilitator"}}>Guidance Facilitator</option>
                    </select>
                        <span class="invalid-feedback-staffrole col-12 text-error d-flex" role="alert">
                        </span>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="modal-btn">
            <div class="row">
                <div class="col-6">
                    <button type="submit" class="btn btn-primary paid-continue-btn add_section">Update</button>
                </div>
                <div class="col-6">
                    <button type="button" class="btn btn-primary paid-cancel-btn closeBTN" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Faculty User -->
<div class="modal custom-modal fade" id="editfacultyuser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
    <div class="modal-header p-2" style="background-color: #05300e; color:#fff;">
        <h5 class="modal-title" style="color:#fff;" id="exampleModalLabel">Faculty Information</h5>
      </div>
      
      <div class="modal-body">
      <form action="#" id="editFaculty" class="form-horizontal" method="POST">
      @csrf
        <div class="row  pt-3">
        <input type="hidden" name="faculty_id" id="faculty_id">
            <div class="col-12 col-sm-4">
                <div class="form-group local-forms">
                    <label>First Name <span class="login-danger">*</span></label>
                    <input type="text" id="first_name_faculty" class="form-control @error('first_name') is-invalid @enderror" name="first_name" style="text-transform: capitalize;" placeholder="Enter First Name" value="{{ old('first_name') }}">
                        <span class="invalid-feedback-firstname col-12 text-error d-flex" role="alert">
                        </span>
                </div>
            </div>
            <div class="col-12 col-sm-4">
                <div class="form-group local-forms">
                    <label>Middle Name</label>
                    <input type="text" id="middle_name_faculty" class="form-control @error('middle_name') is-invalid @enderror" name="middle_name" style="text-transform: capitalize;" placeholder="Enter Middle Name" value="{{ old('middle_name') }}">
                        <span class="invalid-feedback-middlename col-12 text-error d-flex" role="alert">
                        </span>
                </div>
            </div>
            <div class="col-12 col-sm-4">
                <div class="form-group local-forms">
                    <label>Last Name <span class="login-danger">*</span></label>
                    <input type="text" id="last_name_faculty" class="form-control @error('last_name') is-invalid @enderror" name="last_name" style="text-transform: capitalize;" placeholder="Enter Last Name" value="{{ old('last_name') }}">
                        <span class="invalid-feedback-lastname col-12 text-error d-flex" role="alert">
                        </span>
                </div>
            </div>
            <div class="col-12 col-sm-4">
                <div class="form-group local-forms">
                    <label>University Number <span class="login-danger">*</span></label>
                    <input id="university_number_faculty" class="form-control @error('university_number') is-invalid @enderror" type="number" name="university_number" onKeyPress="if(this.value.length==12) return false;" placeholder="Enter University Number" value="{{ old('lrn_number') }}">
                        <span class="invalid-feedback-universitynumber col-12 text-error d-flex" role="alert">
                        </span>
                </div>
            </div>
            <div class="col-12 col-sm-4">
                <div class="form-group local-forms">
                    <label>Gender <span class="login-danger">*</span></label>
                    <select id="gender_faculty" class="form-control select  @error('gender') is-invalid @enderror" name="gender" data-placeholder="Select Gender">
                        <option></option>
                        <option value="Female" {{ old('gender') == 'Female' ? "selected" :"Female"}}>Female</option>
                        <option value="Male" {{ old('gender') == 'Male' ? "selected" :""}}>Male</option>
                    </select>
                        <span class="invalid-feedback-gender col-12 text-error d-flex" role="alert">
                        </span>
                </div>
            </div>
            <div class="col-12 col-sm-4">
                <div class="form-group local-forms">
                    <label>E-Mail <span class="login-danger">*</span></label>
                    <input id="email_faculty" class="form-control @error('email') is-invalid @enderror" type="email" name="email" placeholder="Enter Email Address" value="{{ old('email') }}">
                        <span class="invalid-feedback-email col-12 text-error d-flex" role="alert">
                        </span>
                </div>
            </div>
            <div class="col-12 col-sm-4">
                <div class="form-group local-forms">
                    <label>Phone <span class="login-danger">*</span></label>
                    <input id="phone_faculty" class="form-control @error('phone_number') is-invalid @enderror ." onKeyPress="if(this.value.length==12) return false;" type="number" name="phone_number" placeholder="Enter Phone Number" value="{{ old('phone_number') }}">
                    <span class="invalid-feedback-phone col-12 text-error d-flex" role="alert"> 
                    </span>
                </div>
            </div>
            <div class="col-12 col-sm-4">
                <div class="form-group local-forms">
                    <label>Home Address <span class="login-danger">*</span></label>
                    <input id="home_address_faculty" type="text" class="form-control @error('home_address') is-invalid @enderror" name="home_address" style="text-transform: capitalize;" placeholder="Enter Home Address" value="{{ old('home_address') }}">
                    <span class="invalid-feedback-homeaddress col-12 text-error d-flex" role="alert">
                    </span>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="modal-btn">
            <div class="row">
                <div class="col-6">
                    <button type="submit" class="btn btn-primary paid-continue-btn add_section">Update</button>
                </div>
                <div class="col-6">
                    <button type="button" class="btn btn-primary paid-cancel-btn closeBTN" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="view_class_modal" role="dialog" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header p-2 view_class_modal_title" style="background-color: #05300e; color:#fff;">
            </div>      
            <div class="modal-body">
                <div class="table-responsive viewClassTable" id="viewClassTable">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="input_grades_modal" role="dialog" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header p-2 input_grades_modal_title" style="background-color: #05300e; color:#fff;">
            </div>      
            <div class="modal-body">
            <form action="#" id="submitGrades" class="form-horizontal" method="POST">
            @csrf
                <div class="table-responsive inputGradesTable" id="inputGradesTable">
                </div>
            </div>
            <div class="modal-footer">
            <button type="submit" class="btn btn-primary"i><i class="fas fa-paper-plane"></i> Submit</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="view_grades_modal" role="dialog" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header p-2 view_grades_modal_title" style="background-color: #05300e; color:#fff;">
            </div>      
            <div class="modal-body">
                <div class="table-responsive viewGradesTable" id="viewGradesTable">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="view_advisees_modal" role="dialog" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header p-2 view_advisees_modal_title" style="background-color: #05300e; color:#fff;">
            </div>      
            <div class="modal-body">
                <div class="table-responsive viewAdviseesTable" id="viewAdviseesTable">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="grades_validation_modal" role="dialog" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header p-2 grades_validation_modal_title" style="background-color: #05300e; color:#fff;">
            </div>      
            <div class="modal-body">
            <form action="#" id="validateGrades" class="form-horizontal" method="POST">
            @csrf
                <div class="table-responsive gradesValidationTable" id="gradesValidationTable">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary"i><i class="fas fa-check"></i> Validate</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="grades_validated_modal" role="dialog" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header p-2 grades_validated_modal_title" style="background-color: #05300e; color:#fff;">
            </div>      
            <div class="modal-body">
                <div class="table-responsive gradesValidatedTable" id="gradesValidatedTable">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Student User -->
<div class="modal custom-modal fade" id="editstudentuser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
    <div class="modal-header p-2" style="background-color: #05300e; color:#fff;">
        <h5 class="modal-title" style="color:#fff;" id="exampleModalLabel">Student Information</h5>
      </div>
      
      <div class="modal-body">
      <form action="{{ route('updateStudentUser') }}" id="editStudent" class="form-horizontal" method="POST" enctype="multipart/form-data">
      @csrf
        <div class="row  pt-3">
        <input type="hidden" name="student_id" id="student_id">
            <div class="col-12 col-sm-4">
                <div class="form-group local-forms">
                    <label>First Name <span class="login-danger">*</span></label>
                    <input type="text" id="first_name_student" class="form-control @error('first_name') is-invalid @enderror" name="first_name" style="text-transform: capitalize;" placeholder="Enter First Name" value="{{ old('first_name') }}">
                    <span class="invalid-feedback-firstname col-md-12 text-error" role="alert"> 
                    </span>
                </div>
            </div>
            <div class="col-12 col-sm-4">
                <div class="form-group local-forms">
                    <label>Middle Name</label>
                    <input type="text" id="middle_name_student" class="form-control @error('middle_name') is-invalid @enderror" name="middle_name" style="text-transform: capitalize;" placeholder="Enter Middle Name" value="{{ old('middle_name') }}">
                    <span class="invalid-feedback-middlename col-12 text-error d-flex" role="alert"> 
                    </span>
                </div>
            </div>
            <div class="col-12 col-sm-4">
                <div class="form-group local-forms">
                    <label>Last Name <span class="login-danger">*</span></label>
                    <input type="text" id="last_name_student" class="form-control @error('last_name') is-invalid @enderror" name="last_name" style="text-transform: capitalize;" placeholder="Enter Last Name" value="{{ old('last_name') }}">
                    <span class="invalid-feedback-lastname col-12 text-error d-flex" role="alert"> 
                    </span>
                </div>
            </div>
            <div class="col-12 col-sm-3">
                <div class="form-group local-forms">
                    <label>LRN Number <span class="login-danger">*</span></label>
                    <input id="lrn_number_student" class="form-control @error('lrn_number') is-invalid @enderror" onKeyPress="if(this.value.length==12) return false;" type="number" name="lrn_number" placeholder="Enter LRN Number" value="{{ old('lrn_number') }}">
                    <span class="invalid-feedback-lrnnumber col-12 text-error d-flex" role="alert"> 
                    </span>
                </div>
            </div>
            <div class="col-12 col-sm-3">
                <div class="form-group local-forms">
                    <label>Grade Level <span class="login-danger">*</span></label>
                    <select id="grade_level_student" class="form-control select  @error('grade_level') is-invalid @enderror" name="grade_level" data-placeholder="Select Grade Level">
                        <option></option>
                        <option value="Grade 7" {{ old('grade_level') == 'Grade 7' ? "selected" :"Grade 7"}}>Grade 7</option>
                        <option value="Grade 8" {{ old('grade_level') == 'Grade 8' ? "selected" :"Grade 8"}}>Grade 8</option>
                        <option value="Grade 9" {{ old('grade_level') == 'Grade 9' ? "selected" :"Grade 9"}}>Grade 9</option>
                        <option value="Grade 10" {{ old('grade_level') == 'Grade 10' ? "selected" :"Grade 10"}}>Grade 10</option>
                        <option value="Grade 11" {{ old('grade_level') == 'Grade 11' ? "selected" :"Grade 11"}}>Grade 11</option>
                        <option value="Grade 12" {{ old('grade_level') == 'Grade 12' ? "selected" :"Grade 12"}}>Grade 12</option>
                    </select>
                    <span class="invalid-feedback-gradelevel col-12 text-error d-flex" role="alert"> 
                    </span>
                </div>
            </div>
            <div class="col-12 col-sm-3">
                <div class="form-group local-forms">
                    <label>Section <span class="login-danger">*</span></label>
                    <select id="section_student" class="form-control select  @error('section') is-invalid @enderror" name="section">
                        
                    </select>
                    <span class="invalid-feedback-section col-12 text-error d-flex" role="alert"> 
                    </span>
                </div>
            </div>
            <div class="col-12 col-sm-3">
                <div class="form-group local-forms">
                    <label>Gender <span class="login-danger">*</span></label>
                    <select id="gender_student" class="form-control select  @error('gender') is-invalid @enderror" name="gender" data-placeholder="Select Gender">
                        <option></option>
                        <option value="Female" {{ old('gender') == 'Female' ? "selected" :"Female"}}>Female</option>
                        <option value="Male" {{ old('gender') == 'Male' ? "selected" :""}}>Male</option>
                    </select>
                    <span class="invalid-feedback-gender col-12 text-error d-flex" role="alert"> 
                    </span>
                </div>
            </div>
            <div class="col-12 col-sm-3">
                <div class="form-group local-forms">
                    <label>E-Mail <span class="login-danger">*</span></label>
                    <input id="email_student" class="form-control @error('email') is-invalid @enderror" type="email" name="email" placeholder="Enter Email Address" value="{{ old('email') }}">
                    <span class="invalid-feedback-email col-12 text-error d-flex" role="alert"> 
                    </span>
                </div>
            </div>
            <div class="col-12 col-sm-3">
                <div class="form-group local-forms">
                    <label>Phone <span class="login-danger">*</span></label>
                    <input id="phone" class="form-control @error('phone_number') is-invalid @enderror" onKeyPress="if(this.value.length==12) return false;" type="number" name="phone_number" placeholder="Enter Phone Number" value="{{ old('phone_number') }}">
                    <span class="invalid-feedback-phone col-12 text-error d-flex" role="alert"> 
                    </span>
                </div>
            </div>
            <div class="col-12 col-sm-3">
                <div class="form-group local-forms calendar-icon">
                    <label>Date Of Birth <span class="login-danger">*</span></label>
                    <input id="dateofbirth" class="form-control datetimepicker @error('date_of_birth') is-invalid @enderror" name="date_of_birth" type="text" placeholder="DD-MM-YYYY" value="{{ old('date_of_birth') }}">
                    <span class="invalid-feedback-dateofbirth col-12 text-error d-flex" role="alert">
                    </span>
                </div>
            </div>
            <div class="col-12 col-sm-3">
                <div class="form-group local-forms">
                    <label>Age <span class="login-danger">*</span></label>
                    <input id="age_student" class="form-control @error('age') is-invalid @enderror" type="number" name="age" placeholder="Enter Age" value="{{ old('age') }}">
                    <span class="invalid-feedback-age col-12 text-error d-flex" role="alert">
                    </span>
                </div>
            </div>
            <div class="col-12 col-sm-4">
                <div class="form-group local-forms">
                    <label>Home Address <span class="login-danger">*</span></label>
                    <input id="home_address_student" type="text" class="form-control @error('home_address') is-invalid @enderror" name="home_address" style="text-transform: capitalize;" placeholder="Enter Home Address" value="{{ old('home_address') }}">
                    <span class="invalid-feedback-homeaddress col-12 text-error d-flex" role="alert">
                    </span>
                </div>
            </div>
            <div class="col-12 col-sm-4">
                <div class="form-group local-forms">
                    <label>Parent/Guardian's Name <span class="login-danger">*</span></label>
                    <input id="parent_name_student" type="text" class="form-control @error('parent_name') is-invalid @enderror" name="parent_name" style="text-transform: capitalize;" placeholder="Enter Parent/Guardian's Name" value="{{ old('parent_name') }}">
                    <span class="invalid-feedback-parentname col-12 text-error d-flex" role="alert">
                    </span>
                </div>
            </div>
            <div class="col-12 col-sm-4">
                <div class="form-group local-forms">
                    <label>Parent/Guardian's Address <span class="login-danger">*</span></label>
                    <input id="parent_address_student" type="text" class="form-control @error('parent_address') is-invalid @enderror" name="parent_address" style="text-transform: capitalize;" placeholder="Enter Parent/Guardian's Address" value="{{ old('parent_address') }}">
                    <span class="invalid-feedback-parentaddress col-12 text-error d-flex" role="alert">
                    </span>
                </div>
            </div>
            <div class="col-12 col-sm-6">
                <div class="form-group local-forms">
                    <label>Previous School Graduated <span class="login-danger">*</span></label>
                    <input id="school_graduated" type="text" class="form-control @error('previous_school') is-invalid @enderror" name="previous_school" style="text-transform: capitalize;" placeholder="Enter Previous School" value="{{ old('previous_school') }}">
                    <span class="invalid-feedback-previousschool col-12 text-error d-flex" role="alert">
                    </span>
                </div>
            </div>
            <div class="col-12 col-sm-3">
                <div class="form-group local-forms">
                    <label>Year Graduated <span class="login-danger">*</span></label>
                    <input id="year_grad" class="form-control @error('year_graduated') is-invalid @enderror" type="text" id="datepicker" name="year_graduated" placeholder="Enter Year Graduated" value="{{ old('year_graduated') }}">
                    <span class="invalid-feedback-yeargraduated col-12 text-error d-flex" role="alert">
                    </span>
                </div>
            </div>
            <div class="col-12 col-sm-3">
                <div class="form-group local-forms">
                    <label>GPA <span class="login-danger">*</span></label>
                    <input id="gpa_student" class="form-control @error('gpa') is-invalid @enderror" type="number" step="0.01" name="gpa" placeholder="Enter Previous School GPA" value="{{ old('gpa') }}">
                    <span class="invalid-feedback-gpa col-12 text-error d-flex" role="alert">
                    </span>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="modal-btn">
            <div class="row">
                <div class="col-6">
                    <button type="submit" class="btn btn-primary paid-continue-btn add_section">Update</button>
                </div>
                <div class="col-6">
                    <button type="button" class="btn btn-primary paid-cancel-btn closeBTN" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
      </div>
      </form>
    </div>
  </div>
</div>



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



