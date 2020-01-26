<?php require_once ("../Include/DB.php"); ?>
<?php require_once("../Include/Sessions.php"); ?>
<?php require_once("../Include/Function.php"); ?>
<?php Confirm_Login(); ?>
<?php
if (filter_input(INPUT_POST, 'Submit')) {
    $Title = mysqli_real_escape_string($conn, filter_input(INPUT_POST, "Title"));
    $Category = mysqli_real_escape_string($conn, filter_input(INPUT_POST, "Category"));
    $Post = mysqli_real_escape_string($conn, filter_input(INPUT_POST, "Post"));
    date_default_timezone_set("Europe/Belgrade");
    $CurentTime = time();
    $DateTime = strftime("%d-%B-%Y %H:%M:%S", $CurentTime);
    $DateTime;
    $Admin = $_SESSION["Username"];
    $Image = $_FILES["Image"]['name'];
    $Target = "../Upload/" . basename($_FILES["Image"]['name']);

//------------------------VALIDACIJE--------------------------------
    if (empty($Title)) {
        $_SESSION["ErrorMesage"] = "Title can't be empty";
        Redirect_to("Add_New_Post.php");
    } elseif (strlen($Title) < 2) {
        $_SESSION["ErrorMesage"] = "Title is too short";
        Redirect_to("Add_New_Post.php");
    } elseif (strlen($Title) >  199) {
        $_SESSION["ErrorMesage"] = "Title is too short, add at least 10 characterts";
        Redirect_to("Add_New_Post.php");
    } elseif (empty($Post)) {
        $_SESSION["ErrorMesage"] = "Post can't be empty";
        Redirect_to("Add_New_Post.php");
    } elseif (strlen($Post) < 10) {
        $_SESSION["ErrorMesage"] = "Post is too short, add at least 10 characters";
        Redirect_to("Add_New_Post.php");
    } elseif (strlen($Post) > 9999) {
        $_SESSION["ErrorMesage"] = "Post si too long";
        Redirect_to("Add_New_Post.php");
    } else {           //----------------IZVRSENJE------------------------
        global $conn;
        $query = "INSERT INTO admin_panel(DATETIME, TITLE, CATEGORY,AUTHOR, IMAGE, POST) VALUES('$DateTime','$Title','$Category','$Admin','$Image','$Post')";
        $execute = mysqli_query($conn, $query);
        move_uploaded_file($_FILES["Image"]["tmp_name"], $Target);
        if ($execute) {
            $_SESSION["SuccessMessage"] = "Post Added successfully";
            Redirect_to("Add_New_Post.php");
        } else {
            $_SESSION["ErrorMesage"] = "Somethong Wnet Wrong, Try Again";
            Redirect_to("Add_New_Post.php");
        }
    }
}
?>
<!DOCTYPE html>
<head>
    <title>New Post</title>
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
    <h3 style="margin-left: 5%;">Add New Post</h3>
    <div><?php
        echo Message();
        echo SuccessMessage();
        ?></div>
    <div>
        <form style="margin-left: 5%;" action="Add_New_Post.php" method="post" enctype="multipart/form-data">
            <fieldset>
                <div>
                    <label for="title">Title:</label>
                    <input type="text" name="Title" id="title" placeholder="Title"> 
                </div>
                <br>
                <div>
                    <label for="categoryselect">Category</label>
                    <select id="categoryselect" name="Category">
                        <?php
                        $conn = mysqli_connect("localhost", "root", "", "uit");
                        $Viewquery = "SELECT * FROM category ORDER BY DATETIME desc";
                        $execute = mysqli_query($conn, $Viewquery);
                        while ($DataRows = mysqli_fetch_array($execute)) {
                            $ID = $DataRows["ID"];
                            $CategoryName = $DataRows["NAME"];
                            ?>
                            <option><?php echo $CategoryName; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <br>
                <div>
                    <label for="imageselect">Select Image:</label>
                    <input type="File" name="Image" id="imageselect">
                </div>
                <br>
                <div>
                    <label for="postarea">Post:</label></br>
                    <textarea style="width:300px" name="Post" id="postarea"></textarea>
                </div>
                <br>
                <input type="Submit" name="Submit" value="Add New Post">
            </fieldset>
        </form>
    </div>
</body>