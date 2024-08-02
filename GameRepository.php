<?php

class GameRepository
{
    public function __construct(string $fileName) {
        if (!file_exists($fileName)) {
            throw new RuntimeException('File doesn\'t exist');
        }
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
        $games = $this->getGames();
        $games[] = $game;
        file_put_contents($this->fileName, $games);
    }
    public function getGames(): array
    {
        $fileName = __DIR__ . '/games.json';
        $json = file_get_contents($fileName);
        
        return json_decode($json);
    }
}
