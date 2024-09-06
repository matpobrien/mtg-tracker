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

$authenticated = $authController->isAuthenticated();
// if ($_SERVER['REQUEST_URI']) {}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$authenticated) {
        if (isset($_POST['login'])) {
            // http response redirect during login
            $loggedIn = $authController->login();
            $config['newUser'] = !$loggedIn;
            $authenticated = $authController->isAuthenticated(); // use service
        }
        if (isset($_POST['signup'])) {
            $config['newUser'] = !$authController->signup();
            $authenticated = $authController->isAuthenticated();
        }
    }
 
    if ($authenticated) {
        if (isset($_POST['signout'])) {
            $authController->signout();
            $authenticated = $authController->isAuthenticated($config['loggedIn']);
        }
        if (isset($_POST['addGame'])) {
            echo $gameController->addGame();
        }
    }
}
if (!$authenticated) {
    if ($config['newUser']) {
        echo $authController->renderSignup();
    } else {
        echo $authController->renderLogin();
    }
}

if ($authenticated)
{
    echo $authController->renderSignoutButton();
    echo $gameController->getGames();
}



// tell nginx that independent of path in the request, always execute index.php (steal from taskboard)
