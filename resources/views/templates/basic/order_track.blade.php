@extends('Template::layouts.master')
@section('content')
<div class="tw-min-h-screen tw-bg-gray-50 tw-py-12">
    <div class="tw-max-w-4xl tw-mx-auto tw-px-4">
        <div class="tw-text-center tw-mb-12">
            <h1 class="tw-text-4xl tw-font-bold tw-text-gray-800 tw-mb-4">Suivre ma commande</h1>
            <p class="tw-text-gray-600 tw-max-w-2xl tw-mx-auto">
                Entrez votre numéro de commande pour suivre l'état de votre livraison en temps réel.
            </p>
        </div>

        <div class="tw-bg-white tw-rounded-2xl tw-shadow-lg tw-p-8 tw-mb-8">
            <form id="trackOrderForm" class="tw-flex tw-flex-col sm:tw-flex-row tw-gap-4">
                <input
                    type="text"
                    id="trackingNumber"
                    name="tracking_number"
                    placeholder="Ex: ESM123456 ou #ESM123456"
                    class="tw-flex-1 tw-px-4 tw-py-3 tw-border-2 tw-border-gray-200 tw-rounded-xl focus:tw-border-orange-500 focus:tw-outline-none tw-text-sm"
                    required
                />
                <button
                    type="submit"
                    class="tw-px-8 tw-py-3 tw-bg-orange-500 tw-text-white tw-font-bold tw-rounded-xl hover:tw-bg-orange-600 tw-transition-colors tw-whitespace-nowrap tw-border-0 tw-cursor-pointer"
                >
                    Suivre
                </button>
            </form>
        </div>

        <div id="loadingState" class="tw-hidden">
            <div class="tw-bg-white tw-rounded-2xl tw-shadow-lg tw-p-8 tw-text-center">
                <div class="tw-inline-block tw-animate-spin tw-rounded-full tw-h-8 tw-w-8 tw-border-b-2 tw-border-orange-500"></div>
                <p class="tw-mt-4 tw-text-gray-600">Recherche en cours...</p>
            </div>
        </div>

        <div id="orderResults" class="tw-hidden tw-space-y-6">
            <!-- Order Summary -->
            <div class="tw-bg-white tw-rounded-2xl tw-shadow-lg tw-p-6">
                <div class="tw-flex tw-items-start tw-justify-between tw-mb-6">
                    <div>
                        <p class="tw-text-gray-600 tw-text-sm">Numéro de commande</p>
                        <h2 class="tw-text-2xl tw-font-bold tw-text-gray-800" id="orderNumber"></h2>
                    </div>
                    <div class="tw-text-right">
                        <p class="tw-text-gray-600 tw-text-sm">Total</p>
                        <p class="tw-text-2xl tw-font-bold tw-text-orange-600" id="orderTotal"></p>
                    </div>
                </div>
                <div class="tw-grid tw-grid-cols-2 tw-gap-4 tw-pt-6 tw-border-t tw-border-gray-100">
                    <div>
                        <p class="tw-text-gray-600 tw-text-sm">Commandée le</p>
                        <p class="tw-font-semibold tw-text-gray-800" id="orderDate"></p>
                    </div>
                    <div>
                        <p class="tw-text-gray-600 tw-text-sm">Livraison estimée</p>
                        <p class="tw-font-semibold tw-text-green-600" id="orderDelivery"></p>
                    </div>
                </div>
            </div>

            <!-- Status Timeline -->
            <div class="tw-bg-white tw-rounded-2xl tw-shadow-lg tw-p-6">
                <h3 class="tw-text-lg tw-font-bold tw-text-gray-800 tw-mb-6">Statut de livraison</h3>
                <div id="orderTimeline" class="tw-space-y-4"></div>
            </div>

            <!-- Items -->
            <div class="tw-bg-white tw-rounded-2xl tw-shadow-lg tw-p-6">
                <h3 class="tw-text-lg tw-font-bold tw-text-gray-800 tw-mb-4">Articles commandés</h3>
                <div id="orderItems" class="tw-space-y-3"></div>
            </div>

            <!-- Contact -->
            <div class="tw-bg-gradient-to-r tw-from-orange-50 tw-to-green-50 tw-rounded-2xl tw-p-6">
                <h3 class="tw-text-lg tw-font-bold tw-text-gray-800 tw-mb-4">Besoin d'aide ?</h3>
                <div class="tw-grid tw-grid-cols-1 sm:tw-grid-cols-2 tw-gap-4">
                    <a href="tel:+2250700000000" class="tw-flex tw-items-center tw-justify-center tw-gap-2 tw-py-3 tw-bg-white tw-rounded-xl hover:tw-bg-gray-50 tw-transition-colors tw-no-underline">
                        <svg class="tw-w-5 tw-h-5 tw-text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <span class="tw-font-semibold tw-text-gray-800">+225 07 00 00 00</span>
                    </a>
                    <a href="mailto:support@etsmory.ci" class="tw-flex tw-items-center tw-justify-center tw-gap-2 tw-py-3 tw-bg-white tw-rounded-xl hover:tw-bg-gray-50 tw-transition-colors tw-no-underline">
                        <svg class="tw-w-5 tw-h-5 tw-text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span class="tw-font-semibold tw-text-gray-800">support@etsmory.ci</span>
                    </a>
                </div>
            </div>
        </div>

        <div id="notFoundError" class="tw-hidden tw-bg-yellow-100 tw-border tw-border-yellow-400 tw-rounded-2xl tw-p-8 tw-text-center tw-text-yellow-700">
            <p class="tw-text-lg tw-font-semibold">⚠️ Commande non trouvée</p>
            <p class="tw-text-sm tw-mt-2">Vérifiez votre numéro de commande et réessayez.</p>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('trackOrderForm');
    const loadingState = document.getElementById('loadingState');
    const orderResults = document.getElementById('orderResults');
    const notFoundError = document.getElementById('notFoundError');
    const trackingInput = document.getElementById('trackingNumber');

    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        const trackingNumber = trackingInput.value.trim();
        if (!trackingNumber) return;

        // Clean tracking number (remove # if present)
        const cleanNumber = trackingNumber.replace(/^#/, '');
        console.log('Searching for order:', cleanNumber);

        // Reset all states - hide everything first
        orderResults.classList.add('tw-hidden');
        notFoundError.classList.add('tw-hidden');
        loadingState.classList.add('tw-hidden');

        // Show loading
        loadingState.classList.remove('tw-hidden');

        try {
            const response = await fetch(`{{ url('order-data') }}/${cleanNumber}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            console.log('Response status:', response.status);

            // Hide loading
            loadingState.classList.add('tw-hidden');

            if (!response.ok) {
                console.error('Response not OK:', response.status);
                notFoundError.classList.remove('tw-hidden');
                return;
            }

            const data = await response.json();
            console.log('Received data:', data);

            if (data.success && data.order) {
                console.log('Displaying order:', data.order);
                displayOrderData(data.order);
                orderResults.classList.remove('tw-hidden');
            } else {
                console.error('No order in response or success=false');
                notFoundError.classList.remove('tw-hidden');
            }
        } catch (error) {
            console.error('Error fetching order:', error);
            loadingState.classList.add('tw-hidden');
            notFoundError.classList.remove('tw-hidden');
        }
    });

    function displayOrderData(order) {
        // Order Summary
        document.getElementById('orderNumber').textContent = '#' + order.number;
        document.getElementById('orderTotal').textContent = formatCurrency(order.amount);
        document.getElementById('orderDate').textContent = formatDate(order.created_at);
        document.getElementById('orderDelivery').textContent = order.estimated_delivery || 'Bientôt disponible';

        // Timeline
        const timeline = document.getElementById('orderTimeline');
        const steps = getOrderSteps(order.status, order.created_at, order.updated_at);
        timeline.innerHTML = steps.map((step, index) => `
            <div class="tw-flex tw-gap-4">
                <div class="tw-flex tw-flex-col tw-items-center">
                    <div class="tw-w-8 tw-h-8 tw-rounded-full tw-flex tw-items-center tw-justify-center tw-font-bold tw-text-sm ${
                        step.completed
                            ? 'tw-bg-green-100 tw-text-green-600'
                            : 'tw-bg-gray-100 tw-text-gray-400'
                    }">
                        ${step.completed ? '✓' : (index + 1)}
                    </div>
                    ${index < steps.length - 1 ? `
                        <div class="tw-w-1 tw-h-12 tw-mt-2 ${step.completed ? 'tw-bg-green-100' : 'tw-bg-gray-100'}"></div>
                    ` : ''}
                </div>
                <div class="tw-py-2">
                    <p class="tw-font-semibold tw-text-gray-800">${step.label}</p>
                    <p class="tw-text-sm tw-text-gray-600">${step.date}</p>
                </div>
            </div>
        `).join('');

        // Order Items
        const itemsContainer = document.getElementById('orderItems');
        itemsContainer.innerHTML = order.items.map((item, index) => `
            <div class="tw-flex tw-items-center tw-justify-between tw-py-3 tw-border-b tw-border-gray-100 ${index === order.items.length - 1 ? 'last:tw-border-0' : ''}">
                <div class="tw-flex-1">
                    <p class="tw-font-semibold tw-text-gray-800">${item.name}</p>
                    <p class="tw-text-sm tw-text-gray-600">Quantité: ${item.quantity}</p>
                </div>
                <p class="tw-font-bold tw-text-orange-600">${formatCurrency(item.price * item.quantity)}</p>
            </div>
        `).join('');
    }

    function getOrderSteps(status, createdAt, updatedAt) {
        const statusMap = {
            0: 'pending',      // Status::ORDER_PENDING
            1: 'processing',   // Status::ORDER_PROCESSING
            2: 'dispatched',   // Status::ORDER_DISPATCHED
            3: 'delivered'     // Status::ORDER_DELIVERED
        };

        const currentStatus = statusMap[status] || 'pending';
        const createdDate = formatDateTime(createdAt);
        const updatedDate = formatDateTime(updatedAt);

        const steps = [
            {
                label: 'Commande confirmée',
                completed: ['pending', 'processing', 'dispatched', 'delivered'].includes(currentStatus),
                date: createdDate
            },
            {
                label: 'En préparation',
                completed: ['processing', 'dispatched', 'delivered'].includes(currentStatus),
                date: ['processing', 'dispatched', 'delivered'].includes(currentStatus) ? updatedDate : 'En attente'
            },
            {
                label: 'En livraison',
                completed: ['dispatched', 'delivered'].includes(currentStatus),
                date: ['dispatched', 'delivered'].includes(currentStatus) ? updatedDate : 'En attente'
            },
            {
                label: 'Livrée',
                completed: currentStatus === 'delivered',
                date: currentStatus === 'delivered' ? updatedDate : "Aujourd'hui avant 22h"
            }
        ];

        return steps;
    }

    function formatCurrency(amount) {
        return new Intl.NumberFormat('fr-FR', {
            style: 'decimal',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(amount) + ' FCFA';
    }

    function formatDate(dateString) {
        const date = new Date(dateString);
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        return date.toLocaleDateString('fr-FR', options);
    }

    function formatDateTime(dateString) {
        const date = new Date(dateString);
        const dateOptions = { day: 'numeric', month: 'long' };
        const timeOptions = { hour: '2-digit', minute: '2-digit' };
        return date.toLocaleDateString('fr-FR', dateOptions) + ' ' +
               date.toLocaleTimeString('fr-FR', timeOptions);
    }
});
</script>
@endpush
