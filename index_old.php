<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['button'])) {
    $fileName = $_SERVER['DOCUMENT_ROOT'] . '/games.json';
    
    function getData($fileName) {
        
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
    
    file_put_contents($fileName, getData($fileName));
}
?>
<html>
<head>
    <style type="text/css">
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        #row:nth-child(even) {
            background-color: #D6EEEE;
        }

        td {
            padding-right: 2rem;
        }
    </style>
</head>
<body>
<h1>Add a game</h1>
<form action='add_game.php' method='post'>
    <table>
        <tr><td><label>Your Deck Name: </label><input required type='text' name='myDeck'/></td></tr>
        <tr><td><label>Opponent's Deck Name: </label><input required type='text' name='opponentsDeck'/></td></tr>
        <tr><td><label>Did You Win?</label></tr></td>
        <tr>
            <td>
                Yes <input required type='radio' name='didWin' value='true' />
                No <input required type='radio' name='didWin' value='false' />
            </td>
        </tr>
        <tr><td><input name='button' type='submit' value='Add Game' formmethod='post'/></td></tr>
    </table>
</form>
<h1> Previous Games</h1>
<?php
$fileName = $_SERVER['DOCUMENT_ROOT'] . '/games.json';
$json = file_get_contents($fileName);
$games = json_decode($json);

$rows = [];
foreach ($games as $game) {
    foreach ($game as $key => $value) {
        if (!in_array($key, $rows)) {
            $rows[] = $key;
        }
    }
}

echo '<table>';
foreach ($rows as $row) {
    echo '<th>' .
        ucwords(
            implode(
                ' ',
                preg_split('/(?=[A-Z])/', $row)
            )
        )
        . '</th>';
    
    
}
foreach ($games as $game) {
    echo '<tr id="row">';
    foreach ($game as $key => $value) {
        echo '<td>' . $value  . '</td>';
    }
    echo '</tr>';
}
echo '</table>';
?>
</body>
</html>
