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
    'newUser' => false,
];
$gameRepository = new GameRepository($config['gamesFileName']);
$gameController = new GameController($gameRepository);
$userRepository = new UserRepository($config['usersFileName']);
$authController = new AuthenticationController($userRepository);
// use a secure cookie for storing the jwt when you log in there's a set cookie option and then the browser sees it
// and stores the cookie
// every request after will have the cookie attached to it
$authenticated = $authController->isAuthenticated($config['loggedIn']);
echo '<p>' . json_encode(['Cookie' => $_COOKIE['jwt']]) . '</p>';
echo '<p>' . json_encode(['Authenticated' => $authenticated]) . '</p>';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['signup'])) {
        $config['newUser'] = !$authController->signup();
        $config['loggedIn'] = isset($_COOKIE['jwt']);
        $authenticated = $authController->isAuthenticated($config['loggedIn']);
        if ($authenticated) {
            echo $gameController->getGames();
        }
    }
    if (isset($_POST['login'])) {
        $loggedIn = $authController->login();
        $config['loggedIn'] = isset($_COOKIE['jwt']);
        $config['newUser'] = !$loggedIn;
        $authenticated = $authController->isAuthenticated($config['loggedIn']);
        if ($authenticated) {
            echo $gameController->getGames();
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

if ($authenticated && $_SERVER['REQUEST_METHOD'] !== 'POST')
{
    echo $authController->renderSignoutButton();
    echo $gameController->getGames();
}



