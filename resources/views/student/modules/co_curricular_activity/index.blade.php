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
                <div class="col-lg-3 mt-3">
                    <div class="card">
                    <div class="info-header">
                        <b>Adding Form</b>
                    </div>
                        <div class="card-body">
                            <form  action="#" id="addActivity" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group text-center type">
                                <label class="col-xs-5 control-label" for="typeCoCurricular">Type of Activity</label>  
                                
                                <select id="typeCoCurricularsel" name="typeCoCurricularsel" class="form-select form-select-sm normselect" data-placeholder="Select Type of Activity">
                                    <option value=""></option>
                                    @foreach($type as $types)
                                    <option value="{{$types['id']}}">{{$types->type_of_activity}}</option>
                                    @endforeach
                                </select>
                                <div class="typeerror col-md-12 text-warning">
                                </div>
                            </div>
                            <div class="form-group text-center">
                                <label class="col-xs-12 control-label" for="subTypeCoCurricular">Sub Type</label>  
                                
                                <select id="subTypeCoCurricularsel" name="subTypeCoCurricularsel" class="form-control normselect">              
                                </select>
                                <div class="subtypeerror col-md-12 text-warning">
                                </div>
                            </div>
                            <div class="form-group text-center">
                                <label class="col-xs-12 control-label" for="awardscopeCoCurricular">Award Or Scope</label>  
                                
                                <select id="awardscopeCoCurricularsel" name="awardscopeCoCurricularsel" class="form-control normselect">
                                </select>
                                <div class="awardscopeerror col-md-12 text-warning">
                                </div>
                            </div>
                            <div class="text-center">
                                <label class="col-xs-12 control-label" for="file">Upload Proof File</label>
                                <input type="file" name="file" id="inputFile" class="form-control" required>
                                <div class="fileerror col-md-12 text-warning">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-auto text-end float-end ms-auto download-grp">
                                    <button id="resetBTN"class="btn btn-primary" type='reset'>Clear</button>
                                    <button class="btn btn-primary float-right add_activity" type="submit">Save</button>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-9 mt-3">       
                    <div class="card">
                        <div class="info-header">
                        <strong><i class="bx bx-data"></i>Co Curricular Activities</strong>
                            
                        </div>
                        <div class="card-body">
                        <div class="row">
                                <div class="col-md-6 mt-2">
                                    <div class="row d-flex">
                                        <div class="col-md-12 m-0">
                                            <small><small>Grade Level:</small></small>
                                        </div>
                                        <div class="col-md-12 m-0">
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
                                <div class="col-md-6 mt-0 mb-2">
                                    <div class="row">
                                        <div class="point col-md-12 bg-warning mb-3">
                                            <strong>Cumulative Points:  </strong>
                                            <small>0 pts</small>
                                        </div>
                                        <div class="percentage col-md-12 bg-success">
                                            <strong>Percentage (10%):</strong>
                                            <small>0 %</small>
                                        </div>
                                        <div class="col-auto text-end float-end ms-auto download-grp mt-2 mb-3">
                                        <button type="submit" class="btn btn-primary" style="background:#05300e; color:#fff;">Submit Activities</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <div class="table-responsive" id="activityList">
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
    <script>
    $(document).ready(function() {

      $('#typeCoCurricularsel').on('change', function() {
          var categoryID = $(this).val();
          if(categoryID) {
              $.ajax({
                  url: '/getSubtypes/'+categoryID,
                  type: "GET",
                  data : {"_token":"{{ csrf_token() }}"},
                  dataType: "json",
                  success:function(data)
                  {
                    if(data){
                      $('.typeerror').html("");
                      $('.subtypeerror').html("");
                      $('.awardscopeerror').html("");
                      $('#subTypeCoCurricularsel').empty();
                      if(categoryID == 1 || categoryID == 2){
                        $('#subTypeCoCurricularsel').select2({
                          placeholder: "Select Award or Scope",
                          minimumResultsForSearch: Infinity
                        });
                        $('#awardscopeCoCurricularsel').select2({
                          placeholder: "Select Award or Scope",
                          minimumResultsForSearch: Infinity
                        });
                      }else{
                        $('#subTypeCoCurricularsel').select2({
                        placeholder: "Select Award or Scope",
                        minimumResultsForSearch: Infinity
                        });
                        $('#awardscopeCoCurricularsel').select2({
                          placeholder: "",
                          minimumResultsForSearch: Infinity
                        });
                      }
                      $('#subTypeCoCurricularsel').append('<option value"" selected></option>'); 
                      $.each(data, function(key, subtypes){
                          $('select[name="subTypeCoCurricularsel"]').append('<option value="'+ subtypes.id +'">' + subtypes.subtype+ '</option>');
                      });
                  }else{
                      $('#subTypeCoCurricularsel').empty();
                  }
                }
              });
              $.ajax({
                  url: '/getAwardScope/'+categoryID,
                  type: "GET",
                  data : {"_token":"{{ csrf_token() }}"},
                  dataType: "json",
                  success:function(data)
                  {
                    if(data){
                      $('#awardscopeCoCurricularsel').empty();
                      $('#awardscopeCoCurricularsel').append('<option value"" selected></option>'); 
                      $.each(data, function(key, awardscopes){
                          $('select[name="awardscopeCoCurricularsel"]').append('<option value="'+ awardscopes.id +'">' + awardscopes.award_scope + '</option>');
                      });
                  }else{
                      $('#awardscopeCoCurricularsel').empty();
                  }
                }
              });
          }else{
            $('#subTypeCoCurricularsel').empty();
            $('#awardscopeCoCurricularsel').empty();
          }
      });
      
    });
</script> 
<script type="text/javascript">
    $( "#resetBTN" ).click(function() {
    $('#typeCoCurricularsel').val($(this).data('val')).trigger('change');
    $('#subTypeCoCurricularsel').select2({
      placeholder: ""
    });
    $('#awardscopeCoCurricularsel').select2({
      placeholder: ""
    });
    $('.alert').html("");
    $('.typeerror').html("");
    $('.subtypeerror').html("");
    $('.awardscopeerror').html("");
});
</script>
<!-- Scripts for Student's Co Curricular Activity -->
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
          url: "/fetch-activity",
          data: data,
          dataType: "json",
          success: function (response) {
               console.log(response.activities);
              if (response.status == 'success') {
                $('#activityList').html(response.query);
                if(response.point == null){
                  $('.point').html('<strong>Cumulative Points:  </strong><small>0 pts</small>'); 
                  $('.percentage').html('<strong>Percentage (10%):  </strong><small>0 %</small>'); 
                }else{
                  $('.point').html('<strong>Cumulative Points:  </strong><small>'+ response.point.sumTotal + ' pts</small>'); 
                  $('.percentage').html('<strong>Percentage (10%):  </strong><small>'+ response.percentage + ' %</small>');
                }
              }else{
                $('#activityList').html("");
              }
              if ($('.datatables').length > 0) {
                        $('.datatables').DataTable({
                            "bFilter": true,
                        });
              }
          }
        });
      }
      
      $("#subTypeCoCurricularsel").on('change', function() {
        $('.subtypeerror').html("");
      });
      $("#awardscopeCoCurricularsel").on('change', function() {
        $('.awardscopeerror').html("");
      });
      $("#inputFile").change(function () {
        $('.fileerror').html("");
      });
      $("#gradelevel").on('change', function() {
        fetchActivity();
      });
      
      $(document).on('click', '.add_activity', function (e) {
        e.preventDefault();
        const form = document.getElementById("addActivity");
        const fd = new FormData(form);

            $.ajax({
                type: "POST",
                url: "/add-activity",
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function (response) {
                    console.log(response);
                    
                    if (response.status == 'success') { 
                      $('#gradelevel').val($(this).data('val')).trigger('change');
                      fetchActivity();
                      Swal.fire({
                      title: "Good job!",
                      text: "You have new Co Curricular Activity!",
                      icon: "success"
                    });
                    $("#resetBTN").click()
                    } else {
                      toastr.warning('Warning');
                    if(response.errors.typeCoCurricularsel != null){
                      $('.typeerror').html("<small>This field is required</small>");
                    }else if(response.errors.subTypeCoCurricularsel != null && response.errors.awardscopeCoCurricularsel == null){
                      $('.subtypeerror').html("<small>This field is required</small>");
                    }else if(response.errors.subTypeCoCurricularsel == null && response.errors.awardscopeCoCurricularsel != null){
                      $('.awardscopeerror').html("<small>This field is required</small>");
                    }else if(response.errors.subTypeCoCurricularsel != null && response.errors.awardscopeCoCurricularsel != null){
                      $('.subtypeerror').html("<small>This field is required</small>");
                      $('.awardscopeerror').html("<small>This field is required</small>");
                    }else{
                      $('.subtypeerror').html("");
                      $('.awardscopeerror').html("");
                    }
                    if(response.errors.file != null){
                      $('.fileerror').html('<small>'+response.errors.file+'</small>');
                    }
                    }
                }
            });

        });
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
              url: '{{ route('deleteActivity') }}',
              method: 'delete',
              data: {
                id: id,
                _token: csrf
              },
              success: function(response) {
                console.log(response);
                Swal.fire(
                  'Deleted!',
                  'Your activity  has been deleted.',
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