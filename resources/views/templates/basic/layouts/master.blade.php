@extends('Template::layouts.app')
@section('app')
    @include('Template::partials.header')

    <main class="tw-min-h-screen tw-bg-gray-50">
        @yield('content')
    </main>

    {{-- Cart Sidebar --}}
    @if (!Route::is('cart.page'))
        <div class="site-sidebar cart-sidebar-area" id="cart-sidebar-area">
            <button class="sidebar-close-btn"><i class="las la-times"></i></button>
            <div class="top-content d-flex gap-2">
                <h5 class="cart-sidebar-area__title">@lang('Mon Panier')</h5>
                <a href="{{ route('cart.page') }}" class="text-muted text-decoration-underline">@lang('Voir le panier')</a>
            </div>
            <div class="cart-products cart--products"></div>
        </div>
    @endif

    {{-- Wishlist Sidebar --}}
    @if (gs('product_wishlist'))
        <div class="site-sidebar cart-sidebar-area wishlist-sidebar" id="wish-sidebar-area">
            <button class="sidebar-close-btn"><i class="las la-times"></i></button>
            <div class="top-content d-flex gap-2">
                <h5 class="cart-sidebar-area__title">@lang('Mes Favoris')</h5>
                <a href="{{ route('wishlist.page') }}" class="text-muted text-decoration-underline">@lang('Voir les favoris')</a>
            </div>
            <div class="cart-products wish--products"></div>
        </div>
    @endif

    {{-- Auth Sidebar --}}
    @auth
        <div class="site-sidebar sidebar-nav" id="authSidebarMenu">
            <button type="button" class="sidebar-close-btn"><i class="las la-times"></i></button>
            <ul class="text--white login-user-menu">
                @include('Template::user.partials.sidebar')
            </ul>
        </div>
    @endauth

    @include('Template::partials.footer')

    {{-- Login Modal --}}
    @guest
        <div class="modal custom--modal fade" id="loginModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="close modal-close-btn" data-bs-dismiss="modal" aria-label="Close">
                            <i class="las la-times"></i>
                        </button>
                        @include('Template::partials.login')
                    </div>
                </div>
            </div>
        </div>
    @endguest

    @if (gs('guest_checkout'))
        @guest
            @include('Template::partials.guest_user_info')
        @endguest
    @endif

    {{-- Cookie Consent --}}
    @php
        $cookie = App\Models\Frontend::where('data_keys', 'cookie.data')->first();
    @endphp
    @if ($cookie && @$cookie->data_values->status == Status::ENABLE && !\Cookie::get('gdpr_cookie'))
        <div class="cookies-card text-center hide">
            <div class="cookies-card__icon bg--base"><i class="las la-cookie-bite"></i></div>
            <p class="mt-4 cookies-card__content">{{ $cookie->data_values->short_desc }}
                <a href="{{ route('cookie.policy') }}" target="_blank" class="text--base">@lang('En savoir plus')</a>
            </p>
            <div class="cookies-card__btn mt-4">
                <a class="btn btn--base w-100 policy h-45" href="javascript:void(0)">@lang('Accepter')</a>
            </div>
        </div>
    @endif

    {{-- Back to Top --}}
    <button onclick="window.scrollTo({top:0,behavior:'smooth'})" id="etsmory-back-to-top"
        class="tw-fixed tw-bottom-20 tw-right-4 tw-bg-orange-500 tw-text-white tw-p-3 tw-rounded-full tw-shadow-lg hover:tw-bg-orange-600 tw-transition-colors tw-z-40 tw-border-0 tw-hidden">
        <i class="las la-angle-up tw-text-xl"></i>
    </button>

    {{-- WhatsApp Button --}}
    <a href="https://wa.me/2250700000000" target="_blank" rel="noopener noreferrer"
        class="tw-fixed tw-bottom-4 tw-right-4 tw-bg-green-500 tw-text-white tw-p-3 tw-rounded-full tw-shadow-lg hover:tw-bg-green-600 tw-transition-colors tw-z-40 tw-no-underline">
        <i class="lab la-whatsapp tw-text-2xl"></i>
    </a>
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";

            // Login trigger
            $(document).on('click', '.login-trigger', function() {
                $(".sidebar-close-btn").trigger('click');
            });

            // Cookie consent
            $('.policy').on('click', function() {
                $.get("{{ route('cookie.accept') }}", function(response) {
                    $('.cookies-card').addClass('d-none');
                });
            });

            // Back to top visibility
            $(window).on('scroll', function() {
                $('#etsmory-back-to-top').toggleClass('tw-hidden', $(window).scrollTop() <= 300);
            });

            // Cart sidebar open
            $('#cart-open').on('click', function() {
                $('#cart-sidebar-area').addClass('active');
                $('#body-overlay').addClass('active');
            });

            // Wishlist sidebar open
            $('#wishlist-open').on('click', function() {
                $('#wish-sidebar-area').addClass('active');
                $('#body-overlay').addClass('active');
            });
        })(jQuery);
    </script>

    <x-frontend.visermart-script />
@endpush

@push('style-lib')
    <script src="{{ asset(activeTemplate(true) . 'js/lazyload.js') }}"></script>
@endpush
