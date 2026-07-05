<?php


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
