<?php

    echo "<br><Br>POST:";
    print_r("$_POST");
    
    echo "<br><Br>GET:";
    print_r("$_GET");
    
    echo "<br><Br>SESSION:";
    print_r("$_SESSION");
    
    
    // connect
    $m = new MongoClient();
    
    // select a database
    $db = $m->store;
    
    // select a collection (analogous to a relational database's table)
    $collection = $db->files;
    
    // add a record
    $document = array( "filename" => "Yldau - Fjoer.mp3", "location" => "downloads\\" );
    $collection->insert($document);

    // add another record, with a different "shape"
    $document = array( "filename" => "JoY-project - Hold on.mp3", "location" => "downloads\\" );
    $collection->insert($document);

    // find everything in the collection
    $cursor = $collection->find();

    // iterate through the results
    foreach ($cursor as $document) {
        echo $document["filename"] . "\n";
    }

?>