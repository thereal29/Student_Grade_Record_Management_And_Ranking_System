
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
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>LRN Number <span class="login-danger">*</span></label>
                                            <input class="form-control @error('lrn_number') is-invalid @enderror" type="number" name="lrn_number" placeholder="Enter LRN Number" value="{{ old('lrn_number') }}">
                                            @error('lrn_number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Grade Level <span class="login-danger">*</span></label>
                                            <select id="grade_level" class="form-control select  @error('grade_level') is-invalid @enderror" name="grade_level" data-placeholder="Select Grade Level">
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
                                    <div class="col-12 col-sm-4">
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
                                    <div class="col-12 col-sm-4">
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
                                        <div class="form-group local-forms">
                                            <label>Phone </label>
                                            <input class="form-control @error('phone_number') is-invalid @enderror" type="number" name="phone_number" placeholder="Enter Phone Number" value="{{ old('phone_number') }}">
                                            @error('phone_number')
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
