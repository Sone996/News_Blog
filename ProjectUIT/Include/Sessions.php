<?php

session_start();

function Message() {
    if (isset($_SESSION["ErrorMesage"])) {
        $output = htmlentities($_SESSION["ErrorMesage"]);
        $_SESSION["ErrorMesage"] = null;
        return $output;
    }
}

function SuccessMessage() {
    if (isset($_SESSION["SuccessMessage"])) {
        $output = htmlentities($_SESSION["SuccessMessage"]);
        $_SESSION["SuccessMessage"] = null;
        return $output;
    }
}
?>