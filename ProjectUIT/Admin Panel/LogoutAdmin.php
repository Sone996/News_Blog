<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/ProjectUIT/Include/Sessions.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/ProjectUIT/Include/Function.php'; ?>
<?php

$_SESSION["User_ID"] = NULL;
session_destroy();
header("Location: http://localhost/ProjectUIT/index.php?PageName=Home");
?>
