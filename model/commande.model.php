<?php


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


function calculerMontantTotal(array $lignes, array $plats): float
{
    $total = 0.0;
    foreach ($lignes as $ligne) {
        $plat = $plats[$ligne['plat_id']];
        $total += $plat['prix'] * $ligne['quantite'];
    }
    return $total;
}


function changerStatutCommande(array &$commande, string $nouveauStatut): void
{
    $commande['statut'] = $nouveauStatut;
}
