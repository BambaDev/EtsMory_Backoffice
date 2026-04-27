@extends('Template::layouts.checkout')

@section('blade')
<div class="tw-bg-white tw-rounded-2xl tw-shadow-sm tw-border tw-border-gray-100 tw-overflow-hidden">
    <div class="tw-px-6 tw-py-4 tw-border-b tw-border-gray-100 tw-flex tw-items-center tw-gap-3">
        <div class="tw-w-8 tw-h-8 tw-bg-orange-100 tw-rounded-full tw-flex tw-items-center tw-justify-center">
            <i class="las la-user-circle tw-text-orange-500"></i>
        </div>
        <h2 class="tw-text-lg tw-font-bold tw-text-gray-800 tw-m-0">@lang('Informations de livraison')</h2>
    </div>

    <div class="tw-p-6">
        <form action="{{ route('checkout.guest.shipping.info.store') }}" method="POST" id="shipping-form">
            @csrf
            <div>
                @php
                    $shippingInformation = (object) Session::get('shipping_info');
                    $checkoutContent = getContent('guest_checkout.content', true)?->data_values;
                @endphp

                @if ($checkoutContent->shipping_info_recipient_info_title)
                    <h5 class="mb-1">{{ __($checkoutContent->shipping_info_recipient_info_title) }}</h5>
                @endif

                @if ($checkoutContent->shipping_info_recipient_info_description)
                    <p class="text-muted fst-italic">
                        {{ __($checkoutContent->shipping_info_recipient_info_description) }}
                    </p>
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('First Name')</label>
                            <input type="text" value="{{ @$shippingInformation->firstname }}" class="form-control form--control" name="firstname" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('Last Name')</label>
                            <input type="text" value="{{ @$shippingInformation->lastname }}" class="form-control form--control" name="lastname" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('Mobile')</label>
                            <div class="input-group">
                                <span class="input-group-text mobile-code"></span>
                                <input type="hidden" name="mobile_code">
                                <input type="hidden" name="country_code">
                                <input type="number" name="mobile" value="{{ @$shippingInformation->mobile }}" class="form-control form--control ps-0" required>
                            </div>
                            <small class="text-muted"><i class="la la-info-circle"></i> @lang('Enter the mobile number without the country code.')</small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('Email')</label>
                            <input type="text" value="{{ @$shippingInformation->email }}" class="form-control form--control" name="email" required>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    @if ($checkoutContent->description_in_shipping_info_title)
                        <h5 class="mb-1">{{ __($checkoutContent->description_in_shipping_info_title) }}</h5>
                    @endif

                    @if ($checkoutContent->description_in_shipping_info_description)
                        <p class="text-muted fst-italic">
                            {{ __($checkoutContent->description_in_shipping_info_description) }}
                        </p>
                    @endif

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">@lang('Country')</label>
                            <select name="country" class="form-control form--control select2" required>
                                @foreach ($countries as $key => $country)
                                    <option data-mobile_code="{{ $country->dial_code }}" value="{{ $country->country }}" data-code="{{ $key }}">
                                        {{ __($country->country) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('State')</label>
                            <input type="text" value="{{ @$shippingInformation->state }}" class="form-control form--control" name="state" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('City')</label>
                            <input type="text" value="{{ @$shippingInformation->city }}" class="form-control form--control" name="city" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>@lang('Zip')</label>
                            <input type="text" value="{{ @$shippingInformation->zip }}" class="form-control form--control" name="zip" required>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>@lang('Address')</label>
                            <input type="text" value="{{ @$shippingInformation->address }}" class="form-control form--control" name="address" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tw-flex tw-items-center tw-justify-between tw-flex-wrap tw-gap-3 tw-mt-6">
                <a href="{{ route('cart.page') }}"
                    class="tw-flex tw-items-center tw-gap-1 tw-text-orange-500 hover:tw-text-orange-600 tw-no-underline tw-font-medium">
                    <i class="las la-angle-left"></i> @lang('Retour au panier')
                </a>

                <button type="submit"
                    class="tw-inline-flex tw-items-center tw-gap-2 tw-bg-orange-500 tw-text-white tw-px-8 tw-py-3 tw-rounded-full tw-font-semibold hover:tw-bg-orange-600 tw-transition-colors tw-border-0 tw-cursor-pointer tw-shadow-md">
                    @lang('Continuer') <i class="las la-angle-right"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";

            let mobileElement = $('.mobile-code');
            $('select[name=country]').on('change', function() {
                mobileElement.text(`+${$('select[name=country] :selected').data('mobile_code')}`);
            });

        })(jQuery);
    </script>
@endpush
