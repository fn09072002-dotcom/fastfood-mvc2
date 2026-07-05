<?php
/**
 * Contrôleur Client — Scénario 1 : "Passer une commande"
 */

require_once __DIR__ . "/../model/plat.model.php";
require_once __DIR__ . "/../model/commande.model.php";
require_once __DIR__ . "/../service/service.php";
require_once __DIR__ . "/../utils/validator.php";
require_once __DIR__ . "/../utils/view.utils.php";

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

    // RG2 : vérifie la disponibilité de chaque plat
    foreach ($panier as $ligne) {
        $plat = trouverPlat($ligne['plat_id']);
        if (!$plat || !platEstDisponible($plat)) {
            erreur('PLAT_INDISPONIBLE');
        }
    }

    // RG3 : calcule le montant total
    $montantTotal = calculerMontantTotal($panier, $data['plats']);

    // RG4 : enregistre la commande avec le statut "En attente"
    $id = prochainId('commande');
    $commande = creerCommande($id, (int) $_POST["client_id"], $panier, $montantTotal);
    enregistrerCommande($commande);

    render("client.view.php", ["mode" => "commande_creee", "commande" => $commande]);
}
