<?php

declare(strict_types=1);

namespace Jess19\Dice;

use function Mos\Functions\{
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
    /**
     * Play a game.
     */
    public function playGame(): void
    {

        $data = [
            "header" => "Game 21",
            "message" => "Spela 21!",
            "action" => url("/dicegame/process"),
            "endGame" => url("/dicegame/end"),
            "nbrDice" => $_SESSION["nbrDice"] ?? null,
        ];

        $doStartGame = $_SESSION["doStartGame"] ?? null;
        $doContinue = $_SESSION["doContinue"] ?? null;
        $doStopGame = $_SESSION["doStopGame"] ?? null;

        //If start button is pressed, start a new game.
        if ($doStartGame) {
            //Nbr of dice to use.
            $nbrDice = intval($data["nbrDice"]);

            // Unset of the session variables.
            $_SESSION["playerSum"] = 0;
            $_SESSION["computerSum"] = 0;

            if(!isset($_SESSION["scorePlayer"])){
                $_SESSION["scorePlayer"] = 0;
            }
            if (!isset($_SESSION["scoreComputer"])) {
                $_SESSION["scoreComputer"] = 0;
            }

            //Create new dice hand.
            $_SESSION["hand"] = new DiceHand($nbrDice);
            $_SESSION["compHand"] = new DiceHand($nbrDice);

            $_SESSION["hand"]->roll();
            $data["lastHandRoll"] = $_SESSION["hand"]->getImages();
            $_SESSION["playerSum"] += $_SESSION["hand"]->getSum();
        }
        
        //If continue button is pressed, roll the dice.
        if ($doContinue) {
            $_SESSION["hand"]->roll();
            $data["lastHandRoll"] = $_SESSION["hand"]->getImages();
            $_SESSION["playerSum"] += $_SESSION["hand"]->getSum();
        }

        //If player get more than 21 game is over.
        if ($_SESSION["playerSum"] > 21) {
            $data["result"] = "Spelet slut!";
            $_SESSION["scoreComputer"] += 1;
            //End round

         //If player get 21
        } else if ($_SESSION["playerSum"] == 21) {
            $data["result"] = "Grattis, Du fick 21!";
        }

        //If stop button is pressed
        if ($doStopGame || $_SESSION["playerSum"] >= 21) {
            //Computer plays
            $cHand = $_SESSION["compHand"];
            while ($_SESSION["computerSum"] < 21) {
                $cHand->roll();
                $_SESSION["computerSum"] += $cHand->getSum();
                echo $_SESSION["computerSum"] . ", ";
            }

            
        }

        //$nbrDice = intval($data["nbrDice"]);
        //$_SESSION["hand"] = new DiceHand($nbrDice);
        //$_SESSION["hand"]->roll();
        //$data["lastHandRoll"] = $_SESSION["hand"]->getImages();
        //$_SESSION["playerSum"] += $_SESSION["hand"]->getSum();

        $body = renderView("layout/dicegame.php", $data);
        sendResponse($body);
    }

    /**
     * Roll the dice for the player.
     */
    private function playerRolls(): void {
        $_SESSION["hand"]->roll();
        $data["lastHandRoll"] = $_SESSION["hand"]->getImages();
        $_SESSION["playerSum"] += $_SESSION["hand"]->getSum();
    }

    /**
     * Roll the dice for the player.
     */
    private function endRound(): void
    {

    }
}
