<?php


require_once __DIR__ . "/../model/commande.model.php";
require_once __DIR__ . "/../service/service.php";
require_once __DIR__ . "/../utils/validator.php";
require_once __DIR__ . "/../utils/view.utils.php";
require_once __DIR__ . "/../view/gerant.view.php";


function listerCommandesPayeesAction(): void
{
    $data = &db();
    $commandes = array_values(array_filter($data['commandes'], fn($c) => $c['statut'] === 'Payée'));

    render("gerant.view.php", ["mode" => "commandes_payees", "commandes" => $commandes]);
}


function validerCommandeAction(): void
{
    valider_champs_requis($_POST, ["commande_id", "confirmation"]);

    if ($_POST["confirmation"] !== "oui") {
        render("gerant.view.php", ["mode" => "message", "message" => "Validation annulee."]);
        return;
    }

    $commande = trouverCommande((int) $_POST["commande_id"]);
    if (!$commande) erreur('COMMANDE_INTROUVABLE');
    if ($commande['statut'] !== 'Payée') erreur('STATUT_INVALIDE');

   
    changerStatutCommande($commande, 'En préparation');
    enregistrerCommande($commande);

    
    $data = &db();
    $client = $data['clients'][$commande['client_id']];
    notifier($client['email'], "Votre commande #{$commande['id']} est en cours de preparation.");

    render("gerant.view.php", ["mode" => "commande_validee", "commande" => $commande]);
}
