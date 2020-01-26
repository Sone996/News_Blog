<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/ProjectUIT/Include/DB.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/ProjectUIT/Include/Sessions.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/ProjectUIT/Include/Function.php'; ?>
<?php Confirm_Login(); ?>
<?php
//uzima podatke iz baze
$Name = "";
$LastName = "";
$Mail = "";
$User = "";
$Password = "";
$conn = mysqli_connect("localhost", "root", "", "uit");
$Update_record = filter_input(INPUT_GET, 'Update');
$Show_query = "SELECT * FROM users WHERE ID='$Update_record' ";
$Update = mysqli_query($conn, $Show_query);
while ($DataRows = mysqli_fetch_array($Update)) {
    $Update_ID = $DataRows['ID'];
    $Name = $DataRows['IME'];
    $LastName = $DataRows['PREZIME'];
    $Mail = $DataRows['MAIL'];
    $User = $DataRows['USER_NAME'];
    $Password = $DataRows['PASSWORD'];
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Create a account</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../CSS/Create.css">
    </head>
    <body>
        <div>
            <h1>Create an account</h1>
            <form action="Update.php?Update_ID=<?php echo $Update_ID; ?>" method="post">
                <table>
                    <tr><td class="L"> <span>Name:</span></td>
                        <td class="R"><input type="text" name="name"  value="<?php echo $Name; ?>"><br></td></tr>
                    <tr><td class="L"><span>Last name:</span></td>
                        <td class="R"><input  type="text" name="last_name"  value="<?php echo $LastName; ?>"><br></td></tr> 
                    <tr><td class="L"> <span>E-mail:</span></td>
                        <td class="R"> <input type="text" name="mail" value="<?php echo $Mail; ?>"><br></td></tr>
                    <tr><td class="L"> <span>User name:</span></td>
                        <td class="R"><input type="text" name="user" value="<?php echo $User; ?>"><br></td></tr> 
                    <tr><td class="L"> <span>Password:</span></td>
                        <td class="R"> <input  type="password" name="password" value="<?php echo $Password; ?>" ><br></td></tr>
                </table>
                <input id="dugme" type="Submit" name="submit" value="Update">
            </form>
        </div>
    </body>
</html>
<?php
//Vraca podatke u tebelu

if (filter_input(INPUT_POST,'submit')) {
    $conn = new mysqli("localhost", "root", "", "uit");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }    
    $Update_ID = filter_input(INPUT_GET,'Update_ID');
    $Name = filter_input(INPUT_POST, 'name');
    $LastName = filter_input(INPUT_POST, 'last_name');
    $Mail = filter_input(INPUT_POST, 'mail');
    $User = filter_input(INPUT_POST, 'user');
    $Password = filter_input(INPUT_POST, 'password');
    $execute = "UPDATE users SET IME='$Name', PREZIME='$LastName', MAIL='$Mail', USER_NAME='$User', PASSWORD='$Password' WHERE ID='$Update_ID' ";
    if ($conn->query($execute) === TRUE) {
        $conn->close();
         echo '<script>window.open("DB_view.php?Updated=Update successfully","_self")</script>';
    } 
    else {
        echo "Error updating record: " . $conn->error;
    }
}
?>
