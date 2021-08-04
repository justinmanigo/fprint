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
                                     <td>{{$transaction->orders->pickupDate}}</td>
                                     <td>{{$transaction->orders->files->filename}}</td>
                                     <td>{{$transaction->orders->modeOfPayment}}</td>
                                     <td>{{$transaction->isPaid}}</td>
                                     <td>₱{{number_format($transaction->orders->grandTotalPrice, 2, '.', ',')}}</td> 
                                     @if ($transaction->status == "")
                                     <td>{{$transaction->orders->status}}</td>
                                      @else
                                      <td>{{$transaction->status}}</td>
                                      @endif

                                     

                                       
                                    
                                     
                                    <td>  
                                     
                                    <a href="{{url('/viewOrder',$transaction->id)}}" type="button" class="btn btn-outline-dark" data-toggle="tooltip" data-placement="top" title="View File Uploaded" target="_blank" rel="noopener noreferrer"><span class="fa fa-print"></span></a>
                                    <button onclick="getOrderInfo({{$transaction->id}})" type="button" class="btn btn-outline-primary" data-toggle="tooltip" data-placement="top" title="View Order Form"> <i class="fa fa-eye"></i></button>
                                    @if ($transaction->orders->modeOfPayment == "Gcash" && $transaction->orders->status == "Confirmed" &&  $transaction->isPaid == "Not paid")
                                    <button onclick="pay({{$transaction->id}})" id="payButton" type="button" class="btn btn-outline-success" ><i class="fa fa-credit-card"></i></button>
                                    @endif
                                    <button onclick="track({{$transaction->id}})"  type="button" class="btn btn-primary" data-toggle="modal"> Track</button>
                                  </td>
                               
                                </tr>
                            @endforeach 
                            
                            </tbody>
                            <tfoot>
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
                            </tfoot>
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
                          <input type="date" class="form-control col-sm-6" id="pickupDate"  placeholder="Enter first name" name="pickupDate" style="background-color:white" readonly>
                          <span class="text-danger error-text pickupDate_err"></span>
                      </div>
                      <!-- space -->
                      <div class="col-sm-12 pb-3">
                          <hr class="my-3">
                          <h3>File Details </h3>
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
                          <input type="number" class="form-control pageFrom" id="pageFrom" min="1" placeholder="Enter start page" name="pageFrom" style="background-color:white" readonly>
                          <span class="text-danger error-text pageFrom_err"></span>
                      </div>
                      <!-- page to -->
                      <div class="col-sm-5 pb-3">
                          <label for="pageTo">Page to:</label>
                          <input type="number" class="form-control pageTo" id="pageTo" min="1" placeholder="Enter end page" name="pageTo" style="background-color:white" readonly>
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
                      <!-- MOP -->
                      <div class="col-sm-6 pb-3">
                          <label for="modeOfPayment">Mode of payment:</label><br>
                          <input type="text" class="form-control price" id="modeOfPayment" placeholder="" name="modeOfPayment"  value="" style= "background-color: white" readonly>
                          <span class="text-danger error-text modeOfPayment_err"></span>
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
                       <!-- total price -->
                       <div class="col-sm-6 pb-3">
                          <label for="status">Satus:</label><br>
                                  <input type="text" class="form-control status" id="status" placeholder="" name="status"  value="" style= "background-color: white" readonly>
                                  <span class="text-danger error-text status_err"></span>
                      </div>   
                      <!-- upload file -->
                      <div class="col-sm-6 pb-3">
                          <div class="form-row">
                              <label class="col-md col-form-label" for="file">File</label>
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
                              <textarea class="form-control" id="remarks" name="remarks" style= "background-color: white" readonly></textarea>
                              {{-- <small class="text-info">
                              Add the packaging note here.
                              </small> --}}
                      </div>
                        <!-- token -->
                        <input type="hidden" name="e_token" id="e_token" value="{{ csrf_token() }}">

                         <!-- token -->
                         <input type="hidden" class="form-control status" id="id" placeholder="" name="id"  value="" style= "background-color: white" readonly>
                            
                    </div>

                    <!-- footer -->
                    <div class="modal-footer" id="footer">
                        <button  id="update" type="submit" class="btn btn-success"><span class="glyphicon glyphicon-search" aria-hidden="true"></span>Update</button>
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
                                  <div class="col-sm-12  pb-3">
                                        <h5>Submit your receipt</h5>
                                        <label for="receipt">Upload Screenshot of Receipt</label>
                                        <input type="file" class="form-control-file" name="receipt" id="receipt">
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


      <div id="trackInfo"></dib>

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
<script type="text/javascript">
 
//start get order info 
function getOrderInfo(valueId){

$.get('/getMyOrder/'+valueId,function(data){  
  
  console.log(data);
    //Get the data value
    var yourDateValue = new Date(data.order.orders.pickupDate); 
    //Format the date value
    var formattedDate = yourDateValue.toISOString().substr(0, 10)
    //Assign date value to date textbox
    $('#pickupDate').val(formattedDate);
  $('#referenceNumber').html(data.order.orders.referenceNumber);
  $('#price').val(data.price.price);
  $('#pageFrom').val(data.order.orders.files.pageFrom);
  $('#pageTo').val(data.order.orders.files.pageTo);
  $('#totalPages').val(data.order.orders.files.totalPages);
  $('#noOfCopy').val(data.order.orders.files.noOfCopy);
  $('#modeOfPayment').val(data.order.orders.modeOfPayment);
  $('#grandTotalPrice').val(data.order.orders.grandTotalPrice);
  $('#status').val(data.order.orders.status);
  $('#file').val(data.order.orders.files.filename);
  $('#remarks').val(data.order.orders.remarks);
  $('#id').val(data.order.order_id);
  if(data.price.isColored === "Yes"){
    var type = "Colored";
  }else{
    var type = "Black & White";
  } 
  var size = data.price.size +"-"+type;
  $('#praperSize').val(size);
  
 

  if(data.order.orders.status === "Processed"){  
        var html = '';   
        // $("#update").show();
        $("#update").hide();
    }else{
      $("#update").hide();
    }


    // var html = '';
    // html += ' <button onclick="viewPDF({{'data.order.order_id'}})" type="button" class="btn btn-success">Update</button>';
    // $('#viewPDF').append(html);
    
   // open modal
  $("#viewModal").modal('toggle');
});

}
//end get order info 

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
                        // location.reload();
                        
                        // $('#viewModal').modal('toggle');
                        //  $('#viewModal')[0].reset();   
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
    // text: "Once deleted, you will not be able to recover this!",
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
      Swal.fire('Payment  was not successful.')
      }

    });   


   

});
// end pay order  via gcash  


//start get order info 
function track(valueId){
  
 $.get('/getTrackOrder/'+valueId,function(data){  
  
   console.log(data);
 
  for(i=0;i<data.length;i++){
 
    var html = '';
    html += '<h4>'+data[i].action+' </h4>';
    html += '<h6>'+data[i].updated_at+' </h6>';
    html += '<hr>';
    $('#trackInfo').append(html);
  }

    // open modal
  $("#trackModal").modal('show');
   
 });
 $("#trackInfo").empty();

}
//end get order info 


</script>
<!-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/jquery-ui.min.js"></script> -->

<script>
  // A $( document ).ready() block.
$( document ).ready(function() {
  
  // $("#payButton").hide();

    console.log( "ready!" );
});

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
