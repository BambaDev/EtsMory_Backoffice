@extends('Template::layouts.user')

@section('panel')

@if($notifications->count())

    {{-- Header --}}
    <div class="tw-flex tw-items-center tw-gap-3 tw-mb-6">
        <div class="tw-w-8 tw-h-8 tw-bg-orange-100 tw-rounded-full tw-flex tw-items-center tw-justify-center">
            <i class="las la-bell tw-text-orange-500"></i>
        </div>
        <h2 class="tw-text-lg tw-font-bold tw-text-gray-800 tw-m-0">{{ __($pageTitle) }}</h2>
    </div>

    {{-- Notification list --}}
    <div class="tw-flex tw-flex-col tw-gap-3">
        @foreach($notifications as $notification)
        <div class="tw-relative tw-flex tw-items-center tw-gap-4 tw-p-4 tw-rounded-xl tw-border tw-transition-all
            @if($notification->is_read)
                tw-bg-white tw-border-gray-100
            @else
                tw-bg-orange-50 tw-border-orange-200
            @endif">

            {{-- Full-area link overlay — preserves click behaviour on entire row --}}
            <a href="{{ route('user.notification.read', encrypt($notification->id)) }}"
                class="tw-absolute tw-inset-0 tw-rounded-xl"></a>

            {{-- Icon --}}
            <div class="tw-w-10 tw-h-10 tw-rounded-lg tw-border tw-border-gray-200 tw-bg-white tw-flex tw-items-center tw-justify-center tw-flex-shrink-0
                @if(!$notification->is_read) tw-border-orange-300 @endif">
                <i class="las la-bell @if($notification->is_read) tw-text-gray-400 @else tw-text-orange-500 @endif"></i>
            </div>

            {{-- Content --}}
            <div class="tw-flex-1 tw-min-w-0">
                <p class="tw-text-sm tw-font-semibold tw-mb-0.5 tw-leading-snug
                    @if($notification->is_read) tw-text-gray-500 @else tw-text-gray-800 @endif"
                    style="-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;display:-webkit-box;">
                    <span class="tw-text-gray-400 tw-font-normal tw-mr-1">
                        {{ $notifications->firstItem() + $loop->index }}.
                    </span>
                    {{ __($notification->title) }}
                </p>
                <small class="tw-text-xs tw-text-gray-400">
                    {{ showDateTime($notification->created_at, 'd M, Y H:iA') }}
                </small>
            </div>

            {{-- Arrow --}}
            <i class="las la-angle-right tw-text-gray-400 tw-flex-shrink-0 tw-relative tw-z-10"></i>
        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    @if($notifications->hasPages())
    <div class="tw-mt-6">
        {{ paginateLinks($notifications) }}
    </div>
    @endif

@else

    {{-- Empty state --}}
    <div class="tw-bg-white tw-rounded-2xl tw-shadow-sm tw-border tw-border-gray-100">
        <div class="card-body">
            <x-dynamic-component :component="frontendComponent('empty-message')" :message="$emptyMessage" :isTable="true" />
        </div>
    </div>

@endif

@endsection
