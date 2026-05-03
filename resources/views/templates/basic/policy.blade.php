@extends('Template::layouts.master')

@section('content')

{{-- EtsMory breadcrumb --}}
<div class="tw-bg-gradient-to-r tw-from-orange-50 tw-to-green-50 tw-py-6">
    <div class="tw-max-w-7xl tw-mx-auto tw-px-4">
        <nav class="tw-flex tw-items-center tw-gap-2 tw-text-sm tw-text-gray-600">
            <a href="{{ route('home') }}" class="hover:tw-text-orange-600 tw-no-underline tw-text-gray-600">@lang('Accueil')</a>
            <i class="las la-angle-right tw-text-xs"></i>
            <span class="tw-text-gray-800 tw-font-medium">{{ __(@$policy->data_values->title) }}</span>
        </nav>
    </div>
</div>

{{-- Hero section --}}
<section class="tw-bg-white tw-py-16">
    <div class="tw-max-w-4xl tw-mx-auto tw-px-4 tw-text-center">
        <div class="tw-w-16 tw-h-16 tw-bg-orange-100 tw-rounded-full tw-flex tw-items-center tw-justify-center tw-mx-auto tw-mb-6">
            <i class="las la-file-contract tw-text-4xl tw-text-orange-500"></i>
        </div>
        <h1 class="tw-text-4xl lg:tw-text-5xl tw-font-bold tw-text-gray-800 tw-mb-6">
            {{ __(@$policy->data_values->title) }}
        </h1>
        <p class="tw-text-lg tw-text-gray-600">
            @lang('Dernière mise à jour') : {{ $policy->updated_at->format('d/m/Y') }}
        </p>
    </div>
</section>

{{-- Policy Content --}}
<section class="tw-py-16 tw-bg-gray-50">
    <div class="tw-max-w-4xl tw-mx-auto tw-px-4">
        <div class="tw-bg-white tw-rounded-2xl tw-shadow-sm tw-border tw-border-gray-100 tw-p-8 lg:tw-p-12">
            <div class="policy-content tw-prose tw-prose-lg tw-max-w-none">
                @php
                    echo $policy->data_values->details;
                @endphp
            </div>
        </div>
    </div>
</section>

@endsection
