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
                                    <h2>Manage <b>Users</b></h2>
                                </div>
                            </div>
                        </div>
                        <table id="userTable" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                            <thead>
                                <tr>
                                  <th>No.</th>    
                                    <th>User ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Type</th>
                                    <th>Occupation</th>
                                    <th>Blocklisted</th>
                                    <th>Actions</th>
                                 
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($users as $user)
                                <tr id="uid{{$user->id}}">
                                  <td>{{$loop->iteration}}</td> 
                                    <td>{{$user->idNumber}}</td>
                                    <td>{{$user->firstName}} {{$user->lastName}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->roles->first()->name}}</td>
                                    <td>{{$user->occupation}}</td>
                                    <td>{{$user->isBlocked}}</td>
                                   
                                    <td>  
                                   
                                    
                                    <button onclick="getUserInfo({{$user->id}})" type="button" class="btn btn-outline-primary" data-toggle="tooltip" data-placement="top" title="View Information"><i class="fa fa-eye"></i></button>
                                    <button   onclick="blockUser({{$user->id}})" type="button" class="btn btn-outline-warning" data-toggle="tooltip" data-placement="top" title="Update Blocklist"><i class="fa fa-user-lock"></i></button>
                                    <button onclick="deleteUser({{$user->id}})"  type="button" class="btn btn-outline-danger" data-toggle="tooltip" data-placement="top" title="Delete User"><i class="fa fa-trash"></i></button>
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

<!-- start view user modal -->
<div class="modal fade" id="viewUserModal" tabindex="-1" aria-labelledby="viewUserModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div id="addModal2" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewUserModalLabel">View User Information</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="userForm"  enctype="multipart/form-data">
        @csrf
          <div class="modal-body">
                <!-- paper size -->
                <div class="form-group">
                <label for="firstName">First Name</label>
                <input type="text" class="form-control" id="firstName" placeholder="Enter first name" name="firstName" required>
                <span class="text-danger error-text firstName_err"></span>
                </div>

                 <!-- paper size -->
                 <div class="form-group">
                <label for="lastName">Last Name</label>
                <input type="text" class="form-control" id="lastName" placeholder="Enter name" name="lastName" required>
                <span class="text-danger error-text lastName_err"></span>
                </div>

                <!-- adamson email -->
                <div class="form-group">
                <label for="email">Email</label>
                <input type="text" class="form-control" id="email" placeholder="Enter email" name="email" required>
                <span class="text-danger error-text email_err"></span>
                </div>
                
                <!-- price -->
                <div class="form-group">
                <label for="idNumber">ID Number</label>
                <input type="number" class="form-control" id="idNumber" placeholder="Enter ID idNumber" name="idNumber" required>
                <span class="text-danger error-text price_err"></span>
                </div>

                 <!-- adamson email
                 <div class="form-group">
                <label for="contact">Contact Number</label>
                <input type="text" class="form-control" id="contact" placeholder="Enter contact number" name="contact" required>
                <span class="text-danger error-text contact_err"></span>
                </div> -->

                <div class="form-group">
                    <label for="occupation">Occupation</label><br>
                    <select class="form-control" id="occupation" name="occupation">
                        <option disabled  value> -- select an option -- </option>
                        <option value="Student"> Student </option>
                        <option value="Professor"> Professor </option>
                        <option value="Employee"> Employee </option>
                    </select>
                    <span class="text-danger error-text modeOfPayment_err"></span>
                </div>

                 
                <div class="form-group">
                    <label for="type">User Type</label><br>
                    <select class="form-control" id="type" name="type">
                        <option disabled  value> -- select an option -- </option>
                        <option value="1">Admin</option>
                        <option value="2">User</option>
                    </select>
                    <span class="text-danger error-text modeOfPayment_err"></span>
                </div>

              <!-- token -->
              <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}"> 
            
          </div>  <!-- end modal body -->
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
      </form>  
    </div>
  </div>
</div>
<!-- end  view user modal -->


<script>
//start get user info 
function getUserInfo(valueId){
    $("#userForm").trigger("reset");
    $.get('/getUserInfo/'+valueId,function(data){   

        console.log(data);
         
        $('#firstName').val(data.firstName);
        $('#lastName').val(data.lastName);
        $('#email').val(data.email);
        $('#idNumber').val(data.idNumber);
        $('#occupation').val(data.occupation);
        $('#type').val(data.type);

    });
   
    // open modal
    $("#viewUserModal").modal('toggle');

}
// end get user info


//start update user
$('#userForm').on('submit',function(event){
    event.preventDefault();
      $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        }); 
         var formData = new FormData(this);


         Swal.fire({
          title: 'Are you sure you want to update user type?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, update it!'
          }).then((result) => {
            if (result.isConfirmed) {
              $.ajax({
                  url:"{{route('user.updateUserType')}}",
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
                            title: 'User Info has been updated' ,
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
            Swal.fire('Order was not added.')
            }
  
          });   
    

   

});
// end update user

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

<script>
  //start block user 
function blockUser(valueId){
 
  event.preventDefault();
  $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });   

  swal.fire({
  title: 'Block or Unblock the user for using the system.',
  showCancelButton: true,
  confirmButtonText: 'Update',
  }).then((result) => {

      if (result.isConfirmed) {
       
        var id = valueId;
         
        
        $.ajax({
          url:"{{route('user.blockUser')}}",
          type:'POST',
          data: {id:id},
          success:function(data){
            console.log(data);
            
            if($.isEmptyObject(data.error)){
                    console.log("success");
                    $(".text-danger").hide();

                    Swal.fire({
                    icon: 'success',
                    title: 'Order has been cancelled',
                    showConfirmButton: false,
                    timer: 1000
                    })
                   
                    location.reload();
                    
                    $('#viewModal').modal('toggle');
                    $('#viewModal')[0].reset();   
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
      }   
    })
}
// end cancel order



// delete user start
function deleteUser(valueId){
 
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
             url:"/UserDelete/"+id,
             type:'DELETE',
             data:{
               _token: $("input[name=_token]").val()
             },
             success:function(data) {
            //   remove datatooltip in UI
              location.reload();
             Swal.fire({
             icon: 'success',
             title: 'User deleted',
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
// delete user end

</script>


@endsection
