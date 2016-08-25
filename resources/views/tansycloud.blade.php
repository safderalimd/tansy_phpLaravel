<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Tansy cloud</title>
    <!-- Bootstrap Core CSS -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link href="/tansy/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="/tansy/css/one-page-wonder.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">Tansy cloud</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="#about">About</a></li>
                    <li><a href="#services">Products</a></li>
                    <li><a href="#contact">Contact</a></li>
                    @if (session()->has('user'))
                        <li><a href="/cabinet">Cabinet</a></li>
                        <li><a href="/cabinet/logout">Logout</a></li>
                    @else
                        <li><a href="/login">Login</a></li>
                    @endif
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
    <!-- Full Width Image Header -->
    <header class="header-image">
        <img src="/tansy/img/Tansy.png" class="img-responsive banner-img" />
    </header>
    <!-- Page Content -->
    <div class="container">
        <hr class="featurette-divider">
        <!-- First Featurette -->
        <div class="featurette" id="about">
            <img class="featurette-image img-circle img-responsive pull-right" src="/tansy/img/About.jpg">
            <h2 class="featurette-heading">About us

            </h2>
            <p class="lead">
                Tansy Cloud is about running your business in entirety from your mobile or tablet.
                <br>
                <br> Tansy Cloud is one of the unique mobile app in the market that caters the needs of business organizations, owners, employees, customers, marketing agents, students, parents and teachers via mobiles, tablets and desktops. All our application features are independent of devices that the app is running on.
                <br>
                <br> Our app runs on mobile data that are as low as 2G/3G speeds. We have low footprint on your data usage too. We constantly invest our time and money to improve our mobile app performance so as to facilitate and enrich business organizations from remote places of India.
            </p>
        </div>
        <hr class="featurette-divider">
        <!-- Second Featurette -->
        <div class="featurette" id="services">
            <img class="featurette-image img-circle img-responsive pull-left" src="/tansy/img/school.jpg">
            <h2 class="featurette-heading">School Management App</h2>
            <p class="lead">You can run your entire school management application on your mobile with internet speed as low as 3G speeds.</p>
            <p class="lead">School correspondent(s), administrator, principal, teachers and parents will get their own login via android and apple mobile application.</p>
            <p class="lead">We have used advanced USER INTERFACE (UI) technology to reduce your data input and most of the screens you will not be using keyboard at all. </p>
            <p class="lead">We have built dynamic GPA examination report generation process, where you can choose subjects, sub-exams and report formats at individual class level. Yes, it is all dynamic and you define what you want per class. You can also define formulas to consider reduced marks over maximum marks per exam. </p>
            <p class="lead"><b>Fee</b> scheduling and <b>collection</b> is designed according to <b>banking systems</b> so as to be <b>100% fraud proof</b>. Daily close cash counter feature is what you would like.</p>
            <p class="lead">Note: Our app is dynamic enough so that we can configure it for colleges and coaching centres.</p>
        </div>
        <hr class="featurette-divider">
        <!-- Second Featurette -->
        <div class="featurette" id="services-2">
            <img class="featurette-image img-circle img-responsive pull-left" src="/tansy/img/sms.png">
            <h2 class="featurette-heading">SMS App
            </h2>
            <p class="lead">For any business you would need SMS functionality and we have taken care of it for you. At click of a button you send sms to 1000+ clients from your mobile over 2G/3G mobile data or broadband connection.</p>
            <p class="lead">We have build SMS dashboards to analyse your SMS usage patterns that includes costs and success rate.</p>
        </div>
        <hr class="featurette-divider">
        <!-- Third Featurette -->
        <div class="featurette" id="contact">

            <div class="pull-right">
                <img class="featurette-image img-circle img-responsive" src="/tansy/img/contact.jpg">
                <address>
                    <strong>H.No#2-4-611</strong><br>
                    Kachiguda Kamela<br>
                    Hyderabad -27<br>
                    <abbr title="Phone">P:</abbr> +91 800-837-0527
                </address>
                <address class="second-address">
                    <strong>H.No: 24-1-12</strong><br>
                    Afzalnagar Kazipet<br>
                    Warangal 506004<br>
                    <abbr title="Phone">P:</abbr> +91 800-837-0527
                </address>
            </div>

            <section id="contact-section">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="block">
                                <h2 class="subtitle wow fadeInDown" data-wow-duration="500ms" data-wow-delay=".3s">Contact Us</h2>
                                <p class="subtitle-des wow fadeInDown" data-wow-duration="500ms" data-wow-delay=".5s">
                                    <b>Tansy Cloud Private Limited.</b>
                                </p>
                                <div class="contact-form">

                                    <div class="contact-message"></div>
                                    <form id="contact-form" method="POST" action="/contact" role="form">
                                        <div class="form-group wow fadeInDown" data-wow-duration="500ms" data-wow-delay=".6s">
                                            <input type="text" placeholder="Your Name" class="form-control" name="name" id="name">
                                        </div>
                                        <div class="form-group wow fadeInDown" data-wow-duration="500ms" data-wow-delay=".8s">
                                            <input type="email" placeholder="Your Email" class="form-control" name="email" id="email">
                                        </div>
                                        <div class="form-group wow fadeInDown" data-wow-duration="500ms" data-wow-delay="1s">
                                            <input type="text" placeholder="Subject" class="form-control" name="subject" id="subject">
                                        </div>
                                        <div class="form-group wow fadeInDown" data-wow-duration="500ms" data-wow-delay="1.2s">
                                            <textarea rows="6" placeholder="Message" class="form-control" name="message" id="message"></textarea>
                                        </div>
                                        <div id="submit" class="wow fadeInDown" data-wow-duration="500ms" data-wow-delay="1.4s">
                                            <input type="button" data-loading-text="Sending..." id="contact-submit" class="btn btn-primary btn-send" value="Send Message">
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="featurette-divider">
                    <!-- Footer -->
                    <footer>
                        <div class="row">
                            <div class="col-lg-12">
                                <p>Copyright &copy; Tansycloud {{ date('Y') }}</p>
                            </div>
                        </div>
                    </footer>
                </div>
            </section>
        </div>
    </div>

    <!-- /.container -->
    <!-- jQuery -->
    <script src="/tansy/js/jquery.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="/tansy/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {

            $('#contact-submit').on('click', function() {
                var name = $('#name').val();
                var email = $('#email').val();
                var subject = $('#subject').val();
                var message = $('#message').val();

                $('#contact-submit').button('loading');

                $.ajax({
                    type: "POST",
                    url: "/contact",
                    data: {
                        name: name,
                        email: email,
                        subject: subject,
                        message: message
                    },
                    dataType: "json",
                    success: function(data) {
                        $('#contact-submit').button('reset');
                        if (data.error) {
                            $('.contact-message').addClass('error').removeClass('success').text(data.error);
                        } else if (data.success) {
                            $('.contact-message').addClass('success').removeClass('error').text(data.success);
                            $('#name').val('');
                            $('#email').val('');
                            $('#subject').val('');
                            $('#message').val('');
                        }
                    },
                    failure: function(errMsg) {
                        $('#contact-submit').button('reset');
                    }
                });
            });

        });
    </script>
</body>

</html>

