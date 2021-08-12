@extends('layouts.index')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="firstName" class="col-lg-4 col-form-label text-lg-right">{{ __('First Name') }}</label>

                            <div class="col-lg-6">
                                <input id="firstName" type="text" class="form-control @error('firstName') is-invalid @enderror" name="firstName" value="{{ old('firstName') }}" required  autofocus>

                                @error('firstName')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="lastName" class="col-lg-4 col-form-label text-lg-right">{{ __('Last Name') }}</label>

                            <div class="col-lg-6">
                                <input id="lastName" type="text" class="form-control @error('lastName') is-invalid @enderror" name="lastName" value="{{ old('lastName') }}" required  autofocus>

                                @error('fistName')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-lg-4 col-form-label text-lg-right">{{ __('Adamson E-Mail') }}</label>

                            <div class="col-lg-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"  name="email" required  pattern="[a-z0-9._%+-]+@adamson.edu.ph" title="Invalid Email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="idNumber" class="col-lg-4 col-form-label text-lg-right">{{ __('ID Number') }}</label>

                            <div class="col-lg-6">
                                <input id="idNumber" type="text" class="form-control @error('idNumber') is-invalid @enderror" name="idNumber" value="{{ old('idNumber') }}" required  autofocus>

                                @error('idNumber')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="contact" class="col-lg-4 col-form-label text-lg-right">{{ __('Contact Number') }}</label>

                            <div class="col-lg-6">
                                <input id="contact" type="text" class="form-control @error('contact') is-invalid @enderror" name="contact" value="{{ old('contact') }}" required  autofocus>

                                @error('contact')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                       

                        <div class="form-group row">
                            <label for="password" class="col-lg-4 col-form-label text-lg-right">{{ __('Password') }}</label>

                            <div class="col-lg-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required >

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-lg-4 col-form-label text-lg-right">{{ __('Confirm Password') }}</label>

                            <div class="col-lg-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-lg-6 offset-lg-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('#app').attr("style", 
        "background-image:url('{{ asset('/img/backround.png') }}');background-repeat: no-repeat;background-attachment: fixed;background-position: center;background-size: cover;")
    });
</script>
@endsection
