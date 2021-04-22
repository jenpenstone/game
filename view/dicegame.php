<?php

/**
 * Standard view template to generate a simple web page, or part of a web page.
 */

declare(strict_types=1);

$header = $header ?? null;
$message = $message ?? null;
$action = $action ?? null;
$endGame = $endGame ?? null;
$nbrDice = $nbrDice ?? null;
$lastHandRoll = $lastHandRoll ?? [];
$playerRolls = $playerRolls ?? null;
$playerSum = $_SESSION["computerSum"] ?? null;
$scorePlayer = $scorePlayer ?? null;
$computerRolls = $computerRolls ?? null;
$computerSum = $_SESSION["computerSum"] ?? null;
$scoreComputer = $scoreComputer ?? null;

?>

<h1><?= $header ?></h1>

<p><?= $message ?></p>

<form method="post" action="<?= $endGame ?>">
    <p> Ställning:</p>
    <input type="number" name="scorePlayer" value="<?= $scorePlayer ?>" readonly>
    <input type="number" name="scoreComputer" value="<?= $scoreComputer ?>" readonly>
    <input type=submit name="doEndGame" value="Nollställ" id="btnEndGame">
</form>

<form method="post" action="<?= $action ?>">
    <label for="nbrDice">Antal tärningar:</label>
    <input type="number" name="nbrDice" value="<?= $nbrDice ?>" min="1" max="2">
    <input type=submit name="doStartGame" value="Starta ny omgång" id="btnStart">
    <br>
    <input type=submit name="doContinue" value="Fortsätt" id="btnContinue">
    <input type=submit name="doStopGame" value="Stanna" id="btnStop">
</form>

<div>
    <h3>Spelaren:</h3>
    <div>
        <?php for ($i = 0; $i < count($lastHandRoll); $i++) : ?>
            <div class='dice <?= $lastHandRoll[$i] ?>'></div>
        <?php endfor; ?>
    </div>
    <p>Summa: <?= $playerSum ?></p>
</div>

<div>
    <h3>Datorn:</h3>
    <p>Summa: <?= $computerSum ?></p>
</div>