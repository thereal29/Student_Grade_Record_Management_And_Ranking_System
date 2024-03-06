
@extends('layouts.master')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <h3 class="page-title">Add Students</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('admin.student-user')}}">Student</a></li>
                                <li class="breadcrumb-item active">Add Students</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            {{-- message --}}
            {!! Toastr::message() !!}
            <div class="row">
                <div class="col-sm-12">
                    <div class="card comman-shadow">
                        <div class="card-body">
                            <form action="{{route('admin.student-user-create')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="form-title student-info">Student Information
                                        </h5>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>First Name <span class="login-danger">*</span></label>
                                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" style="text-transform: capitalize;" placeholder="Enter First Name" value="{{ old('first_name') }}">
                                            @error('first_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Middle Name</label>
                                            <input type="text" class="form-control @error('middle_name') is-invalid @enderror" name="middle_name" style="text-transform: capitalize;" placeholder="Enter Middle Name" value="{{ old('middle_name') }}">
                                            @error('middle_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Last Name <span class="login-danger">*</span></label>
                                            <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" style="text-transform: capitalize;" placeholder="Enter Last Name" value="{{ old('last_name') }}">
                                            @error('last_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="form-group local-forms">
                                            <label>LRN Number <span class="login-danger">*</span></label>
                                            <input class="form-control @error('lrn_number') is-invalid @enderror" type="number" onKeyPress="if(this.value.length==12) return false;" name="lrn_number" placeholder="Enter LRN Number" value="{{ old('lrn_number') }}">
                                            @error('lrn_number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="form-group local-forms" >
                                            <label>Grade Level <span class="login-danger">*</span></label>
                                            <select id="grade_level"  class="form-control select  @error('grade_level') is-invalid @enderror" style="z-index: 9999 !important;" name="grade_level" data-placeholder="Select Grade Level">
                                                <option></option>
                                                <option value="Grade 7" {{ Request('grade_level') == 'Grade 7' ? "selected" :"Grade 7"}}>Grade 7</option>
                                                <option value="Grade 8" {{ Request('grade_level') == 'Grade 8' ? "selected" :"Grade 8"}}>Grade 8</option>
                                                <option value="Grade 9" {{ Request('grade_level') == 'Grade 9' ? "selected" :"Grade 9"}}>Grade 9</option>
                                                <option value="Grade 10" {{ Request('grade_level') == 'Grade 10' ? "selected" :"Grade 10"}}>Grade 10</option>
                                                <option value="Grade 11" {{ Request('grade_level') == 'Grade 11' ? "selected" :"Grade 11"}}>Grade 11</option>
                                                <option value="Grade 12" {{ Request('grade_level') == 'Grade 12' ? "selected" :"Grade 12"}}>Grade 12</option>
                                            </select>
                                            @error('grade_level')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="form-group local-forms">
                                            <label>Section <span class="login-danger">*</span></label>
                                            <select id="section" class="form-control select  @error('section') is-invalid @enderror" name="section" >
                                                <option selected disable>Please select Grade Level first</option>
                                            </select>
                                            @error('section')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="form-group local-forms">
                                            <label>Gender <span class="login-danger">*</span></label>
                                            <select class="form-control select  @error('gender') is-invalid @enderror" name="gender" data-placeholder="Select Gender">
                                                <option></option>
                                                <option value="Female" {{ old('gender') == 'Female' ? "selected" :"Female"}}>Female</option>
                                                <option value="Male" {{ old('gender') == 'Male' ? "selected" :""}}>Male</option>
                                            </select>
                                            @error('gender')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>E-Mail <span class="login-danger">*</span></label>
                                            <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" placeholder="Enter Email Address" value="{{ old('email') }}">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms" style="z-index: 999 !important; width: 100% !important;">
                                            <label>Phone <span class="login-danger">*</span></label>
                                            <input  class="form-control @error('phone_number') is-invalid @enderror" id="phone" onKeyPress="if(this.value.length==10) return false;" type="number" name="phone_number" placeholder="Enter Phone Number" value="{{ old('phone_number') }}">
                                            @error('phone_number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group local-forms calendar-icon">
                                            <label>Date Of Birth <span class="login-danger">*</span></label>
                                            <input class="form-control datetimepicker @error('date_of_birth') is-invalid @enderror" name="date_of_birth" type="text" placeholder="DD-MM-YYYY" value="{{ old('date_of_birth') }}">
                                            @error('date_of_birth')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group local-forms">
                                            <label>Age <span class="login-danger">*</span></label>
                                            <input class="form-control @error('age') is-invalid @enderror" type="number" name="age" placeholder="Enter Age" value="{{ old('age') }}">
                                            @error('age')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Home Address <span class="login-danger">*</span></label>
                                            <input type="text" class="form-control @error('home_address') is-invalid @enderror" name="home_address" style="text-transform: capitalize;" placeholder="Enter Home Address" value="{{ old('home_address') }}">
                                            @error('home_address')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Parent/Guardian's Name <span class="login-danger">*</span></label>
                                            <input type="text" class="form-control @error('parent_name') is-invalid @enderror" name="parent_name" style="text-transform: capitalize;" placeholder="Enter Parent/Guardian's Name" value="{{ old('parent_name') }}">
                                            @error('parent_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Parent/Guardian's Address <span class="login-danger">*</span></label>
                                            <input type="text" class="form-control @error('parent_address') is-invalid @enderror" name="parent_address" style="text-transform: capitalize;" placeholder="Enter Parent/Guardian's Address" value="{{ old('parent_address') }}">
                                            @error('parent_address')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Previous School Graduated <span class="login-danger">*</span></label>
                                            <input type="text" class="form-control @error('previous_school') is-invalid @enderror" name="previous_school" style="text-transform: capitalize;" placeholder="Enter Previous School" value="{{ old('previous_school') }}">
                                            @error('previous_school')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group local-forms">
                                            <label>Year Graduated <span class="login-danger">*</span></label>
                                            <input class="form-control @error('year_graduated') is-invalid @enderror" type="text" id="datepicker" name="year_graduated" placeholder="Enter Year Graduated" value="{{ old('year_graduated') }}">
                                            @error('year_graduated')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group local-forms">
                                            <label>GPA <span class="login-danger">*</span></label>
                                            <input class="form-control @error('gpa') is-invalid @enderror" type="number" step="0.01" name="gpa" placeholder="Enter Previous School GPA" value="{{ old('gpa') }}">
                                            @error('gpa')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-auto text-end float-end ms-auto download-grp">
                                        <div class="student-submit">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    
    <script>
        
    $(document).ready(function() {
        
      $('#grade_level').on('change', function() {
          var gradelevel = $(this).val();
          if(gradelevel) {
              $.ajax({
                  url: '/getSection/'+gradelevel,
                  type: "GET",
                  data : {"_token":"{{ csrf_token() }}"},
                  dataType: "json",
                  success:function(data)
                  {
                    if(data){
                        $('#section').empty();
                        $('#section').select2({
                        placeholder: "Select Section",
                        minimumResultsForSearch: Infinity
                        });
                        $('#section').append('<option></option>'); 
                        $.each(data, function(key, gradelevels){
                            $('select[name="section"]').append('<option value="'+ gradelevels.section +'">' + gradelevels.section + '</option>');
                        });
                    }else{
                        $('#section').empty();
                    }
                }
              });
          }else{
            $('#section').empty();
          }
      });
      
    });
</script> 
@endsection
