@extends('Template::layouts.master')
@section('content')

{{-- Hero Slider with Auto-play --}}
<section class="tw-relative tw-h-96 lg:tw-h-[500px] tw-overflow-hidden">
    <div id="heroSlider" class="tw-relative tw-h-full">
        @php
        $heroSlides = [
            [
                'title' => 'Supermarché en Ligne de Côte d\'Ivoire',
                'subtitle' => 'Produits frais livrés à votre porte',
                'cta' => 'Acheter maintenant',
                'gradient' => 'tw-from-orange-600 tw-via-orange-500 tw-to-green-600'
            ],
            [
                'title' => 'Promo Flash du Weekend',
                'subtitle' => 'Jusqu\'à -40% sur les produits frais',
                'cta' => 'Voir les offres',
                'gradient' => 'tw-from-green-700 tw-via-green-500 tw-to-orange-400'
            ],
            [
                'title' => 'Nouveaux Arrivages',
                'subtitle' => 'Poisson frais et viande de qualité',
                'cta' => 'Découvrir',
                'gradient' => 'tw-from-green-800 tw-via-orange-600 tw-to-yellow-500'
            ]
        ];
        @endphp

        @foreach($heroSlides as $index => $slide)
        <div class="hero-slide {{ $index === 0 ? 'active' : '' }} tw-absolute tw-inset-0 tw-bg-gradient-to-r {{ $slide['gradient'] }} tw-transition-opacity tw-duration-500"
            style="opacity: {{ $index === 0 ? '1' : '0' }}">
            <div class="tw-max-w-7xl tw-mx-auto tw-px-4 tw-h-full tw-flex tw-items-center">
                <div class="tw-grid tw-grid-cols-1 lg:tw-grid-cols-2 tw-gap-8 tw-items-center tw-w-full">
                    <div class="tw-text-white tw-space-y-6">
                        <h1 class="tw-text-3xl md:tw-text-4xl lg:tw-text-6xl tw-font-bold tw-leading-tight">
                            {{ $slide['title'] }}
                        </h1>
                        <p class="tw-text-lg md:tw-text-xl lg:tw-text-2xl tw-opacity-90">
                            {{ $slide['subtitle'] }}
                        </p>
                        <a href="{{ route('product.all') }}"
                            class="tw-inline-block tw-bg-white tw-text-orange-600 tw-px-8 tw-py-4 tw-rounded-full tw-font-bold tw-text-lg hover:tw-bg-orange-50 tw-transition-colors tw-shadow-lg tw-no-underline">
                            {{ $slide['cta'] }}
                        </a>
                    </div>
                    @if($banners->count() > 0 && $index === 0)
                    <div class="tw-hidden lg:tw-block">
                        <img src="{{ getImage(getFilePath('promotionalBanner') . '/' . $banners->first()->image) }}"
                            alt="Hero" class="tw-w-full tw-h-80 tw-object-cover tw-rounded-2xl tw-shadow-2xl">
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach

        {{-- Dots Navigation --}}
        <div class="tw-absolute tw-bottom-6 tw-left-1/2 tw-transform tw--translate-x-1/2 tw-flex tw-gap-2 tw-z-10">
            @foreach($heroSlides as $index => $slide)
            <button onclick="goToSlide({{ $index }})"
                class="hero-dot tw-w-3 tw-h-3 tw-rounded-full tw-transition-colors {{ $index === 0 ? 'tw-bg-white' : 'tw-bg-white/50' }}"></button>
            @endforeach
        </div>
    </div>
</section>

{{-- Stats Bar --}}
<div class="tw-bg-white tw-py-6 tw-border-b tw-border-gray-100">
    <div class="tw-max-w-7xl tw-mx-auto tw-px-4">
        <div class="tw-grid tw-grid-cols-2 lg:tw-grid-cols-4 tw-gap-4">
            @foreach([
                ['icon' => 'la-truck', 'label' => __('Livraison gratuite'), 'value' => __('dès 10 000 FCFA')],
                ['icon' => 'la-shield-alt', 'label' => __('Paiement sécurisé'), 'value' => __('100% garanti')],
                ['icon' => 'la-undo-alt', 'label' => __('Retour facile'), 'value' => __('sous 30 jours')],
                ['icon' => 'la-headset', 'label' => __('Support 24/7'), 'value' => __('toujours disponible')],
            ] as $stat)
            <div class="tw-flex tw-items-center tw-gap-3 tw-text-gray-700">
                <div class="tw-w-10 tw-h-10 tw-bg-orange-100 tw-rounded-full tw-flex tw-items-center tw-justify-center tw-text-orange-600">
                    <i class="las {{ $stat['icon'] }} tw-text-xl"></i>
                </div>
                <div>
                    <div class="tw-font-semibold tw-text-sm">{{ $stat['label'] }}</div>
                    <div class="tw-text-xs tw-text-gray-500">{{ $stat['value'] }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Categories --}}
@if($parentCategories->count() > 0)
<section class="tw-py-12 tw-bg-white">
    <div class="tw-max-w-7xl tw-mx-auto tw-px-4">
        <h2 class="tw-text-2xl lg:tw-text-3xl tw-font-bold tw-text-center tw-mb-8">@lang('Explorez nos rayons')</h2>
        <div class="tw-grid tw-grid-cols-2 md:tw-grid-cols-4 lg:tw-grid-cols-5 tw-gap-4">
            @foreach($parentCategories->take(10) as $category)
            <a href="{{ route('product.by.category', $category->slug) }}"
                class="tw-p-6 tw-rounded-xl tw-shadow-sm tw-border tw-border-gray-100 hover:tw-shadow-md hover:tw-scale-105 tw-transition-all tw-text-center tw-bg-gradient-to-br tw-from-orange-50 tw-to-green-50 tw-no-underline tw-text-gray-800">
                @if($category->image)
                <img src="{{ getImage(getFilePath('category') . '/' . $category->image, getFileSize('category')) }}"
                    alt="{{ $category->name }}" class="tw-w-16 tw-h-16 tw-object-cover tw-rounded-full tw-mx-auto tw-mb-2">
                @else
                <div class="tw-text-4xl tw-mb-2">🛍️</div>
                @endif
                <div class="tw-font-semibold">{{ __($category->name) }}</div>
                <div class="tw-text-xs tw-text-gray-500">{{ $category->products->count() }} @lang('produits')</div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Flash Deals / Promotions du jour --}}
@if($offers->count() > 0)
@php
$firstOffer = $offers->first();
$offerProducts = $firstOffer->products()->with('brand')->where('is_published', 1)->take(8)->get();
@endphp
<section class="tw-py-12 tw-bg-gray-50">
    <div class="tw-max-w-7xl tw-mx-auto tw-px-4">
        <div class="tw-flex tw-flex-col lg:tw-flex-row tw-items-start lg:tw-items-center tw-justify-between tw-gap-4 tw-mb-8">
            <div>
                <h2 class="tw-text-2xl lg:tw-text-3xl tw-font-bold">@lang('Promotions du jour')</h2>
                <p class="tw-text-gray-600 tw-mt-2 tw-max-w-2xl">@lang('Des offres exclusives sur vos produits frais et indispensables du quotidien.')</p>
            </div>
            @if($firstOffer->show_countdown && $firstOffer->ends_at)
            <div class="tw-flex tw-items-center tw-gap-2 tw-bg-red-100 tw-px-4 tw-py-2 tw-rounded-full">
                <i class="las la-bolt tw-text-red-600"></i>
                <span class="tw-text-red-600 tw-font-bold tw-text-sm" id="countdown-timer">
                    @lang('Chargement...')
                </span>
            </div>
            @endif
        </div>

        {{-- Flash Deals Carousel --}}
        <div class="tw-relative">
            <div class="tw-overflow-hidden" id="flashDealsCarousel">
                <div class="tw-flex tw-transition-transform tw-duration-500 tw-ease-in-out" id="flashDealsSlider">
                    @foreach($offerProducts as $product)
                    <div class="tw-flex-none tw-w-full md:tw-w-1/2 lg:tw-w-1/3 xl:tw-w-1/4 tw-px-2">
                        <div class="tw-bg-white tw-rounded-xl tw-shadow-sm tw-border tw-border-gray-100 tw-overflow-hidden hover:tw--translate-y-1 tw-transition-transform">
                            <div class="tw-relative">
                                <img src="{{ $product->mainImage() }}" alt="{{ $product->name }}"
                                    class="tw-w-full tw-h-48 tw-object-cover">
                                @if($firstOffer->discount_type == 1)
                                <div class="tw-absolute tw-top-3 tw-left-3 tw-bg-red-500 tw-text-white tw-px-2 tw-py-1 tw-rounded tw-text-xs tw-font-bold">
                                    -{{ number_format((($product->regular_price - $product->salePrice()) / $product->regular_price) * 100, 0) }}%
                                </div>
                                @endif
                            </div>
                            <div class="tw-p-4">
                                <h3 class="tw-font-semibold tw-mb-2 tw-line-clamp-2">{{ $product->name }}</h3>
                                <div class="tw-flex tw-items-center tw-gap-2 tw-mb-3">
                                    <span class="tw-text-base md:tw-text-lg tw-font-bold tw-text-orange-600">
                                        {{ showAmount($product->salePrice()) }}
                                    </span>
                                    @if($product->salePrice() < $product->regular_price)
                                    <span class="tw-text-xs md:tw-text-sm tw-text-gray-400 tw-line-through">
                                        {{ showAmount($product->regular_price) }}
                                    </span>
                                    @endif
                                </div>
                                <button type="button" data-product-id="{{ $product->id }}"
                                    class="addToCart tw-w-full tw-bg-orange-500 tw-text-white tw-py-2 tw-rounded-lg hover:tw-bg-orange-600 tw-transition-colors tw-font-medium tw-border-0 tw-cursor-pointer">
                                    @lang('Ajouter au panier')
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Carousel Navigation --}}
            @if($offerProducts->count() > 4)
            <button onclick="prevFlashDeal()"
                class="tw-absolute tw-left-0 tw-top-1/2 tw--translate-y-1/2 tw-bg-white tw-shadow-lg tw-rounded-full tw-p-2 hover:tw-bg-gray-50 tw-transition-colors tw-z-10 tw-border-0 tw-cursor-pointer">
                <i class="las la-angle-left tw-text-2xl tw-text-gray-700"></i>
            </button>
            <button onclick="nextFlashDeal()"
                class="tw-absolute tw-right-0 tw-top-1/2 tw--translate-y-1/2 tw-bg-white tw-shadow-lg tw-rounded-full tw-p-2 hover:tw-bg-gray-50 tw-transition-colors tw-z-10 tw-border-0 tw-cursor-pointer">
                <i class="las la-angle-right tw-text-2xl tw-text-gray-700"></i>
            </button>
            @endif
        </div>
    </div>
</section>
@endif

{{-- Featured Products --}}
@if($featuredProducts->count() > 0)
<section class="tw-py-12 tw-bg-white">
    <div class="tw-max-w-7xl tw-mx-auto tw-px-4">
        <div class="tw-flex tw-items-center tw-justify-between tw-mb-8">
            <div>
                <h2 class="tw-text-2xl lg:tw-text-3xl tw-font-bold">@lang('Nos produits phares')</h2>
                <p class="tw-text-gray-600 tw-mt-1">@lang('Découvrez notre sélection de produits de qualité')</p>
            </div>
            <a href="{{ route('product.all') }}"
                class="tw-px-6 tw-py-2 tw-border tw-border-orange-500 tw-text-orange-500 tw-rounded-lg hover:tw-bg-orange-500 hover:tw-text-white tw-transition-colors tw-font-medium tw-no-underline">
                @lang('Voir tout') →
            </a>
        </div>
        <div class="tw-grid tw-grid-cols-2 md:tw-grid-cols-3 lg:tw-grid-cols-4 tw-gap-4">
            @foreach($featuredProducts as $product)
            @include('Template::partials.etsmory_product_card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Features Bar --}}
<div class="tw-bg-gradient-to-r tw-from-green-50 tw-to-orange-50 tw-py-12">
    <div class="tw-max-w-7xl tw-mx-auto tw-px-4 tw-text-center">
        <h2 class="tw-text-2xl lg:tw-text-3xl tw-font-bold tw-text-gray-800 tw-mb-8">@lang('Pourquoi choisir EtsMory ?')</h2>
        <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-3 tw-gap-6">
            @foreach([
                ['icon' => 'la-truck', 'color' => 'tw-bg-green-100 tw-text-green-600', 'title' => __('Livraison rapide'), 'desc' => __('Livraison à domicile en moins de 2h dans Abidjan')],
                ['icon' => 'la-shield-alt', 'color' => 'tw-bg-orange-100 tw-text-orange-600', 'title' => __('Produits frais'), 'desc' => __('Sélection rigoureuse de produits locaux et importés')],
                ['icon' => 'la-headset', 'color' => 'tw-bg-green-100 tw-text-green-600', 'title' => __('Service client'), 'desc' => __('Support disponible 7j/7 pour vos questions')],
            ] as $feature)
            <div class="tw-bg-white tw-p-6 tw-rounded-xl tw-shadow-sm">
                <div class="tw-w-16 tw-h-16 {{ $feature['color'] }} tw-rounded-full tw-flex tw-items-center tw-justify-center tw-mx-auto tw-mb-4">
                    <i class="las {{ $feature['icon'] }} tw-text-3xl"></i>
                </div>
                <h3 class="tw-font-bold tw-text-lg tw-mb-2">{{ $feature['title'] }}</h3>
                <p class="tw-text-gray-600">{{ $feature['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Top Selling --}}
@if($topSelling->count() > 0)
<section class="tw-py-12 tw-bg-white">
    <div class="tw-max-w-7xl tw-mx-auto tw-px-4">
        <h2 class="tw-text-2xl lg:tw-text-3xl tw-font-bold tw-text-center tw-mb-8">@lang('Meilleures ventes')</h2>
        <div class="tw-grid tw-grid-cols-2 md:tw-grid-cols-3 lg:tw-grid-cols-4 tw-gap-4">
            @foreach($topSelling as $product)
            @include('Template::partials.etsmory_product_card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection

@push('script')
<script>
(function() {
    'use strict';

    // Hero Slider
    let currentSlide = 0;
    const slides = document.querySelectorAll('.hero-slide');
    const dots = document.querySelectorAll('.hero-dot');
    const totalSlides = slides.length;

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.style.opacity = i === index ? '1' : '0';
            slide.classList.toggle('active', i === index);
        });
        dots.forEach((dot, i) => {
            dot.classList.toggle('tw-bg-white', i === index);
            dot.classList.toggle('tw-bg-white/50', i !== index);
        });
    }

    function nextSlide() {
        currentSlide = (currentSlide + 1) % totalSlides;
        showSlide(currentSlide);
    }

    window.goToSlide = function(index) {
        currentSlide = index;
        showSlide(currentSlide);
    };

    // Auto-play every 5 seconds
    setInterval(nextSlide, 5000);

    // Flash Deals Carousel
    let currentFlashSlide = 0;
    const flashSlider = document.getElementById('flashDealsSlider');
    const flashItems = flashSlider ? flashSlider.children.length : 0;
    const itemsPerView = window.innerWidth >= 1280 ? 4 : window.innerWidth >= 1024 ? 3 : window.innerWidth >= 768 ? 2 : 1;
    const maxFlashSlide = Math.max(0, flashItems - itemsPerView);

    window.nextFlashDeal = function() {
        if (currentFlashSlide < maxFlashSlide) {
            currentFlashSlide++;
            updateFlashSlider();
        }
    };

    window.prevFlashDeal = function() {
        if (currentFlashSlide > 0) {
            currentFlashSlide--;
            updateFlashSlider();
        }
    };

    function updateFlashSlider() {
        if (flashSlider) {
            const percentage = -(currentFlashSlide * (100 / itemsPerView));
            flashSlider.style.transform = `translateX(${percentage}%)`;
        }
    }

    // Countdown Timer
    const countdownElement = document.getElementById('countdown-timer');
    @if($offers->count() > 0 && $offers->first()->ends_at)
    const targetDate = new Date("{{ $offers->first()->ends_at->format('Y-m-d H:i:s') }}").getTime();

    function updateCountdown() {
        const now = new Date().getTime();
        const diff = targetDate - now;

        if (diff > 0) {
            const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);

            if (countdownElement) {
                countdownElement.textContent = `Fin dans ${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            }
        } else {
            if (countdownElement) {
                countdownElement.textContent = 'Offre terminée';
            }
        }
    }

    if (countdownElement) {
        updateCountdown();
        setInterval(updateCountdown, 1000);
    }
    @endif
})();
</script>
@endpush
