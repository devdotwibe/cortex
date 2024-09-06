   <!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cortex</title>
        <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="./assets/css/slick.css">
        <link rel="stylesheet" href="./assets/css/slick-theme.css">
        <link rel="stylesheet" href="./assets/css/aos.css">
        <link rel="stylesheet" href="./assets/css/stylesheet.css">
    </head>
    <body>
        <header class="header-wrapp">
            <div class="container">
                <div class="header-row">
                    <div class="brand-logo">
                        <a href="">
                            <img src="./assets/images/logo.svg" alt="">
                        </a>
                    </div>
                    <div class="header-right">
                        <ul>
                            <li class="nav-link"><a href="">Home</a></li>
                            <li class="nav-link"><a href="">Course</a></li>
                            <li class="nav-link"><a href="">Pricing</a></li>
                            <li class="nav-link"><a href="">Find a Tutor</a></li>
                            <li class="nav-link signup-link"><a href="">Sign Up</a></li>
                        </ul>
                        <div class="header-btn">
                            <a href="" class="header-btn1">Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
    @yield('content')

    @stack('modals')



    <footer>
        <div class="footer-wrapp">
            <div class="container">
                <div class="footer-row">
                    <div class="footer-col1">
                        <a href="" class="footer-brand">
                            <img src="./assets/images/footer-logo.svg" alt="">
                        </a>
                    </div>
                    <div class="footer-col2">
                        <h3>Courses</h3>
                        <ul>
                            <li><a href="">Diagnostic Exam</a></li>
                            <li><a href="">Critical Reasoning</a></li>
                            <li><a href="">Exam Preparation</a></li>
                        </ul>
                    </div>
                    <div class="footer-col3">
                        <h3>Information</h3>
                        <ul>
                            <li><a href="">Home</a></li>
                            <li><a href="">Pricing </a></li>
                            <li><a href="">Courses</a></li>
                            <li><a href="">Find Tutor</a></li>
                        </ul>
                    </div>
                    <div class="footer-col4">
                        <p><a href="">www.cortexacademy.com.au</a></p>
                        <p><a href="">St Hudson Street
                            <span>Australia</span></a>
                        </p>
                        <p><a href="">Open 9am to 5pm
                            <span>Monday to Friday</span></a>
                        </p>
                        <ul class="social-icons">
                            <li><a href=""><img src="./assets/images/fb.svg" alt=""></a></li>
                            <li><a href=""><img src="./assets/images/yt.svg" alt=""></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-row1">
            <div class="container">
                <p>Privacy Policy | Terms & Conditions © 2024 Cortex</p>
            </div>
        </div>
    </footer>

    <script src="./assets/js/jquery-3.7.1.min.js"></script>
    <script src="./assets/js/bootstrap.min.js"></script>
    <script src="./assets/js/slick.js"></script>
    <script src="./assets/js/aos.js"></script>
    <script src="./assets/js/scripts.js"></script>

    @stack('scripts')

</body>
</html>
