
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
                                <li class="breadcrumb-item"><a href="{{ route('admin/student_record') }}">Student</a></li>
                                <li class="breadcrumb-item active">Grades</li>
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
                                        <h3 class="page-title">Student Grades</h3>
                                    </div>
                                </div>
                                <div class="row pb-3" style="border-bottom:2px solid #5e8e44;">
                                    <div class="col-md-6">
                                        <div class="row d-flex">
                                            <div class="col-md-12 m-0">
                                                <small><small>Select Grade Level:</small></small>
                                            </div>
                                            <div class="col-md-9 m-0">
                                                <select name="gradelevel" id="gradelevel" data-placeholder="Select Grade Level" class="form-control d-flex normselect" >
                                                    <option value=""></option>
                                                    <option value="Grade 7" {{$currGrade == 'Grade 7' ? 'selected' : ''}}> Grade 7</option>
                                                    <option value="Grade 8" {{$currGrade == 'Grade 8' ? 'selected' : ''}}> Grade 8</option>
                                                    <option value="Grade 9" {{$currGrade == 'Grade 9' ? 'selected' : ''}}> Grade 9</option>
                                                    <option value="Grade 10" {{$currGrade == 'Grade 10' ? 'selected' : ''}}> Grade 10</option>
                                                    <option value="Grade 11" {{$currGrade == 'Grade 11' ? 'selected' : ''}}> Grade 11</option>
                                                    <option value="Grade 12" {{$currGrade == 'Grade 12' ? 'selected' : ''}}> Grade 12</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-auto text-end float-end ms-auto">
                                                <strong class="me-5">GPA:  </strong>
                                                <small></small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive" id="gradeList">
                                
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
                // Grades
                $("#gradelevel").on('change', function() {
                    fetchGrades();
                });
                fetchGrades();
                function fetchGrades(){
                    var data = {
                            'gradelevel': $('#gradelevel').val(),
                        }
                    $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                    $.ajax({
                    type: "POST",
                    url: "/fetch-grades",
                    data: data,
                    dataType: "json",
                    success: function (response) {
                        console.log(response.activities);
                        if (response.status == 'success') {
                            $('#gradeList').html(response.query);
                        }else{
                            $('#gradeList').html("");
                        }
                    }
                    });
                }
            });
        </script>
        @endsection
@endsection
