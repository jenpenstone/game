<?php

declare(strict_types=1);

namespace Jess19\Dice;

use function Mos\Functions\ {
    redirectTo,
    renderView,
    sendResponse,
    url,
    destroySession
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
        $submit = $_SESSION["submit"] ?? null;
        $_SESSION["submit"] = null;

        $result = $_SESSION["sum"] ?? null;

        var_dump($_SESSION);

        $data = [
            "header" => "Game 21",
            "message" => "Play game 21!",
            "action" => url("/form/process"),
            "dice" => $_SESSION["dice"] ?? null,
        ];

        //Empty variables for form and game content
        $formView = "";
        $res = "";

        //Start content for form
        if ($submit == null) {
            destroySession();
            $formView .= "<label for='dice'>Antal tärningar:</label>";
            $formView .= "<input type='number' name='dice' value='1' min='1' max='2'>";
            $formView .= "<input type=submit name='submit' value='Starta spelet'>";
        //If user has reached 21
        } else if ($submit == "Stanna" || $result >= 21) {
            //If user got more than 21, end game without computer playing
            if ($result > 21) {
                $res .= "<h3>Tyvärr, du förlorade!!</h3>";
            } else {
                //If user got 21
                if ($result == 21) {
                $res .= "<p>Grattis, du fick 21!</p>";
                }
                //Computer plays
                $cSum = 0;
                $cDice = "";
                $nbrDice = intval($data["dice"]);
                $cHand = new DiceHand($nbrDice);
                while ($cSum <= 21) {
                    $cHand->roll();
                    $dice = $cHand->getValues();
                    for ($i = 0; $i < count($dice); $i++) {
                        $cDice .= $dice[$i] . " ";
                    }
                    $cSum += $cHand->getSum();
                }

                //Present computer result
                $res .= "<p><strong>Datorns resultat:</strong> ";
                $res .= $cDice . " = " . $cSum; 
                $res .= "</p>";

                //Check who won the game
                if ($cSum == 21) {
                    $res .= "<p><strong>Tyvärr, du förlorade!</strong> ";
                } else if ($cSum > 21 || $cSum < $result) {
                    $res .= "<p><strong>Grattis! Du vann!!</strong> ";
                } else {
                    $res .= "<p><strong>Tyvärr, du förlorade!</strong> ";
                }
                //End session
                
            }
            
        } else {
            $formView .= "<input type=submit name='submit' value='Fortsätt'>";
            $formView .= "<input type=submit name='submit' value='Stanna'>";

            if ($submit == "Starta spelet") {
                $nbrDice = intval($data["dice"]);
                $_SESSION["hand"] = new DiceHand($nbrDice);
                $_SESSION["sum"] = 0;
            } else if ($submit == "Stanna" || $_SESSION["sum"] >= 21) {
                redirectTo(url("/dicegame"));
            }

            $hand = $_SESSION["hand"] ?? null;
            $hand->roll();
            $images = $hand->getImages();
            $res .= "<div class='dicehand'>";
            for ($i = 0; $i < count($images); $i++) {
                $res .= "<div class='dice ";
                $res .= $images[$i];
                $res .= "'></div>";
            }
            $res .= "</div>";

            $sum = $hand->getSum();
            $_SESSION["sum"] += $sum;

            $res .= "<p>Summa: " . $_SESSION["sum"] . "</p>";

        }

        $data["form"] = $formView;
        $data["result"] = $res;

        $body = renderView("layout/dicegame.php", $data);
        sendResponse($body);
    }

    

}
