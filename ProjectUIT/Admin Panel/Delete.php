<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/ProjectUIT/Include/DB.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/ProjectUIT/Include/Sessions.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/ProjectUIT/Include/Function.php'; ?>
<?php Confirm_Login(); ?>
<?php
$conn = mysqli_connect("localhost", "root", "", "uit");
$Delete_Record_ID = $_GET['Delete'];
$Delete_Query = "DELETE FROM users WHERE ID=$Delete_Record_ID";
$execute = mysqli_query($conn,$Delete_Query);
if ($execute) {
    echo '<script>window.open("DB_view.php?Deleted=Deleted successfully","_self")</script>';
}
?>