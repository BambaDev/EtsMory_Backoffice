@extends('Template::layouts.auth')
@section('content')
    @php
        $loginContent = getContent('login_page.content', true);
    @endphp
    <div class="container">
        <div class="row g-4 gy-lg-0 @if ($loginContent->data_values->image) justify-content-between @else justify-content-center @endif flex-wrap-reverse align-items-center">
            @if ($loginContent->data_values->image)
                <div class="col-lg-6 col-xxl-7 d-none d-lg-block">
                    <div class="text-center pe-xl-5">
                        <img src="{{ frontendImage('login_page', @$loginContent->data_values->image, '600x840') }}" alt="image" class="img-fluid">
                    </div>
                </div>
            @endif

            <div class="@if ($loginContent->data_values->image) col-lg-6 col-xxl-5 @else col-xl-5 col-lg-7 col-md-9 @endif">
                <div class="tw-w-full tw-max-w-md tw-px-4 mx-auto">
                    {{-- Login Card --}}
                    <div class="tw-bg-white tw-rounded-2xl tw-shadow-sm tw-border tw-border-gray-100 tw-overflow-hidden tw-p-6">
                        {{-- Header --}}
                        <div class="tw-text-center tw-mb-5">
                            <div class="logo tw-mb-3">
                                <a href="{{ route('home') }}"><img src="{{ siteLogo('dark') }}" alt="@lang('logo')"></a>
                            </div>
                        </div>

                        <div class="tw-mb-5">
                            <form method="POST" action="{{ route('user.login') }}">
                                @csrf
                                <div class="tw-mb-4">
                                    <label class="form--label tw-text-sm tw-font-medium tw-text-gray-700">@lang('Username')</label>
                                    <input class="form--control tw-w-full tw-px-3 tw-py-2 tw-rounded-lg tw-border tw-border-gray-300 focus:tw-border-orange-500 focus:tw-ring-1 focus:tw-ring-orange-500 focus:tw-outline-none tw-transition-colors" type="text" name="username" value="{{ old('username') }}" placeholder="@lang('Username')" required autofocus>
                                </div>

                                <div class="tw-mb-4">
                                    <label class="form--label tw-text-sm tw-font-medium tw-text-gray-700" for="password">@lang('Password')</label>
                                    <input id="password" type="password" name="password" class="form--control tw-w-full tw-px-3 tw-py-2 tw-rounded-lg tw-border tw-border-gray-300 focus:tw-border-orange-500 focus:tw-ring-1 focus:tw-ring-orange-500 focus:tw-outline-none tw-transition-colors" placeholder="@lang('Enter Your Password')" required autocomplete="current-password">
                                </div>

                                <div class="tw-flex tw-items-center tw-justify-content-between tw-mb-4">
                                    <div class="form-check form--check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                        <label class="form-check-label tw-text-sm tw-text-gray-600" for="remember">
                                            @lang('Remember Me')
                                        </label>
                                    </div>

                                    <a href="{{ route('user.password.request') }}" class="t-link tw-text-sm tw-text-orange-500 hover:tw-text-orange-600 tw-font-medium tw-no-underline tw-transition-colors">
                                        @lang('Forgot Password?')
                                    </a>
                                </div>

                                <x-captcha />

                                <button class="btn btn--base tw-w-full tw-h-11 tw-rounded-lg tw-font-semibold tw-text-sm tw-transition-colors" type="submit" id="recaptcha">@lang('Login Account')</button>

                                @if (Route::has('user.register'))
                                    <p class="tw-mt-3 tw-mb-0 tw-text-sm tw-text-gray-600">
                                        @lang('Don\'t have an account') ? <a href="{{ route('user.register') }}" class="t-link tw-text-orange-500 hover:tw-text-orange-600 tw-font-medium tw-no-underline tw-transition-colors">@lang('Create An Account')</a>
                                    </p>
                                @endif
                            </form>
                        </div>

                        @include('Template::partials.social_login')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
