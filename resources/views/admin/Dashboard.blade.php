@extends('layouts.index')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
      
    <div class="row">
        <div class="col-md-3">
        <div class="card-counter primary">
            <i class="fa  fa-shopping-cart"></i>
            <span class="count-numbers">12</span>
            <span class="count-name">Pending Orders</span>
        </div>
        </div>

        <div class="col-md-3">
        <div class="card-counter danger">
            <i class="fa fa-list"></i>
            <span class="count-numbers">599</span>
            <span class="count-name">Total Orders</span>
        </div>
        </div>

        <div class="col-md-3">
        <div class="card-counter success">
            <i class="fa fa-money"></i>
            <span class="count-numbers">₱6875</span>
            <span class="count-name">Total Revenue</span>
        </div>
        </div>

        <div class="col-md-3">
        <div class="card-counter info">
            <i class="fa fa-users"></i>
            <span class="count-numbers">35</span>
            <span class="count-name">Total Users</span>
        </div>
        </div>

    </div>
  


        </div>
    </div>
</div>
@endsection
