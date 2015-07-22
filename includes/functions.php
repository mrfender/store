<?php

    # Bestandsnaam : functions.php
    # Omschrijving : Dit bestand bevat handige functies
    # Auteur       : Jan Hoekstra
    # Datum        : 15-10-2011
    # Versie       : 1.2.0


    // includes
    require_once("includes/html.php");
    require_once("includes/settings.php");


    # getGETvar
    # - Omschrijving: ophalen van een GET-variabele
    # - Parameters:   GET-variabelenaam
    # - Resultaat:    waarde van de GET-variabele of een lege string
    function getGETvar($var) {
        return ( IsSet($_GET[$var] ) ? $_GET[$var] : "" );
    }

    # getGETPOSTvar
    # - Omschrijving: ophalen van een GET-variabele, als deze er niet is de POST-variabele proberen
    # - Parameters:   GET-variabelenaam of POST-variabelenaam
    # - Resultaat:    waarde van de GET-variabele, POST-variabele of een lege string
    function getGETPOSTvar($var) {
        $result = ( IsSet($_GET[$var] ) ? $_GET[$var] : "" );
        if ( !$result ) $result = ( IsSet($_POST[$var] ) ? $_POST[$var] : "" );
        return $result;
    }

    # getPOSTvar
    # - Omschrijving: ophalen van een POST-variabele
    # - Parameters:   POST-variabelenaam
    # - Resultaat:    waarde van POST-variabele of een lege string
    function getPOSTvar($var) {
        return ( IsSet($_POST[$var]) ? $_POST[$var] : "" );
    }

    # getPOSTGETvar
    # - Omschrijving: ophalen van een POST-variabele, als deze er niet is de GET-variabele proberen
    # - Parameters:   POST-variabelenaam of GET-variabelenaam
    # - Resultaat:    waarde van de POST-variabele, GET-variabele of een lege string
    function getPOSTGETvar($var) {
        $result = ( IsSet($_POST[$var] ) ? $_POST[$var] : "" );
        if ( !$result ) $result = ( IsSet($_GET[$var] ) ? $_GET[$var] : "" );
        return $result;
    }

    # getFILEvar
    # - Omschrijving: ophalen van een FILES-variabele
    # - Parameters:   FILES-variabelenaam
    # - Resultaat:    waarde van FILES-variabele of een lege string
    function getFILEvar($var) {
        return ( IsSet($_FILES[$var]) ? $_FILES[$var] : "" );
    }

    # WriteImage
    # - Omschrijving: wegschrijven van de header image
    function WriteImage($src) {
        HtmlStartTable("imageHeader", true, true, "cellpadding='0' cellspacing='0'");
        HtmlImage($src);
        HtmlEndTable(true, true);
    }

    # WriteHeader
    # - Omschrijving: wegschrijven van de header van een scherm, evt. met links
    function WriteHeader($title, $css="", $prevLink="", $nextLink="") {
        if ( !$css ) $css = "home";
        HtmlStartTable($css, true, false);
        HtmlStartTD("valign='middle'");
        if ( $prevLink ) {
            HtmlAnchor("&lt;&lt;", $prevLink, "", "class='header_navigation'");
            WriteLine(" ");
        }
        WriteLine(ucfirst($title)."&nbsp;");
        if ( $nextLink ) {
            WriteLine(" ");
            HtmlAnchor("&gt;&gt;", $nextLink, "", "class='header_navigation'");
        }
        HtmlEndTD();
        HtmlEndTable(true, false);
    }
    
    # WriteLoginLink
    # - Omschrijving: Menulink plaatsen
    function WriteLoginLink($link) {
        HtmlStartAnchor($link, "", "class='login'");
        if ( file_exists(MENU_IMAGES_DIR ."login.png") ) {
            $onMouseOver = "";
            $onMouseOut  = "";
            if ( file_exists(MENU_IMAGES_DIR ."login_s.png") ) {
                $onMouseOver = "menuMouseAction(this.id, \"". MENU_IMAGES_DIR . "login_s.png\");";
                $onMouseOut  = "menuMouseAction(this.id, \"". MENU_IMAGES_DIR . "login.png\");";
            }
            HtmlImage(MENU_IMAGES_DIR . "login.png", "login", "id='menuLogin' onMouseOver='$onMouseOver' onMouseOut='$onMouseOut'");
        }
        else {
            WriteLine("login");
        }
        HtmlEndAnchor();
    }

    # WriteFooter
    # - Omschrijving: Wegschrijven van de footer van een scherm
    # - Parameters:   Link van de terug-knop en de tekst hiervan
    function WriteFooter($text, $link) {
        HtmlStartTable("small", true, true, "");
        HtmlBR(1);
        HtmlAnchor($text, $link, "", "");
        HtmlBR(2);
        HtmlEndTable(true, true);
    }

    # getFormAction()
    function getFormAction() {
        $pageID = "";
        if      ( getPOSTvar("Add")      ) $pageID = getPOSTvar("pageAdd");
        else if ( getPOSTvar("Edit")     ) $pageID = getPOSTvar("pageEdit");
        else if ( getPOSTvar("Delete")   ) $pageID = getPOSTvar("pageDelete");
        else if ( getPOSTvar("Order")    ) $pageID = getPOSTvar("pageOrder");
        else if ( getPOSTvar("Download") ) $pageID = getPOSTvar("pageDownload");
        else if ( getPOSTvar("Block")    ) $pageID = getPOSTvar("pageBlock");
        else                               $pageID = getPOSTvar("nPID");
        return $pageID;
    }

    function WriteProtectedButtons($pageID) {
        if ( $menuItems = getPMenuByParentID($pageID) ) {
            HtmlBR();
            HtmlInputHidden("", "action", "1");
            HtmlInputHidden("addID", "addID", "");
            HtmlInputHidden("editID", "editID", "");
            foreach ( $menuItems as $mi ) {
                if ( $mi->userrightOrder >= getS_Userright() ) {
                    HtmlInputSubmit("button". ucfirst($mi->name), ucfirst($mi->name), $mi->label);
                    if ( in_array(ucfirst($mi->name), array("Add", "Edit", "Delete", "Order", "Download", "Block")) )
                        HtmlInputHidden("", "page". ucfirst($mi->name), $mi->menuID);
                    else
                        HtmlInputHidden("", "nPID", $mi->menuID);
                    HtmlBR();
                }
            }
        }
    }

    function WriteMenuOptions($parentID, $currentParentID, $i="", $locked=true, $excludeIDs="") {
        if ( $mItems = getMenuByParentID($parentID, $locked, $excludeIDs) ) {
            foreach ( $mItems as $mi ) {
                HtmlSelectOption($mi->menuID, $i ." ". $mi->label, ($currentParentID == $mi->menuID));
                WriteMenuOptions($mi->menuID, $currentParentID, $i . "&gt;", $locked, $excludeIDs);
            }
        }
    }

    function WritePMenuOptions($parentID, $currentParentID, $i="") {
        if ( $mItems = getPMenuByParentID($parentID) ) {
            foreach ( $mItems as $mi ) {
                HtmlSelectOption($mi->menuID, $i ." ". $mi->name ." - ". $mi->label, ($currentParentID == $mi->menuID));
                WritePMenuOptions($mi->menuID, $currentParentID, $i . "&gt;");
            }
        }
    }

    function GetMenuNavigation($parentID, $action) {
        $menuNavigation = "";     
        if ( $parentID ) {
            $tmp = $parentID;
            while ( $tmp ) {
                $mi = getMenuByID($tmp);
                if ( $tmp == $parentID ) $tmp2  = " >> ". $mi->name;
                else {
                    $link = $action . filterAND("&&parentID=". $mi->menuID);
                    $tmp2 = " >> <a href='". $link ."'>". $mi->label ."</a>";
                }
                $tmp            = $mi->menuParentID;
                $menuNavigation = $tmp2 . $menuNavigation;
            }
        }    
        return $menuNavigation;
    }

    function GetPMenuNavigation($parentID, $action) {
        $menuNavigation = "";     
        if ( $parentID ) {
            $tmp  = $parentID;
            $menu = "";
            while ( $tmp ) {
                $mi = getPMenuByID($tmp);
                if ( $tmp == $parentID ) $tmp2  = " >> ". $mi->name;
                else {
                    $link = $action . filterAND("&&parentID=". $mi->menuID);
                    $tmp2 = " >> <a href='". $link ."'>". $mi->label ."</a>";
                }
                $tmp           = $mi->menuParentID;
                $menuNavigation = $tmp2 . $menuNavigation;
            }
        }
        return $menuNavigation;
    }    

    function WriteUserRightOptions($currUserrightID="") {
        $userrights = getUserrights();
        foreach ( $userrights as $ur ) {
            if ( $currUserrightID == $ur->userrightID ) HtmlSelectOption($ur->userrightID, $ur->userright, true);
            else HtmlSelectOption($ur->userrightID, $ur->userright, false);
        }
        HtmlEndSelect();
    }

    function WriteDatePickerOption($fieldname, $fieldvalue, $fieldlabel="selecteer datum") {
        HtmlStartTable("", true, false);
        HtmlStartTD("valign='top' style='padding-top:5px;'");
        HtmlInputText("", $fieldname, $fieldvalue, "maxlength='10' class='shortTextfield'");
        HtmlEndTD();
        HtmlStartTD("valign='top'");
        HtmlStartAnchor("#", "", "onClick='displayDatePicker(\"". $fieldname ."\");'");
        HtmlImage(ICONS_DIR . "i_datepicker.png", $fieldlabel, "border='0'");
        HtmlEndAnchor();
        HtmlEndTD();
        HtmlEndTable(true, false);
    }
    
    function WriteJavaScript($js) {
        WriteLine("<SCRIPT language='javascript' type='text/javascript'>". $js ."</SCRIPT>");
    }

    function GetFocus($ID) {
        WriteJavaScript("document.getElementById('". $ID ."').focus();");
    }

    function generatePassword($maxPasswordCharacters=8) {
        $letters = array('a','b','c','d','e','f','g','h','i','j','k','l','m', 
                         'n','o','p','q','r','s','t','u','v','w','x','y','z', 
                         'A','B','C','D','E','F','G','H','I','J','K','L','M', 
                         'N','O','P','Q','R','S','T','U','V','W','X','Y','Z', 
                         '0','1','2','3','4','5','6','7','8','9', 
                         '+','.','(',')','$','#','=' 
                        );
        srand((double) microtime() * 1000000);
        $password = "";
        for ( $c = 0; $c <= $maxPasswordCharacters; $c++ ) $password .= $letters[rand(0, count($letters)-1)];
        return $password;
    }

    function showHelp($helpText) {
        if ( $helpText ) {
            HtmlStartDiv("", "helpText");
            HtmlStartTable("helpText", true, false);
            HtmlStartTD("align='right'");
            HtmlInputButton("buttonHelp", "help", "", "onClick='showhideElement(\"helpTextDiv\", \"helpTextShow\");' onDblClick='showhideElement(\"helpTextDiv\", \"helpTextHide\");'");
            HtmlDiv($helpText, "helpTextDiv", "helpTextHide", "onClick='showhideElement(\"helpTextDiv\", \"helpTextHide\");'");
            HtmlEndTD();
            HtmlEndTable(true, false);
            HtmlEndDiv();
        }
    }
    
    function ChangeBackground($label="default") {
        $ut = getUploadTypeIDByUploadType("Background");
        if ( $media = getMediaByTypeID($ut, $label) ) {
            $cnt    = count($media);
            $rIndex = rand(0, ($cnt-1));
            WriteJavaScript("$('.page').css(\"background-image\",\"url('". UPLOADDIR . $media[$rIndex]->directory . $media[$rIndex]->filename ."')\");");
            WriteJavaScript("$('.page').css(\"background-position\",\"center center\");");
        }
    }

?>