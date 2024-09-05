<?php

include_once __DIR__ . '/Template/MainTemplate.php';
include_once __DIR__ . '/Controller/GameController.php';
include_once __DIR__ . '/Repository/GameRepository.php';
include_once __DIR__ . '/Repository/UserRepository.php';
include_once __DIR__ . '/Controller/AuthenticationController.php';
include_once __DIR__ . '/Service/AuthenticationService.php';

$config = [
    'gamesFileName' => __DIR__ . '/games.json',
    'usersFileName' => __DIR__ . '/users.json',
    'loggedIn' => isset($_COOKIE['jwt']),
];
$gameRepository = new GameRepository($config['gamesFileName']);
$gameController = new GameController($gameRepository);
$userRepository = new UserRepository($config['usersFileName']);
$authController = new AuthenticationController($userRepository);
// use a secure cookie for storing the jwt when you log in there's a set cookie option and then the browser sees it
// and stores the cookie
// every request after will have the cookie attached to it
if (!$authController->isAuthenticated($config['loggedIn'])) {
    echo $authController->renderLogin();

    $config['loggedIn'] = $authController->login();
    if (!$config['loggedIn']) {
        echo $authController->renderSignup();
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo $gameController->addGame();
    } else {
        echo $gameController->getGames();
    }



