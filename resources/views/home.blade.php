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
            {{-- <div class="d-grid gap-2 d-sm-flex justify-content-sm-center mb-5">
                <button type="button" class="btn btn-primary btn-lg px-4 me-sm-3 mr-3">Primary button</button>
                <button type="button" class="btn btn-secondary btn-lg px-4">Secondary</button>
            </div> --}}
            </div>
            {{-- <div class="overflow-hidden" style="max-height: 30vh;">
            <div class="container px-5">
                <img src="bootstrap-docs.png" class="img-fluid border rounded-3 shadow-lg mb-4" alt="Example image" width="700" height="500" loading="lazy">
            </div>
            </div> --}}
        </div>
    </div>

</div>
{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __(' User Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div> --}}
@endsection
