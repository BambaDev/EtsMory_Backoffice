@extends('Template::layouts.master')

@section('content')

{{-- EtsMory breadcrumb --}}
<div class="tw-bg-gradient-to-r tw-from-orange-50 tw-to-green-50 tw-py-6">
    <div class="tw-max-w-7xl tw-mx-auto tw-px-4">
        <nav class="tw-flex tw-items-center tw-gap-2 tw-text-sm tw-text-gray-600">
            <a href="{{ route('home') }}" class="hover:tw-text-orange-600 tw-no-underline tw-text-gray-600">@lang('Accueil')</a>
            <i class="las la-angle-right tw-text-xs"></i>
            <span class="tw-text-gray-800 tw-font-medium">@lang('Marques')</span>
        </nav>
    </div>
</div>

{{-- Hero section --}}
<section class="tw-bg-white tw-py-16">
    <div class="tw-max-w-7xl tw-mx-auto tw-px-4 tw-text-center">
        <div class="tw-w-16 tw-h-16 tw-bg-orange-100 tw-rounded-full tw-flex tw-items-center tw-justify-center tw-mx-auto tw-mb-6">
            <i class="las la-tags tw-text-4xl tw-text-orange-500"></i>
        </div>
        <h1 class="tw-text-4xl lg:tw-text-5xl tw-font-bold tw-text-gray-800 tw-mb-6">
            @lang('Toutes nos marques')
        </h1>
        <p class="tw-text-xl tw-text-gray-600">
            @lang('Découvrez nos marques partenaires de confiance')
            @if($brands->count())
            <span class="tw-inline-block tw-ml-2 tw-px-3 tw-py-1 tw-bg-orange-100 tw-text-orange-600 tw-rounded-full tw-text-base tw-font-semibold">
                {{ $brands->count() }} @lang('marques')
            </span>
            @endif
        </p>
    </div>
</section>

{{-- Brands Grid --}}
<section class="tw-py-16 tw-bg-gray-50">
    <div class="tw-max-w-7xl tw-mx-auto tw-px-4">
        @if ($brands->count())
            <div class="tw-grid tw-grid-cols-2 sm:tw-grid-cols-3 md:tw-grid-cols-4 lg:tw-grid-cols-5 xl:tw-grid-cols-6 tw-gap-4">
                @foreach ($brands as $brand)
                    <div class="tw-bg-white tw-rounded-2xl tw-p-6 tw-text-center tw-shadow-sm hover:tw-shadow-md tw-transition-all">
                        <x-dynamic-component :component="frontendComponent('brand-card')" :brand="$brand" />
                    </div>
                @endforeach
            </div>
        @else
            <div class="tw-flex tw-flex-col tw-items-center tw-justify-center tw-py-20 tw-text-center tw-bg-white tw-rounded-2xl tw-shadow-sm tw-border tw-border-gray-100">
                <img src="{{ getImage('assets/images/empty_list.png') }}"
                    alt="@lang('Liste vide')"
                    class="tw-w-32 tw-h-32 tw-object-contain tw-mb-6 tw-opacity-60">
                <h3 class="tw-text-xl tw-font-semibold tw-text-gray-700 tw-mb-2">
                    @lang('Aucune marque disponible')
                </h3>
                <p class="tw-text-gray-500 tw-mb-6">
                    @lang('Les marques seront bientôt disponibles.')
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
