#!/usr/bin/env php
<?php
/**
 * Script d'application automatique du patch home.blade.php
 * Ajoute 4 sections dynamiques sans supprimer l'existant
 *
 * Usage: php apply_home_patch.php
 */

echo "\n";
echo "========================================================\n";
echo " PATCH AUTOMATIQUE - home.blade.php                    \n";
echo " Ajout de 4 sections dynamiques (non destructif)       \n";
echo "========================================================\n";
echo "\n";

// Configuration
$homeFile = __DIR__ . '/resources/views/templates/basic/home.blade.php';
$backupFile = __DIR__ . '/resources/views/templates/basic/home.blade.php.backup';

// Vérification que le fichier existe
if (!file_exists($homeFile)) {
    die("❌ ERREUR: Fichier home.blade.php introuvable!\n   Chemin: $homeFile\n\n");
}

echo "📁 Fichier cible: " . basename($homeFile) . "\n";
echo "💾 Sauvegarde: " . basename($backupFile) . "\n\n";

// Lecture du fichier actuel
$content = file_get_contents($homeFile);
$originalSize = strlen($content);

echo "📊 Taille fichier actuel: " . number_format($originalSize) . " octets\n";
echo "📝 Lignes actuelles: " . substr_count($content, "\n") . "\n\n";

// Vérification si le patch a déjà été appliqué
if (strpos($content, 'Featured Brands (Dynamic Section)') !== false) {
    die("⚠️  ATTENTION: Le patch semble déjà appliqué!\n   (Section 'Featured Brands (Dynamic Section)' détectée)\n\n   Si vous voulez réappliquer, restaurez d'abord la sauvegarde:\n   cp $backupFile $homeFile\n\n");
}

// Sauvegarde
echo "💾 Création de la sauvegarde...\n";
if (!copy($homeFile, $backupFile)) {
    die("❌ ERREUR: Impossible de créer la sauvegarde!\n\n");
}
echo "   ✅ Sauvegarde créée: $backupFile\n\n";

// Définition des patches
$patches = [
    [
        'name' => 'Featured Brands',
        'marker' => '@endif

{{-- Flash Deals / Promotions du jour --}}',
        'replacement' => '@endif

{{-- ============================================ --}}
{{-- Featured Brands (Dynamic Section)           --}}
{{-- ============================================ --}}
@includeIf(\'Template::sections.featured_brands\')

{{-- Flash Deals / Promotions du jour --}}',
    ],
    [
        'name' => 'Promo Banners',
        'marker' => '@endif

{{-- Featured Products --}}',
        'replacement' => '@endif

{{-- ============================================== --}}
{{-- Promo Banners (Dynamic Section)              --}}
{{-- ============================================== --}}
@includeIf(\'Template::sections.promo_banner\')

{{-- Featured Products --}}',
    ],
    [
        'name' => 'Product Collections',
        'marker' => '@endif

{{-- Features Bar --}}',
        'replacement' => '@endif

{{-- ================================================ --}}
{{-- Product Collections (Dynamic Section)           --}}
{{-- ================================================ --}}
@includeIf(\'Template::sections.collection\')

{{-- Features Bar --}}',
    ],
    [
        'name' => 'Recently Viewed',
        'marker' => '</div>

{{-- Top Selling --}}',
        'replacement' => '</div>

{{-- ======================================================= --}}
{{-- Recently Viewed Products (Dynamic Section)             --}}
{{-- ======================================================= --}}
@includeIf(\'Template::sections.recent_viewed\')

{{-- Top Selling --}}',
    ],
];

// Application des patches
echo "🔧 Application des patches...\n\n";

$patchCount = 0;
$failedPatches = [];

foreach ($patches as $patch) {
    echo "   📌 Patch: {$patch['name']}... ";

    if (strpos($content, $patch['marker']) !== false) {
        $content = str_replace($patch['marker'], $patch['replacement'], $content);

        // Vérification que le remplacement a fonctionné
        if (strpos($content, $patch['replacement']) !== false) {
            echo "✅\n";
            $patchCount++;
        } else {
            echo "❌\n";
            $failedPatches[] = $patch['name'];
        }
    } else {
        echo "⚠️  Marqueur non trouvé\n";
        $failedPatches[] = $patch['name'];
    }
}

echo "\n";

// Vérification des résultats
if (count($failedPatches) > 0) {
    echo "⚠️  ATTENTION: " . count($failedPatches) . " patch(es) échoué(s):\n";
    foreach ($failedPatches as $failed) {
        echo "   - $failed\n";
    }
    echo "\n";
    echo "❌ Application annulée pour éviter un fichier corrompu.\n";
    echo "   La sauvegarde est conservée: $backupFile\n\n";
    exit(1);
}

// Écriture du nouveau fichier
echo "💾 Écriture du fichier modifié...\n";
if (file_put_contents($homeFile, $content) === false) {
    die("❌ ERREUR: Impossible d'écrire le fichier!\n\n");
}

$newSize = strlen($content);
$newLines = substr_count($content, "\n");

echo "   ✅ Fichier mis à jour\n\n";

// Rapport final
echo "========================================================\n";
echo " RAPPORT FINAL                                          \n";
echo "========================================================\n\n";

echo "✅ Patches appliqués avec succès: $patchCount/4\n\n";

echo "📊 Statistiques:\n";
echo "   - Taille avant: " . number_format($originalSize) . " octets\n";
echo "   - Taille après: " . number_format($newSize) . " octets\n";
echo "   - Différence: +" . number_format($newSize - $originalSize) . " octets\n";
echo "   - Lignes ajoutées: +" . ($newLines - substr_count(file_get_contents($backupFile), "\n")) . "\n\n";

echo "📝 Sections ajoutées:\n";
echo "   1. ✅ Featured Brands (après Categories)\n";
echo "   2. ✅ Promo Banners (après Flash Deals)\n";
echo "   3. ✅ Product Collections (après Featured Products)\n";
echo "   4. ✅ Recent Viewed (avant Top Selling)\n\n";

echo "🎯 Prochaines étapes:\n\n";
echo "   1. Tester l'affichage:\n";
echo "      → http://127.0.0.1:8000/\n\n";

echo "   2. Configurer les sections en admin:\n";
echo "      → /admin/frontend/frontend-sections/featured_brands\n";
echo "      → /admin/frontend/frontend-sections/promo_banner\n";
echo "      → /admin/collection/all\n\n";

echo "   3. Tester Recent Viewed:\n";
echo "      → Visiter quelques produits\n";
echo "      → Retourner sur la home\n\n";

echo "💡 Rollback si nécessaire:\n";
echo "   cp $backupFile $homeFile\n\n";

echo "========================================================\n";
echo " ✅ PATCH APPLIQUÉ AVEC SUCCÈS!                         \n";
echo "========================================================\n\n";

exit(0);
