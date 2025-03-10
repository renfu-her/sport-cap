<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <title>@yield('title', config('app.name', 'Sport Cap'))</title>

  <!-- mobile responsive meta -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- ** Plugins Needed for the Project ** -->
  <!-- Bootstrap -->
  <link rel="stylesheet" href="{{ asset('plugins/bootstrap/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/themify-icons/themify-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/slick/slick.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/venobox/venobox.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/animate/animate.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/aos/aos.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/bootstrap-touchspin-master/jquery.bootstrap-touchspin.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/nice-select/nice-select.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/bootstrap-slider/bootstrap-slider.min.css') }}">

  <!-- Main Stylesheet -->
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">

  <!--Favicon-->
  <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon">
  <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon">

  @stack('styles')
</head>

<body>

  <!-- preloader start -->
  <div class="preloader">
    <img src="{{ asset('images/preloader.gif') }}" alt="preloader">
  </div>
  <!-- preloader end -->

<!-- header -->
<header>
  <!-- top header -->
  <div class="top-header">
    <div class="row">
      <div class="col-lg-6 text-center text-lg-left">
        <p class="text-white mb-lg-0 mb-1">免費送貨 • 30天免費退貨 • 快速配送</p>
      </div>
      <div class="col-lg-6 text-center text-lg-right">
        <ul class="list-inline">
          <li class="list-inline-item"><img src="{{ asset('images/flag.jpg') }}" alt="flag"></li>
          <li class="list-inline-item"><a href="{{ route('login') }}">我的帳戶</a></li>
          <li class="list-inline-item">
            <form action="#">
              <select class="country" name="country">
                <option value="TWD">TWD</option>
                <option value="USD">USD</option>
                <option value="JPY">JPY</option>
              </select>
            </form>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <!-- /top-header -->
</header>

<!-- navigation -->
<nav class="navbar navbar-expand-lg navbar-light bg-white w-100" id="navbar">
  <a class="navbar-brand order-2 order-lg-1" href="{{ url('/') }}"><img class="img-fluid" src="{{ asset('images/logo.png') }}" alt="logo"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse order-1 order-lg-2" id="navbarSupportedContent">
    <ul class="navbar-nav mx-auto">
      <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/') }}">首頁</a>
      </li>
      <li class="nav-item dropdown view {{ request()->is('shop*') ? 'active' : '' }}">
        <a class="nav-link dropdown-toggle" href="{{ url('/shop') }}" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          商店
        </a>
        <div class="dropdown-menu">
          <a class="dropdown-item" href="{{ url('/shop') }}">所有商品</a>
          <a class="dropdown-item" href="{{ url('/shop/categories') }}">商品分類</a>
          <a class="dropdown-item" href="{{ url('/cart') }}">購物車</a>
          <a class="dropdown-item" href="{{ url('/checkout') }}">結帳</a>
        </div>
      </li>
      <li class="nav-item {{ request()->is('about*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/about') }}">關於我們</a>
      </li>
      <li class="nav-item {{ request()->is('teaching-methods*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/teaching-methods') }}">教學方式</a>
      </li>
      <li class="nav-item {{ request()->is('training-camps*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/training-camps') }}">訓練營</a>
      </li>
      <li class="nav-item {{ request()->is('tournaments*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/tournaments') }}">比賽</a>
      </li>
      <li class="nav-item {{ request()->is('butler-services*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/butler-services') }}">管家服務</a>
      </li>
      <li class="nav-item {{ request()->is('contact*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/contact') }}">聯絡我們</a>
      </li>
    </ul>
  </div>
  <div class="order-3 navbar-right-elements">
    <div class="search-cart">
      <!-- search -->
      <div class="search">
        <button id="searchOpen" class="search-btn"><i class="ti-search"></i></button>
        <div class="search-wrapper">
          <form action="{{ url('/search') }}" method="GET">
            <input class="search-box" id="search" name="query" type="search" placeholder="輸入關鍵字...">
            <button class="search-icon" type="submit"><i class="ti-search"></i></button>
          </form>
        </div>
      </div>
      <!-- cart -->
      <div class="cart">
        <button id="cartOpen" class="cart-btn"><i class="ti-bag"></i><span class="d-xs-none">購物車</span> <span id="cart-count">0</span></button>
        <div class="cart-wrapper">
          <i id="cartClose" class="ti-close cart-close"></i>
          <h4 class="mb-4">您的購物車</h4>
          <div id="cart-items">
            <!-- 購物車項目將通過 JavaScript 動態加載 -->
          </div>
          <div class="mb-3">
            <span>購物車總計</span>
            <span class="float-right" id="cart-total">NT$0.00</span>
          </div>
          <div class="text-center">
            <a href="{{ url('/cart') }}" class="btn btn-dark btn-mobile rounded-0">查看購物車</a>
            <a href="{{ url('/checkout') }}" class="btn btn-dark btn-mobile rounded-0">結帳</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</nav>
<!-- /navigation -->

<!-- main wrapper -->
<div class="main-wrapper">
  @yield('content')

  <!-- service -->
  <section class="section-sm border-top">
    <div class="container">
      <div class="row">
        <!-- service item -->
        <div class="col-lg-3 col-sm-6 mb-4 mb-lg-0">
          <div class="d-flex flex-sm-row flex-column align-items-center align-items-sm-start">
            <i class="ti-truck icon-lg mr-4 mb-3 mb-sm-0"></i>
            <div class="text-center text-sm-left">
              <h4>免費送貨</h4>
              <p class="mb-0 text-gray">訂單滿 NT$2000 免運費</p>
            </div>
          </div>
        </div>
        <!-- service item -->
        <div class="col-lg-3 col-sm-6 mb-4 mb-lg-0">
          <div class="d-flex flex-sm-row flex-column align-items-center align-items-sm-start">
            <i class="ti-shield icon-lg mr-4 mb-3 mb-sm-0"></i>
            <div class="text-center text-sm-left">
              <h4>安全付款</h4>
              <p class="mb-0 text-gray">我們確保使用安全的付款方式</p>
            </div>
          </div>
        </div>
        <!-- service item -->
        <div class="col-lg-3 col-sm-6 mb-4 mb-lg-0">
          <div class="d-flex flex-sm-row flex-column align-items-center align-items-sm-start">
            <i class="ti-timer icon-lg mr-4 mb-3 mb-sm-0"></i>
            <div class="text-center text-sm-left">
              <h4>24/7 支援</h4>
              <p class="mb-0 text-gray">全天候客戶服務</p>
            </div>
          </div>
        </div>
        <!-- service item -->
        <div class="col-lg-3 col-sm-6 mb-4 mb-lg-0">
          <div class="d-flex flex-sm-row flex-column align-items-center align-items-sm-start">
            <i class="ti-reload icon-lg mr-4 mb-3 mb-sm-0"></i>
            <div class="text-center text-sm-left">
              <h4>30天退貨</h4>
              <p class="mb-0 text-gray">30天內可退換貨</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- /service -->

  <!-- newsletter -->
  <section class="section bg-gray">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <h2 class="section-title">訂閱電子報</h2>
          <p class="mb-4">訂閱我們的電子報，獲取最新優惠和活動資訊</p>
        </div>
        <div class="col-lg-6 col-md-8 col-sm-9 col-10 mx-auto">
          <form action="{{ url('/newsletter') }}" method="POST" class="d-flex flex-column flex-sm-row">
            @csrf
            <input type="email" name="email" class="form-control rounded-0 border-0 mr-3 mb-4 mb-sm-0" id="mail" placeholder="輸入您的電子郵件">
            <button type="submit" class="btn btn-primary">訂閱</button>
          </form>
        </div>
      </div>
    </div>
  </section>
  <!-- /newsletter -->

  <!-- footer -->
  <footer class="bg-light">
    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-3 col-sm-6 mb-5 mb-md-0 text-center text-sm-left">
            <h4 class="mb-4">聯絡我們</h4>
            <p>台北市信義區信義路五段7號</p>
            <p>+886 2 1234 5678</p>
            <p>info@sportcap.com</p>
            <ul class="list-inline social-icons">
              <li class="list-inline-item"><a href="#"><i class="ti-facebook"></i></a></li>
              <li class="list-inline-item"><a href="#"><i class="ti-instagram"></i></a></li>
              <li class="list-inline-item"><a href="#"><i class="ti-youtube"></i></a></li>
              <li class="list-inline-item"><a href="#"><i class="ti-twitter-alt"></i></a></li>
            </ul>
          </div>
          <div class="col-md-3 col-sm-6 mb-5 mb-md-0 text-center text-sm-left">
            <h4 class="mb-4">商品分類</h4>
            <ul class="pl-0 list-unstyled">
              <li class="mb-2"><a class="text-color" href="{{ url('/shop/categories/men') }}">男裝</a></li>
              <li class="mb-2"><a class="text-color" href="{{ url('/shop/categories/women') }}">女裝</a></li>
              <li class="mb-2"><a class="text-color" href="{{ url('/shop/categories/kids') }}">兒童</a></li>
              <li class="mb-2"><a class="text-color" href="{{ url('/shop/categories/accessories') }}">配件</a></li>
              <li class="mb-2"><a class="text-color" href="{{ url('/shop/categories/shoes') }}">鞋類</a></li>
            </ul>
          </div>
          <div class="col-md-3 col-sm-6 mb-5 mb-md-0 text-center text-sm-left">
            <h4 class="mb-4">實用連結</h4>
            <ul class="pl-0 list-unstyled">
              <li class="mb-2"><a class="text-color" href="{{ url('/about') }}">關於我們</a></li>
              <li class="mb-2"><a class="text-color" href="{{ url('/teaching-methods') }}">教學方式</a></li>
              <li class="mb-2"><a class="text-color" href="{{ url('/training-camps') }}">訓練營</a></li>
              <li class="mb-2"><a class="text-color" href="{{ url('/tournaments') }}">比賽</a></li>
              <li class="mb-2"><a class="text-color" href="{{ url('/contact') }}">聯絡我們</a></li>
            </ul>
          </div>
          <div class="col-md-3 col-sm-6 text-center text-sm-left">
            <h4 class="mb-4">我們的政策</h4>
            <ul class="pl-0 list-unstyled">
              <li class="mb-2"><a class="text-color" href="{{ url('/privacy-policy') }}">隱私政策</a></li>
              <li class="mb-2"><a class="text-color" href="{{ url('/terms-conditions') }}">條款和條件</a></li>
              <li class="mb-2"><a class="text-color" href="{{ url('/cookie-policy') }}">Cookie 政策</a></li>
              <li class="mb-2"><a class="text-color" href="{{ url('/terms-of-sale') }}">銷售條款</a></li>
              <li class="mb-2"><a class="text-color" href="{{ url('/shipping-returns') }}">運送和退貨</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="bg-dark py-4">
      <div class="container">
        <div class="row">
          <div class="col-md-5 text-center text-md-left mb-4 mb-md-0 align-self-center">
            <p class="text-white mb-0">Sport Cap &copy; {{ date('Y') }} 版權所有</p>
          </div>
          <div class="col-md-2 text-center text-md-left mb-4 mb-md-0">
            <img src="{{ asset('images/logo-alt.png') }}" alt="logo">
          </div>
          <div class="col-md-5 text-center text-md-right mb-4 mb-md-0">
            <ul class="list-inline">
              <li class="list-inline-item"><img class="img-fluid rounded atm-card-img" src="{{ asset('images/payment-card/card-1.jpg') }}" alt="card"></li>
              <li class="list-inline-item"><img class="img-fluid rounded atm-card-img" src="{{ asset('images/payment-card/card-2.jpg') }}" alt="card"></li>
              <li class="list-inline-item"><img class="img-fluid rounded atm-card-img" src="{{ asset('images/payment-card/card-3.jpg') }}" alt="card"></li>
              <li class="list-inline-item"><img class="img-fluid rounded atm-card-img" src="{{ asset('images/payment-card/card-4.jpg') }}" alt="card"></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <!-- /footer -->

</div>
<!-- /main wrapper -->

<!-- jQuery -->
<script src="{{ asset('plugins/jQuery/jquery.min.js') }}"></script>
<!-- Bootstrap JS -->
<script src="{{ asset('plugins/bootstrap/bootstrap.min.js') }}"></script>
<script src="{{ asset('plugins/slick/slick.min.js') }}"></script>
<script src="{{ asset('plugins/venobox/venobox.min.js') }}"></script>
<script src="{{ asset('plugins/aos/aos.js') }}"></script>
<script src="{{ asset('plugins/syotimer/jquery.syotimer.js') }}"></script>
<script src="{{ asset('plugins/instafeed/instafeed.min.js') }}"></script>
<script src="{{ asset('plugins/zoom-master/jquery.zoom.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap-touchspin-master/jquery.bootstrap-touchspin.min.js') }}"></script>
<script src="{{ asset('plugins/nice-select/jquery.nice-select.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap-slider/bootstrap-slider.min.js') }}"></script>
<!-- Main Script -->
<script src="{{ asset('js/script.js') }}"></script>

@stack('scripts')

</body>
</html> 