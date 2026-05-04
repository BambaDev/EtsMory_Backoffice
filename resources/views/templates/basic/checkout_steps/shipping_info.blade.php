@extends('Template::layouts.checkout')

@section('blade')
<div class="tw-bg-white tw-rounded-2xl tw-shadow-sm tw-border tw-border-gray-100 tw-overflow-hidden">
    <div class="tw-px-6 tw-py-4 tw-border-b tw-border-gray-100 tw-flex tw-items-center tw-gap-3">
        <div class="tw-w-8 tw-h-8 tw-bg-orange-100 tw-rounded-full tw-flex tw-items-center tw-justify-center">
            <i class="las la-map-marker-alt tw-text-orange-500"></i>
        </div>
        <h2 class="tw-text-lg tw-font-bold tw-text-gray-800 tw-m-0">@lang('Adresse de livraison')</h2>
    </div>

    <div class="tw-p-6">
        <div class="tw-space-y-4">
            @foreach ($shippingAddresses as $item)
                @php
                    $checkoutData = session('shipping_info');
                    $guestShippingInfo = session('guest_shipping_info');
                    if (@$checkoutData['shipping_address_id'] == $item->id) {
                        $isChecked = true;
                    } elseif ($loop->first) {
                        $isChecked = true;
                    } else {
                        $isChecked = false;
                    }
                @endphp

                <label for="address-{{ $item->id }}"
                    class="tw-flex tw-items-start tw-gap-4 tw-p-4 tw-border tw-border-gray-200 tw-rounded-xl hover:tw-border-orange-300 tw-cursor-pointer tw-transition-colors {{ $isChecked ? 'tw-border-orange-500 tw-bg-orange-50' : 'tw-bg-white' }}">
                    <div class="tw-flex-shrink-0 tw-pt-1">
                        <input type="radio"
                            name="shipping_address_id"
                            value="{{ $item->id }}"
                            form="shipping-form"
                            id="address-{{ $item->id }}"
                            @checked($isChecked)
                            class="tw-w-5 tw-h-5 tw-text-orange-500 tw-border-gray-300 focus:tw-ring-orange-500">
                    </div>

                    <div class="tw-flex-1 tw-min-w-0">
                        <h6 class="tw-font-semibold tw-text-gray-800 tw-mb-3">{{ $item->label }}</h6>
                        <div class="tw-grid tw-grid-cols-1 sm:tw-grid-cols-2 tw-gap-x-4 tw-gap-y-2 tw-text-sm">
                            <div class="tw-flex tw-gap-2">
                                <span class="tw-text-gray-500 tw-min-w-[80px]">@lang('Address'):</span>
                                <span class="tw-text-gray-700 tw-font-medium">{{ $item->address }}</span>
                            </div>
                            <div class="tw-flex tw-gap-2">
                                <span class="tw-text-gray-500 tw-min-w-[80px]">@lang('Zip Code'):</span>
                                <span class="tw-text-gray-700 tw-font-medium">{{ $item->zip }}</span>
                            </div>
                            <div class="tw-flex tw-gap-2">
                                <span class="tw-text-gray-500 tw-min-w-[80px]">@lang('City'):</span>
                                <span class="tw-text-gray-700 tw-font-medium">{{ $item->city }}</span>
                            </div>
                            <div class="tw-flex tw-gap-2">
                                <span class="tw-text-gray-500 tw-min-w-[80px]">@lang('State'):</span>
                                <span class="tw-text-gray-700 tw-font-medium">{{ $item->state }}</span>
                            </div>
                            <div class="tw-flex tw-gap-2">
                                <span class="tw-text-gray-500 tw-min-w-[80px]">@lang('Country'):</span>
                                <span class="tw-text-gray-700 tw-font-medium">{{ $item->country }}</span>
                            </div>
                            <div class="tw-flex tw-gap-2">
                                <span class="tw-text-gray-500 tw-min-w-[80px]">@lang('Phone'):</span>
                                <span class="tw-text-gray-700 tw-font-medium">{{ $item->mobile }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="tw-flex-shrink-0">
                        <button type="button"
                            data-resource="{{ $item }}"
                            class="editAddress tw-px-3 tw-py-2 tw-rounded-lg tw-border tw-border-blue-300 tw-text-blue-600 hover:tw-bg-blue-50 tw-transition-colors tw-text-sm tw-font-medium tw-flex tw-items-center tw-gap-1">
                            <i class="la la-pencil"></i>
                            <span class="tw-hidden sm:tw-inline">@lang('Change')</span>
                        </button>
                    </div>
                </label>
            @endforeach

            <button type="button"
                class="newAddress tw-w-full tw-p-4 tw-border-2 tw-border-dashed tw-border-gray-300 tw-rounded-xl hover:tw-border-orange-400 hover:tw-bg-orange-50 tw-transition-colors tw-flex tw-flex-col tw-items-center tw-gap-2 tw-bg-white tw-cursor-pointer">
                <i class="las la-plus-circle tw-text-3xl tw-text-orange-500"></i>
                <span class="tw-text-base tw-font-medium tw-text-gray-700">@lang('Add New Address')</span>
            </button>
        </div>

        <div class="tw-flex tw-items-center tw-justify-between tw-flex-wrap tw-gap-3 tw-mt-6">
            <a href="{{ route('cart.page') }}"
                class="tw-flex tw-items-center tw-gap-1 tw-text-orange-500 hover:tw-text-orange-600 tw-no-underline tw-font-medium">
                <i class="las la-angle-left"></i> @lang('Retour au panier')
            </a>

            <form action="{{ route('checkout.shipping.info.add') }}" method="POST" id="shipping-form">
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

@push('modal')
    <x-dynamic-component :component="frontendComponent('shipping-address-modal')" :countries="$countries" />
@endpush

@push('style')
    <style>
        .add-new-title {
            font-size: 1rem;
            color: hsl(var(--body-color) / 0.8);
        }
    </style>
@endpush
