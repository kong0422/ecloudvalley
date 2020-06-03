<?php
    $dbhost = 'database-1.ciiureknen9u.ap-northeast-2.rds.amazonaws.com';
    $dbuser = 'admin';
    $dbpass = 'kanxuutt00';
    $dbname = 'ecloudvalley';
    // if ($_SERVER['HTTP_HOST'] == 'localhost') {
    //     $dbhost = 'localhost';
    //     $dbuser = 'root';
    //     $dbpass = 'q1w2e3r4';
    //     $dbname = 'ecloudvalley';
    // }

    $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
    if ($mysqli->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        exit();
    }
    $mysqli->set_charset("utf8");
?>
