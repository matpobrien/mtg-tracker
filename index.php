<?php

include_once __DIR__ . '/Templates/MainTemplate.php';
include_once __DIR__ . '/GameController.php';
include_once __DIR__ . '/GameRepository.php';

$config = [
    'fileName' => __DIR__ . '/games.json',
];
$gameRepository = new GameRepository($config['fileName']);
$gameController = new GameController($gameRepository);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo $gameController->addGame();
} else {
    echo $gameController->getGames();
}
