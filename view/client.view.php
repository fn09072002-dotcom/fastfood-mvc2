<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Espace Client</title></head>
<body style="font-family: sans-serif; max-width: 640px; margin: 40px auto;">
<h1>Espace Client</h1>

<?php if ($mode === "menu"): ?>
    <h2>Menu</h2>
    <ul>
        <?php foreach ($plats as $p): ?>
            <li><?= $p['nom'] ?> — <?= $p['prix'] ?> FCFA — <?= $p['description'] ?></li>
        <?php endforeach; ?>
    </ul>

<?php elseif ($mode === "commande_creee"): ?>
    <p>Commande #<?= $commande['id'] ?> enregistrée, statut : <?= $commande['statut'] ?>.</p>
    <p>Montant total : <?= $commande['montant_total'] ?> FCFA</p>
<?php endif; ?>

</body>
</html>
