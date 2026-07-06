<?php


require_once __DIR__ . "/../model/plat.model.php";
require_once __DIR__ . "/../model/commande.model.php";
require_once __DIR__ . "/../model/paiement.model.php";
require_once __DIR__ . "/../service/service.php";
require_once __DIR__ . "/../utils/validator.php";
require_once __DIR__ . "/../utils/view.utils.php";
require_once __DIR__ . "/../view/client.view.php";

function afficherMenu(): void
{
    $plats = listerPlatsDisponibles();
    render("client.view.php", ["mode" => "menu", "plats" => $plats]);
}


function passerCommandeAction(): void
{
    valider_champs_requis($_POST, ["client_id", "panier"]);
    $panier = json_decode($_POST["panier"], true) ?? [];
    valider_panier($panier);

    $data = &db();

    foreach ($panier as $ligne) {
        $plat = trouverPlat($ligne['plat_id']);
        if (!$plat || !platEstDisponible($plat)) {
            erreur('PLAT_INDISPONIBLE');
        }
    }

    $montantTotal = calculerMontantTotal($panier, $data['plats']);

    $id = prochainId('commande');
    $commande = creerCommande($id, (int) $_POST["client_id"], $panier, $montantTotal);
    enregistrerCommande($commande);

    render("client.view.php", ["mode" => "commande_creee", "commande" => $commande]);
}


function payerCommandeAction(): void
{
    valider_champs_requis($_POST, ["commande_id", "numero_carte", "cvv"]);

    $commande = trouverCommande((int) $_POST["commande_id"]);
    if (!$commande) erreur('COMMANDE_INTROUVABLE');
    if ($commande['statut'] !== 'En attente') erreur('STATUT_INVALIDE');

    
    $infosCarte = ['numero' => $_POST["numero_carte"], 'cvv' => $_POST["cvv"]];
    $transactionValidee = validerTransactionBancaire($infosCarte);

    
    if (!$transactionValidee) erreur('TRANSACTION_REFUSEE');

    
    $id = prochainId('paiement');
    $paiement = creerPaiement($id, $commande['id'], $commande['montant_total']);
    $paiement['statut_transaction'] = 'Validée';
    $commande['statut'] = 'Payée';
    enregistrerCommande($commande);

    $recu = genererRecu($paiement);

    render("client.view.php", ["mode" => "paiement_confirme", "commande" => $commande, "recu" => $recu]);
}
