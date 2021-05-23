<?php

/**
 * yatzy view template to generate web page, or part of a web page.
 */

declare(strict_types=1);

$header = $header ?? null;
$message = $message ?? null;

$result = $result ?? null;

$startGame = $startGame ?? null;
$rollDice = $rollDice ?? null;

$dice = $_SESSION["dice"] ?? null;
$hideBtn = $hideBtn ?? false;

$sumOne = $sum1 ?? null;
$sumTwo = $sum2 ?? null;
$sumThree = $sum3 ?? null;
$sumFour = $sum4 ?? null;
$sumFive = $sum5 ?? null;
$sumSix = $sum6 ?? null;
$bonus = $bonus ?? null;
$sum = $sumTotal ?? null;

?>

<h1><?= $header ?></h1>

<p><?= $message ?></p>

<form method="post" action="<?= $startGame ?>">
    <input type=submit name="startGame" value="Starta spelet" id="btnStartGame">
</form>

<form method="post" action="<?= $rollDice ?>">
    <div class=halfpage>
        <div class="yatzyblock">
            <label for="one">Ettor:</label>
            <input type="number" name="one" value="<?= $sumOne ?>" readonly>
        </div>
        <div class="yatzyblock">
            <label for="two">Tvåor:</label>
            <input type="number" name="two" value="<?= $sumTwo ?>" readonly>
        </div>
        <div class="yatzyblock">
            <label for="three">Treor:</label>
            <input type="number" name="three" value="<?= $sumThree ?>" readonly>
        </div>
        <div class="yatzyblock">
            <label for="four">Fyror:</label>
            <input type="number" name="four" value="<?= $sumFour ?>" readonly>
        </div>
        <div class="yatzyblock">
            <label for="five">Femmor:</label>
            <input type="number" name="five" value="<?= $sumFive ?>" readonly>
        </div>
        <div class="yatzyblock">
            <label for="six">Sexor:</label>
            <input type="number" name="six" value="<?= $sumSix ?>" readonly>
        </div>
        <div class="yatzyblock">
            <label for="bonus">Bonus:</label>
            <input type="number" name="bonus" value="<?= $bonus ?>" readonly>
        </div>
        <div class="yatzyblock sum">
            <label for="scorePlayer">Summa:</label>
            <input type="number" name="sum" value="<?= $sum ?>" readonly>
        </div>
    </div>

    <div class="dicefield halfpage">
        <?= $dice ?>
    </div>

    <?php if (!$hideBtn) : ?>
        <input type=submit name="rollDice" value="Slå tärningar" id="btnRollDice">
    <?php endif; ?>

</form>