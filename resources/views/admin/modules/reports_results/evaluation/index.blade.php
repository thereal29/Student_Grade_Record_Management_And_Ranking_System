@extends('layouts.master')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <h3 class="page-title">Student Character Evaluation</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item active"><a href="">Co Curricular Activities Validation</a></li>
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
                                        <h3 class="page-title">Character Evaluations</h3>
                                    </div>
                                    <div class="col-auto text-end float-end ms-auto download-grp">
                                        <button id="" class="btn btn-primary add_new_evaluation"><i class="fas fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive" id="evaluation_list">
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
      function alertEval(){
      Swal.fire(
        'One Default Character Evaluation Per School Year',
        'Add School Year First',
        'info'
      )
      }
</script>
    <script>
  $(document).ready(function() {
        fetchEvaluation();
        function fetchEvaluation(){
                $.ajax({
                type: "get",
                url: "/fetch-character-evaluation",
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function (response) {
                    if (response.status == 'success') {
                        $('#evaluation_list').html(response.query);
                    }else{
                        $('#evaluation_list').html("");
                    }
                    if(response.existSY == null){
                        $('.add_new_evaluation').attr('id', null);
                    }else{
                        $('.add_new_evaluation').attr('id', response.existSY);
                    }
                    if ($('.datatables').length > 0) {
                        $('.datatables').DataTable({
                            "bFilter": true,
                        });
                    }
                    }
                });
        }
        $("#addEvaluation").submit(function(e) {
            e.preventDefault();
            var fd = $(this).serialize();
            $.ajax({
            url: '{{ route('addEvaluation') }}',
            method: 'post',
            data: fd,
            dataType: 'json',
            success: function(response) {
                if (response.status == 'success') {
                Swal.fire(
                    'Success!',
                    'New Character Evaluation Added Successfully!',
                    'success'
                )
                fetchEvaluation();
                }
                $("#addEvaluation")[0].reset();
                $("#addnewevaluation").modal('hide');
            },error: function(response) {
                Swal.fire(
                    'Error!',
                    'Error!',
                    'error'
                )
            }
            });
        });
        $(document).on('click', '.add_new_evaluation', function(e) {
            e.preventDefault();
            let id = $(this).attr('id');
            if(id == null){
                $('#addnewevaluation').modal('show');
                fetchEvaluation();
            }else{
                Swal.fire(
                    'One Default Character Evaluation Per School Year',
                    'Add School Year First',
                    'info'
                )
            }
            
        });

        $(document).on('click', '.delete_evaluation', function(e) {
            e.preventDefault();
            let id = $(this).attr('id');
            let csrf = '{{ csrf_token() }}';
            Swal.fire({
            title: 'Confimation?',
            text: "Are you sure to delete this question?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#05300e',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                url: '{{ route('deleteEvaluation') }}',
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
                    fetchEvaluation();
                }
                });
            }
            })
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
              url: '{{ route('staffValidateActivities') }}',
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
              url: '{{ route('staffRevertActivities') }}',
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