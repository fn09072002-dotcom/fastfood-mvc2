<?php
require_once __DIR__ . "/erreurs.enum.php";

function erreur(Erreur $erreur): void
{
    http_response_code($erreur->code());
    echo json_encode(["erreur" => $erreur->value]);
    exit;
}
