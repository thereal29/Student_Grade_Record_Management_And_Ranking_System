
@extends('layouts.master')
@section('content')
    {{-- message --}}
    {!! Toastr::message() !!}
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Class Advisories</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Class Advisory</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-table">
                        <div class="card-body">
                            <div class="page-header">
                                <div class="row align-items-center">
                                    <div class="col-auto text-end float-end ms-auto download-grp">
                                        <a href="#" class="btn btn-outline-primary me-2">
                                            <i class="fas fa-print"></i> Print
                                        </a>
                                        <a  class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addnewsectionmodal">
                                            <i class="fas fa-plus"></i>
                                        </a>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row d-flex">
                                            <div class="col-md-12 m-0">
                                                <small><small>Select Grade Level:</small></small>
                                            </div>
                                                <div class="col-md-9">
                                                <form action="" method="get">
                                                    <select name="gradelevel" id="gradelevel" class="form-select d-flex normselect">
                                                        <option value="">Show all Section</option>
                                                        <!-- <option value="">No Enrolled Students</option> -->
                                                        <option value="Grade 7" {{Request::get('gradelevel') == 'Grade 7' ? 'selected' : ''}}> Grade 7</option>
                                                        <option value="Grade 8" {{Request::get('gradelevel') == 'Grade 8' ? 'selected' : ''}}> Grade 8</option>
                                                        <option value="Grade 9" {{Request::get('gradelevel') == 'Grade 9' ? 'selected' : ''}}> Grade 9</option>
                                                        <option value="Grade 10" {{Request::get('gradelevel') == 'Grade 10' ? 'selected' : ''}}> Grade 10</option>
                                                        <option value="Grade 11" {{Request::get('gradelevel') == 'Grade 11' ? 'selected' : ''}}> Grade 11</option>
                                                        <option value="Grade 12" {{Request::get('gradelevel') == 'Grade 12' ? 'selected' : ''}}> Grade 12</option>
                                                    </select>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive" id="section_list">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- model elete --}}
    <div class="modal custom-modal fade" id="delete" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Delete Subject</h3>
                        <p>Are you sure want to delete?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <div class="row">
                            <form action="" method="POST">
                                @csrf
                                <input type="hidden" name="subject_id" class="e_subject_id" value="">
                                <div class="row">
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-primary paid-continue-btn" style="width: 100%;">Delete</button>
                                    </div>
                                    <div class="col-6">
                                        <a data-bs-dismiss="modal"
                                            class="btn btn-primary paid-cancel-btn">Cancel
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @section('script')
        {{-- delete js --}}
        <script>
            
        </script>
        <script>
            $(document).ready(function(){
                fetchSection();
                $("#gradelevel").on('change', function() {
                    fetchSection();
                });

                $(document).on('click', '.delete_section', function(e) {
                e.preventDefault();
                let id = $(this).attr('id');
                let totalStud = $(this).attr('value');
                let csrf = '{{ csrf_token() }}';
                if(totalStud == 0){
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
                        url: '{{ route('deleteSection') }}',
                        method: 'delete',
                        data: {
                            id: id,
                            _token: csrf
                        },
                        success: function(response) {
                            console.log(response);
                            Swal.fire(
                            'Deleted!',
                            'Subject  has been deleted.',
                            'success'
                            )
                            fetchSection();
                        }
                        });
                    }
                })   
                }else{
                    Swal.fire({
                    title: 'Restricted',
                    text: "You won't be able to delete this!",
                    icon: 'info',
                    })
                }
            });

                    function fetchSection(){
                        var gradelevel = $('#gradelevel').val();
                        $.ajax({
                        type: "POST",
                        url: "/fetch-section",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            gradelevel : gradelevel
                        },
                        dataType: "json",
                        success: function (response) {
                            console.log(response.activities);
                            if (response.status == 'success') {
                                $('#section_list').html(response.query);
                            }else{
                                $('#section_list').html("");
                            }
                            if ($('.datatable').length > 0) {
                                $('.datatable').DataTable({
                                    "bFilter": true,
                                });
                            }
                        }
                        });
                    }
                    $(document).on('click', '.edit_section', function(e) {
                    e.preventDefault();
                    let id = $(this).attr('id');
                    $('#editsectionmodal').modal('show');
                    $.ajax({
                    url: '{{ route('editSection') }}',
                    method: 'get',
                    data: {
                        id: id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#sec_id').val(response.sid);
                        $('#editsectionlevel').val(response.grade_level);
                        $('#editsectionlevel').select2();
                        $('#editsectionlevel').select2({
                        minimumResultsForSearch: Infinity,
                        dropdownParent: $('#editsectionmodal')
                        });
                        $('#editsection').val(response.section);
                        $('#editfaculty').val(response.fid);
                        $('#editfaculty').select2();
                        $('#editfaculty').select2({
                        minimumResultsForSearch: Infinity,
                        dropdownParent: $('#editsectionmodal')
                        });
                    }
                    });
                    
                });
                $("#editSection").submit(function(e) {
                    e.preventDefault();
                    var fd = $(this).serialize();
                    $.ajax({
                    url: '{{ route('updateSection') }}',
                    method: 'post',
                    data: fd,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 'success') {
                        Swal.fire(
                            'Updated!',
                            'Class Advisory Updated Successfully!',
                            'success'
                        )
                        fetchSection();
                        }
                        $("#editSection")[0].reset();
                        $("#editsectionmodal").modal('hide');
                    },
                    error:function(response){
                        if(response.responseJSON.errors.section){
                            $(".invalid-feedback-section").html('<small>'+ response.responseJSON.errors.section+'</small>');
                        }else{
                            $(".invalid-feedback-section").html('');
                        }
                        if(response.responseJSON.errors.grade_level){
                            $(".invalid-feedback-grade_level").html('<small>'+ response.responseJSON.errors.grade_level+'</small>');
                        }else{
                            $(".invalid-feedback-grade_level").html('');
                        }
                        if(response.responseJSON.errors.faculty){
                            $(".invalid-feedback-faculty").html('<small>'+ response.responseJSON.errors.faculty+'</small>');
                        }else{
                            $(".invalid-feedback-faculty").html('');
                        }
                    } 
                    });
                });


                $("#addSection").submit(function(e) {
                    e.preventDefault();
                    var fd = $(this).serialize();
                    $.ajax({
                    url: '{{ route('addSection') }}',
                    method: 'post',
                    data: fd,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 'success') {
                        Swal.fire(
                            'Added!',
                            'Class Advisory Added Successfully!',
                            'success'
                        )
                        fetchSection();
                        }
                        $("#addSection")[0].reset();
                        $("#addnewsectionmodal").modal('hide');
                    },
                    error:function(response){
                        if(response.responseJSON.errors.section){
                            $(".invalid-feedback-section").html('<small>'+ response.responseJSON.errors.section+'</small>');
                        }else{
                            $(".invalid-feedback-section").html('');
                        }
                        if(response.responseJSON.errors.grade_level){
                            $(".invalid-feedback-grade_level").html('<small>'+ response.responseJSON.errors.grade_level+'</small>');
                        }else{
                            $(".invalid-feedback-grade_level").html('');
                        }
                        if(response.responseJSON.errors.faculty){
                            $(".invalid-feedback-faculty").html('<small>'+ response.responseJSON.errors.faculty+'</small>');
                        }else{
                            $(".invalid-feedback-faculty").html('');
                        }
                    } 
                    });
                });
                

            });
        </script>
    @endsection

@endsection
