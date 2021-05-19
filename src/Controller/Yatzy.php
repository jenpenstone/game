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
        destroySession();

        $psr17Factory = new Psr17Factory();

        $_SESSION["yatzygame"] = new \Jess19\Dice\Yatzy();
        $data = $_SESSION["yatzygame"]->initGame();

        $body = renderView("layout/yatzygame.php", $data);

        return $psr17Factory
            ->createResponse(200)
            ->withBody($psr17Factory->createStream($body));
    }

    public function start(): ResponseInterface
    {
        $psr17Factory = new Psr17Factory();

        $_SESSION["yatzygame"] = new \Jess19\Dice\Yatzy();
        $data = $_SESSION["yatzygame"]->startGame();

        $body = renderView("layout/yatzygame.php", $data);

        return $psr17Factory
            ->createResponse(200)
            ->withBody($psr17Factory->createStream($body));
    }

    public function play(): ResponseInterface
    {
        $psr17Factory = new Psr17Factory();

        $callable = $_SESSION["yatzygame"] ?? null;

        $data = $callable->playGame();

        $body = renderView("layout/yatzygame.php", $data);

        return $psr17Factory
            ->createResponse(200)
            ->withBody($psr17Factory->createStream($body));
    }
}
