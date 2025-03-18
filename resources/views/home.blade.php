@extends('layouts.app')

@section('title', '首頁 - ' . config('app.name', '運動班長'))

@section('content')
<!-- BANNER
================================================== -->
<section class="p-0 main-banner">
    <div class="banner-slider">
        <div class="item">
            <div class="main-slider-content bg-img cover-background" data-overlay-dark="6" data-background="{{ asset('images/banner/banner1.jpg') }}">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-7 col-sm-12">
                            <h6 class="text-white">歡迎來到運動班長</h6>
                            <h1 class="text-white mb-3">專業運動訓練</h1>
                            <p class="text-white w-sm-95 w-md-90 mb-4">我們提供專業的運動訓練課程，幫助您提升運動技能，達到健康生活的目標。</p>
                            <div>
                                <a href="{{ url('/coaching') }}" class="butn primary me-4">
                                    <span>了解課程</span>
                                </a>
                                <a href="{{ url('/contact') }}" class="butn white">
                                    <span>聯絡我們</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ABOUT
================================================== -->
<section>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-2-3 mb-lg-0">
                <div class="pe-lg-1-6">
                    <h2 class="mb-3">關於我們</h2>
                    <p class="mb-4">運動班長成立於2010年，致力於提供高品質的運動訓練課程和專業指導。我們的教練團隊擁有豐富的教學經驗，能夠根據不同學員的需求制定合適的訓練計劃。</p>
                    <div class="row">
                        <div class="col-lg-6 mb-4 mb-lg-0">
                            <div class="d-flex align-items-center mb-4">
                                <div class="flex-shrink-0">
                                    <img src="{{ asset('images/icons/icon1.png') }}" alt="...">
                                </div>
                                <div class="flex-grow-1 ms-4">
                                    <h4 class="mb-0">專業教練</h4>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <img src="{{ asset('images/icons/icon2.png') }}" alt="...">
                                </div>
                                <div class="flex-grow-1 ms-4">
                                    <h4 class="mb-0">完善設備</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="d-flex align-items-center mb-4">
                                <div class="flex-shrink-0">
                                    <img src="{{ asset('images/icons/icon3.png') }}" alt="...">
                                </div>
                                <div class="flex-grow-1 ms-4">
                                    <h4 class="mb-0">科學訓練</h4>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <img src="{{ asset('images/icons/icon4.png') }}" alt="...">
                                </div>
                                <div class="flex-grow-1 ms-4">
                                    <h4 class="mb-0">個人指導</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="position-relative">
                    <div class="text-center">
                        <img src="{{ asset('images/about/about1.jpg') }}" class="border-radius-5" alt="...">
                        <a href="https://www.youtube.com/your-video-id" class="popup-social-video position-absolute top-50 start-50 translate-middle">
                            <i class="fas fa-play"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SERVICES
================================================== -->
<section class="bg-light">
    <div class="container">
        <div class="section-heading mb-2-3 mb-lg-2-9 wow fadeInDown" data-wow-delay=".2s">
            <h6 class="text-secondary"><span>我們的服務</span></h6>
            <h2 class="mb-0 h1">專業課程</h2>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-1-6 mb-md-1-9">
                <article class="card card-style1">
                    <div class="card-img">
                        <img src="{{ asset('images/services/service1.jpg') }}" alt="...">
                        <div class="card-img-overlay">
                            <div class="primary-overlay"></div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h3 class="h4 mb-3"><a href="{{ url('/coaching') }}">個人教練</a></h3>
                        <p class="mb-3">一對一專業指導，根據個人需求制定訓練計劃。</p>
                        <a href="{{ url('/coaching') }}" class="text-secondary text-primary-hover font-weight-600">
                            了解更多 <i class="ti-arrow-right ms-2 align-middle display-30"></i>
                        </a>
                    </div>
                </article>
            </div>
            <div class="col-lg-4 col-md-6 mb-1-6 mb-md-1-9">
                <article class="card card-style1">
                    <div class="card-img">
                        <img src="{{ asset('images/services/service2.jpg') }}" alt="...">
                        <div class="card-img-overlay">
                            <div class="primary-overlay"></div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h3 class="h4 mb-3"><a href="{{ url('/training') }}">團體課程</a></h3>
                        <p class="mb-3">專業團體訓練，激發運動樂趣，提升團隊精神。</p>
                        <a href="{{ url('/training') }}" class="text-secondary text-primary-hover font-weight-600">
                            了解更多 <i class="ti-arrow-right ms-2 align-middle display-30"></i>
                        </a>
                    </div>
                </article>
            </div>
            <div class="col-lg-4 col-md-6 mb-1-6 mb-md-1-9">
                <article class="card card-style1">
                    <div class="card-img">
                        <img src="{{ asset('images/services/service3.jpg') }}" alt="...">
                        <div class="card-img-overlay">
                            <div class="primary-overlay"></div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h3 class="h4 mb-3"><a href="{{ url('/membership') }}">會員制度</a></h3>
                        <p class="mb-3">專屬會員優惠，享受更多專業服務與設施。</p>
                        <a href="{{ url('/membership') }}" class="text-secondary text-primary-hover font-weight-600">
                            了解更多 <i class="ti-arrow-right ms-2 align-middle display-30"></i>
                        </a>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // 輪播設定
    $('.banner-slider').slick({
        dots: true,
        infinite: true,
        speed: 500,
        fade: true,
        cssEase: 'linear',
        autoplay: true,
        autoplaySpeed: 5000
    });
});
</script>
@endpush 