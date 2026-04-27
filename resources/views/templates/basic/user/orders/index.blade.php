@extends('Template::layouts.user')

@section('panel')

{{-- Filter tabs --}}
<div class="tw-flex tw-flex-wrap tw-gap-2 tw-mb-6">
    <a href="{{ route('user.orders.all') }}"
        class="nav--link tw-px-4 tw-py-2 tw-rounded-lg tw-text-sm tw-font-medium tw-border tw-no-underline tw-transition-colors {{ menuActive('user.orders.all') }}">
        @lang('All Orders')
    </a>
    <a href="{{ route('user.orders.pending') }}"
        class="nav--link tw-px-4 tw-py-2 tw-rounded-lg tw-text-sm tw-font-medium tw-border tw-no-underline tw-transition-colors {{ menuActive('user.orders.pending') }}">
        @lang('Pending')
    </a>
    <a href="{{ route('user.orders.processing') }}"
        class="nav--link tw-px-4 tw-py-2 tw-rounded-lg tw-text-sm tw-font-medium tw-border tw-no-underline tw-transition-colors {{ menuActive('user.orders.processing') }}">
        @lang('Processing')
    </a>
    <a href="{{ route('user.orders.dispatched') }}"
        class="nav--link tw-px-4 tw-py-2 tw-rounded-lg tw-text-sm tw-font-medium tw-border tw-no-underline tw-transition-colors {{ menuActive('user.orders.dispatched') }}">
        @lang('Dispatched')
    </a>
    <a href="{{ route('user.orders.completed') }}"
        class="nav--link tw-px-4 tw-py-2 tw-rounded-lg tw-text-sm tw-font-medium tw-border tw-no-underline tw-transition-colors {{ menuActive('user.orders.completed') }}">
        @lang('Completed')
    </a>
    <a href="{{ route('user.orders.canceled') }}"
        class="nav--link tw-px-4 tw-py-2 tw-rounded-lg tw-text-sm tw-font-medium tw-border tw-no-underline tw-transition-colors {{ menuActive('user.orders.canceled') }}">
        @lang('Cancelled')
    </a>
</div>

{{-- Orders table — partial unchanged --}}
<div class="tw-bg-white tw-rounded-2xl tw-shadow-sm tw-border tw-border-gray-100 tw-overflow-hidden">
    @include('Template::user.orders.orders_table')
</div>

{{-- Pagination --}}
@if($orders->hasPages())
<div class="tw-mt-4">
    {{ paginateLinks($orders) }}
</div>
@endif

@endsection

@push('style')
<style>
    /* Base tab style */
    .nav--link {
        color: #545454;
        border-color: #e5e7eb;
        background-color: #fff;
    }
    .nav--link:hover {
        border-color: #f97316;
        color: #f97316;
    }
    /* Active tab — EtsMory orange */
    .nav--link.active {
        background-color: #f97316;
        border-color: #f97316;
        color: #fff !important;
    }
    /* "All Orders" tab: always active when on user.orders.all */
    @media (max-width: 575px) {
        .nav--link {
            flex: 1 1 calc(50% - .5rem);
        }
    }
</style>
@endpush
