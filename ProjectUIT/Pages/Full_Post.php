<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/ProjectUIT/Include/DB.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/ProjectUIT/Include/Sessions.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/ProjectUIT/Include/Function.php'; ?>
<?php
// ZA DODAVANJE KOMENTARA
if (filter_input(INPUT_POST, 'Submit')) {
    $Name = mysqli_real_escape_string($conn, filter_input(INPUT_POST, "Name"));
    $Comment = mysqli_real_escape_string($conn, filter_input(INPUT_POST, "Comment"));
    date_default_timezone_set("Europe/Belgrade");
    $CurentTime = time();
    $DateTime = strftime("%d-%B-%Y %H:%M:%S", $CurentTime);
    $DateTime;
    $PostID = filter_input(INPUT_GET, "id");
//------------------------VALIDACIJE--------------------------------
    if (empty($Name) | empty($Comment)) {
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
            Redirect_to("Full_Post.php?id={$PostID}");
        } else {
            $_SESSION["ErrorMesage"] = "Somethong Wnet Wrong, Try Again";
            Redirect_to("Full_Post.php?id={$PostID} ");
        }
    }
}
?>

<!DOCTYPE html>
<head>
    <title>Full Post</title>
    <style>
        #homeWrapper{
            margin:10%;
        }
        #box{
            border: 1px solid white;
            margin-bottom: 20px;
        }
        img{
            min-width: 100%;
            height: 300px;
        }
    </style>
</head>
<body>
    <div id="homeWrapper">
        <h1>Full Post</h1>            
        <div><?php
            echo Message();
            echo SuccessMessage();
            ?></div>
        <div>
            <?php
            global $conn;
            $Post_ID_From_URL = filter_input(INPUT_GET, "id");
            $Viewquery = "SELECT * FROM admin_panel  WHERE ID = '$Post_ID_From_URL' ";
            $execute = mysqli_query($conn, $Viewquery);
            if (!$execute) {       //TEST***********************
                printf("Error: %s\n", mysqli_error($conn));
                exit();
            }
            while ($DataRows = mysqli_fetch_array($execute)) {
                $PostID = $DataRows ["ID"];
                $DateTime = $DataRows ["DATETIME"];
                $Title = $DataRows ["TITLE"];
                $Category = $DataRows ["CATEGORY"];
                $Admin = $DataRows ["AUTHOR"];
                $Image = $DataRows ["IMAGE"];
                $Post = $DataRows ["POST"];
                ?>
                <div> 
                    <img src="http://localhost/ProjectUIT/Upload/<?php echo $Image; ?>" alt="img"> 
                </div>
                <div>
                    <h1><?php echo htmlentities($Title); ?></h1> <!--htmlentities je da ne bi pukao html usled ekstraktovanja iz baze-->
                    <p>Category: <?php echo htmlentities($Category); ?><br>
                        <?php echo htmlentities($DateTime); ?></p>
                    <p><?php echo $Post; ?></p>
                </div>
            <?php } ?>
            <div>Comments:</div>
            <?php
            $conn;
            $Post_ID_for_Comments = filter_input(INPUT_GET, "id");
            $Extracting_Comments = "SELECT * FROM cumments WHERE ADMIN_PANEL_ID='$Post_ID_for_Comments' AND STATUS='ON' ";
            $Execute = mysqli_query($conn, $Extracting_Comments);
            if (!$Execute) {       //TEST***********************
                printf("Error: %s\n", mysqli_error($conn));
                exit();
            }
            while ($DataRows = mysqli_fetch_array($Execute)) {
                $CommentDate = $DataRows ["DATETIME"];
                $CommentName = $DataRows ["NAME"];
                $Comments = $DataRows ["COMMENTS"];
                ?>
                <div>
                    <p><?php echo $CommentName; ?></p>
                    <p><?php echo $CommentDate; ?></p>
                    <p><?php echo $Comments; ?></p>
                </div>
                <hr>
            <?php } ?>
            <!--FORMA ZA KOMENTARE-->
            <div> 
                <br>
                <span>Add New Comment:</span>
                <form action="Full_Post.php?id=<?php echo $PostID; ?>" method="post" enctype="multipart/form-data">
                    <fieldset>
                        <div>
                            </label>
                           <?php 
                                if(isset($_SESSION['Username']) ){
                                    echo '<label for="Name">Name: ' . $_SESSION['Username'] . '</label>';
                                    echo '<label for="commentarea">Comment:</label>';
                                    echo '<textarea  name="Comment" id="commentarea"></textarea>';
                                    echo '</br>';
                                    echo '<input type="Submit" name="Submit" value="Submit">';
                                }
                                else{
                                    echo '<a href="../index.php#loginForm">Login</a>';
                                }
                                    
                             ?>
                        </div>
                        <br>
                        <div>
                            
                            
                        </div>
                        
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</body>
