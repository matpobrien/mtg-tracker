<?php

class GameController
{
    public function __construct() {}
    
    public function addGame(): void
    {
        
        if (isset($_POST['button'])
        ) {
            $fileName = $_SERVER['DOCUMENT_ROOT'] . '/games.json';
            
            file_put_contents($fileName, $this->getPostData($fileName));
        }
    }
    
    public function getGames()
    {
        $fileName = $_SERVER['DOCUMENT_ROOT'] . '/games.json';
        $json = file_get_contents($fileName);
        
        return json_decode($json);
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
