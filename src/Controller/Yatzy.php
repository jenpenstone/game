<?php

declare(strict_types=1);

namespace Jess19\Controller;

use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

use function Mos\Functions\{
    destroySession,
    renderView,
    url
};

/**
 * Controller for the Yatzy routes.
 */
class Yatzy
{
    public function init(): ResponseInterface
    {
        $psr17Factory = new Psr17Factory();

        $callable = new \Jess19\Dice\Yatzy();
        $data = $callable->initGame();

        $body = renderView("layout/yatzygame.php", $data);

        return $psr17Factory
            ->createResponse(200)
            ->withBody($psr17Factory->createStream($body));
    }

    public function play(): ResponseInterface
    {
        $psr17Factory = new Psr17Factory();

        $callable = new \Jess19\Dice\Yatzy();
        if (isset($_POST["doStartGame"])) {
            $callable->newGame($_POST["nbrDice"]);
        } else if (isset($_POST["doContinue"])) {
            $callable->continueRoll();
        } else if (isset($_POST["doStop"])) {
            $callable->playerStopped();
        } else if (isset($_POST["doNewRound"])) {
            $callable->newRound();
        }

        $data = $callable->playGame();

        $body = renderView("layout/yatzygame.php", $data);

        return $psr17Factory
            ->createResponse(200)
            ->withBody($psr17Factory->createStream($body));
    }

    public function end(): ResponseInterface
    {
        destroySession();

        return (new Response())
            ->withStatus(301)
            ->withHeader("Location", url("/yatzygame"));
    }
}
