@extends('Template::layouts.master')

@section('content')

{{-- EtsMory breadcrumb --}}
<div class="tw-bg-gradient-to-r tw-from-orange-50 tw-to-green-50 tw-py-5">
    <div class="tw-max-w-5xl tw-mx-auto tw-px-4">
        <nav class="tw-flex tw-items-center tw-gap-2 tw-text-sm tw-text-gray-600">
            <a href="{{ route('home') }}" class="hover:tw-text-orange-600 tw-no-underline tw-text-gray-600">@lang('Accueil')</a>
            <i class="las la-angle-right tw-text-xs"></i>
            <a href="{{ route('cart.page') }}" class="hover:tw-text-orange-600 tw-no-underline tw-text-gray-600">@lang('Panier')</a>
            <i class="las la-angle-right tw-text-xs"></i>
            <span class="tw-text-gray-800 tw-font-medium">{{ $pageTitle ?? __('Commande') }}</span>
        </nav>
    </div>
</div>

{{-- EtsMory step progress bar --}}
<div class="tw-bg-white tw-border-b tw-border-gray-100 tw-py-6">
    <div class="tw-max-w-5xl tw-mx-auto tw-px-4">
        <div class="tw-flex tw-items-center tw-justify-center tw-gap-0">

            @php
                $steps = [
                    ['route' => 'cart.page',                  'icon' => 'la-shopping-cart', 'label' => __('Panier')],
                    ['route' => 'checkout.shipping.info',     'icon' => 'la-map-marker',    'label' => __('Livraison')],
                    ['route' => 'checkout.delivery.methods',  'icon' => 'la-truck',         'label' => __('Transport')],
                    ['route' => 'checkout.payment.methods',   'icon' => 'la-credit-card',   'label' => __('Paiement')],
                    ['route' => 'checkout.confirmation',      'icon' => 'la-check-circle',  'label' => __('Confirmation')],
                ];
                $activeSteps = ['cart.page', 'checkout.shipping.info', 'checkout.delivery.methods', 'checkout.payment.methods', 'checkout.confirmation'];
                $currentIndex = 0;
                foreach ($activeSteps as $i => $r) {
                    if (Route::is($r) || Route::is('checkout.guest.*') && $r === 'checkout.shipping.info') {
                        $currentIndex = $i;
                        break;
                    }
                }
            @endphp

            @foreach($steps as $i => $step)
            {{-- Step circle --}}
            <div class="tw-flex tw-flex-col tw-items-center tw-relative" style="min-width: 80px;">
                <div @class([
                    'tw-w-10 tw-h-10 tw-rounded-full tw-flex tw-items-center tw-justify-center tw-font-bold tw-text-sm tw-transition-all tw-z-10',
                    'tw-bg-orange-500 tw-text-white tw-shadow-md' => $i <= $currentIndex,
                    'tw-bg-gray-200 tw-text-gray-400' => $i > $currentIndex,
                ])>
                    @if($i < $currentIndex)
                        <i class="las la-check"></i>
                    @else
                        <i class="las {{ $step['icon'] }}"></i>
                    @endif
                </div>
                <span @class([
                    'tw-text-xs tw-mt-1 tw-font-medium tw-text-center',
                    'tw-text-orange-600' => $i <= $currentIndex,
                    'tw-text-gray-400' => $i > $currentIndex,
                ])>{{ $step['label'] }}</span>
            </div>
            {{-- Connector line (not after last) --}}
            @if($i < count($steps) - 1)
            <div @class([
                'tw-flex-1 tw-h-0.5 tw-mb-5',
                'tw-bg-orange-400' => $i < $currentIndex,
                'tw-bg-gray-200' => $i >= $currentIndex,
            ])></div>
            @endif
            @endforeach

        </div>
    </div>
</div>

{{-- Page content --}}
<div class="tw-bg-gray-50 tw-min-h-screen tw-py-8">
    <div class="tw-max-w-5xl tw-mx-auto tw-px-4">
        @yield('blade')
    </div>
</div>

@endsection

@push('style')
    <link rel="stylesheet" href="{{ asset(activeTemplate(true) . 'css/checkout-steps.css') }}">
@endpush
