<?php

    include("config.php");

    $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }
    
    $fetch = $mysqli->query("SELECT productID, identifier, artist, title, price, listenURL AS soundcloudURL FROM products");
    
    $rows = array();
    while($r = mysqli_fetch_assoc($fetch)) {
        $rows[] = $r;
    }

    print json_encode($rows);
    
?>