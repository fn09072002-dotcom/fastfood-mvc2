<?php
/**
 * Contrôleur Client — Scénario 1 : "Passer une commande"
 *                      Scénario 2 : "Payer une commande en ligne"
 */

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

/**
 * RG1 : le client sélectionne un ou plusieurs plats (panier envoyé en POST).
 * RG2 : le système vérifie la disponibilité de chaque plat.
 * RG3 : le système calcule le montant total.
 * RG4 : le client valide, la commande est enregistrée avec le statut "En attente".
 */
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

/**
 * RG1 : le client choisit de payer une commande "En attente".
 * RG2 : le système transmet les informations de paiement au Système Bancaire.
 * RG3 : le Système Bancaire valide la transaction et renvoie une confirmation.
 * RG4 : le système met à jour la commande au statut "Payée" et génère un reçu.
 */
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
