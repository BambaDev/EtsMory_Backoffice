@extends('Template::layouts.master')
@section('content')

{{-- Hero Section --}}
<section class="tw-relative tw-overflow-hidden tw-bg-gradient-to-r tw-from-orange-600 tw-to-green-600" style="min-height:400px">
    <div class="tw-max-w-7xl tw-mx-auto tw-px-4 tw-py-16 lg:tw-py-24">
        <div class="tw-grid tw-grid-cols-1 lg:tw-grid-cols-2 tw-gap-8 tw-items-center">
            <div class="tw-text-white tw-space-y-6">
                <h1 class="tw-text-3xl md:tw-text-4xl lg:tw-text-6xl tw-font-bold tw-leading-tight">
                    @lang('Bienvenue sur') {{ gs('site_name') }}
                </h1>
                <p class="tw-text-lg md:tw-text-xl lg:tw-text-2xl tw-opacity-90">
                    @lang('Vos produits préférés livrés chez vous. Qualité, fraîcheur et prix imbattables.')
                </p>
                <a href="{{ route('product.all') }}" class="tw-inline-block tw-bg-white tw-text-orange-600 tw-px-8 tw-py-4 tw-rounded-full tw-font-bold tw-text-lg hover:tw-bg-orange-50 tw-transition-colors tw-shadow-lg tw-no-underline">
                    @lang('Découvrir la boutique') →
                </a>
            </div>
            @if($banners->count() > 0)
            <div class="tw-hidden lg:tw-block">
                <img src="{{ getImage(getFilePath('promotionalBanner') . '/' . $banners->first()->image) }}" alt="Hero"
                    class="tw-w-full tw-h-80 tw-object-cover tw-rounded-2xl tw-shadow-2xl">
            </div>
            @endif
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
                class="tw-p-6 tw-rounded-xl tw-shadow-sm tw-border tw-border-gray-100 hover:tw-shadow-md tw-transition-all tw-text-center tw-bg-gradient-to-br tw-from-orange-50 tw-to-green-50 tw-no-underline tw-text-gray-800">
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

{{-- Featured Products --}}
@if($featuredProducts->count() > 0)
<section class="tw-py-12 tw-bg-gray-50">
    <div class="tw-max-w-7xl tw-mx-auto tw-px-4">
        <div class="tw-flex tw-items-center tw-justify-between tw-mb-8">
            <div>
                <h2 class="tw-text-2xl lg:tw-text-3xl tw-font-bold">@lang('Nos produits')</h2>
                <p class="tw-text-gray-600 tw-mt-1">@lang('Découvrez notre sélection')</p>
            </div>
            <a href="{{ route('product.all') }}" class="tw-px-6 tw-py-2 tw-border tw-border-orange-500 tw-text-orange-500 tw-rounded-lg hover:tw-bg-orange-500 hover:tw-text-white tw-transition-colors tw-font-medium tw-no-underline">
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
        <h2 class="tw-text-2xl lg:tw-text-3xl tw-font-bold tw-text-gray-800 tw-mb-8">@lang('Pourquoi nous choisir ?')</h2>
        <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-3 tw-gap-6">
            @foreach([
                ['icon' => 'la-truck', 'color' => 'tw-bg-green-100 tw-text-green-600', 'title' => __('Livraison rapide'), 'desc' => __('Livraison à domicile rapide et fiable')],
                ['icon' => 'la-shield-alt', 'color' => 'tw-bg-orange-100 tw-text-orange-600', 'title' => __('Produits de qualité'), 'desc' => __('Sélection rigoureuse de produits')],
                ['icon' => 'la-headset', 'color' => 'tw-bg-green-100 tw-text-green-600', 'title' => __('Service client'), 'desc' => __('Support disponible pour vos questions')],
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
