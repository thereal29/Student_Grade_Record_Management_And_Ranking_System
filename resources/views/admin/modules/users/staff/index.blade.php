@extends('layouts.master')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <h3 class="page-title">Staff User Management</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item active">Staff</li>
                                
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
                                        <a href="{{route('admin.staff-user-add')}}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="profile-menu" style="background-color:#e7ffce">
                                <ul class="nav nav-tabs nav-tabs-solid" style="justify-content:center;">
                                    @if(auth()->user()->role == 'Super Administrator')
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href=".admin">Administrator</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href=".committee">Honors and Awards Committee</a>
                                    </li>
                                    @endif
                                    @if(auth()->user()->role == 'Administrator')
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href=".committee">Honors and Awards Committee</a>
                                    </li>
                                    @endif
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href=".guidancefaci">Guidance Facilitator</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content" id="{{auth()->user()->role}}">
                    @if(auth()->user()->role == 'Super Administrator')
                    <div id="2" class="tab-pane fade show active staffTab admin">
                        <div class="card">
                            <div class="card-body">
                                <div class="row align-items-center pb-3">
                                    <div class="col-auto text-end float-end ms-auto download-grp">
                                        <a href="#" class="btn btn-outline-primary me-2"><i class="fas fa-print"></i> Print</a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-10 col-lg-12">
                                        <div class="table-responsive" id="admin">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="3" class="tab-pane fade staffTab committee">
                        <div class="card">
                            <div class="card-body">
                                <div class="row align-items-center pb-3">
                                    <div class="col-auto text-end float-end ms-auto download-grp">
                                        <a href="#" class="btn btn-outline-primary me-2"><i class="fas fa-print"></i> Print</a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-10 col-lg-12">
                                        <div class="table-responsive" id="committee">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    @if(auth()->user()->role == 'Administrator')
                    <div id="3" class="tab-pane fade show active staffTab committee">
                        <div class="card">
                            <div class="card-body">
                                <div class="row align-items-center pb-3">
                                    <div class="col-auto text-end float-end ms-auto download-grp">
                                        <a href="#" class="btn btn-outline-primary me-2"><i class="fas fa-print"></i> Print</a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-10 col-lg-12">
                                        <div class="table-responsive" id="committee">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div id="4" class="tab-pane fade staffTab guidancefaci">
                        <div class="card">
                            <div class="card-body">
                                <div class="row align-items-center pb-3">
                                    <div class="col-auto text-end float-end ms-auto download-grp">
                                        <a href="#" class="btn btn-outline-primary me-2"><i class="fas fa-print"></i> Print</a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-10 col-lg-12">
                                        <div class="table-responsive" id="guidance">
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
  $(document).ready(function() {
    
  });
</script>
    <script>
        $(document).ready(function(){
            let temp = $('.tab-content').attr('id');
            if(temp == "Super Administrator"){
                var role = '2';
            }else{
                var role = '3';
            }
            
            fetchUser();
            $("#sy").on('change', function() {
                fetchUser();
            });
            
            $('a[data-bs-toggle="tab"]').on('show.bs.tab', function(e) {
                var tab = $(e.target);
                var contentId = tab.attr("href");
                role = $(contentId).attr('id');
                fetchUser();
                
            });
            function fetchUser(){
                var sy = $('#sy').val();
                let staffRole = role;
                $.ajax({
                type: "POST",
                url: "/fetch-staff-user",
                data: {
                    "_token": "{{ csrf_token() }}",
                    staffRole : staffRole,
                    sy : sy
                },
                dataType: "json",
                success: function (response) {
                    if (response.status == 'success') {
                        $('#admin').html(response.query);
                        $('#committee').html(response.query);
                        $('#guidance').html(response.query);
                    }else{
                        $('#admin').html("");
                        $('#committee').html("");
                        $('#guidance').html("");
                    }
                    if ($('.datatables').length > 0) {
                        $('.datatables').DataTable({
                            "bFilter": true,
                        });
                    }
                    }
                    });
                }
                $(document).on('click', '.staff_delete', function(e) {
                e.preventDefault();
                let id = $(this).attr('id');
                let csrf = '{{ csrf_token() }}';
                Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to retrieve this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#05300e',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                    url: '{{ route('deleteSY') }}',
                    method: 'delete',
                    data: {
                        id: id,
                        _token: csrf
                    },
                    success: function(response) {
                        console.log(response);
                        Swal.fire(
                        'Success',
                        'Deleted Successfully',
                        'success'
                        )
                        fetchSY();
                    }
                    });
                }
                })
                });

                $(document).on('click', '.edit_staff_user', function(e) {
                    e.preventDefault();
                    let id = $(this).attr('id');
                    $('#editstaffuser').modal('show');
                    $.ajax({
                    url: '{{ route('editStaffUser') }}',
                    method: 'get',
                    data: {
                        id: id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#staff_id').val(response.fid);
                        $('#first_name').val(response.ffname);
                        $('#middle_name').val(response.fmname);
                        $('#last_name').val(response.flname);
                        $('#university_number').val(response.university_number);
                        $('#gender').val(response.gender);
                        $('#gender').select2();
                        $('#gender').select2({
                        minimumResultsForSearch: Infinity,
                        dropdownParent: $('#editstaffuser')
                        });
                        $('#email').val(response.email);
                        $('#staff_role').val(response.role);
                        $('#staff_role').select2();
                        $('#staff_role').select2({
                        minimumResultsForSearch: Infinity,
                        dropdownParent: $('#editstaffuser')
                        });
                    }
                    });
                });
                $("#editStaff").submit(function(e) {
                    e.preventDefault();
                    const fd = new FormData(this);
                    $.ajax({
                    url: '{{ route('updateStaffUser') }}',
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
                            'Staff Updated Successfully!',
                            'success'
                        )
                        fetchUser();
                        }
                        $("#editStaff")[0].reset();
                        $("#editstaffuser").modal('hide');
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
                        if(response.responseJSON.errors.staff_role){
                            $(".invalid-feedback-staffrole").html('<small>'+ response.responseJSON.errors.staff_role+'</small>');
                        }else{
                            $(".invalid-feedback-staffrole").html('');
                        }
                    } 
                    });
                });

        });
    </script>
@endsection