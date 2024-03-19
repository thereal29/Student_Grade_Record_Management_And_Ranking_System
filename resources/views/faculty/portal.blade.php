@extends('layouts.master')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <h3 class="page-title">Teacher's Portal</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item active">Portal</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            {{-- message --}}
            {!! Toastr::message() !!}
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-table mb-0 ">
                        <div class="card-body">
                            <div class="profile-header">
                                <div class="row align-items-center">
                                    <div class="col-auto profile-image">
                                        <a href="#">
                                            <img class="rounded-circle" alt="{{ Session::get('name') }}" src="{{ Storage::url('faculty-photos/'.Session::get('avatar')) }}">
                                        </a>
                                    </div>
                                    <div class="col ms-md-n2 profile-user-info">
                                        <h6 class="text-muted">{{ $details->university_number }}</h6>
                                        <h4 class="user-name mb-0">{{ $details->firstname . ' ' .$details->lastname }}</h4>
                                        <h6 class="text-muted">{{ Auth::user()->role }}</h6>
                                        <div class="user-Location"><i class="fas fa-envelope"></i> {{ $details->email }}</div>
                                    </div>
                                    <div class="col-auto profile-btn">
                                        <a href="" class="btn btn-primary">Edit</a>
                                    </div>
                                </div>
                            </div>
                            <div class="profile-menu" style="background-color:#e7ffce">
                                <ul class="nav nav-tabs nav-tabs-solid">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href=".class"><i class="fas fa-child"></i> My Class</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href=".grades"><i class="fas fa-star"></i> Grades</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href=".advisees"><i class="fas fa-thumbs-up"></i> Advisees</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div id="class_tab" class="tab-pane fade show active classTab class">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-10 col-lg-12">
                                            <div class="table-responsive" id="class">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="grades_tab" class="tab-pane fade gradTab grades">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-10 col-lg-12">
                                            <div class="table-responsive" id="grades">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="advisees_tab" class="tab-pane fade adviseesTab advisees">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-10 col-lg-12">
                                            <div class="table-responsive" id="advisees">
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
@section('script')
<script>
     $(document).ready(function(){
        let id = 0;
        fetchClass();
        $('a[data-bs-toggle="tab"]').on('show.bs.tab', function(e) {
            var tab = $(e.target);
            var contentId = tab.attr("href");
            tab = $(contentId).attr('id');
            if(tab == 'class_tab'){
                fetchClass();
            }else if(tab == 'grades_tab'){
                fetchGrades();
            }else{
                fetchAdvisees();
            }
        });
        function fetchClass(){
            $.ajax({
            type: "get",
            url: "/fetch-faculty-class",
            data: {
                "_token": "{{ csrf_token() }}"
            },
            dataType: "json",
            success: function (response) {
                if (response.status == 'success') {
                    $('#class').html(response.query);
                }else{
                    $('#class').html("");
                }
                if ($('.datatables').length > 0) {
                    $('.datatables').DataTable({
                        "bFilter": true,
                    });
                }
                }
            });
        }
        function fetchGrades(){
            let id = $('.view_grades').attr('id');
            $.ajax({
            type: "get",
            url: "/fetch-faculty-grades",
            data: {
                "_token": "{{ csrf_token() }}",
                id : id
            },
            dataType: "json",
            success: function (response) {
                if (response.status == 'success') {
                    $('#grades').html(response.query);
                }else{
                    $('#grades').html("");
                }
                if ($('.datatable_grades').length > 0) {
                    $('.datatable_grades').DataTable({
                        "bFilter": true,
                    });
                }
                }
            });
        }
        function fetchAdvisees(){
            $.ajax({
            type: "get",
            url: "/fetch-faculty-advisees",
            data: {
                "_token": "{{ csrf_token() }}"
            },
            dataType: "json",
            success: function (response) {
                if (response.status == 'success') {
                    $('#advisees').html(response.query);
                }else{
                    $('#advisees').html("");
                }
                if ($('.datatable').length > 0) {
                    $('.datatable').DataTable({
                        "bFilter": true,
                    });
                }
                }
            });
        }
        function fetchViewClass(){
            var cid = id;
            $.ajax({
            type: "get",
            url: "/fetch-faculty-view-class",
            data: {
                "_token": "{{ csrf_token() }}",
                id : cid
            },
            dataType: "json",
            success: function (response) {
                $('.view_class_modal_title').html('<small style="color:#fff;">'+response.class.subject_code+' '+response.class.subject_description+'</small>');
                if (response.status == 'success') {
                    $('#viewClassTable').html(response.query);
                }else{
                    $('#viewClassTable').html("");
                }
                if($('.datatables_class').length > 0) {
                    $('.datatables_class').DataTable({
                        "bFilter": true,
                    });
                }
                }
            });
        }
        function fetchInputGrades(){
            let cid = id;
            $.ajax({
            type: "get",
            url: "/fetch-faculty-input-grades",
            data: {
                "_token": "{{ csrf_token() }}",
                id : cid
            },
            dataType: "json",
            success: function (response) {
                $('.input_grades_modal_title').html('<small style="color:#fff;">'+response.class.subject_code+' '+response.class.subject_description+'</small>');
                if (response.status == 'success') {
                    $('#inputGradesTable').html(response.query);
                }else{
                    $('#inputGradesTable').html("");
                }
                if($('.datatables_grades').length > 0) {
                    $('.datatables_grades').DataTable({
                        "bFilter": true,
                    });
                }
                }
            });
        }
        function fetchViewGrades(){
            let cid = id;
            $.ajax({
            type: "get",
            url: "/fetch-faculty-view-grades",
            data: {
                "_token": "{{ csrf_token() }}",
                id : cid
            },
            dataType: "json",
            success: function (response) {
                $('.view_grades_modal_title').html('<small style="color:#fff;">'+response.class.subject_code+' '+response.class.subject_description+'</small>');
                if (response.status == 'success') {
                    $('#viewGradesTable').html(response.query);
                }else{
                    $('#viewGradesTable').html("");
                }
                if($('.datatables_grades').length > 0) {
                    $('.datatables_grades').DataTable({
                        "bFilter": true,
                    });
                }
                }
            });
        }

        function fetchViewAdvisees(){
            let sid = id;
            $.ajax({
            type: "get",
            url: "/fetch-view-advisees",
            data: {
                "_token": "{{ csrf_token() }}",
                id : sid
            },
            dataType: "json",
            success: function (response) {
                $('.view_advisees_modal_title').html('<strong style="color:#fff;">'+response.student.lrn_number+' - '+response.student.firstname+' '+response.student.lastname+' ('+response.student.grade_level+' - '+response.student.section+')'+'</strong>');
                if (response.status == 'success') {
                    $('#viewAdviseesTable').html(response.query);
                }else{
                    $('#viewAdviseesTable').html("");
                }
                }
            });
        }

        $('#input_grades_modal').on('hidden.bs.modal', function (e) {
                // Modal is closed or hidden
                $('.datatables_grades').DataTable().destroy();
                // Perform any actions you want here
        });
        $('#view_grades_modal').on('hidden.bs.modal', function (e) {
            // Modal is closed or hidden
            $('.datatables_grades').DataTable().destroy();
            // Perform any actions you want here
        });

        $(document).on('click', '.view_class', function() {
            $('#view_class_modal').modal('show');
            id = $(this).attr('id');
            fetchViewClass();
        });
        $(document).on('click', '.input_grades', function() {
            $('#input_grades_modal').modal('show');
            id = $(this).attr('id');
            fetchInputGrades();
        });
        $(document).on('click', '.view_grades', function() {
            $('#view_grades_modal').modal('show');
            id = $(this).attr('id');
            fetchViewGrades();
        });
        $(document).on('click', '.view_advisees', function() {
            $('#view_advisees_modal').modal('show');
            id = $(this).attr('id');
            fetchViewAdvisees();
        });
        $("#submitGrades").submit(function(e) {
            e.preventDefault();
            var fd = $(this).serialize();
            $.ajax({
            url: '{{ route('submitGrades') }}',
            method: 'post',
            data: fd,
            dataType: 'json',
            success: function(response) {
                if (response.status == 'success') {
                Swal.fire(
                    'Updated!',
                    'Grades Submitted Successfully!',
                    'success'
                )
                fetchGrades();
                }
                $("#submitGrades")[0].reset();
                $("#input_grades_modal").modal('hide');
            },error: function(response) {
                Swal.fire(
                    'Error!',
                    'Submittion Error!',
                    'error'
                )
            }
            });
        });
    });
</script>
@endsection