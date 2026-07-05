<?php
/**
 * "Modèle" Commande :
 * ['id' => int, 'client_id' => int, 'lignes' => [['plat_id'=>int,'quantite'=>int], ...],
 *  'montant_total' => float, 'statut' => string, 'livreur_id' => int|null]
 */

function creerCommande(int $id, int $clientId, array $lignes, float $montantTotal): array
{
    return [
        'id' => $id,
        'client_id' => $clientId,
        'lignes' => $lignes,
        'montant_total' => $montantTotal,
        'statut' => 'En attente',
        'livreur_id' => null,
    ];
}

/** RG3 du scénario 1 : calcule le montant total à partir des lignes et du catalogue de plats. */
function calculerMontantTotal(array $lignes, array $plats): float
{
    $total = 0.0;
    foreach ($lignes as $ligne) {
        $plat = $plats[$ligne['plat_id']];
        $total += $plat['prix'] * $ligne['quantite'];
    }
    return $total;
}
