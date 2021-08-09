@extends('layouts.index')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
      
    <div class="row">

      
        <div class="col-md-3">
            <a href="/orders">
                <div class="card-counter primary">
                    <i class="fa  fa-shopping-cart"></i>
                    <span class="count-numbers">{{$pendingOrders}}</span>
                    <span class="count-name">Pending Orders</span>
                </div>
            </a>
        </div>
         


        <div class="col-md-3">
            <a href="/orders">
                <div class="card-counter danger">
                    <i class="fa fa-list"></i>
                    <span class="count-numbers">{{$totalOrders}}</span>
                    <span class="count-name">Total Orders</span>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="#">
                <div class="card-counter success">
                    <i class="fa fa-money"></i>
                    <span class="count-numbers">₱{{number_format($revenue, 2, '.', ',')}}</span>
                    <span class="count-name">Total Revenue</span>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="/users">
                <div class="card-counter info">
                    <i class="fa fa-users"></i>
                    <span class="count-numbers">{{$totalOrders}}</span>
                    <span class="count-name">Total Users</span>
                </div>
            </a>
        </div>

    </div>
  


        </div>
    </div>
</div>
@endsection
