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
    $Admin = "Nebojsa Ilic";
    $Image = $_FILES["Image"]['name'];
    $Target = "../Upload/" . basename($_FILES["Image"]['name']);

    //----------------IZVRSENJE------------------------
    global $conn;
    $Delete_FromURL = filter_input(INPUT_GET, 'Delete');
    $query = "DELETE FROM admin_panel WHERE id='$Delete_FromURL' ";
    $execute = mysqli_query($conn, $query);
    move_uploaded_file($_FILES["Image"]["tmp_name"], $Target);
    if ($execute) {
        $_SESSION["SuccessMessage"] = "Post Deleted successfully";
        Redirect_to("Add_New_Post.php");
    } else {
        $_SESSION["ErrorMesage"] = "Somethong Wnet Wrong, Try Again";
        Redirect_to("Add_New_Post.php");
    }
}
?>
<!DOCTYPE html>
<head>
    <title>Edit Post</title>
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
        img{
            height: 50px;
            width: 170px;
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
        </ul>
    </div>
    <h1>Delete Post</h1>
    <div><?php
        echo Message();
        echo SuccessMessage();
        ?></div>
    <div>
        <?php
        // uzimanje podataka
        $conn;
        $Search = filter_input(INPUT_GET, "Delete");
        $query = "SELECT * FROM admin_panel  WHERE ID = '$Search' ";
        $execute_query = mysqli_query($conn, $query);
        if (!$execute_query) {       //TEST***********************
            printf("Error: %s\n", mysqli_error($conn));
            exit();
        }
        while ($DataRows = mysqli_fetch_array($execute_query)) {
            $Title_Update = $DataRows['TITLE'];
            $Category_Update = $DataRows['CATEGORY'];
            $Image_Update = $DataRows['IMAGE'];
            $Post_Update = $DataRows['POST'];
        }
        ?>
        <form action="Delete_Post.php?Delete=<?php echo $Search; ?>" method="post" enctype="multipart/form-data">
            <fieldset>
                <div>
                    <label for="title">Title:</label>
                    <input disabled value="<?php echo $Title_Update; ?>" type="text" name="Title" id="title" placeholder="Title"> 
                </div>
                <br>
                <div>
                    <span>Existing category</span>
<?php echo $Category_Update; ?><br>
                    <label for="categoryselect">Category</label>
                    <select disabled id="categoryselect" name="Category">
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
                    <span>Existing image: </span>
                    <img src="../Upload/<?php echo $Image_Update; ?>"><br>
                    <label for="imageselect">Select Image:</label>
                    <input disabled type="File" name="Image" id="imageselect">
                </div>
                <br>
                <div>
                    <label for="postarea">Post:</label>
                    <textarea disabled name="Post" id="postarea"><?php echo $Post_Update; ?></textarea>
                </div>
                <br>
                <input type="Submit" name="Submit" value="Delete Post">
            </fieldset>
        </form>
    </div>
</body>