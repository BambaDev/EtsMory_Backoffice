@extends('Template::layouts.master')

@section('content')

{{-- EtsMory breadcrumb --}}
<div class="tw-bg-gradient-to-r tw-from-orange-50 tw-to-green-50 tw-py-6">
    <div class="tw-max-w-7xl tw-mx-auto tw-px-4">
        <nav class="tw-flex tw-items-center tw-gap-2 tw-text-sm tw-text-gray-600">
            <a href="{{ route('home') }}" class="hover:tw-text-orange-600 tw-no-underline tw-text-gray-600">@lang('Accueil')</a>
            <i class="las la-angle-right tw-text-xs"></i>
            <span class="tw-text-gray-800 tw-font-medium">@lang('FAQ')</span>
        </nav>
    </div>
</div>

{{-- Hero section --}}
<section class="tw-bg-white tw-py-16">
    <div class="tw-max-w-4xl tw-mx-auto tw-px-4 tw-text-center">
        <div class="tw-w-16 tw-h-16 tw-bg-orange-100 tw-rounded-full tw-flex tw-items-center tw-justify-center tw-mx-auto tw-mb-6">
            <i class="las la-question-circle tw-text-4xl tw-text-orange-500"></i>
        </div>
        <h1 class="tw-text-4xl lg:tw-text-5xl tw-font-bold tw-text-gray-800 tw-mb-6">
            @lang('Questions Fréquentes')
        </h1>
        <p class="tw-text-xl tw-text-gray-600">
            @lang('Trouvez rapidement les réponses à vos questions les plus courantes')
        </p>
    </div>
</section>

{{-- FAQ Accordion --}}
<section class="tw-py-16 tw-bg-gray-50">
    <div class="tw-max-w-4xl tw-mx-auto tw-px-4">

        @php
            $faqs = [
                [
                    'question' => 'Comment passer une commande ?',
                    'answer' => 'Pour passer une commande, parcourez notre catalogue de produits, ajoutez les articles souhaités à votre panier, puis cliquez sur "Passer commande". Suivez les étapes pour saisir vos informations de livraison et de paiement. Vous recevrez une confirmation par email une fois votre commande validée.'
                ],
                [
                    'question' => 'Quels sont les modes de paiement acceptés ?',
                    'answer' => 'Nous acceptons plusieurs modes de paiement : cartes bancaires (Visa, Mastercard), Mobile Money, et paiement à la livraison pour certaines zones. Tous les paiements en ligne sont sécurisés et cryptés.'
                ],
                [
                    'question' => 'Quels sont les délais de livraison ?',
                    'answer' => 'Les délais de livraison varient selon votre localisation et le mode de livraison choisi. En général, comptez 2 à 5 jours ouvrables pour les zones urbaines et 5 à 10 jours pour les zones rurales. Vous pouvez suivre votre commande en temps réel depuis votre compte.'
                ],
                [
                    'question' => 'Puis-je retourner un produit ?',
                    'answer' => 'Oui, vous disposez de 30 jours pour retourner un produit si vous n\'êtes pas satisfait. Le produit doit être dans son emballage d\'origine et en parfait état. Contactez notre service client pour initier un retour. Les frais de retour peuvent s\'appliquer selon les cas.'
                ],
                [
                    'question' => 'Comment suivre ma commande ?',
                    'answer' => 'Une fois votre commande expédiée, vous recevrez un email avec un numéro de suivi. Vous pouvez également suivre votre commande depuis votre compte en vous connectant et en consultant la section "Mes commandes". Le statut de votre commande sera mis à jour en temps réel.'
                ],
                [
                    'question' => 'Que faire si je reçois un produit défectueux ?',
                    'answer' => 'Si vous recevez un produit défectueux ou endommagé, contactez immédiatement notre service client dans les 48 heures suivant la réception. Fournissez des photos du produit et de l\'emballage. Nous organiserons un retour gratuit et un remplacement ou remboursement selon votre préférence.'
                ],
                [
                    'question' => 'Comment contacter le service client ?',
                    'answer' => 'Notre service client est disponible 7j/7 de 8h à 20h. Vous pouvez nous contacter par téléphone, email, ou via le formulaire de contact sur notre site. Nous nous engageons à répondre à toutes vos questions dans les 24 heures.'
                ],
                [
                    'question' => 'Y a-t-il des frais de livraison ?',
                    'answer' => 'Les frais de livraison varient selon le poids de votre commande et votre zone géographique. La livraison est gratuite pour toutes les commandes supérieures à 10 000 FCFA. Les frais exacts seront calculés et affichés avant la validation de votre commande.'
                ],
            ];
        @endphp

        <div class="tw-space-y-4">
            @foreach($faqs as $index => $faq)
            <div class="tw-bg-white tw-rounded-2xl tw-shadow-sm tw-border tw-border-gray-100 tw-overflow-hidden">
                <button type="button"
                    class="faq-question tw-w-full tw-px-6 tw-py-4 tw-flex tw-items-center tw-justify-between tw-text-left hover:tw-bg-gray-50 tw-transition-colors tw-border-0 tw-cursor-pointer"
                    onclick="toggleFaq({{ $index }})">
                    <span class="tw-font-semibold tw-text-gray-800 tw-pr-4">
                        {{ $index + 1 }}. @lang($faq['question'])
                    </span>
                    <i class="las la-angle-down tw-text-2xl tw-text-orange-500 tw-transition-transform tw-duration-300 faq-icon-{{ $index }}"></i>
                </button>
                <div id="faq-answer-{{ $index }}"
                    class="faq-answer tw-hidden tw-px-6 tw-py-4 tw-border-t tw-border-gray-100 tw-bg-gray-50">
                    <p class="tw-text-gray-600 tw-leading-relaxed tw-mb-0">
                        @lang($faq['answer'])
                    </p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Contact CTA --}}
<section class="tw-py-16 tw-bg-white">
    <div class="tw-max-w-4xl tw-mx-auto tw-px-4 tw-text-center">
        <h2 class="tw-text-3xl tw-font-bold tw-text-gray-800 tw-mb-6">
            @lang('Vous ne trouvez pas votre réponse ?')
        </h2>
        <p class="tw-text-gray-600 tw-text-lg tw-mb-8">
            @lang('Notre équipe est là pour vous aider. Contactez-nous et nous vous répondrons dans les plus brefs délais.')
        </p>
        <a href="{{ route('contact') }}"
            class="tw-inline-block tw-bg-orange-500 tw-text-white tw-px-8 tw-py-4 tw-rounded-full tw-font-semibold tw-text-lg hover:tw-bg-orange-600 tw-transition-colors tw-no-underline tw-shadow-lg">
            @lang('Nous contacter') →
        </a>
    </div>
</section>

@endsection

@push('script')
<script>
    function toggleFaq(index) {
        const answer = document.getElementById(`faq-answer-${index}`);
        const icon = document.querySelector(`.faq-icon-${index}`);

        // Toggle current FAQ
        answer.classList.toggle('tw-hidden');
        icon.classList.toggle('tw-rotate-180');
    }
</script>
@endpush
