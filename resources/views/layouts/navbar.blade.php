<body id="body">
    <div class="class=preloader" id="app">

      <div id="content-wrap">
        <nav class="bg-dark navbar navbar-expand-md navbar-dark bg-secondary shadow-sm">
            <div class="container">
             
                <!-- logo -->
                <a class="navbar-brand" href="
                    @if(Route::currentRouteName() == "home")
                        #    
                    @else
                        /
                    @endif
                ">
                    <img src="{{ asset('/img/logo.png') }}" width="30" height="30" class="d-inline-block align-top rounded" alt="">
                    Falcon Printing Service
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- nav menu -->
                <div class="collapse navbar-collapse" id="navbarToggler">
                    <ul class="navbar-nav mx-auto mt-2 mt-lg-0">
                         
                        @guest
                        <li class="nav-item active">
                            <a href="
                                @if(Route::currentRouteName() == "home")
                                    #    
                                @else
                                    /
                                @endif
                        " class="nav-link"> Home</a>
                        </li>
                        <li class="nav-item active">
                            <a href="#about_us" class="nav-link"> About Us</a>
                        </li>
                        <li class="nav-item active">
                            <a href="#steps" class="nav-link"> Let's Print</a>
                        </li>
                        <li class="nav-item active">
                            <a href="#printing_schedule" class="nav-link"> Printing Schedule</a>
                        </li>
                        @endguest
                        
                        @if(Auth::user())
                        <!-- <li class="nav-item active">
                            <a href="
                                @if(Route::currentRouteName() == "home")
                                    #    
                                @else
                                    /
                                @endif
                            " class="nav-link"> Home</a>
                        </li> -->
                        <li class="nav-item dropdown active">
                            <a class="nav-link dropdown-toggle" href="/" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Home
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="
                                @if(Route::currentRouteName() == "home")
                                    #    
                                @else
                                    /
                                @endif
                            ">Home</a>
                            <a class="dropdown-item" href="/#about_us">About Us</a>
                            <a class="dropdown-item" href="/#steps">Let's Print</a>
                            <a class="dropdown-item" href="/#printing_schedule">Printing Schedule</a>
                        </li>
                        <li class="nav-item active">
                            <a href="/orderForm" class="nav-link"> Order Form </a>
                            <!-- <a class="nav-item nav-link" href="/orderForm">Order Form <span class="sr-only"></span></a> -->
                        </li>
                        <li class="nav-item active">
                            <a href="/myOrders" class="nav-link"> Track my Order </a>
                            <!-- <a class="nav-link" href="/myOrders">Track my Order <span class="sr-only"></span></a> -->
                        </li>
                        @endif

                        @if(Auth::user() && Auth::user()->roles->first()->name == "admin")
                        <li class="nav-item dropdown active">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Admin
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/users">Users</a>
                            <a class="dropdown-item" href="/orders">Orders</a>
                            <a class="dropdown-item" href="/transactions">Transactions</a>
                            <a class="dropdown-item" href="/printprice">Print Price</a>
                            <a class="dropdown-item" href="/dashboard">Dashboard</a>
                        </li>
                        @endif
                    </ul>
                </div>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->firstName}} {{Auth::user()->lastName }} 
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="/settings">
                                            {{ __('Settings') }}
                                    </a>

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                     @csrf
                                    </form>
                                  
                                </div>
                                
                            </li>
                            
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <!-- content of the website -->
        <main class="pt-4 pb-lg-0">
            @yield('content')
        </main>
           <!-- Scroll to top button -->
           <div class="d-flex justify-content-end mb-3">
            <button  class="scrollToTopBtn" id="scrollToTopBtn"> ↑</button><br>
            </div>
    </div>