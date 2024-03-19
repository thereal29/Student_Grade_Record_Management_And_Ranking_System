@extends('layouts.master')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <h3 class="page-title">Student Co Curricular Activity Validation</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item active"><a href="">Co Curricular Activities Validation</a></li>
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
                            <div class="col-md-12">
                                <small><small>Filter by Grade Level:</small></small>
                                <div class="col-md-6 m-0">
                                    <select name="gradelevel" id="gradelevel" data-placeholder="Select Grade Level" class="form-select d-flex normselect">
                                        <option value=""></option>
                                        <!-- <option value="">No Enrolled Students</option> -->
                                        <option value="showall" {{Request::get('gradelevel') == 'showall' ? 'selected' : ''}}> Show all activities</option>
                                        <option value="Grade 7" {{Request::get('gradelevel') == 'Grade 7' ? 'selected' : ''}}> Grade 7</option>
                                        <option value="Grade 8" {{Request::get('gradelevel') == 'Grade 8' ? 'selected' : ''}}> Grade 8</option>
                                        <option value="Grade 9" {{Request::get('gradelevel') == 'Grade 9' ? 'selected' : ''}}> Grade 9</option>
                                        <option value="Grade 10" {{Request::get('gradelevel') == 'Grade 10' ? 'selected' : ''}}> Grade 10</option>
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
                            <div class="table-responsive" id="activity_list">
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
  $(document).ready(function() {
    fetchActivity();
      function fetchActivity(){
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
          url: "/fetch-validation-activity",
          data: data,
          dataType: "json",
          success: function (response) {
               console.log(response.activities);
              if (response.status == 'success') {
                $('#activity_list').html(response.query);
                
              }else{
                $('#activity_list').html("");
              }
              if ($('.datatables').length > 0) {
                        $('.datatables').DataTable({
                            "bFilter": true,
                        });
              }
          }
        });
      }
      $("#gradelevel").on('change', function() {
        fetchActivity();
      });
        $(document).on('click', '.validate_activity', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        let csrf = '{{ csrf_token() }}';
        Swal.fire({
          title: 'Validation',
          text: "Validate this Co Curricular Activity",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#05300e',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Validate'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: '{{ route('validateActivities') }}',
              method: 'post',
              data: {
                id: id,
                _token: csrf
              },
              success: function(response) {
                console.log(response);
                Swal.fire(
                  'Validate!',
                  'Validated Successfully.',
                  'success'
                )
                fetchActivity();
              }
            });
          }
        })
      });
      $(document).on('click', '.revert_activity', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        let csrf = '{{ csrf_token() }}';
        Swal.fire({
          title: 'Validation',
          text: "Revert this Co Curricular Activity",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#05300e',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Revert'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: '{{ route('revertActivities') }}',
              method: 'post',
              data: {
                id: id,
                _token: csrf
              },
              success: function(response) {
                console.log(response);
                Swal.fire(
                  'Validation!',
                  'Reverted Successfully.',
                  'success'
                )
                fetchActivity();
              }
            });
          }
        })
      });

  });
</script>
@endsection