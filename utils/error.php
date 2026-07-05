<?php
$GLOBALS['ERREURS'] = [
    'CHAMP_REQUIS'         => ["Ce champ est requis.", 400],
    'PANIER_VIDE'          => ["Le panier ne peut pas être vide.", 400],
    'PLAT_INDISPONIBLE'    => ["Ce plat n'est plus disponible.", 409],
    'COMMANDE_INTROUVABLE' => ["Commande introuvable.", 404],
    'CLIENT_INTROUVABLE'   => ["Client introuvable.", 404],
    'LIVREUR_INTROUVABLE'  => ["Livreur introuvable.", 404],
    'LIVREUR_INDISPONIBLE' => ["Ce livreur n'est plus disponible.", 409],
    'STATUT_INVALIDE'      => ["Cette commande n'a pas le statut requis pour cette action.", 409],
    'TRANSACTION_REFUSEE'  => ["Transaction bancaire refusée.", 402],
];

function erreur(string $cle): void
{
    [$message, $code] = $GLOBALS['ERREURS'][$cle];
    http_response_code($code);
    echo json_encode(["erreur" => $message]);
    exit;
}
