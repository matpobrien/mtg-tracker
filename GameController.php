<?php

include_once __DIR__ . '/Templates/MainTemplate.php';
include_once __DIR__ . '/GameRepository.php';

class GameController
{
    private MainTemplate $template;
    public function __construct(
        protected readonly GameRepository $gameRepository,
    ) {
        $this->template = new MainTemplate();
    }
    
    public function addGame(): string
    {
        if (isset($_POST['button'])
        ) {
            $fileName = $_SERVER['DOCUMENT_ROOT'] . '/games.json';
            
            file_put_contents($fileName, $this->getPostData($fileName));
        }
        
        return $this->getGames();
    }
    
    public function getGames(): string
    {
        return $this->template->render(
            $this->gameRepository->getGames()
        );
    }
    
    private function getPostData($fileName): bool | string
    {
        $myDeck = htmlspecialchars($_POST['myDeck']);
        $opponentsDeck = htmlspecialchars($_POST['opponentsDeck']);
        $didWin = $_POST['didWin'];
        
        if ('' === $myDeck || '' === $opponentsDeck) {
            echo 'Invalid data!';
        }
        
        $game = [
                'myDeck' => $myDeck,
                'opponentsDeck' => $opponentsDeck,
                'didWin' => $didWin,
                'createdAt' => (new DateTime())->format('c'),
        ];
        
        $games = [];

        if (file_exists($fileName)) {
            $oldJson = file_get_contents($fileName);
            $games = json_decode($oldJson);
        }

        $games[] = $game;
        
        return json_encode($games);
    }
}
