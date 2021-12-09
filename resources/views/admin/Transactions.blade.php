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
                                    <h2>Manage <b>Transactions</b></h2>
                          </div>
                            
                      </div>
                    </div>
                        <table id="myOrderTable" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                            <thead>
                                <tr> 
                                    <th>No.</th>    
                                    <th>Reference Number</th>
                                    <th>Pickup Date</th>
                                    <th>Filename</th>
                                    <th>Payment Method</th>
                                    <th>Payment Status</th>
                                    <th>Total Price</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                              @foreach ($transactions as $transaction)
                                @if($transaction->orders->status == "Processed")
                                    <!-- data row will not be inserted from the table -->
                                @else
                                  <tr id="tid{{$transaction->id}}">
                                      <td>{{$loop->iteration}}</td> 
                                      <td>{{$transaction->orders->referenceNumber}}</td>
                                      <td>{{date('j F, Y', strtotime($transaction->orders->pickupDate))}}</td>
                                      <td>{{$transaction->orders->files->filename}}</td>
                                      <td>{{$transaction->orders->modeOfPayment}}</td>
                                      <td>{{$transaction->isPaid}}  
                                      @if ($transaction->orders->modeOfPayment == "Gcash" && $transaction->isPaid == "Paid")
                                      <button onclick="viewReceipt({{$transaction->id}})" type="button" class="btn btn-outline-secondary" ><i class="fa fa-credit-card"></i></button>
                                      @endif
                                      </td>
                                      <td>₱{{number_format($transaction->orders->grandTotalPrice, 2, '.', ',')}}</td> 
                                      
                                      @empty($transaction->status)
                                        <td>{{$transaction->orders->status}}</td>
                                      @else
                                        @if($transaction->status == "Delivered")
                                        <td>Completed</td>
                                        @elseif($transaction->status== "Ready for pick up")
                                          <td>{{$transaction->status}}
                                           <button onclick="notifyUser({{$transaction->id}})" type="button" class="btn btn-outline-success" data-toggle="tooltip" data-placement="top" title="Send message" ><i class="fa fa-envelope"></i></button>
                                          </td>
                                         
                                        @else
                                        <td>{{$transaction->status}}</td>
                                        @endif
                                       @endif

                                      
                                      <td>  
                                        <a href="{{url('/viewOrder',$transaction->order_id)}}" type="button" class="btn btn-outline-dark" data-toggle="tooltip" data-placement="top" title="View File Uploaded" target="_blank" rel="noopener noreferrer"><span class="fa fa-print"></span></a>
                                        <button onclick="getOrderInfo({{$transaction->id}})" type="button" class="btn btn-outline-primary" data-toggle="tooltip" data-placement="top" title="View Order Form" ><i class="fa fa-eye"></i></button>
                                    </td>
                                  </tr>
                                @endif
                              @endforeach 
                            </tbody>
                            <!-- <tfoot>
                                <tr>
                                    <th>No.</th> 
                                    <th>Reference Number</th>
                                    <th>Pickup Date</th>
                                    <th>Filename</th>
                                    <th>Payment Method</th>
                                    <th>Payment Status</th>
                                    <th>Total Price</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </tfoot> -->
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
      <form id="viewTransactionForm"  enctype="multipart/form-data">
        @csrf 
          <!-- div modal body -->
          <div class="modal-body">
                <div class="form-row mt-4">
                          <!-- pick up date -->
                          <div class="col-sm-12 pb-3">
                              <label for="referenceNumber">Reference number: &nbsp   <span class="h3" id="referenceNumber"> </span> </label>
                              <span class="text-danger error-text referenceNumber_err"></span>
                          </div>
                          <!-- pick up date -->
                          <div class="col-sm-6 pb-3">
                              <label for="pickupDate">Pick up date:</label>
                              <input type="date" class="form-control col-sm-6" id="pickupDate"  placeholder="Enter first name" name="pickupDate" style="background-color:white" readonly>
                              <span class="text-danger error-text pickupDate_err"></span>
                          </div>
                          <!-- space -->
                          <div class="col-sm-12 pb-3">
                              <hr class="my-3">
                              <h3>File details </h3>
                          </div>
                          <!-- size and isColored -->
                          <div class="col-sm-6 pb-3">
                              <label for="praperSize">Paper size:</label>
                              <input type="text" class="form-control praperSize" id="praperSize" placeholder="" name="praperSize_id"  value="" style= "background-color: white" readonly>
                              <span class="text-danger error-text praperSize_err"></span>
                          </div>
                          <!-- price per paper -->
                          <div class="col-sm-6 pb-3">
                              <label for="price">Price per paper:</label><br>
                              <div class="input-group">
                                  <div class="input-group-prepend"><span class="input-group-text">₱</span></div>
                                  <input type="number" class="form-control price" id="price" placeholder="" name="price"  value="0" style= "background-color: white" readonly>
                                  <span class="text-danger error-text price_err"></span>
                              </div>
                          </div>                    
                          <!-- page from -->
                          <div class="col-sm-5 pb-3">
                              <label for="pageFrom">Page from:</label>
                              <input type="number" class="form-control pageFrom" id="pageFrom" min="1" placeholder="Enter start page" name="pageFrom" style= "background-color: white" readonly>
                              <span class="text-danger error-text pageFrom_err"></span>
                          </div>
                          <!-- page to -->
                          <div class="col-sm-5 pb-3">
                              <label for="pageTo">Page to:</label>
                              <input type="number" class="form-control pageTo" id="pageTo" min="1" placeholder="Enter end page" name="pageTo" style= "background-color: white" readonly>
                              <span class="text-danger error-text pageTo_err"></span>
                          </div>
                          <!-- total pages -->
                          <div class="col-sm-2 pb-3">
                              <label for="totalPages">Total pages:</label>
                              <input type="number" class="form-control totalPages" id="totalPages" placeholder="" name="totalPages"  style= "background-color: white" value="0" readonly>
                              <span class="text-danger error-text totalPages_err"></span>
                          </div>
                          <!-- no of copies -->
                          <div class="col-sm-6 pb-3">
                              <label for="noOfCopy">Number of copies:</label>
                              <input type="text" class="form-control price" id="noOfCopy" placeholder="" name="noOfCopy"  value="" style= "background-color: white" readonly>
                              <span class="text-danger error-text noOfCopy_err"></span>
                          </div>
                          <!-- upload file -->
                          <div class="col-sm-6 pb-3">
                            
                                   <label for="file">File name:</label>
                                  <input type="text" class="form-control file" id="file" placeholder="" name="file"  value="" style= "background-color: white" readonly>
                                  <span class="text-danger error-text file_err"></span>
                          </div>
                          
                           <!-- MOP -->
                           <div class="col-sm-6 pb-3">
                              <label for="modeOfPayment">Mode of payment:</label><br>
                              <input type="text" class="form-control price" id="modeOfPayment" placeholder="" name="modeOfPayment"  value="" style= "background-color: white" readonly>
                              <span class="text-danger error-text modeOfPayment_err"></span>
                          </div>
                            
                          <!-- total price -->
                          <div class="col-sm-6 pb-3">
                              <label for="status">Order satus:</label><br>
                                      <input type="text" class="form-control status" id="status" placeholder="" name="status"  value="" style= "background-color: white" readonly>
                                      <span class="text-danger error-text status_err"></span>
                          </div>   
                           

                          <!-- total price -->
                          <div class="col-sm-6 pb-3">
                              <label for="grandTotalPrice">Total price:</label><br>
                              <div class="input-group">
                                      <div class="input-group-prepend"><span class="input-group-text">₱</span></div>
                                      <input type="text" class="form-control grandTotalPrice" id="grandTotalPrice" placeholder="" name="grandTotalPrice"  value="" style= "background-color: white" readonly>
                                      <span class="text-danger error-text grandTotalPrice_err"></span>
                              </div>
                          </div>  
                         
                           <!--isPaid -->
                           <div class="col-sm-6  pb-3">
                                <label for="isPaid">Transaction Payment</label>
                                <input type="text" class="form-control isPaid" id="isPaid" placeholder="" name="isPaid"  value="" style= "background-color: white" readonly>
                          </div>

                          


                          <!-- Remarks -->
                          <div class="col-md-12 pb-2 mt-2">
                                  <label for="remarks">Remarks</label>
                                  <textarea class="form-control" id="remarks" name="remarks" style= "background-color: white" readonly></textarea>
                                  <small class="text-info">
                                  <!-- Add the packaging note here. -->
                                  </small>
                          </div>

                            <!-- Feedback-->
                           <div id="feedbackTextArea" class="col-md-12 pb-2 mt-2">
                           </div>
                             

                         
                           <!-- Cancelled Order Reason -->
                           <div id="cancelledTextArea" class="col-md-12 pb-2 mt-2">

                           

                           </div>


                          <!-- token -->
                          <input type="hidden" name="e_token" id="e_token" value="{{ csrf_token() }}">

                          <!-- transaction id -->
                          <input type="hidden" class="form-control status" id="id" placeholder="" name="id"  value="" style= "background-color: white" readonly>
                            
                          <!-- space -->
                          <div class="col-sm-12 pb-3">
                              <hr class="my-3">
                          </div>
                      
                          <!-- transaction status -->
                          <div id="updateTransactionSatusDiv" class="col-sm-6 pb-3">
                              <label for="updateTransactionStatus">Update order transaction status:</label><br>
                                  <select class="form-control updateTransactionStatus" id="updateTransactionStatus" name="updateTransactionStatus">
                                      <option disabled selected value> -- select an option -- </option>
                                      <option value="Printing in process">Printing in process</option>
                                      <option value="Ready for pick up">Ready for pick up</option>
                                      <option value="Delivered">Delivered</option>
                                  </select>
                              <span class="text-danger error-text transactionStatus_err"></span>
                          </div>  

              </div>
            </div>
              <!-- footer -->
              <div class="modal-footer" id="footer">
                  <button  id="update" type="submit" class="btn btn-success">Update</button>
              </div>
                       
      </form>  
    </div>
  </div>
</div>
<!-- end view order modal -->


<!-- start View Uploaded Receipt Modal -->
<div class="modal fade" id="viewReceiptModal" tabindex="-1" aria-labelledby="viewReceiptModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div id="addModal2" class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="viewReceiptModalLabel">View Uploaded Receipt</h4>
        <button type="button" class="close"data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form id="payGcashForm"  enctype="multipart/form-data">
            @csrf   
              <!-- div body -->
              <div class="modal-body">
                  
                      
                        <div class="form-row mt-4">
                                  <!-- pick up date -->
                                  <div class="col-12" id="receiptImage">
                                  <h5>Receipt Image:</h5>
                                  
                                  </div>
                                    <!-- space -->
                                    <div class="col-sm-12 pb-3">
                                      <hr class="my-3">
                                    </div>
                                      <!-- space -->
                                  <div class="col-sm-12 pb-3">
                                    <h5>Gcash Reference Number: <span id="refNumReceipt">  </span></h5>
                                  </div>  
                        </div>  

                         
                  
              </div> <!-- div end body -->
        
            <!-- footer -->
            <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
              </div>
          </form>
    </div>
  </div>
</div>
<!-- end View Uploaded Receipt modal -->


<!-- start send email modal -->
<div class="modal fade" id="emailModal" tabindex="-1" aria-labelledby="emailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div id="addModal2" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="emailModalLabel">Email Information</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="emailForm"  enctype="multipart/form-data">
        @csrf
          <div class="modal-body">
                <!-- paper size -->
                <div class="form-group">
                <label for="subject">Subject</label>
                <input type="text" class="form-control" id="subject" placeholder="Enter subject" name="subject" required>
                <span class="text-danger error-text subject_err"></span>
                </div>

                 <!-- paper size -->
                 <div class="form-group">
                <label for="lastName">Body</label>
                <textarea class="form-control" id="body" name="body" required></textarea>
                <span class="text-danger error-text body_err"></span>
                </div>
            
              <!-- transaction id -->
              <input type="hidden" name="trans_id" id="trans_id" value=""> 

              <!-- token -->
              <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}"> 
            
          </div>  <!-- end modal body -->
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Send</button>
          </div>
      </form>  
    </div>
  </div>
</div>
<!-- end  send email modal -->





<script type="text/javascript">
 
//start get order info 
function getOrderInfo(valueId){

  $.get('/getMyOrderAdmin/'+valueId,function(data){     
  
    console.log(data);
    //Get the data value
    var yourDateValue = new Date(data.transaction.orders.pickupDate); 
    //Format the date value
    var formattedDate2 = data.transaction.orders.pickupDate.toString().substr(0, 10);
    //Assign date value to date textbox
    $('#pickupDate').val(formattedDate2);
    $('#referenceNumber').html(data.transaction.orders.referenceNumber);
    $('#price').val(data.price.price);
    $('#pageFrom').val(data.transaction.orders.files.pageFrom);
    $('#pageTo').val(data.transaction.orders.files.pageTo);
    $('#totalPages').val(data.transaction.orders.files.totalPages);
    $('#noOfCopy').val(data.transaction.orders.files.noOfCopy);
    $('#modeOfPayment').val(data.transaction.orders.modeOfPayment);
    $('#grandTotalPrice').val(data.transaction.orders.grandTotalPrice);
    $('#status').val(data.transaction.orders.status);
    $('#file').val(data.transaction.orders.files.filename);
    $('#remarks').val(data.transaction.orders.remarks);
    $('#isPaid').val(data.transaction.isPaid);
    $('#transactionStatus').val(data.transaction.status);
    $('#id').val(data.transaction.id);

    // order status
    (data.transaction.status == null) ? $('#status').val(data.transaction.orders.status) :  $('#status').val(data.transaction.status);
    // update button
    (data.transaction.orders.status === "Confirmed") ? $("#update").show() :  $("#update").hide();

    // Paper Size
    var type;
    (data.price.isColored === "Yes") ?  type = "Colored" : type = "Black & White";
    $('#praperSize').val(data.price.size +" ("+ data.price.dimension+") " +" - "+type);
  
    if(data.transaction.orders.status == "Cancelled"){
      $("#updateTransactionSatusDiv").hide();
      $("#footer").hide();
      var html = '';
        html += ' <label style="color:red" for="cancelledReason">Cancelled Reason</label>';
        html += ' <textarea class="form-control" id="cancelledReason" name="cancelledReason" style="background-color: white" readonly></textarea>';
        html += ' <small class="text-info">';
      $('#cancelledTextArea').append(html);
    }
    $('#cancelledReason').val(data.transaction.orders.cancelledReason);


    if(data.transaction.orders.feedback != null){
     // $("#updateTransactionSatusDiv").hide();
     // $("#footer").hide();
       var html = '';
        html += ' <label  for="feedback">Order Feedback</label>';
        html += ' <textarea class="form-control" id="feedback" name="feedback" style="background-color: white" readonly></textarea>';
        html += ' <small class="text-info">';
      $('#feedbackTextArea').append(html);
    }
    $('#feedback').val(data.transaction.orders.feedback);




      // order status update select option
      $(".updateTransactionStatus option").filter(function() {
        return $(this).data().number === 0
      }).prop("disabled", false)


      console.log(data.transaction.status);
      if(data.transaction.status === "Printing in process"){
        console.log("Printing in process ");
        $('#updateTransactionStatus option[value="Printing in process"]').attr('disabled',true);
        $('#updateTransactionStatus option[value="Ready for pick up"]').attr('disabled',false);
        $('#updateTransactionStatus option[value="Delivered"]').attr('disabled',false);
      }else if(data.transaction.status === "Ready for pick up"){
        console.log("ready for pick up ");
        $('#updateTransactionStatus option[value="Printing in process"]').attr('disabled',true);
        $('#updateTransactionStatus option[value="Ready for pick up"]').attr('disabled',true);
        $('#updateTransactionStatus option[value="Delivered"]').attr('disabled',false);
      }else if(data.transaction.status === "Delivered"){
        console.log("Delivered");
        $('#updateTransactionStatus option[value="Printing in process"]').attr('disabled',true);
        $('#updateTransactionStatus option[value="Ready for pick up"]').attr('disabled',true);
        $('#updateTransactionStatus option[value="Delivered"]').attr('disabled',true);
      }else{
        console.log("wa sod ");
        $('#updateTransactionStatus option[value="Printing in process"]').attr('disabled',false);
        $('#updateTransactionStatus option[value="Ready for pick up"]').attr('disabled',false);
        $('#updateTransactionStatus option[value="Delivered"]').attr('disabled',false);
      }

    
   // open modal
  $("#viewModal").modal('toggle');
});

}
//end get order info 

//start accept order referenceNumber
$('#viewTransactionForm').on('submit',function(event){
 
  event.preventDefault();
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });   

      var id = $('#id').val(); //get the id of order
      var status = $('#updateTransactionStatus').val(); //get the transaction status
      console.log(id , status);
      Swal.fire({
        title: 'Are you sure you want to update the transaction order?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, accept it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url:"{{route('transactionAdmin.updateStatus')}}",
              type:'POST',
              data: {id:id,status:status},
              success:function(data){
              console.log(data);
                
                if($.isEmptyObject(data.error)){
                        console.log("sod success");
                        $(".text-danger").hide();

                        Swal.fire({
                        icon: 'success',
                        title: 'Transaction status updated',
                        type: "success",
                        showConfirmButton: false, 
                        }).then((result) => {
                          // Reload the Page
                          location.reload();
                        });
                          
                        
                        $('#viewModal').modal('toggle');

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

        });

   

});
// end accept order

//start view gcash receipt uploaded
function viewReceipt(valueId){
   
  $('#receiptImage').empty();
  $.get('/viewReceiptAdmin/'+valueId,function(data){ 
  console.log(data);
  $("#refNumReceipt").text(data.refNumReceipt);    

     
    var html = '';
    if(data.receipt){
      html += ' <img src="gcash/'+data.receipt+'" id="qr"class="img-thumbnail rounded mx-auto d-block" alt="...">';
    }
    $('#receiptImage').append(html);       
    
    // open modal
    $("#viewReceiptModal").modal('toggle');
    });

}
//end view gcash receipt uploaded

//start view gcash receipt uploaded
function notifyUser(valueId){
  
  // open modal
    $("#emailModal").modal('toggle');

     $.get('/getMyOrderAdmin/'+valueId,function(data){     
        console.log(data);

         $('#trans_id').val(data.transaction.id);


     });
  

}
//end view gcash receipt uploaded

//start update user
$('#emailForm').on('submit',function(event){
    event.preventDefault();
      $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        }); 
         var formData = new FormData(this);


         Swal.fire({
          title: 'Are you sure you want to send email?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, send it!'
          }).then((result) => {
            if (result.isConfirmed) {
              $.ajax({
                  url:"{{route('transactionAdmin.notifyUser')}}",
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
                            title: 'Email has been sent!' ,
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
            Swal.fire('email was not send.')
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
 

@endsection