@extends('Template::layouts.' . $layout)

@php
    $sectionName = $layout == 'user' ? 'panel' : 'content';
@endphp

@section($sectionName)

@if($layout != 'user')
{{-- Public order view: EtsMory breadcrumb + container --}}
<div class="tw-bg-gradient-to-r tw-from-orange-50 tw-to-green-50 tw-py-6">
    <div class="tw-max-w-5xl tw-mx-auto tw-px-4">
        <nav class="tw-flex tw-items-center tw-gap-2 tw-text-sm tw-text-gray-600">
            <a href="{{ route('home') }}" class="hover:tw-text-orange-600 tw-no-underline tw-text-gray-600">@lang('Accueil')</a>
            <i class="las la-angle-right tw-text-xs"></i>
            <span class="tw-text-gray-800 tw-font-medium">#{{ $order->order_number }}</span>
        </nav>
    </div>
</div>
<div class="tw-max-w-5xl tw-mx-auto tw-px-4 tw-py-8">
@endif

{{-- Order header card --}}
<div class="tw-bg-white tw-rounded-2xl tw-shadow-sm tw-border tw-border-gray-100 tw-overflow-hidden tw-mb-6">
    <div class="tw-px-6 tw-py-4 tw-border-b tw-border-gray-100 tw-flex tw-flex-wrap tw-items-center tw-justify-between tw-gap-3">
        {{-- Badges --}}
        <div class="tw-flex tw-items-center tw-gap-2">
            @php echo $order->paymentBadge() @endphp
            @php echo $order->statusBadge() @endphp
        </div>
        {{-- Order number + date --}}
        <div class="tw-text-right">
            <div class="tw-font-bold tw-text-gray-800 tw-text-lg">#{{ $order->order_number }}</div>
            <div class="tw-text-sm tw-text-gray-500">{{ showDateTime($order->created_at, 'd F, Y') }}</div>
        </div>
    </div>

    {{-- Products table --}}
    <div class="tw-p-6">
        @php
            $subtotal = $order->orderDetail->sum(fn($d) => $d->price * $d->quantity);
        @endphp
        <div class="order-details-products">
            <div class="table-responsive">
                <table class="table table-bordered table--responsive--md">
                    <thead>
                        <tr>
                            <th>@lang('Product')</th>
                            <th>@lang('Price')</th>
                            <th>@lang('Quantity')</th>
                            <th>@lang('Total Price')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderDetail as $data)
                            @php
                                $mainImage = $data->productVariant && @$data->productVariant->main_image_id
                                    ? $data->productVariant->mainImage(true)
                                    : @$data->product->mainImage(true);
                            @endphp
                            <tr>
                                <td>
                                    <div class="single-product-item align-items-center">
                                        <div class="thumb">
                                            <img class="lazyload"
                                                src="{{ getImage(null) }}"
                                                data-src="{{ $mainImage }}"
                                                alt="{{ @$data->product->name ?? 'product' }}">
                                        </div>
                                        <div class="content d-flex flex-column">
                                            {{ @$data->product->name }}
                                            @if($data->productVariant)
                                                - {{ @$data->productVariant->name }}
                                            @endif
                                            @if($data->product->is_downloadable && $order->status == Status::ORDER_DELIVERED && $order->payment_status == Status::PAYMENT_SUCCESS)
                                                <a href="{{ route('order.item.download', encrypt($data->id)) }}"
                                                    class="fw-light text-decoration-underline">
                                                    <i class="la la-download"></i> @lang('Download')
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>{{ showAmount($data->price) }}</td>
                                <td>{{ $data->quantity }}</td>
                                <td class="text-end">{{ showAmount($data->price * $data->quantity) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Summary + shipping grid --}}
<div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-2 tw-gap-6 tw-mb-6">

    {{-- Left: order summary + payment details --}}
    <div class="tw-flex tw-flex-col tw-gap-4">

        {{-- Order summary --}}
        <div class="details-info-list tw-bg-white tw-rounded-2xl tw-shadow-sm tw-border tw-border-gray-100">
            <h6 class="mb-3">@lang('Order Summary')</h6>
            <ul>
                <li>
                    <span>@lang('Subtotal')</span>
                    <span class="fw-semibold">{{ showAmount($subtotal, 2) }}</span>
                </li>
                @if($order->appliedCoupon)
                    <li>
                        <span>(<i class="la la-minus"></i>) @lang('Coupon')
                            ({{ $order->appliedCoupon->coupon->coupon_code }})</span>
                        <span>{{ showAmount($order->appliedCoupon->amount, 2) }}</span>
                    </li>
                @endif
                <li>
                    <span>(<i class="la la-plus"></i>) @lang('Shipping')</span>
                    <span>{{ showAmount($order->shipping_charge, 2) }}</span>
                </li>
                <li class="total">
                    <span>@lang('Total')</span>
                    <span>{{ showAmount($order->total_amount) }}</span>
                </li>
            </ul>
        </div>

        {{-- Payment details (only if deposit exists and is not pending) --}}
        @if(isset($order->deposit) && $order->deposit->status != 0)
        <div class="details-info-list tw-bg-white tw-rounded-2xl tw-shadow-sm tw-border tw-border-gray-100">
            <h6 class="mb-3">@lang('Payment Details')</h6>
            <ul>
                <li>
                    <span>@lang('Payment Method')</span>
                    <span>
                        @if($order->deposit->method_code == 0)
                            @lang('Cash On Delivery')
                        @else
                            {{ __($order->deposit->gateway->name) }}
                        @endif
                    </span>
                </li>
                <li>
                    <span>@lang('Total Bill')</span>
                    <span>{{ showAmount($order->total_amount) }}</span>
                </li>
                @if(@$order->deposit->charge > 0)
                    <li>
                        <span>@lang('Gateway Charge')</span>
                        <span>{{ gs('cur_sym') . getAmount(@$order->deposit->charge) }}</span>
                    </li>
                @endif
                <li class="total">
                    <span>@lang('Total Payable Amount')</span>
                    <span>{{ gs('cur_sym') . getAmount($order->deposit->amount + @$order->deposit->charge) }}</span>
                </li>
            </ul>
        </div>
        @endif

    </div>

    {{-- Right: shipping address --}}
    @if($order->shipping_address)
    <div>
        <div class="details-info-address tw-bg-white tw-rounded-2xl tw-shadow-sm">
            <h6 class="mb-3">@lang('Shipping Details')</h6>
            <ul class="info-address-list">
                <li>
                    <span class="title">@lang('Name')</span>
                    <span><span class="devide-colon">:</span>
                        {{ $order->shipping_address->firstname . ' ' . $order->shipping_address->lastname }}
                    </span>
                </li>
                <li>
                    <span class="title">@lang('Address')</span>
                    <span><span class="devide-colon">:</span> {{ $order->shipping_address->address }}</span>
                </li>
                <li>
                    <span class="title">@lang('State')</span>
                    <span><span class="devide-colon">:</span> {{ $order->shipping_address->state }}</span>
                </li>
                <li>
                    <span class="title">@lang('City')</span>
                    <span><span class="devide-colon">:</span> {{ $order->shipping_address->city }}</span>
                </li>
                <li>
                    <span class="title">@lang('Zip')</span>
                    <span><span class="devide-colon">:</span> {{ $order->shipping_address->zip }}</span>
                </li>
                <li>
                    <span class="title">@lang('Country')</span>
                    <span><span class="devide-colon">:</span> {{ $order->shipping_address->country }}</span>
                </li>
            </ul>
        </div>
    </div>
    @endif

</div>

@if($layout != 'user')
</div>{{-- close tw-max-w-5xl container --}}
@endif

@endsection

@push('style')
    <link rel="stylesheet" href="{{ asset(activeTemplate(true) . 'css/order_details.css') }}">
@endpush
