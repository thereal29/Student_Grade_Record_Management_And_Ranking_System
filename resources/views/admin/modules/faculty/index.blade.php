
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
                                <li class="breadcrumb-item"><a href="">Faculty</a></li>
                                <li class="breadcrumb-item active">All Faculties</li>
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
                                        <h3 class="page-title">Faculty</h3>
                                    </div>
                                    <div class="col-auto text-end float-end ms-auto download-grp">
                                        <a href="#" class="btn btn-outline-primary me-2"><i class="fas fa-print"></i> Print</a>
                                        <a href="" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table border-0 star-student table-hover table-center mb-0 datatables table-striped">
                                    <thead class="student-thread">
                                    <tr>
                                        <th>University ID</th>
                                        <th>Name</th>
                                        <th>Gender</th>
                                        <th>No. of Subject Load</th>
                                        <th>Class Advisory</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($faculties as $faculty)
                                    <tr>
                                        <td>{{$faculty->university_number}}</a></td>
                                        <td>{{$faculty->firstname}} {{$faculty->lastname}}</td>
                                        <td>{{$faculty->gender}}</td>
                                        <td><div class="badge badge-info" style="font-size:14px;">{{$faculty->ctr}} 
                                            @if($faculty->ctr > 1)
                                                Subjects
                                            @else
                                                Subject
                                            @endif
                                        </div></td>
                                        @if($faculty->section != null)
                                            <td><div class="badge badge-info" style="font-size:14px;">{{$faculty->grade_level}} {{$faculty->section}}</div></td>
                                        @else
                                            <td><div class="badge badge-info" style="font-size:14px;">None</div></td>
                                        @endif
                                        <td class="text-end">
                                            <div class="actions">
                                                <a href="view=faculty?id={{$faculty->fid}}" class="btn btn-sm bg-danger-light">
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
    {{-- model student delete --}}
    <div class="modal fade contentmodal" id="studentUser" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content doctor-profile">
                <div class="modal-header pb-0 border-bottom-0  justify-content-end">
                    <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i
                        class="feather-x-circle"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST">
                        @csrf
                        <div class="delete-wrap text-center">
                            <div class="del-icon">
                                <i class="feather-x-circle"></i>
                            </div>
                            <input type="hidden" name="id" class="e_id" value="">
                            <input type="hidden" name="avatar" class="e_avatar" value="">
                            <h2>Sure you want to delete</h2>
                            <div class="submit-section">
                                <button type="submit" class="btn btn-success me-2">Yes</button>
                                <a class="btn btn-danger" data-bs-dismiss="modal">No</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @section('script')

    {{-- delete js --}}
    <script>
        $(document).on('click','.student_delete',function()
        {
            var _this = $(this).parents('tr');
            $('.e_id').val(_this.find('.id').text());
            $('.e_avatar').val(_this.find('.avatar').text());
        });
    </script>

    <script>
        $(document).ready(function(){
            fetchStudent();
            $("#adviser").on('change', function() {
                fetchStudent();
            });
            function fetchStudent(){
                var adviser = $('#adviser').val();
                $.ajax({
                type: "POST",
                url: "/fetch-students",
                data: {
                    "_token": "{{ csrf_token() }}",
                    adviser : adviser
                },
                dataType: "json",
                success: function (response) {
                    if (response.status == 'success') {
                        $('#student_list').html(response.query);
                    }else{
                        $('#student_list').html("");
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
