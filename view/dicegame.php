<?php

/**
 * Standard view template to generate a simple web page, or part of a web page.
 */

declare(strict_types=1);

$header = $header ?? null;
$message = $message ?? null;
$action = $action ?? null;
$form = $form ?? null;
$lastHandRoll = $lastHandRoll ?? null;
$sum = $sum ?? null;

?>

<h1><?= $header ?></h1>

<p><?= $message ?></p>

<form method="post" action="<?= $action ?>">
    <?= $form ?>
</form>

<div class="game" <?= $result ?>
    