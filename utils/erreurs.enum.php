<?php
/**
 * Enumération centralisant tous les messages d'erreur de l'application.
 */
enum Erreur: string
{
    case CHAMP_REQUIS          = "Ce champ est requis.";
    case PANIER_VIDE           = "Le panier ne peut pas être vide.";
    case PLAT_INDISPONIBLE     = "Ce plat n'est plus disponible.";
    case COMMANDE_INTROUVABLE  = "Commande introuvable.";
    case CLIENT_INTROUVABLE    = "Client introuvable.";
    case LIVREUR_INTROUVABLE   = "Livreur introuvable.";
    case LIVREUR_INDISPONIBLE  = "Ce livreur n'est plus disponible.";
    case STATUT_INVALIDE       = "Cette commande n'a pas le statut requis pour cette action.";
    case TRANSACTION_REFUSEE   = "Transaction bancaire refusée.";

    public function code(): int
    {
        return match($this) {
            self::COMMANDE_INTROUVABLE, self::CLIENT_INTROUVABLE, self::LIVREUR_INTROUVABLE => 404,
            self::TRANSACTION_REFUSEE => 402,
            self::PLAT_INDISPONIBLE, self::LIVREUR_INDISPONIBLE, self::STATUT_INVALIDE => 409,
            default => 400,
        };
    }
}
