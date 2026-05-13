@extends('layouts.app')
@section('content')
    <style>
        .swiper-slide {
            height: auto;
            padding: 40px 0;
        }

        @media (min-width: 768px) {
            .swiper-slide {
                height: 500px;
            }
        }
    </style>

    <main>
        <section class="swiper-container js-swiper-slider swiper-number-pagination "
            data-settings='{
        "autoplay": {
          "delay": 5000
        },
        "slidesPerView": 1,
        "effect": "fade",
        "loop": true
      }'>

            <div class="swiper-wrapper">
                @foreach ($slides as $slide)
                    <div class="swiper-slide">
                        <div class="container h-100">
                            <div class="row align-items-center h-100">

                                <!-- النص -->
                                <div class="col-12 col-md-5 text-center text-md-start mb-3 mb-md-0">
                                    <h6 class="text_dash text-uppercase fs-base fw-medium">
                                        New Arrivals
                                    </h6>

                                    <h2 class="h2 fw-normal mb-0">
                                        {{ $slide->title }}
                                    </h2>

                                    <h2 class="h2 fw-bold">
                                        {{ $slide->subtitle }}
                                    </h2>

                                    <a href="{{ $slide->link }}" class="btn-link btn-link_lg default-underline fw-medium">
                                        Shop Now
                                    </a>
                                </div>

                                <!-- الصورة -->
                                <div class="col-12 col-md-7 text-center">
                                    <img src="{{ asset('uploads/slides') }}/{{ $slide->image }}" class="img-fluid w-100"
                                        style="max-height: 500px; object-fit: contain;">
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="container">
                <div
                    class="slideshow-pagination slideshow-number-pagination d-flex align-items-center position-absolute bottom-0 mb-5">
                </div>
            </div>
        </section>
        <div class="container mw-1620 bg-white border-radius-10">
            <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>
            <section class="category-carousel container">
                <h2 class="section-title text-center mb-3 pb-xl-2 mb-xl-4">Shop by Category</h2>

                <div class="position-relative">
                    <div class="swiper-container js-swiper-slider"
                        data-settings='{
              "autoplay": {
                "delay": 5000
              },
              "slidesPerView": 8,
              "slidesPerGroup": 1,
              "effect": "none",
              "loop": true,
              "navigation": {
                "nextEl": ".products-carousel__next-1",
                "prevEl": ".products-carousel__prev-1"
              },
              "breakpoints": {
                "320": {
                  "slidesPerView": 2,
                  "slidesPerGroup": 2,
                  "spaceBetween": 15
                },
                "768": {
                  "slidesPerView": 4,
                  "slidesPerGroup": 4,
                  "spaceBetween": 30
                },
                "992": {
                  "slidesPerView": 6,
                  "slidesPerGroup": 1,
                  "spaceBetween": 45,
                  "pagination": false
                },
                "1200": {
                  "slidesPerView": 8,
                  "slidesPerGroup": 1,
                  "spaceBetween": 60,
                  "pagination": false
                }
              }
            }'>
                        <div class="swiper-wrapper">
                            @foreach ($categories as $category)
                                <div class="swiper-slide">
                                    <img loading="lazy" class="w-100 h-auto mb-3"
                                        src="{{ asset('uploads/categorys') }}/{{ $category->image }}" width="124"
                                        height="124" alt="" />
                                    <div class="text-center"><a
                                            href="{{ route('shop.index', ['categories' => $category->id]) }}"
                                            class="menu-link fw-medium">
                                            {{ $category->name }}
                                        </a> </div>
                                </div>
                            @endforeach

                        </div><!-- /.swiper-wrapper -->
                    </div><!-- /.swiper-container js-swiper-slider -->

                    <div
                        class="products-carousel__prev products-carousel__prev-1 position-absolute top-50 d-flex align-items-center justify-content-center">
                        <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                            <use href="#icon_prev_md" />
                        </svg>
                    </div><!-- /.products-carousel__prev -->
                    <div
                        class="products-carousel__next products-carousel__next-1 position-absolute top-50 d-flex align-items-center justify-content-center">
                        <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                            <use href="#icon_next_md" />
                        </svg>
                    </div><!-- /.products-carousel__next -->
                </div><!-- /.position-relative -->
            </section>

            <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

            <section class="hot-deals container">
                <h2 class="section-title text-center mb-3 pb-xl-3 mb-xl-4">Hot Deals</h2>
                <div class="row">
                    <div
                        class="col-md-6 col-lg-4 col-xl-20per d-flex align-items-center flex-column justify-content-center py-4 align-items-md-start">
                        <h2>Summer Sale</h2>
                        <h2 class="fw-bold">Up to 60% Off</h2>

                        <div class="position-relative d-flex align-items-center text-center pt-xxl-4 js-countdown mb-3"
                            data-date="18-3-2024" data-time="06:50">
                            <div class="day countdown-unit">
                                <span class="countdown-num d-block"></span>
                                <span class="countdown-word text-uppercase text-secondary">Days</span>
                            </div>

                            <div class="hour countdown-unit">
                                <span class="countdown-num d-block"></span>
                                <span class="countdown-word text-uppercase text-secondary">Hours</span>
                            </div>

                            <div class="min countdown-unit">
                                <span class="countdown-num d-block"></span>
                                <span class="countdown-word text-uppercase text-secondary">Mins</span>
                            </div>

                            <div class="sec countdown-unit">
                                <span class="countdown-num d-block"></span>
                                <span class="countdown-word text-uppercase text-secondary">Sec</span>
                            </div>
                        </div>

                        <a href="{{ route('shop.index') }}"
                            class="btn-link default-underline text-uppercase fw-medium mt-3">View All</a>
                    </div>
                    <div class="col-md-6 col-lg-8 col-xl-80per">
                        <div class="position-relative">
                            <div class="swiper-container js-swiper-slider"
                                data-settings='{
                  "autoplay": {
                    "delay": 5000
                  },
                  "slidesPerView": 4,
                  "slidesPerGroup": 4,
                  "effect": "none",
                  "loop": false,
                  "breakpoints": {
                    "320": {
                      "slidesPerView": 2,
                      "slidesPerGroup": 2,
                      "spaceBetween": 14
                    },
                    "768": {
                      "slidesPerView": 2,
                      "slidesPerGroup": 3,
                      "spaceBetween": 24
                    },
                    "992": {
                      "slidesPerView": 3,
                      "slidesPerGroup": 1,
                      "spaceBetween": 30,
                      "pagination": false
                    },
                    "1200": {
                      "slidesPerView": 4,
                      "slidesPerGroup": 1,
                      "spaceBetween": 30,
                      "pagination": false
                    }
                  }
                }'>
                                <div class="swiper-wrapper">
                                    @foreach ($sproducts as $sproduct)
                                        <div class="swiper-slide product-card product-card_style3">
                                            <div class="pc__img-wrapper">
                                                <a href="{{ route('shop.product.details', ['slug' => $sproduct->slug]) }}">
                                                    <img loading="lazy"
                                                        src="{{ asset('uploads/products/thumbnails/' . $sproduct->image) }}"
                                                        width="258" height="313" alt="{{ $sproduct->name }}"
                                                        class="pc__img">

                                                </a>
                                            </div>

                                            <div class="pc__info position-relative">
                                                <h6 class="pc__title"><a
                                                        href="{{ route('shop.product.details', ['slug' => $sproduct->slug]) }}">{{ $sproduct->name }}</a>
                                                </h6>
                                                <div class="product-card__price d-flex">
                                                    <span class="money price text-secondary">
                                                        @if ($sproduct->discount_price)
                                                            <s>${{ $sproduct->regular_price }}</s>
                                                            ${{ $sproduct->sale_price }}
                                                        @else
                                                            ${{ $sproduct->regular_price }}
                                                        @endif
                                                    </span>
                                                </div>


                                            </div>
                                        </div>
                                    @endforeach

                                </div><!-- /.swiper-wrapper -->
                            </div><!-- /.swiper-container js-swiper-slider -->
                        </div><!-- /.position-relative -->
                    </div>
                </div>
            </section>

            <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

            <section class="category-banner container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="category-banner__item border-radius-10 mb-5">
                            <img loading="lazy" class="h-auto" src="{{ asset('2/2.png') }}"
                                width="690" height="665" alt="" />
                            {{-- <div class="category-banner__item-mark">
                                iPhone
                            </div> --}}
                            <div class="category-banner__item-content">
                                <h3 class="mb-0">iPhone</h3>
                                <a href="http://127.0.0.1:8000/shop?brands=20" class="btn-link default-underline text-uppercase fw-medium">Shop Now</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="category-banner__item border-radius-10 mb-5">
                        <img loading="lazy" class="" src="{{ asset('2/4.png') }}" width="690" height="680" alt="" />
                            {{-- <div class="category-banner__item-mark">
                                Samsung
                            </div> --}}
                            <div class="category-banner__item-content">
                                <h3 class="mb-0">Samsung</h3>
                                <a href="http://127.0.0.1:8000/shop?brands=21" class="btn-link default-underline text-uppercase fw-medium">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

            <section class="products-grid container">
                <h2 class="section-title text-center mb-3 pb-xl-3 mb-xl-4">Featured Products</h2>

                <div class="row">

                    @foreach ($fproducts as $fproduct)
                        <div class="col-6 col-md-4 col-lg-3">
                            <div class="product-card product-card_style3 mb-3 mb-md-4 mb-xxl-5">
                                <div class="pc__img-wrapper">
                                    <a href="{{ route('shop.product.details', ['slug' => $fproduct->slug]) }}">
                                        <img loading="lazy"
                                            src="{{ asset('uploads/products/thumbnails/' . $fproduct->image) }}"
                                            width="330" height="400" alt="{{ $fproduct->name }}" class="pc__img">
                                    </a>
                                </div>

                                <div class="pc__info position-relative">
                                    <h6 class="pc__title"><a href="details.html">{{ $fproduct->name }}</a></h6>
                                    <div class="product-card__price d-flex align-items-center">
                                        <span class="money price text-secondary">$ @if ($fproduct->discount_price)
                                                <s>${{ $fproduct->regular_price }}</s>
                                                ${{ $fproduct->sale_price }}
                                            @else
                                                ${{ $fproduct->regular_price }}
                                            @endif
                                        </span>
                                    </div>

                                    <div
                                        class="anim_appear-bottom position-absolute bottom-0 start-0 d-none d-sm-flex align-items-center bg-body">
                                        <button
                                            class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-add-cart js-open-aside"
                                            data-aside="cartDrawer" title="Add To Cart">Add To Cart</button>
                                        <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-quick-view"
                                            data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                            <span class="d-none d-xxl-block">Quick View</span>
                                            <span class="d-block d-xxl-none"><svg width="18" height="18"
                                                    viewBox="0 0 18 18" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <use href="#icon_view" />
                                                </svg></span>
                                        </button>
                                        <button class="pc__btn-wl bg-transparent border-0 js-add-wishlist"
                                            title="Add To Wishlist">
                                            <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_heart" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div><!-- /.row -->

                <div class="text-center mt-2">
                    <a class="btn-link btn-link_lg default-underline text-uppercase fw-medium" href="#">Load
                        More</a>
                </div>
            </section>
        </div>

        <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

    </main>
@endsection
