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
    'newUser' => false,
];
$gameRepository = new GameRepository($config['gamesFileName']);
$gameController = new GameController($gameRepository);
$userRepository = new UserRepository($config['usersFileName']);
$authService = new AuthenticationService($userRepository);
$authController = new AuthenticationController($userRepository, $authService);


if (!$authService->isAuthenticated()) {
    http_redirect('/login');
}
if ($_SERVER['REQUEST_URI'] === 'login') {
     if ($authService->isAuthenticated()) {
        http_redirect('/games');
     }

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        echo $authController->renderLogin();
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $authController->login();
    }
}
if ($_SERVER['REQUEST_URI'] === 'signup') {
    if ($authService->isAuthenticated()) {
        http_redirect('/games');
    }
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        echo $authController->renderSignup();
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $authController->signup();
    }
}
if ($authService->isAuthenticated()) {
    if ($_SERVER['REQUEST_URI'] === 'signout') {
        $authController->signout();
    }
    if ($_SERVER['REQUEST_URI'] === 'addGame') {
        $gameController->addGame();
    }
    if ($_SERVER['REQUEST_URI'] === 'games') {
        echo $authController->renderSignoutButton();
        echo $gameController->getGames();
    }
}
