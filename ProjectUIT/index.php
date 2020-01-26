<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/ProjectUIT/Include/DB.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/ProjectUIT/Include/Sessions.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/ProjectUIT/Include/Function.php'; ?>
<?php
if (isset($_POST["Registrate"])) {
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
            header("Location: http://localhost/ProjectUIT/index.php?PageName=Home");
            exit;
        }
    } else {
        echo '<span class="fieldset">ALL FIELDS  MUST BE FILLED UP</span>';
    }
}
?>
<?php
// ZA DODAVANJE KOMENTARA

if (filter_input(INPUT_POST, 'commentSubmit')) {
    $Comment = mysqli_real_escape_string($conn, filter_input(INPUT_POST, "Comment"));
    date_default_timezone_set("Europe/Belgrade");
    $CurentTime = time();
    $DateTime = strftime("%d-%B-%Y %H:%M:%S", $CurentTime);
    $DateTime;
    $PostID = filter_input(INPUT_GET, "id");
//------------------------VALIDACIJE--------------------------------
    $Name = $_SESSION['Username'];
    if (empty($Name) || empty($Comment)) {
        $_SESSION["ErrorMesage"] = "All fields are required";
    } elseif (strlen($Comment) > 500) {
        $_SESSION["ErrorMesage"] = "Only 500 characters are allowed in comment";
    } else {           //----------------IZVRSENJE------------------------
        global $conn;
        $Post_ID_FROM_URL = filter_input(INPUT_GET, 'id');
        $query = "INSERT INTO cumments (DATETIME, NAME, COMMENTS, APPROVEDBY, STATUS, ADMIN_PANEL_ID) VALUES ('$DateTime', '$Name', '$Comment', 'Pending', 'OFF','$Post_ID_FROM_URL') ";
        $execute = mysqli_query($conn, $query);
        if ($execute) {
            $_SESSION["SuccessMessage"] = "Comment submited successfully";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        } else {
            $_SESSION["ErrorMesage"] = "Something Went Wrong, Try Again";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }
    }
}
?>
<?php
if (filter_input(INPUT_POST, 'Submit')) {
    $UserName = mysqli_real_escape_string($conn, filter_input(INPUT_POST, "Username"));
    $Password = mysqli_real_escape_string($conn, filter_input(INPUT_POST, "Password"));

    if (empty($UserName)) {
        $_SESSION["ErrorMesage"] = "All Fields must be filled";
        header("Location: " . $_SERVER['HTTP_REFERER']);
    } elseif (empty($Password)) {
        $_SESSION["ErrorMesage"] = "All Fields must be filled";
        header("Location: " . $_SERVER['HTTP_REFERER']);
    } else {
        // za admina
        $Founds_Acconut = Login_Attempt($UserName, $Password);
        $_SESSION["User_ID"] = $Founds_Acconut["ID"];
        $_SESSION["Username"] = $Founds_Acconut["USERNAME"];
        if ($Founds_Acconut) {
            $_SESSION["SuccessMessage"] = "Welcome {$_SESSION["Username"]}";
            redirect_to("Admin Panel/Dashboard.php");
        }
        // user
        $Founds_Acconut_User = Login_Attempt_User($UserName, $Password);
        $_SESSION["user_ID"] = $Founds_Acconut_User["ID"];
        $_SESSION["Username"] = $Founds_Acconut_User["USER_NAME"];

        if ($Founds_Acconut_User) {
            $_SESSION["SuccessMessage"] = "Welcome {$_SESSION["Username"]}";
            header("Location: " . $_SERVER['HTTP_REFERER']);
        } else {

            $_SESSION["ErrorMessage"] = "Invalid Username or Password";
            redirect_to("index.php");
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Projekat</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="CSS/index.css">
        <link rel="stylesheet" href="./material.min.css">
        <script src="./material.min.js"></script>
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    </head>
    <body>

        <style>
            .demo-layout-transparent .mdl-layout__header,
            .demo-layout-transparent .mdl-layout__drawer-button {
                color: white;
            }
            #bg{
                position: fixed;
                width: 100%;
                min-height: 100vh ;
                background-image: url("images/premier_league_wallpaper_by_gio0989.jpg");
                background-size: cover;
                background-repeat: no-repeat;
                background-position: top;
                background-attachment: fixed;
                /*                -webkit-filter: blur(5px);
                                -moz-filter: blur(5px);
                                -o-filter: blur(5px);
                                -ms-filter: blur(5px);
                                filter: blur(5px);*/
                z-index: -1;
            }
            #footer{
                text-align: center;
            }
        </style>
        <div id="bg"></div>
        <div class="demo-layout-transparent mdl-layout mdl-js-layout">
            <header class="mdl-layout__header mdl-layout__header--transparent">
                <div class="mdl-layout__header-row">
                    <!-- Title -->
                    <span class="mdl-layout-title">Premier League</span>
                    <!-- Add spacer, to align navigation to the right -->
                    <div class="mdl-layout-spacer"></div>
                    <!-- Navigation -->
                    <nav class="mdl-navigation">
                        <?php if (!isset($_SESSION['Username'])) : ?>
                            <a class="mdl-navigation__link" href="?PageName=Create">Sign up</a>
                            <a class="mdl-navigation__link show-modal" href="#">Sign in</a>
                        <?php endif; ?>
                        <?php if (isset($_SESSION['Username'])) : ?>
                            <a class="mdl-navigation__link" href="?PageName=Account_Info">Account Info</a>
                            <a class="mdl-navigation__link show-modal" href="Admin Panel/Logout.php">Sign out</a>
                        <?php endif; ?>
                    </nav>
                </div>
            </header>
            <div class="mdl-layout__drawer">
                <span class="mdl-layout-title">Pages</span>
                <nav class="mdl-navigation">
                    <a class="mdl-navigation__link" href="index.php?PageName=Home">Home</a>
                    <a class="mdl-navigation__link" href="index.php?PageName=About">About</a>
                    <a class="mdl-navigation__link" href="index.php?PageName=Galery">Galerija</a>
                    <a class="mdl-navigation__link" href="index.php?PageName=Contact">Contact</a>
                </nav>
            </div>
            <main class="mdl-layout__content">
            </main>
        </div>
        <div id="main"></div>


        <div id="login">

            <dialog class="mdl-dialog">
                <form id="loginForm" action="index.php" method="post">
                    <fieldset>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="max-width:90%">
                            <input type="text" name="Username" id="Username" class="mdl-textfield__input" type="text" id="sample3">
                            <label class="mdl-textfield__label" for="sample3">Username...</label>  
                        </div>

                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="max-width:90%">
                            <input type="password" name="Password" id="Password" class="mdl-textfield__input" type="text" id="sample3">
                            <label class="mdl-textfield__label" for="sample3">Password...</label>  
                        </div>
                        <input type="Submit" name="Submit" value="Login" class="mdl-button mdl-button--colored">

                        <div class="mdl-button mdl-button--colored" onclick="dialog.close();" style="margin-right: 10%;float:right">Close</div>
                    </fieldset>
                </form>
            </dialog>
            <script>
                var dialog = document.querySelector('dialog');
                var showModalButton = document.querySelector('.show-modal');
                if (!dialog.showModal) {
                    dialogPolyfill.registerDialog(dialog);
                }
                showModalButton.addEventListener('click', function () {
                    dialog.showModal();
                });
                dialog.querySelector('.close').addEventListener('click', function () {
                    dialog.close();
                });
            </script>
        </div>
        <div id="content" style="background-color: rgba(10,10,10,0.7);">
            <?php
            if (!empty($_GET['PageName'])) {
                $folder = 'Pages';
                $pages = scandir($folder, 0);
                $PageName = $_GET['PageName'];
                if (in_array($PageName . '.inc.php', $pages)) {
                    include($folder . '/' . $PageName . '.inc.php');
                }
            }
            ?>
            <div style="color: white; "><?php
                echo Message();
                echo SuccessMessage();
                ?></div>
        </div>
    </div>
    <div id="footer">
        <br><br>
        <p>Projekat iz predmeta programiranje veb aplikacija<br>
            ------------Autori: Nebojša Ilić RТ-11/15 & Predrag Ivanović RT-65/16------------</p>
    </div>
    <?php
    ?>
</body>
</html>
