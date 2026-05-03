@extends('Template::layouts.master')

@section('content')

{{-- EtsMory breadcrumb --}}
<div class="tw-bg-gradient-to-r tw-from-orange-50 tw-to-green-50 tw-py-6">
    <div class="tw-max-w-7xl tw-mx-auto tw-px-4">
        <nav class="tw-flex tw-items-center tw-gap-2 tw-text-sm tw-text-gray-600">
            <a href="{{ route('home') }}" class="hover:tw-text-orange-600 tw-no-underline tw-text-gray-600">@lang('Accueil')</a>
            <i class="las la-angle-right tw-text-xs"></i>
            <span class="tw-text-gray-800 tw-font-medium">@lang('À propos')</span>
        </nav>
    </div>
</div>

{{-- Hero section --}}
<section class="tw-bg-gradient-to-br tw-from-orange-500 tw-to-green-600 tw-text-white tw-py-20">
    <div class="tw-max-w-7xl tw-mx-auto tw-px-4">
        <div class="tw-text-center tw-max-w-3xl tw-mx-auto">
            <h1 class="tw-text-4xl lg:tw-text-5xl tw-font-bold tw-mb-6">
                @lang('À propos de') {{ gs('site_name') }}
            </h1>
            <p class="tw-text-xl tw-opacity-90 tw-leading-relaxed">
                @lang('Votre partenaire de confiance pour des achats en ligne de qualité. Nous sommes dédiés à vous offrir les meilleurs produits aux meilleurs prix.')
            </p>
        </div>
    </div>
</section>

{{-- Mission & Values --}}
<section class="tw-py-16 tw-bg-white">
    <div class="tw-max-w-7xl tw-mx-auto tw-px-4">
        <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-2 tw-gap-12 tw-items-center">
            <div>
                <h2 class="tw-text-3xl tw-font-bold tw-text-gray-800 tw-mb-6">
                    @lang('Notre Mission')
                </h2>
                <p class="tw-text-gray-600 tw-text-lg tw-leading-relaxed tw-mb-4">
                    @lang('Chez') {{ gs('site_name') }}, @lang('nous croyons que chacun mérite d\'avoir accès à des produits de qualité à des prix abordables. Notre mission est de faciliter vos achats en ligne en vous proposant une large sélection de produits soigneusement sélectionnés.')
                </p>
                <p class="tw-text-gray-600 tw-text-lg tw-leading-relaxed">
                    @lang('Nous nous engageons à offrir une expérience d\'achat exceptionnelle, de la navigation sur notre site à la livraison de vos commandes.')
                </p>
            </div>
            <div class="tw-bg-gradient-to-br tw-from-orange-100 tw-to-green-100 tw-rounded-2xl tw-p-8 tw-h-96 tw-flex tw-items-center tw-justify-center">
                <i class="las la-shopping-bag tw-text-9xl tw-text-orange-500"></i>
            </div>
        </div>
    </div>
</section>

{{-- Why Choose Us --}}
<section class="tw-py-16 tw-bg-gray-50">
    <div class="tw-max-w-7xl tw-mx-auto tw-px-4">
        <div class="tw-text-center tw-mb-12">
            <h2 class="tw-text-3xl tw-font-bold tw-text-gray-800 tw-mb-4">
                @lang('Pourquoi nous choisir ?')
            </h2>
            <p class="tw-text-gray-600 tw-text-lg">
                @lang('Ce qui nous distingue de la concurrence')
            </p>
        </div>

        <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-3 tw-gap-8">
            {{-- Feature 1 --}}
            <div class="tw-bg-white tw-rounded-2xl tw-p-8 tw-text-center tw-shadow-sm hover:tw-shadow-md tw-transition-shadow">
                <div class="tw-w-16 tw-h-16 tw-bg-orange-100 tw-rounded-full tw-flex tw-items-center tw-justify-center tw-mx-auto tw-mb-6">
                    <i class="las la-shield-alt tw-text-3xl tw-text-orange-500"></i>
                </div>
                <h3 class="tw-text-xl tw-font-bold tw-text-gray-800 tw-mb-3">
                    @lang('Qualité garantie')
                </h3>
                <p class="tw-text-gray-600">
                    @lang('Tous nos produits sont soigneusement sélectionnés et vérifiés pour garantir leur qualité.')
                </p>
            </div>

            {{-- Feature 2 --}}
            <div class="tw-bg-white tw-rounded-2xl tw-p-8 tw-text-center tw-shadow-sm hover:tw-shadow-md tw-transition-shadow">
                <div class="tw-w-16 tw-h-16 tw-bg-green-100 tw-rounded-full tw-flex tw-items-center tw-justify-center tw-mx-auto tw-mb-6">
                    <i class="las la-truck tw-text-3xl tw-text-green-600"></i>
                </div>
                <h3 class="tw-text-xl tw-font-bold tw-text-gray-800 tw-mb-3">
                    @lang('Livraison rapide')
                </h3>
                <p class="tw-text-gray-600">
                    @lang('Nous assurons une livraison rapide et fiable de vos commandes à votre domicile.')
                </p>
            </div>

            {{-- Feature 3 --}}
            <div class="tw-bg-white tw-rounded-2xl tw-p-8 tw-text-center tw-shadow-sm hover:tw-shadow-md tw-transition-shadow">
                <div class="tw-w-16 tw-h-16 tw-bg-orange-100 tw-rounded-full tw-flex tw-items-center tw-justify-center tw-mx-auto tw-mb-6">
                    <i class="las la-headset tw-text-3xl tw-text-orange-500"></i>
                </div>
                <h3 class="tw-text-xl tw-font-bold tw-text-gray-800 tw-mb-3">
                    @lang('Support client 24/7')
                </h3>
                <p class="tw-text-gray-600">
                    @lang('Notre équipe est disponible à tout moment pour répondre à vos questions.')
                </p>
            </div>
        </div>
    </div>
</section>

{{-- Stats --}}
<section class="tw-py-16 tw-bg-gradient-to-br tw-from-orange-500 tw-to-green-600 tw-text-white">
    <div class="tw-max-w-7xl tw-mx-auto tw-px-4">
        <div class="tw-grid tw-grid-cols-2 md:tw-grid-cols-4 tw-gap-8 tw-text-center">
            <div>
                <div class="tw-text-5xl tw-font-bold tw-mb-2">10K+</div>
                <div class="tw-text-lg tw-opacity-90">@lang('Clients satisfaits')</div>
            </div>
            <div>
                <div class="tw-text-5xl tw-font-bold tw-mb-2">5K+</div>
                <div class="tw-text-lg tw-opacity-90">@lang('Produits')</div>
            </div>
            <div>
                <div class="tw-text-5xl tw-font-bold tw-mb-2">99%</div>
                <div class="tw-text-lg tw-opacity-90">@lang('Satisfaction client')</div>
            </div>
            <div>
                <div class="tw-text-5xl tw-font-bold tw-mb-2">24/7</div>
                <div class="tw-text-lg tw-opacity-90">@lang('Support')</div>
            </div>
        </div>
    </div>
</section>

{{-- CTA Section --}}
<section class="tw-py-16 tw-bg-white">
    <div class="tw-max-w-4xl tw-mx-auto tw-px-4 tw-text-center">
        <h2 class="tw-text-3xl tw-font-bold tw-text-gray-800 tw-mb-6">
            @lang('Prêt à commencer ?')
        </h2>
        <p class="tw-text-gray-600 tw-text-lg tw-mb-8">
            @lang('Découvrez notre large sélection de produits et profitez de nos offres exceptionnelles.')
        </p>
        <a href="{{ route('product.all') }}"
            class="tw-inline-block tw-bg-orange-500 tw-text-white tw-px-8 tw-py-4 tw-rounded-full tw-font-semibold tw-text-lg hover:tw-bg-orange-600 tw-transition-colors tw-no-underline tw-shadow-lg">
            @lang('Découvrir la boutique') →
        </a>
    </div>
</section>

@endsection
