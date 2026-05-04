#!/usr/bin/env php
<?php
/**
 * Script d'application automatique du patch about.blade.php
 * Ajoute 5 sections dynamiques sans supprimer l'existant
 *
 * Usage: php apply_about_patch.php
 */

echo "\n";
echo "========================================================\n";
echo " PATCH AUTOMATIQUE - about.blade.php                   \n";
echo " Ajout de 5 sections dynamiques (non destructif)       \n";
echo "========================================================\n";
echo "\n";

// Configuration
$aboutFile = __DIR__ . '/resources/views/templates/basic/about.blade.php';
$backupFile = __DIR__ . '/resources/views/templates/basic/about.blade.php.backup';

// Vérification que le fichier existe
if (!file_exists($aboutFile)) {
    die("❌ ERREUR: Fichier about.blade.php introuvable!\n   Chemin: $aboutFile\n\n");
}

echo "📁 Fichier cible: " . basename($aboutFile) . "\n";
echo "💾 Sauvegarde: " . basename($backupFile) . "\n\n";

// Lecture du fichier actuel
$content = file_get_contents($aboutFile);
$originalSize = strlen($content);

echo "📊 Taille fichier actuel: " . number_format($originalSize) . " octets\n";
echo "📝 Lignes actuelles: " . substr_count($content, "\n") . "\n\n";

// Vérification si le patch a déjà été appliqué
if (strpos($content, 'Services (Dynamic Section)') !== false) {
    die("⚠️  ATTENTION: Le patch semble déjà appliqué!\n   (Section 'Services (Dynamic Section)' détectée)\n\n   Si vous voulez réappliquer, restaurez d'abord la sauvegarde:\n   cp $backupFile $aboutFile\n\n");
}

// Sauvegarde
echo "💾 Création de la sauvegarde...\n";
if (!copy($aboutFile, $backupFile)) {
    die("❌ ERREUR: Impossible de créer la sauvegarde!\n\n");
}
echo "   ✅ Sauvegarde créée: $backupFile\n\n";

// Définition des patches
$patches = [
    [
        'name' => 'Services',
        'marker' => '</section>

{{-- Mission & Values --}}',
        'replacement' => '</section>

{{-- ============================================ --}}
{{-- Services (Dynamic Section)                  --}}
{{-- ============================================ --}}
@includeIf(\'Template::sections.services\')

{{-- Mission & Values --}}',
    ],
    [
        'name' => 'About Us Content',
        'marker' => '</section>

{{-- Why Choose Us --}}',
        'replacement' => '</section>

{{-- ============================================ --}}
{{-- About Us Content (Dynamic Section)          --}}
{{-- ============================================ --}}
@includeIf(\'Template::sections.about_us\')

{{-- Why Choose Us --}}',
    ],
    [
        'name' => 'Features',
        'marker' => '</section>

{{-- Stats --}}',
        'replacement' => '</section>

{{-- ============================================ --}}
{{-- Features (Dynamic Section)                  --}}
{{-- ============================================ --}}
@includeIf(\'Template::sections.feature\')

{{-- Stats --}}',
    ],
    [
        'name' => 'Counter + Quote',
        'marker' => '</section>

{{-- CTA Section --}}',
        'replacement' => '</section>

{{-- ============================================ --}}
{{-- Counter (Dynamic Section)                   --}}
{{-- ============================================ --}}
@includeIf(\'Template::sections.counter\')

{{-- ============================================ --}}
{{-- Quote/Testimonial (Dynamic Section)         --}}
{{-- ============================================ --}}
@includeIf(\'Template::sections.quote\')

{{-- CTA Section --}}',
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
if (file_put_contents($aboutFile, $content) === false) {
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
echo "   1. ✅ Services (après Hero)\n";
echo "   2. ✅ About Us Content (après Mission)\n";
echo "   3. ✅ Features (après Why Choose Us)\n";
echo "   4. ✅ Counter (après Stats)\n";
echo "   5. ✅ Quote (avant CTA)\n\n";

echo "🎯 Prochaines étapes:\n\n";
echo "   1. Tester l'affichage:\n";
echo "      → http://127.0.0.1:8000/about-us\n\n";

echo "   2. Configurer les sections en admin:\n";
echo "      → /admin/frontend/frontend-sections/services\n";
echo "      → /admin/frontend/frontend-sections/about_us\n";
echo "      → /admin/frontend/frontend-sections/feature\n";
echo "      → /admin/frontend/frontend-sections/counter\n";
echo "      → /admin/frontend/frontend-sections/quote\n\n";

echo "   3. Tester chaque section:\n";
echo "      → Services: icônes + titres configurables\n";
echo "      → About Us: banner + contenu + bouton\n";
echo "      → Features: layout 2 colonnes\n";
echo "      → Counter: animation odometer\n";
echo "      → Quote: testimonial avec citation\n\n";

echo "💡 Rollback si nécessaire:\n";
echo "   cp $backupFile $aboutFile\n\n";

echo "========================================================\n";
echo " ✅ PATCH APPLIQUÉ AVEC SUCCÈS!                         \n";
echo "========================================================\n\n";

exit(0);
