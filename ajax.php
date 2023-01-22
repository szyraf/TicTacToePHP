<?php
    // in server / memcache:

    // TODO: get game board and which turn from memcache

    // 0 - nothing, 1 - x, 2 - o
    $gameBoard = [[0, 0, 0], [0, 0, 0], [0, 0, 0]];
    $whichTurn = 'x'; // x / o


    if (isset($_POST['reload'])) {
        if ($_POST['reload'] == '1') {
            if (isset($_POST['idkwhoiam'])) {
                if ($_POST['idkwhoiam'] == '0') {
                    
                }
            }
            $_POST['gameBoard'] = $gameBoard;
        }
    }
    else if (isset($_POST['move'])) {
        $move = intval($_POST['move']);


    }
    else if (isset($_POST['side'])) {
        $side = $_POST['side'];

        // TODO: check if player is set already

        // TODO: generate secret
        $_POST['secret'] = 'abc';
    }


    echo json_encode($_POST); // json_decode
?>