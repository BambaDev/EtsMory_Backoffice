@extends('Template::layouts.user')

@section('panel')
    <div class="tw-space-y-6">
        {{-- Profile Header Card --}}
        <div class="tw-bg-white tw-rounded-2xl tw-shadow-sm tw-border tw-border-gray-100 tw-overflow-hidden">
            <div class="tw-px-6 tw-py-5">
                <div class="tw-flex tw-items-center tw-gap-5 tw-flex-wrap">
                    {{-- Avatar --}}
                    <div class="tw-relative tw-flex-shrink-0" style="width:120px;height:120px;">
                        <img id="imagePreview" src="{{ getImage(null) }}" data-src="{{ getAvatar(getFilePath('userProfile') . '/' . $user->image) }}" class="lazyload tw-w-full tw-h-full tw-object-cover tw-rounded-full tw-border tw-border-gray-200" alt="@lang('user')">
                        <label for="file-input" class="file-input-btn tw-cursor-pointer">
                            <i class="la la-edit"></i>
                        </label>
                    </div>

                    {{-- User Info --}}
                    <div class="tw-flex-1 tw-min-w-0">
                        <h5 class="tw-font-bold tw-text-gray-800 tw-mb-1">{{ $user->fullname }}</h5>
                        <p class="tw-text-sm tw-text-gray-500 tw-flex tw-items-center tw-gap-1.5 tw-mb-3">
                            <i class="las la-user-alt"></i>
                            <span>{{ $user->username }}</span>
                        </p>
                        <ul class="tw-flex tw-flex-wrap tw-items-center tw-gap-x-4 tw-gap-y-2 tw-text-sm tw-mb-0 tw-pl-0 tw-list-none">
                            @if ($user->email)
                                <li class="tw-flex tw-items-center tw-gap-1.5">
                                    <i class="las la-envelope tw-text-orange-500"></i>
                                    <span class="tw-text-gray-600">{{ $user->email }}</span>
                                </li>
                            @endif

                            @if ($user->mobileNumber)
                                <li class="tw-flex tw-items-center tw-gap-1.5">
                                    <i class="las la-phone tw-text-orange-500"></i>
                                    <span class="tw-text-gray-600">{{ $user->mobileNumber }}</span>
                                </li>
                            @endif

                            @if ($user->country_name)
                                <li class="tw-flex tw-items-center tw-gap-1.5">
                                    <i class="las la-globe tw-text-orange-500"></i>
                                    <span class="tw-text-gray-600">{{ $user->country_name }}</span>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-- Update Profile Card --}}
        <div class="tw-bg-white tw-rounded-2xl tw-shadow-sm tw-border tw-border-gray-100 tw-overflow-hidden">
            <div class="tw-px-6 tw-py-4 tw-border-b tw-border-gray-100">
                <h5 class="tw-font-bold tw-text-gray-800 tw-mb-0">@lang('Update Your Profile')</h5>
            </div>
            <div class="tw-p-6">
                <form action="" method="post" enctype="multipart/form-data" class="user-profile-form row tw-mb-0">
                    @csrf
                    <input type='file' class="d-none" name="image" id="file-input" accept=".png, .jpg, .jpeg" />

                    <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-2 tw-gap-4">
                        <div>
                            <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-1">@lang('First Name')</label>
                            <input class="form--control tw-w-full tw-px-3 tw-py-2 tw-rounded-lg tw-border tw-border-gray-300 focus:tw-border-orange-500 focus:tw-ring-1 focus:tw-ring-orange-500 focus:tw-outline-none tw-transition-colors" type="text" name="firstname" value="{{ $user->firstname }}" placeholder="@lang('First Name')" required>
                        </div>

                        <div>
                            <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-1">@lang('Last Name')</label>
                            <input class="form--control tw-w-full tw-px-3 tw-py-2 tw-rounded-lg tw-border tw-border-gray-300 focus:tw-border-orange-500 focus:tw-ring-1 focus:tw-ring-orange-500 focus:tw-outline-none tw-transition-colors" type="text" name="lastname" value="{{ $user->lastname }}" placeholder="@lang('Last Name')" required>
                        </div>

                        <div>
                            <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-1">@lang('State')</label>
                            <input class="form--control tw-w-full tw-px-3 tw-py-2 tw-rounded-lg tw-border tw-border-gray-300 focus:tw-border-orange-500 focus:tw-ring-1 focus:tw-ring-orange-500 focus:tw-outline-none tw-transition-colors" type="text" name="state" value="{{ $user->state }}" placeholder="@lang('State')">
                        </div>

                        <div>
                            <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-1">@lang('City')</label>
                            <input class="form--control tw-w-full tw-px-3 tw-py-2 tw-rounded-lg tw-border tw-border-gray-300 focus:tw-border-orange-500 focus:tw-ring-1 focus:tw-ring-orange-500 focus:tw-outline-none tw-transition-colors" type="text" name="city" value="{{ $user->city }}" placeholder="@lang('City')">
                        </div>

                        <div>
                            <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-1">@lang('Zip')</label>
                            <input class="form--control tw-w-full tw-px-3 tw-py-2 tw-rounded-lg tw-border tw-border-gray-300 focus:tw-border-orange-500 focus:tw-ring-1 focus:tw-ring-orange-500 focus:tw-outline-none tw-transition-colors" type="text" name="zip" value="{{ $user->zip }}" placeholder="@lang('Zip')">
                        </div>

                        <div>
                            <label class="tw-block tw-text-sm tw-font-medium tw-text-gray-700 tw-mb-1">@lang('Address')</label>
                            <textarea class="form--control tw-w-full tw-px-3 tw-py-2 tw-rounded-lg tw-border tw-border-gray-300 focus:tw-border-orange-500 focus:tw-ring-1 focus:tw-ring-orange-500 focus:tw-outline-none tw-transition-colors" name="address" rows="3">{{ $user->address }}</textarea>
                        </div>
                    </div>

                    <div class="tw-mt-5">
                        <button type="submit" class="btn btn--base tw-px-6 tw-py-2.5 tw-rounded-lg tw-font-semibold tw-text-sm tw-bg-orange-500 tw-text-white hover:tw-bg-orange-600 tw-transition-colors tw-border-0 tw-no-underline">@lang('Update Profile')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        'use strict';
        (function($) {
            $("#file-input").on('change', function() {
                readURL(this);
            });

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#imagePreview').attr('src', e.target.result);
                        $('#imagePreview').hide();
                        $('#imagePreview').fadeIn(650);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
        })(jQuery)
    </script>
@endpush
