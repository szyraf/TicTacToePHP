<?php
    function server() : int {
        include('hidden.php');

        $memcache = new Memcache;
        $memcache->connect('localhost', $PORT);
        
        if (!$memcache) {
            $_POST['error'] = 'memcache connection failed';
            return 0;    
        }
        
        if ($memcache->get('init') == false) {
            $memcache->set('init', 'yes');
            $memcache->set('gameBoard', [[0, 0, 0], [0, 0, 0], [0, 0, 0]]);
            $memcache->set('playerOne', '');
            $memcache->set('whichTurn', '');
            $memcache->set('winner', '');
        }
        
        $gameBoard = $memcache->get('gameBoard');
        $playerOne = $memcache->get('playerOne');
        $whichTurn = $memcache->get('whichTurn');

        if (isset($_POST['reload'])) {
            $memcache->set('init', false);
        } else if (isset($_POST['getdata'])) {
            if ($_POST['idkwhoiam'] == '1' && $playerOne != '') {
                $_POST['yourSide'] = $playerOne == 'x' ? 'o' : 'x';
            }
            else if ($_POST['idkwhoiam'] == '0' && $playerOne == '') {
                $_POST['reloadPage'] = 'yes';
            }
            
            if ($memcache->get('winner') != '') {
                $_POST['winner'] = $memcache->get('winner');
            }
            $_POST['whichTurn'] = $whichTurn;

            $_POST['gameBoard'] = $gameBoard;
        } else if (isset($_POST['move'])) {
            $move = intval($_POST['move']);
            $player = $_POST['player'];

            if ($player == $whichTurn) {
                $x = $move % 3;
                $y = floor($move / 3);

                if ($gameBoard[$y][$x] == 0 && $memcache->get('winner') == '') {
                    $gameBoard[$y][$x] = $player == 'x' ? 1 : 2;
                    $memcache->set('gameBoard', $gameBoard);

                    $whichTurn = $whichTurn == 'x' ? 'o' : 'x';
                    $memcache->set('whichTurn', $whichTurn);

                    $_POST['gameBoard'] = $gameBoard;

                    $win = false;
                    for ($i = 0; $i < 3; $i++) {
                        if ($gameBoard[$i][0] == $gameBoard[$i][1] && $gameBoard[$i][1] == $gameBoard[$i][2] && $gameBoard[$i][0] != 0) {
                            $win = true;
                            break;
                        }
                        if ($gameBoard[0][$i] == $gameBoard[1][$i] && $gameBoard[1][$i] == $gameBoard[2][$i] && $gameBoard[0][$i] != 0) {
                            $win = true;
                            break;
                        }
                    }
                    if ($gameBoard[0][0] == $gameBoard[1][1] && $gameBoard[1][1] == $gameBoard[2][2] && $gameBoard[0][0] != 0) {
                        $win = true;
                    }
                    if ($gameBoard[0][2] == $gameBoard[1][1] && $gameBoard[1][1] == $gameBoard[2][0] && $gameBoard[0][2] != 0) {
                        $win = true;
                    }

                    if (!$win) {
                        $draw = true;
                        for ($i = 0; $i < 3; $i++) {
                            for ($j = 0; $j < 3; $j++) {
                                if ($gameBoard[$i][$j] == 0) {
                                    $draw = false;
                                    break;
                                }
                            }
                        }
                        if ($draw) {
                            $win = true;
                            $player = 'draw';
                        }
                    }

                    if ($win) {
                        $_POST['winner'] = $player;
                        $memcache->set('winner', $player);
                    }
                }
            }

        } else if (isset($_POST['pickSide'])) {
            $side = $_POST['pickSide'];

            if ($playerOne == '') {
                $memcache->set('playerOne', $side);
                $memcache->set('whichTurn', $side);
                $_POST['yourSide'] = $side;
            }
        } else {
            $_POST['error'] = 'unknown request';
        }

        return 0;
    }

    $res = server();
    
    echo json_encode($_POST);
?>