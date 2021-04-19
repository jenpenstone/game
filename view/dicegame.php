<?php

/**
 * Standard view template to generate a simple web page, or part of a web page.
 */

declare(strict_types=1);

$header = $header ?? null;
$message = $message ?? null;
$action = $action ?? null;
$output = $output ?? null;


?>

<h1><?= $header ?></h1>

<p><?= $message ?></p>

<form method="post" action="<?= $action ?>">
    <label for="dice">Antal tärningar:</label>
    <input type="number" name="dice" value="1" min="1" max="2">
    <input type=submit value="Starta spelet">

    <?php if ($output !== null) : ?>
        <p>
            <output>You have sent the value of:<br>'<?= htmlentities($output) ?>'</output>
        </p>
    <?php endif; ?>
</form>

<p>DiceHand</p>
<p><?= $lastHandRoll ?></p>