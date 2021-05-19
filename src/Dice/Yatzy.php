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
    private $data;
    private DiceHand $hand;
    private array $rounds;
    private array $savedDice;
    private int $nbrRolls;
    private int $currentRound;

    /**
     * Constructor to create a Yatzy game.
     */
    public function __construct()
    {
        $this->data = [
            "header" => "Yatzy",
            "start" => url("/yatzygame/play"),
            "endGame" => url("/yatzygame/end"),
            "result" => "",
        ];

        //Create parts needed for showing view

    }

    /**
     * Start a game.
     */
    public function startGame(): array
    {
        //Create a dicehand

        //Store hand in session variable to be accessed at all times

        //create an empty rounds array

        //create empty savedDice array



        return $this->data;
    }

    /**
     * Play the game.
     */
    public function playGame(): array
    {
        //
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

    /**
     * Player has pressed button for new round.
     */
    public function endGame(): void
    {
       
    }
}
