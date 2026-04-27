@php
    $image = $product->mainImage();
    $avgRating = $product->reviews_avg_rating ?? ($product->reviews->count() > 0 ? round($product->reviews->avg('rating'), 1) : 0);
    $hasDiscount = $product->sale_price && $product->sale_price < $product->regular_price;
    $discountPercent = $hasDiscount ? round((($product->regular_price - $product->sale_price) / $product->regular_price) * 100) : 0;
    $displayPrice = $hasDiscount ? $product->sale_price : $product->regular_price;
@endphp

<div class="tw-bg-white tw-rounded-xl tw-shadow-sm tw-border tw-border-gray-100 tw-overflow-hidden hover:tw-shadow-md tw-transition-all tw-group">
    <div class="tw-relative">
        <a href="{{ route('product.detail', $product->slug) }}">
            <img src="{{ $image }}" alt="{{ $product->name }}"
                class="tw-w-full tw-h-48 tw-object-cover group-hover:tw-scale-105 tw-transition-transform tw-duration-300">
        </a>
        @if($hasDiscount)
        <div class="tw-absolute tw-top-3 tw-left-3 tw-bg-red-500 tw-text-white tw-px-2 tw-py-1 tw-rounded tw-text-xs tw-font-bold">
            -{{ $discountPercent }}%
        </div>
        @endif
        <div class="tw-absolute tw-top-3 tw-right-3 tw-flex tw-flex-col tw-gap-2">
            <button data-product="{{ $product->slug }}" class="quickViewBtn tw-w-8 tw-h-8 tw-bg-white/90 tw-rounded-full tw-flex tw-items-center tw-justify-center hover:tw-bg-orange-500 hover:tw-text-white tw-transition-colors tw-border-0 tw-shadow-sm"
                data-bs-toggle="modal" data-bs-target="#quickView">
                <i class="las la-eye tw-text-sm"></i>
            </button>
            @if(gs('product_wishlist'))
            <button data-id="{{ $product->id }}" class="addToWishlist tw-w-8 tw-h-8 tw-bg-white/90 tw-rounded-full tw-flex tw-items-center tw-justify-center hover:tw-bg-red-500 hover:tw-text-white tw-transition-colors tw-border-0 tw-shadow-sm">
                <i class="las la-heart tw-text-sm"></i>
            </button>
            @endif
        </div>
    </div>
    <div class="tw-p-4">
        <a href="{{ route('product.detail', $product->slug) }}" class="tw-font-semibold tw-text-gray-800 tw-text-sm tw-line-clamp-2 tw-leading-tight tw-no-underline hover:tw-text-orange-600 tw-transition-colors">
            {{ __($product->name) }}
        </a>
        @if($avgRating > 0)
        <div class="tw-flex tw-items-center tw-gap-1 tw-mt-2">
            @for($i = 1; $i <= 5; $i++)
            <i class="las la-star {{ $i <= $avgRating ? 'tw-text-yellow-400' : 'tw-text-gray-300' }} tw-text-xs"></i>
            @endfor
            <span class="tw-text-xs tw-text-gray-500">({{ $product->reviews->count() }})</span>
        </div>
        @endif
        <div class="tw-flex tw-items-center tw-gap-2 tw-mt-2">
            <span class="tw-text-base tw-font-bold tw-text-orange-600">{{ gs('cur_sym') }}{{ showAmount($displayPrice) }}</span>
            @if($hasDiscount)
            <span class="tw-text-xs tw-text-gray-400 tw-line-through">{{ gs('cur_sym') }}{{ showAmount($product->regular_price) }}</span>
            @endif
        </div>
        @if($product->productVariants && $product->productVariants->count())
        <button data-product="{{ $product->slug }}" class="quickViewBtn tw-w-full tw-mt-3 tw-py-2 tw-bg-orange-500 tw-text-white tw-rounded-lg hover:tw-bg-orange-600 tw-transition-colors tw-font-medium tw-text-sm tw-border-0 tw-cursor-pointer"
            data-bs-toggle="modal" data-bs-target="#quickView">
            <i class="las la-shopping-cart tw-mr-1"></i> @lang('Ajouter au panier')
        </button>
        @else
        <input type="hidden" name="quantity" value="1">
        <button data-id="{{ $product->id }}" data-product_type="{{ $product->product_type }}" class="addToCart tw-w-full tw-mt-3 tw-py-2 tw-bg-orange-500 tw-text-white tw-rounded-lg hover:tw-bg-orange-600 tw-transition-colors tw-font-medium tw-text-sm tw-border-0 tw-cursor-pointer">
            <i class="las la-shopping-cart tw-mr-1"></i> @lang('Ajouter au panier')
        </button>
        @endif
    </div>
</div>
