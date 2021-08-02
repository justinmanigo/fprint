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
                                    <h2>Manage <b>Paper Price</b></h2>
                                </div>
                                <div class="col-xs-7 col-md-12">
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addprice">Add Price</button>
                                </div>
                            </div>
                        </div>
                        <table id="priceTable" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Price ID</th>
                                    <th>Paper size</th>
                                    <th>Type</th>
                                    <th>Price</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                              @foreach ($prices as $price)
                                  <tr id="pid{{$price->id}}">
                                      <td>{{$price->id}}</td>
                                      <td>{{$price->size}}</td>
                                      <td>{{$price->isColored}}</td>
                                      <td>₱{{number_format($price->price, 2, '.', ',')}}</td> 
                                      <td>  
                                      <button onclick="getPriceInfo({{$price->id}})" type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="View Price"><i class="fa fa-eye"></i></button>
                                      <button onclick="deletePrintPrice({{$price->id}})" type="button" class="btn btn-outline-danger">delete</button>
                                      </td>
                                  </tr>
                              @endforeach 
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Price ID</th>
                                    <th>Paper size</th>
                                    <th>Type</th>
                                    <th>Price</th>
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                        </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- start edit print price Modal -->
<div class="modal fade" id="getPriceInfo" tabindex="-1" aria-labelledby="getPriceInfoLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div id="addModal2" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="getPriceInfoLabel">Edit Paper Price</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="editPrintPriceForm"  enctype="multipart/form-data">
        @csrf
          <div class="modal-body">
                <!-- paper size -->
                <div class="form-group">
                <label for="edit_size">Paper Size</label>
                <input type="text" class="form-control" id="edit_size" placeholder="Enter paper edit_size" name="edit_size" required>
                <span class="text-danger error-text size_err"></span>
                </div>
               
                <div class="form-group">
                    <label for="edit_isColored">Paper type:</label><br>
                    <select class="form-control" id="edit_isColored" name="edit_isColored">
                        <option disabled selected value> -- select an option -- </option>
                        <option value="Yes">Colored</option>
                        <option value="No">Black & White</option>
                    </select>
                    <span class="text-danger error-text modeOfPayment_err"></span>
                </div>

                <!-- price -->
                <div class="form-group">
                <label for="edit_price">Price:</label>
                <input type="number" class="form-control" id="edit_price" placeholder="Enter edit_price" name="edit_price" required>
                <span class="text-danger error-text price_err"></span>
                </div>

              <!-- token -->
              <input type="hidden" name="edit_token" id="edit_token" value="{{ csrf_token() }}"> 

              <!-- token -->
              <input type="hidden" name="id" id="id" value=""> 
            
          </div>  <!-- end modal body -->
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
      </form>  
    </div>
  </div>
</div>
<!-- end edit print price Modal -->

<!-- Add new print price Modal -->
<div class="modal fade" id="addprice" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div id="addModal2" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Paper Price</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="newPriceForm"  enctype="multipart/form-data">
        @csrf
          <div class="modal-body">
                <!-- paper size -->
                <div class="form-group">
                <label for="size">Paper Size</label>
                <input type="text" class="form-control" id="size" placeholder="Enter paper size" name="size" required>
                <span class="text-danger error-text size_err"></span>
                </div>

                <div class="form-group">
                    <label for="isColored">Paper type:</label><br>
                    <select class="form-control" id="isColored" name="isColored">
                        <option disabled selected value> -- select an option -- </option>
                        <option value="Yes">Colored</option>
                        <option value="No">Black & White</option>
                    </select>
                    <span class="text-danger error-text modeOfPayment_err"></span>
                </div>

                <!-- price -->
                <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" class="form-control" id="price" placeholder="Enter price" name="price" required>
                <span class="text-danger error-text price_err"></span>
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
<!-- end add new Print price modal -->

 

<!-- script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script type="text/javascript">

//start add new product start
$('#newPriceForm').on('submit',function(event){ 
     event.preventDefault();
      $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      }); 
    
      var formData = new FormData(this);

      Swal.fire({
      title: 'Are you sure do you want to add?',
      // text: "Once deleted, you will not be able to recover this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, add it!'
      }).then((result) => {
          if (result.isConfirmed) {
              $.ajax({

                  url:"{{route('printPrice.store')}}",
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
                        title: 'Staff Added',
                        showConfirmButton: false,
                        timer: 1000
                      }).then((result) => {
                          // Reload the Page
                          location.reload();
                          // hide modal
                          $("#addprice").modal('hide'); 
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
            } 
  
          });   

});
//end add new product end
 


//start editPrintPriceForm
$('#editPrintPriceForm').on('submit',function(event){ 

  event.preventDefault();
      $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
  }); 
    
  var formData = new FormData(this);
  Swal.fire({
      title: 'Are you sure do you want to add?',
      // text: "Once deleted, you will not be able to recover this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, add it!'
      }).then((result) => {
          if (result.isConfirmed) {
              $.ajax({

                  url:"{{route('printPrice.editPrice')}}",
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
                        title: 'Staff Added',
                        showConfirmButton: false,
                        timer: 1000
                      }).then((result) => {
                          // Reload the Page
                          location.reload();
                          // hide modal
                          $("#addprice").modal('hide'); 
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
            } 
  
      }); 


});
//end editPrintPriceForm

//start get user info 
 
function getPriceInfo(valueId){
    $("#editPrintPriceForm").trigger("reset");
    $.get('/getPrintPriceInfo/'+valueId,function(data){   

        console.log(data);
        $('#edit_size').val(data.size);
        $('#edit_isColored').val(data.isColored);
        $('#edit_price').val(data.price);
        $('#id').val(data.id);

    });
   
    // open modal
    $("#getPriceInfo").modal('toggle');

}
// end get user info


// delete product start
function deletePrintPrice(valueId){
 
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
             url:"/printPriceDelete/"+id,
             type:'DELETE',
             data:{
               _token: $("input[name=_token]").val()
             },
             success:function(data) {
           //   remove datatooltip in UI
              location.reload();
            //  $("#pid"+id).remove();
             Swal.fire({
             icon: 'success',
             title: 'Print price deleted',
             showConfirmButton: false,
             timer: 2500
           })
       
           }, error: function(data) {
             alert("wa sod");
             }
       });
   } 
 });

}
// delete product end




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
