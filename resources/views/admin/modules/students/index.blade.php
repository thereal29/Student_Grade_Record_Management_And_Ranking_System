
@extends('layouts.master')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <h3 class="page-title">Students</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="">Student</a></li>
                                <li class="breadcrumb-item active">All Students</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            {{-- message --}}
            {!! Toastr::message() !!}
            <div class="student-group-form">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row d-flex">
                        <div class="col-md-12 m-0">
                            <small><small>Filter by Class Advisory:</small></small>
                        </div>
                            <div class="col-md-9">
                            <form action="" method="get">
                                <select name="adviser" id="adviser" class="form-select d-flex normselect2">
                                    <option></option>
                                    <option value="showall">Show all</option>
                                    @foreach($advisers as $adviser)
                                    <option value="{{$adviser->lastname}}" {{Request::get('adviser') == '$adviser->lastname' ? 'selected' : ''}}>{{$adviser->lastname}}, {{$adviser->firstname}} - {{$adviser->grade_level}} {{$adviser->section}}</option>
                                    @endforeach                                
                                </select>
                            </div>
                            </form>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-table comman-shadow">
                        <div class="card-body">
                            <div class="page-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h3 class="page-title">Students</h3>
                                    </div>
                                    <div class="col-auto text-end float-end ms-auto download-grp">
                                        <a href="#" class="btn btn-outline-primary me-2"><i class="fas fa-print"></i> Print</a>
                                        <a href="" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive" id="student_list">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- model student delete --}}
    <div class="modal fade contentmodal" id="studentUser" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content doctor-profile">
                <div class="modal-header pb-0 border-bottom-0  justify-content-end">
                    <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i
                        class="feather-x-circle"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST">
                        @csrf
                        <div class="delete-wrap text-center">
                            <div class="del-icon">
                                <i class="feather-x-circle"></i>
                            </div>
                            <input type="hidden" name="id" class="e_id" value="">
                            <input type="hidden" name="avatar" class="e_avatar" value="">
                            <h2>Sure you want to delete</h2>
                            <div class="submit-section">
                                <button type="submit" class="btn btn-success me-2">Yes</button>
                                <a class="btn btn-danger" data-bs-dismiss="modal">No</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @section('script')

    {{-- delete js --}}
    <script>
        $(document).on('click','.student_delete',function()
        {
            var _this = $(this).parents('tr');
            $('.e_id').val(_this.find('.id').text());
            $('.e_avatar').val(_this.find('.avatar').text());
        });
    </script>

    <script>
        $(document).ready(function(){
            fetchStudent();
            $("#adviser").on('change', function() {
                fetchStudent();
            });
            function fetchStudent(){
                var adviser = $('#adviser').val();
                $.ajax({
                type: "POST",
                url: "/fetch-students",
                data: {
                    "_token": "{{ csrf_token() }}",
                    adviser : adviser
                },
                dataType: "json",
                success: function (response) {
                    if (response.status == 'success') {
                        $('#student_list').html(response.query);
                    }else{
                        $('#student_list').html("");
                    }
                    if ($('.datatable').length > 0) {
                        $('.datatable').DataTable({
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
                        $('#phone_number_student').val(response.phone_number);
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
                        fetchStudent();
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
                    } 
                    });
                });
        });
    </script>
    @endsection


@endsection
