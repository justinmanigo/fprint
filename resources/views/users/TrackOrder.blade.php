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
                                    <h2>Manage <b>Orders</b></h2>
                                </div>
                                <div class="col-xs-7 col-md-12">
                                <!-- <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addModal">New Order</button> -->
                                </div>
                            </div>
                        </div>
                        <table id="orderTable" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Reference Number</th>
                                    <th>Order By</th>
                                    <th>Pickup Date</th>
                                    <th>Filename</th>
                                    <th>Method</th>
                                    <th>Total Price</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                 
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($orders as $order)
                                <tr id="oid{{$order->id}}">
                                    <td>{{$order->referenceNumber}}</td>
                                    <td>{{$order->user->name}}</td>
                                    <td>{{date('j F, Y', strtotime($order->pickupDate))}}</td>
                                    <td>{{$order->files->filename}}</td>
                                    <td>{{$order->modeOfPayment}}</td>
                                    <td>{{$order->grandTotalPrice}}</td> </b>
                                    <td>{{$order->status}}</td>
                                   
                                    <td>  
                                    <button onclick="getOrderInfo({{$order->id}})" type="button" class="btn btn-outline-success" >view</button>
                                    </td>
                               
                                </tr>
                            @endforeach 
                            
                            </tbody>
                            <!----
                            <tfoot>
                                <tr>
                                    <th>Reference Number</th>
                                    <th>Order By</th>
                                    <th>Pickup Date</th>
                                    <th>Filename</th>
                                    <th>Method</th>
                                    <th>Total Price</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                            ----->
                        </table>
                </div>
            </div>
        </div>
    </div>
</div>





<!-- start view order Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div id="addModal2" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">View Order Form</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- div body -->
      <div class="modal-body">
          <form id="viewOrderForm"  enctype="multipart/form-data">
            @csrf   
                  <div class="form-row mt-4">
                       <!-- pick up date -->
                       <div class="col-sm-12 pb-3">
                          <label for="referenceNumber">Reference Number: &nbsp   <span class="h3" id="referenceNumber"> </span> </label>
                          
                         
                          <span class="text-danger error-text referenceNumber_err"></span>
                      </div>
                      <!-- pick up date -->
                      <div class="col-sm-6 pb-3">
                          <label for="pickupDate">Pick-up Date:</label>
                          <input type="date" class="form-control col-sm-6" id="pickupDate"  placeholder="Enter first name" name="pickupDate">
                          <span class="text-danger error-text pickupDate_err"></span>
                      </div>
                      <!-- space -->
                      <div class="col-sm-12 pb-3">
                          <hr class="my-3">
                          <h3>File Details </h3>
                      </div>
                      <!-- size and isColored -->
                      <div class="col-sm-6 pb-3">
                          <label for="praperSize">Paper Size:</label>
                          <input type="text" class="form-control praperSize" id="praperSize" placeholder="" name="praperSize_id"  value="" style= "background-color: white" readonly>
                          <span class="text-danger error-text praperSize_err"></span>
                      </div>
                      <!-- price per paper -->
                      <div class="col-sm-6 pb-3">
                          <label for="price">Price per paper:</label><br>
                          <div class="input-group">
                              <div class="input-group-prepend"><span class="input-group-text">$</span></div>
                              <input type="number" class="form-control price" id="price" placeholder="" name="price"  value="0" style= "background-color: white" readonly>
                              <span class="text-danger error-text price_err"></span>
                          </div>
                      </div>                    
                      <!-- page from -->
                      <div class="col-sm-5 pb-3">
                          <label for="pageFrom">Page From:</label>
                          <input type="number" class="form-control pageFrom" id="pageFrom" min="1" placeholder="Enter start page" name="pageFrom" style= "background-color: white" readonly>
                          <span class="text-danger error-text pageFrom_err"></span>
                      </div>
                      <!-- page to -->
                      <div class="col-sm-5 pb-3">
                          <label for="pageTo">Page To:</label>
                          <input type="number" class="form-control pageTo" id="pageTo" min="1" placeholder="Enter end page" name="pageTo" style= "background-color: white" readonly>
                          <span class="text-danger error-text pageTo_err"></span>
                      </div>
                      <!-- total pages -->
                      <div class="col-sm-2 pb-3">
                          <label for="totalPages">Total Pages:</label>
                          <input type="number" class="form-control totalPages" id="totalPages" placeholder="" name="totalPages"  style= "background-color: white" value="0" readonly>
                          <span class="text-danger error-text totalPages_err"></span>
                      </div>
                      <!-- no of copies -->
                      <div class="col-sm-6 pb-3">
                          <label for="noOfCopy">Number of Copies:</label>
                          <input type="text" class="form-control price" id="noOfCopy" placeholder="" name="noOfCopy"  value="" style= "background-color: white" readonly>
                          <span class="text-danger error-text noOfCopy_err"></span>
                      </div>
                      <!-- MOP -->
                      <div class="col-sm-6 pb-3">
                          <label for="modeOfPayment">Mode of payment:</label><br>
                          <input type="text" class="form-control price" id="modeOfPayment" placeholder="" name="modeOfPayment"  value="" style= "background-color: white" readonly>
                          <span class="text-danger error-text modeOfPayment_err"></span>
                      </div>
                      <!-- total price -->
                      <div class="col-sm-6 pb-3">
                          <label for="grandTotalPrice">Total Price:</label><br>
                          <div class="input-group">
                                  <div class="input-group-prepend"><span class="input-group-text">$</span></div>
                                  <input type="text" class="form-control grandTotalPrice" id="grandTotalPrice" placeholder="" name="grandTotalPrice"  value="" style= "background-color: white" readonly>
                                  <span class="text-danger error-text grandTotalPrice_err"></span>
                          </div>
                      </div>   
                       <!-- total price -->
                       <div class="col-sm-6 pb-3">
                          <label for="status">Satus:</label><br>
                                  <input type="text" class="form-control status" id="status" placeholder="" name="status"  value="" style= "background-color: white" readonly>
                                  <span class="text-danger error-text status_err"></span>
                      </div>   
                      <!-- upload file -->
                      <div class="col-6">
                          <div class="form-row">
                              <label class="col-md col-form-label" for="file">File</label>
                              <input type="text" class="form-control file" id="file" placeholder="" name="file"  value="" style= "background-color: white" readonly>
                          </div>
                      </div>
                     

                      <!-- space -->
                      <div class="col-sm-12 pb-3">
                          <hr class="my-3">
                      </div>
                      <!-- Remarks -->
                      <div class="col-md-12 pb-2 mt-2">
                              <label for="remarks">Remarks</label>
                              <textarea class="form-control" id="remarks" name="remarks" style= "background-color: white" readonly></textarea>
                              <small class="text-info">
                              Add the packaging note here.
                              </small>
                      </div>
                        <!-- token -->
                        <input type="hidden" name="e_token" id="e_token" value="{{ csrf_token() }}">

                         <!-- token -->
                         <input type="hidden" class="form-control status" id="id" placeholder="" name="id"  value="" style= "background-color: white" readonly>
                            
                    </div>

                    <!-- footer -->
                    <div class="modal-footer" id="footer"></div>        
                    
          </form>  
        
      </div>
      <!-- div end body -->
      
    </div>
  </div>
</div>
<!-- end view order modal -->
<script type="text/javascript">
//start get order info 
function getOrderInfo(valueId){

$.get('/getOrder/'+valueId,function(order){  
  
  console.log(order);
  //Get the data value
  var yourDateValue = new Date(order.order.pickupDate); 
  //Format the date value
  var formattedDate = yourDateValue.toISOString().substr(0, 10)
  //Assign date value to date textbox
  $('#pickupDate').val(formattedDate);
  $('#referenceNumber').html(order.order.referenceNumber);
  $('#price').val(order.price.price);
  $('#pageFrom').val(order.order.files.pageFrom);
  $('#pageTo').val(order.order.files.pageTo);
  $('#totalPages').val(order.order.files.totalPages);
  $('#noOfCopy').val(order.order.files.noOfCopy );
  $('#modeOfPayment').val(order.order.modeOfPayment);
  $('#grandTotalPrice').val(order.order.grandTotalPrice);
  $('#status').val(order.order.status);
  $('#file').val(order.order.files.filename);
  $('#remarks').val(order.order.remarks);
  $('#id').val(order.order.id);

  var type;
  (order.price.isColored === "Yes") ?  type = "Colored" : type = "Black & White";
  $('#praperSize').val(order.price.size +"-"+type);
  
 

  if(order.order.status === "Processed"){  
        var html = '';
        html += ' <button type="button" class="btn btn-outline-danger">Cancelled</button>';
        html += ' <button   type="submit" class="btn btn-success">Accept</button>';
        
        
    $('#footer').append(html);
    }
  // open modal
  $("#viewModal").modal('toggle');
});

}
//end get order info 

//start accept order 
$('#viewOrderForm').on('submit',function(event){
    event.preventDefault();
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });   

      var id = $('#id').val();

      Swal.fire({
        title: 'Are you sure?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, accept it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url:"{{route('orderUser.acceptOrder')}}",
              type:'POST',
              data: {id:id},
              success:function(data){
                console.log(data);
                
                if($.isEmptyObject(data.error)){
                        console.log("sod success");
                        $(".text-danger").hide();

                        Swal.fire({
                        icon: 'success',
                        title: 'Order Accepted',
                        showConfirmButton: false,
                        timer: 1000
                        })
                          location.reload();  
                }else{
                        $(".text-danger").show();
                        printErrorMsg(data.error);
                        console.log("sod error");
                }   
              },
              error: function(data) {
                  console.log(data);
                  // alert("Exceed 25MB Try again");
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
            Swal.fire('Type was not Updated.')
          }

        });
   

});
// end accept order


</script>
@endsection
