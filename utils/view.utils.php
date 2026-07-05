<?php
function render(string $vue, array $donnees = []): void
{
    extract($donnees);
    require __DIR__ . "/../view/" . $vue;
}
