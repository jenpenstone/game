<?php

declare(strict_types=1);

namespace Jess19\Dice;

use function Mos\Functions\{
    url
};

/**
 * Class for playing Game 21.
 */

class Game21
{
    private $data;


    /**
     * Constructor to create a Game21.
     */
    public function __construct()
    {
        $this->data = [
            "header" => "Game 21",
            "message" => "Spela 21!",
            "action" => url("/dicegame/play"),
            "endGame" => url("/dicegame/end"),
            "result" => "",
        ];
    }

    /**
     * Init a game.
     */
    public function initGame(): array
    {
        $_SESSION["state"] = 1;
        return $this->data;
    }

    /**
     * Init a game.
     */
    public function playGame(): array
    {
        return $this->data;
    }

    /**
     * Start a game.
     */
    public function newGame($nbrDice): array
    {
        //Nbr of dice to use.
        $dice = intval($nbrDice);

        // init the score variables.
        $_SESSION["scorePlayer"] = 0;
        $_SESSION["scoreComputer"] = 0;

        //Create new dice hand.
        $_SESSION["hand"] = new DiceHand($dice);
        $_SESSION["compHand"] = new DiceHand($dice);

        //Start new round
        $this->startRound();

        //Player rolls the dice
        $this->playerRolls();

        return $this->data;
    }


    /**
     * Player continues to roll.
     */
    public function continueRoll(): void
    {
        //Roll
        $this->playerRolls();

        //Check if player has reached 21 and round is finished.
        if ($_SESSION["playerSum"] > 21) {
            $_SESSION["result"] = "Tyvärr! Du förlorade!";
            $_SESSION["scoreComputer"] += 1;

            $_SESSION["state"] = 3;
        } else if ($_SESSION["playerSum"] == 21) {
            $_SESSION["result"] = "Grattis, Du fick 21!";
        }
    }

    /**
     * Player has pressed button for stop rolling the dice.
     */
    public function playerStopped(): void
    {
        $_SESSION["state"] = 3;

        //Computer plays
        $this->computerPlays();

        //Check who won the round
        $this->checkWinner();
    }

    /**
     * Player has pressed button for new round.
     */
    public function newRound(): void
    {
        // init the score variables.
        $this->startRound();

        //Player rolls the dice
        $this->playerRolls();
    }

    /**
     * Start round.
     */
    private function startRound(): void
    {
        // init the score variables.
        $_SESSION["playerSum"] = 0;
        $_SESSION["computerSum"] = 0;
        $_SESSION["result"] = "";
        $_SESSION["state"] = 2;
    }

    /**
     * Roll the dice for player.
     */
    private function playerRolls(): void
    {
        $_SESSION["hand"]->roll();
        $_SESSION["playerSum"] += $_SESSION["hand"]->getSum();
    }

    /**
     * Computer plays.
     */
    private function computerPlays(): void
    {
        $cHand = $_SESSION["compHand"];
        while ($_SESSION["computerSum"] < 21) {
            $cHand->roll();
            $_SESSION["computerSum"] += $cHand->getSum();
        }
    }

    /**
     * Check who won the round.
     */
    private function checkWinner(): void
    {
        if ($_SESSION["computerSum"] == 21) {
            $_SESSION["result"] = "Tyvärr! Du förlorade!";
            $_SESSION["scoreComputer"] += 1;
        } else if ($_SESSION["computerSum"] > 21) {
            $_SESSION["result"] = "Grattis! Du vann!";
            $_SESSION["scorePlayer"] += 1;
        } else {
            if ($_SESSION["computerSum"] < $_SESSION["playerSum"]) {
                $_SESSION["result"] = "Grattis! Du vann!";
                $_SESSION["scorePlayer"] += 1;
            } else {
                $_SESSION["result"] = "Tyvärr! Du förlorade!";
                $_SESSION["scoreComputer"] += 1;
            }
        }
    }
}
