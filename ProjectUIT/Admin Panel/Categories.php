<?php require_once ("../Include/DB.php"); ?>
<?php require_once("../Include/Sessions.php"); ?>
<?php require_once("../Include/Function.php"); ?>
<?php Confirm_Login(); ?>
<?php
if (filter_input(INPUT_POST, 'Submit')) {
    $Category = mysqli_real_escape_string($conn, filter_input(INPUT_POST, "Category"));
    date_default_timezone_set("Europe/Belgrade");
    $CurentTime = time();
    $DateTime = strftime("%d-%B-%Y %H:%M:%S", $CurentTime);
    $DateTime;
    $Admin = $_SESSION["Username"];
    if (empty($Category)) {
        $_SESSION["ErrorMesage"] = "All Fields must be filled";
        Redirect_to("Categories.php");
    } elseif (strlen($Category) > 99) {
        $_SESSION["ErrorMesage"] = "Name is too long";
        Redirect_to("Categories.php");
    } else {
        global $conn;
        $query = "INSERT INTO category(DATETIME, NAME, CREATORNAME) VALUES('$DateTime','$Category','$Admin')";
        $execute = mysqli_query($conn, $query);
        if ($execute) {
            $_SESSION["SuccessMessage"] = "Success";
            Redirect_to("Categories.php");
        } else {
            $_SESSION["ErrorMesage"] = "Categorie failed to add";
            Redirect_to("Categories.php");
        }
    }
}
?>
<!DOCTYPE html>
<head>
    <title>Manage Categoies</title>
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
    <h3 style="margin-left: 5%;">Create a category</h3>
    <div>
        <form style="margin-left: 5%;line-height: 250%;" action="Categories.php" method="post">
            <fieldset>
                <label for="categoryname">Name:</label>
                <input type="text" name="Category" id="categoryname" placeholder="Name"> <br>
                <input type="Submit" name="Submit" value="Add New Categoty">
            </fieldset>
        </form>
    </div>
    <div><?php
        echo Message();
        echo SuccessMessage();
        ?></div>
    <div>
        <table style="margin-left: 5%; line-height: 200%;" >
            <tr>
                <th>Number</th>
                <th>Date and Time</th>
                <th>Category name</th>
                <th>Creator Name</th>
                <th>Action</th>
            </tr>
            <?php
            $conn = mysqli_connect("localhost", "root", "", "uit");
            $Viewquery = "SELECT * FROM category ORDER BY DATETIME desc";
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
                $CategoryName = $DataRows["NAME"];
                $CreatorName = $DataRows["CREATORNAME"];
                $number++;
                ?>
                <tr>
                    <td><?php echo $number; ?></td>
                    <td><?php echo $DateTime; ?></td>
                    <td><?php echo $CategoryName; ?></td>
                    <td><?php echo $CreatorName; ?></td>
                    <td><a href="Delete_Category.php?id=<?php echo $ID; ?>">Delete</a></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>