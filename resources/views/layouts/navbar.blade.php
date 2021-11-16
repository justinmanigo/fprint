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
                    <img src="{{ asset('/img/logo.png') }}" width="40" height="40" class="d-inline-block align-top rounded" alt="">
                   <b style="font-size:25px"> Falcon Printing Service  </b>
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
                        <li class="nav-item active">
                            <a href="#FAQs" class="nav-link">FAQs</a>
                        </li>
                        <div class="d-block d-sm-none">
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

                        </div>   
                            @else
                         <div class="d-block d-sm-none">
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
                         </div>
                         
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
                            <a class="dropdown-item" href="/#FAQs">FAQs</a>
                        
                        
                        </li>
                            @if(Auth::user() && Auth::user()->roles->first()->name == "admin")
                            <li class="nav-item active">
                                <a href="/dashboard" class="nav-link"> Dashboard </a>
                            </li>
                            
                            @else
                            <li class="nav-item active">
                                <a href="/orderForm" class="nav-link"> Order Form </a>
                            </li>
                            <li class="nav-item active">
                                <a href="/myOrders" class="nav-link"> Track my Order </a>
                            </li>
                            @endif
                        @endif

                        @if(Auth::user() && Auth::user()->roles->first()->name == "admin")
                        <li class="nav-item dropdown active">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Admin
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <!-- <a class="dropdown-item" href="/dashboard">Dashboard</a> -->
                            <a class="dropdown-item" href="/announcement">Announcements</a>
                            <a class="dropdown-item" href="/orders">Orders</a>
                            <a class="dropdown-item" href="/printprice">Print Price</a>
                            <a class="dropdown-item" href="/transactions">Transactions</a>
                            <a class="dropdown-item" href="/users">Users</a>
                                
                        </li>
                        @endif
                    </ul>
                </div>
                

                
                


                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                            <!-- <li class="nav-item dropdown dropdown-notifications">
                                        <a href="#" class="nav-link dropdown-toggle" id="navbarDropdown2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                            
                                            <i data-count="0" class="glyphicon glyphicon-bell  notification-icon"> </i>
                                        </a>

                                        <div class="dropdown-container">
                                            <div class="dropdown-toolbar">
                                            <div class="dropdown-toolbar-actions">
                                                <a href="#">Mark all as read</a>
                                            </div>
                                            <h3 class="dropdown-toolbar-title">Notifications (<span class="notif-count">0</span>)</h3>
                                            </div>
                                            <ul class="dropdown-menu  dropdown-menu-left" aria-labelledby="navbarDropdown2">

                                            </ul>
                                            <div class="dropdown-footer text-center">
                                            <a href="#">View All</a>
                                            </div>
                                        </div>
                            </li> -->
                            <!-- <li><a href="#">Timeline</a></li>
                            <li><a href="#">Friends</a></li> -->

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
                        <!-- <li class="nav-item avatar dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-light" id="navbarDropdownMenuLink-5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <span class="badge badge-danger ml-2">4</span>
                            <i class="fas fa-bell"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-lg-right dropdown-secondary" aria-labelledby="navbarDropdownMenuLink-5">
                            <a class="dropdown-item waves-effect waves-light" href="#">Action <span class="badge badge-danger ml-2">4</span></a>
                            <a class="dropdown-item waves-effect waves-light" href="#">Another action <span class="badge badge-danger ml-2">1</span></a>
                            <a class="dropdown-item waves-effect waves-light" href="#">Something else here <span class="badge badge-danger ml-2">4</span></a>
                            </div>
                        </li> -->

                        
       
           
           
         
                     
                         
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

    <!-- <script src="https://js.pusher.com/5.0/pusher.min.js"></script>  -->
    <script src="//js.pusher.com/3.1/pusher.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

 
    <script type="text/javascript">
      var notificationsWrapper   = $('.dropdown-notifications');
      var notificationsToggle    = notificationsWrapper.find('a[data-toggle]');
      var notificationsCountElem = notificationsToggle.find('i[data-count]');
      var notificationsCount     = parseInt(notificationsCountElem.data('count'));
      var notifications          = notificationsWrapper.find('ul.dropdown-menu');

    //   if (notificationsCount <= 0) {
    //     notificationsWrapper.hide();
    //   }

      // Enable pusher logging - don't include this in production
      // Pusher.logToConsole = true;

      var pusher = new Pusher('ca55e4cfb99b8ad6ffd5', {
        cluster: 'ap1',
        forceTLS: true,
      });

      // Subscribe to the channel we specified in our Laravel Event
      var channel = pusher.subscribe('status-liked');

      // Bind a function to a Event (the full Laravel class)
      channel.bind('status-liked-event', function(data) {
        console.log("test");
        var existingNotifications = notifications.html();
        var avatar = Math.floor(Math.random() * (71 - 20 + 1)) + 20;
        var newNotificationHtml = `
          <li class="notification active">
              <div class="media">
                <div class="media-left">
                  <div class="media-object">
                    <img src="https://api.adorable.io/avatars/71/`+avatar+`.png" class="img-circle" alt="50x50" style="width: 50px; height: 50px;">
                  </div>
                </div>
                <div class="media-body">
                  <strong class="notification-title">`+data.message+`</strong>
                  <!--p class="notification-desc">Extra description can go here</p-->
                  <div class="notification-meta">
                    <small class="timestamp">about a minute ago</small>
                  </div>
                </div>
              </div>
          </li>
        `;
        notifications.html(newNotificationHtml + existingNotifications);

        notificationsCount += 1;
        notificationsCountElem.attr('data-count', notificationsCount);
        notificationsWrapper.find('.notif-count').text(notificationsCount);
        notificationsWrapper.show();
      });
    </script>