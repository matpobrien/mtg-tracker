<?php

class GameRepository
{
    public function getGames(): array
    {
        $fileName = __DIR__ . '/games.json';
        $json = file_get_contents($fileName);
        
        return json_decode($json);
    }
}
