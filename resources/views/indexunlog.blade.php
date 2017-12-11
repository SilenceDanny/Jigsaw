<!DOCTYPE html>
<html class="no-js">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>PUZZLE COLLABORATE</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
        
        <!-- Fonts -->
        <!-- Source Sans Pro -->
        <link href="https://fonts.googleapis.com/css?family=Droid+Serif:400i|Source+Sans+Pro:300,400,600,700" rel="stylesheet">
        
        <!-- CSS -->

        <!-- <link rel="stylesheet" href="css/bootstrap.min.css"> -->
        <!-- Bootstrap CDN -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css" integrity="sha384-AysaV+vQoT3kOAXZkl02PThvDr8HYKPZhNT5h/CXfBThSRXQ6jW5DO2ekP5ViFdi" crossorigin="anonymous">
        

        <link rel="stylesheet" href="css/themefisher-fonts.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/owl.carousel.css">
        <link rel="stylesheet" href="css/animate.css">
        <link rel="stylesheet" href="css/style.css">
        <!-- Responsive Stylesheet -->
        <link rel="stylesheet" href="css/responsive.css">
    </head>

    <body id="body">

        <div id="preloader">
            <div class="book">
              <div class="book__page"></div>
              <div class="book__page"></div>
              <div class="book__page"></div>
            </div>
        </div>

        <!-- 
        Header start
        ==================== -->
        <div class="container">
            <nav class="navbar navbar-fixed-top  navigation " id="top-nav">
              <div class="collapse navbar-toggleable-md" id="navbarResponsive">
                <ul class="nav navbar-nav menu float-lg-right" id="top-nav">
<!--                   <li class="nav-item active">
                    <a class="nav-link" href="#">HOME</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#explore">EXPLORE</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#diy">DIY</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#contact">CONTACT</a>
                  </li> -->
                </ul>
              </div>
            </nav>
        </div>
        

        <section class="hero-area bg-1">
            <div class="container">
                <div class="row">
                    <div class="col-md-7">
                        <div class="block">
                            <h1 class="wow fadeInDown" data-wow-delay="0.3s" data-wow-duration=".2s">Play Jigsaw Puzzle With You Friend</h1>
                            <p class="wow fadeInDown" data-wow-delay="0.5s" data-wow-duration=".5s"></p>
                            <div class="wow fadeInDown" data-wow-delay="0.7s" data-wow-duration=".7s">
                                <a class="btn btn-home" href="/login" role="button">Sign In</a>
                                <a class="btn btn-register" style="margin-left: 20px;" href="/register" role="button">Register</a>
                                <!-- 协同拼图入口 -->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 wow zoomIn">
                        <div class="block">
                            <div class="counter text-center">
                                <div style="font-size:40px;line-height: 50px;color: #fff;font-weight: 600;">SEASON ENDS IN:</div>
                                <ul id="countdown_dashboard">
                                    {{-- main.js修改时间 --}}
                                    <li>
                                        <div class="dash days_dash">
                                            <div class="digit">0</div>
                                          <div class="digit">0</div>
                                          <div class="digit">0</div>
                                            <span class="dash_title">Days</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="dash hours_dash">
                                            <div class="digit">0</div>
                                          <div class="digit">0</div>
                                            <span class="dash_title">Hours</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="dash minutes_dash">
                                            <div class="digit">0</div>
                                          <div class="digit">0</div>
                                            <span class="dash_title">Minutes</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="dash seconds_dash">
                                            <div class="digit">0</div>
                                          <div class="digit">0</div>
                                            <span class="dash_title">Seconds</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div><!-- .row close -->
            </div><!-- .container close -->
        </section><!-- header close -->

        <!-- Js -->
        <script type="text/javascript"
            src="{{ URL::asset('js/vendor/jquery-2.1.1.min.js') }}"></script>
        <script type="text/javascript"
            src="{{ URL::asset('js/vendor/modernizr-2.6.2.min.js') }}"></script>
        <script type="text/javascript"
            src="{{ URL::asset('js/jquery.lwtCountdown-1.0.js') }}"></script>
        <script type="text/javascript"
            src="{{ URL::asset('js/owl.carousel.min.js') }}"></script>
        <script type="text/javascript"
            src="{{ URL::asset('js/jquery.validate.min.js') }}"></script>
        <script type="text/javascript"
            src="{{ URL::asset('js/jquery.form.js') }}"></script>
        <script type="text/javascript"
            src="{{ URL::asset('js/jquery.nav.js') }}"></script>
        <script type="text/javascript"
            src="{{ URL::asset('js/wow.min.js') }}"></script>
        <script type="text/javascript"
            src="{{ URL::asset('js/main.js') }}"></script> 
    </body>
</html>
