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
                                <!-- <div class="col-xs-7 col-md-12">
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addModal">New Order</button>
                                </div> -->
                            </div>
                        </div>
                        <table id="userTable" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Type</th>
                                    <th>Contact</th>
                                    <th>Actions</th>
                                 
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($users as $user)
                                <tr id="uid{{$user->id}}">
                                    <td>{{$user->idNumber}}</td>
                                    <td>{{$user->firstName}} {{$user->lastName}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->roles->first()->name}}</td>
                                    <td>{{$user->contact}}</td>
                                   
                                    <td>  
                                    <button onclick="getUserInfo({{$user->id}})" type="button" class="btn btn-outline-primary" data-toggle="tooltip" data-placement="top" title="View Order Form"><i class="fa fa-eye"></i></button>
                                    <!-- <button onclick="deleteStaff({{$user->id}})" type="button" class="btn btn-danger" >delete</button> -->
                                    </td>
                               
                                </tr>
                            @endforeach 
                            
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>User ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Type</th>
                                    <th>Contact</th>
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
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

                 <!-- adamson email -->
                 <div class="form-group">
                <label for="contact">Contact Number</label>
                <input type="text" class="form-control" id="contact" placeholder="Enter contact number" name="contact" required>
                <span class="text-danger error-text contact_err"></span>
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
        $('#contact').val(data.contact);
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
          // text: "Once deleted, you will not be able to recover this!",
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

                                // window.location.href = "{{url('/myOrders')}}";
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
                      alert("wa sod");
                  }
                });
            }else{
            Swal.fire('Order was not added.')
            }
  
          });   
    

   

});
// end update user
 

 
</script>


@endsection
