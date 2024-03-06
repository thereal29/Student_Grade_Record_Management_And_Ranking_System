@extends('layouts.master')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <h3 class="page-title">Student User Management</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item active">Student</li>
                                
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            {{-- message --}}
            {!! Toastr::message() !!}
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-table mb-0">
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <small><small>Filter by School Year:</small></small>
                                    <div class="col-md-6">
                                        <select name="schoolyear" id="sy" class="form-select d-flex normselect" data-placeholder="Select School Year">
                                            <option></option>
                                            <option value="showall">Show all</option>
                                            @foreach($schoolyear as $schoolyear)
                                            <option value="{{$schoolyear->from_year}}" {{Request::get('schoolyear') == '$schoolyear->id' ? 'selected' : ''}}>{{$schoolyear->from_year}} - {{$schoolyear->to_year}}</option>
                                            @endforeach                                
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="col-auto text-end float-end ms-auto download-grp">
                                        <a href="#" class="btn btn-outline-gray me-2 active">
                                            <i class="fa fa-list" aria-hidden="true"></i>
                                        </a>
                                        <a href="#" class="btn btn-outline-gray me-2">
                                            <i class="fa fa-th" aria-hidden="true"></i>
                                        </a>
                                        <a href="#" class="btn btn-outline-primary me-2"><i class="fas fa-download"></i> Download</a>
                                        <a href="{{route('admin.student-user-add')}}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="profile-menu" style="background-color:#e7ffce">
                                <ul class="nav nav-tabs nav-tabs-solid" style="justify-content:center;">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href=".grade7">Grade 7</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href=".grade8">Grade 8</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href=".grade9">Grade 9</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href=".grade10">Grade 10</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href=".grade11">Grade 11</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href=".grade12">Grade 12</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content">
                    <div id="Grade 7" class="tab-pane fade show active gradeTab grade7">
                        <div class="card">
                            <div class="card-body">
                                <div class="row align-items-center pb-3">
                                    <div class="col-auto text-end float-end ms-auto download-grp">
                                        <a href="#" class="btn btn-outline-primary me-2"><i class="fas fa-print"></i> Print</a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-10 col-lg-12">
                                        <div class="table-responsive" id="grade7users">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="Grade 8" class="tab-pane fade gradeTab grade8">
                        <div class="card">
                            <div class="card-body">
                                <div class="row align-items-center pb-3">
                                    <div class="col-auto text-end float-end ms-auto download-grp">
                                        <a href="#" class="btn btn-outline-primary me-2"><i class="fas fa-print"></i> Print</a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-10 col-lg-12">
                                        <div class="table-responsive" id="grade8users">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="Grade 9" class="tab-pane fade gradeTab grade9">
                        <div class="card">
                            <div class="card-body">
                                <div class="row align-items-center pb-3">
                                    <div class="col-auto text-end float-end ms-auto download-grp">
                                        <a href="#" class="btn btn-outline-primary me-2"><i class="fas fa-print"></i> Print</a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-10 col-lg-12">
                                        <div class="table-responsive" id="grade9users">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="Grade 10" class="tab-pane fade gradeTab grade10">
                        <div class="card">
                            <div class="card-body">
                                <div class="row align-items-center pb-3">
                                    <div class="col-auto text-end float-end ms-auto download-grp">
                                        <a href="#" class="btn btn-outline-primary me-2"><i class="fas fa-print"></i> Print</a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-10 col-lg-12">
                                        <div class="table-responsive" id="grade10users">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="Grade 11" class="tab-pane fade gradeTab grade11">
                        <div class="card">
                            <div class="card-body">
                                <div class="row align-items-center pb-3">
                                    <div class="col-auto text-end float-end ms-auto download-grp">
                                        <a href="#" class="btn btn-outline-primary me-2"><i class="fas fa-print"></i> Print</a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-10 col-lg-12">
                                        <div class="table-responsive" id="grade11users">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="Grade 12" class="tab-pane fade gradeTab grade12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row align-items-center pb-3">
                                    <div class="col-auto text-end float-end ms-auto download-grp">
                                        <a href="#" class="btn btn-outline-primary me-2"><i class="fas fa-print"></i> Print</a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-10 col-lg-12">
                                        <div class="table-responsive" id="grade12users">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function(){
            var grade = "Grade 7";
            fetchUser();
            $("#sy").on('change', function() {
                fetchUser();
            });
            
            $('a[data-bs-toggle="tab"]').on('show.bs.tab', function(e) {
                var tab = $(e.target);
                var contentId = tab.attr("href");
                grade = $(contentId).attr('id');
                fetchUser();
                
            });
            function fetchUser(){
                var sy = $('#sy').val();
                let gradelevel = grade;
                $.ajax({
                type: "POST",
                url: "/fetch-student-user",
                data: {
                    "_token": "{{ csrf_token() }}",
                    gradelevel : gradelevel,
                    sy : sy
                },
                dataType: "json",
                success: function (response) {
                    if (response.status == 'success') {
                        $('#grade7users').html(response.query);
                        $('#grade8users').html(response.query);
                        $('#grade9users').html(response.query);
                        $('#grade10users').html(response.query);
                        $('#grade11users').html(response.query);
                        $('#grade12users').html(response.query);
                    }else{
                        $('#grade7users').html("");
                        $('#grade8users').html("");
                        $('#grade9users').html("");
                        $('#grade10users').html("");
                        $('#grade11users').html("");
                        $('#grade12users').html("");
                    }
                    if ($('.datatables').length > 0) {
                        $('.datatables').DataTable({
                            "bFilter": true,
                        });
                    }
                    }
                    });
                }

                $('#grade_level_student').on('change', function() {
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
                                    $('#section_student').empty();
                                    $('#section_student').select2({
                                    placeholder: "Select Section",
                                    minimumResultsForSearch: Infinity,
                                    dropdownParent: $('#editstudentuser')
                                    });
                                    $('#section_student').append('<option></option>'); 
                                    $.each(data, function(key, gradelevels){
                                        $('select[name="section"]').append('<option value="'+ gradelevels.section +'">' + gradelevels.section + '</option>');
                                    });
                                }else{
                                    $('#section_student').empty();
                                }
                            }
                        });
                    }else{
                        $('#section_student').empty();
                    }
                });

                $(document).on('click', '.edit_student_user', function(e) {
                    e.preventDefault();
                    let id = $(this).attr('id');
                    $('#editstudentuser').modal('show');
                    $.ajax({
                    url: '{{ route('editStudentUser') }}',
                    method: 'get',
                    data: {
                        id: id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if(response.grade_level) {
                        $.ajax({
                            url: '/getSection/'+response.grade_level,
                            type: "GET",
                            data : {"_token":"{{ csrf_token() }}"},
                            dataType: "json",
                            success:function(data)
                            {
                                if(data){
                                    $('#section_student').empty();
                                    $('#section_student').select2({
                                    minimumResultsForSearch: Infinity,
                                    dropdownParent: $('#editstudentuser')
                                    }); 
                                    $.each(data, function(key, gradelevels){
                                        $('select[name="section"]').append('<option value="'+ gradelevels.section +'" selected>' + gradelevels.section + '</option>');
                                    });
                                }else{
                                    $('#section_student').empty();
                                }
                            }
                        });
                    }else{
                        $('#section_student').empty();
                    }
                        $('#student_id').val(response.sid);
                        $('#first_name_student').val(response.sfname);
                        $('#middle_name_student').val(response.smname);
                        $('#last_name_student').val(response.slname);
                        $('#lrn_number_student').val(response.lrn_number);
                        $('#grade_level_student').val(response.grade_level);
                        $('#grade_level_student').select2();
                        $('#grade_level_student').select2({
                        minimumResultsForSearch: Infinity,
                        dropdownParent: $('#editstudentuser')
                        });
                        $('#gender_student').val(response.gender);
                        $('#gender_student').select2();
                        $('#gender_student').select2({
                        minimumResultsForSearch: Infinity,
                        dropdownParent: $('#editstudentuser')
                        });
                        $('#email_student').val(response.email);
                        $('#phone').val(response.phone_number);
                        $('#dateofbirth').val(response.birth_date);
                        $('#age_student').val(response.age);
                        $('#home_address_student').val(response.home_address);
                        $('#parent_name_student').val(response.parent_name);
                        $('#parent_address_student').val(response.parent_address);
                        $('#school_graduated').val(response.previous_school_graduated);
                        $('#year_grad').val(response.year_graduated);
                        $('#gpa_student').val(response.previous_school_average);
                    }
                    });
                });
                $("#editStudent").submit(function(e) {
                    e.preventDefault();
                    var fd = $(this).serialize();
                    $.ajax({
                    url: '{{ route('updateStudentUser') }}',
                    method: 'post',
                    data: fd,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 'success') {
                        Swal.fire(
                            'Updated!',
                            'Student Updated Successfully!',
                            'success'
                        )
                        fetchUser();
                        }
                        $("#editStudent")[0].reset();
                        $("#editstudentuser").modal('hide');
                    },
                    error:function(response){
                        if(response.responseJSON.errors.first_name){
                            $(".invalid-feedback-firstname").html('<small>'+ response.responseJSON.errors.first_name+'</small>');
                        }else{
                            $(".invalid-feedback-firstname").html('');
                        }
                        if(response.responseJSON.errors.middle_name){
                            $(".invalid-feedback-middlename").html('<small>'+ response.responseJSON.errors.middle_name+'</small>');
                        }else{
                            $(".invalid-feedback-middlename").html('');
                        }
                        if(response.responseJSON.errors.last_name){
                            $(".invalid-feedback-lastname").html('<small>'+ response.responseJSON.errors.last_name+'</small>');
                        }else{
                            $(".invalid-feedback-lastname").html('');
                        }
                        if(response.responseJSON.errors.lrn_number){
                            $(".invalid-feedback-lrnnumber").html('<small>'+ response.responseJSON.errors.lrn_number+'</small>');
                        }else{
                            $(".invalid-feedback-lrnnumber").html('');
                        }
                        if(response.responseJSON.errors.grade_level){
                            $(".invalid-feedback-gradelevel").html('<small>'+ response.responseJSON.errors.grade_level+'</small>');
                        }else{
                            $(".invalid-feedback-gradelevel").html('');
                        }
                        if(response.responseJSON.errors.section){
                            $(".invalid-feedback-section").html('<small>'+ response.responseJSON.errors.section+'</small>');
                        }else{
                            $(".invalid-feedback-section").html('');
                        }
                        if(response.responseJSON.errors.gender){
                            $(".invalid-feedback-gender").html('<small>'+ response.responseJSON.errors.gender+'</small>');
                        }else{
                            $(".invalid-feedback-gender").html('');
                        }
                        if(response.responseJSON.errors.email){
                            $(".invalid-feedback-email").html('<small>'+ response.responseJSON.errors.email+'</small>');
                        }else{
                            $(".invalid-feedback-email").html('');
                        }
                        if(response.responseJSON.errors.phone_number){
                            $(".invalid-feedback-phone").html('<small>'+ response.responseJSON.errors.phone_number+'</small>');
                        }else{
                            $(".invalid-feedback-phone").html('');
                        }
                        if(response.responseJSON.errors.phone_number){
                            $(".invalid-feedback-phone").html('<small>'+ response.responseJSON.errors.phone_number+'</small>');
                        }else{
                            $(".invalid-feedback-phone").html('');
                        }
                        if(response.responseJSON.errors.date_of_birth){
                            $(".invalid-feedback-dateofbirth").html('<small>'+ response.responseJSON.errors.date_of_birth+'</small>');
                        }else{
                            $(".invalid-feedback-dateofbirth").html('');
                        }
                        if(response.responseJSON.errors.age){
                            $(".invalid-feedback-age").html('<small>'+ response.responseJSON.errors.age+'</small>');
                        }else{
                            $(".invalid-feedback-age").html('');
                        }
                        if(response.responseJSON.errors.home_address){
                            $(".invalid-feedback-homeaddress").html('<small>'+ response.responseJSON.errors.home_address+'</small>');
                        }else{
                            $(".invalid-feedback-homeaddress").html('');
                        }
                        if(response.responseJSON.errors.parent_name){
                            $(".invalid-feedback-parentname").html('<small>'+ response.responseJSON.errors.parent_name+'</small>');
                        }else{
                            $(".invalid-feedback-parentname").html('');
                        }
                        if(response.responseJSON.errors.parent_address){
                            $(".invalid-feedback-parentaddress").html('<small>'+ response.responseJSON.errors.parent_address+'</small>');
                        }else{
                            $(".invalid-feedback-parentaddress").html('');
                        } 
                        if(response.responseJSON.errors.previous_school){
                            $(".invalid-feedback-previousschool").html('<small>'+ response.responseJSON.errors.previous_school+'</small>');
                        }else{
                            $(".invalid-feedback-previousschool").html('');
                        }  
                        if(response.responseJSON.errors.year_graduated){
                            $(".invalid-feedback-yeargraduated").html('<small>'+ response.responseJSON.errors.year_graduated+'</small>');
                        }else{
                            $(".invalid-feedback-yeargraduated").html('');
                        }
                        if(response.responseJSON.errors.gpa){
                            $(".invalid-feedback-gpa").html('<small>'+ response.responseJSON.errors.gpa+'</small>');
                        }else{
                            $(".invalid-feedback-gpa").html('');
                        }
                    } 
                    });
                });

        });
    </script>
@endsection