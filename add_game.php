<?php
if (isset($_POST['button'])) {
	$myDeck = $_POST['myDeck'];
	$opponentsDeck = $_POST['opponentsDeck'];
	$didWin = $_POST['didWin'];

	echo 'Your Deck: ' . $myDeck . '<br>';
	echo 'Opponent\'s Deck' .  $opponentsDeck . '<br>';
	echo 'Did you win? ' .  $didWin;
}
?>
