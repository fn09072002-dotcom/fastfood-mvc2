<?php
/**
 * Vue Client — mode console : affiche du texte simple dans le terminal.
 */

function afficherVueClient(string $mode, array $donnees = []): void
{
    echo "=== Espace Client ===" . PHP_EOL;

    if ($mode === "menu") {
        echo "--- Menu ---" . PHP_EOL;
        foreach ($donnees['plats'] as $p) {
            echo "- {$p['nom']} : {$p['prix']} FCFA ({$p['description']})" . PHP_EOL;
        }

    } elseif ($mode === "commande_creee") {
        $commande = $donnees['commande'];
        echo "Commande #{$commande['id']} enregistree, statut : {$commande['statut']}" . PHP_EOL;
        echo "Montant total : {$commande['montant_total']} FCFA" . PHP_EOL;

    } elseif ($mode === "paiement_confirme") {
        $commande = $donnees['commande'];
        echo "Paiement effectue. Statut de la commande : {$commande['statut']}" . PHP_EOL;
        echo $donnees['recu'] . PHP_EOL;
    }
}
