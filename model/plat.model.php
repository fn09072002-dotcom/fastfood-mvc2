<?php
/**
 * "Modèle" Plat — ici, un plat est juste un tableau associatif :
 * ['id' => int, 'nom' => string, 'prix' => float, 'description' => string, 'disponible' => bool]
 */

function creerPlat(int $id, string $nom, float $prix, string $description): array
{
    return [
        'id' => $id,
        'nom' => $nom,
        'prix' => $prix,
        'description' => $description,
        'disponible' => true,
    ];
}

function platEstDisponible(array $plat): bool
{
    return $plat['disponible'] === true;
}
