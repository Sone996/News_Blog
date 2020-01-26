<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/ProjectUIT/Include/DB.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/ProjectUIT/Include/Sessions.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/ProjectUIT/Include/Function.php'; ?>
<?php Confirm_Login(); ?>
<!DOCTYPE html> 
<html>
    <head>
        <title>View from DB</title>
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
        <table style="margin-left: 5%;" class="mdl-data-table mdl-js-data-table mdl-data-table--selectable mdl-shadow--2dp">
            <h3 style="margin-left: 5%">Users</h3>
            <tr>
                <th>ID</th>
                <th>NAME</th>
                <th>LAST NAME</th>
                <th>MAIL</th>
                <th>USERNAME</th>
                <th>PASSWORD</th>
                <th>DELETE</th>
                <th>UPDATE</th>
            </tr>
            <?php
            $conn = mysqli_connect("localhost", "root", "", "uit");
            $Viewquery = "SELECT * FROM users";
            $execute = mysqli_query($conn, $Viewquery);
            while ($DataRows = mysqli_fetch_array($execute)) {
                $ID = $DataRows['ID'];
                $Name = $DataRows['IME'];
                $LastName = $DataRows['PREZIME'];
                $Mail = $DataRows['MAIL'];
                $User = $DataRows['USER_NAME'];
                $Password = $DataRows['PASSWORD'];
                ?>
                <tr>
                    <td><?php echo $ID; ?></td>
                    <td><?php echo $Name; ?></td>
                    <td><?php echo $LastName; ?></td>
                    <td><?php echo $Mail; ?></td>
                    <td><?php echo $User; ?></td>
                    <td><?php echo $Password; ?></td> 
                    <td><a href="Delete.php?Delete=<?php echo $ID; ?>">DELETE</a></td>
                    <td><a href="Update.php?Update=<?php echo $ID; ?>">UPDATE</a></td>
                </tr>
            <?php } ?>
        </table>
    </body>

</html>