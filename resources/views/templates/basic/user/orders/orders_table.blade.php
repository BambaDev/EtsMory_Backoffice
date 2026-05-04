{{-- EtsMory Orders Table --}}
<div class="tw-overflow-x-auto">
    <table class="table table--responsive--md tw-mb-0">
        <thead class="tw-bg-gray-50">
            <tr>
                <th class="tw-text-gray-700 tw-font-semibold">@lang('Order ID')</th>
                <th class="tw-text-gray-700 tw-font-semibold">@lang('Items')</th>
                <th class="tw-text-gray-700 tw-font-semibold">@lang('Payment')</th>
                <th class="tw-text-gray-700 tw-font-semibold">@lang('Order')</th>
                <th class="tw-text-gray-700 tw-font-semibold tw-text-right">@lang('Action')</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
                <tr class="tw-border-b tw-border-gray-100 hover:tw-bg-orange-50 tw-transition-colors">
                    <td>
                        <span class="tw-font-mono tw-text-sm tw-font-semibold tw-text-gray-800">#{{ $order->order_number }}</span>
                    </td>
                    <td>
                        <span class="tw-inline-flex tw-items-center tw-gap-1.5 tw-px-2.5 tw-py-1 tw-bg-blue-100 tw-text-blue-700 tw-rounded-full tw-text-xs tw-font-medium">
                            <i class="las la-shopping-bag"></i>
                            {{ $order->orderDetail->sum('quantity') }} @lang('items')
                        </span>
                    </td>
                    <td>
                        @php echo $order->paymentBadge() @endphp
                    </td>
                    <td>
                        @php echo $order->statusBadge() @endphp
                    </td>
                    <td>
                        <div class="tw-flex tw-justify-end">
                            <a href="{{ route('user.orders.details', $order->order_number) }}"
                                class="btn btn-outline--light tw-px-4 tw-py-2 tw-rounded-lg tw-border tw-border-orange-500 tw-text-orange-500 hover:tw-bg-orange-500 hover:tw-text-white tw-transition-colors tw-font-medium tw-text-sm tw-no-underline">
                                <i class="las la-desktop"></i> @lang('View')
                            </a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="tw-text-center tw-py-8">
                        <div class="tw-flex tw-flex-col tw-items-center tw-gap-3">
                            <div class="tw-w-16 tw-h-16 tw-bg-gray-100 tw-rounded-full tw-flex tw-items-center tw-justify-center">
                                <i class="las la-shopping-bag tw-text-3xl tw-text-gray-400"></i>
                            </div>
                            <p class="tw-text-gray-500 tw-mb-0">@lang('No order yet')</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
