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
$env = parse_ini_file('.env');
$baseUrl = $env['BASE_URL'];

$gameRepository = new GameRepository($config['gamesFileName']);
$gameController = new GameController($gameRepository);
$userRepository = new UserRepository($config['usersFileName']);
$authService = new AuthenticationService($userRepository, $baseUrl);
$authController = new AuthenticationController($userRepository, $authService, $baseUrl);

$requestUri = mb_substr($_SERVER['REQUEST_URI'], 1);

if ($requestUri === 'login') {
     if ($authService->isAuthenticated()) {
        header("Location: " . $baseUrl . 'games');
        exit;
     }

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        echo $authController->renderLogin();
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $authController->login();
    }
}
if ($requestUri === 'signup') {
    if ($authService->isAuthenticated()) {
        header("Location: " . $baseUrl . 'games');
        exit;
    }
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        echo $authController->renderSignup();
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $authController->signup();
    }
}
//if (!$authService->isAuthenticated()) {
//    header("Location: " . $baseUrl . 'login');
//    exit;
//} else {
    if ($requestUri === 'signout') {
        $authController->signout();
    }
    if ($requestUri === 'addGame') {
        $gameController->addGame();
        header("Location: " . $baseUrl . 'games');
        exit;
    }
    if ($requestUri === 'games') {
        echo $authController->renderSignoutButton();
        echo $gameController->getGames();
    }
//}
