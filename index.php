<?php

$gameController = new GameController();
$template = new MainTemplate($gameController->getGames());

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gameController->addGame();
} else {
    return $template;
}

