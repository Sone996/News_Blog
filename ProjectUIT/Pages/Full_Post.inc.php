<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/ProjectUIT/Include/DB.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/ProjectUIT/Include/Sessions.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/ProjectUIT/Include/Function.php'; ?>


<!DOCTYPE html>
<head>
    <title>Full Post</title>
    <style>
        #homeWrapper{
            margin:0% 10% 10% 10%;
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
        <a style="margin-bottom:20px; color:white" href="index.php?PageName=Home" class="mdl-button">Browse other posts</a>
        
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
                <form style="color:#FFF" method="post" enctype="multipart/form-data">
                    <fieldset>
                        <div>
                           <?php 
                                if(isset($_SESSION['Username']) ){
                                    echo '<label for="Name">Name: ' . $_SESSION['Username'] . '</label></br>';
                                    echo '<label for="commentarea">Comment:</label></br>';
                                    echo '<div style="width: 100%;color:white" class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">';
                                    echo '<input name="Comment" style="color:white;border-bottom:1px solid white;" class="mdl-textfield__input" type="text" id="commentarea">';
                                    echo '<label class="mdl-textfield__label" style="color:white;" for="sample3">Comment...</label>';
                                    echo '</div></br>';
                                    echo '<input type="Submit" name="commentSubmit" value="Comment">';
                                }
                                else{
                                    echo '<a href="#login">Login</a>';
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
