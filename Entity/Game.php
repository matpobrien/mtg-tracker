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
    
    public function setDidWin(bool $didWin): self
    {
        $this->didWin = $didWin;
        
        return $this;
    }
    
    public function isDidWin(): bool
    {
        return $this->didWin;
    }
    
    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;
        
        return $this;
    }
    
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }
    
    public function toArray(): array
    {
        return [
            'myDeck' => $this->getMyDeck(),
            'opponentsDeck' => $this->getOpponentsDeck(),
            'didWin' => $this->isDidWin(),
            'createdAt' => $this->getCreatedAt()->format('c')
        ];
    }
}
