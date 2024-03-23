
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
                                <li class="breadcrumb-item"><a href="{{ route('admin/student_record') }}">Student Records</a></li>
                                <li class="breadcrumb-item active">Academic Record</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            {{-- message --}}
            {!! Toastr::message() !!}
            <div class="student-group-form">
                <div class="row align-items-center">
                    <div class="col-auto ms-auto me-3 download-grp">
                        <a type="button" class="btn btn-primary" style="float:right; background:#05300e; color:#fff;" href="{{ route('admin/student_record') }}"> Back</a>
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
                                                    <option value="Grade 7" {{$record->grade_level == 'Grade 7' ? 'selected' : ''}}> Grade 7</option>
                                                    <option value="Grade 8" {{$record->grade_level == 'Grade 8' ? 'selected' : ''}}> Grade 8</option>
                                                    <option value="Grade 9" {{$record->grade_level == 'Grade 9' ? 'selected' : ''}}> Grade 9</option>
                                                    <option value="Grade 10" {{$record->grade_level == 'Grade 10' ? 'selected' : ''}}> Grade 10</option>
                                                    <option value="Grade 11" {{$record->grade_level == 'Grade 11' ? 'selected' : ''}}> Grade 11</option>
                                                    <option value="Grade 12" {{$record->grade_level == 'Grade 12' ? 'selected' : ''}}> Grade 12</option>
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
                                    <div class="col-md-6 m-0">                                                                  
                                        
                                    </div>
                                </div>
                                <div class="col-md-12 mt-4">
                                    <strong>LRN Number: </strong>
                                    <small>{{$record->lrn_number}}</small></br>
                                    <strong>Name: </strong>
                                    <small class="text-uppercase">{{$record->fnameStud. ' ' .$record->mnameStud. ' ' .$record->lnameStud }}</small></br>
                                    <strong>Grade & Section: </strong>
                                    <small class="text-uppercase">{{$record->grade_level. ' ' .$record->section}}</small></br>
                                    <strong>Adviser: </strong>
                                    <small class="text-uppercase">{{$record->firstname. ' ' .$record->lastname}}</small></br>
                                    <input type="text" value="{{$record->studID}}" id="std_id" hidden>
                                </div>
                            </div>
                            <div class="table-responsive" id="view_record">
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
                fetchGradeRecord();
                $("#gradelevel").on('change', function() {
                    fetchGradeRecord();
                });
                function fetchGradeRecord(){
                    var gradelevel = $('#gradelevel').val();
                    var student_id = $('#std_id').val();
                    $.ajax({
                    type: "POST",
                    url: "/fetch-staff-record",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        gradelevel : gradelevel,
                        student_id : student_id
                    },
                    dataType: "json",
                    success: function (response) {
                        if (response.status == 'success') {
                            $('#view_record').html(response.query);
                        }else{
                            $('#view_record').html("");
                        }
                        }
                        });
                    }
            });
        </script>
        @endsection
@endsection
