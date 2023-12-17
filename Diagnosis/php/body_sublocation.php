<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the 'radio_group' key exists in the $_POST array
    if (isset($_POST['body_loc'])) {
        // Retrieve the selected radio input value
        $selectedValue = $_POST['body_loc'];
    } else {
        echo "No radio option selected.";
    }
}
?>
<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="description" content="Orbitor,business,company,agency,modern,bootstrap4,tech,software" />
    <meta name="author" content="themefisher.com" />

    <title>Treatify- Health & Care Medical Solutions</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="/treatify/images/favicon.png" />

    <!-- bootstrap.min css -->
    <link rel="stylesheet" href="/treatify/plugins/bootstrap/css/bootstrap.min.css" />
    <!-- Icon Font Css -->
    <link rel="stylesheet" href="/treatify/plugins/icofont/icofont.min.css" />
    <!-- Slick Slider  CSS -->
    <link rel="stylesheet" href="/treatify/plugins/slick-carousel/slick/slick.css" />
    <link rel="stylesheet" href="/treatify/plugins/slick-carousel/slick/slick-theme.css" />

    <!-- Main Stylesheet -->
    <style>
        .form-container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 50px auto;
            transition: box-shadow 0.3s ease;
        }

        .form-step {
            display: none;
            opacity: 0;
            transform: translateX(-20px);
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .form-progress {
            height: 10px;
            background-color: #ddd;
            border-radius: 5px;
            margin-bottom: 20px;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            width: 67%;
            background: rgb(70, 70, 255);
            /* Red Color */
            border-radius: 5px;
            transition: width 0.3s ease;
        }

        .active {
            display: block;
            opacity: 1;
            transform: translateX(0);
        }

        .welcome-step {
            opacity: 1;
            transform: translateX(0);
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        button {
            background-color: #3498db;
            /* Dark Blue Color */
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-right: 10px;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        button:hover {
            background: linear-gradient(to right, rgb(255, 80, 80) 5%, rgb(102, 102, 245) 100%);
            /* Red Color */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }
    </style>
    <link rel="stylesheet" href="/treatify/css/style.css" />
</head>

<body id="top">
    <header>
        <nav class="navbar navbar-expand-lg navigation" id="navbar">
            <div class="container">
                <a class="navbar-brand" href="/treatify/index.html">
                    <img src="/treatify/images/logo_icon.png" alt="" style="max-width: 100%; height: 128px" />
                </a>

                <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarmain"
                    aria-controls="navbarmain" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icofont-navigation-menu"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarmain">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="/treatify/index.html">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/treatify/about.html">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/treatify/service.html">Services</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="/Treatify/Diagnosis/fbd.php">Diagnosis</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/treatify/blog-sidebar.html">Blog</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/treatify/contact.html">Contact Us</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <!-- Content starts here-->
    <section class="page-title bg-1">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-6 form-container">
                                <div class="form-progress">
                                    <div class="progress-bar" id="progress-bar"></div>
                                </div>

                                <div class="form-step welcome-step active" id="welcome">
                                    <h1>Select a sublocation of Body part:</h1>
                                    <p>
                                    <form action="symptoms_in_bodysubloc.php" method="post" id="bodysubloc_form">
                                        <?php

                                        require 'token_generator.php';
                                        require 'priaid_client.php';

                                        class Demo
                                        {
                                            private $config;
                                            private $diagnosisClient;

                                            function __construct()
                                            {
                                                $this->config = parse_ini_file("config.ini");
                                            }

                                            private function checkRequiredParameters()
                                            {
                                                $pass = true;

                                                if (!isset($this->config['username'])) {
                                                    $pass = false;
                                                    print "You didn't set username in config.ini";
                                                }

                                                if (!isset($this->config['password'])) {
                                                    $pass = false;
                                                    print "You didn't set password in config.ini";
                                                }

                                                if (!isset($this->config['authServiceUrl'])) {
                                                    $pass = false;
                                                    print "You didn't set authServiceUrl in config.ini";
                                                }

                                                if (!isset($this->config['healthServiceUrl'])) {
                                                    $pass = false;
                                                    print "You didn't set healthserviceUrl in config.ini";
                                                }

                                                return $pass;
                                            }

                                            public function simulate()
                                            {
                                                if (!$this->checkRequiredParameters())
                                                    return;

                                                $tokenGenerator = new TokenGenerator($this->config['username'], $this->config['password'], $this->config['authServiceUrl']);
                                                $token = $tokenGenerator->loadToken();

                                                if (!isset($token))
                                                    exit();

                                                $this->diagnosisClient = new DiagnosisClient($token, $this->config['healthServiceUrl'], 'en-gb');
                                                $bodyLocations = $this->diagnosisClient->loadBodyLocations();
                                                if (!isset($bodyLocations))
                                                    exit();
                                                // $this->printSimpleObject($bodyLocations);
                                        
                                                $bodylocId = $_POST['body_loc'];
                                                $bodySublocations = $this->diagnosisClient->loadBodySublocations($bodylocId);
                                                if (!isset($bodySublocations))
                                                    exit();
                                                $this->printSimpleObject($bodySublocations);

                                            }
                                            private function printSimpleObject($object)
                                            {

                                                array_map(function ($var) {
                                                    echo "<br><input type='radio' name='bodysubloc' value='", $var['ID'], "'> ", $var['Name'], "<br>";
                                                }, $object);
                                            }
                                        }

                                        $demo = new Demo();
                                        $demo->simulate();

                                        ?>
                                        <button type="submit" id="submit">Next</button>
                                        </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
    <!-- Content ends here-->
    <!-- footer Start -->
    <footer class="footer section gray-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mr-auto col-sm-6">
                    <div class="widget mb-5 mb-lg-0">
                        <div class="logo mb-4">
                            <img src="/treatify/images/logo_icon.png" alt="" class="img-fluid" />
                        </div>
                        <p>
                            Follow us on Social Media to keep yourself up to date with latest technology.
                        </p>

                        <ul class="list-inline footer-socials mt-4">
                            <li class="list-inline-item">
                                <a href="https://www.facebook.com/DPSBharuch/"><i class="icofont-facebook"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a href="https://twitter.com/dpsbharuch?lang=en"><i class="icofont-twitter"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a href="https://in.linkedin.com/company/delhi-public-school-bharuch"><i
                                        class="icofont-linkedin"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6 col-sm-6">
                    <div class="widget mb-5 mb-lg-0">
                        <h4 class="text-capitalize mb-3">Support</h4>
                        <div class="divider mb-4"></div>

                        <ul class="list-unstyled footer-menu lh-35">
                            <li><a href="#">Terms & Conditions</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Company Support </a></li>
                            <li><a href="#">FAQuestions</a></li>
                            <li><a href="#">Company Licence</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="widget widget-contact mb-5 mb-lg-0">
                        <h4 class="text-capitalize mb-3">Get in Touch</h4>
                        <div class="divider mb-4"></div>

                        <div class="footer-contact-block mb-4">
                            <div class="icon d-flex align-items-center">
                                <i class="icofont-email mr-3"></i>
                                <span class="h6 mb-0">Support Available for 24/7</span>
                            </div>
                            <h4 class="mt-2">
                                <a href="tel:+23-345-67890">Support@email.com</a>
                            </h4>
                        </div>

                        <div class="footer-contact-block">
                            <div class="icon d-flex align-items-center">
                                <i class="icofont-support mr-3"></i>
                                <span class="h6 mb-0">Mon to Fri : 08:30 - 18:00</span>
                            </div>
                            <h4 class="mt-2">
                                <a href="tel:+23-345-67890">+23-456-6588</a>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer-btm py-4 mt-5">
                <div class="row align-items-center justify-content-between">
                    <div class="col-lg-6">
                        <div class="copyright">
                            &copy; Copyright Reserved to
                            <span class="text-color">Treatify</span>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="subscribe-form text-lg-right mt-5 mt-lg-0">
                            <form action="#" class="subscribe">
                                <input type="text" class="form-control" placeholder="Your Email address" />
                                <a href="#" class="btn btn-main-2 btn-round-full">Subscribe</a>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4">
                        <a class="backtop js-scroll-trigger" href="#top">
                            <i class="icofont-long-arrow-up"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- 
    Essential Scripts
    =====================================-->

    <!-- Main jQuery -->
    <script src="/treatify/plugins/jquery/jquery.js"></script>
    <!-- Bootstrap 4.3.2 -->
    <script src="/treatify/plugins/bootstrap/js/popper.js"></script>
    <script src="/treatify/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="/treatify/plugins/counterup/jquery.easing.js"></script>
    <!-- Slick Slider -->
    <script src="/treatify/plugins/slick-carousel/slick/slick.min.js"></script>
    <!-- Counterup -->
    <script src="/treatify/plugins/counterup/jquery.waypoints.min.js"></script>

    <script src="/treatify/plugins/shuffle/shuffle.min.js"></script>
    <script src="/treatify/plugins/counterup/jquery.counterup.min.js"></script>

    <script src="/treatify/js/script.js"></script>
    <script src="/treatify/js/contact.js"></script>
</body>

</html>