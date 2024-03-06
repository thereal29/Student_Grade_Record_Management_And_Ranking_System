@extends('layouts.master')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <h3 class="page-title">Faculty User Management</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item active">Faculty</li>
                                
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
                                        <a href="{{route('admin.faculty-user-add')}}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive" id="faculty-users">
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
            fetchUser();
            $("#sy").on('change', function() {
                fetchUser();
            });
            function fetchUser(){
                var sy = $('#sy').val();
                $.ajax({
                type: "POST",
                url: "/fetch-faculty-user",
                data: {
                    "_token": "{{ csrf_token() }}",
                    sy : sy
                },
                dataType: "json",
                success: function (response) {
                    if (response.status == 'success') {
                        $('#faculty-users').html(response.query);
                    }else{
                        $('#faculty-users').html("");
                    }
                    if ($('.datatables').length > 0) {
                        $('.datatables').DataTable({
                            "bFilter": true,
                        });
                    }
                }
                });
            }

            $(document).on('click', '.edit_faculty_user', function(e) {
                e.preventDefault();
                let id = $(this).attr('id');
                $('#editfacultyuser').modal('show');
                $.ajax({
                url: '{{ route('editFacultyUser') }}',
                method: 'get',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#faculty_id').val(response.fid);
                    $('#first_name_faculty').val(response.ffname);
                    $('#middle_name_faculty').val(response.fmname);
                    $('#last_name_faculty').val(response.flname);
                    $('#university_number_faculty').val(response.university_number);
                    $('#gender_faculty').val(response.gender);
                    $('#gender_faculty').select2();
                    $('#gender_faculty').select2({
                    minimumResultsForSearch: Infinity,
                    dropdownParent: $('#editfacultyuser')
                    });
                    $('#email_faculty').val(response.email);
                    $('#phone_faculty').val(response.phone_number);
                    $('#home_address_faculty').val(response.home_address);
                }
                });
            });
            $("#editFaculty").submit(function(e) {
                e.preventDefault();
                const fd = new FormData(this);
                $.ajax({
                url: '{{ route('updateFacultyUser') }}',
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 'success') {
                    Swal.fire(
                        'Updated!',
                        'Faculty Updated Successfully!',
                        'success'
                    )
                    fetchUser();
                    }
                    $("#editFaculty")[0].reset();
                    $("#editfacultyuser").modal('hide');
                },error:function(response){
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
                        if(response.responseJSON.errors.university_number){
                            $(".invalid-feedback-universitynumber").html('<small>'+ response.responseJSON.errors.university_number+'</small>');
                        }else{
                            $(".invalid-feedback-universitynumber").html('');
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
                        if(response.responseJSON.errors.home_address){
                            $(".invalid-feedback-homeaddress").html('<small>'+ response.responseJSON.errors.home_address+'</small>');
                        }else{
                            $(".invalid-feedback-homeaddress").html('');
                        }
                    } 
                });
                
            });


        });
    </script>
@endsection