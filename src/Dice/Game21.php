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

        var_dump($_SESSION);

        $data = [
            "header" => "Game 21",
            "message" => "Play game 21!",
            "action" => url("/form/process"),
            "dice" => $_SESSION["dice"] ?? null,
        ];

        $formView = "";
        $res = "";

        if ($submit == null) {
            $formView .= "<label for='dice'>Antal tärningar:</label>";
            $formView .= "<input type='number' name='dice' value='1' min='1' max='2'>";
            $formView .= "<input type=submit name='submit' value='Starta spelet'>";
        } else {
            $formView .= "<input type=submit name='submit' value='Fortsätt'>";
            $formView .= "<input type=submit name='submit' value='Stanna'>";

            if ($submit == "Starta spelet") {
                $nbrDice = intval($data["dice"]);
                $_SESSION["hand"] = new DiceHand($nbrDice);
                $_SESSION["sum"] = 0;
            } else if ($submit == "Stanna") {
                destroySession();
                redirectTo(url("/dicegame"));
            }

            $hand = $_SESSION["hand"] ?? null;
            $hand->roll();
            $dice = $hand->getValues();
            $images = $hand->getImages();
            $res .= "<div class='dicehand'>";
            for ($i = 0; $i < count($dice); $i++) {
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
