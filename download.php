<?php

    print_r($_POST);
    
    if ( $txn_id = $_POST['txn_id'] ) {
        $fetch = $mysqli->query("SELECT * FROM tokens WHERE txnID='$txn_id' AND elapseDT < DATE_ADD(NOW(), INTERVAL 14 DAY)");
        
        if ( $fetch->num_rows > 1 ) {
            echo "Products bought:<br><br>";
            while($product = mysqli_fetch_assoc($fetch)) {
                print_r($product);
                echo "<br><br>";
            }
        }
    }

?>