<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/ProjectUIT/Include/DB.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/ProjectUIT/Include/Sessions.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/ProjectUIT/Include/Function.php'; ?>
<?php Confirm_Login(); ?>
<!DOCTYPE html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="../CSS/DB_view.css">
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
            <li><a href="Admins.php">Manage Admins</a></li>
            <li><a href="LogoutAdmin.php">Logout</a></li>
        </ul>
    </div>
    <h3 style="margin-left: 5%;">Dashboard</h3>
    <div><?php
        echo Message();
        echo SuccessMessage();
        ?></div>
    <div>
        <table style="margin-left:5%" class="mdl-data-table mdl-js-data-table mdl-data-table--selectable mdl-shadow--2dp">
            <tr>
                <th>No</th>
                <th>Post Title</th>
                <th>Date and Time</th>
                <th>Author</th>
                <th>Category</th>
                <th>Banner</th>
                <th>Comments</th>
                <th>Action</th>
                <th>Details</th>
            </tr>
            <?php
            $conn;
            $Viewquery = "SELECT * FROM admin_panel ORDER BY DATETIME desc;";
            $execute = mysqli_query($conn, $Viewquery);
            if (!$execute) {       //TEST***********************
                printf("Error: %s\n", mysqli_error($conn));
                exit();
            }
            $NO = 0;
            while ($DataRows = mysqli_fetch_array($execute)) {
                $ID = $DataRows ["ID"];
                $DateTime = $DataRows ["DATETIME"];
                $Title = $DataRows ["TITLE"];
                $Category = $DataRows ["CATEGORY"];
                $Admin = $DataRows ["AUTHOR"];
                $Image = $DataRows ["IMAGE"];
                $Post = $DataRows ["POST"];
                $NO++;
                ?>
                <tr>
                    <td><?php echo $NO; ?></td>
                    <td><?php
                        if (strlen($Title) > 20) {
                            $Title = substr($Title, 0, 20) . '..';
                        }
                        echo $Title;
                        ?></td>
                    <td><?php echo $DateTime; ?></td>
                    <td><?php echo $Admin; ?></td>
                    <td><?php echo $Category; ?></td>
                    <td><img src = "http://localhost/ProjectUIT/Upload/<?php echo $Image; ?>" alt="img" ></td>
                    <td>
                        <?php
                        $conn;
                        $Query_Approved = "SELECT COUNT(*) FROM cumments WHERE ADMIN_PANEL_ID='$ID' AND STATUS='ON' ";
                        $Execute_Approved = mysqli_query($conn, $Query_Approved);
                        $Rows_Approved = mysqli_fetch_array($Execute_Approved);
                        $Total_Approved = array_shift($Rows_Approved);
                        if ($Total_Approved > 0) {
                            ?>
                            <span style="background-color: green; color:white; padding: 4px; float:left; margin-left: 5px"> <?php echo $Total_Approved; ?></span>
                        <?php } ?>
                        <?php
                        $conn;
                        $Query_Un_Approved = "SELECT COUNT(*) FROM cumments WHERE ADMIN_PANEL_ID='$ID' AND STATUS='OFF' ";
                        $Execute_Un_Approved = mysqli_query($conn, $Query_Un_Approved);
                        $Rows_Un_Approved = mysqli_fetch_array($Execute_Un_Approved);
                        $Total_Un_Approved = array_shift($Rows_Un_Approved);
                        if ($Total_Un_Approved > 0) {
                            ?>
                            <span style="background-color: red; color:white; padding: 4px; float:right; margin-right: 5px;"> <?php echo $Total_Un_Approved; ?></span>
                        <?php } ?>
                    </td>
                    <td><a href='Edit_Post.php?Edit=<?php echo $ID; ?>' target="_blank"><span>Edit</span></a>
                        <a href='Delete_Post.php?Delete=<?php echo $ID; ?>' target="_blank"><span>Delete</span></a></td>
                    <td><span><a href='../index.php?PageName=Full_Post&id=<?php echo $ID; ?>' target="_blank">Preview</a></span></td>
                </tr>
            <?php } ?>
        </table>
    </div>  
</body>
