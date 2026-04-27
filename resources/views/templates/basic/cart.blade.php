@extends('Template::layouts.checkout')

@section('blade')

{{-- EtsMory cart layout --}}
@if(!blank($cartData))

<div class="cart-container">
    <div class="tw-grid tw-grid-cols-1 lg:tw-grid-cols-3 tw-gap-6">

        {{-- Left column: cart items (2/3) --}}
        <div class="lg:tw-col-span-2">
            <div class="tw-bg-white tw-rounded-2xl tw-shadow-sm tw-border tw-border-gray-100 tw-overflow-hidden">
                <div class="tw-px-6 tw-py-4 tw-border-b tw-border-gray-100 tw-flex tw-items-center tw-gap-3">
                    <div class="tw-w-8 tw-h-8 tw-bg-orange-100 tw-rounded-full tw-flex tw-items-center tw-justify-center">
                        <i class="las la-shopping-cart tw-text-orange-500"></i>
                    </div>
                    <h2 class="tw-text-lg tw-font-bold tw-text-gray-800 tw-m-0">
                        @lang('Mon panier')
                        <span class="tw-text-sm tw-font-normal tw-text-gray-500 tw-ml-1">
                            ({{ count($cartData) }} @lang('article(s)'))
                        </span>
                    </h2>
                </div>
                <div class="cart cart-body">
                    @foreach($cartData as $cartItem)
                        <x-dynamic-component :component="frontendComponent('cart-item')" :cartItem="$cartItem" />
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Right column: order summary (1/3) --}}
        <div class="lg:tw-col-span-1">
            <div class="tw-bg-white tw-rounded-2xl tw-shadow-sm tw-border tw-border-gray-100 tw-overflow-hidden tw-sticky" style="top: 1rem;">
                <div class="tw-px-6 tw-py-4 tw-border-b tw-border-gray-100 tw-flex tw-items-center tw-gap-3">
                    <div class="tw-w-8 tw-h-8 tw-bg-green-100 tw-rounded-full tw-flex tw-items-center tw-justify-center">
                        <i class="las la-receipt tw-text-green-600"></i>
                    </div>
                    <h2 class="tw-text-lg tw-font-bold tw-text-gray-800 tw-m-0">@lang('Résumé')</h2>
                </div>
                <div class="tw-px-6 tw-py-4 cart-footer">
                    @include('Template::partials.cart_bottom')
                </div>
            </div>
        </div>

    </div>
</div>

{{-- Continue button — OUTSIDE .cart-container so JS .cart-next-step removal works --}}
<div class="tw-mt-6 tw-flex tw-justify-end cart-next-step">
    @auth
        <a href="{{ route('checkout.shipping.info') }}"
            class="tw-inline-flex tw-items-center tw-gap-2 tw-bg-orange-500 tw-text-white tw-px-8 tw-py-3 tw-rounded-full tw-font-semibold hover:tw-bg-orange-600 tw-transition-colors tw-no-underline tw-shadow-md">
            @lang('Continuer la commande')
            <i class="las la-angle-right"></i>
        </a>
    @else
        <button class="login-trigger tw-inline-flex tw-items-center tw-gap-2 tw-bg-orange-500 tw-text-white tw-px-8 tw-py-3 tw-rounded-full tw-font-semibold hover:tw-bg-orange-600 tw-transition-colors tw-shadow-md tw-border-0 tw-cursor-pointer"
            data-bs-toggle="modal"
            data-bs-target="@if(gs('guest_checkout')) #loginAndGuestModal @else #loginModal @endif">
            @lang('Continuer la commande')
            <i class="las la-angle-right"></i>
        </button>
    @endauth
</div>

@else

{{-- Empty cart state — also inside .cart-container so JS can target it --}}
<div class="cart-container">
    <div class="tw-flex tw-flex-col tw-items-center tw-justify-center tw-py-20 tw-text-center tw-bg-white tw-rounded-2xl tw-shadow-sm tw-border tw-border-gray-100">
        <img src="{{ getImage('assets/images/empty_cart.png') }}"
            alt="@lang('Panier vide')"
            class="tw-w-40 tw-h-40 tw-object-contain tw-mb-6 tw-opacity-60">
        <h3 class="tw-text-xl tw-font-semibold tw-text-gray-700 tw-mb-2">
            @lang('Votre panier est vide')
        </h3>
        <p class="tw-text-gray-500 tw-mb-6">
            @lang('Ajoutez des produits pour commencer votre commande.')
        </p>
        <a href="{{ route('product.all') }}"
            class="tw-inline-block tw-bg-orange-500 tw-text-white tw-px-8 tw-py-3 tw-rounded-full tw-font-semibold hover:tw-bg-orange-600 tw-transition-colors tw-no-underline">
            @lang('Découvrir la boutique')
        </a>
    </div>
</div>

@endif

@endsection
