@extends('layouts.index')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 form">
           
        <div class="card">
            <div class="card-header text-center">
                <h2> User Settings </h2>
            </div>

            <div class="card-body">
                    <form id="userSettingsForm"  enctype="multipart/form-data">
                        @csrf
               
                        <div class="form-group row">
                            <label for="firstName" class="col-lg-4 col-form-label text-lg-right">{{ __('First Name') }}</label>

                            <div class="col-lg-6">
                                <input id="firstName" type="text" class="form-control @error('firstName') is-invalid @enderror" name="firstName" value="{{ $user->firstName}}" required  autofocus>
                                <span class="text-danger error-text firstName_err"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="lastName" class="col-lg-4 col-form-label text-lg-right">{{ __('Last Name') }}</label>

                            <div class="col-lg-6">
                                <input id="lastName" type="text" class="form-control @error('lastName') is-invalid @enderror" name="lastName" value="{{ $user->lastName }}" required  autofocus>
                                <span class="text-danger error-text lastName_err"></span>
                               
                            </div>
                        </div>

                        <!-- <div class="form-group row">
                            <label for="contact" class="col-lg-4 col-form-label text-lg-right">{{ __('Contact Number') }}</label>

                            <div class="col-lg-6">
                                <input id="contact" type="text" class="form-control @error('contact') is-invalid @enderror" name="contact" value="{{  $user->contact }}" required  autofocus>
                                <span class="text-danger error-text contact_err"></span>
                                
                            </div>
                        </div> -->

                        

                        <div class="form-group row">
                            <label for="current_password" class="col-lg-4 col-form-label text-lg-right">{{ __('Current Password') }}</label>

                            <div class="col-lg-6">
                                <input id="current_password" type="password" class="form-control @error('password') is-invalid @enderror"   name="current_password" required >
                                <span class="text-danger error-text current_password_err"></span>
                                   
                            </div>
                        </div>

                       

                        <div class="form-group row">
                            <label for="password" class="col-lg-4 col-form-label text-lg-right">{{ __('Password') }}</label>

                            <div class="col-lg-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"   name="password" required >
                                <span class="text-danger error-text password_err"></span>
                                
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password_confirmation" class="col-lg-4 col-form-label text-lg-right">{{ __('Confirm Password') }}</label>

                            <div class="col-lg-6">
                                <input id="password_confirmation" type="password" class="form-control"  name="password_confirmation" required>
                                <span class="text-danger error-text password_confirmation_err"></span>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-lg-6 offset-lg-4">
                                <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
          
         

        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script type="text/javascript">
//start add new product start
$('#userSettingsForm').on('submit',function(event){
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
          confirmButtonText: 'Yes, Update it!'
          }).then((result) => {
            if (result.isConfirmed) {
              $.ajax({
                  url:"{{route('users.edit')}}",
                  type:'post',
                  data: formData,
                  cache:false,
                  contentType: false,
                  processData: false,
                  success:function(data){
                        
                    if($.isEmptyObject(data.error)){
                        console.log(data.error)
                        console.log("sod success");
                        $(".text-danger").hide();
                        Swal.fire({
                            icon: 'success',
                            title: 'Your Information is successfully updated',
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
//end add new product end

// printing error message  for validation start
function printErrorMsg (msg) {
            console.log("sod message");
            console.log(msg);
            if(msg === "Current password does not match!"){
                $('.current_password_err').text(msg);
            }
            $.each( msg, function( key, value ) {
                console.log(key);
                $('.'+key+'_err').text(value);
            });
            
           
}
// printing error message end
</script>
@endsection
