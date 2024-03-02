
@extends('layouts.master')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <h3 class="page-title">Student Subjects</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item active">Student Subjects</li>
                                
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            {{-- message --}}
            {!! Toastr::message() !!}
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-table comman-shadow">
                        <div class="card-body">
                            <div class="page-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h3 class="page-title">Students</h3>
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
                                                        <option value="">Show all Students</option>
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
                            <div class="table-responsive" id="registration_list">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('script')
    <script>
        $(document).ready(function(){
            fetchStudentRegistration();
            $("#gradelevel").on('change', function() {
                fetchStudentRegistration();
            });
            function fetchStudentRegistration(){
                var gradelevel = $('#gradelevel').val();
                $.ajax({
                type: "POST",
                url: "/fetch-student-registration",
                data: {
                    "_token": "{{ csrf_token() }}",
                    gradelevel : gradelevel
                },
                dataType: "json",
                success: function (response) {
                    if (response.status == 'success') {
                        $('#registration_list').html(response.query);
                    }else{
                        $('#registration_list').html("");
                    }
                    if ($('.datatable').length > 0) {
                        $('.datatable').DataTable({
                            "bFilter": true,
                        });
                    }
                    }
                    });
                }
        });
    </script>
    @endsection
@endsection
