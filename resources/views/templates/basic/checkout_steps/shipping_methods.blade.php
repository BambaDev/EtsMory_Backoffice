@extends('Template::layouts.checkout')

@section('blade')
<div class="tw-bg-white tw-rounded-2xl tw-shadow-sm tw-border tw-border-gray-100 tw-overflow-hidden">
    <div class="tw-px-6 tw-py-4 tw-border-b tw-border-gray-100 tw-flex tw-items-center tw-gap-3">
        <div class="tw-w-8 tw-h-8 tw-bg-orange-100 tw-rounded-full tw-flex tw-items-center tw-justify-center">
            <i class="las la-truck tw-text-orange-500"></i>
        </div>
        <h2 class="tw-text-lg tw-font-bold tw-text-gray-800 tw-m-0">@lang('Mode de livraison')</h2>
    </div>

    <div class="tw-p-6">
        <div class="address-wrapper">
            <div class="address-type-content">
                <h6 class="mb-3">@lang('Choose Delivery Type')</h6>

                <div class="delivery-type-wrapper">
                    @foreach ($shippingMethods as $item)
                        <label for="method-{{ $item->id }}" class="delivery-type">
                            <span class="form--check d-flex">
                                <input class="form-check-input mt-0" type="radio" name="shipping_method_id"
                                    value="{{ $item->id }}" form="deliveryMethodForm" id="method-{{ $item->id }}"
                                    data-resource="{{ $item }}" @checked($loop->first) required>
                            </span>

                            <span class="delivery-type-name">
                                {{ __($item->name) }}
                            </span>
                        </label>

                        <div class="methodInfo mt-3 delivery-type-content">
                            <div class="address-item-inner">
                                <span class="address-item-label">@lang('Delivered In')</span>
                                <span class="address-item-value"> <span class="item-devide">:</span> {{ $item->shipping_time }}
                                    @lang('Days')</span>
                            </div>

                            <div class="address-item-inner">
                                <span class="address-item-label">@lang('Delivery Charge')</span>
                                <span class="address-item-value">
                                    <span class="item-devide">:</span>
                                    {{ showAmount($item->charge) }}
                                </span>
                            </div>

                            @if (strip_tags($item->description))
                                <div class="address-item-inner bg-light p-3 rounded-3">
                                    <p>
                                        @php echo $item->description @endphp
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="tw-flex tw-items-center tw-justify-between tw-flex-wrap tw-gap-3 tw-mt-6">
            <a href="{{ route('checkout.shipping.info') }}"
                class="tw-flex tw-items-center tw-gap-1 tw-text-orange-500 hover:tw-text-orange-600 tw-no-underline tw-font-medium">
                <i class="las la-angle-left"></i> @lang('Retour à la livraison')
            </a>

            <form action="{{ route('checkout.delivery.method.add') }}" method="POST" id="deliveryMethodForm">
                @csrf
                <button type="submit"
                    class="tw-inline-flex tw-items-center tw-gap-2 tw-bg-orange-500 tw-text-white tw-px-8 tw-py-3 tw-rounded-full tw-font-semibold hover:tw-bg-orange-600 tw-transition-colors tw-border-0 tw-cursor-pointer tw-shadow-md">
                    @lang('Continuer') <i class="las la-angle-right"></i>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('style')
    <style>
        .address-item-inner p {
            margin-bottom: 0 !important;
        }

        .delivery-type-content {
            display: none;
            order: 2;
        }

        .delivery-type {
            order: 0;
        }

        .delivery-type-wrapper:has(.delivery-type:first-of-type input:checked) .delivery-type-content:first-of-type {
            display: block;
        }

        .delivery-type-wrapper:has(.delivery-type:last-of-type input:checked) .delivery-type-content:last-of-type {
            display: block;
        }
    </style>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            const wrapper = document.querySelector('.delivery-type-wrapper');
            const radios = wrapper.querySelectorAll('.delivery-type input[type="radio"]');
            const contents = wrapper.querySelectorAll('.delivery-type-content');

            radios.forEach((radio, index) => {
                radio.addEventListener('change', () => {
                    contents.forEach((content, i) => {
                        content.style.display = i === index ? 'block' : 'none';
                    });
                });
            });

            radios.forEach((radio, index) => {
                if (radio.checked) {
                    contents.forEach((content, i) => {
                        content.style.display = i === index ? 'block' : 'none';
                    });
                }
            });
        })(jQuery);
    </script>
@endpush
