<!--konekcija-->
<?php
$conn = mysqli_connect("localhost", "root", "", "uit");
if (mysqli_connect_errno()) {
    die("Neuspela konekcija sa bazom <br>Poruka o gresci:" . mysqli_connect_error());
}
mysqli_close($conn);
?>


<!--inster-->
<?php
if (isset($_POST["submit"])) {
    if (!empty($_POST["name"]) && !empty($_POST["last_name"]) && !empty($_POST["mail"]) && !empty($_POST["user"]) && !empty($_POST["password"])) {
        $name = $_POST["name"];
        $last_name = $_POST["last_name"];
        $mail = $_POST["mail"];
        $user = $_POST["user"];
        $password = $_POST["password"];
        $conn = mysqli_connect("localhost", "root", "", "uit");
        $query = "INSERT INTO users(IME, PREZIME, MAIL,USER_NAME,PASSWORD) VALUES('$name','$last_name','$mail','$user','$password')";
        $execute = mysqli_query($conn, $query);
        if ($execute) {
            echo '<span class="fieldset">SUCCESS</span>';
        }
    } else {
        echo '<span class="fieldset">ALL FIELDS  MUST BE FILLED UP</span>';
    }
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
            <form action="create.php" method="post">
                <table>
                    <tr><td class="L"> <span>Name:</span></td>
                        <td class="R"><input type="text" name="name"  placeholder="name"><br></td></tr>
                    <tr><td class="L"><span>Last name:</span></td>
                        <td class="R"><input  type="text" name="last_name"  placeholder="last name"><br></td></tr> 
                    <tr><td class="L"> <span>E-mail:</span></td>
                        <td class="R"> <input type="text" name="mail" placeholder="mail"><br></td></tr>
                    <tr><td class="L"> <span>User name:</span></td>
                        <td class="R"><input type="text" name="user" placeholder="username"><br></td></tr> 
                    <tr><td class="L"> <span>Password:</span></td>
                        <td class="R"> <input  type="password" name="password" ><br></td></tr>
                </table>
                <input id="dugme" type="Submit" name="submit">
            </form>
        </div>
    </body>
</html>