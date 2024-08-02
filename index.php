<html lang="">
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
    <title>MTG Tracker</title>
</head>
<body>
<h1>Add a game</h1>
<form action='PostController.php' method='post'>
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
<?php
    include_once __DIR__ . '/GetController.php';
?>
</body>
</html>
