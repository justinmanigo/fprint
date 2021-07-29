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
                            <div class="col-xs-7 col-md-12">
                                <!-- <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addModal">New Order</button> -->
                            </div>
                      </div>
                    </div>
                        <table id="myOrderTable" class="display nowrap" style="width:100%">
                            <thead>
                                <tr>
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
                                      <td>{{$transaction->orders->referenceNumber}}</td>
                                      <td>{{$transaction->orders->pickupDate}}</td>
                                      <td>{{$transaction->orders->files->filename}}</td>
                                      <td>{{$transaction->orders->modeOfPayment}}</td>
                                      <td>{{$transaction->isPaid}}</td>
                                      <td>{{$transaction->orders->grandTotalPrice}}</td>
                                      @if(empty($transaction->status)){
                                        <td>{{$transaction->orders->status}}</td>
                                      }@else{
                                        <td>{{$transaction->status}}</td>
                                      }
                                       @endif
                                      <td>  
                                      <a href="{{url('/viewOrder',$transaction->order_id)}}" type="button" class="btn btn-outline-secondary">File</a>
                                        <button onclick="getOrderInfo({{$transaction->id}})" type="button" class="btn btn-outline-success" >view</button>
                                    </td>
                                  </tr>
                                @endif
                              @endforeach 
                            </tbody>
                            <tfoot>
                                <tr>
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
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                              <input type="date" class="form-control col-sm-6" id="pickupDate"  placeholder="Enter first name" name="pickupDate">
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
                                  <div class="input-group-prepend"><span class="input-group-text">$</span></div>
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
                                      <div class="input-group-prepend"><span class="input-group-text">$</span></div>
                                      <input type="text" class="form-control grandTotalPrice" id="grandTotalPrice" placeholder="" name="grandTotalPrice"  value="" style= "background-color: white" readonly>
                                      <span class="text-danger error-text grandTotalPrice_err"></span>
                              </div>
                          </div>   
                          <!-- total price -->
                          <div class="col-sm-6 pb-3">
                              <label for="status">Order satus:</label><br>
                                      <input type="text" class="form-control status" id="status" placeholder="" name="status"  value="" style= "background-color: white" readonly>
                                      <span class="text-danger error-text status_err"></span>
                          </div>   
                          <!-- upload file -->
                          <div class="col-sm-6 pb-3">
                              <div class="form-row">
                                  <label class="col-md col-form-label" for="file">File</label>
                                  <input type="text" class="form-control file" id="file" placeholder="" name="file"  value="" style= "background-color: white" readonly>
                                  <!-- <object data="http://www.africau.edu/images/default/sample.pdf" type="application/pdf" width="100%" height="100%"> -->
                                  <!-- <input type="file" class="form-control-file" name="file" id="file">
                                  <span class="text-danger error-text file_err"></span> -->
                              </div>
                          </div>

                          <!-- Remarks -->
                          <div class="col-md-12 pb-2 mt-2">
                                  <label for="remarks">Remarks</label>
                                  <textarea class="form-control" id="remarks" name="remarks" style= "background-color: white" readonly></textarea>
                                  <small class="text-info">
                                  <!-- Add the packaging note here. -->
                                  </small>
                          </div>

                          <!--isPaid -->
                          <div class="col-sm-6  pb-3 mt-2">
                                <label for="isPaid">Transaction Payment</label>
                                <input type="text" class="form-control isPaid" id="isPaid" placeholder="" name="isPaid"  value="" style= "background-color: white" readonly>
                          </div>

                          <!-- transaction status file -->
                          <div class="col-sm-6 pb-3 mt-2">
                                <label  for="transactionStatus">Transaction Status</label>
                                <input type="text" class="form-control transactionStatus" id="transactionStatus" placeholder="" name="transactionStatus"  value="" style= "background-color: white" readonly>
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
                          <div class="col-sm-6 pb-3">
                              <label for="updateTransactionStatus">Update order transaction status:</label><br>
                                  <select class="form-control updateTransactionStatus" id="updateTransactionStatus" name="updateTransactionStatus">
                                      <option disabled selected value> -- select an option -- </option>
                                      <option value="Printing in process">Printing in process</option>
                                      <option value="Ready for pick up">Ready for pick up"</option>
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



<!-- start pay order Modal -->
<div class="modal fade" id="payModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div id="addModal2" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Pay order via Gcash</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="payOrderForm"  enctype="multipart/form-data">
        @csrf 
          <!-- div modals body -->
          <div class="modal-body">
              
                <div class="form-row mt-4">
                      <!-- pick up date -->
                      <div class="col-12">
                      <h4>Gcash Account Number: 09983128845</h4>
                      <h4>QR Code:</h4>
                      
                      <img src="{{ asset('/img/gcash3.jpg') }}" id="qr"class="img-thumbnail rounded mx-auto d-block" alt="...">
                      </div>

                      <!-- space -->
                      <div class="col-sm-12 pb-3">
                          <hr class="my-3">
                      </div>
                      
                      <div class="col-12">
                          <div class="form-row">
                              <label class="col-md col-form-label" for="receipt">Upload Screenshot of Receipt</label>
                              <input type="file" class="form-control-file" name="receipt" id="receipt">
                              <span class="text-danger error-text receipt_err"></span>
                          </div>
                      </div>
                </div> <!-- div end body -->  
            </div>
        <!-- footer -->
        <div class="modal-footer" id="footer">
            <button  type="submit" class="btn btn-success">Submit</button>
        </div>
                 
    </form>      
       
    </div>
  </div>
</div>
<!-- end pay order modal -->
<script type="text/javascript">
 
//start get order info 
function getOrderInfo(valueId){

  $.get('/getMyOrderAdmin/'+valueId,function(data){   
  
    console.log(data);
    //Get the data value
    var yourDateValue = new Date(data.transaction.orders.pickupDate); 
    //Format the date value
    var formattedDate = yourDateValue.toISOString().substr(0, 10)
    //Assign date value to date textbox
    $('#pickupDate').val(formattedDate);
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
    if(data.price.isColored === "Yes"){
      var type = "Colored";
    }else{
      var type = "Black & White";
    } 
    var size = data.price.size +"-"+type;
    $('#praperSize').val(size);
  
   

    if(data.transaction.orders.status === "Confirmed"){  
          var html = '';
          // html += ' <button type="button" class="btn btn-outline-danger">Cancelled</button>';
          // html += ' <button   type="submit" class="btn btn-success">Update</button>';
          
          $("#update").show();
      // $('#footer').append(html);
      }else{

        $("#update").hide();
      }
      // Delivered Ready for pick up Printing in process
      $(".updateTransactionStatus option").filter(function() {
        return $(this).data().number === 0
      }).prop("disabled", false)


      console.log(data.transaction.status);
      if($("#transactionStatus").val() === "Printing in process"){
        $('#updateTransactionStatus option[value="Printing in process"]').attr('disabled',true);
        $('#updateTransactionStatus option[value="Ready for pick up"]').attr('disabled',false);
        $('#updateTransactionStatus option[value="Delivered"]').attr('disabled',false);
      }else if($("#transactionStatus").val() === "Ready for pick up"){
        $('#updateTransactionStatus option[value="Printing in process"]').attr('disabled',true);
        $('#updateTransactionStatus option[value="Ready for pick up"]').attr('disabled',true);
        $('#updateTransactionStatus option[value="Delivered"]').attr('disabled',false);
      }else if($("#transactionStatus").val() === "Delivered"){
        $('#updateTransactionStatus option[value="Printing in process"]').attr('disabled',true);
        $('#updateTransactionStatus option[value="Ready for pick up"]').attr('disabled',true);
        $('#updateTransactionStatus option[value="Delivered"]').attr('disabled',true);
      }else{
        $('#updateTransactionStatus option[value="Printing in process"]').attr('disabled',false);
        $('#updateTransactionStatus option[value="Ready for pick up"]').attr('disabled',false);
        $('#updateTransactionStatus option[value="Delivered"]').attr('disabled',false);
      }

    
   // open modal
  $("#viewModal").modal('toggle');
});

}
//end get order info 

// function pay(valueId){
//     //   // open modal
//     $("#payModal").modal('toggle');
// }

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
                    // alert(data.success);
                        console.log("sod success");
                        $(".text-danger").hide();

                        Swal.fire({
                        icon: 'success',
                        title: 'Transaction status updated',
                        showConfirmButton: false,
                        timer: 1000
                        })
                       
                        // location.reload();
                        
                        $('#viewModal').modal('toggle');
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

   

});
// end accept order


</script>
 

 
@endsection
