{{-- @extends('layouts.app') --}}
@extends('layouts.index')

@section('content')
<div id="hero" class="px-2 pt-5 pb-4 text-center border-bottom">
    <div class="jumbotron d-flex align-items-center" style="background-color:transparent!important">
        <div class="container">
            <h1 class="display-1 text-white" style="letter-spacing: 10px;"><strong>F-PRINT</strong></h1>
            <div class="col-lg-8 mx-auto">
            <p class="lead text-white">Make your reservation anytime and get your printing needs done!</p>
            </div>
        </div>
    </div>
</div>

<div id="about_us" class="container-fluid my-5">
    <div class="row justify-content-center">
        <div class="col-lg-4 py-3 py-lg-5 order-1 order-lg-0">
            <h1 class="display-3 fw-bold lh-1">About Us</h1>
            <p class="lead">
                F-Print is a web-based printing system that were created by four people, Jenine Seminiano, Aileen Guingon, Gab Morales, and Renzo Valera. The name F-Print was made because with your reservation anytime, you can get your printing needs done.
            </p>
        </div>
        <div class="col-lg-4 p-0 order-0 order-lg-1">
            {{-- Insert picture here later :)) --}}
            <img src="{{ asset('img/fprint.png') }}" width="540" class="mx-auto my-0" style="display:block!important;">
            {{-- <img class="rounded-lg-3" src="bootstrap-docs.png" alt="" width="720"> --}}
        </div>
    </div>
</div>
<hr>

<div id="printing_schedule" class="container my-5">
    <div id="printing_schedule_card" class="row p-4 pb-0 pe-lg-0 pt-lg-5 align-items-center rounded-3 border shadow-lg">
        <div id="printing_schedule_text" class="col-lg-7 p-3 p-lg-5 pt-lg-3">
            <h1 class="display-3 fw-bold lh-1">Printing Schedule</h1>
            <p class="lead">
                Monday to Friday<br>
                8:00 am - 4:00 pm
            </p>

            <div class="d-grid gap-2 d-md-flex justify-content-md-start mb-4 mb-lg-3">
            <a href="{{ route('register') }}" role="button" class="btn btn-light btn-lg px-4 me-md-2 fw-bold">Start Reserving Yours Now</a>
            </div>
        </div>
        <div class="col-lg-4 offset-lg-1 p-0 overflow-hidden shadow-lg">
            {{-- Insert picture here later :)) --}}
            {{-- <img class="rounded-lg-3" src="bootstrap-docs.png" alt="" width="720"> --}}
        </div>
    </div>
</div>
<hr>
<div id="steps" class="container my-5">
     
</div>

<!-- @include('layouts.printingschedule') -->

@endsection
