<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/ProjectUIT/Include/DB.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/ProjectUIT/Include/Sessions.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/ProjectUIT/Include/Function.php'; ?>
<?php Confirm_Login(); ?>
<!DOCTYPE html>
<head>
    <title>Manage Comments</title>
    <link rel="stylesheet" type="text/css" href="CSS/index.css">
    <link rel="stylesheet" href="../material.min.css">
    <script src="../material.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../CSS/DB_view.css">
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
    <div><?php
        echo Message();
        echo SuccessMessage();
        ?></div>
    <h3 style="margin-left:5%">Unapproved Comments</h3>
    <div>
        <table style="margin-left:5%" class="mdl-data-table mdl-js-data-table mdl-data-table--selectable mdl-shadow--2dp">
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Date and Time</th>
                <th>Comment</th>
                <th>Approve</th>
                <th>Delete</th>
                <th>Details</th>
            </tr>
            <?php
            $conn;
            $query = "SELECT * FROM cumments WHERE STATUS='OFF' ORDER BY DATETIME desc";
            $execute = mysqli_query($conn, $query);
            $number = 0;
            while ($DataRows = mysqli_fetch_array($execute)) {
                $CommentID = $DataRows['ID'];
                $DateTimeComment = $DataRows['DATETIME'];
                $PersonName = $DataRows['NAME'];
                $PersonComment = $DataRows['COMMENTS'];
                $CommentPostID = $DataRows['ADMIN_PANEL_ID'];
                $number++;
                if (strlen($PersonComment) > 20) {
                    $PersonComment = substr($PersonComment, 0, 20) . '..';
                }
                if (strlen($PersonName) > 20) {
                    $PersonName = substr($PersonName, 0, 20) . '..';
                }
                ?>
                <tr>
                    <td><?php echo htmlentities($number); ?></td>
                    <td><?php echo htmlentities($PersonName); ?></td>
                    <td><?php echo htmlentities($DateTimeComment); ?></td>
                    <td><?php echo htmlentities($PersonComment); ?></td>
                    <td><a href="ApproveComments.php?id=<?php echo $CommentID; ?>">Approve</a></td>
                    <td><a href="Delete_Comments.php?id=<?php echo $CommentID; ?>">Delete</a></td>
                    <td><a href="http://localhost/ProjectUIT/index.php?PageName=Full_Post&id=<?php echo $CommentPostID; ?>" target="_blank">Details</a></td>
                </tr>
            <?php } ?>
        </table>
    </div>

    <h3 style="margin-left:5%">Approved Comments</h3>
    <div>
        <table style="margin-left: 5%;margin-bottom:50px;" class="mdl-data-table mdl-js-data-table mdl-data-table--selectable mdl-shadow--2dp">
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Date and Time</th>
                <th>Comment</th>
                <th>Approbed By</th>
                <th>Approved by</th>
                <th>Revert Approve</th>
                <th>Delete</th>
                <th>Details</th>
            </tr>
            <?php
            $conn;
            $Admin = "Nebojša Ilić";
            $query = "SELECT * FROM cumments WHERE STATUS='ON' ORDER BY DATETIME desc";
            $execute = mysqli_query($conn, $query);
            $number = 0;
            while ($DataRows = mysqli_fetch_array($execute)) {
                $CommentID = $DataRows['ID'];
                $DateTimeComment = $DataRows['DATETIME'];
                $PersonName = $DataRows['NAME'];
                $PersonComment = $DataRows['COMMENTS'];
                $ApprovedBy = $DataRows['APPROVEDBY'];
                $CommentPostID = $DataRows['ADMIN_PANEL_ID'];
                $number++;
                if (strlen($PersonComment) > 20) {
                    $PersonComment = substr($PersonComment, 0, 20) . '..';
                }
                if (strlen($PersonName) > 20) {
                    $PersonName = substr($PersonName, 0, 20) . '..';
                }
                ?>
                <tr>
                    <td><?php echo htmlentities($number); ?></td>
                    <td><?php echo htmlentities($PersonName); ?></td>
                    <td><?php echo htmlentities($DateTimeComment); ?></td>
                    <td><?php echo htmlentities($PersonComment); ?></td>
                    <td><?php echo htmlentities($ApprovedBy); ?></td>
                    <td><?php echo $Admin; ?></td>
                    <td><a href="Dis-Approve_Comments.php?id=<?php echo $CommentID; ?>">Disapprove</a></td>
                    <td><a href="Delete_Comments.php?id=<?php echo $CommentID; ?>">Delete</a></td>
                    <td><a href="../Pages/Full_Post.php?id=<?php echo $CommentPostID; ?>" target="_blank">Details</a></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
