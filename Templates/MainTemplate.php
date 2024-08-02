<?php

class MainTemplate {
    private array $games = [];
    public function __construct(array $games) {
        $this->games = $games;
    }

    private static function renderTable(array $games): string {
        $rows = [];
        
        foreach ($games as $game) {
            foreach ($game as $key => $value) {
                if (!in_array($key, $rows)) {
                    $rows[] = $key;
                }
            }
        }
        
        $html = '<table>';
        foreach ($rows as $row) {
            $html .= '<th>' .
            ucwords(
                implode(
                    ' ',
                    preg_split('/(?=[A-Z])/', $row)
                )
            )
            . '</th>';
        }
        
        foreach ($games as $game) {
            $html .= '<tr id="row">';
            
            foreach ($game as $key => $value) {
                $html .= '<td>' . $value . '</td>';
            }
            $html .= '</tr>';
        }
        $html .= '</table>';
        
        return $html;
    }
    
    public function render(array $games)
    {
        echo <<<HTML
            <html lang=''>
                <head>
                    <style>
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
                    <title>MTG Tracker</title>
                </head>
                <body>
                <h1>Add a game</h1>
                <form action='GameController.php' method='post'>
                    <table>
                        <tr>
                            <td>
                                <label>Your Deck Name:
                                    <input required type='text' name='myDeck'/>
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Opponent's Deck Name:
                                    <input required type='text' name='opponentsDeck'/>
                                </label>
                            </td>
                        </tr>
                        <tr><td>
                                <label>Did You Win?
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>
                                    Yes
                                    <input required type='radio' name='didWin' value='true' />
                                </label>
                                <label>
                                    No
                                    <input required type='radio' name='didWin' value='false' />
                                </label>
                            </td>
                        </tr>
                        <tr><td><input name='button' type='submit' value='Add Game' formmethod='post'/></td></tr>
                    </table>
                </form>
                <h1> Previous Games</h1>
                    { self::renderTable($this->games) }
                </body>
            </html>
        HTML;
    }
}
