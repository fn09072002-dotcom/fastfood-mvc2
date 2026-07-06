<?php

function render(string $vue, array $donnees = []): void
{
    $mode = $donnees['mode'];
    if ($vue === "client.view.php") {
        afficherVueClient($mode, $donnees);
    } elseif ($vue === "gerant.view.php") {
        afficherVueGerant($mode, $donnees);
    }
}
