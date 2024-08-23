<?php

include_once __DIR__ . '/Template/MainTemplate.php';
include_once __DIR__ . '/Controller/GameController.php';
include_once __DIR__ . '/Repository/GameRepository.php';
include_once __DIR__ . '/Repository/UserRepository.php';
include_once __DIR__ . '/Controller/UserController.php';

$config = [
    'gamesFileName' => __DIR__ . '/games.json',
    'usersFileName' => __DIR__ . '/users.json',
];
$gameRepository = new GameRepository($config['gamesFileName']);
$gameController = new GameController($gameRepository);
$userRepository = new UserRepository($config['usersFileName']);
$userController = new UserController($userRepository);
$jwt = null;

if (isset($jwt))
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo $gameController->addGame();
    } else {
        echo $gameController->getGames();
    }
}

echo $userController->login();
