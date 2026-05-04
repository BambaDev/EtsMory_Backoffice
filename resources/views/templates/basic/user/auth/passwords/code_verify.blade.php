@extends('Template::layouts.auth')
@section('content')
    <div class="container">
        <div class="d-flex justify-content-center">
            <div class="tw-w-full tw-max-w-md tw-px-4">
                {{-- Verification Code Card --}}
                <div class="tw-bg-white tw-rounded-2xl tw-shadow-sm tw-border tw-border-gray-100 tw-overflow-hidden tw-p-6">
                    {{-- Logo --}}
                    <div class="tw-text-center tw-mb-5">
                        <a href="{{ route('home') }}" class="tw-inline-block">
                            <img src="{{ siteLogo('dark') }}" alt="@lang('logo')">
                        </a>
                    </div>

                    {{-- Title --}}
                    <div class="tw-text-center tw-mb-5">
                        <h5 class="tw-font-bold tw-text-gray-800 tw-mb-2">@lang('Verify Email Address')</h5>
                        <p class="tw-text-sm tw-text-gray-500 tw-mb-0">@lang('A 6 digit verification code sent to your email address') : {{ showEmailAddress($email) }}</p>
                    </div>

                    {{-- Verification Form --}}
                    <form action="{{ route('user.password.verify.code') }}" method="POST" class="submit-form">
                        @csrf
                        <input type="hidden" name="email" value="{{ $email }}">

                        @include('Template::partials.verification_code')

                        <button type="submit" class="btn btn--base tw-w-full tw-h-11 tw-rounded-lg tw-font-semibold tw-text-sm tw-transition-colors">@lang('Submit')</button>
                    </form>

                    {{-- Resend Link --}}
                    <p class="tw-text-center tw-text-sm tw-text-gray-500 tw-mt-4 tw-mb-0">
                        @lang('Please check including your Junk/Spam Folder. if not found, you can')
                        <a href="{{ route('user.password.request') }}" class="tw-text-orange-500 hover:tw-text-orange-600 tw-font-medium tw-no-underline tw-transition-colors">@lang('Try to send again')</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
