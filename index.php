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
if (!$authenticated) {
    if ($config['newUser']) {
        echo $authController->renderSignup();
    } else {
        echo $authController->renderLogin();
    }
}
// if ($_SERVER['REQUEST_URI'] === 'login') {
//     if ($authenticatd) {
//        http_redirect('/games');
//     }
//    if (isset($_POST['login'])) {
//        // http response redirect during login
//        $loggedIn = $authController->login();
//        $config['newUser'] = !$loggedIn;
//        $authenticated = $authController->isAuthenticated(); // use service
//
//        if (!$loggedIn) {
//           http_redirect('/signup');
//        }
//
//        //redirect
//        http_redirect('/games');
//    }
//
// }
// if ($_SERVER['REQUEST_URI'] === 'signup') {
//    if ($authenticated) {
//        http_redirect('/games');
//    }
//    if (isset($_POST['signup'])) {
//        $signupSuccessful = !$authController->signup();
//        $config['newUser'] = !$signupSuccessful;
//        $authenticated = $authController->isAuthenticated();
//
//        if ($signupSuccessful) {
//            http_redirect('/login');
//        }
//    }
//}
// if ($_SERVER['REQUEST_URI'] === 'signout') {
//    if ($authenticated) {
//        $authController->signout();
//        $authenticated = $authController->isAuthenticated($config['loggedIn']);
//        http_redirect('/login');
//    }
//}
// if ($_SERVER['REQUEST_URI'] === 'addGame') {
//        $gameController->addGame();
//}
// if ($_SERVER['REQUEST_URI'] === 'games') {
//    if ($authenticated) {
//        echo $authController->renderSignoutButton();
//        echo $gameController->getGames();
//    }
//}





// tell nginx that independent of path in the request, always execute index.php (steal from taskboard)
