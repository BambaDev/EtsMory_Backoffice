@extends('Template::layouts.master')

@section('content')

{{-- EtsMory breadcrumb --}}
<div class="tw-bg-gradient-to-r tw-from-orange-50 tw-to-green-50 tw-py-6">
    <div class="tw-max-w-7xl tw-mx-auto tw-px-4">
        <nav class="tw-flex tw-items-center tw-gap-2 tw-text-sm tw-text-gray-600">
            <a href="{{ route('home') }}" class="hover:tw-text-orange-600 tw-no-underline tw-text-gray-600">@lang('Accueil')</a>
            <i class="las la-angle-right tw-text-xs"></i>
            <span class="tw-text-gray-800 tw-font-medium">@lang('Suivi de commande')</span>
        </nav>
    </div>
</div>

{{-- Hero section --}}
<section class="tw-bg-white tw-py-16">
    <div class="tw-max-w-4xl tw-mx-auto tw-px-4 tw-text-center">
        <div class="tw-w-16 tw-h-16 tw-bg-orange-100 tw-rounded-full tw-flex tw-items-center tw-justify-center tw-mx-auto tw-mb-6">
            <i class="las la-shipping-fast tw-text-4xl tw-text-orange-500"></i>
        </div>
        <h1 class="tw-text-4xl lg:tw-text-5xl tw-font-bold tw-text-gray-800 tw-mb-6">
            @lang('Suivez votre commande')
        </h1>
        <p class="tw-text-xl tw-text-gray-600">
            @lang('Entrez votre numéro de commande pour connaître son statut en temps réel')
        </p>
    </div>
</section>

{{-- Order Track Section --}}
<section class="tw-py-16 tw-bg-gray-50">
    <div class="tw-max-w-5xl tw-mx-auto tw-px-4">

        {{-- Track Form --}}
        <div class="tw-mb-12">
            <div class="tw-bg-white tw-rounded-2xl tw-shadow-sm tw-border tw-border-gray-100 tw-p-8">
                <form class="order-track-form" id="order-track">
                    <div class="tw-flex tw-flex-col sm:tw-flex-row tw-gap-4">
                        <input type="text"
                            name="order_number"
                            placeholder="@lang('Entrez votre numéro de commande')"
                            class="tw-flex-1 tw-px-6 tw-py-4 tw-rounded-xl tw-border tw-border-gray-300 focus:tw-border-orange-500 focus:tw-ring-2 focus:tw-ring-orange-200 focus:tw-outline-none tw-text-lg"
                            required>
                        <button type="submit"
                            class="track-btn tw-px-8 tw-py-4 tw-bg-gradient-to-r tw-from-orange-500 tw-to-green-600 tw-text-white tw-rounded-xl tw-font-semibold tw-text-lg hover:tw-shadow-lg tw-transition-all tw-border-0 tw-cursor-pointer tw-whitespace-nowrap">
                            @lang('Suivre') <i class="las la-search tw-ml-2"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Order Status Timeline --}}
        <div class="tw-bg-white tw-rounded-2xl tw-shadow-sm tw-border tw-border-gray-100 tw-p-8 lg:tw-p-12">
            <h3 class="tw-text-2xl tw-font-bold tw-text-gray-800 tw-mb-8 tw-text-center">
                @lang('Statut de la commande')
            </h3>

            <div class="order-track-wrapper tw-grid tw-grid-cols-1 sm:tw-grid-cols-2 lg:tw-grid-cols-4 tw-gap-6 lg:tw-gap-8">
                {{-- Pending --}}
                <div class="confirm-state order-track-item tw-text-center">
                    <div class="thumb tw-w-20 tw-h-20 tw-bg-gray-100 tw-rounded-full tw-flex tw-items-center tw-justify-center tw-mx-auto tw-mb-4 tw-transition-all">
                        <i class="las la-check-square tw-text-4xl tw-text-gray-400"></i>
                    </div>
                    <div class="content">
                        <h6 class="title tw-font-semibold tw-text-gray-800 tw-mb-2">@lang('En attente')</h6>
                        <div class="tw-w-12 tw-h-1 tw-bg-gray-200 tw-rounded-full tw-mx-auto tw-mt-3"></div>
                    </div>
                </div>

                {{-- Processing --}}
                <div class="order-track-item processing-state tw-text-center">
                    <div class="thumb tw-w-20 tw-h-20 tw-bg-gray-100 tw-rounded-full tw-flex tw-items-center tw-justify-center tw-mx-auto tw-mb-4 tw-transition-all">
                        <i class="las la-sync-alt tw-text-4xl tw-text-gray-400"></i>
                    </div>
                    <div class="content">
                        <h6 class="title tw-font-semibold tw-text-gray-800 tw-mb-2">@lang('En traitement')</h6>
                        <div class="tw-w-12 tw-h-1 tw-bg-gray-200 tw-rounded-full tw-mx-auto tw-mt-3"></div>
                    </div>
                </div>

                {{-- Dispatched --}}
                <div class="order-track-item dispatched-state tw-text-center">
                    <div class="thumb tw-w-20 tw-h-20 tw-bg-gray-100 tw-rounded-full tw-flex tw-items-center tw-justify-center tw-mx-auto tw-mb-4 tw-transition-all">
                        <i class="las la-truck-pickup tw-text-4xl tw-text-gray-400"></i>
                    </div>
                    <div class="content">
                        <h6 class="title tw-font-semibold tw-text-gray-800 tw-mb-2">@lang('Expédié')</h6>
                        <div class="tw-w-12 tw-h-1 tw-bg-gray-200 tw-rounded-full tw-mx-auto tw-mt-3"></div>
                    </div>
                </div>

                {{-- Delivered --}}
                <div class="order-track-item delivered-state tw-text-center">
                    <div class="thumb tw-w-20 tw-h-20 tw-bg-gray-100 tw-rounded-full tw-flex tw-items-center tw-justify-center tw-mx-auto tw-mb-4 tw-transition-all">
                        <i class="las la-map-signs tw-text-4xl tw-text-gray-400"></i>
                    </div>
                    <div class="content">
                        <h6 class="title tw-font-semibold tw-text-gray-800 tw-mb-2">@lang('Livré')</h6>
                        <div class="tw-w-12 tw-h-1 tw-bg-gray-200 tw-rounded-full tw-mx-auto tw-mt-3"></div>
                    </div>
                </div>
            </div>

            {{-- Help Text --}}
            <div class="tw-mt-12 tw-text-center tw-text-gray-600">
                <p class="tw-mb-0">
                    @lang('Besoin d\'aide ?')
                    <a href="{{ route('contact') }}" class="tw-text-orange-500 hover:tw-text-orange-600 tw-font-medium tw-no-underline">
                        @lang('Contactez notre service client')
                    </a>
                </p>
            </div>
        </div>

    </div>
</section>

@endsection

@push('script')
    <script>
        'use strict';
        (function($) {
            $(document).on('submit', '#order-track', function(e) {
                e.preventDefault();

                let orderNumber = $('input[name=order_number]').val();

                $.get(`{{ url('order-data') }}/${orderNumber}`, function(response) {
                    if (response.success) {
                        if (response.status == {{ Status::ORDER_CANCELED }}) {
                            $('.confirm-state, .processing-state, .dispatched-state, .delivered-state').removeClass('active');
                            notify('error', 'This order is canceled by admin');
                        } else if (response.status == {{ Status::ORDER_RETURNED }}) {
                            $('.confirm-state, .processing-state, .dispatched-state, .delivered-state').removeClass('active');
                            notify('error', 'This order is cancelled by the customer');
                        } else {
                            response.status >= '{{ Status::ORDER_PENDING }}' ? $('.confirm-state').addClass('active') : $('.confirm-state').removeClass('active');

                            response.status >= '{{ Status::ORDER_PROCESSING }}' ? $('.processing-state').addClass('active') : $('.processing-state').removeClass('active');

                            response.status >= '{{ Status::ORDER_DISPATCHED }}' ? $('.dispatched-state').addClass('active') : $('.dispatched-state').removeClass('active');

                            response.status >= '{{ Status::ORDER_DELIVERED }}' ? $('.delivered-state').addClass('active') : $('.delivered-state').removeClass('active');
                        }
                    } else {
                        $('.confirm-state, .processing-state, .dispatched-state, .delivered-state').removeClass('active');
                        notify('error', response.error);
                    }

                    $('.track-btn').attr('disabled', false);
                });
            });
        })(jQuery)
    </script>
@endpush

@push('style')
    <style>
        /* EtsMory Order Track Active States */
        .order-track-item.active .thumb {
            background: linear-gradient(135deg, #f97316 0%, #16a34a 100%);
        }
        .order-track-item.active .thumb i {
            color: white;
        }
        .order-track-item.active .content .tw-w-12 {
            background: linear-gradient(90deg, #f97316 0%, #16a34a 100%);
        }
    </style>
@endpush
