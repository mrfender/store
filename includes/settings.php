<?php

    # Bestand       settings.php
    # Omschrijving: dit bestand bevat standaard settings voor de website
    # Auteur:       Jan Hoekstra
    # Datum:        09-10-2011
    # Versie:       2.0.0


    // CONSTANTES
    // versie
    define("VERSION",         "versie 1.0.0 - 22 juli 2015");

    // html-settings
    define("HTMLTITLE",       "JoY Project");
    define("HTMLDESCRIPTION", "");
    define("HTMLKEYWORDS",    "");
    define("HTMLAUTHOR",      "JH &copy; 2015.");
    define("HTMLPUBLISHER",   "JoY Project");
    define("HTMLCOPYRIGHT",   "&copy; 2015 JoY Project");
    define("HTMLFAVICON",     "animated_favicon.gif");

    // session
    define("BASE_SESSION",      "_JoY");
    define("BASE_SITEID",       0);

    // diverse:
    define("BULLET",            "&bull;");
    define("MENU_SEPERATOR",    "");

    // text-editor 
    //define("EDITOR_SCRIPT",     "includes/ckeditor_3.6.2.php");

    // images:
    /*define("FILE_IMAGES_DIR",   "./images/files/");
    define("MENU_IMAGES_DIR",   "./images/layout/menu/");
    define("IMAGES_DIR",        "./images/layout/");
    define("ICONS_DIR",         "./images/icons/big/");*/

    // uploads:
    /*define("UPLOADDIR",         "uploads");
    define("THUMBDIR",          "thumbs");
    define("THUMBPREFIX",       "tn_");*/

        // email:
    define("MAIL_NAME",                 HTMLTITLE);
    define("MAIL_ADMIN",                "mrfender@gmail.com");
    define("MAIL_INFO",                 "mrfender@gmail.com");

?>