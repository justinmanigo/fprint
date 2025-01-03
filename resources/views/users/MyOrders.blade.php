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
                                     <td class="text-right">₱{{number_format($transaction->orders->grandTotalPrice, 2, '.', ',')}}</td> 

                                     @if ($transaction->status == "")
                                        @if ($transaction->orders->status == "Processed")
                                        <td>Pending</td>
                                        @else
                                        <td>{{$transaction->orders->status}}</td>
                                        @endif

                                     
                                      @else
                                        @if ($transaction->status == "Delivered")
                                        <td>Completed
                                        @if($transaction->orders->feedback == null)
                                         <button onclick="feedback({{$transaction->id}})" type="button" class="btn btn-outline-success" data-toggle="tooltip" data-placement="top" title="send feedback" ><i class="fa fa-envelope"></i></button>
                                        @endif
                                        </td>
                                        @else
                                        <td>{{$transaction->status}}</td>
                                        @endif
                                      @endif

                                     

                                       
                                    
                                     
                                    <td>  
                                    @if ($transaction->orders->status == "Processed")
                                    <button  id="cancel"  onclick="cancelOrder({{$transaction->id}})"  class="btn btn-outline-danger" data-toggle="tooltip" data-placement="top" title="Cancel Order"><i class="fa  fa-times-circle"></i></button>
                                    @endif
                                    <a href="{{url('/viewOrder',$transaction->id)}}" type="button" class="btn btn-outline-dark" data-toggle="tooltip" data-placement="top" title="View File Uploaded" target="_blank" rel="noopener noreferrer"><span class="fa fa-print"></span></a>
                                    <button onclick="getOrderInfo({{$transaction->id}})" type="button" class="btn btn-outline-primary" data-toggle="tooltip" data-placement="top" title="View Order Form"> <i class="fa fa-eye"></i></button>
                                    @if ($transaction->orders->modeOfPayment == "Gcash" && $transaction->orders->status == "Confirmed" &&  $transaction->isPaid == "Not paid")
                                    <button onclick="pay({{$transaction->id}})" id="payButton" type="button" class="btn btn-outline-success" ><i class="fa fa-credit-card"></i></button>
                                    @endif
                                    <button onclick="track({{$transaction->id}})"  type="button" class="btn btn-outline-info" data-toggle="modal" data-toggle="tooltip" data-placement="top" title="Track Order"> <i class="fa fa-truck"></i></button>
                                  </td>
                               
                                </tr>
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
      <!-- div body -->
      <div class="modal-body">
          <form id="viewOrderForm"  enctype="multipart/form-data">
            @csrf   
                  <div class="form-row mt-4">
                       <!-- pick up date -->
                       <div class="col-sm-12 pb-3">
                          <label for="referenceNumber">Reference Number &nbsp   <span class="h3" id="referenceNumber"> </span> </label>
                          
                         
                          <span class="text-danger error-text referenceNumber_err"></span>
                      </div>
                      <!-- pick up date -->
                      <div class="col-sm-6 pb-3">
                          <label for="pickupDate">Pick Up Date</label>
                          <input type="date" class="form-control col-sm-6" id="pickupDate"  placeholder="Enter first name" name="pickupDate" style= "background-color: white">
                          <span class="text-danger error-text pickupDate_err"></span>
                      </div>
                      <!-- space -->
                      <div class="col-sm-12 pb-3">
                          <hr class="my-3">
                          <h3>File Details </h3>
                      </div>
                      <!-- size and isColored -->
                      <div class="col-sm-6 pb-3">
                          <label for="printPrice_id">Paper Size</label>
                            <select class="form-control printPrice_id" id="printPrice_id" name="printPrice_id" style= "background-color: white">
                                      <option disabled selected value> -- select an option -- </option>
                                      @if(isset($prices))
                                      @foreach ($prices as $price)
                                      @if ($price->isColored == "Yes")
                                      <option value="{{$price->id}}" >{{$price->size}} ({{$price->dimension}} ) - Colored</option>
                                      @else
                                      <option value="{{$price->id}}" >{{$price->size}} - Black & White</option>
                                      @endif
                                      @endforeach
                                      @endif
                              </select>
                            <span class="text-danger error-text printPrice_id_err"></span>
                          
                          <!-- <input type="text" class="form-control praperSize" id="praperSize" placeholder="" name="praperSize_id"  value="" style= "background-color: white" readonly>
                          <span class="text-danger error-text praperSize_err"></span> -->
                      </div>
                      <!-- price per paper -->
                      <div class="col-sm-6 pb-3">
                          <label for="price">Price Per Paper:</label><br>
                          <div class="input-group">
                              <div class="input-group-prepend"><span class="input-group-text">₱</span></div>
                              <input type="number" class="form-control price" id="price" placeholder="" name="price"  value="0" style= "background-color: white" readonly>
                              <span class="text-danger error-text price_err"></span>
                          </div>
                      </div>                    
                      <!-- page from -->
                      <div class="col-sm-5 pb-3">
                          <label for="pageFrom">Page From:</label>
                          <input type="number" class="form-control pageFrom" id="pageFrom" min="1" placeholder="Enter start page" name="pageFrom" style= "background-color: white">
                          <span class="text-danger error-text pageFrom_err"></span>
                      </div>
                      <!-- page to -->
                      <div class="col-sm-5 pb-3">
                          <label for="pageTo">Page To:</label>
                          <input type="number" class="form-control pageTo" id="pageTo" min="1" placeholder="Enter end page" name="pageTo" style= "background-color: white">
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
                          <label for="noOfCopy">Number Of Copies:</label>
                          <input type="number" class="form-control" id="noOfCopy" min="1" placeholder="Enter first name" name="noOfCopy" value="0" style= "background-color: white" required>
                            <span class="text-danger error-text noOfCopy_err"></span>
                      </div>
                        <!-- total price -->
                        <div class="col-sm-6 pb-3">
                        <label for="grandTotalPrice">Total Price:</label><br>
                        <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">₱</span></div>
                                <input type="text" class="form-control grandTotalPrice" id="grandTotalPrice" placeholder="" name="grandTotalPrice"  value="" style= "background-color: white" readonly>
                                <span class="text-danger error-text grandTotalPrice_err"></span>
                        </div>
                      </div>   
                      <!-- MOP -->
                      <div class="col-sm-6 pb-3">
                          <label for="modeOfPayment">Mode Of Payment:</label><br>

                          <select class="form-control" id="modeOfPayment" name="modeOfPayment" style= "background-color: white">
                                    <option disabled selected value> -- select an option -- </option>
                                    <option value="COP">Cash on Pickup</option>
                                    <option value="Gcash">Gcash</option>
                                </select>
                            <span class="text-danger error-text modeOfPayment_err"></span>
                            
                          <!-- <input type="text" class="form-control price" id="modeOfPayment" placeholder="" name="modeOfPayment"  value="" style= "background-color: white" readonly>
                          <span class="text-danger error-text modeOfPayment_err"></span> -->
                      </div>
                   
                       <!-- total price -->
                       <div class="col-sm-6 pb-3">
                          <label for="status">Status:</label><br>
                                  <input type="text" class="form-control status" id="status" placeholder="" name="status"  value="" style= "background-color: white" readonly>
                                  <span class="text-danger error-text status_err"></span>
                      </div>   
                      <!-- upload file -->
                      <div class="col-sm-6 pb-3">
                          <div class="form-row">
                              <label class="col-md col-form-label" for="file">Filename</label>
                              <input type="text" class="form-control file" id="file" placeholder="" name="file"  value="" style= "background-color: white" readonly>
                              <!-- <a href="{{url('/viewOrder',2)}}" type="button" class="btn btn-success">View PDF</a> -->
                              <!-- <div  id="viewPDF"></div> -->
                              <!-- <object data="http://www.africau.edu/images/default/sample.pdf" type="application/pdf" width="100%" height="100%"> -->
                              <!-- <input type="file" class="form-control-file" name="file" id="file">
                              <span class="text-danger error-text file_err"></span> -->
                          </div>
                      </div>

                      <!-- space -->
                      <div class="col-sm-12 pb-3">
                          <hr class="my-3">
                      </div>
                      <!-- Remarks -->
                      <div class="col-md-12 pb-2 mt-2">
                              <label for="remarks">Remarks</label>
                              <textarea class="form-control" id="remarks" name="remarks" style= "background-color: white" ></textarea>
                              <small class="text-info">
                              Add the packaging note here.
                              </small>
                      </div>

                      <!-- feedback Order Reason -->
                      <div id="feedbackTextArea" class="col-md-12 pb-2 mt-2">

                      </div>
                      <!-- Cancelled Order Reason -->
                      <div id="cancelledTextArea" class="col-md-12 pb-2 mt-2">

                      </div>
                      <!-- token -->
                      <input type="hidden" name="e_token" id="e_token" value="{{ csrf_token() }}">

                      <!-- order_id -->
                      <input type="hidden" class="form-control status" id="order_id" placeholder="" name="order_id"  value="" style= "background-color: white" readonly>
                      
                      <!-- file_id -->
                      <input type="hidden" class="form-control status" id="file_id" placeholder="" name="file_id"  value="" style= "background-color: white" readonly>
                      
                    </div>

                    <!-- footer -->
                    <div class="modal-footer" id="footer">
                        
                        <button  id="update" type="submit" class="btn btn-success">Update</button>
                        <button type="button" class="btn btn-light"data-bs-dismiss="modal">Close</button>
                    </div>
                     
                    <!-- <div class="modal-footer">
                      <button type="button" class="btn btn-outline-danger">Cancelled</button>
                      <button   type="submit" class="btn btn-success">Accept</button>
                    </div> -->
                    
          </form>  
        
      </div>
      <!-- div end body -->
      
    </div>
  </div>
</div>
<!-- end view order modal -->

<!-- start View Uploaded Receipt Modal -->
<div class="modal fade" id="viewReceiptModal"  aria-labelledby="viewReceiptModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div id="addModal2" class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="viewReceiptModalLabel">View Uploaded Receipt</h4>
        <button type="button" class="close"data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form id="payGcashForm2"  enctype="multipart/form-data">
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

<!-- start pay order Modal -->
<div class="modal fade" id="payModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div id="addModal2" class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Pay order via Gcash</h4>
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
                                  <div class="col-12">
                                  
                                  <h5>QR Code:</h5>
                                  <a href="#" data-target="#modalIMG" data-toggle="modal" class="color-gray-darker c6 td-hover-none">
                                  <img src="{{ asset('/img/qrgcash.png') }}" id="qr"class="img-thumbnail rounded mx-auto d-block" alt="...">
                                  </a>
                                  </div>
                                    <!-- space -->
                                    <div class="col-sm-12 pb-3">
                                      <hr class="my-3">
                                    </div>
                                      <!-- space -->
                                  <div class="col-sm-12 pb-3">
                                    <h5>Gcash Account Number: 09983128845</h5>
                                     </div>
                                    <!-- space -->
                                  <div class="col-sm-12 pb-3">
                                      <hr class="my-3">
                                  </div>
                                   <div class="col-sm-12 pb-3">
                                    <p><strong> Note:</strong> </p>
                                   <p>For Gcash payment, select express send only and type the reference number on the message before sending the payment. 
                                     Our admin receiver will be notified via text message and can identify the payment and be approved directly.</p>
                                  
                                  </div>
                                  <!-- space -->
                                  <div class="col-sm-12 pb-3">
                                    <hr class="my-3">
                                  </div>
                                  <div class="col-sm-12  pb-3">
                                        <h5>Submit your receipt</h5>
                                        <label for="receipt">Upload Screenshot of Receipt</label>
                                        <input type="file" class="form-control-file" name="file" id="file">
                                        <span class="text-danger error-text receipt_err"></span>
                                </div>   
                                
                                <!-- Reference Number -->
                                <div class="col-sm-6 pb-3">
                                    <label for="refNumReceipt">Gcash Reference Number:</label><br>
                                    <input type="text" class="form-control price" id="refNumReceipt" placeholder="" name="refNumReceipt">
                                    <span class="text-danger error-text refNumReceipt_err"></span>
                                </div>
                        </div>  

                        <input type="hidden" id="transaction_id" name="transaction_id" value="">
                  
              </div> <!-- div end body -->
        
            <!-- footer -->
            <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
              </div>
          </form>
    </div>
  </div>
</div>
<!-- end pay order modal -->

<!-- start display gcash qr code -->
<div aria-hidden="true" aria-labelledby="myModalLabel" class="modal fade" id="modalIMG" role="dialog" tabindex="-1">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-body mb-0 p-0">
        <div class="form-row mt-4">
        <div class="col-sm-12 offset-sm-3">
			  	<img src="{{ asset('/img/gcash6.png') }}" alt="" class="img-thumbnail" style="width:60%;">
        </div>
        </div>
			</div>
			<div class="modal-footer">
			 
				<button class="btn btn-outline-primary btn-rounded btn-md ml-4 text-center" data-dismiss="modal" type="button">Close</button>
			</div>
		</div>
	</div>
</div>
<!-- end display gcash qr code -->

<!-- start track order -->
<div class="modal fade" id="trackModal"  role="dialog" aria-labelledby="trackModalModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="trackModalModalTitle">Track Order</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">     


      <div id="trackInfo"></div>

      <!-- <h3>Your order has been confirmed </h3>
      <h6> 2021-5-5 </h6> -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- end track order -->

<!-- start send email modal -->
<div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div id="addModal2" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="feedbackModalLabel">Send Feedback</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="feedbackForm"  enctype="multipart/form-data">
        @csrf
          <div class="modal-body">
                <!-- paper size -->
                <div class="form-group">
                <label for="ref_num">Order Reference Number:</label>
                <input type="text" class="form-control" id="ref_num"  name="ref_num" readonly>
                <span class="text-danger error-text ref_num_err"></span>
                </div>

                 <!-- paper size -->
                 <div class="form-group">
                <label for="feedback">Feedback</label>
                <textarea class="form-control" id="feedback" name="feedback" required></textarea>
                <span class="text-danger error-text feedback_err"></span>
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

$.get('/getMyOrder/'+valueId,function(data){  
  
  console.log(data);
    //Get the data value
    var yourDateValue = new Date(data.order.orders.pickupDate); 
    console.log(data.order.orders.pickupDate.toString().substr(0, 10));
    
  //Format the date value
  // var formattedDate = yourDateValue.toISOString().substr(0, 10);
  var formattedDate2 =data.order.orders.pickupDate.toString().substr(0, 10);
     
  //Assign date value to date textbox
  $('#pickupDate').val(formattedDate2);
  $('#referenceNumber').html(data.order.orders.referenceNumber);
  $('#printPrice_id').val(data.price.id);
  $('#price').val(data.price.price);
  $('#pageFrom').val(data.order.orders.files.pageFrom);
  $('#pageTo').val(data.order.orders.files.pageTo);
  $('#totalPages').val(data.order.orders.files.totalPages);
  $('#noOfCopy').val(data.order.orders.files.noOfCopy);
  $('#modeOfPayment').val(data.order.orders.modeOfPayment);
  $('#grandTotalPrice').val(data.order.orders.grandTotalPrice);
  $('#file').val(data.order.orders.files.filename);
  $('#remarks').val(data.order.orders.remarks);
  $('#order_id').val(data.order.order_id);
  $('#file_id').val(data.order.orders.files.id);

   
   
  (data.order.status == null)? $('#status').val(data.order.orders.status) :  $('#status').val(data.order.status);


 

  if(data.order.orders.status == "Cancelled"){
      // $("#updateTransactionSatusDiv").hide();
      // $("#footer").hide();
        var html = '';
        html += ' <label style="color:red" for="cancelledReason">Cancelled Reason</label>';
        html += ' <textarea class="form-control" id="cancelledReason" name="cancelledReason" style="background-color: white" readonly></textarea>';
        html += ' <small class="text-info">';
      $('#cancelledTextArea').append(html);
    }
     $('#cancelledReason').val(data.order.orders.cancelledReason);

  
  if(data.order.orders.feedback != null){
    console.log("sodsdasd");
      var htmls = '';
        htmls += ' <label  for="feedback">Feedback</label>';
        htmls += ' <textarea class="form-control" id="feedback" name="feedback" style="background-color: white" readonly></textarea>';
        htmls += ' <small class="text-info">';
      $('#feedbackTextArea').append(htmls);
    
  }
   $('#feedback').val(data.order.orders.feedback);
    console.log(htmls);


  if(data.order.orders.status === "Processed"){  
          $("#update, #pickupDate, #printPrice_id, #pageFrom, #pageTo, #noOfCopy, #modeOfPayment, #remarks").prop('disabled',false);
  }else{
          console.log("sod di proce");    
          $("#update, #pickupDate, #printPrice_id, #pageFrom, #pageTo, #noOfCopy, #modeOfPayment, #remarks ").prop('disabled',true);    
  }
    
   // open modal
  $("#viewModal").modal('toggle');
});

  // reset the append cancelled reason text area if the user close the modal
  $("#cancelledTextArea").empty();


}
//end get order info 

// start update  order
$('#viewOrderForm').on('submit',function(event){
    event.preventDefault();
    $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });   

    var formData = new FormData(this);
    console.log(formData);

    Swal.fire({
        title: 'Are you sure you want to update your order?',
        // text: "Once deleted, you will not be able to recover this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, update it!'
    }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
              url:"{{route('transactionUser.edit')}}",
              type:'POST',
              data: formData,
              cache:false,
              contentType: false,
              processData: false,
              success:function(data){
                Swal.fire({
                  icon: 'success',
                  title: 'Order Updated',
                  showConfirmButton: false,
                  timer: 1000
                }).then((result) => {
                    // Reload the Page
                     location.reload();
                    console.log(data);
                  
                });

                 $('#viewOrderForm').modal('toggle');
                $('#viewOrderForm')[0].reset();   

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
// end update  order 

function viewPDF(){
  event.preventDefault();
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });   

      var id = $('#id').val(); //get the id of order
     
      console.log(id , status);
      Swal.fire({
        title: 'Are you sure you want to view the file?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, accept it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url:"/viewOrder/"+id,
              type:'get',
              success:function(data){
              console.log(data);
                
                if($.isEmptyObject(data.error)){
                    // alert(data.success);
                        console.log("sod success");
                        $(".text-danger").hide();

                        Swal.fire({
                        icon: 'success',
                        title: 'Transaction status updated',
                        showConfirmButton: false,
                        timer: 1000
                        })
                        window.location.href = "{{url('/viewPDF')}}";  
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
}

function pay(valueId){
   
    $('#transaction_id').val(valueId);
    //   // open modal
    $("#payModal").modal('toggle');
}

//start pay order  via gcash  
$('#payGcashForm').on('submit',function(event){
 
  event.preventDefault();
      $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    }); 
  var formData = new FormData(this);

    console.log(formData);

    Swal.fire({
    title: 'Are you sure?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, add it!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({

            url:"{{route('orderUser.payGcash')}}",
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
                      title: 'Payment receipt is successfully submitted' ,
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
      Swal.fire('Payment  was not successful.')
      }

    });   


   

});
// end pay order  via gcash  


//start get order info 
function track(valueId){
  
 $.get('/getTrackOrder/'+valueId,function(data){  
  
  //  console.log(data);
 
  for(i=0;i<data.length;i++){
    
    //  var formattedDate =data[i].updated_at.toString().substr(0, 10);
    var formattedDate = moment(data[i].updated_at).format('MMM/DD/YYYY h:mm a');
    var html = '';
    html +='<div class="row">';
    html +='<div class="col-md-3">';
    html += '<h6>'+formattedDate+' </h6>';
    html +='</div>';
    html +='<div class="col-md-9">';
    html += '<h4>'+data[i].action+' </h4>';
    html +='</div>';
    html +='</div>';
    html += '<hr>';
    $('#trackInfo').append(html);
  }

    // open modal
  $("#trackModal").modal('show');
   
 });
 $("#trackInfo").empty();

}
//end get order info 


//start view gcash receipt uploaded
function viewReceipt(valueId){
   
   $('#receiptImage').empty();
   $.get('/viewReceiptUser/'+valueId,function(data){ 
   console.log(data);
 
   // <img src="{{ asset('/img/qrgcash.png') }}" id="qr"class="img-thumbnail rounded mx-auto d-block" alt="...">
   $("#refNumReceipt").text(data.refNumReceipt);    
   
      
     var html = '';
     if(data.receipt){
       html += ' <img src="gcash/'+data.receipt+'" id="qr"class="img-thumbnail rounded mx-auto d-block" alt="...">';
     }
     $('#receiptImage').append(html);       
     
     // open modal
     $("#viewReceiptModal").modal('show');
     });
 
 }
 //end view gcash receipt uploaded







//start view gcash receipt uploaded
function feedback(valueId){

  // open modal
    $("#feedbackModal").modal('toggle');

     $.get('/getMyOrder/'+valueId,function(data){     
        console.log(data);

         $('#trans_id').val(data.order.orders.id);
         $('#ref_num').val(data.order.orders.referenceNumber);
        console.log(data.order.orders.referenceNumber);

     });
  

}
//end view gcash receipt uploaded

//start update user
$('#feedbackForm').on('submit',function(event){
    event.preventDefault();
      $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        }); 
         var formData = new FormData(this);


         Swal.fire({
          title: 'Are you sure you want to send this feedback?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, send it!'
          }).then((result) => {
            if (result.isConfirmed) {
              $.ajax({
                  url:"{{route('transactionUser.feedback')}}",
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
                            title: 'feedback has been sent!' ,
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
            Swal.fire('Feedback was not send.')
            }
  
          });   
    

   

});
// end update user


</script>


<script>
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
  var price  = 0;
  var totalPrice =0;
  var finalPrice =0;
  var totalPrice =0;
  var totalPages =0;
  var noOfCopy =0;
// get price per paper
 $(document).on('input','.printPrice_id',function(){
  var paperPrice_id=$(this).val(); 
   


  $.get('/getPrintPrice/'+paperPrice_id,function(data){  

      $("#price").val(data.price);
      console.log("price:"+data.price);
       price = data.price;
       totalPages=$('#totalPages').val(); 
       noOfCopy=$('#noOfCopy').val();

      totalPrice = price * totalPages;
      finalPrice = totalPrice * noOfCopy
      console.log("finalprice:"+finalPrice);
      $("#grandTotalPrice").val(finalPrice);
    });

});  


// get range to be print
$(document).on('input','.pageTo, .pageFrom',function(){
  var pageFrom=$('#pageFrom').val(); 
  var pageTo=$('#pageTo').val(); 
  var totalPage = 0;

  for (var i = pageFrom; i <= pageTo; i++) {
    totalPage = totalPage + 1;
    }
   
    $("#totalPages").val(totalPage);
});

// get total price totalPages price
$(document).on('change','#noOfCopy, #pageFrom, #pageTo',function(){
  console.log("sod");
  price=$('#price').val(); 
  totalPages=$('#totalPages').val(); 
  noOfCopy=$('#noOfCopy').val();
  
  

  totalPrice = price * totalPages;
  finalPrice = totalPrice * noOfCopy
  console.log(finalPrice);
  $("#grandTotalPrice").val(finalPrice);
});


</script>

<script>
  //start cancel order 
function cancelOrder(valueId){
 
  event.preventDefault();
  $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });   

  swal.fire({
  title: 'Reason for cancelling the order',
  input: 'textarea',
  inputPlaceholder: 'Type your message here',
  showCancelButton: true
  }).then((result) => {

      if (result.isConfirmed) {
       
        var id = valueId;
        var reason = result.value;
        
        $.ajax({
          url:"{{route('orderUser.cancelOrderUser')}}",
          type:'POST',
          data: {id:id,reason:reason},
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

</script>
@endsection
