<?php

    # Bestandsnaam : session.php
    # Omschrijving : Dit bestand zorgt voor de aanmaak / aanroep / controle van de sessie
    # Auteur       : Jan Hoekstra
    # Datum        : 17-10-2011
    # Versie       : 1.4.0


    // Sessie starten
    session_start();


    // includes
    require_once("includes/settings.php");
    require_once("includes/functions.php");


    // Contantes
    define("S_MAX_TIME", (20*60)); // Maximum inlogtijd (5 min. * 60 sec. = 300 sec.)
    define("S_USER",     "sUser"  .  BASE_SESSION);
    define("S_ADMIN",    "sAdmin" .  BASE_SESSION);
    define("S_TIME",     "sTime"  .  BASE_SESSION);
    define("S_CALENDAR", "sCal"   .  BASE_SESSION);
    define("S_SITEID",   "sSiteID".  BASE_SESSION);
    define("S_MESSAGE",  "sMessage". BASE_SESSION);


    // authenticatie
    // Standaard de sessie controleren
    if ( !checkSession() ) $pageID = "login";


    // instellen van de site-taal
    if ( !getS_SiteID() )                setS_SiteID(BASE_SITEID);
    if ( $siteID = getGETvar("siteID") ) setS_SiteID($siteID);


    # isAdmin
    # Omschrijving controleren of de ingelogde gebruiker admin is
    function isAdmin() {
        return (getS_Userright() <= ADMIN_RIGHTS);
    }

    # isModerator
    # Omschrijving controleren of de ingelogde gebruiker moderator is
    function isModerator() {
        return (getS_Userright() <= MODERATOR_RIGHTS);
    }

    # registerSession
    # - Omschrijving: De functie zorgt voor het registreren van de standaard inlog sessie
    # - Parameters:   gebruikersID, username, email, gebruikersrechten
    function registerSession($uID, $username, $email, $userright) {
        // VERPLICHT
        // gebruikergegevens opslaan
        $user->userID           = strtolower($uID);
        $user->username         = $username;
        $user->userright        = $userright;
        $user->email            = $email;
        $_SESSION[S_USER]       = $user;

        // instellen van de tijd
        $_SESSION[S_TIME] = time();

        // NIET VERPLICHT
        // opslaan van kalender gegevens
        $cal->calendarMonth     = date("m");
        $cal->calendarYear      = date("Y");
        $_SESSION[S_CALENDAR]   = $cal;
    }

    # checkSession
    # - Omschrijving: Controleren of er een geldige standaard sessie aanwezig is
    # - Resultaat:    geldige sessie ja/nee
    function checkSession() {
        $result = true;

        if ( !IsSet($_SESSION[S_USER]) ) $result = false;

        if ( !IsSet($_SESSION[S_TIME]) ) {
            $result = false;
        }
        else {
            $oldTime = $_SESSION[S_TIME];
            $newTime = time();

            if ( ($newTime-$oldTime) > S_MAX_TIME ) $result = false;
            else $_SESSION[S_TIME] = $newTime;
        }

        if ( !$result ) {
            unregisterSession(S_USER);
            unregisterSession(S_TIME);

            unregisterSession(S_CALENDAR);
        }

        return $result;
    }

    # getS_UserID
    # - Omschrijving: gebruikersID ophalen uit de sessie
    # - Resultaat:    gebruikersID
    function getS_UserID() {
        return $_SESSION[S_USER]->userID;
    }

    # getS_Username
    # - Omschrijving: gebruikersnaam ophalen uit de sessie
    # - Resultaat:    gebruikersnaam
    function getS_Username() {
        return $_SESSION[S_USER]->username;
    }

    # getS_Userright
    # - Omschrijving: gebruikersrechten ophalen uit de sessie
    # - Resultaat:    gebruikersrechten
    function getS_Userright() {
        return $_SESSION[S_USER]->userright;
    }

    # getS_Email
    # - Omschrijving: e-mailadres ophalen uit de sessie
    # - Resultaat:    e-mailaders
    function getS_Email() {
        return $_SESSION[S_USER]->email;
    }

    # setS_UserID
    # - Omschrijving: gebruikersID in de sessie plaatsen
    # - Parameter:    gebruikersID
    function setS_UserID($userID) {
        $_SESSION[S_USER]->userID = $userID;
    }

    # registerAdminSession
    # - Omschrijving: De functie zorgt voor het registreren van de admin inlog sessie
    # - Parameters:   gebruikersID, username, email, gebruikersrechten
    function registerAdminSession($uID, $username, $email, $userright) {
        // gebruikergegevens opslaan
        $user->userID      = strtolower($uID);
        $user->username    = $username;
        $user->userright   = $userright;
        $user->email       = $email;
        $_SESSION[S_ADMIN] = $user;
    }

    # checkAdminSession
    # - Omschrijving: Controleren of er een geldige admin sessie aanwezig is
    # - Resultaat:    geldige sessie ja/nee
    function checkAdminSession() {
        $result = true;
        if ( !IsSet($_SESSION[S_ADMIN]) ) $result = false;
        if ( !$result ) unregisterSession(S_ADMIN);
        return $result;
    }

    # getS_AdminUserID
    # - Omschrijving: admin gebruikersID ophalen uit de adminsessie
    # - Resultaat:    admin gebruikersID
    function getS_AdminUserID() {
        return $_SESSION[S_ADMIN]->userID;
    }

    # getS_AdminUsername
    # - Omschrijving: admin gebruikersnaam ophalen uit de adminsessie
    # - Resultaat:    admin gebruikersnaam
    function getS_AdminUsername() {
        return $_SESSION[S_ADMIN]->username;
    }

    # getS_AdminUserright
    # - Omschrijving: admin gebruikersrechten ophalen uit de adminsessie
    # - Resultaat:    admin gebruikersrechten
    function getS_AdminUserright() {
        return $_SESSION[S_ADMIN]->userright;
    }

    # getS_AdminEmail
    # - Omschrijving: admin e-mailadres ophalen uit de adminsessie
    # - Resultaat:    admin e-mailaders
    function getS_AdminEmail() {
        return $_SESSION[S_ADMIN]->email;
    }

    # getS_CalendarMonth
    # - Omschrijving: kalender maand uit de sessie halen
    # - Resultaat:    kalender maand
    function getS_CalendarMonth() {
        if ( IsSet($_SESSION[S_CALENDAR]) ) return $_SESSION[S_CALENDAR]->calendarMonth;
        else return date("m");
    }

    # getS_CalendarYear
    # - Omschrijving: kalender jaar uit de sessie halen
    # - Resultaat:    kalender jaar
    function getS_CalendarYear() {
        if ( IsSet($_SESSION[S_CALENDAR]) ) return $_SESSION[S_CALENDAR]->calendarYear;
        else return date("Y");
    }

    # setS_CalendarMonth
    # - Omschrijving: kalender maand uit de sessie halen
    # - Parameters:   maand
    # - Resultaat:    kalender maand
    function setS_CalendarMonth($month) {
        $_SESSION[S_CALENDAR]->calendarMonth = $month;
    }

    # setS_CalendarYear
    # - Omschrijving: kalender jaar uit de sessie halen
    # - Parameters:   jaar
    # - Resultaat:    kalender jaar
    function setS_CalendarYear($year) {
        $_SESSION[S_CALENDAR]->calendarYear = $year;
    }

    # getS_SiteID
    # - Omschrijving: siteID ophalen uit de sessie
    # - Resultaat:    siteID
    function getS_SiteID() {
        return (IsSet($_SESSION[S_SITEID]) ? $_SESSION[S_SITEID] : false);
    }

    # setS_SiteID
    # - Omschrijving: siteID in de sessie plaatsen
    # - Resultaat:    siteID
    function setS_SiteID($siteID) {
        $_SESSION[S_SITEID] = $siteID;
    }

    # getS_Message
    # - Omschrijving: bericht ophalen uit sesie
    # - Resultaat:    bericht, berichtType, css class
    function getS_Message() {
        return (IsSet($_SESSION[S_MESSAGE]) ? $_SESSION[S_MESSAGE] : false);
    }

    # setS_Message
    # - Omschrijving: bericht opslaan in sesie
    # - Parameters:   bericht, bericht type, css class
    function setS_Message($msg, $msgCSS="", $msgType="", $msgTime=2) {
        $message->msg     = $msg;
        $message->msgCSS  = $msgCSS;
        $message->msgType = $msgType;
        $message->msgTime = ($msgTime * 1000);
        $message->msgCnt  = 0;
        $_SESSION[S_MESSAGE] = $message;
    }
    
    function cntS_Message() {
        $_SESSION[S_MESSAGE]->msgCnt++;
    }
    
    # clearS_Message
    # - Omschrijving: verwijderen van berichtinfo
    function clearS_Message() {
        $_SESSION[S_MESSAGE] = "";
        unregisterSession(S_MESSAGE);
    }

    # unregisterSession
    # - Omschrijving: opgegeven sessie verwijderen
    function unregisterSession($session) {
        unset($session);
    }

    # unregisterSessions
    # - Omschrijving: alle sessies verwijderen
    function unregisterSessions() {
        foreach ( $_SESSION as $var => $val) {
            unset($_SESSION[$var]);
        }
        session_destroy();
    }

?>