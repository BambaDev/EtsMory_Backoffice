@extends('Template::layouts.master')

@section('content')

{{-- EtsMory breadcrumb --}}
<div class="tw-bg-gradient-to-r tw-from-orange-50 tw-to-green-50 tw-py-6">
    <div class="tw-max-w-7xl tw-mx-auto tw-px-4">
        <nav class="tw-flex tw-items-center tw-gap-2 tw-text-sm tw-text-gray-600">
            <a href="{{ route('home') }}" class="hover:tw-text-orange-600 tw-no-underline tw-text-gray-600">@lang('Accueil')</a>
            <i class="las la-angle-right tw-text-xs"></i>
            <span class="tw-text-gray-800 tw-font-medium">@lang('Ma liste de souhaits')</span>
        </nav>
    </div>
</div>

{{-- Page content --}}
<div class="tw-bg-gray-50 tw-min-h-screen tw-py-10">
    <div class="tw-max-w-7xl tw-mx-auto tw-px-4">

        {{-- Header row --}}
        <div class="tw-flex tw-flex-wrap tw-items-center tw-justify-between tw-gap-3 tw-mb-8">
            <div>
                <h1 class="tw-text-2xl lg:tw-text-3xl tw-font-bold tw-text-gray-800">
                    @lang('Ma liste de souhaits')
                </h1>
                @if($wishlists->count() > 0)
                <p class="tw-text-gray-500 tw-mt-1 tw-text-sm">
                    {{ $wishlists->count() }} @lang('article(s) sauvegardé(s)')
                </p>
                @endif
            </div>
            @if($wishlists->count() > 1)
            <button class="removeAllBtn tw-flex tw-items-center tw-gap-2 tw-px-4 tw-py-2 tw-border tw-border-red-300 tw-text-red-500 tw-rounded-lg hover:tw-bg-red-50 tw-transition-colors tw-text-sm tw-font-medium tw-bg-white"
                data-bs-toggle="modal" data-bs-target="#deleteModal">
                <i class="las la-trash-alt"></i>
                @lang('Tout supprimer')
            </button>
            @endif
        </div>

        {{-- Wishlist grid --}}
        <div class="tw-grid tw-grid-cols-2 md:tw-grid-cols-3 lg:tw-grid-cols-4 xl:tw-grid-cols-5 tw-gap-4 wishlist-row">
            @forelse($wishlists as $wishlist)
            <div class="wishlistItem">
                <x-dynamic-component :component="frontendComponent('product-card')" :product="$wishlist->product" :wishlist="$wishlist" />
            </div>
            @empty
            <div class="tw-col-span-full tw-flex tw-flex-col tw-items-center tw-justify-center tw-py-20 tw-text-center">
                <img src="{{ getImage('assets/images/empty_wishlist.png') }}"
                    alt="@lang('Liste vide')"
                    class="tw-w-40 tw-h-40 tw-object-contain tw-mb-6 tw-opacity-60">
                <h3 class="tw-text-xl tw-font-semibold tw-text-gray-700 tw-mb-2">
                    @lang('Votre liste de souhaits est vide')
                </h3>
                <p class="tw-text-gray-500 tw-mb-6">
                    @lang('Ajoutez des produits que vous aimez à votre liste de souhaits.')
                </p>
                <a href="{{ route('product.all') }}"
                    class="tw-inline-block tw-bg-orange-500 tw-text-white tw-px-8 tw-py-3 tw-rounded-full tw-font-semibold hover:tw-bg-orange-600 tw-transition-colors tw-no-underline">
                    @lang('Découvrir la boutique')
                </a>
            </div>
            @endforelse
        </div>

    </div>
</div>

{{-- Delete all confirmation modal --}}
<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content tw-rounded-2xl tw-border-0 tw-shadow-xl">
            <div class="modal-header tw-border-b tw-border-gray-100">
                <h5 class="modal-title tw-font-bold tw-text-gray-800">
                    <i class="las la-exclamation-triangle tw-text-orange-500 tw-mr-2"></i>
                    @lang('Confirmation')
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body tw-py-6">
                <p class="tw-text-gray-600 tw-text-center">
                    @lang('Voulez-vous vraiment supprimer tous les produits de votre liste de souhaits ?')
                </p>
            </div>
            <div class="modal-footer tw-border-t tw-border-gray-100 tw-gap-3">
                <button class="tw-px-6 tw-py-2 tw-rounded-lg tw-border tw-border-gray-300 tw-text-gray-600 hover:tw-bg-gray-50 tw-transition-colors tw-font-medium"
                    data-bs-dismiss="modal" type="button">
                    @lang('Annuler')
                </button>
                <button class="removeWishlist tw-px-6 tw-py-2 tw-rounded-lg tw-bg-red-500 tw-text-white hover:tw-bg-red-600 tw-transition-colors tw-font-medium tw-border-0"
                    data-bs-dismiss="modal" data-id="0" data-page="1" type="submit">
                    @lang('Oui, tout supprimer')
                </button>
            </div>
        </div>
    </div>
</div>

@endsection
