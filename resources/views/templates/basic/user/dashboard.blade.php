@extends('Template::layouts.user')
@section('panel')
    <div class="notice"></div>

    {{-- EtsMory Stats Grid --}}
    <div class="tw-grid tw-grid-cols-2 md:tw-grid-cols-3 tw-gap-4 tw-mb-6">
        {{-- All Orders --}}
        <a href="{{ route('user.orders.all') }}"
            class="tw-bg-gradient-to-br tw-from-blue-500 tw-to-blue-600 tw-rounded-2xl tw-p-6 tw-text-white hover:tw-shadow-lg tw-transition-all tw-no-underline tw-group">
            <div class="tw-flex tw-items-center tw-gap-4">
                <div class="tw-w-14 tw-h-14 tw-bg-white/20 tw-rounded-full tw-flex tw-items-center tw-justify-center group-hover:tw-scale-110 tw-transition-transform">
                    <i class="las la-list-ul tw-text-3xl"></i>
                </div>
                <div>
                    <h2 class="tw-text-3xl tw-font-bold tw-mb-1">{{ $order['total'] }}</h2>
                    <p class="tw-mb-0 tw-text-sm tw-opacity-90">@lang('All Orders')</p>
                </div>
            </div>
        </a>

        {{-- Pending Orders --}}
        <a href="{{ route('user.orders.pending') }}"
            class="tw-bg-gradient-to-br tw-from-yellow-500 tw-to-orange-500 tw-rounded-2xl tw-p-6 tw-text-white hover:tw-shadow-lg tw-transition-all tw-no-underline tw-group">
            <div class="tw-flex tw-items-center tw-gap-4">
                <div class="tw-w-14 tw-h-14 tw-bg-white/20 tw-rounded-full tw-flex tw-items-center tw-justify-center group-hover:tw-scale-110 tw-transition-transform">
                    <i class="las la-pause-circle tw-text-3xl"></i>
                </div>
                <div>
                    <h2 class="tw-text-3xl tw-font-bold tw-mb-1">{{ $order['pending'] }}</h2>
                    <p class="tw-mb-0 tw-text-sm tw-opacity-90">@lang('Pending Orders')</p>
                </div>
            </div>
        </a>

        {{-- Processing Orders --}}
        <a href="{{ route('user.orders.processing') }}"
            class="tw-bg-gradient-to-br tw-from-orange-500 tw-to-orange-600 tw-rounded-2xl tw-p-6 tw-text-white hover:tw-shadow-lg tw-transition-all tw-no-underline tw-group">
            <div class="tw-flex tw-items-center tw-gap-4">
                <div class="tw-w-14 tw-h-14 tw-bg-white/20 tw-rounded-full tw-flex tw-items-center tw-justify-center group-hover:tw-scale-110 tw-transition-transform">
                    <i class="las la-spinner tw-text-3xl"></i>
                </div>
                <div>
                    <h2 class="tw-text-3xl tw-font-bold tw-mb-1">{{ $order['processing'] }}</h2>
                    <p class="tw-mb-0 tw-text-sm tw-opacity-90">@lang('Processing Orders')</p>
                </div>
            </div>
        </a>

        {{-- Dispatched Orders --}}
        <a href="{{ route('user.orders.dispatched') }}"
            class="tw-bg-gradient-to-br tw-from-purple-500 tw-to-purple-600 tw-rounded-2xl tw-p-6 tw-text-white hover:tw-shadow-lg tw-transition-all tw-no-underline tw-group">
            <div class="tw-flex tw-items-center tw-gap-4">
                <div class="tw-w-14 tw-h-14 tw-bg-white/20 tw-rounded-full tw-flex tw-items-center tw-justify-center group-hover:tw-scale-110 tw-transition-transform">
                    <i class="las la-shopping-basket tw-text-3xl"></i>
                </div>
                <div>
                    <h2 class="tw-text-3xl tw-font-bold tw-mb-1">{{ $order['dispatched'] }}</h2>
                    <p class="tw-mb-0 tw-text-sm tw-opacity-90">@lang('Dispatched Orders')</p>
                </div>
            </div>
        </a>

        {{-- Order Completed --}}
        <a href="{{ route('user.orders.completed') }}"
            class="tw-bg-gradient-to-br tw-from-green-500 tw-to-green-600 tw-rounded-2xl tw-p-6 tw-text-white hover:tw-shadow-lg tw-transition-all tw-no-underline tw-group">
            <div class="tw-flex tw-items-center tw-gap-4">
                <div class="tw-w-14 tw-h-14 tw-bg-white/20 tw-rounded-full tw-flex tw-items-center tw-justify-center group-hover:tw-scale-110 tw-transition-transform">
                    <i class="las la-check-circle tw-text-3xl"></i>
                </div>
                <div>
                    <h2 class="tw-text-3xl tw-font-bold tw-mb-1">{{ $order['delivered'] }}</h2>
                    <p class="tw-mb-0 tw-text-sm tw-opacity-90">@lang('Order Completed')</p>
                </div>
            </div>
        </a>

        {{-- Canceled Orders --}}
        <a href="{{ route('user.orders.canceled') }}"
            class="tw-bg-gradient-to-br tw-from-red-500 tw-to-red-600 tw-rounded-2xl tw-p-6 tw-text-white hover:tw-shadow-lg tw-transition-all tw-no-underline tw-group">
            <div class="tw-flex tw-items-center tw-gap-4">
                <div class="tw-w-14 tw-h-14 tw-bg-white/20 tw-rounded-full tw-flex tw-items-center tw-justify-center group-hover:tw-scale-110 tw-transition-transform">
                    <i class="las la-times-circle tw-text-3xl"></i>
                </div>
                <div>
                    <h2 class="tw-text-3xl tw-font-bold tw-mb-1">{{ $order['canceled'] }}</h2>
                    <p class="tw-mb-0 tw-text-sm tw-opacity-90">@lang('Canceled Orders')</p>
                </div>
            </div>
        </a>
    </div>

    {{-- Latest Orders Section --}}
    <div class="tw-bg-white tw-rounded-2xl tw-shadow-sm tw-border tw-border-gray-100 tw-overflow-hidden">
        <div class="tw-px-6 tw-py-4 tw-border-b tw-border-gray-100">
            <h5 class="tw-font-bold tw-text-gray-800 tw-mb-0">@lang('Latest Orders')</h5>
        </div>
        <div class="tw-p-6">
            @include('Template::user.orders.orders_table', ['orders' => $latestOrders])
        </div>
    </div>
@endsection
