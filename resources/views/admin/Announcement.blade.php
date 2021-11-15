@extends('layouts.index')

@section('content')
<div class="container-fluid">
    <div class="row">
         <div class="col-md-10 offset-1">
            <div class="table">
			    <div class="table-wrapper">
                        <div class="table-title mb-3">
                            <div class="row">
                            <div class="col-xs-6 col-md-12">
                                    <h2>Manage <b>Announcements</b></h2>
                                </div>
                                <div class="col-xs-7 col-md-12">
                                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#addprice">Add Announcement</button>
                                </div>
                            </div>
                        </div>
                        <table id="announcementTable" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                            <thead>
                                <tr>
                                  
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Date</th>
                                    <th>Display</th>
                                    <th>Actions</th>
                                 
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($announcements as $announcement)
                                <tr id="aid{{$announcement->id}}">
                                 
                                    <td>{{$announcement->id}}</td>
                                    <td>{{$announcement->title}}</td>
                                    <td>{{Str::limit($announcement->description,100)}}</td>
                                    <td>{{$announcement->updated_at}}</td>
                                    <td>{{$announcement->display}}</td>
                                    
                                   
                                    <td>  
                                    <button onclick="getAnnouncementInfo({{$announcement->id}})" type="button" class="btn btn-outline-primary" data-toggle="tooltip" data-placement="top" title="View Announcment"><i class="fa fa-eye"></i></button>
                                    <button onclick="deleteAnnouncement({{$announcement->id}})" type="button" class="btn btn-outline-danger" data-toggle="tooltip" data-placement="top" title="Delete Announcment"><i class="fa fa-trash"></i></button>
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


<!-- edit new announcement price Modal -->
<div class="modal fade" id="editAnnouncment" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div id="addModal2" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Announcement</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="edit_announcementForm"  enctype="multipart/form-data">
        @csrf
          <div class="modal-body">
             
                <div class="form-group">
                    <label for="edit_title">Title</label>
                    <input type="text" class="form-control" id="edit_title" placeholder="Enter paper edit_title" name="edit_title" required>
                    <span class="text-danger error-text edit_title_err"></span>
                </div>

                <div class="form-group">
                    <label for="edit_description">Description</label>
                    <textarea class="form-control" id="edit_description" name="edit_description"></textarea>
                    <span class="text-danger error-text edit_description_err"></span>
                </div>

                <div class="form-group">
                    <label for="edit_display">Add to home page:</label><br>
                    <select class="form-control" id="edit_display" name="edit_display">
                        <option disabled selected value> -- select an option -- </option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                    <span class="text-danger error-text edit_display_err"></span>
                </div>

               

              <!-- token -->
              <input type="hidden" name="edit_token" id="token" value="{{ csrf_token() }}"> 
               <!-- id -->
               <input type="hidden" name="id" id="id" value=""> 
            
          </div>  <!-- end modal body -->
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
      </form>  
    </div>
  </div>
</div>
<!-- end edit announcement price modal -->

<!-- Add new announcement price Modal -->
<div class="modal fade" id="addprice" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div id="addModal2" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Announcement</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="announcementForm"  enctype="multipart/form-data">
        @csrf
          <div class="modal-body">
             
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" placeholder="Enter paper title" name="title" required>
                    <span class="text-danger error-text title_err"></span>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description"></textarea>
                    <span class="text-danger error-text description_err"></span>
                </div>

                <div class="form-group">
                    <label for="display">Add to home page:</label><br>
                    <select class="form-control" id="display" name="display">
                        <option disabled selected value> -- select an option -- </option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                    <span class="text-danger error-text modeOfPayment_err"></span>
                </div>

               

              <!-- token -->
              <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}"> 
            
          </div>  <!-- end modal body -->
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
      </form>  
    </div>
  </div>
</div>
<!-- end add new announcement price modal -->


<script>
//start get announcement info 
function getAnnouncementInfo(valueId){
    $("#announcementForm").trigger("reset");
    $.get('/getAnnouncementInfo/'+valueId,function(data){   

        console.log(data);
        $('#id').val(data.id);
        $('#edit_title').val(data.title);
        $('#edit_description').val(data.description);
        $('#edit_display').val(data.display);
      

    });
   
    // open modal
    $("#editAnnouncment").modal('toggle');

}
// end get announcement info


//start add announcement
$('#announcementForm').on('submit',function(event){
    event.preventDefault();
      $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        }); 
         var formData = new FormData(this);


         Swal.fire({
          title: 'Are you sure you want to add this announcement?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, update it!'
          }).then((result) => {
            if (result.isConfirmed) {
              $.ajax({
                  url:"{{route('announcement.store')}}",
                  type:'post',
                  data: formData,
                  cache:false,
                  contentType: false,
                  processData: false,
                  success:function(data){
                        console.log(data);
                    if($.isEmptyObject(data.error)){
                        // alert(data.success);
                        console.log("sod success");
                        $(".text-danger").hide();
                        Swal.fire({
                            icon: 'success',
                            title: 'Announcement added' ,
                            showConfirmButton: false,
                            timer: 2000
                            }).then((result) => {

                                location.reload();
                            
                        });
                        }else{
                          $(".text-danger").show();
                          printErrorMsg(data.error);
                          console.log("sod error");
                        }
                },
                  error: function(data) {
                      console.log(data);
                      Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong.Please reload the page and try again!',
                        timer: 1000
                      }).then((result) => {
                          // Reload the Page
                          location.reload();
                      });
                  }
                });
            }else{
            Swal.fire('announcement was not added.')
            }
  
          });   
    

   

});
// end add announcement



// start edit announcement
$('#edit_announcementForm').on('submit',function(event){
    event.preventDefault();
      $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        }); 
         var formData = new FormData(this);


         Swal.fire({
          title: 'Are you sure you want to update this announcement?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, update it!'
          }).then((result) => {
            if (result.isConfirmed) {
              $.ajax({
                  url:"{{route('announcement.update')}}",
                  type:'post',
                  data: formData,
                  cache:false,
                  contentType: false,
                  processData: false,
                  success:function(data){
                        console.log(data);
                    if($.isEmptyObject(data.error)){
                        // alert(data.success);
                        console.log("sod success");
                        $(".text-danger").hide();
                        Swal.fire({
                            icon: 'success',
                            title: 'Announcement updated.' ,
                            showConfirmButton: false,
                            timer: 2000
                            }).then((result) => {

                                location.reload();
                            
                        });
                        }else{
                          $(".text-danger").show();
                          printErrorMsg(data.error);
                          console.log("sod error");
                        }
                },
                  error: function(data) {
                      console.log(data);
                      Swal.fire({
                          icon: 'error',
                          title: 'Oops...',
                          text: 'Something went wrong.Please reload the page and try again!',
                          timer: 1000
                        }).then((result) => {
                            // Reload the Page
                            location.reload();
                        });
                  }
                });
            }else{
            Swal.fire('announcement was not updated.')
            }
  
          });   
    


});
// end edit announcement


// delete announcement start
function deleteAnnouncement(valueId){
 
 var id = valueId;
 Swal.fire({
   title: 'Are you sure?',
   text: "Once deleted, you will not be able to recover this!",
   icon: 'warning',
   showCancelButton: true,
   confirmButtonColor: '#3085d6',
   cancelButtonColor: '#d33',
   confirmButtonText: 'Yes, delete it!'
   }).then((result) => {
     if (result.isConfirmed) {
       $.ajax({
             url:"/printAnnouncement/"+id,
             type:'DELETE',
             data:{
               _token: $("input[name=_token]").val()
             },
             success:function(data) {
            //   remove datatooltip in UI
              location.reload();
             Swal.fire({
             icon: 'success',
             title: 'Announcement deleted',
             showConfirmButton: false,
             timer: 2500
           })
       
           }, error: function(data) {
             console.log(data);
            Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong.Please reload the page and try again!',
                    timer: 1000
                  }).then((result) => {
                      // Reload the Page
                      location.reload();
                  });
             }
       });
   } 
 });

}
// delete product announcement



// printing error message  for validation start
function printErrorMsg (msg) {
            console.log("sod message");
            $.each( msg, function( key, value ) {
            console.log(key);
              $('.'+key+'_err').text(value);
            });
}
// printing error message end
 

 
</script>


@endsection
