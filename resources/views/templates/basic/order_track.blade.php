@extends('Template::layouts.master')
@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-4xl mx-auto px-4">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">Suivre ma commande</h1>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Entrez votre numéro de commande pour suivre l'état de votre livraison en temps réel.
            </p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
            <form id="trackOrderForm" class="flex flex-col sm:flex-row gap-4">
                <input
                    type="text"
                    id="trackingNumber"
                    name="tracking_number"
                    placeholder="Ex: ESM123456 ou #ESM123456"
                    class="flex-1 px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-orange-500 focus:outline-none text-sm"
                    required
                />
                <button
                    type="submit"
                    class="px-8 py-3 bg-orange-500 text-white font-bold rounded-xl hover:bg-orange-600 transition-colors whitespace-nowrap"
                >
                    Suivre
                </button>
            </form>
        </div>

        <div id="loadingState" class="hidden">
            <div class="bg-white rounded-2xl shadow-lg p-8 text-center">
                <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-orange-500"></div>
                <p class="mt-4 text-gray-600">Recherche en cours...</p>
            </div>
        </div>

        <div id="orderResults" class="hidden space-y-6">
            <!-- Order Summary -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <p class="text-gray-600 text-sm">Numéro de commande</p>
                        <h2 class="text-2xl font-bold text-gray-800" id="orderNumber"></h2>
                    </div>
                    <div class="text-right">
                        <p class="text-gray-600 text-sm">Total</p>
                        <p class="text-2xl font-bold text-orange-600" id="orderTotal"></p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 pt-6 border-t border-gray-100">
                    <div>
                        <p class="text-gray-600 text-sm">Commandée le</p>
                        <p class="font-semibold text-gray-800" id="orderDate"></p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Livraison estimée</p>
                        <p class="font-semibold text-green-600" id="orderDelivery"></p>
                    </div>
                </div>
            </div>

            <!-- Status Timeline -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-6">Statut de livraison</h3>
                <div id="orderTimeline" class="space-y-4"></div>
            </div>

            <!-- Items -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Articles commandés</h3>
                <div id="orderItems" class="space-y-3"></div>
            </div>

            <!-- Contact -->
            <div class="bg-gradient-to-r from-orange-50 to-green-50 rounded-2xl p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Besoin d'aide ?</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <a href="tel:+2250700000000" class="flex items-center justify-center gap-2 py-3 bg-white rounded-xl hover:bg-gray-50 transition-colors">
                        <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <span class="font-semibold text-gray-800">+225 07 00 00 00</span>
                    </a>
                    <a href="mailto:support@etsmory.ci" class="flex items-center justify-center gap-2 py-3 bg-white rounded-xl hover:bg-gray-50 transition-colors">
                        <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span class="font-semibold text-gray-800">support@etsmory.ci</span>
                    </a>
                </div>
            </div>
        </div>

        <div id="notFoundError" class="hidden bg-yellow-100 border border-yellow-400 rounded-2xl p-8 text-center text-yellow-700">
            <p class="text-lg font-semibold">⚠️ Commande non trouvée</p>
            <p class="text-sm mt-2">Vérifiez votre numéro de commande et réessayez.</p>
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

        // Hide previous results
        orderResults.classList.add('hidden');
        notFoundError.classList.add('hidden');
        loadingState.classList.remove('hidden');

        try {
            const response = await fetch(`{{ url('order-data') }}/${cleanNumber}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            loadingState.classList.add('hidden');

            if (!response.ok) {
                notFoundError.classList.remove('hidden');
                return;
            }

            const data = await response.json();

            if (data.success) {
                displayOrderData(data.order);
                orderResults.classList.remove('hidden');
            } else {
                notFoundError.classList.remove('hidden');
            }
        } catch (error) {
            console.error('Error fetching order:', error);
            loadingState.classList.add('hidden');
            notFoundError.classList.remove('hidden');
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
            <div class="flex gap-4">
                <div class="flex flex-col items-center">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm ${
                        step.completed
                            ? 'bg-green-100 text-green-600'
                            : 'bg-gray-100 text-gray-400'
                    }">
                        ${step.completed ? '✓' : (index + 1)}
                    </div>
                    ${index < steps.length - 1 ? `
                        <div class="w-1 h-12 mt-2 ${step.completed ? 'bg-green-100' : 'bg-gray-100'}"></div>
                    ` : ''}
                </div>
                <div class="py-2">
                    <p class="font-semibold text-gray-800">${step.label}</p>
                    <p class="text-sm text-gray-600">${step.date}</p>
                </div>
            </div>
        `).join('');

        // Order Items
        const itemsContainer = document.getElementById('orderItems');
        itemsContainer.innerHTML = order.items.map((item, index) => `
            <div class="flex items-center justify-between py-3 border-b border-gray-100 ${index === order.items.length - 1 ? 'last:border-0' : ''}">
                <div class="flex-1">
                    <p class="font-semibold text-gray-800">${item.name}</p>
                    <p class="text-sm text-gray-600">Quantité: ${item.quantity}</p>
                </div>
                <p class="font-bold text-orange-600">${formatCurrency(item.price * item.quantity)}</p>
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
