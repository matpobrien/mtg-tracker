<?php

$gameController = new GameController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gameController->addGame();
} else {
    $games = $gameController->getGames();
}

$template = new MainTemplate($games);

echo $template;
