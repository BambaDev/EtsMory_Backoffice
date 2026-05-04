@extends('Template::layouts.master')
@section('content')

{{-- EtsMory breadcrumb --}}
<div class="tw-bg-gradient-to-r tw-from-orange-50 tw-to-green-50 tw-py-6">
    <div class="tw-max-w-7xl tw-mx-auto tw-px-4">
        <nav class="tw-flex tw-items-center tw-gap-2 tw-text-sm tw-text-gray-600">
            <a href="{{ route('home') }}" class="hover:tw-text-orange-600 tw-no-underline tw-text-gray-600">@lang('Accueil')</a>
            <i class="las la-angle-right tw-text-xs"></i>
            <span class="tw-text-gray-800 tw-font-medium">@lang('Comparaison de produits')</span>
        </nav>
    </div>
</div>

{{-- Page content --}}
<div class="tw-bg-gray-50 tw-min-h-screen tw-py-10">
    <div class="tw-max-w-7xl tw-mx-auto tw-px-4">

        @if ($compareProducts->count())
            {{-- Header --}}
            <div class="tw-flex tw-flex-wrap tw-items-center tw-justify-between tw-gap-3 tw-mb-6">
                <div>
                    <h1 class="tw-text-2xl lg:tw-text-3xl tw-font-bold tw-text-gray-800">
                        {{ __($pageTitle) }}
                    </h1>
                    <p class="tw-text-gray-500 tw-mt-1 tw-text-sm">
                        {{ $compareProducts->count() }} {{ Str::plural('produit', $compareProducts->count()) }} @lang('sélectionné(s)')
                    </p>
                </div>
                <form action="{{ route('compare.remove') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="tw-flex tw-items-center tw-gap-2 tw-px-4 tw-py-2 tw-border tw-border-red-300 tw-text-red-500 tw-rounded-lg hover:tw-bg-red-50 tw-transition-colors tw-text-sm tw-font-medium tw-bg-white">
                        <i class="las la-trash-alt"></i>
                        @lang('Tout supprimer')
                    </button>
                </form>
            </div>

            {{-- Products comparison cards --}}
            <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-2 lg:tw-grid-cols-{{ min($compareProducts->count(), 4) }} tw-gap-4 tw-mb-6">
                @foreach ($compareProducts as $compareProduct)
                <div class="tw-bg-white tw-rounded-2xl tw-shadow-sm tw-border tw-border-gray-100 tw-overflow-hidden tw-relative">
                    {{-- Remove button --}}
                    <form action="{{ route('compare.remove', $compareProduct->id) }}" method="POST" class="tw-absolute tw-top-3 tw-right-3 tw-z-10">
                        @csrf
                        <button type="submit"
                            class="tw-w-8 tw-h-8 tw-bg-white/90 tw-backdrop-blur-sm tw-rounded-full tw-flex tw-items-center tw-justify-center tw-text-red-500 hover:tw-bg-red-50 tw-transition-colors tw-border tw-border-gray-200 tw-shadow-sm">
                            <i class="las la-trash tw-text-base"></i>
                        </button>
                    </form>

                    {{-- Product image --}}
                    <div class="tw-p-6 tw-pb-4">
                        <img src="{{ $compareProduct->mainImage(false) }}"
                            alt="{{ $compareProduct->name }}"
                            class="tw-w-full tw-h-48 tw-object-contain tw-mb-4">
                    </div>

                    {{-- Product info --}}
                    <div class="tw-px-6 tw-pb-6">
                        <a href="{{ $compareProduct->link() }}"
                            class="tw-block tw-text-base tw-font-semibold tw-text-gray-800 tw-mb-2 tw-line-clamp-2 tw-no-underline hover:tw-text-orange-600 tw-transition-colors">
                            {{ __($compareProduct->name) }}
                        </a>
                        <div class="tw-text-lg tw-font-bold tw-text-orange-600 tw-mb-3">
                            @php echo $compareProduct->formattedPrice() @endphp
                        </div>

                        @if (gs('product_review'))
                        <div class="tw-flex tw-items-center tw-gap-2 tw-mb-2">
                            <div class="tw-flex tw-items-center tw-gap-0.5">
                                @php echo displayRating($compareProduct->reviews_avg_rating) @endphp
                            </div>
                        </div>
                        <p class="tw-text-xs tw-text-gray-500">
                            @lang('Basé sur') {{ $compareProduct->reviews_count }} @lang('avis')
                        </p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Specifications tables --}}
            @foreach ($specificationTemplate->specifications ?? [] as $groupSpecification)
            <div class="tw-bg-white tw-rounded-2xl tw-shadow-sm tw-border tw-border-gray-100 tw-overflow-hidden tw-mb-4">
                {{-- Group header (collapsible) --}}
                <button type="button"
                    class="sliding-header tw-w-full tw-px-6 tw-py-4 tw-flex tw-items-center tw-justify-between tw-bg-gray-50 hover:tw-bg-gray-100 tw-transition-colors tw-border-0 tw-cursor-pointer tw-text-left">
                    <span class="tw-font-semibold tw-text-gray-800 tw-flex tw-items-center tw-gap-2">
                        <i class="las la-angle-down tw-text-xl tw-transition-transform"></i>
                        {{ __($groupSpecification['group_name']) }}
                    </span>
                </button>

                {{-- Specifications table --}}
                <div class="sliding-body tw-overflow-x-auto">
                    <table class="tw-w-full">
                        <tbody>
                            @foreach ($groupSpecification['attributes'] ?? [] as $singleAttribute)
                            <tr class="tw-border-b tw-border-gray-100 last:tw-border-0">
                                <td class="tw-px-6 tw-py-3 tw-font-medium tw-text-gray-700 tw-bg-gray-50 tw-w-1/4">
                                    {{ $singleAttribute }}
                                </td>
                                @foreach ($compareProducts as $compareProduct)
                                <td class="tw-px-6 tw-py-3 tw-text-gray-600 tw-text-sm">
                                    {{ collect($compareProduct->specification)->where('key', $singleAttribute)?->first()->value ?? '---' }}
                                </td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endforeach

        @else
            {{-- Empty state --}}
            <div class="tw-flex tw-flex-col tw-items-center tw-justify-center tw-py-20 tw-text-center tw-bg-white tw-rounded-2xl tw-shadow-sm tw-border tw-border-gray-100">
                <img src="{{ asset('assets/images/empty_list.png') }}"
                    alt="@lang('Liste vide')"
                    class="tw-w-32 tw-h-32 tw-object-contain tw-mb-6 tw-opacity-60">
                <h3 class="tw-text-xl tw-font-semibold tw-text-gray-700 tw-mb-2">
                    @lang('Aucun produit sélectionné')
                </h3>
                <p class="tw-text-gray-500 tw-mb-6">
                    @lang('Veuillez sélectionner au moins deux produits pour commencer la comparaison.')
                </p>
                <a href="{{ route('product.all') }}"
                    class="tw-inline-block tw-bg-orange-500 tw-text-white tw-px-8 tw-py-3 tw-rounded-full tw-font-semibold hover:tw-bg-orange-600 tw-transition-colors tw-no-underline">
                    @lang('Découvrir la boutique')
                </a>
            </div>
        @endif

    </div>
</div>

@endsection

@push('script')
<script>
    (function($) {
        'use strict';
        $('.sliding-header').on('click', function() {
            const $body = $(this).siblings('.sliding-body');
            const $icon = $(this).find('.las');

            $body.slideToggle(300);
            $icon.toggleClass('tw-rotate-180');
        });
    })(jQuery);
</script>
@endpush
