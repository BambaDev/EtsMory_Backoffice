@extends('Template::layouts.master')
@section('content')
    <div class="py-60">
        <div class="d-flex justify-content-center">
            <div class="tw-w-full tw-max-w-md tw-px-4">
                {{-- Verification Code Card --}}
                <div class="tw-bg-white tw-rounded-2xl tw-shadow-sm tw-border tw-border-gray-100 tw-overflow-hidden tw-p-6">
                    {{-- Title --}}
                    <div class="tw-text-center tw-mb-5">
                        <h5 class="tw-font-bold tw-text-gray-800 tw-mb-2">@lang('Verify Mobile Number')</h5>
                        <p class="tw-text-sm tw-text-gray-500 tw-mb-0">@lang('A 6 digit verification code sent to your mobile number') : +{{ showMobileNumber(auth()->user()->mobile) }}</p>
                    </div>

                    {{-- Verification Form --}}
                    <form action="{{ route('user.verify.mobile') }}" method="POST" class="submit-form">
                        @csrf
                        @include('Template::partials.verification_code')

                        <button type="submit" class="btn btn--base tw-w-full tw-h-11 tw-rounded-lg tw-font-semibold tw-text-sm tw-transition-colors">@lang('Submit')</button>
                    </form>

                    {{-- Resend Link --}}
                    <p class="tw-text-center tw-text-sm tw-text-gray-500 tw-mt-4 tw-mb-0">
                        @lang('If you don\'t get any code'), <span class="countdown-wrapper">@lang('try again after') <span id="countdown" class="tw-fw-bold">--</span> @lang('seconds')</span> <a href="{{ route('user.send.verify.code', 'sms') }}" class="try-again-link d-none tw-text-orange-500 hover:tw-text-orange-600 tw-font-medium tw-no-underline tw-transition-colors"> @lang('Try again')</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        var distance =Number("{{ isset($user->ver_code_send_at) ? $user->ver_code_send_at->addMinutes(2)->timestamp - time() : '' }}");
        var x = setInterval(function() {
            distance--;
            document.getElementById("countdown").innerHTML = distance;
            if (distance <= 0) {
                clearInterval(x);
                document.querySelector('.countdown-wrapper').classList.add('d-none');
                document.querySelector('.try-again-link').classList.remove('d-none');
            }
        }, 1000);
    </script>
@endpush
