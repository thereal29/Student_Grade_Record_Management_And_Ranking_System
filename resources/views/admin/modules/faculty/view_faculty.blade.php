@extends('layouts.master')
@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Faculty Profile</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Faculty</a></li>
                        <li class="breadcrumb-item active">Faculty Profile</li>
                    </ul>
                </div>
            </div>
        </div>

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
                            <h4 class="user-name mb-0">{{ $details->firstname . ' ' .$details->lastname }}</h4>
                            <h6 class="text-muted">{{ $details->description }}</h6>
                            <div class="user-Location"><i class="fas fa-map-marker-alt"></i> {{ $details->email }}</div>
                        </div>
                        <div class="col-auto profile-btn">
                            <a href="" class="btn btn-primary">Edit</a>
                        </div>
                    </div>
                </div>
                <div class="profile-menu">
                    <ul class="nav nav-tabs nav-tabs-solid">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#per_details_tab">Personal Details</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#classes_tab">Classes Hadled</a>
                        </li>
                        @if($class_advisory_ctr->count() > 0)
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#advisory_tab">Class Advisory</a>
                        </li>
                        @endif
                    </ul>
                </div>
                <div class="tab-content profile-tab-cont">
                    <div class="tab-pane fade show active" id="per_details_tab">
                        <div class="row">
                            <div class="col-lg-9">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title d-flex justify-content-between">
                                            <span>Personal Details</span>
                                            <a class="edit-link" data-bs-toggle="modal"
                                                href="#edit_personal_details"><i
                                                    class="far fa-edit me-1"></i>Edit</a>
                                        </h5>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Name</p>
                                            <p class="col-sm-9">{{ $details->firstname . ' ' . $details->middlename . ' ' . $details->lastname }}</p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Gender</p>
                                            <p class="col-sm-9">{{ $details->gender}}</p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Email</p>
                                            <p class="col-sm-9"><a href="/cdn-cgi/l/email-protection"
                                                    class="__cf_email__"
                                                    data-cfemail="a1cbcec9cfc5cec4e1c4d9c0ccd1cdc48fc2cecc">{{ $details->email}}</a>
                                            </p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Mobile</p>
                                            <p class="col-sm-9">{{ $details->phone_number}}</p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0">Address</p>
                                            <p class="col-sm-9 mb-0">{{ $details->home_address}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="classes_tab" class="tab-pane fade">
                        <div class="card">
                            <div class="card-body">
                                <div class="row align-items-center pb-3">
                                    <div class="col-auto text-end float-end ms-auto download-grp">
                                        <a href="#" class="btn btn-outline-primary me-2"><i class="fas fa-print"></i> Print</a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-10 col-lg-12">
                                        <div class="table-responsive">
                                            <table class="table border-0 star-student table-hover table-center mb-0 datatables table-striped">
                                                    <thead class="student-thread">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Subject Code</th>
                                                        <th>Subject Description</th>
                                                        <th>Grade Level</th>
                                                        <th>No. of Students</th>
                                                        <th class="text-end">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($classes as $key => $class)
                                                    <tr>
                                                        <td>STD {{++$key}}</a></td>
                                                        <td>{{$class->subject_code}}</td>
                                                        <td>{{$class->subject_description}}</td>
                                                        <td>{{$class->grade_level}}</td>
                                                        <td><div class="badge badge-info" style="font-size:14px;">{{$class->ctr}} 
                                                            @if($class->ctr > 1)
                                                                Students
                                                            @else
                                                                Student
                                                            @endif
                                                        </div></td>
                                                        <td class="text-end">
                                                            <div class="actions">
                                                                <a href="faculty/view=class?id={{$class->cid}}" class="btn btn-sm bg-danger-light">
                                                                    <i class="fas fa-eye"></i>
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
                    <div id="advisory_tab" class="tab-pane fade">
                        <div class="card">
                            <div class="card-body">
                            @if($class_advisory->count() > 0)
                                <div class="row align-items-center pb-3" style="border-bottom:2px solid #5e8e44;">
                                    <div class="col">
                                        <h5>Current Class Advisory: {{$advisory->grade_level. ' ' .$advisory->section}}</h5>
                                    </div>
                                    <div class="col-auto text-end float-end ms-auto download-grp">
                                        <a href="#" class="btn btn-outline-primary me-2"><i class="fas fa-print"></i> Print</a>
                                    </div>
                                </div>
                            @endif
                                <div class="row mt-3">
                                    <div class="col-md-10 col-lg-12">
                                        <div class="table-responsive">
                                            <table class="table border-0 star-student table-hover table-center mb-0 datatables table-striped">
                                                    <thead class="student-thread">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>LRN</th>
                                                        <th>Name</th>
                                                        <th>Gender</th>
                                                        <th>Deficiency Status</th>
                                                        <th class="text-end">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($class_advisory as $key => $class)
                                                    <tr>
                                                        <td>STD {{++$key}}</a></td>
                                                        <td>{{$class->lrn_number}}</td>
                                                        <td>{{$class->sfname. ' ' .$class->slname}}</td>
                                                        <td>{{$class->sgender}}</td>
                                                        <td></td>
                                                        <td class="text-end">
                                                            <div class="actions">
                                                                <a class="btn btn-sm bg-danger-light">
                                                                    <i class="fas fa-eye"></i>
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
            </div>
        </div>
    </div>
</div>
@endsection
