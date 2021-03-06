<?php

declare(strict_types=1);

namespace Mos\Router;

use function Mos\Functions\{
    destroySession,
    redirectTo,
    renderView,
    renderTwigView,
    sendResponse,
    url
};

/**
 * Class Router.
 */
class Router
{
    public static function dispatch(string $method, string $path): void
    {
        if ($method === "GET" && $path === "/") {
            $data = [
                "header" => "Index page",
                "message" => "Hello, this is the index page, rendered as a layout.",
            ];
            $body = renderView("layout/page.php", $data);
            sendResponse($body);
            return;
        } else if ($method === "GET" && $path === "/session") {
            $body = renderView("layout/session.php");
            sendResponse($body);
            return;
        } else if ($method === "GET" && $path === "/session/destroy") {
            destroySession();
            redirectTo(url("/session"));
            return;
        } else if ($method === "GET" && $path === "/debug") {
            $body = renderView("layout/debug.php");
            sendResponse($body);
            return;
        } else if ($method === "GET" && $path === "/twig") {
            $data = [
                "header" => "Twig page",
                "message" => "Hey, edit this to do it youreself!",
            ];
            $body = renderTwigView("index.html", $data);
            sendResponse($body);
            return;
        } else if ($method === "GET" && $path === "/some/where") {
            $data = [
                "header" => "Rainbow page",
                "message" => "Hey, edit this to do it youreself!",
            ];
            $body = renderView("layout/page.php", $data);
            sendResponse($body);
            return;
        } else if ($method === "GET" && $path === "/dicegame") {
            $callable = new \Jess19\Dice\Game21();
            $callable->initGame();
            return;
        } else if ($method === "GET" && $path === "/dicegame/play") {
            $callable = new \Jess19\Dice\Game21();
            $callable->playGame();
            return;
        } else if ($method === "POST" && $path === "/dicegame/process") {
            $callable = new \Jess19\Dice\Game21();
            if (isset($_POST["doStartGame"])) {
                $callable->newGame($_POST["nbrDice"]);
            } else if (isset($_POST["doContinue"])) {
                $callable->continueRoll();
            } else if (isset($_POST["doStop"])) {
                $callable->playerStopped();
            } else if (isset($_POST["doNewRound"])) {
                $callable->newRound();
            }

            redirectTo(url("/dicegame/play"));
            return;
        } else if ($method === "POST" && $path === "/dicegame/end") {
            destroySession();
            redirectTo(url("/dicegame"));
            return;
        }

        $data = [
            "header" => "404",
            "message" => "The page you are requesting is not here. You may also checkout the HTTP response code, it should be 404.",
        ];
        $body = renderView("layout/page.php", $data);
        sendResponse($body, 404);
    }
}
