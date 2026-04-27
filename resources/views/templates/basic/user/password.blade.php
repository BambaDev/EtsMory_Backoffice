@extends('Template::layouts.user')

@section('panel')

{{-- Info banner --}}
<div class="tw-flex tw-items-start tw-gap-3 tw-bg-orange-50 tw-border tw-border-orange-200 tw-rounded-xl tw-p-4 tw-mb-6">
    <div class="tw-w-8 tw-h-8 tw-bg-orange-100 tw-rounded-full tw-flex tw-items-center tw-justify-center tw-flex-shrink-0 tw-mt-0.5">
        <i class="las la-info-circle tw-text-orange-500"></i>
    </div>
    <p class="tw-text-sm tw-text-orange-700 tw-m-0 tw-leading-relaxed">
        @lang('For the security of your account, it\'s important to update your password periodically. Regular updates help keep your account safe from unauthorized access.')
    </p>
</div>

{{-- Form card --}}
<div class="tw-bg-white tw-rounded-2xl tw-shadow-sm tw-border tw-border-gray-100 tw-overflow-hidden">
    <div class="tw-px-6 tw-py-4 tw-border-b tw-border-gray-100 tw-flex tw-items-center tw-gap-3">
        <div class="tw-w-8 tw-h-8 tw-bg-orange-100 tw-rounded-full tw-flex tw-items-center tw-justify-center">
            <i class="las la-key tw-text-orange-500"></i>
        </div>
        <h2 class="tw-text-lg tw-font-bold tw-text-gray-800 tw-m-0">@lang('Change Password')</h2>
    </div>

    <div class="tw-p-6">
        <form action="" method="post" class="tw-max-w-md">
            @csrf

            <div class="form-group tw-mb-4">
                <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-1">
                    @lang('Current Password')
                </label>
                <input type="password"
                    class="form--control tw-w-full"
                    name="current_password"
                    required
                    autocomplete="current-password">
            </div>

            <div class="form-group tw-mb-4">
                <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-1">
                    @lang('New Password')
                </label>
                <input type="password"
                    class="form--control tw-w-full @if(gs('secure_password')) secure-password @endif"
                    name="password"
                    required
                    autocomplete="new-password">
            </div>

            <div class="form-group tw-mb-6">
                <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-1">
                    @lang('Confirm Password')
                </label>
                <input type="password"
                    class="form--control tw-w-full"
                    name="password_confirmation"
                    required
                    autocomplete="new-password">
            </div>

            <button type="submit"
                class="tw-w-full tw-py-3 tw-bg-orange-500 tw-text-white tw-rounded-full tw-font-semibold hover:tw-bg-orange-600 tw-transition-colors tw-border-0 tw-cursor-pointer tw-shadow-md">
                @lang('Update Password')
            </button>
        </form>
    </div>
</div>

@endsection

@push('script-lib')
    <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            @if(gs('secure_password'))
                $('input[name=password]').on('input', function() {
                    secure_password($(this));
                });

                $('[name=password]').focus(function() {
                    $(this).closest('.form-group').addClass('hover-input-popup');
                });

                $('[name=password]').focusout(function() {
                    $(this).closest('.form-group').removeClass('hover-input-popup');
                });
            @endif
        })(jQuery);
    </script>
@endpush
