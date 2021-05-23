<?php

declare(strict_types=1);

namespace Jess19\Dice;

use function Mos\Functions\{
    url
};

/**
 * Class for playing Yatzy.
 */

class Yatzy
{
    private int $nbrDice = 5;
    private int $nbrRounds = 6;

    private $data;
    private array $hand;
    private $totalSum;
    private int $nbrRolls;
    private int $currentRound;

    /**
     * Constructor to create a Yatzy game.
     */
    public function __construct()
    {
        $this->data = [
            "header" => "Yatzy",
            "message" => "Markera de tärningar du vill slå igen.",
            "startGame" => url("/yatzygame/start"),
            "rollDice" => url("/yatzygame/play"),
        ];

        //Create a dicehand
        $this->hand = [new GraphicalDice(), new GraphicalDice(), new GraphicalDice(), new GraphicalDice(), new GraphicalDice()];

        //init variables
        $this->currentRound = 0;
        $this->nbrRolls = 0;
    }

    /**
     * Start a game.
     */
    public function initGame(): array
    {
        $this->data["dice"] = "";
        $this->data["hideBtn"] = true;
        return $this->data;
    }

    /**
     * Start a game.
     */
    public function startGame(): array
    {
        //Make the fist roll
        $dice = "";
        $i = 0;
        foreach ($this->hand as $die) {
            $die->roll();
            $value = $die->getValue();
            $dice .= "<input type='checkbox' id='die$i' name='die$i' value='true'>";
            $dice .= "<label for='die$i'> <div class='dice dice-$value'></div> </label><br>";
            $i++;
        }
        $_SESSION["dice"] = $dice;

        $this->totalSum = 0;
        $this->currentRound += 1;
        $this->nbrRolls += 1;
        return $this->data;
    }

    /**
     * Play the game.
     */
    public function playGame(): array
    {
        $dice = "";
        $i = 0;
        $this->nbrRolls += 1;

        if ($this->nbrRolls == 3) {
            //calculate sum and add to sum array
            $sum = 0;
            foreach ($this->hand as $die) {
                $value = $die->getValue();
                if ($value == $this->currentRound) {
                    $sum += $value;
                }

                $dice .= "<div class='dice dice-$value'></div>";
                $i++;
            }
            $this->totalSum += $sum;
            $this->data["sum$this->currentRound"] = $sum;

            if ($this->currentRound == 6) {
                if ($this->totalSum > 62) {
                    $this->totalSum += 50;
                    $this->data["bonus"] = 50;
                }
                $this->data["sumTotal"] = $this->totalSum;
                $this->data["hideBtn"] = true;
            } else {
                $this->nbrRolls = 0;
                $this->currentRound += 1;
            }
        } else {
            //roll dice that are marked
            foreach ($this->hand as $die) {
                $roll = $_POST["die$i"] ?? false;
                if ($roll) {
                    $die->roll();
                }
                $value = $die->getValue();
                $dice .= "<input type='checkbox' id='die$i' name='die$i' value='true'>";
                $dice .= "<label for='die$i'> <div class='dice dice-$value'></div> </label><br>";
                $i++;
            }
        }

        $_SESSION["dice"] = $dice;

        return $this->data;
    }

    /**
     * Start a new round.
     */
    public function newRound(): array
    {
        //set/reset $nbrRolls to 0

        return $this->data;
    }

    /**
     * roll the Dice in the hand.
     */
    public function rollHand(): array
    {
        //Roll all dices in dicehand except for the ones that are saved

        //increase $nbrRolls by 1
        return $this->data;
    }

    /**
     * Save a dice from being rolled again.
     */
    private function saveDice(array $dice): void
    {
        //Save the nbr of the position of the dice that should not be rolled again.
    }    


    /**
     * Get sum of the diceHand and store in $rounds.
     */
    public function sumHand(): void
    {
        //loop through diceHand array with dice
        //if value of dice is same as $currentround the value will be added to the sum
        //the sum for the round is stored in the $rounds array
    }

    /**
     * Get the total sum for the game.
     */
    public function sumGame(): int
    {
        // loop through array $rounds and summarize all values

        //return sum
        return 0;
    }
}
