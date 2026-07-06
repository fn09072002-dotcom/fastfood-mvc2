<?php


function afficherVueGerant(string $mode, array $donnees = []): void
{
    echo "=== Espace Gerant ===" . PHP_EOL;

    if ($mode === "commandes_payees") {
        echo "--- Commandes payees a valider ---" . PHP_EOL;
        foreach ($donnees['commandes'] as $c) {
            echo "- Commande #{$c['id']} : {$c['montant_total']} FCFA" . PHP_EOL;
        }

    } elseif ($mode === "commande_validee") {
        $commande = $donnees['commande'];
        echo "Commande #{$commande['id']} - statut : {$commande['statut']}. Client notifie." . PHP_EOL;

    } elseif ($mode === "message") {
        echo $donnees['message'] . PHP_EOL;
    }
}
