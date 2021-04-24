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

$diceImages = [];
if (isset($_SESSION["hand"])) {
    $diceImages = $_SESSION["hand"]->getImages() ?? [];
}

$playerSum = $_SESSION["playerSum"] ?? null;
$computerSum = $_SESSION["computerSum"] ?? null;
$scorePlayer = $_SESSION["scorePlayer"] ?? null;
$scoreComputer = $_SESSION["scoreComputer"] ?? null;

$result = $_SESSION["result"] ?? null;

var_dump($_SESSION["state"]);

?>

<h1><?= $header ?></h1>

<p><?= $message ?></p>

<form method="post" action="<?= $endGame ?>">
    <p> Ställning:</p>
    <label for="scorePlayer">Spelaren:</label>
    <input type="number" name="scorePlayer" value="<?= $scorePlayer ?>" readonly>
    <label for="scoreComputer">Datorn:</label>
    <input type="number" name="scoreComputer" value="<?= $scoreComputer ?>" readonly>
    <input type=submit name="doEndGame" value="Nollställ" id="btnEndGame">
</form>

<form method="post" action="<?= $action ?>">
    <label for="nbrDice">Antal tärningar:</label>
    <input type="number" name="nbrDice" value="<?= $nbrDice ?>" min="1" max="2">
    <?php if ($_SESSION["state"] == 1) : ?>
        <input type=submit name="doStartGame" value="Starta spelet" id="btnStart">
    <?php endif; ?>
    <br>
    <?php if ($_SESSION["state"] == 2) : ?>
        <input type=submit name="doContinue" value="Fortsätt" id="btnContinue">
        <input type=submit name="doStop" value="Stanna" id="btnStop">
    <?php endif; ?>
    <br>
    <?php if ($_SESSION["state"] == 3) : ?>
        <input type=submit name="doNewRound" value="Starta ny omgång" id="btnNewRound">
    <?php endif; ?>
</form>

<div>
    <h3>Spelaren:</h3>
    <div>
        <?php for ($i = 0; $i < count($diceImages); $i++) : ?>
            <div class='dice <?= $diceImages[$i] ?>'></div>
        <?php endfor; ?>
    </div>
    <p>Summa: <?= $playerSum ?></p>
</div>

<div>
    <h3>Datorn:</h3>
    <p>Summa: <?= $computerSum ?></p>
</div>

<div>
    <h3>Resultat</h3>
    <p><?= $result ?></p>
</div>