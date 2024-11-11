<?php
if (!function_exists('safeInclude')) {
    require_once __DIR__ . '/../../config/init.php';
}

use Config\SiteConfig;
$SiteConfig = new SiteConfig();
$SiteConfig->init();
use Config\Utils;
$Utils = new Utils();

$siteName = SiteConfig::$siteName;
$metaDescription = SiteConfig::$metaDescription;
$googleVerification = SiteConfig::$googleVerification;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <script>
        function updatePageTitle() {
            var path = window.location.pathname; // Récupérer le chemin de l'URL
            var hash = window.location.hash; // Récupérer le fragment
            var navLinkName = 'Inconnu'; // Valeur par défaut

            // Vérifier d'abord le chemin
            switch (path) {
                case '/form':
                    navLinkName = 'Formulaire';
                    break;
                case '/list':
                    navLinkName = 'Liste';
                    break;
                case '/panel':
                    navLinkName = 'Panel Admin';
                    break;
                case '/login':
                    navLinkName = 'Connexion';
                    break;
            }

            // Ensuite, vérifier le fragment
            switch (hash) {
                case '#aboutus':
                    navLinkName = 'À Propos de nous';
                    break;
                case '#story':
                    navLinkName = 'Notre Histoire';
                    break;
                // Ajoutez d'autres fragments si nécessaire
            }

            // Mettre à jour le titre de la page
            document.title = navLinkName + ' | ' + '<?php echo htmlspecialchars($siteName); ?>';
        }

        document.addEventListener("DOMContentLoaded", function() {
            updatePageTitle(); // Mettre à jour le titre au chargement de la page

            // Écouter les changements d'historique
            window.addEventListener('popstate', function() {
                updatePageTitle(); // Mettre à jour le titre lors du retour en arrière ou de l'avance
            });

            // Écouter les clics sur les liens pour mettre à jour l'historique
            document.querySelectorAll('a').forEach(function(link) {
                link.addEventListener('click', function(event) {
                    var href = this.getAttribute('href');
                    if (href && href.startsWith('/')) { // Vérifier que c'est un lien interne
                        event.preventDefault(); // Empêcher le comportement par défaut
                        history.pushState(null, '', href); // Mettre à jour l'URL sans recharger
                        updatePageTitle(); // Mettre à jour le titre
                        // Optionnel : charger le contenu de la nouvelle page via AJAX ici si nécessaire
                        loadContent(href); // Charger le contenu de la nouvelle page
                    }
                });
            });
        });

        function loadContent(url) {
            // Exemple de chargement de contenu via AJAX
            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.text();
                })
                .then(html => {
                    // Remplacer le contenu de la page avec le nouveau contenu
                    document.body.innerHTML = html; // Remplacez cela par la logique de mise à jour appropriée
                    updatePageTitle(); // Mettre à jour le titre après le chargement du nouveau contenu
                })
                .catch(error => {
                    console.error('Il y a eu un problème avec la requête fetch:', error);
                });
        }
    </script>
    <meta name="google-site-verification" content="<?php echo htmlspecialchars($googleVerification); ?>" />
    <meta name="description" content="<?php echo htmlspecialchars($metaDescription); ?>">

    <!-- Styles Externes -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!-- CSS Root (Styles principaux) -->
    <link rel="stylesheet" href="/assets/css/main.css">
    <!-- Styles Navbar + Footer -->
    <link rel="stylesheet" href="/assets/css/navbar.css">
    <link rel="stylesheet" href="/assets/css/home.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="stylesheet" href="/assets/css/list.css">

    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <link rel="manifest" href="/assets/images/favicons/site.webmanifest">
    <link rel="icon" href="/assets/images/favicons/favicon.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/images/favicons/apple-touch-icon.png">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/assets/images/favicons/favicon.png">
</head>
