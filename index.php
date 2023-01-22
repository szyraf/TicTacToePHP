<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <title>Document</title>
    </head>
    
    <body>
        <h1>Tic tac toe</h1>
        <br><br>
        <div >
            <p>Wybierz gracza: O / X</p>
            <p>Wybrałeś: O / X</p>
            <p>Twój ruch / Ruch przeciwnika</p>
            <p>Wygrało O / X</p>
        </div>
        <br><br>
        <div class="plansza">
            <?php
                for ($i = 0; $i < 9; $i++) {
                    $style = '';
                    if ($i < 3)      $style .= 'border-top: none;';
                    if ($i % 3 == 0) $style .= 'border-left: none;';
                    if ($i % 3 == 2) $style .= 'border-right: none;';
                    if ($i > 5)      $style .= 'border-bottom: none;';

                    echo '<div onclick="klik(' . strval($i) . ')" class="pole" style="' . $style . '" id="' . strval($i) . '"></div>';
                }
            ?>
        </div>

        <script>
            function klik(id) {
                console.log(id)
                sendMove(id)
            }

            function sendMove(id) {
                var xhttp = new XMLHttpRequest()
                xhttp.open('POST', 'ajax.php', true)
    
                xhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        let json = JSON.parse(this.responseText)
                        console.log(json)
                    }
                };
    
                xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded')
                xhttp.send(`move=${id}`)
            }

            function pickSide(side) {
                var xhttp = new XMLHttpRequest()
                xhttp.open('POST', 'ajax.php', true)
    
                xhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        let json = JSON.parse(this.responseText)
                        console.log(json)
                    }
                };
    
                xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded')
                xhttp.send(`side=${side}`)
            }
    
            setInterval(() => {
                getData()
            }, 1000);

            function getData() {
                var xhttp = new XMLHttpRequest()
                xhttp.open('POST', 'ajax.php', true)
    
                xhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        let json = JSON.parse(this.responseText)
                        console.log(json)
                        // TODO: 
                    }
                };
    
                xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded')
                xhttp.send(`reload=1&idkwhoiam=1`)
            }

            window.addEventListener('DOMContentLoaded', (event) => {
                //send();
            });
        </script>
    </body>
</html>