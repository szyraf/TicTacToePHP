<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <title>Tic tac toe</title>
        <script src="js.js" defer></script>
    </head>
    
    <body>
        <h1>Tic tac toe</h1>
        <br><br><br><br><br>
        <span id="wybierzGracza">Wybierz gracza: <div onclick="xSelected()">X</div> <div onclick="oSelected()">O</div></span>
        <p id="wybrano"></p>
        <p id="ruch"></p>
        <p id="wygrana"></p>

        <br><br>
        <div class="plansza">
            <?php
                for ($i = 0; $i < 9; $i++) {
                    $style = '';
                    if ($i < 3)      $style .= 'border-top: none;';
                    if ($i % 3 == 0) $style .= 'border-left: none;';
                    if ($i % 3 == 2) $style .= 'border-right: none;';
                    if ($i > 5)      $style .= 'border-bottom: none;';

                    echo '<div onclick="boardClick(' . strval($i) . ')" class="pole" style="' . $style . '" id="' . strval($i) . '"></div>';
                }
            ?>
        </div>
    </body>
</html>