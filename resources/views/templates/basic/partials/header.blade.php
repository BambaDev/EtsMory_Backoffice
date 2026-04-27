{{-- EtsMory TopBar --}}
<div class="tw-bg-orange-500 tw-text-white tw-text-xs sm:tw-text-sm tw-py-2">
    <div class="tw-max-w-7xl tw-mx-auto tw-px-4 tw-flex tw-items-center tw-justify-center tw-gap-2 sm:tw-gap-4">
        <span>🚚 @lang('Livraison gratuite dès 10 000 FCFA')</span>
        <span class="tw-hidden sm:tw-inline">•</span>
        <span>📞 @lang('Support 24/7')</span>
        <span class="tw-hidden sm:tw-inline">•</span>
        <span class="tw-hidden md:tw-inline">⭐ @lang('4.8/5 sur Trustpilot')</span>
    </div>
</div>

{{-- EtsMory Header --}}
<header class="tw-bg-white tw-shadow-sm tw-border-b tw-border-gray-100 tw-sticky tw-top-0 tw-z-40">
    <div class="tw-max-w-7xl tw-mx-auto tw-px-4">
        <div class="tw-flex tw-items-center tw-justify-between tw-h-16">
            {{-- Logo + Nav --}}
            <div class="tw-flex tw-items-center tw-gap-8">
                <a href="{{ route('home') }}" class="tw-flex tw-items-center tw-gap-2 tw-no-underline">
                    <span class="tw-text-2xl">🛒</span>
                    <h1 class="tw-text-xl tw-font-extrabold tw-mb-0">
                        <span class="tw-text-orange-500">{{ gs('site_name') ? substr(gs('site_name'), 0, 2) : 'Et' }}</span><span class="tw-text-green-500">{{ gs('site_name') ? substr(gs('site_name'), 2) : 'Smory' }}</span>
                    </h1>
                </a>
                <nav class="tw-hidden md:tw-flex tw-items-center tw-gap-6">
                    <a href="{{ route('home') }}" class="tw-font-medium tw-no-underline {{ request()->routeIs('home') ? 'tw-text-orange-600' : 'tw-text-gray-700 hover:tw-text-orange-600' }} tw-transition-colors">
                        @lang('Accueil')
                    </a>
                    <a href="{{ route('product.all') }}" class="tw-font-medium tw-no-underline {{ request()->routeIs('product.*') ? 'tw-text-orange-600' : 'tw-text-gray-700 hover:tw-text-orange-600' }} tw-transition-colors">
                        @lang('Boutique')
                    </a>
                    <a href="{{ route('about') }}" class="tw-font-medium tw-no-underline {{ request()->routeIs('about') ? 'tw-text-orange-600' : 'tw-text-gray-700 hover:tw-text-orange-600' }} tw-transition-colors">
                        @lang('À propos')
                    </a>
                    <a href="{{ route('contact') }}" class="tw-font-medium tw-no-underline {{ request()->routeIs('contact') ? 'tw-text-orange-600' : 'tw-text-gray-700 hover:tw-text-orange-600' }} tw-transition-colors">
                        @lang('Contact')
                    </a>
                </nav>
            </div>

            {{-- Right actions --}}
            <div class="tw-flex tw-items-center tw-gap-4">
                {{-- Search --}}
                <form action="{{ route('product.all') }}" method="GET" class="tw-hidden sm:tw-flex tw-items-center tw-bg-gray-100 tw-rounded-xl tw-px-4 tw-py-2 tw-gap-2 tw-flex-1 tw-max-w-md">
                    <i class="las la-search tw-text-gray-400"></i>
                    <input type="text" name="search" placeholder="@lang('Rechercher des produits...')" value="{{ request('search') }}"
                        class="tw-bg-transparent tw-flex-1 tw-outline-none tw-text-sm tw-border-0">
                </form>

                {{-- Account --}}
                @auth
                    <a href="{{ route('user.home') }}" class="tw-hidden md:tw-inline-flex tw-items-center tw-gap-2 tw-px-4 tw-py-2 tw-text-sm tw-font-medium tw-text-gray-700 tw-border tw-border-gray-200 tw-rounded-lg hover:tw-border-orange-400 hover:tw-text-orange-600 tw-transition-colors tw-no-underline">
                        <i class="las la-user tw-text-base"></i>
                        {{ auth()->user()->username }}
                    </a>
                @endauth

                {{-- Wishlist --}}
                @if(gs('product_wishlist'))
                <button class="tw-relative tw-p-2 hover:tw-bg-gray-100 tw-rounded-lg tw-transition-colors tw-border-0 tw-bg-transparent" id="wishlist-open">
                    <i class="las la-heart tw-text-xl"></i>
                    <span class="tw-absolute tw--top-1 tw--right-1 tw-bg-red-500 tw-text-white tw-text-xs tw-rounded-full tw-w-5 tw-h-5 tw-flex tw-items-center tw-justify-center tw-font-bold wishlist-count">0</span>
                </button>
                @endif

                {{-- Cart --}}
                <button class="tw-relative tw-p-2 hover:tw-bg-gray-100 tw-rounded-lg tw-transition-colors tw-border-0 tw-bg-transparent" id="cart-open">
                    <i class="las la-shopping-cart tw-text-xl"></i>
                    <span class="tw-absolute tw--top-1 tw--right-1 tw-bg-orange-500 tw-text-white tw-text-xs tw-rounded-full tw-w-5 tw-h-5 tw-flex tw-items-center tw-justify-center tw-font-bold cartItemCount cart-count">0</span>
                </button>

                {{-- Auth buttons --}}
                @guest
                <div class="tw-hidden sm:tw-flex tw-items-center tw-gap-2 tw-border-l tw-border-gray-200 tw-pl-4 tw-ml-2">
                    <a href="{{ route('user.login') }}" class="tw-px-4 tw-py-2 tw-text-sm tw-font-medium tw-text-orange-600 hover:tw-bg-orange-50 tw-rounded-lg tw-transition-colors tw-no-underline">
                        @lang('Se connecter')
                    </a>
                    <a href="{{ route('user.register') }}" class="tw-px-4 tw-py-2 tw-text-sm tw-font-medium tw-text-white tw-bg-orange-500 hover:tw-bg-orange-600 tw-rounded-lg tw-transition-colors tw-no-underline">
                        @lang("S'inscrire")
                    </a>
                </div>
                @endguest

                {{-- Mobile menu toggle --}}
                <button onclick="document.getElementById('etsmory-mobile-menu').classList.toggle('tw-hidden')" class="md:tw-hidden tw-p-2 hover:tw-bg-gray-100 tw-rounded-lg tw-transition-colors tw-border-0 tw-bg-transparent" id="mobile-menu-toggle">
                    <i class="las la-bars tw-text-xl"></i>
                </button>
            </div>
        </div>

        {{-- Mobile menu --}}
        <div id="etsmory-mobile-menu" class="md:tw-hidden tw-bg-white tw-border-t tw-border-gray-100 tw-py-4 tw-hidden">
            <nav class="tw-flex tw-flex-col tw-gap-4 tw-px-4">
                <a href="{{ route('home') }}" class="tw-text-left tw-font-medium tw-no-underline {{ request()->routeIs('home') ? 'tw-text-orange-600' : 'tw-text-gray-700 hover:tw-text-orange-600' }}">@lang('Accueil')</a>
                <a href="{{ route('product.all') }}" class="tw-text-left tw-font-medium tw-no-underline {{ request()->routeIs('product.*') ? 'tw-text-orange-600' : 'tw-text-gray-700 hover:tw-text-orange-600' }}">@lang('Boutique')</a>
                <a href="{{ route('about') }}" class="tw-text-left tw-font-medium tw-no-underline {{ request()->routeIs('about') ? 'tw-text-orange-600' : 'tw-text-gray-700 hover:tw-text-orange-600' }}">@lang('À propos')</a>
                <a href="{{ route('contact') }}" class="tw-text-left tw-font-medium tw-no-underline {{ request()->routeIs('contact') ? 'tw-text-orange-600' : 'tw-text-gray-700 hover:tw-text-orange-600' }}">@lang('Contact')</a>
            </nav>
            @guest
            <div class="tw-px-4 tw-mt-4 tw-flex tw-gap-2">
                <a href="{{ route('user.login') }}" class="tw-flex-1 tw-text-center tw-px-4 tw-py-3 tw-text-sm tw-font-medium tw-text-orange-600 tw-border tw-border-orange-200 tw-rounded-lg tw-no-underline">@lang('Se connecter')</a>
                <a href="{{ route('user.register') }}" class="tw-flex-1 tw-text-center tw-px-4 tw-py-3 tw-text-sm tw-font-medium tw-text-white tw-bg-orange-500 tw-rounded-lg tw-no-underline">@lang("S'inscrire")</a>
            </div>
            @endguest
            <div class="tw-px-4 tw-mt-4 sm:tw-hidden">
                <form action="{{ route('product.all') }}" method="GET" class="tw-flex tw-items-center tw-bg-gray-100 tw-rounded-xl tw-px-4 tw-py-2 tw-gap-2">
                    <i class="las la-search tw-text-gray-400"></i>
                    <input type="text" name="search" placeholder="@lang('Rechercher des produits...')" class="tw-bg-transparent tw-flex-1 tw-outline-none tw-text-sm tw-border-0">
                </form>
            </div>
        </div>
    </div>
</header>
