<?php

declare(strict_types=1);

namespace Jess19\Dice;

use function Mos\Functions\ {
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
            "message" => "Play game 21!",
            "action" => url("/form/process"),
            "dice" => $_SESSION["dice"] ?? null,
        ];

        $nbrDice = intval($data["dice"]);
        $hand = new DiceHand($nbrDice);
        $hand->roll();
        $dice = $hand->getValues();
        $images = $hand->getImages();
        $res = "";
        for ($i = 0; $i < count($dice); $i++) {
            $res .= "<div class='dice ";
            $res .= $images[$i];
            $res .= "'></div>";
        }
        $data["lastHandRoll"] = $res;

        $body = renderView("layout/dicegame.php", $data);
        sendResponse($body);
    }

    

}
