@php
    $content = getContent('order_confirmation.content', true);
@endphp

@extends('Template::layouts.checkout')

@section('blade')
<div class="tw-flex tw-justify-center">
    <div class="tw-bg-white tw-rounded-2xl tw-shadow-sm tw-border tw-border-gray-100 tw-overflow-hidden tw-w-full tw-max-w-lg">
        <div class="tw-px-6 tw-py-4 tw-border-b tw-border-gray-100 tw-flex tw-items-center tw-gap-3">
            <div class="tw-w-8 tw-h-8 tw-bg-green-100 tw-rounded-full tw-flex tw-items-center tw-justify-center">
                <i class="las la-check-circle tw-text-green-500"></i>
            </div>
            <h2 class="tw-text-lg tw-font-bold tw-text-gray-800 tw-m-0">@lang('Commande confirmée')</h2>
        </div>

        <div class="tw-p-8 tw-text-center">
            <img src="{{ asset(activeTemplate(true) . 'images/order-completed.gif') }}"
                class="tw-w-36 tw-h-36 tw-object-contain tw-mx-auto tw-mb-6"
                alt="@lang('Commande complétée')">

            <h3 class="tw-text-xl tw-font-bold tw-text-gray-800 tw-mb-3">
                {{ __(@$content->data_values->title) }}
            </h3>
            <p class="tw-text-gray-500 tw-mb-6 tw-leading-relaxed">
                {{ __(@$content->data_values->description) }}
            </p>

            @if(isset($order) && $order)
            <div class="tw-bg-orange-50 tw-rounded-xl tw-p-4 tw-mb-6">
                <p class="tw-text-sm tw-text-gray-600 tw-mb-1">@lang('Numéro de commande')</p>
                <p class="tw-font-bold tw-text-orange-600 tw-text-lg tw-m-0">{{ $order->order_number }}</p>
            </div>
            <a href="{{ route('orders.details', $order->order_number) }}"
                class="tw-inline-flex tw-items-center tw-gap-2 tw-bg-orange-500 tw-text-white tw-px-8 tw-py-3 tw-rounded-full tw-font-semibold hover:tw-bg-orange-600 tw-transition-colors tw-no-underline tw-shadow-md">
                <i class="las la-receipt"></i>
                @lang('Voir ma commande')
            </a>
            @endif

            <div class="tw-mt-4">
                <a href="{{ route('home') }}"
                    class="tw-inline-flex tw-items-center tw-gap-1 tw-text-gray-500 hover:tw-text-orange-500 tw-no-underline tw-text-sm">
                    <i class="las la-home"></i> @lang('Retour à l\'accueil')
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
