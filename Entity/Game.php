<?php

class Game
{
    private string $myDeck;
    private string $opponentsDeck;
    private bool $didWin;
    private DateTime $createdAt;
    
    public function setMyDeck(string $myDeck): self
    {
        $this->myDeck = $myDeck;
        
        return $this;
    }
    
    public function getMyDeck(): string
    {
        return $this->myDeck;
    }
    
    public function setOpponentsDeck(string $opponentsDeck): self
    {
        $this->opponentsDeck = $opponentsDeck;
        
        return $this;
    }
    
    public function getOpponentsDeck(): string
    {
        return $this->opponentsDeck;
    }
    
    public function setDidWin(DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;
        
        return $this;
    }
    
    public function getDidWin(): DateTime
    {
        return $this->createdAt;
    }
    
    
}
