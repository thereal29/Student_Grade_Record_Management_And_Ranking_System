@extends('layouts.master')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <div class="page-title"></div>
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
            <div class="row">
                <div class="col-lg-3 mt-4">
                    <div class="card">
                    <div class="info-header">
                        <b>School Year Form</b>
                    </div>
                        <div class="card-body">
                        <form  action="#" id="addSY" method="POST" enctype="multipart/form-data">
                            @csrf
                                <div class="form-group">
                                    <label class="col-xs-5 control-label" for="school_year">From Year</label>
                                    <input id="fromY" class="form-control" name="fromY" value="{{date('Y')}}" readonly="true">
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-5 control-label" for="school_year">To Year</label>
                                    <input id="toY" class="form-control" type="number" value="{{date('Y', strtotime('+1 year'))}}" name="toY" readonly="true">
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-5 control-label" for="school_year">Quarter</label>
                                    <select name="quarter" id="quarter" class="form-select d-flex normselect" data-placeholder="Select Quarter" required>
                                        <option value=""></option>
                                        <!-- <option value="">No Enrolled Students</option> -->
                                        <option value="1st Quarter">1st Quarter</option>
                                        <option value="2nd Quarter">2nd Quarter</option>
                                        <option value="3rd Quarter">3rd Quarter</option>
                                        <option value="4th Quarter">4th Quarter</option>
                                    </select>
                                </div>
                            
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-auto text-end float-end ms-auto download-grp">
                                    <button id="clrBTN"class="btn btn-primary" type='reset'>Clear</button>
                                    <button class="btn btn-primary float-right add_SY" type="submit">Save</button>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-9 mt-4">
                    <div class="card">
                    <div class="info-header">
                        <strong><i class="bx bx-data"></i>List of School Year</strong>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" id="SYlist">
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- modal delete --}}
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
@endsection
@section('script')
<script type="text/javascript">
    $( "#clrBTN" ).click(function() {
    $('#quarter').val($(this).data('val')).trigger('change');
    $('#toY').html("");
    $('#fromY').html("");
    $('.subtypeerror').html("");
    $('.awardscopeerror').html("");
});
</script>
    <script>
    $(document).ready(function() {
        fetchSY();
        function fetchSY(){
            $.ajax({
                type: "GET",
                url: "/fetch-school_year",
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                dataType: "json",
                success: function (response) {
                    if (response.status == 'success') {
                        $('#SYlist').html(response.query);
                        $('.page-title').html('<h5><div class="badge badge-success">School Year: A.Y ' + response.currentSY.from_year + ' - ' + response.currentSY.to_year + ' / ' + response.currentSY.quarter+'</div></h5>');
                    }else{
                        $('#SYlist').html("");
                    }
                }
            });
        }

        //add
        $('#addSY').on('submit', function(e){
            e.preventDefault();
            const fd = new FormData(this);
                $.ajax({
                    type: "POST",
                    url: "/add-school_year",
                    data: fd,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        if (response.status == 'success') {
                        fetchSY();
                        Swal.fire({
                        title: "Success",
                        text: "New School Year/Quarter Added Successfully",
                        icon: "success"
                        });
                        $("#clrBTN").click()
                        } else {
                            toastr.error('Already Existed','Duplicate');
                            $("#clrBTN").click()
                        }
                    }
                });

            });               

        //delete
        $(document).on('click', '.deleteIcon', function(e) {
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
                url: '{{ route('deleteSY') }}',
                method: 'delete',
                data: {
                    id: id,
                    _token: csrf
                },
                success: function(response) {
                    console.log(response);
                    Swal.fire(
                    'Success',
                    'Deleted Successfully',
                    'success'
                    )
                    fetchSY();
                }
                });
            }
            })
        });

        //edit
        $(document).on('click', '.editIcon', function(e) {
            e.preventDefault();
            let id = $(this).attr('id');
            let isCurrent = $(this).attr('value');
            let csrf = '{{ csrf_token() }}';
            if(isCurrent == 1) {
                Swal.fire(
                'Prompt',
                'Already Default',
                'info'
                )
            }else{
                Swal.fire({
                title: 'Are you sure?',
                text: "This will be the default school year/quarter",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#05300e',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, make it default'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                        url: '{{ route('editSY') }}',
                        method: 'get',
                        data: {
                            id: id,
                            _token: csrf
                        },
                        success: function(response) {
                            console.log(response);
                            if(response.status == 'success') {
                            Swal.fire(
                            'Success',
                            'School Year has changed.',
                            'success'
                            )
                            }else{
                                Swal.fire(
                                'Error',
                                'Already Default',
                                'error'
                                )
                            }
                            fetchSY();
                            
                        }
                        });
                    }
                })
            }
                
        });
    });
</script>
@endsection