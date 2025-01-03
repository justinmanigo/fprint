{{-- @extends('layouts.app') --}}
@extends('layouts.index')

@section('content')

<div 
id="hero" class="px-2 pt-5 pb-4 text-center border-bottom">

    <div class="jumbotron d-flex align-items-center" style="background-color:transparent!important">
        <div class="container">
            <h1 id="font2" class="display-1 text-white" style="letter-spacing: 10px;"><strong>F-PRINT</strong></h1>
            <div class="col-lg-8 mx-auto">
            <p  id="font1" class="lead text-white">Make your reservation anytime and get your printing needs done!</p>
            </div>
        </div>
    </div>
</div>
<img id="hero-border" src="{{ asset('img/background-with-border.png') }}">;
<!-- news -->
 
<div id="about_us" class="container my-5">
    <div class="row">
    
        <div id="font1" class="col-lg-12 py-3 py-lg-5 order-1 order-lg-0">
        <h2 class="display-4 fw-bold lh-1">Announcements</h2>
      
        @foreach ($announcements as $announcement)   
        <div class="card announcment_card">
                <div class="card-body">
                     <h4 class="display-7 fw-regular lh-1">{{$announcement->title}} - {{date('d-m-Y', strtotime($announcement->updated_at))}}</h4>
                    <p class="lead">{{$announcement->description}}  </p>
                </div>
        </div>
        
        @endforeach 

        @empty($announcement)

            <div class="card announcment_card">
                    <div class="card-body">
                        <h4 class="display-7 fw-regular lh-1">No further announcement.</h4>
                        <!-- <p class="lead"> </p> -->
                    </div>
            </div>
        @endempty
             
        </div>
    </div>
</div><hr>

 
 


<div id="about_us" class="container my-5">
    <div class="row">
        <div id="font1" class="col-lg-7 py-3 py-lg-5 order-1 order-lg-0">
            <h2 class="display-4 fw-bold lh-1">About Us</h2>
            <p class="lead">
                F-Print is a web-based printing system that were created by four people, Jenine Seminiano, Aileen Guingon, Gab Morales, and Renzo Valera. The name F-Print was made because with your reservation anytime, you can get your printing needs done.
            </p>
        </div>
        <div class="col-lg-5  p-0 order-0 order-lg-1">
            {{-- Insert picture here later :)) --}}
            <img src="{{ asset('img/fprint.png') }}" width="540" class="mx-auto my-0" style="display:block!important;">
            {{-- <img class="rounded-lg-3" src="bootstrap-docs.png" alt="" width="720"> --}}
        </div>
    </div>
</div><hr>
<div id="steps" class="container my-0 py-0">
 
</div>
<div id="steps_container" class="container my-5">
    <h2 id="font1" class="text-center display-4">Steps on How to Print with F-Print</h2>
    <div class="row justify-content-center text-center pt-4">
        <div class="col-lg-2 col-md-4 col-sm-6">
            <img src="{{ asset('img/steps/1.png') }}" class="mb-3">
            <h5>1. Print Form</h5>
            <p><i>Kindly fill out the print form</i></p>
        </div>
        <!---------

        
        <div class="col-lg-2 col-md-4 col-sm-6">
            <img src="{{ asset('img/steps/2.png') }}" class="mb-3">
            <h5>2. Order Process</h5>
            <p><i>The payment amount and the referential number will be shown</i></p>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
            <img src="{{ asset('img/steps/3.png') }}" class="mb-3">
            <h5>3. Payment</h5>
            <p><i>Selecting a payment method (GCash / Cash on Pickup)</i></p>
        </div>
        ---->
        <div class="col-lg-2 col-md-4 col-sm-6">
            <img src="{{ asset('img/steps/4.png') }}" class="mb-3">
            <h5>2. Order Completed</h5>
            <p><i>Once submitted, the order request will be sent to the printing station</i></p>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
            <img src="{{ asset('img/steps/5.png') }}" class="mb-3">
            <h5>3. Track Order</h5>
            <p><i>View and track the status of your order</i></p>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
            <img src="{{ asset('img/steps/6.png') }}" class="mb-3">
            <h5>4. Ready for Pick-Up</h5>
            <p><i>Order is ready for pick-up and payment over-the-counter (for Cash on Pick-up)</i></p>
        </div>
    </div>
</div>
<hr>
@include('layouts.printingschedule')
<hr>
@include('layouts.FAQs')
@endsection
