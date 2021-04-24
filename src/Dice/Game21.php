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
        ];
    }

    /**
     * Init a game.
     */
    public function initGame(): void
    {
        echo "Init game";
        //Unset session
        destroySession();

        //Render view
        $this->showView();
    }

    /**
     * Start a game.
     */
    public function newGame($nbrDice): void
    {
        echo "New game";
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
            $this->data["result"] = "Tyvärr! Du förlorade!";
            $_SESSION["scoreComputer"] += 1;
            //End round
        } else if ($_SESSION["playerSum"] == 21) {
            $this->data["result"] = "Grattis, Du fick 21!";
        }

        //Render view
        $this->showView();
    }

    /**
     * Player has pressed button for stop rolling the dice.
     */
    public function playerStopped(): void
    {
        echo "Player stopped";

        //Computer plays
        $this->computerPlays();

        //Check who won the round
        $this->checkWinner();

        //Render view
        $this->showView();
    }

    /**
     * Player has pressed button for new round.
     */
    public function newRound(): void
    {
        echo "New round";

        // init the score variables.
        $this->startRound();

        //Player rolls the dice
        $this->playerRolls();

        //Render view
        $this->showView();
    }

    /**
     * Start round.
     */
    public function startRound(): void
    {
        echo "Start round";

        // init the score variables.
        $_SESSION["playerSum"] = 0;
        $_SESSION["computerSum"] = 0;
    }

    /**
     * Roll the dice for player.
     */
    public function playerRolls(): void
    {
        echo "player rolls";

        $_SESSION["hand"]->roll();
        $this->data["lastHandRoll"] = $_SESSION["hand"]->getImages();
        $_SESSION["playerSum"] += $_SESSION["hand"]->getSum();
    }

    /**
     * Computer plays.
     */
    public function computerPlays(): void
    {
        echo "Computer plays";

        $cHand = $_SESSION["compHand"];
        while ($_SESSION["computerSum"] < 21) {
            $cHand->roll();
            $_SESSION["computerSum"] += $cHand->getSum();
            echo $_SESSION["computerSum"] . ", ";
        }
    }

    /**
     * Check who won the round.
     */
    public function checkWinner(): void
    {
        echo "Check winner";

        if ($_SESSION["computerSum"] == 21) {
            $this->data["result"] = "Tyvärr! Du förlorade!";
        } else if ($_SESSION["computerSum"] > 21) {
            $this->data["result"] = "Grattis! Du vann!";
        } else {
            if ($_SESSION["computerSum"] < $_SESSION["playerSum"]) {
                $this->data["result"] = "Grattis! Du vann!";
            } else {
                $this->data["result"] = "Tyvärr! Du förlorade!";
            }
        }
    }


    /**
     * Render view.
     */
    public function showView(): void
    {
        echo "Render view";

        $body = renderView("layout/dicegame.php", $this->data);
        sendResponse($body);
    }
}
