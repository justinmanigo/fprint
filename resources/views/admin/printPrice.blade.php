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
                        <table id="priceTable" class="display nowrap" style="width:100%">
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
                                    <td>{{$price->price}}</td>
                                    
                                    <td>  
                                    <button onclick="getPriceInfo({{$price->id}})" type="button" class="btn btn-success" >update</button>
                                    <button onclick="deleteStaff({{$price->id}})" type="button" class="btn btn-outline-danger" >delete</button>
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

<!-- Add new print price Modal -->
<div class="modal fade" id="addprice" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div id="addModal2" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Paper Price</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="newPriceForm"  enctype="multipart/form-data">
        @csrf
            <div class="form-group">
            <label for="size">Paper Size</label>
            <input type="text" class="form-control" id="size" placeholder="Enter paper size" name="size" required>
            <span class="text-danger error-text size_err"></span>
            </div>

            <div class="form-group">
                <label for="isColored">Colored:</label><br>
                <label class="radio-inline">
                <input type="radio" name="isColored" value="Yes" checked>Colored
                </label> &nbsp;
                <label class="radio-inline">
                <input type="radio" name="isColored" value="No">Black & White
                </label>
                <span class="text-danger error-text isColored_err"></span>
            </div>


            <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" class="form-control" id="price" placeholder="Enter price" name="price" required>
            <span class="text-danger error-text price_err"></span>
            </div>


           <!-- token -->
           <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}"> 
         
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
                                // $("#productsTable tbody").append('<tr id=pid'+data.id+'>'+ 
                                // '<td>'+ data.id + '</td>' + 
                                // '<td>'+ data.name + '</td>' + 
                                // '<td>'+ data.quantity + '</td>' +
                                // '<td>'+ data.branch_id + '</td>' +
                                // '<td scope="row">'+ 
                                // ' <button  type="button" class="item" data-toggle="tooltip" data-placement="top" title="Edit"> </button>' +
                                // '</td>'+
                                // '</tr>');
                                
                                // $("#newProductForm")[0].reset();
                                // $("#addModal2").modal('hide'); 
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
            Swal.fire('Staff was not added.')
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

@endsection
