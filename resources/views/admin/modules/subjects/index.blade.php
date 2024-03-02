
@extends('layouts.master')
@section('content')
    {{-- message --}}
    {!! Toastr::message() !!}
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Subjects</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Subjects</li>
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
                                    <div class="col">
                                        <h3 class="page-title">Subjects</h3>
                                    </div>
                                    <div class="col-auto text-end float-end ms-auto download-grp">
                                        <a href="#" class="btn btn-outline-primary me-2">
                                            <i class="fas fa-print"></i> Print
                                        </a>
                                        <a  class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addnewcurriculum">
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
                                                        <option value="">Show all Subjects</option>
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
                            <div class="table-responsive" id="subject_list">
                                
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
                fetchSubject();
                $("#gradelevel").on('change', function() {
                    fetchSubject();
                });

                $(document).on('click', '.delete_subject', function(e) {
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
                    url: '{{ route('deleteSubject') }}',
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
                        fetchSubject();
                    }
                    });
                }
                })
            });

                    function fetchSubject(){
                        var gradelevel = $('#gradelevel').val();
                        $.ajax({
                        type: "POST",
                        url: "/fetch-subject",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            gradelevel : gradelevel
                        },
                        dataType: "json",
                        success: function (response) {
                            console.log(response.activities);
                            if (response.status == 'success') {
                                $('#subject_list').html(response.query);
                            }else{
                                $('#subject_list').html("");
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
