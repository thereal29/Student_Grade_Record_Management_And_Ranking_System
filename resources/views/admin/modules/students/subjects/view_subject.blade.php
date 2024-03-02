
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
                                <li class="breadcrumb-item"><a href="{{ route('admin/subject') }}">Student Subjects</a></li>
                                <li class="breadcrumb-item active">Added Subjects</li>
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
                                <div class="row pb-3" style="border-bottom:2px solid #5e8e44;">
                                    <div class="col-auto text-end float-end ms-auto download-grp">
                                        <a class="btn btn-primary" href="{{ route('admin/subject') }}"> Back</a>
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
                                    <div class="col-auto text-end float-end ms-auto download-grp mt-2">
                                        <a href="#" class="btn btn-outline-primary me-2"><i class="fas fa-print"></i> Print</a>
                                        <a href="#" class="btn btn-primary me-2"><i class="fas fa-plus"></i></a>
                                        <a href="#" class="btn btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#approval"><i class="fas fa-check"></i> Approve</a>
                                        <a href="#" class="btn btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#revert"><i class="fas fa-undo"></i> Revert</a>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="table-responsive" id="view_record">
                                <table class="table border-0 star-student table-hover table-center mb-0 table-striped">
                                    <thead class="student-thread">
                                        <tr>
                                            <th>Subject Code</th>
                                            <th>Course Description</th>
                                            <th>Credits</th>
                                            <th>Status</th>
                                            <th class="text-end" >Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($subject as $subjects)
                                        <tr>
                                            <td>{{$subjects->subject_code}}</td>
                                            <td>{{$subjects->subject_description}}</td>
                                            <td>{{$subjects->credits}}</td>
                                            <td><div class="badge badge-success" style="font-size:14px;">{{$subjects->status}}</div></td>
                                            <td class="text-end">
                                                @if($subjects->status != 'Approved')
                                                <div class="actions" style="text-align: center;">
                                                    <a href="" class="btn btn-sm bg-danger-light approval">
                                                        <i class="feather-edit"></i>
                                                    </a>
                                                    <a class="btn btn-sm bg-danger-light delete" data-bs-toggle="modal" data-bs-target="#delete">
                                                        <i class="fe fe-trash-2"></i>
                                                    </a>
                                                </div>
                                                @else
                                                <div class="actions" style="text-align: center;">
                                                </div>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal custom-modal fade" id="approval" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Approval</h3>
                        <p>Do you want to approve this Student Registration?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <div class="row">
                            <form action="" method="POST">
                                @csrf
                                <input type="hidden" name="subject_id" class="e_subject_id" value="">
                                <div class="row">
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-primary paid-continue-btn" style="width: 100%;">Approve</button>
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
    <div class="modal custom-modal fade" id="revert" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Revert</h3>
                        <p>Do you want to revert this Student Registration?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <div class="row">
                            <form action="" method="POST">
                                @csrf
                                <input type="hidden" name="subject_id" class="e_subject_id" value="">
                                <div class="row">
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-primary paid-continue-btn" style="width: 100%;">Revert</button>
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
@endsection
