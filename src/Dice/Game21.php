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
    public function endGame(): void
    {

    }

    /**
     * Play a game.
     */
    public function playGame(): void
    {
        //Array with variables to send to view. 
        $data = [
            "header" => "Game 21",
            "message" => "Play game 21!",
            "action" => url("/form/process"),
            "endGame" => url("/form/endGame"),
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

            //Create new dice hand.
            $_SESSION["hand"] = new DiceHand($nbrDice);
            $_SESSION["compHand"] = new DiceHand($nbrDice);
        }

        if ($_SESSION["playerSum"] == 21) {
            $data["message"] = "Grattis! Du fick 21!";
        } else if ($_SESSION["playerSum"] > 21) {
            $data["message"] = "Tyvärr! Du förlorade!";
            //endGame();
        }

        //If stop button is pressed
        if ($doStopGame || $_SESSION["playerSum"] >=21) {
            //Computer plays
            $cHand = $_SESSION["compHand"];
            while ($_SESSION["computerSum"] < 21) {
                $cHand->roll();
                $_SESSION["computerSum"] += $cHand->getSum();
                echo $_SESSION["computerSum"] . ", ";
            }

            //Check who won the game
            if ($_SESSION["computerSum"] == 21) {
                $data["message"] = "Tyvärr! Du förlorade!";
            } else if ($_SESSION["computerSum"] > 21) {
                $data["message"] = "Grattis! Du vann!";
            } else {
                if ($_SESSION["computerSum"] < $_SESSION["playerSum"]) {
                    $data["message"] = "Grattis! Du vann!";
                } else {
                    $data["message"] = "Tyvärr! Du förlorade!";
                }
            }
            //endGame();
        } else {
            //get pointer to players hand
            $hand = $_SESSION["hand"];
            //Roll dice and get result
            $hand->roll();
            $diceImages = $hand->getImages();

            $data["lastHandRoll"] = $diceImages;
            $_SESSION["playerSum"] += $hand->getSum();
        }

        $body = renderView("layout/dicegame.php", $data);
        sendResponse($body);
    }
}
