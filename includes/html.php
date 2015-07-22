<?php

    # Bestandsnaam : html.php
    # Omschrijving : Dit bestand bevat functies om standaard html te maken
    # Auteur       : Jan Hoekstra
    # Datum        : 14-05-2010
    # Versie       : 2.0


    error_reporting(E_ALL);


    include_once("settings.php");


    # HtmlHeader
    # - Omschrijving: wegschrijven van HTML-tags die nodig zijn voor het opbouwen van een standaard html
    #                 header (DOCTYPE, HTML, etc.)
    # - Parameters:   een array met paden voor stylesheets en javascripts, body wegschrijven J/N, toevoeging aan titel
    function HtmlHeader($stylesheets, $javascripts, $body=true, $addHtmlTitle="") {
        echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">\n";
        HtmlComment(VERSION);
        echo "<html>\n";
        echo "<head>\n";
        echo "<title>". HTMLTITLE . $addHtmlTitle ."</title>\n";
        echo "<META http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>\n";
        echo "<META name='description' content='". HTMLDESCRIPTION ."'>\n";
        echo "<META name='keywords' content='". HTMLKEYWORDS ."'>\n";
        echo "<META name='author' content='". HTMLAUTHOR ."'>\n";
        echo "<META name='publisher' content='". HTMLPUBLISHER ."'>\n";
        echo "<META name='copyright' content='". HTMLCOPYRIGHT ."'>\n";
        echo "<META name='language' content=NL>\n";
        echo "<META name='robots' content=ALL>\n";
        if ( HTMLFAVICON ) {
            echo "<link rel='icon' href='". HTMLFAVICON ."' type='image/gif'>\n";
        }
        if ( $stylesheets ) {
            foreach ( $stylesheets as $ss ) 
                echo "<link rel='stylesheet' type='text/css' href='". $ss ."' title='style'>\n";
        }
        if ( $javascripts ) {
            foreach ( $javascripts as $js ) 
                echo "<script language='JavaScript' type='text/javascript' src='". $js ."'></script>\n";
        }
        echo "</head>\n";

        if ( $body ) echo "<body>\n";
    }

    # HtmlStartBody
    # - Omschrijving: wegschrijven van het begin van de body
    # - Parameters:   CSS class, exra opties
    function HtmlStartBody($class, $extra="") {
        echo "<body";
        if ( $class ) echo " class='$class'";
        if ( $extra ) echo " $extra";
        echo ">\n";
    }

    # HtmlEndBody
    # - Omschrijving: wegschrijven van het einde van de body
    function HtmlEndBody() {
        echo "</body>\n";
    }

    # HtmlFooter
    # - Omschrijving: wegschrijven van HTML-tags die nodig zijn voor het opbouwen van de footer (BODY, HTML)
    # - Parameters:   Body wegschrijven J/N
    function HtmlFooter($body=true) {
        if ( $body ) echo "</body>\n";
        echo "</html>\n";
    }

    # HtmlFrameHeader
    # - Omschrijving: wegschrijven van HTML-tags die nodig zijn voor het opbouwen van een standaard
    #                 frameheader (DOCTYPE, HTML, etc.)
    function HtmlFrameHeader($addHtmlTitle="") {
        echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Frameset//EN\" \"http://www.w3.org/TR/html4/frameset.dtd\">\n";
        HtmlComment(VERSION);
        echo "<html>\n";
        echo "<head>\n";
        echo "<title>". HTMLTITLE . $addHtmlTitle ."</title>\n";
        echo "<META http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>\n";
        echo "<META name='description' content='". HTMLDESCRIPTION ."'>\n";
        echo "<META name='keywords' content='". HTMLKEYWORDS ."'>\n";
        echo "<META name='author' content='". HTMLAUTHOR ."'>\n";
        echo "<META name='publisher' content='". HTMLPUBLISHER ."'>\n";
        echo "<META name='copyright' content='". HTMLCOPYRIGHT ."'>\n";
        echo "<META name='language' content=NL>\n";
        echo "<META name='robots' content=ALL>\n";
        echo "</head>\n";
    }

    # HtmlStartFrameSet
    # - Omschrijving: begin van een FrameSet
    # - Parameters:   aantal rijen, aantal kolommen
    function HtmlStartFrameSet($rows, $cols) {
        if ( $rows ) echo "<frameset rows='$rows'>\n";
        if ( $cols ) echo "<frameset cols='$cols'>\n";
    }

    # HtmlFrame
    # - Omschrijving: HtmlFrame
    # - Parameters:   naam van frame, link, extra opties
    function HtmlFrame($name, $link, $extra="") {
        echo "<frame src='$link'";
        if ( $name  ) echo " name='$name'";
        if ( $extra ) echo " $extra";
        echo ">\n";
    }

    # HtmlEndFrameSet
    # - Omschrijving: einde van een FrameSet
    function HtmlEndFrameSet() {
        echo "</frameset>\n";
    }

    # HtmlFrameFooter
    # - Omschrijving: wegschrijven van HTML-tags die nodig zijn voor het opbouwen van de framefooter (HTML)
    function HtmlFrameFooter() {
        echo "</html>\n";
    }

    # HtmlComment
    # - Omschrijving: wegschrijven van commentaar in HTML
    function HtmlComment($Comment) {
        echo "<!-- $Comment -->\n";
    }

    # HtmlIFrame
    # - Omschrijving: wegschrijven van een iframe in HTML
    # - Parameters:   link, breedte, hoogte, extra opties
    function HtmlIFrame($name, $link, $width, $height, $extra="") {
        echo "<iframe";
        echo " name='$name' src='$link' width='$width' height='$height' frameborder='0'";
        if ( $extra ) echo " $extra";
        echo "></iframe>\n";
    }

    # HtmlStartDiv
    # - Omschrijving: begin van een HTML div
    # - Parameters:   id, class, extra opties
    function HtmlStartDiv($id, $class, $extra="") {
        echo "<div";
        if ( $id    ) echo " id='$id'";
        if ( $class ) echo " class='$class'";
        if ( $extra ) echo " $extra";
        echo ">\n";
    }

    # HtmlEndDiv
    # - Omschrijving: einde van een HTML div
    function HtmlEndDiv() {
        echo "</div>\n";
    }

    # HtmlDiv
    # - Omschrijving: een HTML div
    # - Parameters:   output, id, class, extra opties
    function HtmlDiv($output, $id, $class, $extra="") {
        echo "<div";
        if ( $id    ) echo " id='$id'";
        if ( $class ) echo " class='$class'";
        if ( $extra ) echo " $extra";
        echo ">$output</div>\n";
    }

    # HtmlStartP
    # - Omschrijving: begin van een HTML paragraph
    # - Parameters:   class, extra opties
    function HtmlStartP($class, $extra="") {
        echo "<p";
        if ( $class ) echo " class='$class'";
        if ( $extra ) echo " $extra";
        echo ">\n";
    }

    # HtmlEndP
    # - Omschrijving: einde van een HTML paragraph
    function HtmlEndP() {
        echo "</p>\n";
    }

    # HtmlP
    # - Omschrijving: een HTML paragraph
    # - Parameters:   output, id, class, extra opties
    function HtmlP($text, $class, $extra="") {
        echo "<p";
        if ( $class ) echo " class='$class'";
        if ( $extra ) echo " $extra";
        echo ">$text</p>\n";
    }

    # HtmlStartForm
    # - Omschrijving: wegschrijven van het begin van een form
    # - Parameters:   action en methode van een form
    function HtmlStartForm($action="", $method="", $extra="") {
        if ( $method ) {
            echo "<form name='frm' action='". $action ."' method='". $method ."'";
            if ( $extra ) echo " ". $extra;
            echo ">\n";
        }
        else {
            echo "<form name='frm' action='". $action ."' method='post'";
            if ( $extra ) echo " ".$extra;
            echo ">\n";
        }
    }

    # HtmlEndForm
    # - Omschrijving: wegschrijven van het einde van een form
    function HtmlEndForm() {
        echo "</form>\n";
    }

    # HtmlStartTable
    # - Omschrijving: wegschrijven van het begin van een tabel
    # - Parameters:   CSS class, tabelrij J/N, tabelkolom J/N, extra opties
    function HtmlStartTable($class, $tr=true, $td=true, $extra="border='0' cellpadding='0' cellspacing='0'") {
        echo "<table";
        if ( $class ) echo " class='$class'";
        if ( $extra ) echo " $extra";
        echo ">\n";
        if ( $tr ) {
            echo "<tr>\n";
            if ( $td ) echo "<td>\n";
        }
    }

    # HtmlEndTable
    # - Omschrijving: wegschrijven van het einde van een tabel
    # - Parameters:   tabelrij J/N, tabelkolom J/N
    function HtmlEndTable($tr=true, $td=true) {
        if ( $tr ) {
            if ( $td ) echo "</td>\n";
            echo "</tr>\n";
        }
        echo "</table>\n";
    }

    # HtmlStartTR
    # - Omschrijving: wegschrijven van het begin van een tabelrij
    # - Parameters:   extra opties tabelrij, tabelkolom J/N, zo ja extra opties voor tabelkolom
    function HtmlStartTR($extraTR="", $td=true, $extraTD="") {
        echo "<tr";
        if ( $extraTR ) echo " $extraTR";
        echo ">\n";
         if ( $td ) {
            echo "<td";
            if ( $extraTD ) echo " $extraTD";
            echo ">\n";
        }
    }

    # HtmlEndTR
    # - Omschrijving: wegschrijven van het einde van een tabelrij
    # - Parameters:      tabelkolom J/N
    function HtmlEndTR($td=true) {
        if ( $td ) echo "</td>\n";        
        echo "</tr>\n";
    }

    # HtmlTR
    # - Omschrijving: wegschrijven van een tabelrij
    # - Parameters:   inhoud van de tabelrij, extra opties voor tabelrij, extra opties voor tabelkolom
    function HtmlTR($text, $extraTR="", $extraTD="") {
        echo "<tr";
        if ( $extraTR ) echo " $extraTR";
        echo "><td";
        if ( $extraTD ) echo " $extraTD";
        echo ">$text</td></tr>\n";
    }

    # HtmlStartTD 
    # - Omschrijving: wegschrijven van het begin van een tabelkolom
    # - Parameters:      extra opties
    function HtmlStartTD($extra="") {
        echo "<td";
        if ( $extra ) echo " $extra";
        echo ">\n";
    }

    # HtmlEndTD
    # - Omschrijving: wegschrijven van het einde van een tabelkolom
    function HtmlEndTD() {
        echo "</td>\n";
    }

    # HtmlTD
    # - Omschrijving: wegschrijven van een tabelkolom
    # - Parameters:   inhoud van de tabelkolom, extra opties
    function HtmlTD($text, $extra="") {
        echo "<td";
        if ( $extra ) echo " $extra";
        echo ">$text</td>\n";
    }

    # HtmlStartAnchor
    # - Omschrijving: wegschrijven van het begin van een anchor
    # - Parameters:   link, target en extra opties
    function HtmlStartAnchor($link, $target="", $extra="") {
        echo "<a href='$link'";
        if ( $target ) echo " target='$target'";
        if ( $extra  ) echo " $extra";
        echo ">\n";
    }

    # HtmlEndAnchor
    # - Omschrijving: wegschrijven van het einde van een form
    function HtmlEndAnchor() {
        echo "</a>\n";
    }

    # HtmlAnchor
    # - Omschrijving: wegschrijven van een anchor
    # - Parameters:   tekst, link, target en extra opties
    function HtmlAnchor($text, $link, $target="", $extra="") {
        echo "<a href='$link'";
        if ( $target ) echo " target='$target'";
        if ( $extra  ) echo " $extra";
        echo ">$text</a>\n";
    }

    # HtmlImage
    # - Omschrijving: HTML afbeelding
    # - Parameters:   lokatie van de afbeelding en extra opties
    function HtmlImage($src, $alt="", $extra="") {
        echo "<img src='$src'";
        echo " alt=\"$alt\"";
        if ( $extra ) echo " $extra";
        echo ">";
    }

    # HtmlInputButton
    # - Omschrijving: HTML Input Button
    # - Parameters:   id, naam, waarde, extra opties
    function HtmlInputButton($id, $name, $value, $extra="") {
        echo "<input type='button'";
        if ( $id    ) echo " id='". $id ."'";
        if ( $name  ) echo " name='". $name ."'";
        if ( $value ) echo " value=\"". $value ."\"";
        if ( $extra ) echo " ". $extra;
        if ( !strstr($extra, "class=") ) echo " class='button'";
        echo ">\n";
    }

    # HtmlInputSubmit
    # - Omschrijving: HTML Input Submit
    # - Parameters:   id, naam, waarde, extra opties
    function HtmlInputSubmit($id, $name, $value, $extra="") {
        echo "<input type='submit'";
        if ( $id    ) echo " id='$id'";
        if ( $name  ) echo " name='$name'";
        if ( $value ) echo " value=\"$value\"";
        if ( $extra ) echo " $extra";
        if ( !strstr($extra, "class=") ) echo " class='button'";
        echo ">\n";
    }

    # HtmlInputText
    # - Omschrijving: HTML Input Text
    # - Parameters:   id, naam, waarde, extra opties
    function HtmlInputText($id, $name, $value, $extra="") {
        echo "<input type='text'";
        if ( $id    ) echo " id='$id'";
        if ( $name  ) echo " name='$name'";
        echo " value=\"$value\"";
        if ( $extra ) echo " $extra";
        echo ">\n";
    }

    # HtmlInputPassword
    # - Omschrijving: HTML Input password
    # - Parameters:   id, naam, waarde, extra opties
    function HtmlInputPassword($id, $name, $value, $extra="") {
        echo "<input type='password'";
        if ( $id    ) echo " id='$id'";
        if ( $name  ) echo " name='$name'";
        if ( $value ) echo " value=\"$value\"";
        if ( $extra ) echo " $extra";
        echo ">\n";
    }

    # HtmlInputHidden
    # - Omschrijving: HTML Input Hidden
    # - Parameters:   id, naam, waarde, extra opties
    function HtmlInputHidden($id, $name, $value, $extra="") {
        echo "<input type='hidden'";
        if ( $id    ) echo " id='$id'";
        if ( $name  ) echo " name='$name'";
        echo " value=\"$value\"";
        if ( $extra ) echo " $extra";
        echo ">\n";
    }

    # HtmlInputFile
    # - Omschrijving: HTML Input File
    # - Parameters:   id, naam, waarde, extra opties
    function HtmlInputFile($id, $name, $value, $extra="") {
        echo "<input type='file'";
        if ( $id    ) echo " id='$id'";
        if ( $name  ) echo " name='$name'";
        if ( $value ) echo " value=\"$value\"";
        if ( $extra ) echo " $extra";
        echo ">\n";
    }

    # HtmlInputRadio
    # - Omschrijving: HTML Input Radiobutton
    # - Parameters:   id, naam, waarde, extra opties, aangevinkt j/n
    function HtmlInputRadio($id, $name, $value, $text, $extra="", $checked=false) {
        echo "<input type='radio'";
        if ( $id      ) echo " id='$id'";
        if ( $name    ) echo " name='$name'";
        if ( $value   ) echo " value=\"$value\"";
        if ( $extra   ) echo " $extra";
        if ( $checked ) echo " checked";
        echo "> $text\n";
    }


    # HtmlInputCheckbox
    # - Omschrijving: HTML Input Checkbox
    # - Parameters:   id, naam, waarde, text, extra opties, aangevinkt j/n
    function HtmlInputCheckbox($id, $name, $value, $text, $extra="", $checked=false) {
        echo "<input type='checkbox'";
        if      ( $id         ) echo " id='$id'";
        if      ( $name       ) echo " name='$name'";
        if      ( $value      ) echo " value=\"$value\"";
        else if ( $value == 0 ) echo " value='0'";
        if      ( $extra      ) echo " $extra";
        if      ( $checked    ) echo " checked";
        echo "/> $text\n";
    }

    # HtmlInputImage
    # - Omschrijving: HTML Input Image Button
    # - Parameters:   id, naam, waarde, extra opties
    function HtmlInputImage($id, $name, $value, $src, $extra="class='button'") {
        echo "<input type='image'";
        if ( $id    ) echo " id='". $id ."'";
        if ( $name  ) echo " name='". $name ."'";
        if ( $src   ) echo " src='". $src ."'";
        if ( $value ) echo " value=\"". $value ."\"";
        if ( $extra ) echo " ". $extra;
        echo ">\n";
    }

    # HtmlTextarea
    # - Omschrijving: HTML Input text
    # - Parameters:   id, naam, waarde, extra opties
    function HtmlTextarea($id, $name, $value, $extra="") {
        echo "<textarea";
        if ( $id    ) echo " id='$id'";
        if ( $name  ) echo " name='$name'";
        if ( $extra ) echo " $extra";
        echo ">$value</textarea>\n";
    }

    # HtmlStartSelect
    # - Omschrijving: wegschrijven van het begin van een select
    # - Parameters:   id, name, Extra options van een select
    function HtmlStartSelect($id, $name, $extra="") {
        echo "<select";
        if ( $id    ) echo " id='$id'";
        if ( $name  ) echo " name='$name'";
        if ( $extra ) echo " $extra";
        echo ">\n";
    }

    # HtmlOption
    # - Omschrijving: wegschrijven van een Html Option
    # - Parameters:   waarde, tekst, geselecteerd j/n
    function HtmlSelectOption($value, $text, $selected=false) {
        echo "<option";
        if ( $value    ) echo " value=\"$value\"";
        if ( $selected ) echo " selected";
        echo ">$text</option>\n";
    }

    # HtmlEndSelect
    # - Omschrijving: wegschrijven van het einde van een select   
    function HtmlEndSelect() {
        echo "</select>\n";
    }

    # HtmlBR
    # - Omschrijving: wegschrijven van een <br>
    function HtmlBR($nrOfBR=1) {
        while ( $nrOfBR > 0 ) {
            echo "<br>";
            $nrOfBR--;
        }
        echo "\n";
    }

    # WriteLine
    # - Omschrijving: wegschrijven van een regel(string)
    function WriteLine($line, $br=0) {
        echo $line."\n";
        if ( $br ) HtmlBR($br);
    }

    # WriteString
    # - Omschrijving: wegschrijven van een string
    function WriteString($str) {
        echo $str;
    }

?>