<?php

    /*
        https://developer.paypal.com/docs/classic/ipn/ht_ipn/
        https://gist.github.com/xcommerce-gists/3440401#file-completelistener-php        
    */
    

    include("config.php");
    
    
    //$paypalURL = 'https://www.paypal.com/cgi-bin/webscr';
    $paypalURL = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
    
    
    // STEP 1: read POST data

    // Reading POSTed data directly from $_POST causes serialization issues with array data in the POST.
    // Instead, read raw POST data from the input stream. 
    $raw_post_data = file_get_contents('php://input');
    $raw_post_array = explode('&', $raw_post_data);
    $myPost = array();
    foreach ($raw_post_array as $keyval) {
      $keyval = explode ('=', $keyval);
      if (count($keyval) == 2)
         $myPost[$keyval[0]] = urldecode($keyval[1]);
    }
    // read the IPN message sent from PayPal and prepend 'cmd=_notify-validate'
    $req = 'cmd=_notify-validate';
    if(function_exists('get_magic_quotes_gpc')) {
       $get_magic_quotes_exists = true;
    } 
    foreach ($myPost as $key => $value) {        
       if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) { 
            $value = urlencode(stripslashes($value)); 
       } else {
            $value = urlencode($value);
       }
       $req .= "&$key=$value";
    }

     
    // STEP 2: POST IPN data back to PayPal to validate

    $ch = curl_init($paypalURL);
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

    // In wamp-like environments that do not come bundled with root authority certificates,
    // please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set 
    // the directory path of the certificate as shown below:
    curl_setopt($ch, CURLOPT_CAINFO, 'cacert.pem');
    if( !($res = curl_exec($ch)) ) {
        error_log("Got " . curl_error($ch) . " when processing IPN data");
        curl_close($ch);
        exit;
    }
    curl_close($ch);
     

    // STEP 3: Inspect IPN validation result and act accordingly

    if (strcmp ($res, "VERIFIED") == 0) {
        // The IPN is verified, process it:
        // check whether the payment_status is Completed
        // check that txn_id has not been previously processed
        // check that receiver_email is your Primary PayPal email
        // check that payment_amount/payment_currency are correct
        // process the notification

        // assign posted variables to local variables
        $item_name = $_POST['item_name'];
        $item_number = $_POST['item_number'];
        $payment_status = $_POST['payment_status'];
        $payment_amount = $_POST['mc_gross'];
        $payment_currency = $_POST['mc_currency'];
        $txn_id = $_POST['txn_id'];
        $receiver_email = $_POST['receiver_email'];
        $payer_email = $_POST['payer_email'];

        $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
        if ($mysqli->connect_errno) {
            echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }

        $qResult = $mysqli->query("SELECT * FROM tokens WHERE txnID='$txn_id';");
        
        if ( $qResult->num_rows == 0 ) {
            $cIdx = 1;
            // IPN message values depend upon the type of notification sent.
            // To loop through the &_POST array and print the NV pairs to the screen:
            foreach($_POST as $key => $value) {
                //echo $key." = ". $value."<br>";
                if ( $key == "item_name".$cIdx ) {
                    $rResult = $mysqli->query("INSERT INTO tokens(productID, createDT, elapseDT, downloads, txnID) VALUES($value, NOW(), DATE_ADD(NOW(), INTERVAL 14 DAY), 0, '$txn_id');");
                }
            } 
        }
        
    } 
    else if (strcmp ($res, "INVALID") == 0) {
        // IPN invalid, log for manual investigation
        echo "The response from IPN was: <b>" .$res ."</b>";
    }

?>