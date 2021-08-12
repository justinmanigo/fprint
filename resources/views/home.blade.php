{{-- @extends('layouts.app') --}}
@extends('layouts.index')

@section('content')

<div 
id="hero" 
class="px-2 pt-5 pb-4 text-center border-bottom" 
style="
    background-image:url('{{ asset('/img/adamson.jpg') }}');
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-position: center;
    background-size: cover;
    margin-top:-24px;">
    <div class="jumbotron d-flex align-items-center" style="background-color:transparent!important">
        <div class="container">
            <h1 class="display-1 text-white" style="letter-spacing: 10px;"><strong>F-PRINT</strong></h1>
            <div class="col-lg-8 mx-auto">
            <p class="lead text-white">Make your reservation anytime and get your printing needs done!</p>
            </div>
        </div>
    </div>
</div>

<div class="container my-5">
    <div class="row">
        <div class="col-lg-7 py-3 py-lg-5 order-1 order-lg-0">
            <h1 class="display-3 fw-bold lh-1">About Us</h1>
            <p class="lead">
                F-Print is a web-based printing system that were created by four people, Jenine Seminiano, Aileen Guingon, Gab Morales, and Renzo Valera. The name F-Print was made because with your reservation anytime, you can get your printing needs done.
            </p>
        </div>
        <div class="col-lg-5 p-0 order-0 order-lg-1">
            {{-- Insert picture here later :)) --}}
            <img src="{{ asset('img/fprint.png') }}" width="540" class="mx-auto my-0" style="display:block!important;">
            {{-- <img class="rounded-lg-3" src="bootstrap-docs.png" alt="" width="720"> --}}
        </div>
    </div>
</div>

@include('layouts.printingschedule')

@endsection
