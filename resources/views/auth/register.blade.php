@extends('layouts.index')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 form">
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
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"  name="email" required  title="Invalid Email">

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

                        <!-- <div class="form-group row">
                            <label for="contact" class="col-lg-4 col-form-label text-lg-right">{{ __('Contact Number') }}</label>

                            <div class="col-lg-6">
                                <input id="contact" type="text" class="form-control @error('contact') is-invalid @enderror" name="contact" value="{{ old('contact') }}" required  autofocus>

                                @error('contact')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> -->

                        
                         <div class="form-group row">
                            <label for="contact" class="col-lg-4 col-form-label text-lg-right">{{ __('Occupation') }}</label>

                            <div class="col-lg-6">
                                 
                                <select class="form-control @error('contact') is-invalid @enderror" id="occupation" name="occupation">
                                    <option disabled selected value> -- select an option -- </option>
                                    <option value="student"> Student </option>
                                    <option value="professor"> Professor </option>
                                    <option value="employee"> Employee </option>
                                </select>
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

                        <div class="form-group row">
                               
                                <label class="col-lg-4 col-form-label text-lg-right checkbox" for="TermsAndCondition"></label>

                                <div class="col-lg-6">
                                <input class="form-check-input control" type="checkbox" name="TermsAndCondition" checked id="TermsAndCondition"  value="1">
                                <a data-target="#myModal" data-toggle="modal" class="MainNavText" id="MainNavHelp" href="#myModal"> Terms and Agreement</a><br>
                                
                                </div>
                                @error('TermsAndCondition')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
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


<!-- start T&A modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
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
        <br>
        <h2>Privacy Policy</h2>
        Falcon Printing Services. We are committed to protecting your privacy. This Privacy Policy explains how your personal information is collected, used, and disclosed by Falcon Printing Services.
        This Privacy Policy applies to our website, falconprint.com and its associated subdomains collectively . By accessing or using our service, you signify that you read, understood, and agree to our collection, storage, use, and disclosure of your personal information as described in this Privacy Policy.  
        <br>
        <h2>Your Consent</h2>
        By using our service, registering an account, or making purchase, you consent to this Privacy Policy.
        <br>
        <h2>Affiliates</h2>
        We may disclose information (including personal information) about you to our Corporate Affiliates. For purposes of this Privacy Policy, means any person or entity which directly or indirectly controls, is controlled by or is under common control with us, whether by ownership or otherwise. Any information relating to you that we provide to our Corporate Affiliate will be treated by those Corporate Affiliates in accordance with the terms of this Privacy Policy
        <h2>Order Jobs</h2>
        Unclaimed orders are given one week after the file has been printed. After one week the unclaimed orders will be disregarded in order to avoid piled up of the finished orders.
        <h2>Blacklisted</h2>
        Users who don't comply and follow the terms and agreement of the website will be block listed and cannot login on the website.
        <h2>Protects Data Privacy</h2>
        The Data Privacy Act of 2012 (R.A. 10173), including its implementing Rules and Regulations, strengthens the fundamental human right of privacy, and of communication while ensuring the free flow of information to promote innovation and growth.

    
    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Accept</button>
       
      </div>
    </div>
  </div>
</div>
<!-- end T&A modal -->

<script>
    $(document).ready(function(){
        $('#app').attr("style", 
        "background-image:url('{{ asset('/img/backround.png') }}');background-repeat: no-repeat;background-attachment: fixed;background-position: center;background-size: cover;")
    });
</script>
@endsection
