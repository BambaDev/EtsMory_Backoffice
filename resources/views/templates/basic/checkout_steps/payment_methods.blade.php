@extends('Template::layouts.checkout')

@section('blade')
<div class="tw-grid tw-grid-cols-1 lg:tw-grid-cols-3 tw-gap-6">

    {{-- Left: payment options (2/3) --}}
    <div class="lg:tw-col-span-2">
        <div class="tw-bg-white tw-rounded-2xl tw-shadow-sm tw-border tw-border-gray-100 tw-overflow-hidden">
            <div class="tw-px-6 tw-py-4 tw-border-b tw-border-gray-100 tw-flex tw-items-center tw-gap-3">
                <div class="tw-w-8 tw-h-8 tw-bg-orange-100 tw-rounded-full tw-flex tw-items-center tw-justify-center">
                    <i class="las la-credit-card tw-text-orange-500"></i>
                </div>
                <h2 class="tw-text-lg tw-font-bold tw-text-gray-800 tw-m-0">@lang('Mode de paiement')</h2>
            </div>

            <div class="tw-p-6">
                <div class="payment-option">
                    <h6 class="payment-option__title mb-4">@lang('Select a Payment Option')</h6>
                    <div class="payment-option__wrapper">
                        @if (gs('cod') && $hasPhysicalProduct)
                            <label class="payment-option-item">
                                <div class="form--check">
                                    <input value="0" class="online_payment form-check-input mt-0" type="radio" name="gateway" data-gateway="cod" form="paymentMethodForm" data-currency="{{ gs('cur_text') }}" required>
                                </div>

                                <span class="payment-option-item-content">
                                    <span class="thumb">
                                        <img src="{{ asset(activeTemplate(true) . 'images/cod.png') }}" class="w-100" alt="image">
                                    </span>
                                    <span class="payment-name">
                                        @lang('Cash On Delivery')
                                    </span>
                                </span>
                            </label>
                            <div class="text-center auth-devide">
                                <span>@lang('Online Payment')</span>
                            </div>
                        @endif

                        <div class="payment-option-wrapper">
                            @foreach ($gatewayCurrencies as $item)
                                <label for="data-{{ $loop->index }}" class="payment-option-item">
                                    <div class="form--check">
                                        <input value="{{ $item->method_code }}" id="data-{{ $loop->index }}" data-gateway="{{ $item }}" class="online_payment form-check-input mt-0" type="radio" name="gateway" form="paymentMethodForm" required>
                                    </div>

                                    <span class="payment-option-item-content">
                                        <span class="thumb">
                                            <img src="{{ getImage(getFilePath('gateway') . '/' . @$item->method->image, getFileSize('gateway')) }}" data-src="{{ getImage(getFilePath('gateway') . '/' . @$item->method->image, getFileSize('gateway')) }}" class="w-100 lazyload" alt="image">
                                        </span>
                                        <span class="payment-name">
                                            {{ __($item->name) }}
                                        </span>
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="tw-flex tw-items-center tw-justify-between tw-flex-wrap tw-gap-3 tw-mt-6">
                    <a href="{{ route('checkout.delivery.methods') }}"
                        class="tw-flex tw-items-center tw-gap-1 tw-text-orange-500 hover:tw-text-orange-600 tw-no-underline tw-font-medium">
                        <i class="las la-angle-left"></i> @lang('Retour au transport')
                    </a>

                    <form action="{{ route('checkout.complete') }}" method="POST" id="paymentMethodForm">
                        @csrf
                        <input type="hidden" name="currency">
                        <button type="submit"
                            class="tw-inline-flex tw-items-center tw-gap-2 tw-bg-orange-500 tw-text-white tw-px-8 tw-py-3 tw-rounded-full tw-font-semibold hover:tw-bg-orange-600 tw-transition-colors tw-border-0 tw-cursor-pointer tw-shadow-md">
                            @lang('Valider la commande') <i class="las la-angle-right"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Right: order summary (1/3) --}}
    <div class="lg:tw-col-span-1">
        <div class="tw-bg-white tw-rounded-2xl tw-shadow-sm tw-border tw-border-gray-100 tw-overflow-hidden tw-sticky" style="top: 1rem;">
            <div class="tw-px-6 tw-py-4 tw-border-b tw-border-gray-100 tw-flex tw-items-center tw-gap-3">
                <div class="tw-w-8 tw-h-8 tw-bg-green-100 tw-rounded-full tw-flex tw-items-center tw-justify-center">
                    <i class="las la-receipt tw-text-green-600"></i>
                </div>
                <h2 class="tw-text-lg tw-font-bold tw-text-gray-800 tw-m-0">@lang('Récapitulatif')</h2>
            </div>

            <div class="tw-p-6">
                <div class="payment-details w-100" style="position:static; padding:0; border:none; background:transparent;">
                    <ul class="gateway-info tw-list-none tw-p-0 tw-m-0">
                        <li class="tw-flex tw-justify-between tw-py-3 tw-border-b tw-border-gray-100">
                            <span class="tw-text-gray-500 tw-font-medium tw-text-sm">@lang('Sous-total')</span>
                            <span class="tw-font-semibold tw-text-gray-800" id="cartSubtotal">{{ showAmount($subtotal) }}</span>
                        </li>

                        @php $couponAmount = 0; @endphp

                        @isset($coupon)
                            @php
                                $couponAmount = $coupon['amount'] > $subtotal ? $subtotal : $coupon['amount'];
                            @endphp
                            <li class="tw-flex tw-justify-between tw-py-3 tw-border-b tw-border-gray-100">
                                <span class="tw-text-gray-500 tw-font-medium tw-text-sm">
                                    @lang('Coupon') ({{ $coupon['code'] }})
                                </span>
                                <span class="tw-text-green-600 tw-font-semibold" id="couponAmount">{{ showAmount($couponAmount) }}</span>
                            </li>
                        @endisset

                        @if ($shippingMethod)
                            <li class="tw-flex tw-justify-between tw-py-3 tw-border-b tw-border-gray-100">
                                <span class="tw-text-gray-500 tw-font-medium tw-text-sm">@lang('Frais de livraison')</span>
                                <span class="tw-font-semibold tw-text-gray-800" id="shippingCharge">{{ showAmount($shippingMethod->charge) }}</span>
                            </li>
                        @endif

                        @php
                            $shippingCharge = $shippingMethod->charge ?? 0;
                            $totalAmount = $subtotal + $shippingCharge - $couponAmount;
                        @endphp

                        <li class="deposit-info tw-flex tw-justify-between tw-py-3 tw-border-b tw-border-gray-100">
                            <span class="tw-text-gray-500 tw-font-medium tw-text-sm">
                                @lang('Frais de traitement')
                                <span data-bs-toggle="tooltip" title="@lang('Payment Gateway Processing Charge')" class="processing-fee-info"><i class="las la-info-circle"></i></span>
                            </span>
                            <span class="tw-font-semibold tw-text-gray-800">
                                <span class="processing-fee">@lang('0.00')</span>
                                {{ __(gs('cur_text')) }}
                            </span>
                        </li>

                        <li class="deposit-info total-amount tw-flex tw-justify-between tw-py-3">
                            <span class="tw-text-gray-800 tw-font-bold">@lang('Total')</span>
                            <span class="tw-font-bold tw-text-orange-600 tw-text-lg final-amount">
                                <span id="total">{{ showAmount($totalAmount, currencyFormat: false) }}</span>
                                {{ __(gs('cur_text')) }}
                            </span>
                        </li>
                    </ul>

                    <p class="gateway-conversion mb-0 d-none tw-mt-3 tw-text-sm tw-text-gray-600">
                        <span>@lang('Rate') </span>
                        <span class="exchange_rate fw-semibold"><span class="text"></span></span>
                    </p>

                    <p class="conversion-currency fs-16 tw-bg-orange-50 tw-p-3 tw-mt-3 tw-mb-0 tw-rounded-lg d-none tw-text-sm">
                        <span>@lang('The final payable amount is')</span>
                        <span class="whitespace-nowrap">
                            <strong class="in-currency fw-semibold"></strong> <strong class="gateway-currency fw-semibold"></strong>
                        </span>
                    </p>

                    <p class="crypto-message text-muted tw-mt-3 tw-text-sm">
                        <i class="la la-info-circle"></i>
                        <span> @lang('Conversion with') <span class="gateway-currency text--color"></span>
                            @lang('and final value will Show on next step')</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('script')
    <script>
        (function() {
            "use strict";
            $('[name=gateway]').on('change', function() {
                let gateway = $(this).data('gateway');
                $('[name=currency]').val(gateway == 'cod' ? "{{ gs('cur_text') }}" : gateway.currency);

                let processingFeeInfo = '';
                if (gateway == 'cod') {
                    processingFeeInfo = `@lang('Gateway Processing Charge')`
                } else {
                    processingFeeInfo =
                        `${parseFloat(gateway.percent_charge).toFixed(2)}% with ${parseFloat(gateway.fixed_charge).toFixed(2)} {{ __(gs('cur_text')) }} charge for payment gateway processing fees`;
                }

                $(".processing-fee-info").attr("data-bs-original-title", processingFeeInfo);
                calculation(gateway);
            });

            function calculation(gateway) {
                let percentCharge = 0;
                let fixedCharge = 0;
                let totalPercentCharge = 0;
                let amount = @json($totalAmount);

                if (gateway == 'cod') {
                    gateway = {
                        percent_charge: 0,
                        fixed_charge: 0,
                        currency: "{{ gs('cur_text') }}",
                        method: {
                            crypto: ''
                        }
                    }
                }

                if (amount) {
                    percentCharge = parseFloat(gateway.percent_charge);
                    fixedCharge = parseFloat(gateway.fixed_charge);
                    totalPercentCharge = parseFloat(amount / 100 * percentCharge);
                }

                let totalCharge = parseFloat(totalPercentCharge + fixedCharge);
                let totalAmount = parseFloat((amount || 0) + totalPercentCharge + fixedCharge);

                $(".final-amount").text(totalAmount.toFixed(2));
                $(".processing-fee").text(totalCharge.toFixed(2));

                $("input[name=currency]").val(gateway.currency);
                $(".gateway-currency").text(gateway.currency);

                if (amount < Number(gateway.min_amount) || amount > Number(gateway.max_amount)) {
                    $(".button[type=submit]").attr('disabled', true);
                } else {
                    $(".button[type=submit]").removeAttr('disabled');
                }

                if (gateway.currency != "{{ gs('cur_text') }}" && gateway.method.crypto != 1) {
                    $(".gateway-conversion, .conversion-currency").removeClass('d-none');
                    $(".gateway-conversion").find('.exchange_rate .text').html(
                        `1 {{ __(gs('cur_text')) }} = <span class="rate">${parseFloat(gateway.rate).toFixed(2)}</span>  <span class="method_currency">${gateway.currency}</span>`
                    );
                    $('.in-currency').text(parseFloat(totalAmount * gateway.rate).toFixed(gateway.method.crypto == 1 ? 8 : 2))
                } else {
                    $(".gateway-conversion, .conversion-currency").addClass('d-none');
                    $('.deposit-form').removeClass('adjust-height')
                }

                if (gateway.method.crypto == 1) {
                    $('.crypto-message').removeClass('d-none');
                } else {
                    $('.crypto-message').addClass('d-none');
                }
            }

            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
        })(jQuery);
    </script>
@endpush

@push('style')
    <style>
        .auth-devide {
            position: relative;
            margin: 20px 0px;
        }
        .auth-devide::after {
            content: '';
            position: absolute;
            height: 1px;
            width: 100%;
            background-color: hsl(var(--border));
            top: 50%;
            left: 0;
            z-index: 1;
        }
        .auth-devide span {
            background: hsl(var(--white));
            padding: 3px 8px;
            z-index: 2;
            position: relative;
        }
    </style>
@endpush
