@php
    $footer = getContent('footer.content', true);
    $footerData = @$footer->data_values;
    $socials = getContent('social_icon.element', orderById: true);
@endphp

<footer class="tw-bg-gray-900 tw-text-gray-300 tw-mt-8">
    <div class="tw-max-w-7xl tw-mx-auto tw-px-4 tw-py-12">
        <div class="tw-grid tw-grid-cols-2 lg:tw-grid-cols-5 tw-gap-8">
            {{-- Brand --}}
            <div class="tw-col-span-2 lg:tw-col-span-1">
                <a href="{{ route('home') }}" class="tw-flex tw-items-center tw-gap-2 tw-mb-4 tw-no-underline">
                    <span class="tw-text-2xl">🛒</span>
                    <h3 class="tw-text-xl tw-font-extrabold tw-mb-0">
                        <span class="tw-text-orange-400">{{ gs('site_name') ? substr(gs('site_name'), 0, 2) : 'Et' }}</span><span class="tw-text-green-400">{{ gs('site_name') ? substr(gs('site_name'), 2) : 'Smory' }}</span>
                    </h3>
                </a>
                @if(@$footerData->footer_note)
                <p class="tw-text-sm tw-text-gray-400 tw-mb-4 tw-leading-relaxed">{{ __(@$footerData->footer_note) }}</p>
                @else
                <p class="tw-text-sm tw-text-gray-400 tw-mb-4 tw-leading-relaxed">@lang("Votre supermarché en ligne. Produits frais et épicerie livrés à domicile.")</p>
                @endif
                @if($socials->count() > 0)
                <div class="tw-flex tw-gap-3">
                    @foreach($socials as $social)
                    <a href="{{ $social->data_values->url }}" target="_blank" class="tw-w-9 tw-h-9 tw-bg-gray-800 tw-rounded-lg tw-flex tw-items-center tw-justify-center hover:tw-bg-orange-600 tw-transition-colors tw-text-gray-300 tw-no-underline">
                        {!! $social->data_values->social_icon !!}
                    </a>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- Navigation --}}
            <div>
                <h4 class="tw-text-white tw-font-semibold tw-mb-4">@lang('Navigation')</h4>
                <ul class="tw-space-y-2 tw-text-sm tw-list-none tw-pl-0">
                    <li><a href="{{ route('home') }}" class="hover:tw-text-orange-400 tw-transition-colors tw-text-gray-300 tw-no-underline">@lang('Accueil')</a></li>
                    <li><a href="{{ route('product.all') }}" class="hover:tw-text-orange-400 tw-transition-colors tw-text-gray-300 tw-no-underline">@lang('Boutique')</a></li>
                    <li><a href="{{ route('wishlist.page') }}" class="hover:tw-text-orange-400 tw-transition-colors tw-text-gray-300 tw-no-underline">@lang('Favoris')</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:tw-text-orange-400 tw-transition-colors tw-text-gray-300 tw-no-underline">@lang('Contact')</a></li>
                </ul>
            </div>

            {{-- Categories --}}
            <div>
                <h4 class="tw-text-white tw-font-semibold tw-mb-4">@lang('Catégories')</h4>
                <ul class="tw-space-y-2 tw-text-sm tw-list-none tw-pl-0">
                    @foreach($parentCategories->take(5) as $category)
                    <li><a href="{{ route('product.by.category', $category->slug) }}" class="hover:tw-text-orange-400 tw-transition-colors tw-text-gray-300 tw-no-underline">{{ __($category->name) }}</a></li>
                    @endforeach
                </ul>
            </div>

            {{-- Service client --}}
            <div>
                <h4 class="tw-text-white tw-font-semibold tw-mb-4">@lang('Service client')</h4>
                <ul class="tw-space-y-2 tw-text-sm tw-list-none tw-pl-0">
                    <li><a href="{{ route('order.track') }}" class="hover:tw-text-orange-400 tw-transition-colors tw-text-gray-300 tw-no-underline">@lang('Suivre ma commande')</a></li>
                    <li><a href="{{ route('faq') }}" class="hover:tw-text-orange-400 tw-transition-colors tw-text-gray-300 tw-no-underline">@lang('FAQ')</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:tw-text-orange-400 tw-transition-colors tw-text-gray-300 tw-no-underline">@lang('Aide & Support')</a></li>
                </ul>
            </div>

            {{-- Newsletter --}}
            <div>
                <h4 class="tw-text-white tw-font-semibold tw-mb-4">@lang('Newsletter')</h4>
                <p class="tw-text-sm tw-text-gray-400 tw-mb-3">@lang('Restez informé de nos offres spéciales')</p>
                @if(gs('subscriber_module'))
                <form class="tw-flex tw-gap-2 footer-subscribe-form">
                    <input type="email" name="email" placeholder="@lang('Votre email')" required
                        class="tw-flex-1 tw-px-3 tw-py-2 tw-bg-gray-800 tw-border tw-border-gray-700 tw-rounded-lg tw-text-sm focus:tw-border-orange-500 focus:tw-outline-none tw-text-white">
                    <button type="submit" class="tw-px-4 tw-py-2 tw-bg-orange-500 tw-text-white tw-rounded-lg hover:tw-bg-orange-600 tw-transition-colors tw-text-sm tw-font-medium tw-border-0">
                        @lang("S'abonner")
                    </button>
                </form>
                @push('script')
                <script>
                    (function($) {
                        'use strict';
                        $('.footer-subscribe-form').on('submit', function(e) {
                            e.preventDefault();
                            var email = $(this).find('input[name=email]').val();
                            if (!email) { notify('error', '@lang("Le champ email est requis")'); return; }
                            $.post("{{ route('subscribe') }}", { email: email, _token: '{{ csrf_token() }}' }, function(response) {
                                notify(response.status ? 'success' : 'error', response.message);
                                if (response.status) $('.footer-subscribe-form input[name=email]').val('');
                            });
                        });
                    })(jQuery);
                </script>
                @endpush
                @endif
            </div>
        </div>

        <div class="tw-border-t tw-border-gray-800 tw-mt-8 tw-pt-8 tw-text-center tw-text-sm tw-text-gray-400">
            <p>&copy; {{ date('Y') }} {{ gs('site_name') }}. @lang('Tous droits réservés.')</p>
        </div>
    </div>
</footer>

{{-- Quick View Modal (kept from original) --}}
<div class="modal fade" id="quickView">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <button type="button" class="close modal-close-btn" data-bs-dismiss="modal" aria-label="Close">
                <i class="las la-times"></i>
            </button>
            <div class="modal-body">
                <div class="ajax-loader-wrapper d-flex align-items-center justify-content-center">
                    <div class="spinner-border" role="status">
                        <span class="sr-only">@lang('Loading')...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
