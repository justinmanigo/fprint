@extends('layouts.index')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
      
    <div class="row">

      
        <div class="col-md-3">
            <a href="/orders">
                <div class="card-counter primary">
                    <i class="fa fa-shopping-cart"></i>
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
                    <i class="fas fa-money-bill"></i>
                    <span class="count-numbers">₱ {{number_format($revenue, 2, '.', ',')}}</span>
                    <span class="count-name">Total Revenue</span>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="/users">
                <div class="card-counter info">
                    <i class="fa fa-users"></i>
                    <span class="count-numbers">{{$totalUsers}}</span>
                    <span class="count-name">Total Users</span>
                </div>
            </a>
        </div>

        <div class="col-md-12 mb-6" id="lineChart">                 
            <div class="card text-white bg-dark mb-3">
                    <div class="card-header">
                        Sales Overview
                    </div>
                    <div class="card-body">
                        <canvas id="myLineChart"></canvas> 
                    </div>
            </div>
        </div>

    </div>
 
    
              


     

  


        </div>
    </div>
</div>

<!-- <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                
        </div>
    </div>
</div> -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.6.0/dist/chart.min.js"></script>
<script>
$( window ).on( "load", function() {
    event.preventDefault();

    $.ajaxSetup({

        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }

    });

    $.ajax({
        type:'GET',
        url:'/getRevenue',
        data:{},
        success:function(data) {
            console.log(data);
            $.each(data.revenueOverview,function(key,value){
                  console.log(key);
                  console.log(value);
                   myLineChart.data.labels.push(key);
                   myLineChart.data.datasets[0].data.push(value);
                })
                myLineChart.update();
                
        },
        error:function(data){
            alert("wa sod");
        }
    });

});
</script>
<script>
const ctx = document.getElementById('myLineChart');

const myLineChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: [],
        datasets: [{
            label: 'Revenue',
            data: [],
            backgroundColor: "rgba(78, 115, 223, 0.05)",
            borderColor: "white",
            borderWidth: 1,
            pointRadius: 3,
            pointBackgroundColor: "white",
            pointBorderColor: "white",
            pointHoverRadius: 3,
            pointHoverBackgroundColor: "white",
            pointHoverBorderColor: "white",
            pointHitRadius: 10,
            pointBorderWidth: 2,
        },
    
    
    
    ]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
@endsection
