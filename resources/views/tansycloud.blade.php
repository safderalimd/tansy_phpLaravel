<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>tansyCloud</title>

    <!-- Bootstrap Core CSS -->
    <link href="/tansy/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/tansy/css/agency.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="/tansy/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body id="page-top" class="index">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand page-scroll" href="#page-top">tansyCloud</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#services">Products</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#about">About</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#team">Team</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#contact">Contact</a>
                    </li>
                    @if (session()->has('user'))
                        <li><a class="page-scroll" href="/cabinet">Cabinet</a></li>
                        <li><a class="page-scroll" href="/cabinet/logout">Logout</a></li>
                    @else
                        <li><a class="page-scroll" href="/login">Login</a></li>
                    @endif
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <!-- Header -->
    <header>
        <div class="container">
            <div class="intro-text">
                <div class="intro-lead-in">Welcome To</div>
                <div class="intro-heading">tansyCloud</div>
                <h4 class="subheading">Our Humble Beginnings</h4>
            </div>
        </div>
    </header>

    <!-- Services Section -->
    <section id="services">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Products</h2>
                    <h3 class="section-subheading text-muted">An interesting trend we're seeing more and more often of late...<br>We sure you can agree than almost every business relies on some sort of IT System to operate. .</h3>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fa fa-circle fa-stack-2x text-primary"></i>
                        <i class="fa fa-graduation-cap  fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="service-heading">tansy school</h4>
                    <p class="text-muted">tansy School is an innovative and first of a kind application suite which intends to build a robust communication platform for the schools and the students.</p>
                </div>
                 <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fa fa-circle fa-stack-2x text-primary"></i>
                        <i class="fa fa-automobile fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="service-heading">tansy Vehicle</h4>
                    <p class="text-muted">tansy Vehicle is a platform enabling software publishers to design an ecosystem of smartphone apps that can interact in complete security with vehicles and bring motorists all-new services.</p>
                </div>
                <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fa fa-circle fa-stack-2x text-primary"></i>
                        <i class="fa fa-envelope fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="service-heading">tansy Sms</h4>
                    <p class="text-muted">Built to handle billions of SMS messages, the tansy SMS can withstand usage spikes and unexpected infrastructure outages..</p>
                </div>
                 <div class="col-lg-12 text-center">
                 <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fa fa-circle fa-stack-2x text-primary"></i>
                        <i class="fa fa-laptop fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="service-heading">tansy Appointment </h4>
                    <p class="text-muted">tansyCloud has a slew of services to offer to patients. It ranges from online booking of doctors, checking medical records to keeping an account of medical expenses.</p>
                </div>
                <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fa fa-circle fa-stack-2x text-primary"></i>
                        <i class="fa fa-inr fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="service-heading">tansy payment Schedule </h4>
                    <p class="text-muted">tansy Payment shedule offers a host of benefits and opportunities to merchants like you. Some of them are - Boost your sales
                    The most competitive fees.</p>
                </div>
                 <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fa fa-circle fa-stack-2x text-primary"></i>
                        <i class="fa fa-wrench fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="service-heading">tansy services Schedule</h4>
                    <p class="text-muted">tansy Service Schedule all About Business Services offers business support services to small to medium sized for-profit and non-profit businesses.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
     <section id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">About</h2>
                    <h3 class="section-subheading text-muted">tansyCloud can integrate with existing software programs to enhance and drive the optimal experience for all. </h3>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <ul class="timeline">
                        <li>
                            <div class="timeline-image">
                               <span class="fa-stack fa-4x">
                        <i class="fa fa-signal fa-stack-1x fa-inverse"></i>
                                </span>
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">

                                    <h4 class="subheading">high-quality products and services to our customers.</h4>
                                </div>
                                <div class="timeline-body">
                                    <p class="text-muted">We continually strive to be a great company. At tansyCloud we recognize that software alone does not create a competitive advantage. Competitive advantage is created in the way you use the software, to maximize your total benefit of ownership, ultimately improving the level of service you deliver to your customers.</p>
                                </div>
                            </div>
                        </li>
                        <li class="timeline-inverted">
                            <div class="timeline-image">
                                         <span class="fa-stack fa-4x">
                        <i class="fa fa-laptop fa-stack-1x fa-inverse"></i>
                                </span>
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">

                                    <h4 class="subheading">An tansyCloud is Born</h4>
                                </div>
                                <div class="timeline-body">
                                    <p class="text-muted">We believe that you should have the ability to design and configure the user experience you wish to have, to drive efficiency and effectiveness throughout your business. At the same, it is vital for you to be able to drive a customer experience that sets you apart from your competition. </p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="timeline-image">
                                         <span class="fa-stack fa-4x">
                        <i class="fa fa-user fa-stack-1x fa-inverse"></i>
                                </span>
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">

                                    <h4 class="subheading">Transition to Full Service</h4>
                                </div>
                                <div class="timeline-body">
                                    <p class="text-muted">We will work with you to understand your needs and opportunities, along with those of your prospects and customers. In turn we will design a solution that leverages your existing infrastructure to meet and exceed your objectives in the ideal customer life cycle management process. </p>
                                </div>
                            </div>
                        </li>
                        <li class="timeline-inverted">
                            <div class="timeline-image">
                                <h4>Be Part
                                    <br>Of Our
                                    <br>Company!</h4>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section id="team" class="bg-light-gray">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Our Amazing Team</h2>
                    <h3 class="section-subheading text-muted">tancyCloud is run by a highly professional team headed by an experienced high-quality management.</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="team-member">
                        <img src="img/team/1.jpg" class="img-responsive img-circle" alt="">
                        <h4>Muhammed Ali</h4>
                        <p class="text-muted">CEO/CTO</p>
                        <ul class="list-inline social-buttons">
                            <li><a href="https://twitter.com"><i class="fa fa-twitter"></i></a>
                            </li>
                            <li><a href="https://www.facebook.com/"><i class="fa fa-facebook"></i></a>
                            </li>
                            <li><a href="https://in.linkedin.com/"><i class="fa fa-linkedin"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="team-member">
                        <img src="img/team/2.jpg" class="img-responsive img-circle" alt="">
                        <h4>Yousuf</h4>
                        <p class="text-muted">Business Architecture</p>
                        <ul class="list-inline social-buttons">
                            <li><a href="https://twitter.com"><i class="fa fa-twitter"></i></a>
                            </li>
                            <li><a href="https://www.facebook.com/"><i class="fa fa-facebook"></i></a>
                            </li>
                            <li><a href="https://in.linkedin.com/"><i class="fa fa-linkedin"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="team-member">
                        <img src="img/team/3.jpg" class="img-responsive img-circle" alt="">
                        <h4>Rajesh</h4>
                        <p class="text-muted">Lead Developer</p>
                        <ul class="list-inline social-buttons">
                            <li><a href="https://twitter.com"><i class="fa fa-twitter"></i></a>
                            </li>
                            <li><a href="https://www.facebook.com/"><i class="fa fa-facebook"></i></a>
                            </li>
                            <li><a href="https://in.linkedin.com/"><i class="fa fa-linkedin"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                </div>
                  <div class="container">
                <div class="row">
                <div class="col-sm-4">
                    <div class="team-member">
                        <img src="img/team/4.jpg" class="img-responsive img-circle" alt="">
                        <h4>Mohammed Salman</h4>
                        <p class="text-muted">Business Analasyst/Marketing Head</p>
                        <ul class="list-inline social-buttons">
                            <li><a href="https://twitter.com"><i class="fa fa-twitter"></i></a>
                            </li>
                            <li><a href="https://www.facebook.com/"><i class="fa fa-facebook"></i></a>
                            </li>
                            <li><a href="https://in.linkedin.com/"><i class="fa fa-linkedin"></i></a>
                            </li>
                        </ul>

                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="team-member">
                        <img src="img/team/5.jpg" class="img-responsive img-circle" alt="">
                        <h4> Guguloth Ramesh</h4>
                        <p class="text-muted">UI design Architecture</p>
                        <ul class="list-inline social-buttons">
                            <li><a href="https://twitter.com"><i class="fa fa-twitter"></i></a>
                            </li>
                            <li><a href="https://www.facebook.com/harsha.ram2"><i class="fa fa-facebook"></i></a>
                            </li>
                            <li><a href="https://in.linkedin.com/"><i class="fa fa-linkedin"></i></a>
                            </li>
                        </ul>
                        </div>
                    </div>
                     <div class="col-sm-4">
                    <div class="team-member">
                        <img src="img/team/6.jpg" class="img-responsive img-circle" alt="">
                        <h4>Muhammed Salman Ali</h4>
                        <p class="text-muted">Jr Business Analasyst</p>
                        <ul class="list-inline social-buttons">
                            <li><a href="https://twitter.com"><i class="fa fa-twitter"></i></a>
                            </li>
                            <li><a href="https://www.facebook.com/"><i class="fa fa-facebook"></i></a>
                            </li>
                            <li><a href="https://in.linkedin.com/"><i class="fa fa-linkedin"></i></a>
                            </li>
                        </ul>

                    </div>
                </div>
                </div>
            </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 text-center">
                    <p class="large text-muted">We love to hear from people,
so if you’re looking to work with us on a project or just want to send us some love, please do say hello!</p>
                </div>
            </div>
        </div>
    </section>



    <!-- Contact Section -->
    <section id="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Contact Us</h2>
                    <h3 class="section-subheading text-muted">tansyCloud it developers.</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <form name="sentMessage" id="contactForm" novalidate>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Your Name *" id="name" required data-validation-required-message="Please enter your name.">
                                    <p class="help-block text-danger"></p>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control" placeholder="Your Email *" id="email" required data-validation-required-message="Please enter your email address.">
                                    <p class="help-block text-danger"></p>
                                </div>
                                <div class="form-group">
                                    <input type="tel" class="form-control" placeholder="Your Phone *" id="phone" required data-validation-required-message="Please enter your phone number.">
                                    <p class="help-block text-danger"></p>
                                </div>

                                <div class="form-group">
                                    <textarea class="form-control" placeholder="Your Message *" id="message" required data-validation-required-message="Please enter a message."></textarea>
                                    <p class="help-block text-danger"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="panel panel-default">
                                    <div class="panel-body">

                                        <div class="row show-grid">
                                            <div class="col-xs-6 col-sm-6">
                                                <h4>address</h4>
                                                tansyCloud IT Group,Kachiguda,<br>Hyderbad-500027,INDIA.
                                                <br><br>tansyCloud IT Group,75 Throncliffe Park Dr,<br>Toronto,M4H 1L4, ON,CANADA.
                                                <h4>email</h4>
                                                tansyCloud@gmail.com<br>tansyCloudit@gmail.com
                                                <h4>mobile</h4>
                                                 +91 9701 777 777<br>+91 999 999 999
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix"></div>
                            <div class="col-lg-12 text-center">
                                <div id="success"></div>
                                <button type="submit" class="btn btn-xl">Send Message</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <span class="copyright">Copyright &copy; tansy cloud 2016</span>
                </div>
                <div class="col-md-4">
                    <ul class="list-inline social-buttons">
                        <li><a href="https://twitter.com"><i class="fa fa-twitter"></i></a>
                        </li>
                        <li><a href="https://www.facebook.com/"><i class="fa fa-facebook"></i></a>
                        </li>
                        <li><a href="https://in.linkedin.com/"><i class="fa fa-linkedin"></i></a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <ul class="list-inline quicklinks">
                        <li><a href="#">Privacy Policy</a>
                        </li>
                        <li><a href="#">Terms of Use</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <!-- jQuery -->
    <script src="/tansy/js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="/tansy/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    <script src="/tansy/js/classie.js"></script>
    <script src="/tansy/js/cbpAnimatedHeader.js"></script>

    <!-- Contact Form JavaScript -->
    <script src="/tansy/js/jqBootstrapValidation.js"></script>
    <script src="/tansy/js/contact_me.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="/tansy/js/agency.js"></script>

</body>

</html>
