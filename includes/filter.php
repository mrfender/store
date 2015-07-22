<?php

    # Bestandsnaam : filter.php
    # Omschrijving : alle filteracties op strings worden hier uitgevoerd
    # Auteur       : Jan Hoekstra
    # Datum        : 10-01-2007
    # Versie       : 1.1


    error_reporting(E_ALL);


    # filterText
    function filterText($text) {
        $result = $text;
        //$result = htmlspecialchars($result);
        //$result = nl2br($result);
        return $result;
    }

    # filterText
    function filterShortText($text, $pos=45) {
        $result  = $text;
        $result  = str_replace("<br>", " ", $result);
        $result  = str_replace("<br />", " ", $result);
        $result  = substr($result, 0, $pos);
        $result .= "...";
        return $result;
    }

    # filterBackslashQuotes
    function filterBackslashQuotes($text) {
        $result = $text;
        $result = str_replace("\'", "'", $result); 
        $result = str_replace('\"', "''", $result);
        return $result;
    }

    # filterDoubleQuotes
    function filterDoubleQuotes($text) {
        $result = $text;
        $result = str_replace('"', "'", $result); 
        return $result;
    }

    # filterAND
    function filterAND($string) {
        $result = str_replace("&", "&amp;", $string);
        return $result;
    }

    # filterHTML
    function filterHTML($text) {
        $result = htmlspecialchars($text);
        return $result;
    }

    # filterDirectory
    function filterDirectory($dir) {
        $result = str_replace(" ", "%20", $dir);
        return $result;
    }

    # filterCRLF
    function filterCRLF($text) {
        $result = str_replace("\r\n", "<br>", $text);
        return $result;
    }

    # filterTimeDir
    function filterTimeDir($dir) {
        $result = str_replace(":", ".", $dir);
        return $result;
    }

    # filterComment
    function filterComment($comment) {
        $result = str_replace(";", ",", $comment);
        $result = str_replace("~", "", $result);
        return $result;
    }

    #filterDateTime
    function filterDateTime($dt) {
        $remChars = array("-", ":", " ");
        return str_replace($remChars, "", $dt);
    }

?>