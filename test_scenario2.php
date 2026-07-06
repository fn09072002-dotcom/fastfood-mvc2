<?php

require_once __DIR__ . "/controller/client.controller.php";


initialiserDonneesDemo();
$data = &db();

$panier = [['plat_id' => 1, 'quantite' => 2]];
$montant = calculerMontantTotal($panier, $data['plats']);
$id = prochainId('commande');
$commande = creerCommande($id, 1, $panier, $montant);
enregistrerCommande($commande);

echo "Commande de test creee : #{$commande['id']} - {$commande['montant_total']} FCFA - {$commande['statut']}" . PHP_EOL;
echo str_repeat("-", 40) . PHP_EOL;


$_POST = [
    'commande_id' => $commande['id'],
    'numero_carte' => '4242424242424242',
    'cvv' => '123',
];

payerCommandeAction();
