<?php

/**
 * yatzy view template to generate web page, or part of a web page.
 */

declare(strict_types=1);

$header = $header ?? null;
$message = $message ?? null;

$diceImages = [];
if (isset($_SESSION["hand"])) {
    $diceImages = $_SESSION["hand"]->getImages() ?? [];
}

$diceHand = $_SESSION["diceHand"] ?? null;

$result = $_SESSION["result"] ?? null;

?>

<h1><?= $header ?></h1>

<p><?= $message ?></p>

<form method="post" action="<?= $startGame ?>">
    <input type=submit name="startGame" value="Starta spelet" id="btnStartGame">
</form>

<form class=halfpage method="post" action="<?= $roll ?>">
    <div class="yatzyblock">
        <label for="scorePlayer">Ettor:</label>
        <input type="number" name="one" value="<?= $sumOne ?>" readonly>
    </div>
    <div class="yatzyblock">
        <label for="scorePlayer">Tvåor:</label>
        <input type="number" name="two" value="<?= $sumTwo ?>" readonly>
    </div>
    <div class="yatzyblock">
        <label for="scorePlayer">Treor:</label>
        <input type="number" name="three" value="<?= $sumThree ?>" readonly>
    </div>
    <div class="yatzyblock">
        <label for="scorePlayer">Fyror:</label>
        <input type="number" name="four" value="<?= $sumFour ?>" readonly>
    </div>
    <div class="yatzyblock">
        <label for="scorePlayer">Femmor:</label>
        <input type="number" name="five" value="<?= $sumFive ?>" readonly>
    </div>
    <div class="yatzyblock">
        <label for="scorePlayer">Sexor:</label>
        <input type="number" name="six" value="<?= $sumSix ?>" readonly>
    </div>
    <div class="yatzyblock">
        <label for="scorePlayer">Summa:</label>
        <input type="number" name="sum" value="<?= $sum ?>" readonly>
    </div>

    <input type=submit name="rollDice" value="Slå tärningar" id="btnRollDice">
</form>

<div class="dicefield halfpage">
    
</div>

<div>
    <h3>Resultat</h3>
    <p><?= $result ?></p>
</div>