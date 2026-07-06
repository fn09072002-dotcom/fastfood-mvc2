<?php
/**
 * En mode console, "render" appelle simplement la fonction d'affichage
 * correspondante au lieu d'inclure un template HTML.
 */
function render(string $vue, array $donnees = []): void
{
    $mode = $donnees['mode'];
    if ($vue === "client.view.php") {
        afficherVueClient($mode, $donnees);
    } elseif ($vue === "gerant.view.php") {
        afficherVueGerant($mode, $donnees);
    }
}
