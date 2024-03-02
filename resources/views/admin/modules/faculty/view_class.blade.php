
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
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Faculty</a></li>
                                <li class="breadcrumb-item">Faculty Profile</li>
                                <li class="breadcrumb-item active">Class</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            {{-- message --}}
            {!! Toastr::message() !!}
            <div class="row">
            <div class="col-md-12">
                <div class="profile-header">
                    <div class="row align-items-center">
                        <div class="col-auto profile-image">
                            <a href="#">
                                <img class="rounded-circle" alt="{{ Session::get('name') }}" src="{{Storage::url('faculty-photos/'.$details->avatar)}}">
                            </a>
                        </div>
                        <div class="col ms-md-n2 profile-user-info">
                            <h6 class="text-muted">{{ $details->university_number }}</h6>
                            <h4 class="user-name mb-0">{{ $details->ffname . ' ' .$details->flname }}</h4>
                            <h6 class="text-muted">{{ $details->description }}</h6>
                            <div class="user-Location"><i class="fas fa-map-marker-alt"></i> {{ $details->email }}</div>
                        </div>
                        <div class="col-auto mt-3">
                            <strong>Subject Code: </strong>
                            <small>{{$details->subject_code}}</small></br>
                            <strong>Subject Description: </strong>
                            <small class="text-uppercase">{{$details->subject_description }}</small></br>
                            <strong>Grade Level: </strong>
                            <small class="text-uppercase">{{$details->class_glevel}}</small></br>
                            <strong>No. of Students: </strong>
                            <small class="text-uppercase">{{$details->ctr}}</small></br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-table comman-shadow">
                        <div class="card-body">
                            <div class="row align-items-center mb-3">
                                <div class="col-auto text-end float-end ms-auto download-grp">
                                    <a href="#" class="btn btn-outline-primary me-2"><i class="fas fa-print"></i> Print</a>
                                    <a href="" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table border-0 star-student table-hover table-center mb-0 datatables table-striped">
                                        <thead class="student-thread">
                                        <tr>
                                            <th>#</th>
                                            <th>LRN</th>
                                            <th>Name</th>
                                            <th>Gender</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($classes as $key => $class)
                                        <tr>
                                            <td>STD {{++$key}}</a></td>
                                            <td>{{$class->lrn_number}}</td>
                                            <td>{{$class->firstname. ' ' .$class->lastname}}</td>
                                            <td>{{$class->gender}}</td>
                                            <td class="text-end">
                                                <div class="actions">
                                                    <a class="btn btn-sm bg-danger-light">
                                                        <i class="fe fe-trash-2"></i>
                                                    </a>
                                                </div>
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
