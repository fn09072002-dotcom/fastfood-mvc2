<?php

 

function creerPaiement(int $id, int $commandeId, float $montant): array
{
    return [
        'id' => $id,
        'commande_id' => $commandeId,
        'montant' => $montant,
        'statut_transaction' => 'En cours',
    ];
}


function validerTransactionBancaire(array $infosCarte): bool
{
    return !empty($infosCarte['numero']) && !empty($infosCarte['cvv']);
}


function genererRecu(array $paiement): string
{
    return "Reçu — Commande #{$paiement['commande_id']} — {$paiement['montant']} FCFA — {$paiement['statut_transaction']}";
}
