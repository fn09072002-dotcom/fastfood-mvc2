<?php


session_start();

function &db(): array
{
    if (!isset($_SESSION['db'])) {
        $_SESSION['db'] = [
            'plats' => [],
            'clients' => [],
            'commandes' => [],
            'livreurs' => [],
            'compteurs' => ['plat' => 0, 'client' => 0, 'commande' => 0, 'livreur' => 0, 'paiement' => 0],
        ];
    }
    return $_SESSION['db'];
}

function prochainId(string $cle): int
{
    $data = &db();
    $data['compteurs'][$cle]++;
    return $data['compteurs'][$cle];
}

function initialiserDonneesDemo(): void
{
    $data = &db();
    if (count($data['plats']) > 0) return;

    $data['clients'][1] = ['id' => 1, 'nom' => 'Diop', 'prenom' => 'Moussa', 'email' => 'moussa.diop@mail.com'];
    $data['compteurs']['client'] = 1;

    $data['plats'][1] = creerPlat(1, 'Burger Classic', 3500, 'Steak, cheddar, salade, tomate');
    $data['plats'][2] = creerPlat(2, 'Poulet Braisé', 4000, 'Demi-poulet braisé, frites');
    $data['plats'][3] = creerPlat(3, 'Tacos Fast-Food', 2500, 'Viande hachée, sauce fromagère');
    $data['compteurs']['plat'] = 3;
}


function trouverPlat(int $id): ?array
{
    $data = &db();
    return $data['plats'][$id] ?? null;
}

function listerPlatsDisponibles(): array
{
    $data = &db();
    return array_values(array_filter($data['plats'], 'platEstDisponible'));
}


function trouverCommande(int $id): ?array
{
    $data = &db();
    return $data['commandes'][$id] ?? null;
}

function enregistrerCommande(array $commande): void
{
    $data = &db();
    $data['commandes'][$commande['id']] = $commande;
}
