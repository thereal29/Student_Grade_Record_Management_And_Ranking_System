@extends('layouts.master')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <h3 class="page-title">Add Staff</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('admin.staff-user')}}">Staff</a></li>
                                <li class="breadcrumb-item active">Add Staff</li>
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
                            <form action="{{route('admin.staff-user-create')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="form-title student-info">Staff Information
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
                                            <label>University Number <span class="login-danger">*</span></label>
                                            <input class="form-control @error('university_number') is-invalid @enderror" type="number" onKeyPress="if(this.value.length==12) return false;" name="university_number" placeholder="Enter University Number" value="{{ old('university_number') }}">
                                            @error('university_number')
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
                                        <div class="form-group local-forms" style="z-index: 9999 !important; width: 100% !important;">
                                            <label>Phone <span class="login-danger">*</span></label>
                                            <input class="form-control @error('phone_number') is-invalid @enderror" onKeyPress="if(this.value.length==10) return false;" id="phone" type="number" name="phone_number" placeholder="Enter Phone Number" value="{{ old('phone_number') }}">
                                            @error('phone_number')
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
                                            <label>Staff Role <span class="login-danger">*</span></label>
                                            <select class="form-control select  @error('staff_role') is-invalid @enderror" name="staff_role" data-placeholder="Select Role">
                                                <option></option>
                                                @if(auth()->user()->role == 'Super Administrator')
                                                <option value="2" {{ old('staffrole') == '2' ? "selected" :"Administrator"}}>Administrator</option>
                                                @endif
                                                <option value="3" {{ old('gender') == '3' ? "selected" :"Honors and Awards Committee"}}>Honors and Awards Committee</option>
                                                <option value="4" {{ old('gender') == '4' ? "selected" :"Guidance Facilitator"}}>Guidance Facilitator</option>
                                            </select>
                                            @error('staff_role')
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
