<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/ProjectUIT/Include/DB.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/ProjectUIT/Include/Sessions.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/ProjectUIT/Include/Function.php'; ?>
<link rel="stylesheet" type="text/css" href="CSS/Account_Info.css">
<?php if(isset($_SESSION['Username'])) : ?>

    <?php
    $conn = mysqli_connect("localhost", "root", "", "uit");
    $Viewquery = "SELECT * FROM users WHERE ID=" . $_SESSION["user_ID"];
    $execute = mysqli_query($conn, $Viewquery);
    while ($DataRows = mysqli_fetch_array($execute)) {
        $Name = $DataRows['IME'];
        $LastName = $DataRows['PREZIME'];
        $Mail = $DataRows['MAIL'];
        
        $User = $DataRows['USER_NAME'];
        $Password = $DataRows['PASSWORD'];
        ?>
        <ul id="resultList">
            <li>Name: <?php echo $Name; ?></li>
            <li>Last Name:<?php echo $LastName; ?></li>
            <li>Email: <?php echo $Mail; ?></li>
            <li>Username: <?php echo $User; ?></li>
            <li id="passDisp" onmouseover="revealPass();" onmouseleave="hidePass();" >Move mouse over to display password</li>
        </ul>
<?php } ?>
<?php endif; ?>
<?php if(!isset($_SESSION['Username'])) : ?>
        <h3>You need to be logged in too see account information.</h3>
<?php endif; ?>
<script>
    function revealPass(){
            document.getElementById('passDisp').innerHTML = 'Password: <?php echo $Password; ?>';
    }
    
    function hidePass(){
            document.getElementById('passDisp').innerHTML = 'Move mouse over to display password';
    }
</script>
</table>