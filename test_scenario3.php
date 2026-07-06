<?php
/**
 * Script de test console pour le Scénario 3 : "Valider une commande entrante"
 */

require_once __DIR__ . "/controller/gerant.controller.php";

initialiserDonneesDemo();
$data = &db();

// On simule une commande deja "Payée" (issue des scenarios 1 et 2)
$panier = [['plat_id' => 2, 'quantite' => 1]];
$montant = calculerMontantTotal($panier, $data['plats']);
$id = prochainId('commande');
$commande = creerCommande($id, 1, $panier, $montant);
$commande['statut'] = 'Payée';
enregistrerCommande($commande);

echo "Commande de test : #{$commande['id']} - {$commande['statut']}" . PHP_EOL;
echo str_repeat("-", 40) . PHP_EOL;

// Liste les commandes payées
listerCommandesPayeesAction();
echo str_repeat("-", 40) . PHP_EOL;

// Simule la validation (POST) par le gérant
$_POST = ['commande_id' => $commande['id'], 'confirmation' => 'oui'];
validerCommandeAction();
