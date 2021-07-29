{{-- @extends('layouts.app') --}}
@extends('layouts.index')

@section('content')

<div 
id="hero" 
class="px-2 pt-5 text-center border-bottom" 
style="
    background-image:url('{{ asset('/img/adamson.jpg') }}');
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-position: center;
    background-size: cover;
    height:60vh;
    margin-top:-24px;
">
    <div class="jumbotron d-flex align-items-center" style="background-color:transparent!important">
        <div class="container">
            <h1 class="display-1 text-white" style="letter-spacing: 10px;"><strong>F-PRINT</strong></h1>
            <div class="col-lg-8 mx-auto">
            <p class="lead text-white">Make your reservation anytime and get your printing needs done!</p>
            </div>
        </div>
    </div>
</div>


@endsection
