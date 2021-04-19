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
        ];
        
        $die = new Dice();
        $die->roll();
        $data["lastRoll"] = $die->getValue();

        $die2 = new GraphicalDice();
        $die2->roll();
        $data["lastGraphRoll"] = $die2->getImage();

        $hand = new DiceHand(2);
        $hand->roll();
        $values = $hand->getValues();
        $res = "";
        for ($i = 0; $i < count($values); $i++) {
            $res .= $values[$i] . ", ";
        }
        $data["lastHandRoll"] = $res;

        $body = renderView("layout/dicegame.php", $data);
        sendResponse($body);
    }

}
