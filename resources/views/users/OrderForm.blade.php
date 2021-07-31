@extends('layouts.index')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
            <div class="card-header text-center">
                <h2> Order Form </h2>
            </div>
            <div class="col-md-12">
            <div class="card-body">
                    <span class="anchor" id="formComplex"></span>
                    <!-- <hr class="my-5"> -->
                    <!-- form complex example -->

                <form id="orderFormTable"  enctype="multipart/form-data">
                    @csrf   
                     
                    <div class="form-row mt-4">
                        <!-- pick up date -->
                        <div class="col-sm-12 pb-3">
                            <label for="pickupDate">Pick up date:</label>
                         
                            <input type="date" class="form-control col-sm-6" id="pickupDate"  placeholder="Enter first name" name="pickupDate" required>
                            <span class="text-danger error-text pickupDate_err"></span>
                           
                        </div>
                        <!-- space -->
                        <div class="col-sm-12 pb-3">
                        <hr class="my-3">
                        <h4>File Details </h4>
                        </div>
                        <!-- size and isColored -->
                        <div class="col-sm-6 pb-3">
                            <label for="printPrice_id">Paper size:</label>
                                <select class="form-control printPrice_id" id="printPrice_id2" name="printPrice_id">
                                    <option disabled selected value> -- select an option -- </option>
                                    @if(isset($prices))
                                    @foreach ($prices as $price)
                                    @if ($price->isColored == "Yes")
                                    <option value="{{$price->id}}" >{{$price->size}} - Colored</option>
                                    @else
                                    <option value="{{$price->id}}" >{{$price->size}} - Black & White</option>
                                    @endif
                                    @endforeach
                                    @endif
                                </select>
                            <span class="text-danger error-text printPrice_id_err"></span>
                        </div>
                        <!-- <div class="col-sm-4 pb-3">
                            <label for="isColored">Type:</label><br>
                                <select class="form-control" id="isColored">
                                    <option value="Yes">Colored</option>
                                    <option value="No">Black & White</option>
                                </select>
                                <span class="text-danger error-text isColored_err"></span>
                        </div> -->

                        <div class="col-sm-6 pb-3">
                            <label for="price">Price per paper:</label><br>
                            <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">$</span></div>
                                    <input type="number" class="form-control price" id="price" placeholder="" name="price"  value="0" style= "background-color: white" readonly>
                                    <span class="text-danger error-text price_err"></span>
                            </div>
                        </div>                    

                        <div class="col-sm-5 pb-3">
                            <label for="pageFrom">Page from:</label>
                            <input type="number" class="form-control pageFrom" id="pageFrom" min="1" placeholder="Enter start page" name="pageFrom" required>
                            <span class="text-danger error-text pageFrom_err"></span>
                        </div>
                        <div class="col-sm-5 pb-3">
                            <label for="pageTo">Page to:</label>
                            <input type="number" class="form-control pageTo" id="pageTo" min="1" placeholder="Enter end page" name="pageTo" required>
                            <span class="text-danger error-text pageTo_err"></span>
                        </div>
                        <div class="col-sm-2 pb-3">
                            <label for="totalPages">Total pages:</label>
                            <input type="number" class="form-control totalPages" id="totalPages" placeholder="" name="totalPages"  style= "background-color: white" value="0" readonly>
                            <span class="text-danger error-text totalPages_err"></span>
                        </div>

                        <div class="col-sm-6 pb-3">
                            <label for="noOfCopy">Number of copies:</label>
                            <input type="number" class="form-control" id="noOfCopy" min="1" placeholder="Enter first name" name="noOfCopy" value="0" required>
                            <span class="text-danger error-text noOfCopy_err"></span>
                        </div>

                        

                        <div class="col-sm-6 pb-3">
                            <label for="grandTotalPrice">Total price:</label><br>
                            <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">$</span></div>
                                    <input type="number" class="form-control" id="grandTotalPrice" placeholder="" name="grandTotalPrice" value="0" required>
                                    <span class="text-danger error-text grandTotalPrice_err"></span>
                            </div>
                        </div>   


                        <div class="col-sm-6 pb-3">
                            <label for="modeOfPayment">Mode of payment:</label><br>
                                <select class="form-control" id="modeOfPayment" name="modeOfPayment">
                                    <option disabled selected value> -- select an option -- </option>
                                    <option value="COP">Cash on Pickup</option>
                                    <option value="Gcash">Gcash</option>
                                </select>
                            <span class="text-danger error-text modeOfPayment_err"></span>
                        </div>
                       
                        <div class="col-sm-6 pb-3">
                            <div class="form-row">
                                <label class="col-md col-form-label" for="file">Upload file</label>
                                <input type="file" class="form-control-file" name="file" id="file">
                                <span class="text-danger error-text file_err"></span>
                            </div>
                        </div>

                        
                       
                     

                            <!-- space -->
                            <div class="col-sm-12 pb-3">
                                <hr class="my-3">
                            </div>

                            <div class="col-md-12 pb-2 mt-2">
                                    <label for="remarks">Remarks</label>
                                    <textarea class="form-control" id="remarks" name="remarks"></textarea>
                                    <small class="text-info">
                                    Add the printing note here.
                                    </small>
                            </div>

                            <div class="col-sm-12 offset-5 pb-3 mt-3">
                               
                                <label class="form-check-label" for="TermsAndCondition">
                                <input class="form-check-input" type="checkbox" name="TermsAndCondition"  id="TermsAndCondition"  value="1" {{ old('TermsAndCondition') ? 'checked': null }}>
                                <a data-target="#myModal" data-toggle="modal" class="MainNavText" id="MainNavHelp" href="#myModal"> Terms and Agreement</a><br>
                                <span class="text-danger error-text TermsAndCondition_err"></span>
                                </label>
                            </div>
                    </div>

                 

                </div>
            </div>
            <!-- footer for buttons -->
            <div class="card-footer text-muted text-right">
            <button type="submit" class="btn btn-primary" >Submit</button>
            </div>
            </form>

        </div>
    </div>
</div>
<!-- end content -->

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" style="overflow-y: auto !important;">
  <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalScrollableTitle">Terms and Agreement</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h2>General Terms</h2>
        By accessing placing an order with, you confirm that you are in agreement with and bound by the terms of service contained in the Terms of Conditions outlined below. These terms apply to the entire website and any email or other type of communication between you and Falcon Printing Service.
        Under no circumstances shall team be liable for any direct, indirect, special, incidental, or consequential damages, including, but not limited to, loss of data or profit, arising out of the use, or the inability to use, the materials on this site, even if team or an authorized representative has been advised of the possibility of such damages. If you use of materials from this site results in the need for servicing, repair or correction of equipment or data, you assume any cost thereof.
        Will not be responsible for any outcome that may occur during the course of usage of our resources. We reserve the rights to change prices and revise the resources usage policy in any moment.
        
        <h2>Privacy Policy</h2>
        Falcon Printing Services. We are committed to protecting your privacy. This Privacy Policy explains how your personal information is collected, used, and disclosed by Falcon Printing Services.
        This Privacy Policy applies to our website, falconprint.com and its associated subdomains collectively . By accessing or using our service, you signify that you read, understood, and agree to our collection, storage, use, and disclosure of your personal information as described in this Privacy Policy.  
        
        <h2>Your Consent</h2>
        By using our service, registering an account, or making purchase, you consent to this Privacy Policy.

        <h2>Affiliates</h2>
        We may disclose information (including personal information) about you to our Corporate Affiliates. For purposes of this Privacy Policy, means any person or entity which directly or indirectly controls, is controlled by or is under common control with us, whether by ownership or otherwise. Any information relating to you that we provide to our Corporate Affiliate will be treated by those Corporate Affiliates in accordance with the terms of this Privacy Policy
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Accept</button>
       
      </div>
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script>

// get date today
var myDate = document.getElementById("pickupDate");
var today = new Date();
myDate.value = today.toISOString().substr(0, 10);
    
$(document).ready(function () {
     
 });

</script>

<!-- script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script type="text/javascript">

//start add new product start
$('#orderFormTable').on('submit',function(event){
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
                  url:"{{route('orderUser.store')}}",
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
                            title: 'Order Added. Your Order number is:' +data.referenceNumber ,
                            showConfirmButton: false,
                            timer: 2000
                            }).then((result) => {

                                window.location.href = "{{url('/myOrders')}}";

                            
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
//end add new product end


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
// get price per paper
 $(document).on('input','.printPrice_id',function(){
  var paperPrice_id=$(this).val(); 
   


  $.get('/getPrintPrice/'+paperPrice_id,function(data){  

      $("#price").val(data.price);
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
$(document).on('change','#noOfCopy, #pageFrom, #pageTo, #printPrice_id2',function(){
  var price=$('#price').val(); 
  var totalPages=$('#totalPages').val(); 
  var noOfCopy=$('#noOfCopy').val();
  var totalPrice = 0;
 

  totalPrice = price * totalPages;
  finalPrice = totalPrice * noOfCopy
    console.log(finalPrice);
    $("#grandTotalPrice").val(finalPrice);
});

 

</script>
<script>
 

</script>

@endsection
