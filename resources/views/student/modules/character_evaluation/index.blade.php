@extends('layouts.master')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <h3 class="page-title">Character Evaluation</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item active"><a href="">Student Character Evaluation</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            {{-- message --}}
            {!! Toastr::message() !!}
            <div class="row">
            <div class="col-lg-12 ">
                    <div class="card" style="background-color:#e7ffce">
                        <div class="card-body">
                            <div class="col-md-4" style="margin: 0 auto;">
                                <div class="col-md-12 m-0">
                                    <small><small>Select Student to be Evaluated:</small></small>
                                </div>
                            <form action="" method="get">
                                <select name="evaluators" id="evaluators" class="form-select d-flex student-select">
                                    <option></option>
                                    @foreach($students as $student)
                                    <option value="{{$student->sid}}">{{$student->lrn_number.' - '. $student->slname.', '.$student->sfname}}</option>
                                    @endforeach
                                </select>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            
                            <h5 class="text-center" >Student Character Evaluation</h5>
                            <div class="row mb-3">
                                <div class="text left">
                                    <strong>LRN: <small style="font-weight: normal;">{{$details->lrn_number}}</small></strong>
                                    <strong>Name: <small style="font-weight: normal;">{{$details->firstname.' '.$details->lastname}}</small></strong>
                                    <strong>Name Evaluated: <small style="font-weight: normal;"></small></strong>
                                </div>
                                <div class="text right" style="right:0;">
                                    <strong>Grade & Section: <small style="font-weight: normal;">{{$details->grade_level}}</small></strong>
                                    <strong>School Year: <small style="font-weight: normal;">{{$currSY->from_year.' - '.$currSY->to_year}}</small></strong>
                                </div>
                            </div>
                            <div class="border border-success pb-0 card-body">
                            <div class="w-100">
                                <h6>Direction:</h6>
                                <p>Check the corresponding rating of the student nominee accordingly with 5 as the highest and 1 as the lowest.</p>
                                </div>
                            </div>
                                <form action="" id="submitEvaluation" method="post">
                                <div class="table-responsive" id="questions_list">
                                </div>
                                <div class="col-auto text-end float-end ms-auto download-grp mt-3">
                                    <button type="submit" id="" class="btn btn-primary submit_evaluation"><i class="fas fa-paper-plane"></i>  Finish Evaluation</button>
                                </div>
                                </form>
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
        fetchQuestions();
        function fetchQuestions(){
                $.ajax({
                type: "post",
                url: "/fetch-student-character-evaluation-questions",
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function (response) {
                    if (response.status == 'success') {
                        $('#questions_list').html(response.query);
                    }else{
                        $('#questions_list').html("");
                    }
                    }
                });
        }
        $("#addQuestions").submit(function(e) {
            e.preventDefault();
            var fd = $(this).serialize();
            $.ajax({
            url: '{{ route('addQuestions') }}',
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
                fetchQuestion();
                }
                $("#clrBTN").click()
            },error: function(response) {
                Swal.fire(
                    'Error!',
                    'Error!',
                    'error'
                )
            }
            });
        });
        $(document).on('click', '.edit_question', function(e) {
            e.preventDefault();
            let id = $(this).attr('id');
            $.ajax({
            url: '{{ route('editQuestions') }}',
            method: 'get',
            data: {
                id: id,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                $("[name='evalIndicator']").val(response.description);
                $("[name='evalID']").val(response.eval_id);
                $("[name='formID']").val(response.eval_id);
                $("[name='indID']").val(response.id);
            }
            });
            
        });

        $(document).on('click', '.delete_question', function(e) {
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
                url: '{{ route('deleteQuestion') }}',
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
                    fetchQuestion();
                }
                });
            }
            })
        });

        function sendOrderToServer() {
          var order = [];
          var token = $('meta[name="csrf-token"]').attr('content');
        //   by this function User can Update hisOrders or Move to top or under
          $('tr.row1').each(function(index,element) {
            order.push({
              id: $(this).attr('data-id'),
              position: index+1
            });
          });
// the Ajax Post update 
          $.ajax({
            type: "POST", 
            dataType: "json", 
            url: "{{ url('question-sortable') }}",
                data: {
              order: order,
              _token: token
            },
            success: function(response) {
                if (response.status == "success") {
                  console.log(response);
                } else {
                  console.log(response);
                }
            }
          });
        }


  });
</script>

@endsection