<?php

include_once __DIR__ . '/../Template/MainTemplate.php';
include_once __DIR__ . '/../Repository/GameRepository.php';

class GameController
{
    private MainTemplate $template;
    public function __construct(
        protected readonly GameRepository $gameRepository,
        protected readonly string $baseUrl
    ) {
        $this->template = new MainTemplate();
    }
    
    public function addGame(): void
    {
        if (isset($_POST['addGame'])
        ) {
            $postData = $this->getPostData();
            
            // just store user that creates the game
            $this->gameRepository->addGame(
                $postData['myDeck'],
                $postData['opponentsDeck'],
                $postData['didWin'],
            );
        }
        
        header("Location: " . $this->baseUrl . 'games');
        exit;
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
