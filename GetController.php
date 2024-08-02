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
