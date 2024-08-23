<?php

include_once __DIR__ . '/Template/MainTemplate.php';
include_once __DIR__ . '/Repository/GameRepository.php';

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
            $postData = $this->getPostData();
            
            // just store user that creates the game
            $this->gameRepository->addGame(
                $postData['myDeck'],
                $postData['opponentsDeck'],
                $postData['didWin'],
            );
        }
        
        return $this->getGames();
    }
    
    public function getGames(): string
    {
        return $this->template->render(
            $this->gameRepository->getGames()
        );
    }
    
    private function getPostData(): array
    {
        $myDeck = htmlspecialchars($_POST['myDeck']);
        $opponentsDeck = htmlspecialchars($_POST['opponentsDeck']);
        $didWin = $_POST['didWin'];
        
        if ('' === $myDeck || '' === $opponentsDeck) {
            echo 'Invalid data!';
        }
        
        return [
                'myDeck' => $myDeck,
                'opponentsDeck' => $opponentsDeck,
                'didWin' => $didWin,
                'createdAt' => (new DateTime())->format('c'),
        ];
    }
}
