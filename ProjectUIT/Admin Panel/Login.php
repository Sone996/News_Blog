<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/ProjectUIT/Include/DB.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/ProjectUIT/Include/Sessions.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/ProjectUIT/Include/Function.php'; ?>
<?php
if (filter_input(INPUT_POST, 'Submit')) {
    $UserName = mysqli_real_escape_string($conn, filter_input(INPUT_POST, "Username"));
    $Password = mysqli_real_escape_string($conn, filter_input(INPUT_POST, "Password"));

    if (empty($UserName)) {
        $_SESSION["ErrorMesage"] = "All Fields must be filled";
        Redirect_to("Login.php");
    } elseif (empty($Password)) {
        $_SESSION["ErrorMesage"] = "All Fields must be filled";
        Redirect_to("Login.php");
    } else {
        $Founds_Acconut = Login_Attempt($UserName, $Password);
        $_SESSION["User_ID"] = $Founds_Acconut["ID"];
        $_SESSION["Username"] = $Founds_Acconut["USERNAME"];
        if ($Founds_Acconut) {
            $_SESSION["SuccessMessage"] = "Welcome {$_SESSION["Username"]}";
            redirect_to("Dashboard.php");
        } else {
            $_SESSION["ErrorMessage"] = "Invalid Username or Password";
            redirect_to("Login.php");
        }
    }
}
?>
<!DOCTYPE html>
<head>
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <div>
        <form action="Login.php" method="post">
            <fieldset>
                <label for="Username">UserName:</label>
                <input type="text" name="Username" id="Username" placeholder="UserName"> <br>             
                <label for="Password">Password:</label>
                <input type="password" name="Password" id="Password" placeholder="Password"> <br>            
                <input type="Submit" name="Submit" value="Login">
            </fieldset>
        </form>
    </div>
    <div><?php
        echo Message();
        echo SuccessMessage();
        ?></div>
</body>