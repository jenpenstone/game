<?php

/**
 * Standard view template to generate a simple web page, or part of a web page.
 */

declare(strict_types=1);

$header = $header ?? null;
$message = $message ?? null;



?>

<h1><?= $header ?></h1>

<p><?= $message ?></p>

<form action="">
    <label for="dice">Antal tärningar:</label>
    <input type="number" value="1" min="1" max="2" id="dice">
    <input type=submit>
</form>

<p>DiceHand</p>
<p><?= $lastHandRoll ?></p>