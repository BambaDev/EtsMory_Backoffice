@extends('Template::layouts.user')
@section('panel')
    {{-- EtsMory Payment History Card --}}
    <div class="tw-bg-white tw-rounded-2xl tw-shadow-sm tw-border tw-border-gray-100 tw-overflow-hidden">
        {{-- Header --}}
        <div class="tw-px-6 tw-py-4 tw-border-b tw-border-gray-100">
            <h5 class="tw-font-bold tw-text-gray-800 tw-mb-0">@lang('Historique des paiements')</h5>
        </div>

        {{-- Table wrapper --}}
        <div class="tw-overflow-x-auto">
            <table class="table table--responsive--lg tw-mb-0">
                <thead class="tw-bg-gray-50">
                    <tr>
                        <th class="tw-text-gray-700 tw-font-semibold">@lang('Transaction ID')</th>
                        <th class="tw-text-gray-700 tw-font-semibold">@lang('Gateway')</th>
                        <th class="tw-text-gray-700 tw-font-semibold">@lang('Amount')</th>
                        <th class="tw-text-gray-700 tw-font-semibold">@lang('Status')</th>
                        <th class="tw-text-gray-700 tw-font-semibold">@lang('Time')</th>
                        <th class="tw-text-gray-700 tw-font-semibold">@lang('View')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($deposits as $deposit)
                        <tr class="tw-border-b tw-border-gray-100 hover:tw-bg-orange-50 tw-transition-colors">
                            <td>
                                <span class="tw-font-mono tw-text-sm tw-text-gray-800">#{{ $deposit->trx }}</span>
                            </td>
                            <td>
                                <span class="tw-text-gray-700">{{ $deposit->gateway ? __($deposit->gateway->name) : '---' }}</span>
                            </td>
                            <td>
                                <span class="tw-font-semibold tw-text-gray-800">
                                    {{ getAmount($deposit->amount) }} {{ gs('cur_text') }}
                                </span>
                            </td>
                            <td>
                                <div class="tw-flex tw-items-center tw-gap-2">
                                    @php echo $deposit->statusBadge @endphp
                                    @if ($deposit->admin_feedback != null)
                                        <button class="btn--base details_info_btn detailBtn tw-w-7 tw-h-7 tw-rounded-full tw-flex tw-items-center tw-justify-center tw-bg-orange-500 hover:tw-bg-orange-600 tw-text-white tw-transition-colors tw-border-0 tw-cursor-pointer"
                                            data-admin_feedback="{{ $deposit->admin_feedback }}">
                                            <i class="fa fa-info tw-text-xs"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span class="tw-text-sm tw-text-gray-600">{{ showDateTime($deposit->created_at, 'd M, Y H:iA') }}</span>
                            </td>

                            @php
                                $details = $deposit->detail != null ? json_encode($deposit->detail) : null;
                            @endphp

                            <td>
                                <button type="button"
                                    class="btn btn-outline--light approveBtn tw-px-4 tw-py-2 tw-rounded-lg tw-border tw-border-orange-500 tw-text-orange-500 hover:tw-bg-orange-500 hover:tw-text-white tw-transition-colors tw-font-medium tw-text-sm"
                                    data-info="{{ $details }}"
                                    data-id="{{ $deposit->id }}"
                                    data-amount="{{ getAmount($deposit->amount) }}"
                                    data-charge="{{ getAmount($deposit->charge) }}"
                                    data-after_charge="{{ getAmount($deposit->amount + $deposit->charge) }} {{ gs('cur_text') }}"
                                    data-rate="{{ getAmount($deposit->rate) }} {{ $deposit->method_currency }}"
                                    data-payable="{{ getAmount($deposit->final_amount) }} {{ $deposit->method_currency }}">
                                    <i class="las la-desktop"></i> @lang('View')
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="tw-text-center tw-py-8">
                                <div class="tw-flex tw-flex-col tw-items-center tw-gap-3">
                                    <div class="tw-w-16 tw-h-16 tw-bg-gray-100 tw-rounded-full tw-flex tw-items-center tw-justify-center">
                                        <i class="las la-receipt tw-text-3xl tw-text-gray-400"></i>
                                    </div>
                                    <p class="tw-text-gray-500 tw-mb-0">@lang('No payment records found')</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($deposits->hasPages())
            <div class="tw-px-6 tw-py-4 tw-border-t tw-border-gray-100">
                {{ paginateLinks($deposits) }}
            </div>
        @endif
    </div>
@endsection

@push('modal')
    {{-- APPROVE MODAL (EtsMory style) --}}
    <div id="approveModal" class="modal custom--modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content tw-rounded-2xl tw-border-0 tw-shadow-2xl">
                <div class="modal-body tw-p-0">
                    {{-- Header --}}
                    <div class="tw-px-6 tw-py-4 tw-border-b tw-border-gray-100 tw-flex tw-items-center tw-justify-between">
                        <h5 class="modal-title tw-font-bold tw-text-gray-800 tw-mb-0">@lang('Détails du paiement')</h5>
                        <button type="button" class="close modal-close-btn tw-w-8 tw-h-8 tw-rounded-full tw-flex tw-items-center tw-justify-center hover:tw-bg-gray-100 tw-transition-colors tw-border-0 tw-cursor-pointer" data-bs-dismiss="modal" aria-label="Close">
                            <i class="las la-times tw-text-xl tw-text-gray-600"></i>
                        </button>
                    </div>

                    {{-- Body --}}
                    <div class="tw-p-6">
                        <ul class="list-group list-group-flush tw-space-y-3">
                            <li class="list-group-item d-flex justify-content-between tw-border-0 tw-px-0 tw-py-2">
                                <span class="tw-text-gray-600">@lang('Amount')</span>
                                <span class="deposit-amount tw-font-semibold tw-text-gray-800"></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between tw-border-0 tw-px-0 tw-py-2">
                                <span class="tw-text-gray-600">@lang('Charge')</span>
                                <span class="deposit-charge tw-font-semibold tw-text-gray-800"></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between tw-border-0 tw-px-0 tw-py-2 tw-border-t tw-border-gray-200">
                                <span class="tw-text-gray-600">@lang('After Charge')</span>
                                <span class="deposit-after_charge tw-font-semibold tw-text-gray-800"></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between tw-border-0 tw-px-0 tw-py-2">
                                <span class="tw-text-gray-600">@lang('Conversion Rate')</span>
                                <span class="deposit-rate tw-font-semibold tw-text-gray-800"></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between tw-border-0 tw-px-0 tw-py-2 tw-border-t tw-border-gray-200">
                                <span class="tw-text-gray-700 tw-font-medium">@lang('Payable Amount')</span>
                                <span class="deposit-payable tw-font-bold tw-text-orange-600 tw-text-lg"></span>
                            </li>
                        </ul>

                        <div class="otherInfo d-none tw-mt-6">
                            <h6 class="tw-font-semibold tw-text-gray-800 tw-mb-3">@lang('Others Information')</h6>
                            <ul class="list-group list-group-flush d-flex deposit-detail tw-space-y-2"></ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Detail MODAL (EtsMory style) --}}
    <div id="detailModal" class="modal custom--modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content tw-rounded-2xl tw-border-0 tw-shadow-2xl">
                <div class="modal-header tw-px-6 tw-py-4 tw-border-b tw-border-gray-100">
                    <h5 class="modal-title tw-font-bold tw-text-gray-800 tw-mb-0">@lang('Feedback Administrateur')</h5>
                    <button type="button" class="close tw-w-8 tw-h-8 tw-rounded-full tw-flex tw-items-center tw-justify-center hover:tw-bg-gray-100 tw-transition-colors tw-border-0 tw-cursor-pointer" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times tw-text-xl tw-text-gray-600"></i>
                    </button>
                </div>
                <div class="modal-body tw-p-6">
                    <div class="deposit-detail tw-bg-orange-50 tw-rounded-lg tw-p-4 tw-text-gray-700"></div>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('script')
    <script>
        "use strict";
        (function($) {
            $('.approveBtn').on('click', function() {
                let modal = $('#approveModal');
                modal.find('.deposit-amount').text($(this).data('amount'));
                modal.find('.deposit-charge').text($(this).data('charge'));
                modal.find('.deposit-after_charge').text($(this).data('after_charge'));
                modal.find('.deposit-rate').text($(this).data('rate'));
                modal.find('.deposit-payable').text($(this).data('payable'));

                let userData = $(this).data('info');
                let html = '';

                if (userData) {
                    userData.forEach(element => {
                        if (element.type != 'file') {
                            html += `
                                <li class="list-group-item d-flex justify-content-between rounded-0">
                                    <span> ${element.name}</span> <span>${element.value}</span>
                                </li>`;
                        }
                    });
                }

                if (html) {
                    modal.find('.otherInfo').removeClass('d-none');
                    modal.find('.deposit-detail').html(html);
                } else {
                    modal.find('.otherInfo').addClass('d-none');
                    modal.find('.deposit-detail').html('');
                }
                modal.modal('show');
            });
            $('.detailBtn').on('click', function() {
                let modal = $('#detailModal');
                let feedback = $(this).data('admin_feedback');
                modal.find('.deposit-detail').html(`<p> @lang('${feedback}') </p>`);
                modal.modal('show');
            });
        })(jQuery)
    </script>
@endpush
