<?php

    include("config.php");
    
    $txn_id = $_POST['txn_id'];
    $product_id = $_POST['product_id'];
    
    if ( $_POST['download'] && $txn_id && $product_id ) {
        $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
        if ($mysqli->connect_errno) {
            error_log("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
        }
        
        $fetch = $mysqli->query("SELECT * FROM tokens t INNER JOIN products p ON t.productID=p.productID WHERE p.productID=$product_id AND t.txnID='$txn_id' AND t.elapseDT <= DATE_ADD(NOW(), INTERVAL 14 DAY)");
        
        if ( $fetch->num_rows == 1 ) {
            $r = mysqli_fetch_assoc($fetch);
            $mysqli->query("UPDATE tokens SET downloads=downloads+1 WHERE productID='$product_id' AND txnID='$txn_id'");
            
            //echo $r["downloadURL"];
            
            /*file_put_contents("test.mp3", fopen($r["downloadURL"], 'r'));
            
            header("Content-Type: application/force-download");
            header("Content-Type: application/octet-stream");
            header("Content-Type: application/download");
            header("Content-Disposition: attachment;filename=/test.mp3");
            header("Content-Transfer-Encoding: binary ");*/
            
            
            
            set_time_limit(0); // unlimited max execution time
            $options = array(
              CURLOPT_TIMEOUT =>  28800, // set this to 8 hours so we dont timeout on big files
              CURLOPT_URL     => $r["downloadURL"],
            );

            $ch = curl_init();
            curl_setopt_array($ch, $options);
            curl_exec($ch);
            curl_close($ch);
            
            //file_put_contents("Tmpfile.mp3", $r["downloadURL"]);
        }
    }
?>