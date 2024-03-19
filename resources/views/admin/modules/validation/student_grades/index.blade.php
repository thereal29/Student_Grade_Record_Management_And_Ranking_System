@extends('layouts.master')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <h3 class="page-title">Student Grades Validation</h3>
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
                            <div class="col-md-9">
                                <small><small>Filter by School Year:</small></small>
                                <div class="col-md-12">
                                    <select name="schoolyear" id="sy" class="form-select d-flex normselect" data-placeholder="Select School Year">
                                        <option></option>
                                        <option value="showall">Show all</option>
                                        @foreach($schoolyear as $schoolyear)
                                        <option value="{{$schoolyear->from_year}}" {{Request::get('schoolyear') == '$schoolyear->id' ? 'selected' : ''}}>{{$schoolyear->from_year}} - {{$schoolyear->to_year}}</option>
                                        @endforeach                                
                                    </select>
                                </div>
                            </div>
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
                                        <h3 class="page-title"></h3>
                                    </div>
                                    <div class="col-auto text-end float-end ms-auto download-grp">
                                        <a href="#" class="btn btn-outline-primary me-2"><i class="fas fa-print"></i> Print</a>
                                        <a href="{{route('admin.student-user-add')}}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive" id="student_grades">
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
            var id = 0;
            fetchStudentGrades();
            $("#sy").on('change', function() {
                fetchStudentGrades();
            });
            function fetchStudentGrades(){
                var sy = $('#sy').val();
                $.ajax({
                type: "POST",
                url: "/fetch-validation-grades",
                data: {
                    "_token": "{{ csrf_token() }}",
                    sy : sy
                },
                dataType: "json",
                success: function (response) {
                    if (response.status == 'success') {
                        $('#student_grades').html(response.query);
                    }else{
                        $('#student_grades').html("");
                    }
                    if ($('.datatables').length > 0) {
                        $('.datatables').DataTable({
                            "bFilter": true,
                        });
                    }
                }
                });
            }
            function fetchGradesValidation(){
                var cid = id;
                $.ajax({
                type: "get",
                url: "/fetch-view-validation-grades",
                data: {
                    "_token": "{{ csrf_token() }}",
                    id : cid
                },
                dataType: "json",
                success: function (response) {
                    $('.grades_validation_modal_title').html('<small style="color:#fff;">'+response.class.firstname+' '+response.class.lastname+' - ('+response.class.subject_code+' '+response.class.subject_description+')'+'</small>');
                    if (response.status == 'success') {
                        $('#gradesValidationTable').html(response.query);
                    }else{
                        $('#gradesValidationTable').html("");
                    }
                    if ($('.datatables_validate').length > 0) {
                        $('.datatables_validate').DataTable({
                            "bFilter": true,
                        });
                    }
                }
                });
            }
            function fetchGradesValidated(){
                var cid = id;
                $.ajax({
                type: "get",
                url: "/fetch-view-validated-grades",
                data: {
                    "_token": "{{ csrf_token() }}",
                    id : cid
                },
                dataType: "json",
                success: function (response) {
                    $('.grades_validated_modal_title').html('<small style="color:#fff;">'+response.class.firstname+' '+response.class.lastname+' - ('+response.class.subject_code+' '+response.class.subject_description+')'+'</small>');
                    if (response.status == 'success') {
                        $('#gradesValidatedTable').html(response.query);
                    }else{
                        $('#gradesValidatedTable').html("");
                    }
                    if ($('.datatables_validate').length > 0) {
                        $('.datatables_validate').DataTable({
                            "bFilter": true,
                        });
                    }
                }
                });
            }

            $(document).on('click', '.view_approval', function() {
            $('#grades_validation_modal').modal('show');
            id = $(this).attr('id');
            fetchGradesValidation();
            });
            $(document).on('click', '.view_approved', function() {
            $('#grades_validated_modal').modal('show');
            id = $(this).attr('id');
            fetchGradesValidated();
            });

            $('#grades_validated_modal').on('hidden.bs.modal', function (e) {
                // Modal is closed or hidden
                $('.datatables_validate').DataTable().destroy();
                // Perform any actions you want here
            });
            $('#grades_validation_modal').on('hidden.bs.modal', function (e) {
                // Modal is closed or hidden
                $('.datatables_validate').DataTable().destroy();
                // Perform any actions you want here
            });

            $("#validateGrades").submit(function(e) {
            e.preventDefault();
            var fd = $(this).serialize();
            $.ajax({
            url: '{{ route('validateGrades') }}',
            method: 'post',
            data: fd,
            dataType: 'json',
            success: function(response) {
                if (response.status == 'success') {
                Swal.fire(
                    'Validated!',
                    'Grades Validated Successfully!',
                    'success'
                )
                fetchStudentGrades();
                }
                $("#validateGrades")[0].reset();
                $("#grades_validation_modal").modal('hide');
            },error: function(response) {
                Swal.fire(
                    'Error!',
                    'Cannot be Validated !',
                    'error'
                )
            },
            });
            });



        });
    </script>
@endsection