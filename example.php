<?php
    // $port = 11211; // windows
    $port = 3010;  // linux
    $memcache = memcache_connect('localhost', $port);

    if ($memcache) {
        $memcache->set("str_key", "String to store in memcached");
        $memcache->set("num_key", 123);

        $object = new StdClass;
        $object->attribute = 'test';
        $memcache->set("obj_key", $object);

        $array = Array('assoc'=>123, 345, 567);
        $memcache->set("arr_key", $array);

        var_dump($memcache->get('str_key'));
        echo '<br>';
        var_dump($memcache->get('num_key'));
        echo '<br>';
        var_dump($memcache->get('obj_key'));
    }
    else {
        echo "Connection to memcached failed";
    }
?>