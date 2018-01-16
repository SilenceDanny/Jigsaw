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
        <?php
            use App\Puzzle;
            $puzzles =App\Puzzle::all();
            $puzzleCnt = count($puzzles);
        ?>

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
                  <li class="nav-item active">
                    <a class="nav-link" href="#home">HOME</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#explore">EXPLORE</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#diy">DIY</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#contact">CONTACT</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                    LOGOUT
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                  </li>
                </ul>
              </div>
            </nav>
        </div>    

        <section id="home" class="hero-area bg-1">
            <div class="container">
                <div class="row">
                    <div class="col-md-7">
                        <div class="block">
                            <h1 class="wow fadeInDown" data-wow-delay="0.3s" data-wow-duration=".2s">Welcome to Puzzle Collaborate, {{ Auth::user()->name }} !</h1>
                            <p style="font-size: 18px; margin-left: 20px;">You have two ways to start a Jigsaw Puzzle: DIY your own or play an existing one.</p>
                            <p class="wow fadeInDown" data-wow-delay="0.5s" data-wow-duration=".5s"></p>
                            <div class="wow fadeInDown" data-wow-delay="0.7s" data-wow-duration=".7s">
                                <a class="btn btn-home" style="margin-left: 30px; width: 300px;" href="#diy" role="button">Upload Picture to Start</a><br>
                                <a class="btn btn-home" style="margin-left: 30px; width: 300px;" href="#explore" role="button">Choose a Existing Puzzle</a>
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

        <!--puzzle模块-->


        <section id="explore" class="service section">
            <div class="container">

                <div class="row">
                    <div class="heading wow fadeInUp">
                        <h2>Recommended Chanllege</h2>
                    </div>
                    
                        @for ($i = 0; $i < 8; $i++)
                            <?php
                                $puzzle_choosen = rand(0,$puzzleCnt-1);
                            ?>
                            <div class="col-sm-6 col-md-3 wow fadeInLeft">
                                <div class="block">
                                    {{-- <a onclick="javascript:document.from.submit();">
                                        <img src= {{$puzzles[$puzzle_choosen]->path}} style="width: 200px; height: 200px">
                                    </a> --}}
                                    <form name="playExists" action="playExists" method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="Name" value={{$puzzles[$puzzle_choosen]->puzzle_name}}>
                                        <input type="hidden" name="ID" value={{$puzzles[$puzzle_choosen]->puzzle_id}}>
                                        <input type="hidden" name="Path" value={{$puzzles[$puzzle_choosen]->path}}>
                                        <input type="hidden" name="Mode" value={{$puzzles[$puzzle_choosen]->mode}}>
                                        <input type="image" src={{$puzzles[$puzzle_choosen]->path}} style="width: 200px; height: 200px">
                                    </form>
                                    <h2>Name:{{$puzzles[$puzzle_choosen]->puzzle_name or 'Default'}}</h2>
                                    <h4>Uploader:{{$puzzles[$puzzle_choosen]->owner_name or 'Default'}}</h4>
                                    
                                </div>
                            </div>
                        @endfor                
                </div>
            </div>
        </section>

        <section id="explore" class="service section">
            <div class="container">

                <div class="row">
                    <div class="heading wow fadeInUp">
                        <h2>Colla Chanllege</h2>
                    </div>
                    
                        @for ($i = 0; $i < 8; $i++)
                            <?php
                                $puzzle_choosen = rand(0,$puzzleCnt-1);
                            ?>
                            <div class="col-sm-6 col-md-3 wow fadeInLeft">
                                <div class="block">
                                    {{-- <a onclick="javascript:document.from.submit();">
                                        <img src= {{$puzzles[$puzzle_choosen]->path}} style="width: 200px; height: 200px">
                                    </a> --}}
                                    <form name="playColla" action="playColla" method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="Name" value={{$puzzles[$puzzle_choosen]->puzzle_name}}>
                                        <input type="hidden" name="ID" value={{$puzzles[$puzzle_choosen]->puzzle_id}}>
                                        <input type="hidden" name="Path" value={{$puzzles[$puzzle_choosen]->path}}>
                                        <input type="hidden" name="Mode" value={{$puzzles[$puzzle_choosen]->mode}}>
                                        <input type="image" src={{$puzzles[$puzzle_choosen]->path}} style="width: 200px; height: 200px">
                                    </form>
                                    <h2>Name:{{$puzzles[$puzzle_choosen]->puzzle_name or 'Default'}}</h2>
                                    <h4>Uploader:{{$puzzles[$puzzle_choosen]->owner_name or 'Default'}}</h4>
                                    
                                </div>
                            </div>
                        @endfor                
                </div>
            </div>
        </section>


        <section class="section about bg-gray" id="diy">
            <div class="container">
                <div class="row">
                    <div class="col-md-7 col-sm-12 wow fadeInLeft">
                        <div class="content">
                            <div class="sub-heading">
                            <h3>DIY Your Own Jigsaw Puzzle</h3>
                            </div>
                            <form action="uploadimg" method="POST"  enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <h4>Puzzle Name:</h4>
                                <div class="input-field">
                                    <input type="text" class="uploadpuzzle" placeholder="Your Jigsaw Name" name="JigsawName">
                                <br><br>
                                <h4>Upload Photo:</h4>
                                <span class="btn btn-success fileinput-button">
                                    <span>Choose Picture</span>
                                    <input type="file" name="imageSrc">
                                </span>
                                <br><br>
                                <h4>Game Mode:</h4>
                                <input type="checkbox" name="gamemode" value="25">25 pieces</input>
                                <input type="checkbox" name="gamemode" value="100">100 pieces</input>
                                <br>
                                <button type="submit" class="btn btn-home">Submit</button>
                            </form>                    
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="contact" class="section contact">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="block">
                            <div class="heading wow fadeInUp">
                                <h2>Get In Touch</h2>
                                <p>If you have any suggestions<br>
                                Plase contact us.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-6 offset-md-3 wow fadeInUp" data-wow-delay="0.3s">
                        <div class="form-group">
                            <form action="#" method="post" id="contact-form">
                                <div class="input-field">
                                    <input type="text" class="form-control" placeholder="Your Name" name="name">
                                </div>
                                <div class="input-field">
                                    <input type="email" class="form-control" placeholder="Email Address" name="email">
                                </div>
                                <div class="input-field">
                                    <textarea class="form-control" placeholder="Your Message" rows="3" name="message"></textarea>
                                </div>
                                <button class="btn btn-send" type="submit">SEND</button>
                            </form>

                            <div id="success">
                                <p>Your Message was sent successfully</p>
                            </div>
                            <div id="error">
                                <p>Your Message was not sent successfully</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

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
