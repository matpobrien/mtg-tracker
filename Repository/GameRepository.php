<?php

include __DIR__ . '/Entity/Game.php';

class GameRepository
{
    private string $fileName;
    public function __construct(string $fileName) {
        if (!file_exists($fileName)) {
            throw new RuntimeException('File doesn\'t exist');
        }
        
        $this->fileName = $fileName;
    }
    
    public function addGame(
        string $myDeck,
        string $opponentsDeck,
        bool $didWin,
    ): void
    {
        $game = [
            'myDeck' => $myDeck,
            'opponentsDeck' => $opponentsDeck,
            'didWin' => $didWin,
            'createdAt' => (new DateTime())->format('c'),
        ];
        
//        $game = (new Game())
//            ->setMyDeck($myDeck)
//            ->setOpponentsDeck($opponentsDeck)
//            ->setDidWin($didWin)
//            ->setCreatedAt((new DateTime())->format('c'));
        $games = $this->getGames();
        $games[] = $game;
        file_put_contents($this->fileName, json_encode($games));
    }
    public function getGames(): array
    {
        $json = file_get_contents($this->fileName);
        
        return json_decode($json);
    }
}
