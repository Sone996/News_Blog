<?php require_once ("../Include/DB.php"); ?>
<?php require_once("../Include/Sessions.php"); ?>
<?php require_once("../Include/Function.php"); ?>
<?php Confirm_Login(); ?>
<?php Confirm_Admin();?>
<?php
if (filter_input(INPUT_POST, 'Submit')) {
    $UserName = mysqli_real_escape_string($conn, filter_input(INPUT_POST, "Username"));
    $Password = mysqli_real_escape_string($conn, filter_input(INPUT_POST, "Password"));
    $ConfirmPassword = mysqli_real_escape_string($conn, filter_input(INPUT_POST, "ConfirmPassword"));
    date_default_timezone_set("Europe/Belgrade");
    $CurentTime = time();
    $DateTime = strftime("%d-%B-%Y %H:%M:%S", $CurentTime);
    $DateTime;
    $Admin = $_SESSION["Username"];
    if (empty($UserName)) {
        $_SESSION["ErrorMesage"] = "All Fields must be filled ccccccccc";
        Redirect_to("Admins.php");
    } elseif (strlen($UserName) > 99) {
        $_SESSION["ErrorMesage"] = "Name is too long";
        Redirect_to("Admins.php");
    } elseif (strlen($UserName) < 4) {
        $_SESSION["ErrorMesage"] = "Name is too short, atleast 4 characters";
        Redirect_to("Admins.php");
    } elseif (empty($Password)) {
        $_SESSION["ErrorMesage"] = "All Fields must be filled  ffffffff";
        Redirect_to("Admins.php");
    } elseif (strlen($Password) > 99) {
        $_SESSION["ErrorMesage"] = "Password is too long";
        Redirect_to("Admins.php");
    } elseif (strlen($Password) < 4) {
        $_SESSION["ErrorMesage"] = "Password is too short, atleast 4 characters";
        Redirect_to("Admins.php");
    } elseif (empty($ConfirmPassword)) {
        $_SESSION["ErrorMesage"] = "All Fields must be filled   mmmmmm";
        Redirect_to("Admins.php");
    } elseif ($Password !== $ConfirmPassword) {
        $_SESSION["ErrorMesage"] = "Password does not match";
        Redirect_to("Admins.php");
    } else {
        global $conn;
        $query = "INSERT INTO registration(DATETIME, USERNAME, PASSWORD, ADDEDBY) VALUES('$DateTime','$UserName','$Password','$Admin')";
        $execute = mysqli_query($conn, $query);
        if ($execute) {
            $_SESSION["SuccessMessage"] = "Addmin Added Successfully";
            Redirect_to("Admins.php");
        } else {
            $_SESSION["ErrorMesage"] = "Admin failed to add";
            Redirect_to("Admins.php");
        }
    }
}
?>
<!DOCTYPE html>
<head>
    <title>Manage Admins</title>
    <link rel="stylesheet" type="text/css" href="CSS/index.css">
    <link rel="stylesheet" href="../material.min.css">
    <script src="../material.min.js"></script>
    <style>
        .nav{
            width: 100%; 
            height: 10vh; 
            border: 1px solid black; 
        }
        ul {
            list-style-type: none;
            margin: 0;
            margin-right: 3%;
            padding: 0;
            overflow: hidden;
        }
        li {
            display: inline-block;
        }
        li a {
            display: block;
            color: #666;
            text-align: center;
            padding: 10px 25px;
            text-decoration: none;
            font-weight: bold;
            font-size: 1.25em;
        }
    </style>
</head>
<body>
    <div id=nav>
        <ul>
            <li><a href="DB_view.php">DB view</a></li>
            <li><a href="Categories.php">Categories</a></li>
            <li><a href="Dashboard.php">Dashboard</a></li>
            <li><a href="Add_New_Post.php">Add New Post</a></li>
            <li><a href="Comments.php">Comments</a></li>
            <li><a href="Admins.php">Manage Admins</a></li>
            <li><a href="LogoutAdmin.php">Logout</a></li>
        </ul>
    </div>
    <h3 style="margin-left:5%">Manage Admins</h3>
    <div>
        <form style="margin-left:5%; line-height: 250%" action="Admins.php" method="post">
            <fieldset>
                <label for="Username">UserName:</label>
                <input type="text" name="Username" id="Username" placeholder="UserName"> <br>             
                <label for="Password">Password:</label>
                <input type="password" name="Password" id="Password" placeholder="Password"> <br>            
                <label for="ConfirmPassword">Confirm Password:</label>
                <input type="password" name="ConfirmPassword" id="ConfirmPassword" placeholder="Confirm password"> <br>               
                <input type="Submit" name="Submit" value="Add New Admin">
            </fieldset>
        </form>
    </div>
    <div><?php
        echo Message();
        echo SuccessMessage();
        ?></div>
    <div>
        <table style="margin-left:5%; line-height: 200%">
            <tr>
                <th>Number</th>
                <th>Date and Time</th>
                <th>Admin Name</th>
                <th>Added By</th>
                <th>Action</th>
            </tr>
            <?php
            $conn = mysqli_connect("localhost", "root", "", "uit");
            $Viewquery = "SELECT * FROM registration ORDER BY DATETIME desc";
            $execute = mysqli_query($conn, $Viewquery);
//            PROVERA***********************************
            if (!$execute) {
                printf("Error: %s\n", mysqli_error($conn));
                exit();
            }
            $number = 0;
            while ($DataRows = mysqli_fetch_array($execute)) {
                $ID = $DataRows["ID"];
                $DateTime = $DataRows["DATETIME"];
                $UserName = $DataRows["USERNAME"];
                $Admin = $DataRows["ADDEDBY"];
                $number++;
                ?>
                <tr>
                    <td><?php echo $number; ?></td>
                    <td><?php echo $DateTime; ?></td>
                    <td><?php echo $UserName; ?></td>
                    <td><?php echo $Admin; ?></td>
                    <td><a href="Delete_Admin.php?id=<?php echo $ID; ?>">Delete</a></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>