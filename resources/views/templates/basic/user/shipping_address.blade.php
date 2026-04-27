@extends('Template::layouts.user')

@section('panel')
    {{-- EtsMory Shipping Address Card --}}
    <div class="tw-bg-white tw-rounded-2xl tw-shadow-sm tw-border tw-border-gray-100 tw-overflow-hidden">
        {{-- Header with New Address button --}}
        <div class="tw-px-6 tw-py-4 tw-border-b tw-border-gray-100 tw-flex tw-items-center tw-justify-between tw-flex-wrap tw-gap-3">
            <h5 class="tw-font-bold tw-text-gray-800 tw-mb-0">@lang('Adresses de livraison')</h5>
            <button class="btn btn-outline--light newAddress tw-px-4 tw-py-2 tw-rounded-lg tw-border tw-border-orange-500 tw-text-orange-500 hover:tw-bg-orange-500 hover:tw-text-white tw-transition-colors tw-font-medium tw-text-sm">
                <i class="las la-plus"></i> @lang('New Address')
            </button>
        </div>

        {{-- Table wrapper --}}
        <div class="tw-overflow-x-auto">
            <table class="table table--responsive--lg tw-mb-0">
                <thead class="tw-bg-gray-50">
                    <tr>
                        <th class="tw-text-gray-700 tw-font-semibold">@lang('S.N.')</th>
                        <th class="tw-text-gray-700 tw-font-semibold">@lang('Title')</th>
                        <th class="tw-text-gray-700 tw-font-semibold">@lang('Name')</th>
                        <th class="tw-text-gray-700 tw-font-semibold tw-text-right">@lang('Action')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($shippingAddresses as $address)
                        <tr class="tw-border-b tw-border-gray-100 hover:tw-bg-orange-50 tw-transition-colors">
                            <td>
                                <span class="tw-font-medium tw-text-gray-800">{{ $loop->index + $shippingAddresses->firstItem() }}</span>
                            </td>
                            <td>
                                <span class="tw-font-semibold tw-text-gray-800">{{ __($address->label) }}</span>
                            </td>
                            <td>
                                <span class="tw-text-gray-700">{{ __($address->fullname) }}</span>
                            </td>
                            <td>
                                <div class="d-flex gap-2 flex-wrap justify-content-end">
                                    <button class="btn btn-outline--light editAddress tw-px-3 tw-py-1.5 tw-rounded-lg tw-border tw-border-blue-500 tw-text-blue-500 hover:tw-bg-blue-500 hover:tw-text-white tw-transition-colors tw-font-medium tw-text-sm"
                                        data-resource="{{ $address }}">
                                        <i class="las la-pencil-alt me-0"></i> @lang('Edit')
                                    </button>

                                    <button class="btn btn-outline--light confirmationBtn tw-px-3 tw-py-1.5 tw-rounded-lg tw-border tw-border-red-500 tw-text-red-500 hover:tw-bg-red-500 hover:tw-text-white tw-transition-colors tw-font-medium tw-text-sm"
                                        data-action="{{ route('user.shipping.address.delete', $address->id) }}"
                                        data-question="@lang('Are you sure to delete this shipping address?')">
                                        <i class="las la-trash-alt me-0"></i> @lang('Delete')
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="tw-text-center tw-py-8">
                                <div class="tw-flex tw-flex-col tw-items-center tw-gap-3">
                                    <div class="tw-w-16 tw-h-16 tw-bg-gray-100 tw-rounded-full tw-flex tw-items-center tw-justify-center">
                                        <i class="las la-map-marker-alt tw-text-3xl tw-text-gray-400"></i>
                                    </div>
                                    <p class="tw-text-gray-500 tw-mb-0">@lang('No shipping address added yet')</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($shippingAddresses->hasPages())
            <div class="tw-px-6 tw-py-4 tw-border-t tw-border-gray-100">
                {{ paginateLinks($shippingAddresses) }}
            </div>
        @endif
    </div>
@endsection

@push('modal')
    <x-dynamic-component :component="frontendComponent('shipping-address-modal')" :countries="$countries" />
    <x-confirmation-modal />
@endpush
