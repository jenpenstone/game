<?php

declare(strict_types=1);

namespace Jess19\Dice;

use function Mos\Functions\{
    destroySession,
    redirectTo,
    renderView,
    sendResponse,
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
            "action" => url("/dicegame/process"),
            "endGame" => url("/dicegame/end"),
            "result" => "",
        ];
    }

    /**
     * Init a game.
     */
    public function initGame(): void
    {
        //Render view
        $this->showView();
    }

    /**
     * Start a game.
     */
    public function newGame($nbrDice): void
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

        //Render view
        $this->showView();
    }


    /**
     * Player continues to roll.
     */
    public function continueRoll(): void
    {
        //Roll
        $this->playerRolls();

        if ($_SESSION["playerSum"] > 21) {
            $_SESSION["result"] = "Tyvärr! Du förlorade!";
            $_SESSION["scoreComputer"] += 1;
            //End round
        } else if ($_SESSION["playerSum"] == 21) {
            $_SESSION["result"] = "Grattis, Du fick 21!";
        }
    }

    /**
     * Player has pressed button for stop rolling the dice.
     */
    public function playerStopped(): void
    {
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
    public function startRound(): void
    {
        // init the score variables.
        $_SESSION["playerSum"] = 0;
        $_SESSION["computerSum"] = 0;
        $_SESSION["result"] = "";
    }

    /**
     * Roll the dice for player.
     */
    public function playerRolls(): void
    {
        $_SESSION["hand"]->roll();
        $_SESSION["playerSum"] += $_SESSION["hand"]->getSum();
    }

    /**
     * Computer plays.
     */
    public function computerPlays(): void
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
    public function checkWinner(): void
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


    /**
     * Render view.
     */
    public function showView(): void
    {
        $body = renderView("layout/dicegame.php", $this->data);
        sendResponse($body);
    }
}
