<!DOCTYPE html>
<html>
    <head>
        <!--<meta charset="UTF-8">-->
        <title>Webshop</title>
        <link rel="stylesheet" href="css/bootstrap.min.css" />
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script>
            
        </script>
    </head>    
    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top">
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="#">Joy-Project - Webshop</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
              <form class="navbar-form navbar-right">
                <!--<div class="form-group">
                  <input type="text" placeholder="Email" class="form-control">
                </div>
                <div class="form-group">
                  <input type="password" placeholder="Password" class="form-control">
                </div>
                <button type="submit" class="btn btn-success">Sign in</button>-->
              </form>
            </div><!--/.navbar-collapse -->
          </div>
        </nav>
        
        <div class="container">
          <!-- Example row of columns -->
          <div class="row">
<?php

    include("config.php");
    
    if ( $txn_id = $_POST['txn_id'] ) {
        $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
        if ($mysqli->connect_errno) {
            error_log("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
        }
        
        $fetch = $mysqli->query("SELECT * FROM tokens WHERE txnID='$txn_id' AND elapseDT <= DATE_ADD(NOW(), INTERVAL 14 DAY)");
        
        if ( $fetch->num_rows >= 1 ) {
            while($r = mysqli_fetch_assoc($fetch)) {
              echo "<div class='col-md-4'>";
              echo "<h2 class='item_name'>$r->artist - $r->title</h2>";
              echo "<p><form name='downloadForm' action='download_action.php' target_blank>";
              echo "<input type='hidden' name='tnx_id' value='$txn_id'>";
              echo "<input type='hidden' name='product_id' value='$r->productID'>";
              echo "<input type='submit' class='btn btn-primary' name='download' value='Download'><form></p>";
              echo "</div>";
            }
        }
    }

?>
          </div>

          <hr>

          <footer>
            <p>&copy; JHYH 2015</p>
          </footer>
        </div> <!-- /container -->
    </body>
</html>