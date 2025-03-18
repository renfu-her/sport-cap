<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <!-- metas -->
    <meta charset="utf-8">
    <meta name="author" content="運動班長" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="keywords" content="運動帽和運動用品 HTML 模板" />
    <meta name="description" content="運動帽和運動用品 HTML 模板" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- title  -->
    <title>@yield('title', config('app.name', '運動班長'))</title>

    <!-- favicon -->
    <link rel="shortcut icon" href="{{ asset('img/logos/favicon.png') }}" />
    <link rel="apple-touch-icon" href="{{ asset('img/logos/apple-touch-icon-57x57.png') }}" />
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('img/logos/apple-touch-icon-72x72.png') }}" />
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('img/logos/apple-touch-icon-114x114.png') }}" />

    <!-- plugins -->
    <link rel="stylesheet" href="{{ asset('css/plugins.css') }}">

    <!-- search css -->
    <link rel="stylesheet" href="{{ asset('search/search.css') }}">

    <!-- quform css -->
    <link rel="stylesheet" href="{{ asset('quform/css/base.css') }}">

    <!-- theme core css -->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">

    @stack('styles')

</head>

<body>

    <!-- PAGE LOADING
    ================================================== -->
    <div id="preloader"></div>

    <!-- MAIN WRAPPER
    ================================================== -->
    <div class="main-wrapper">

        <!-- HEADER
        ================================================== -->
        <header class="header-style2">
            <div class="navbar-default">
                <!-- start top search -->
                <div class="top-search bg-primary">
                    <div class="container">
                        <form class="search-form" action="{{ url('/search') }}" method="GET" accept-charset="utf-8">
                            <div class="input-group">
                                <span class="input-group-addon cursor-pointer">
                                    <button class="search-form_submit fas fa-search text-white" type="submit"></button>
                                </span>
                                <input type="text" class="search-form_input form-control" name="query" autocomplete="off" placeholder="輸入關鍵字並按 Enter...">
                                <span class="input-group-addon close-search mt-2"><i class="fas fa-times"></i></span>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- end top search -->
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-12 col-lg-12">
                            <div class="menu_area">
                                <nav class="navbar navbar-expand-lg navbar-light p-0">
                                    <div class="navbar-header navbar-header-custom">
                                        <!-- start logo -->
                                        <a href="{{ url('/') }}" class="navbar-brand logodefault"><img id="logo" src="{{ asset('img/logos/logo.png') }}" alt="logo"></a>
                                        <!-- end logo -->
                                    </div>

                                    <div class="navbar-toggler"></div>

                                    <!-- menu area -->
                                    <ul class="navbar-nav ms-auto" id="nav" style="display: none;">
                                        <li><a href="{{ url('/') }}">首頁</a></li>
                                        <li>
                                            <a href="#!">關於我們</a>
                                            <ul>
                                                <li><a href="{{ url('/about') }}">關於我們</a></li>
                                                <li><a href="{{ url('/team') }}">團隊成員</a></li>
                                                <li><a href="{{ url('/faq') }}">常見問題</a></li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="#!">課程</a>
                                            <ul>
                                                <li><a href="{{ url('/coaching') }}">教練課程</a></li>
                                                <li><a href="{{ url('/training') }}">訓練營</a></li>
                                                <li><a href="{{ url('/membership') }}">會員制度</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="{{ url('/shop') }}">商店</a></li>
                                        <li><a href="{{ url('/contact') }}">聯絡我們</a></li>
                                    </ul>
                                    <!-- end menu area -->

                                    <!-- start attribute navigation -->
                                    <div class="attr-nav align-items-lg-center ms-lg-auto">
                                        <ul>
                                            <li class="search"><a href="#!"><i class="fas fa-search"></i></a></li>
                                            <li class="d-none d-xl-inline-block"><a href="{{ url('/membership') }}" class="butn primary md text-white">成為會員</a></li>
                                        </ul>
                                    </div>
                                    <!-- end attribute navigation -->

                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        @yield('content')

        <!-- FOOTER
        ================================================== -->
        <footer class="bg-white p-0">
            <div class="container-fluid px-0">
                <div class="row g-0">
                    <div class="col-xl-4 order-2 order-xl-1">
                        <div class="footer1-left">
                            <div class="left-data bg-white">
                                <div class="mb-3 footer-logo">
                                    <img src="{{ asset('img/logos/footer-light-logo.png') }}" alt="...">
                                </div>
                                <p class="mb-3">運動班長已成為知名的運動用品品牌，吸引來自世界各地的運動愛好者。</p>
                                <ul class="d-inline-block list-unstyled ps-0">
                                    <li class="align-middle d-inline-block me-3"><a href="#!"><i class="fab fa-facebook-f"></i></a></li>
                                    <li class="align-middle d-inline-block me-3"><a href="#!"><i class="fab fa-twitter"></i></a></li>
                                    <li class="align-middle d-inline-block me-3"><a href="#!"><i class="fab fa-youtube"></i></a></li>
                                    <li class="align-middle d-inline-block"><a href="#!"><i class="fab fa-linkedin-in"></i></a></li>
                                </ul>
                                <p class="mb-0 text-primary font-weight-600">&copy; <span class="current-year">{{ date('Y') }}</span> 運動班長版權所有</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8 order-1 order-xl-2">
                        <div class="footer1-right bg-secondary">
                            <div class="row">
                                <div class="col-sm-6 col-lg-4 col-xl-4 col-xxl-4 mb-2-3 mb-lg-0">
                                    <span class="section-title text-primary mb-4">快速連結</span>
                                    <div class="row">
                                        <div class="col-6">
                                            <ul class="footer-list list-unstyled mb-0">
                                                <li><a href="{{ url('/') }}">首頁</a></li>
                                                <li><a href="{{ url('/about') }}">關於我們</a></li>
                                                <li><a href="{{ url('/coaching') }}">教練課程</a></li>
                                                <li><a href="{{ url('/training') }}">訓練營</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-6">
                                            <ul class="footer-list list-unstyled mb-0">
                                                <li><a href="{{ url('/shop') }}">商店</a></li>
                                                <li><a href="{{ url('/team') }}">團隊</a></li>
                                                <li><a href="{{ url('/faq') }}">常見問題</a></li>
                                                <li><a href="{{ url('/contact') }}">聯絡我們</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-4 col-xl-4 col-xxl-4 mb-2-3 mb-lg-0">
                                    <span class="section-title text-primary mb-4">聯絡我們</span>
                                    <ul class="footer-list ps-0">
                                        <li class="pt-0">
                                            <span class="d-inline-block align-middle"><i class="fas fa-map-marker-alt display-29 text-primary"></i></span>
                                            <span class="d-inline-block w-85 align-top ps-3 text-white">台北市信義區信義路五段7號</span>
                                        </li>
                                        <li class="pb-0">
                                            <span class="d-inline-block align-middle"><i class="fas fa-phone-alt display-29 text-primary"></i></span>
                                            <span class="d-inline-block w-85 align-top ps-3 text-white">+886 2 1234 5678</span>
                                        </li>
                                        <li>
                                            <span class="d-inline-block align-middle"><i class="far fa-envelope display-29 text-primary"></i></span>
                                            <span class="d-inline-block w-85 align-top ps-3 text-white">info@sportcap.com</span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-sm-6 col-lg-4 col-xl-4 col-xxl-3">
                                    <span class="section-title text-primary mb-4">訂閱電子報</span>
                                    <p class="text-white">訂閱我們的電子報，獲取最新優惠和活動資訊。</p>
                                    <form class="quform newsletter" action="{{ url('/newsletter') }}" method="POST">
                                        @csrf
                                        <div class="quform-elements">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="quform-element mb-0">
                                                        <div class="quform-input">
                                                            <input class="form-control" id="email" type="email" name="email" placeholder="輸入您的電子郵件">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="quform-submit-inner">
                                                        <button class="btn btn-white text-primary m-0 px-2" type="submit"><i class="fas fa-paper-plane"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

    </div>

    <!-- start scroll to top -->
    <a href="#!" class="scroll-to-top"><i class="fas fa-angle-up" aria-hidden="true"></i></a>
    <!-- end scroll to top -->

    <!-- all js include start -->

    <!-- jQuery -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>

    <!-- popper js -->
    <script src="{{ asset('js/popper.min.js') }}"></script>

    <!-- bootstrap -->
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>

    <!-- jquery -->
    <script src="{{ asset('js/core.min.js') }}"></script>

    <!-- Search -->
    <script src="{{ asset('search/search.js') }}"></script>

    <!-- custom scripts -->
    <script src="{{ asset('js/main.js') }}"></script>

    <!-- form plugins js -->
    <script src="{{ asset('quform/js/plugins.js') }}"></script>

    <!-- form scripts js -->
    <script src="{{ asset('quform/js/scripts.js') }}"></script>

    <!-- all js include end -->
    
    @stack('scripts')
    
</body>

</html>