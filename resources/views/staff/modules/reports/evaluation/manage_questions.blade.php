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
            <div class="col-lg-3 mt-4">
                    <div class="card">
                        <div class="info-header">
                            <b>Question Form</b>
                        </div>
                        <div class="card-body">
                            
                            <form action="#" id="addQuestions" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                <strong><label class="col-xs-5 control-label" for="evalIndicator">Evaluation Indicator</label></strong>
                                <textarea id="evalIndicator" class="form-control" name="evalIndicator" cols="30" rows="4" required> </textarea>
                                <input id="evalID" class="form-control" name="evalID" value="{{Request::get('id')}}" hidden>
                                <input id="formID" class="form-control" name="formID" value="" hidden>
                                <input id="indID" class="form-control" name="indID" value="" hidden>
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
                <div class="col-lg-9">
                    <div class="card">
                    <fieldset class="border border-info p-2 w-100 mb-5">
					   <legend  class="w-auto"><h5>Rating Legend</h5></legend>
					   <p>Check the corresponding rating of the student nominee accordingly with 5 as the highest and 1 as the lowest.</p>
					</fieldset>
                    <div class="info-header">
                        <strong><i class="bx bx-data"></i>List of Questions</strong>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" id="Qlist">
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
        fetchQuestion();
        function fetchQuestion(){
                var url = window.location.href;
                
                // Parse the URL to extract parameters
                var params = (new URL(url)).searchParams;
                
                // Get the value of the 'id' parameter
                var id = params.get('id');
                $.ajax({
                type: "post",
                url: "/fetch-staff-character-evaluation-questions",
                data: {
                    "_token": "{{ csrf_token() }}",
                    id : id
                },
                dataType: "json",
                success: function (response) {
                    if (response.status == 'success') {
                        $('#Qlist').html(response.query);
                    }else{
                        $('#Qlist').html("");
                    }
                    $("#datatables").DataTable();
                    $( ".sortable" ).sortable({
                    items: "tr",
                    cursor: 'move',
                    opacity: 0.6,
                    update: function() {
                        sendOrderToServer();
                    }
                    });
                    }
                });
        }
        $("#addQuestions").submit(function(e) {
            e.preventDefault();
            var fd = $(this).serialize();
            $.ajax({
            url: '{{ route('staffAddQuestions') }}',
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
            url: '{{ route('staffEditQuestions') }}',
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
                url: '{{ route('staffDeleteQuestion') }}',
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
            url: "{{ url('question-staff-sortable') }}",
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