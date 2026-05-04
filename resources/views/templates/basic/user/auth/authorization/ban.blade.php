@extends('Template::layouts.master')
@section('content')
    <div class="py-60">
        <div class="d-flex justify-content-center">
            <div class="tw-w-full tw-max-w-lg tw-px-4">
                {{-- Banned Card --}}
                <div class="tw-bg-white tw-rounded-2xl tw-shadow-sm tw-border tw-border-red-200 tw-overflow-hidden">
                    <div class="tw-px-6 tw-py-5 tw-text-center tw-border-b tw-border-red-100 tw-bg-red-50">
                        <div class="tw-w-16 tw-h-16 tw-bg-red-100 tw-rounded-full tw-flex tw-items-center tw-justify-center tw-mx-auto tw-mb-4">
                            <i class="las la-ban tw-text-4xl tw-text-red-500"></i>
                        </div>
                        <h3 class="tw-font-bold tw-text-xl tw-text-red-700 tw-mb-0">@lang('You are banned')</h3>
                    </div>
                    <div class="tw-px-6 tw-py-5">
                        <p class="tw-text-sm tw-font-semibold tw-text-gray-700 tw-mb-2">@lang('Reason'):</p>
                        <p class="tw-text-gray-600 tw-mb-0">{{ $user->ban_reason }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
