<?php

    # Bestand       message.php
    # Omschrijving: het tonen van berichten op het scherm
    # Auteur:       Jan Hoekstra
    # Datum:        17-10-2011
    # Versie:       1.2.0


    // includes
    require_once("session.php");
    require_once("html.php");
    require_once("functions.php");
    require_once("filter.php");


    function writeMessage() {
        if ( $msg = getS_Message() ) {
            HtmlStartDiv("msgDiv", $msg->msgCSS);
            HtmlStartTable(($msg->msgType ? $msg->msgType ."_" : ""). "message");
            WriteLine($msg->msg);
            HtmlEndTable();
            HtmlEndDiv();
            WriteJavaScript("$(document).ready(function(){
                                setTimeout(function(){
                                    $('#msgDiv').fadeOut('slow', function(){ 
                                        $('#msgDiv').remove(); 
                                    });
                                }, ". $msg->msgTime .");
                            });");
            clearS_Message();
        }
    }

    function GoToPage($page) {
        WriteJavaScript("window.location.href = '". $page ."';");
    }
    
    # showMessage
    # - Omschrijving: tonen van een bericht
    # - Parameter:    bericht, pagina, css
    function showMessage($msg, $page="", $css="") {
        if ( !$page ) $page = $_SERVER["REQUEST_URI"];
        setS_Message($msg, $css);
        GoToPage($page);
    }

    # showMessageExtra
    # - Omschrijving: tonen van een bericht (X aantal seconden)
    # - Parameter:    bericht, X aantal seconden (bij 0 seconden dan blijft het scherm staan), css, pagina
    function showMessageExtra($msg, $sec, $page="", $css="") {
        if ( $sec   ) $time = $sec;
        if ( !$page ) $page = $_SERVER["REQUEST_URI"];
        setS_Message($msg, $css, "", $time);
        GoToPage($page);
    }

    # showEMessage
    # - Omschrijving: tonen van een error-bericht
    # - Parameter:    bericht, css, pagina
    function showEMessage($msg, $page="", $css="") {
        if ( !$page ) $page = $_SERVER["REQUEST_URI"];
        setS_Message($msg, $css, "error");
        GoToPage($page);
    }

    # showEMessageExtra
    # - Omschrijving: tonen van een error-bericht (X aantal seconden)
    # - Parameter:    bericht, X aantal seconden (bij 0 seconden dan blijft het scherm staan), css, pagina
    function showEMessageExtra($msg, $sec, $page="", $css="") {
        if ( $sec   ) $time = $sec;
        if ( !$page ) $page = $_SERVER["REQUEST_URI"];
        setS_Message($msg, $css, "error", $time);
        GoToPage($page);
    }

    # showEMessageNoSelection
    # - Omschrijving: error-bericht voor als er geen selectie is gemaakt
    # - Parameter:    css en pagina
    function showEMessageNoSelection($page="", $css="") {
        showEMessage("geen selectie", $page, $css);
    }

    # showEMessageFieldsRequired
    # - Omschrijving: error-bericht voor als niet alles is ingevuld
    # - Parameter:    css en pagina
    function showEMessageFieldsRequired($page="", $css="") {
        showEMessage("niet alles ingevuld", $page, $css);
    }

    # showEMessageWrongDate
    # - Omschrijving: error-bericht voor als er een onjuiste datum is ingevuld
    # - Parameter:    css en pagina
    function showEMessageWrongDate($page="", $css="") {
        $msg  = "de ingevulde datum is onjuist!<br>";
        $msg .= "<i>notatie: ". date("d-m-Y") ."</i>";
        showEMessageExtra($msg, 10, $page, $css);
    }

    # showEMessageWrongDates
    # - Omschrijving: error-bericht voor als er een onjuiste datums zijn ingevuld
    # - Parameter:    css en pagina
    function showEMessageWrongDates($page="", $css="") {
        $msg  = "de ingevulde datums zijn onjuist!<br>";
        $msg .= "<i>notatie: ". date("d-m-Y") ."</i><br>";
        $msg .= "Of de eerste datum is groter dan de tweede datum!<br>"; 
        showEMessageExtra($msg, 10, $page, $css);
    }

    # showEMessageWrongDateTime
    # - Omschrijving: error-bericht voor als er een onjuiste datum / tijd is ingevuld
    # - Parameters:   css en pagina
    function showEMessageWrongDateTime($page="", $css="") {
        $msg  = "de ingevulde datum en/of tijd is onjuist!<br>";
        $msg .= "<i>notatie datum: ". date("d-m-Y") ."</i><br>";
        $msg .= "<i>notatie tijd: ". date("H:i") ."</i><br>";
        showEMessageExtra($msg, 10, $page, $css);
    }

    # showEMessageWrongYear
    # - Omschrijving: error-bericht voor als er een onjuiste jaar is ingevuld
    # - Parameter:    css en pagina
    function showEMessageWrongYear($page="", $css="") {
        $msg  = "het ingevulde jaar is onjuist!<br>";
        $msg .= "<i>notatie: ". date("d-m-Y") ."</i>";
        showEMessageExtra($msg, 10, $page, $css);
    }

    # showEMessageWrongYears
    # - Omschrijving: error-bericht voor als er een onjuiste jaren zijn ingevuld
    # - Parameter:    css en pagina
    function showEMessageWrongYears($page="", $css="") {
        $msg  = "de ingevulde jaren zijn onjuist!<br>";
        $msg .= "<i>notatie: ". date("Y") ."</i><br>";
        $msg .= "Of de eerste jaar is groter dan de tweede jaar!<br>"; 
        showEMessageExtra($msg, 10, $page, $css);
    }

?>