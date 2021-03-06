<?php

    include("includes/functions.php");
    include("config.php");
    
    $txn_id = getPOSTGETvar('txn_id');
    $product_id = getPOSTGETvar('product_id');
    
    if ( $txn_id && $product_id ) {
        $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
        if ($mysqli->connect_errno) {
            error_log("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
        }
        
        $fetch = $mysqli->query("SELECT * FROM tokens t INNER JOIN products p ON t.productID=p.productID WHERE p.productID=$product_id AND t.txnID='$txn_id' AND t.elapseDT > NOW()");
        
        if ( $fetch->num_rows == 1 ) {
            $r = mysqli_fetch_assoc($fetch);
            $mysqli->query("UPDATE tokens SET downloads=downloads+1 WHERE productID='$product_id' AND txnID='$txn_id'");
            
            $fileURL = $r["downloadURL"];
            header("location: $fileURL");
        }
    }
?>