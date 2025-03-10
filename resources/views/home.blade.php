@extends('layouts.app')

@section('title', '首頁 - ' . config('app.name', 'Sport Cap'))

@section('content')
<!-- hero area -->
<section class="section bg-gray hero-area">
  <div class="container">
    <div class="hero-slider">
      
      <!-- 第一個輪播項目 -->
      <div class="slider-item">
        <div class="row">
          <div class="col-lg-6 align-self-center text-center text-md-left mb-4 mb-lg-0">
            <h3 data-duration-in=".5" data-animation-in="fadeInLeft" data-delay-in="0" data-animation-out="fadeOutLeft" data-delay-out="5" data-duration-out=".3">專業運動帽</h3>
            <!-- 標題 -->
            <h1 data-duration-in=".5" data-animation-in="fadeInLeft" data-delay-in=".2" data-animation-out="fadeOutLeft" data-delay-out="5" data-duration-out=".3">高品質運動帽</h1> 
            <!-- 副標題 -->
            <h3 class="mb-4" data-duration-in=".5" data-animation-in="fadeInLeft" data-delay-in=".4" data-animation-out="fadeOutLeft" data-delay-out="5" data-duration-out=".3">僅需 NT$590</h3>
            <!-- 描述 -->
            <p class="mb-4" data-duration-in=".5" data-animation-in="fadeInLeft" data-delay-in=".6" data-animation-out="fadeOutLeft" data-delay-out="5" data-duration-out=".3">我們提供最高品質的運動帽，適合各種運動場合，舒適透氣，時尚耐用。</p>
            <!-- 按鈕 -->
            <a href="{{ url('/shop') }}" class="btn btn-primary" data-duration-in=".5" data-animation-in="fadeInLeft" data-delay-in=".8" data-animation-out="fadeOutLeft" data-delay-out="5" data-duration-out=".3">立即購買</a>
          </div>
          <!-- 輪播圖片 -->
          <div class="col-lg-6 text-center text-md-left">
            <!-- 背景字母 -->
            <div class="bg-letter">
              <span data-duration-in=".5" data-animation-in="fadeInRight" data-delay-in="1.2" data-animation-out="fadeOutRight" data-delay-out="5" data-duration-out=".3">
                S 
              </span>
              <!-- 輪播圖片 -->
              <img class="img-fluid d-unset" src="{{ asset('images/hero-area/cap1.png') }}" alt="cap" data-duration-in=".5" data-animation-in="fadeInRight" data-delay-in="1" data-animation-out="fadeOutRight" data-delay-out="5" data-duration-out=".3">
            </div>
          </div>
        </div>
      </div> <!-- 輪播項目結束 -->

      <!-- 第二個輪播項目 -->
      <div class="slider-item">
        <div class="row">
          <div class="col-lg-6 align-self-center text-center text-md-left mb-4 mb-lg-0">
            <h3 data-duration-in=".5" data-animation-in="fadeInDown" data-delay-in="0" data-animation-out="fadeOutDown" data-delay-out="5.8" data-duration-out=".3">專業教練團隊</h3>
            <h1 data-duration-in=".5" data-animation-in="fadeInDown" data-delay-in=".2" data-animation-out="fadeOutDown" data-delay-out="5.4" data-duration-out=".3">專業訓練課程</h1>
            <h3 class="mb-4" data-duration-in=".5" data-animation-in="fadeInDown" data-delay-in=".4" data-animation-out="fadeOutDown" data-delay-out="5" data-duration-out=".3">立即報名享優惠</h3>
            <p class="mb-4" data-duration-in=".5" data-animation-in="fadeInDown" data-delay-in=".6" data-animation-out="fadeOutDown" data-delay-out="4.6" data-duration-out=".3">我們提供專業的運動訓練課程，由經驗豐富的教練團隊指導，幫助您提升運動技能。</p>
            <a href="{{ url('/teaching-methods') }}" class="btn btn-primary" data-duration-in=".5" data-animation-in="fadeInDown" data-delay-in=".8" data-animation-out="fadeOutDown" data-delay-out="4.2" data-duration-out=".3">了解更多</a>
          </div>
          <div class="col-lg-6 text-center">
            <div class="bg-letter">
              <!-- 背景字母 -->
              <span data-duration-in=".5" data-animation-in="fadeInRight" data-delay-in="1.2" data-animation-out="fadeOutRight" data-delay-out="5" data-duration-out=".3">
                T
              </span>
              <img class="img-fluid d-unset" src="{{ asset('images/hero-area/training.png') }}" alt="training" data-duration-in=".5" data-animation-in="fadeInRight" data-delay-in="1" data-animation-out="fadeOutRight" data-delay-out="5" data-duration-out=".3">
            </div>
          </div>
        </div>
      </div> 
      <!-- 輪播項目結束 -->

    </div>
  </div>
</section>
<!-- /hero area -->

<!-- 分類 -->
<section class="section">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-12 text-center">
        <h2 class="section-title">熱門分類</h2>
      </div>
      <!-- 分類項目 -->
      <div class="col-lg-4 col-md-6 mb-50">
        <div class="card p-0">
          <div class="border-bottom text-center hover-zoom-img">
            <a href="{{ url('/shop/categories/caps') }}"><img src="{{ asset('images/categories/caps-big.jpg') }}" class="rounded-top img-fluid w-100" alt="caps"></a>
          </div>
          <ul class="d-flex list-unstyled pl-0 categories-list">
            <li class="m-0 hover-zoom-img">
              <a href="{{ url('/shop/categories/caps/baseball') }}"><img src="{{ asset('images/categories/baseball-cap.jpg') }}" class="img-fluid w-100" alt="baseball-cap"></a>
            </li>
            <li class="m-0 hover-zoom-img">
              <a href="{{ url('/shop/categories/caps/snapback') }}"><img src="{{ asset('images/categories/snapback-cap.jpg') }}" class="img-fluid w-100" alt="snapback-cap"></a>
            </li>
            <li class="m-0 hover-zoom-img">
              <a href="{{ url('/shop/categories/caps/fitted') }}"><img src="{{ asset('images/categories/fitted-cap.jpg') }}" class="img-fluid w-100" alt="fitted-cap"></a>
            </li>
          </ul>
          <div class="px-4 py-3 border-top">
            <h4 class="d-inline-block mb-0 mt-1">運動帽</h4>
            <a href="{{ url('/shop/categories/caps') }}" class="btn btn-sm btn-outline-primary float-right">查看更多</a>
          </div>
        </div>
      </div>
      <!-- 分類項目 -->
      <div class="col-lg-4 col-md-6 mb-50">
        <div class="card p-0">
          <div class="border-bottom text-center hover-zoom-img">
            <a href="{{ url('/shop/categories/apparel') }}"><img src="{{ asset('images/categories/apparel-big.jpg') }}" class="rounded-top img-fluid w-100" alt="apparel"></a>
          </div>
          <ul class="d-flex list-unstyled pl-0 categories-list">
            <li class="m-0 hover-zoom-img">
              <a href="{{ url('/shop/categories/apparel/shirts') }}"><img src="{{ asset('images/categories/shirt.jpg') }}" class="img-fluid w-100" alt="shirt"></a>
            </li>
            <li class="m-0 hover-zoom-img">
              <a href="{{ url('/shop/categories/apparel/pants') }}"><img src="{{ asset('images/categories/pants.jpg') }}" class="img-fluid w-100" alt="pants"></a>
            </li>
            <li class="m-0 hover-zoom-img">
              <a href="{{ url('/shop/categories/apparel/jackets') }}"><img src="{{ asset('images/categories/jacket.jpg') }}" class="img-fluid w-100" alt="jacket"></a>
            </li>
          </ul>
          <div class="px-4 py-3 border-top">
            <h4 class="d-inline-block mb-0 mt-1">運動服飾</h4>
            <a href="{{ url('/shop/categories/apparel') }}" class="btn btn-sm btn-outline-primary float-right">查看更多</a>
          </div>
        </div>
      </div>
      <!-- 分類項目 -->
      <div class="col-lg-4 col-md-6 mb-50">
        <div class="card p-0">
          <div class="border-bottom text-center hover-zoom-img">
            <a href="{{ url('/shop/categories/accessories') }}"><img src="{{ asset('images/categories/accessories-big.jpg') }}" class="rounded-top img-fluid w-100" alt="accessories"></a>
          </div>
          <ul class="d-flex list-unstyled pl-0 categories-list">
            <li class="m-0 hover-zoom-img">
              <a href="{{ url('/shop/categories/accessories/bags') }}"><img src="{{ asset('images/categories/bag.jpg') }}" class="img-fluid w-100" alt="bag"></a>
            </li>
            <li class="m-0 hover-zoom-img">
              <a href="{{ url('/shop/categories/accessories/wristbands') }}"><img src="{{ asset('images/categories/wristband.jpg') }}" class="img-fluid w-100" alt="wristband"></a>
            </li>
            <li class="m-0 hover-zoom-img">
              <a href="{{ url('/shop/categories/accessories/bottles') }}"><img src="{{ asset('images/categories/bottle.jpg') }}" class="img-fluid w-100" alt="bottle"></a>
            </li>
          </ul>
          <div class="px-4 py-3 border-top">
            <h4 class="d-inline-block mb-0 mt-1">運動配件</h4>
            <a href="{{ url('/shop/categories/accessories') }}" class="btn btn-sm btn-outline-primary float-right">查看更多</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- /分類 -->

<!-- 促銷區塊 -->
<section class="section overlay cta" data-background="{{ asset('images/backgrounds/cta.jpg') }}">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 text-center">
        <h1 class="text-white mb-2">季末特賣</h1>
        <p class="text-white mb-4">所有運動帽和配件享有 25% 折扣，結帳時自動套用。</p>
        <a href="{{ url('/shop') }}" class="btn btn-light">立即購買</a>
      </div>
    </div>
  </div>
</section>
<!-- /促銷區塊 -->

<!-- 熱門商品 -->
<section class="section">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 text-center">
        <h2 class="section-title">熱門商品</h2>
      </div>
      <div class="col-12">
        <div class="collection-slider">
          <!-- 商品 -->
          <div class="col-lg-4 col-sm-6">
            <div class="product text-center">
              <div class="product-thumb">
                <div class="overflow-hidden position-relative">
                  <a href="{{ url('/shop/product/1') }}">
                    <img class="img-fluid w-100 mb-3 img-first" src="{{ asset('images/collection/product-1.jpg') }}" alt="product-img">
                    <img class="img-fluid w-100 mb-3 img-second" src="{{ asset('images/collection/product-4.jpg') }}" alt="product-img">
                  </a>
                  <div class="btn-cart">
                    <a href="#" class="btn btn-primary btn-sm add-to-cart" data-product-id="1">加入購物車</a>
                  </div>
                </div>
                <div class="product-hover-overlay">
                  <a href="#" class="product-icon favorite" data-toggle="tooltip" data-placement="left" title="收藏"><i class="ti-heart"></i></a>
                  <a href="#" class="product-icon cart" data-toggle="tooltip" data-placement="left" title="比較"><i class="ti-direction-alt"></i></a>
                  <a data-vbtype="inline" href="#quickView" class="product-icon view venobox" data-toggle="tooltip" data-placement="left" title="快速查看"><i class="ti-search"></i></a>
                </div>
              </div>
              <div class="product-info">
                <h3 class="h5"><a class="text-color" href="{{ url('/shop/product/1') }}">經典棒球帽</a></h3>
                <span class="h5">NT$590</span>
              </div>
            </div>
          </div>
          <!-- //商品結束 -->
          
          <!-- 商品 -->
          <div class="col-lg-4 col-sm-6">
            <div class="product text-center">
              <div class="product-thumb">
                <div class="overflow-hidden position-relative">
                  <a href="{{ url('/shop/product/2') }}">
                    <img class="img-fluid w-100 mb-3 img-first" src="{{ asset('images/collection/product-2.jpg') }}" alt="product-img">
                    <img class="img-fluid w-100 mb-3 img-second" src="{{ asset('images/collection/product-5.jpg') }}" alt="product-img">
                  </a>
                  <div class="btn-cart">
                    <a href="#" class="btn btn-primary btn-sm add-to-cart" data-product-id="2">加入購物車</a>
                  </div>
                </div>
                <div class="product-hover-overlay">
                  <a href="#" class="product-icon favorite" data-toggle="tooltip" data-placement="left" title="收藏"><i class="ti-heart"></i></a>
                  <a href="#" class="product-icon cart" data-toggle="tooltip" data-placement="left" title="比較"><i class="ti-direction-alt"></i></a>
                  <a data-vbtype="inline" href="#quickView" class="product-icon view venobox" data-toggle="tooltip" data-placement="left" title="快速查看"><i class="ti-search"></i></a>
                </div>
              </div>
              <div class="product-info">
                <h3 class="h5"><a class="text-color" href="{{ url('/shop/product/2') }}">運動背包</a></h3>
                <span class="h5">NT$1,290</span>
              </div>
              <!-- 商品標籤 -->
              <div class="product-label new">
                新品
              </div>
            </div>
          </div>
          <!-- //商品結束 -->
          
          <!-- 商品 -->
          <div class="col-lg-4 col-sm-6">
            <div class="product text-center">
              <div class="product-thumb">
                <div class="overflow-hidden position-relative">
                  <a href="{{ url('/shop/product/3') }}">
                    <img class="img-fluid w-100 mb-3 img-first" src="{{ asset('images/collection/product-3.jpg') }}" alt="product-img">
                    <img class="img-fluid w-100 mb-3 img-second" src="{{ asset('images/collection/product-6.jpg') }}" alt="product-img">
                  </a>
                  <div class="btn-cart">
                    <a href="#" class="btn btn-primary btn-sm add-to-cart" data-product-id="3">加入購物車</a>
                  </div>
                </div>
                <div class="product-hover-overlay">
                  <a href="#" class="product-icon favorite" data-toggle="tooltip" data-placement="left" title="收藏"><i class="ti-heart"></i></a>
                  <a href="#" class="product-icon cart" data-toggle="tooltip" data-placement="left" title="比較"><i class="ti-direction-alt"></i></a>
                  <a data-vbtype="inline" href="#quickView" class="product-icon view venobox" data-toggle="tooltip" data-placement="left" title="快速查看"><i class="ti-search"></i></a>
                </div>
              </div>
              <div class="product-info">
                <h3 class="h5"><a class="text-color" href="{{ url('/shop/product/3') }}">運動鞋</a></h3>
                <span class="h5">NT$2,490</span>
              </div>
            </div>
          </div>
          <!-- //商品結束 -->
          
          <!-- 商品 -->
          <div class="col-lg-4 col-sm-6">
            <div class="product text-center">
              <div class="product-thumb">
                <div class="overflow-hidden position-relative">
                  <a href="{{ url('/shop/product/4') }}">
                    <img class="img-fluid w-100 mb-3 img-first" src="{{ asset('images/collection/product-4.jpg') }}" alt="product-img">
                    <img class="img-fluid w-100 mb-3 img-second" src="{{ asset('images/collection/product-2.jpg') }}" alt="product-img">
                  </a>
                  <div class="btn-cart">
                    <a href="#" class="btn btn-primary btn-sm add-to-cart" data-product-id="4">加入購物車</a>
                  </div>
                </div>
                <div class="product-hover-overlay">
                  <a href="#" class="product-icon favorite" data-toggle="tooltip" data-placement="left" title="收藏"><i class="ti-heart"></i></a>
                  <a href="#" class="product-icon cart" data-toggle="tooltip" data-placement="left" title="比較"><i class="ti-direction-alt"></i></a>
                  <a data-vbtype="inline" href="#quickView" class="product-icon view venobox" data-toggle="tooltip" data-placement="left" title="快速查看"><i class="ti-search"></i></a>
                </div>
              </div>
              <div class="product-info">
                <h3 class="h5"><a class="text-color" href="{{ url('/shop/product/4') }}">運動T恤</a></h3>
                <span class="h5">NT$790</span>
              </div>
              <!-- 商品標籤 -->
              <div class="product-label sale">
                -10%
              </div>
            </div>
          </div>
          <!-- //商品結束 -->
        </div>
      </div>
    </div>
  </div>
</section>
<!-- /熱門商品 -->

<!-- 每日特惠 -->
<section class="section bg-cover" data-background="{{ asset('images/backgrounds/deal.jpg') }}">
  <div class="container">
    <div class="row">
      <div class="col-md-6 text-center text-md-left mb-4 mb-md-0">
        <h1>每日特惠</h1>
        <h4 class="mb-40">限時優惠價！</h4>
        <!-- 倒數計時器 -->
        <div class="syotimer large">
          <div id="simple-timer" data-year="{{ date('Y') }}" data-month="{{ date('m') }}" data-day="{{ date('d', strtotime('+1 day')) }}" data-hour="0"></div>
        </div>
        <a href="{{ url('/shop') }}" class="btn btn-primary">立即購買</a>
      </div>
      <div class="col-md-6 text-center text-md-left align-self-center">
        <img src="{{ asset('images/deal/product.png') }}" alt="product-img" class="img-fluid up-down">
      </div>
    </div>
  </div>
</section>
<!-- /每日特惠 -->

<!-- 快速查看彈窗 -->
<div id="quickView" class="quickview">
  <div class="row w-100">
    <div class="col-lg-6 col-md-6 mb-5 mb-md-0 pl-5 pt-4 pt-lg-0 pl-lg-0">
      <img src="{{ asset('images/feature/product.png') }}" alt="product-img" class="img-fluid">
    </div>
    <div class="col-lg-5 col-md-6 text-center text-md-left align-self-center pl-5">
      <h3 class="mb-lg-2 mb-2">經典棒球帽</h3>
      <span class="mb-lg-4 mb-3 h5">NT$590</span>
      <p class="mb-lg-4 mb-3 text-gray">高品質運動帽，適合各種運動場合，舒適透氣，時尚耐用。</p>
      <form action="#">
        <select class="form-control w-100 mb-2" name="color">
          <option value="black">黑色</option>
          <option value="blue">藍色</option>
          <option value="red">紅色</option>
        </select>
        <select class="form-control w-100 mb-3" name="size">
          <option value="s">S 尺寸</option>
          <option value="m">M 尺寸</option>
          <option value="l">L 尺寸</option>
        </select>
        <button class="btn btn-primary w-100 mb-lg-4 mb-3">加入購物車</button>
      </form>
      <ul class="list-inline social-icon-alt">
        <li class="list-inline-item"><a href="#"><i class="ti-facebook"></i></a></li>
        <li class="list-inline-item"><a href="#"><i class="ti-twitter-alt"></i></a></li>
        <li class="list-inline-item"><a href="#"><i class="ti-instagram"></i></a></li>
        <li class="list-inline-item"><a href="#"><i class="ti-youtube"></i></a></li>
      </ul>
    </div>
  </div>
</div>
<!-- /快速查看彈窗 -->

@endsection

@push('scripts')
<script>
  $(document).ready(function() {
    // 加入購物車功能
    $('.add-to-cart').on('click', function(e) {
      e.preventDefault();
      const productId = $(this).data('product-id');
      
      // 這裡可以添加 AJAX 請求來加入購物車
      // $.ajax({
      //   url: '/cart/add',
      //   method: 'POST',
      //   data: {
      //     product_id: productId,
      //     quantity: 1,
      //     _token: '{{ csrf_token() }}'
      //   },
      //   success: function(response) {
      //     // 更新購物車計數
      //     $('#cart-count').text(response.cart_count);
      //     // 顯示成功訊息
      //     alert('商品已加入購物車');
      //   },
      //   error: function() {
      //     alert('加入購物車失敗，請稍後再試');
      //   }
      // });
      
      // 暫時使用模擬功能
      alert('商品已加入購物車');
      const currentCount = parseInt($('#cart-count').text()) || 0;
      $('#cart-count').text(currentCount + 1);
    });
  });
</script>
@endpush 