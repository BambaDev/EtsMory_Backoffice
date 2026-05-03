@extends('Template::layouts.master')

@section('content')

{{-- EtsMory breadcrumb --}}
<div class="tw-bg-gradient-to-r tw-from-orange-50 tw-to-green-50 tw-py-6">
    <div class="tw-max-w-7xl tw-mx-auto tw-px-4">
        <nav class="tw-flex tw-items-center tw-gap-2 tw-text-sm tw-text-gray-600">
            <a href="{{ route('home') }}" class="hover:tw-text-orange-600 tw-no-underline tw-text-gray-600">@lang('Accueil')</a>
            <i class="las la-angle-right tw-text-xs"></i>
            <span class="tw-text-gray-800 tw-font-medium">@lang('Contact')</span>
        </nav>
    </div>
</div>

{{-- Hero section --}}
<section class="tw-bg-white tw-py-16">
    <div class="tw-max-w-7xl tw-mx-auto tw-px-4 tw-text-center">
        <div class="tw-w-16 tw-h-16 tw-bg-orange-100 tw-rounded-full tw-flex tw-items-center tw-justify-center tw-mx-auto tw-mb-6">
            <i class="las la-envelope tw-text-4xl tw-text-orange-500"></i>
        </div>
        <h1 class="tw-text-4xl lg:tw-text-5xl tw-font-bold tw-text-gray-800 tw-mb-6">
            @lang('Contactez-nous')
        </h1>
        <p class="tw-text-xl tw-text-gray-600 tw-max-w-2xl tw-mx-auto">
            @lang('Notre équipe est à votre écoute. N\'hésitez pas à nous contacter pour toute question ou suggestion.')
        </p>
    </div>
</section>

{{-- Contact Section --}}
<section class="tw-py-16 tw-bg-gray-50">
    <div class="tw-max-w-7xl tw-mx-auto tw-px-4">
        <div class="tw-grid tw-grid-cols-1 lg:tw-grid-cols-5 tw-gap-8">

            {{-- Contact Info (2/5) --}}
            <div class="lg:tw-col-span-2">
                <div class="tw-space-y-6">
                    {{-- Address Card --}}
                    <div class="tw-bg-white tw-rounded-2xl tw-p-6 tw-shadow-sm">
                        <div class="tw-flex tw-items-start tw-gap-4">
                            <div class="tw-w-12 tw-h-12 tw-bg-orange-100 tw-rounded-full tw-flex tw-items-center tw-justify-center tw-flex-shrink-0">
                                <i class="las la-map-marker-alt tw-text-2xl tw-text-orange-500"></i>
                            </div>
                            <div>
                                <h3 class="tw-font-semibold tw-text-gray-800 tw-mb-2">@lang('Adresse')</h3>
                                <p class="tw-text-gray-600">
                                    Abidjan, Côte d'Ivoire
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Phone Card --}}
                    <div class="tw-bg-white tw-rounded-2xl tw-p-6 tw-shadow-sm">
                        <div class="tw-flex tw-items-start tw-gap-4">
                            <div class="tw-w-12 tw-h-12 tw-bg-green-100 tw-rounded-full tw-flex tw-items-center tw-justify-center tw-flex-shrink-0">
                                <i class="las la-phone tw-text-2xl tw-text-green-600"></i>
                            </div>
                            <div>
                                <h3 class="tw-font-semibold tw-text-gray-800 tw-mb-2">@lang('Téléphone')</h3>
                                <p class="tw-text-gray-600">
                                    +225 07 00 00 00 00
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Email Card --}}
                    <div class="tw-bg-white tw-rounded-2xl tw-p-6 tw-shadow-sm">
                        <div class="tw-flex tw-items-start tw-gap-4">
                            <div class="tw-w-12 tw-h-12 tw-bg-orange-100 tw-rounded-full tw-flex tw-items-center tw-justify-center tw-flex-shrink-0">
                                <i class="las la-envelope tw-text-2xl tw-text-orange-500"></i>
                            </div>
                            <div>
                                <h3 class="tw-font-semibold tw-text-gray-800 tw-mb-2">@lang('Email')</h3>
                                <p class="tw-text-gray-600">
                                    contact@{{ gs('site_name') ? strtolower(str_replace(' ', '', gs('site_name'))) : 'etsmory' }}.com
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Hours Card --}}
                    <div class="tw-bg-white tw-rounded-2xl tw-p-6 tw-shadow-sm">
                        <div class="tw-flex tw-items-start tw-gap-4">
                            <div class="tw-w-12 tw-h-12 tw-bg-green-100 tw-rounded-full tw-flex tw-items-center tw-justify-center tw-flex-shrink-0">
                                <i class="las la-clock tw-text-2xl tw-text-green-600"></i>
                            </div>
                            <div>
                                <h3 class="tw-font-semibold tw-text-gray-800 tw-mb-2">@lang('Horaires')</h3>
                                <p class="tw-text-gray-600 tw-text-sm">
                                    @lang('Lundi - Vendredi'): 8h - 20h<br>
                                    @lang('Samedi - Dimanche'): 9h - 18h
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Contact Form (3/5) --}}
            <div class="lg:tw-col-span-3">
                <div class="tw-bg-white tw-rounded-2xl tw-shadow-sm tw-p-8">
                    <h2 class="tw-text-2xl tw-font-bold tw-text-gray-800 tw-mb-6">
                        @lang('Envoyez-nous un message')
                    </h2>

                    <form action="{{ route('contact.submit') }}" method="post" class="tw-space-y-6">
                        @csrf

                        <div>
                            <label for="fullname" class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">
                                @lang('Nom complet')
                            </label>
                            <input type="text"
                                class="form-control form--control tw-w-full tw-px-4 tw-py-3 tw-rounded-lg tw-border tw-border-gray-300 focus:tw-border-orange-500 focus:tw-ring-1 focus:tw-ring-orange-500 focus:tw-outline-none"
                                id="fullname"
                                name="name"
                                value="{{ old('name', @$user->fullname) }}"
                                @if($user) readonly @endif
                                required>
                        </div>

                        <div>
                            <label for="email" class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">
                                @lang('Email')
                            </label>
                            <input type="email"
                                class="form-control form--control tw-w-full tw-px-4 tw-py-3 tw-rounded-lg tw-border tw-border-gray-300 focus:tw-border-orange-500 focus:tw-ring-1 focus:tw-ring-orange-500 focus:tw-outline-none"
                                id="email"
                                name="email"
                                value="{{ old('email', @$user->email) }}"
                                @if($user) readonly @endif
                                required>
                        </div>

                        <div>
                            <label for="subject" class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">
                                @lang('Sujet')
                            </label>
                            <input type="text"
                                class="form-control form--control tw-w-full tw-px-4 tw-py-3 tw-rounded-lg tw-border tw-border-gray-300 focus:tw-border-orange-500 focus:tw-ring-1 focus:tw-ring-orange-500 focus:tw-outline-none"
                                id="subject"
                                name="subject"
                                value="{{ old('subject') }}"
                                required>
                        </div>

                        <div>
                            <label for="message" class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-2">
                                @lang('Message')
                            </label>
                            <textarea class="form-control form--control tw-w-full tw-px-4 tw-py-3 tw-rounded-lg tw-border tw-border-gray-300 focus:tw-border-orange-500 focus:tw-ring-1 focus:tw-ring-orange-500 focus:tw-outline-none"
                                name="message"
                                rows="5"
                                id="message"
                                required>{{ old('message') }}</textarea>
                        </div>

                        <x-captcha />

                        <button type="submit"
                            class="tw-w-full tw-bg-orange-500 tw-text-white tw-px-8 tw-py-4 tw-rounded-full tw-font-semibold tw-text-lg hover:tw-bg-orange-600 tw-transition-colors tw-border-0 tw-cursor-pointer tw-shadow-lg">
                            @lang('Envoyer le message') <i class="las la-paper-plane tw-ml-2"></i>
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
