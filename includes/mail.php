<?php

    # Bestandsnaam : mail.php
    # Omschrijving : Dit bestand bevat een MailSender class. Deze bevat php-functies die zorgen voor  
    #                het versturen van text, html en/of multipart e-mails
    # Auteur       : Jan Hoekstra
    # Datum        : 19-10-2011
    # Versie       : 1.2.0


    // includes
    require_once("includes/settings.php");
    require_once("includes/html.php");


    class MailSender {
        var $Boundary;
        var $Subject;
        var $Sender;
        var $Receivers;
        var $ReceiversCC;
        var $ReceiversBCC;
        var $Reply;

        # MailSender
        # Omschrijving: Constructor voor de MailSender class deze maakt een unieke Boundary aan
        function MailSender() {
            $this->Boundary = md5(uniqid(time()));
        }

        # setSubject
        # Omschrijving: stelt het onderwerp van de e-mail in
        # Parameters:   onderwerp
        function setSubject($Subject) {
            $this->Subject = $Subject;
        }

        # setSender
        # Omschrijving: stelt het zender e-mailadres in van de e-mail
        # Parameters:   e-mailadres van zender, evt. naam van zender
        function setSender($Sender, $SenderName="") {
            if ( $SenderName ) $this->Sender = $SenderName ." <". $Sender .">";
            else $this->Sender = $Sender;
        }

        # setReceiver
        # Omschrijving: voegt een ontvanger toe aan de array met ontvangers
        # Parameters:   e-mailadres ontvanger, evt. de naam van de persoon
        function setReceiver($Receiver, $ReceiverName="") {
            if ( $ReceiverName ) $this->Receivers[] = $ReceiverName ." <". $Receiver .">";
            else $this->Receivers[] = $Receiver;
        }

        # setReceivers
        # Omschrijving: voegt een ontvangers toe aan de array met ontvangers
        # Parameters:   e-mailadressen van ontvangers gescheiden door een puntkomma of een komma
        function setReceivers($Receivers) {
            $this->Receivers = preg_split("/,;/", $Receivers);
        }

        # setReceiverCC
        # Omschrijving: voegt een ontvanger toe aan de array met ontvangers
        # Parameters:   e-mailadres ontvanger, evt. de naam van de persoon
        function setReceiverCC($Receiver, $ReceiverName="") {
            if ( $ReceiverName ) $this->ReceiversCC[] = $ReceiverName ." <". $Receiver .">";
            else $this->ReceiversCC[] = $Receiver;
        }

        # setReceiversCC
        # Omschrijving: voegt een ontvangers toe aan de array met ontvangers
        # Parameters:   e-mailadressen van ontvangers gescheiden door een puntkomma of een komma
        function setReceiversCC($Receivers) {
            $this->ReceiversCC = preg_split("/,;/", $Receivers);
        }

        # setReceiverBCC
        # Omschrijving: voegt een ontvanger toe aan de array met ontvangers
        # Parameters:   e-mailadres ontvanger, evt. de naam van de persoon
        function setReceiverBCC($Receiver, $ReceiverName="") {
            if ( $ReceiverName ) $this->ReceiversBCC[] = $ReceiverName ." <". $Receiver .">";
            else $this->ReceiversBCC[] = $Receiver;
        }

        # setReceiversBCC
        # Omschrijving: voegt een ontvangers toe aan de array met ontvangers
        # Parameters:   e-mailadressen van ontvangers gescheiden door een puntkomma of een komma
        function setReceiversBCC($Receivers) {
            $this->ReceiversBCC = preg_split("/,;/", $Receivers);
        }

        # setReply
        # Omschrijving: stelt de het reply e-mailadres in van de e-mail
        # Parameters:   e-mailadres van reply, evt. naam van reply
        function setReply($Reply, $ReplyName="") {
            if ( $ReplyName ) $this->Reply = $ReplyName ." <". $Reply .">";
            else $this->Reply = $Reply;
        }

        # sendTextMail
        # Omschrijving: instellen van een text e-mail
        # Parameters:   tekstbericht
        function sendTextMail($Message) {
            // Afzender instellen
            $text  = 'From: ' . $this->Sender . "\r\n";

            // Ontvanger instellen
            $To = "";
            foreach ( $this->Receivers as $Receiver ) {
                if ( $To ) $To .= ", ". $Receiver;
                else $To = $Receiver;
            }
            $text .= 'To: ' . $To . "\r\n";

            // CC instellen
            $CC = "";
            if ( $this->ReceiversCC ) {
                foreach ( $this->ReceiversCC as $Receiver ) {
                    if ( $CC ) $CC .= ", ". $Receiver;
                    else $CC = $Receiver;
                }
            }
            if ( $CC ) $text .= 'Cc: ' . $CC . "\r\n";

            // BCC instellen
            $BCC = "";
            if ( $this->ReciversBCC ) {
                foreach ( $this->ReceiversBCC as $Receiver ) {
                    if ( $BCC ) $BCC .= ", ". $Receiver;
                    else $BCC = $Receiver;
                }
            }
            if ( $BCC ) $text .= 'Bcc: ' . $BCC . "\r\n";

            // Reply-to instellen
            if ( $this->Reply )    $text .= 'Return-Path: ' . $this->Reply . "\r\n";
            else $text .= 'Return-Path: ' . $this->Sender . "\r\n";

            // Text bericht instellen
            $text .= 'Content-Type: text/plain; charset=ISO-8859-1' ."\r\n";
            $text .= 'Content-Transfer-Encoding: 8bit'. "\r\n\r\n";
            $text .= $Message . "\r\n";

            mail("", $this->Subject, "", $text);
        }

        # sendHtmlMail
        # Omschrijving: instellen van een html e-mail
        # Parameters:   html e-mail
        function sendHtmlMail($Message) {
            // Afzender instellen
            $html  = 'From: ' . $this->Sender . "\r\n";

            // Ontvanger instellen
            $To = "";
            foreach ( $this->Receivers as $Receiver ) {
                if ( $To ) $To .= ", ". $Receiver;
                else $To = $Receiver;
            }
            $html .= 'To: ' . $To . "\r\n";

            // CC instellen
            $CC = "";
            if ( $this->ReceiversCC ) {
                foreach ( $this->ReceiversCC as $Receiver ) {
                    if ( $CC ) $CC .= ", ". $Receiver;
                    else $CC = $Receiver;
                }
            }
            if ( $CC ) $html .= 'Cc: ' . $CC . "\r\n";

            // BCC instellen
            $BCC = "";
            if ( $this->ReceiversBCC ) {
                foreach ( $this->ReceiversBCC as $Receiver ) {
                    if ( $BCC ) $BCC .= ", ". $Receiver;
                    else $BCC = $Receiver;
                }
            }
            if ( $BCC ) $html .= 'Bcc: ' . $BCC . "\r\n";

            // Reply-to instellen
            if ( $this->Reply )    $html .= 'Return-Path: ' . $this->Reply . "\r\n";
            else $html .= 'Return-Path: ' . $this->Sender . "\r\n";

            // Html bericht instellen
            $html .= 'Content-Type: text/HTML; charset=ISO-8859-1' ."\r\n";
            $html .= 'Content-Transfer-Encoding: 8bit'. "\r\n\r\n";
            $html .= $Message . "\r\n";

            mail("", $this->Subject, "", $html);
        }

        # sendMultipartMail
        # Omschrijving: instellen van een multipart e-mail
        # Parameters:   text e-mail, html e-mail
        function sendMultipartMail($MessageText, $MessageHtml) {
            // Afzender instellen
            $multipart  = 'From: ' . $this->Sender . "\r\n";

            // Ontvanger instellen
            $To = "";
            foreach ( $this->Receivers as $Receiver ) {
                if ( $To ) $To .= ", ". $Receiver;
                else $To = $Receiver;
            }
            $multipart .= 'To: ' . $To . "\r\n";

            // CC instellen
            $CC = "";
            if ( $this->ReceiversCC ) {
                foreach ( $this->ReceiversCC as $Receiver ) {
                    if ( $CC ) $CC .= ", ". $Receiver;
                    else $CC = $Receiver;
                }
            }
            if ( $CC ) $multipart .= 'Cc: ' . $CC . "\r\n";

            // BCC instellen
            $BCC = "";
            if ( $this->ReceiversBCC ) {
                foreach ( $this->ReceiversBCC as $Receiver ) {
                    if ( $BCC ) $BCC .= ", ". $Receiver;
                    else $BCC = $Receiver;
                }
            }
            if ( $BCC ) $multipart .= 'Bcc: ' . $BCC . "\r\n";

            // Reply-to instellen
            if ( $this->Reply ) $multipart .= 'Return-Path: ' . $this->Reply . "\r\n";
            else $multipart .= 'Return-Path: ' . $this->Sender . "\r\n";

            // Bericht instellen (text of html)
            $multipart .= 'MIME-Version: 1.0' ."\r\n";
            $multipart .= 'Content-Type: multipart/alternative; boundary="' . $this->Boundary . '"' . "\r\n\r\n";
            $multipart .= $MessageText . "\r\n";
            $multipart .= '--' . $this->Boundary . "\r\n";
            $multipart .= 'Content-Type: text/plain; charset=ISO-8859-1' ."\r\n";
            $multipart .= 'Content-Transfer-Encoding: 8bit'. "\r\n\r\n";
            $multipart .= $MessageText . "\r\n";
            $multipart .= '--' . $this->Boundary . "\r\n";
            $multipart .= 'Content-Type: text/HTML; charset=ISO-8859-1' ."\r\n";
            $multipart .= 'Content-Transfer-Encoding: 8bit'. "\r\n\r\n";
            $multipart .= $MessageHtml . "\r\n";
            $multipart .= '--' . $this->Boundary . "--\r\n";

            mail("", $this->Subject, "", $multipart);
        }
    }

?>