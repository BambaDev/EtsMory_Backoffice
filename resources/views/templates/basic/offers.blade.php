@extends('Template::layouts.master')

@section('content')

{{-- EtsMory breadcrumb --}}
<div class="tw-bg-gradient-to-r tw-from-orange-50 tw-to-green-50 tw-py-6">
    <div class="tw-max-w-7xl tw-mx-auto tw-px-4">
        <nav class="tw-flex tw-items-center tw-gap-2 tw-text-sm tw-text-gray-600">
            <a href="{{ route('home') }}" class="hover:tw-text-orange-600 tw-no-underline tw-text-gray-600">@lang('Accueil')</a>
            <i class="las la-angle-right tw-text-xs"></i>
            <span class="tw-text-gray-800 tw-font-medium">@lang('Offres')</span>
        </nav>
    </div>
</div>

{{-- Hero section --}}
<section class="tw-bg-white tw-py-16">
    <div class="tw-max-w-7xl tw-mx-auto tw-px-4 tw-text-center">
        <div class="tw-w-16 tw-h-16 tw-bg-orange-100 tw-rounded-full tw-flex tw-items-center tw-justify-center tw-mx-auto tw-mb-6">
            <i class="las la-fire tw-text-4xl tw-text-orange-500"></i>
        </div>
        <h1 class="tw-text-4xl lg:tw-text-5xl tw-font-bold tw-text-gray-800 tw-mb-6">
            @lang('Offres spéciales')
        </h1>
        <p class="tw-text-xl tw-text-gray-600">
            @lang('Profitez de nos promotions exceptionnelles et offres à durée limitée')
            @if($offers->count())
            <span class="tw-inline-block tw-ml-2 tw-px-3 tw-py-1 tw-bg-orange-100 tw-text-orange-600 tw-rounded-full tw-text-base tw-font-semibold">
                {{ $offers->count() }} @lang('offres actives')
            </span>
            @endif
        </p>
    </div>
</section>

{{-- Offers Grid --}}
<section class="tw-py-16 tw-bg-gray-50">
    <div class="tw-max-w-7xl tw-mx-auto tw-px-4">
        @if ($offers->count())
            <div class="tw-grid tw-grid-cols-1 sm:tw-grid-cols-2 lg:tw-grid-cols-3 xl:tw-grid-cols-4 tw-gap-6">
                @foreach ($offers as $offer)
                    @php
                        $startTimestamp = $offer->starts_from->timestamp * 1000;
                        $endTimestamp = $offer->ends_at->timestamp * 1000;
                    @endphp

                    <div class="flash-sell-section tw-bg-white tw-rounded-2xl tw-shadow-sm tw-overflow-hidden hover:tw-shadow-md tw-transition-all tw-border tw-border-gray-100"
                        data-starts-at="{{ $startTimestamp }}"
                        data-ends-at="{{ $endTimestamp }}">

                        @if ($offer->show_countdown)
                            <div class="offer-countdown tw-p-4 tw-bg-gradient-to-r tw-from-orange-50 tw-to-green-50">
                                <x-dynamic-component :component="frontendComponent('offer-countdown')" />
                            </div>
                        @endif

                        <a href="{{ route('offer.products', encrypt($offer->id)) }}"
                            class="tw-block tw-relative tw-overflow-hidden tw-group">
                            @if ($offer->banner)
                                <div class="tw-aspect-[4/3] tw-overflow-hidden">
                                    <img class="tw-w-full tw-h-full tw-object-cover group-hover:tw-scale-105 tw-transition-transform tw-duration-300"
                                        src="{{ getImage(getFilePath('offerBanner') . '/' . $offer->banner) }}"
                                        alt="@lang('Offre') - {{ __($offer->name) }}">
                                </div>
                            @else
                                <div class="tw-aspect-[4/3] tw-flex tw-items-center tw-justify-center tw-bg-gradient-to-br tw-from-orange-100 tw-to-green-100">
                                    <h3 class="tw-text-2xl tw-font-bold tw-text-gray-800 tw-text-center tw-px-4">
                                        {{ __($offer->name) }}
                                    </h3>
                                </div>
                            @endif

                            <div class="tw-absolute tw-top-4 tw-right-4 tw-bg-orange-500 tw-text-white tw-px-3 tw-py-1 tw-rounded-full tw-text-sm tw-font-semibold tw-shadow-lg">
                                <i class="las la-fire"></i> @lang('Promo')
                            </div>
                        </a>

                        <div class="tw-p-4 tw-text-center">
                            <h4 class="tw-font-semibold tw-text-gray-800 tw-mb-2">
                                {{ __($offer->name) }}
                            </h4>
                            <a href="{{ route('offer.products', encrypt($offer->id)) }}"
                                class="tw-inline-flex tw-items-center tw-gap-2 tw-text-orange-500 hover:tw-text-orange-600 tw-font-medium tw-text-sm tw-no-underline">
                                @lang('Voir les produits')
                                <i class="las la-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="tw-flex tw-flex-col tw-items-center tw-justify-center tw-py-20 tw-text-center tw-bg-white tw-rounded-2xl tw-shadow-sm tw-border tw-border-gray-100">
                <img src="{{ getImage('assets/images/empty_list.png') }}"
                    alt="@lang('Liste vide')"
                    class="tw-w-32 tw-h-32 tw-object-contain tw-mb-6 tw-opacity-60">
                <h3 class="tw-text-xl tw-font-semibold tw-text-gray-700 tw-mb-2">
                    @lang('Aucune offre disponible')
                </h3>
                <p class="tw-text-gray-500 tw-mb-6">
                    @lang('Les offres promotionnelles seront bientôt disponibles.')
                </p>
                <a href="{{ route('home') }}"
                    class="tw-inline-block tw-bg-orange-500 tw-text-white tw-px-8 tw-py-3 tw-rounded-full tw-font-semibold hover:tw-bg-orange-600 tw-transition-colors tw-no-underline">
                    @lang('Retour à l\'accueil')
                </a>
            </div>
        @endif
    </div>
</section>

@endsection
