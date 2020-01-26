<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/ProjectUIT/Include/DB.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/ProjectUIT/Include/Sessions.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/ProjectUIT/Include/Function.php'; ?>
<?php Confirm_Login(); ?>
<?php 
if(filter_input(INPUT_GET,"id")){
    $ID_From_URL=filter_input(INPUT_GET,"id");
    $conn;
    $query="DELETE FROM cumments WHERE id='$ID_From_URL' ";
    $execute= mysqli_query($conn, $query);
    if($execute){
        $_SESSION["SuccessMessage"]="Comment deleted";
        redirect_to("Comments.php");
    }else{
         $_SESSION["ErrorMessage"]="Something went wrong. Try again";
        redirect_to("Comments.php");
    }
}
?>