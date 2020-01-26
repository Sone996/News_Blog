<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/ProjectUIT/Include/DB.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/ProjectUIT/Include/Sessions.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/ProjectUIT/Include/Function.php'; ?>

<style>
    #homeWrapper{
        margin:0% 10% 10% 10%;
    }
    .box{
        border: 1px solid white;
        margin-bottom: 20px;
    }
    img{
        min-width: 100%;
        height: 300px;
    }
    
    .demo-card-wide.mdl-card {
      width: 100%;
      margin-bottom: 30px;
    }
    .demo-card-wide > .mdl-card__title {
      color: #fff;
      height: 176px;
    }
    .demo-card-wide > .mdl-card__menu {
      color: #fff;
    }
</style>
<div id="homeWrapper">
    <h1>Blog</h1>
    <div>
        <?php
        $numberToLoad = filter_input(INPUT_GET, 'load');
        if ($numberToLoad == NULL){
            $numberToLoad = 3;
        }
        global $conn;
        $Viewquery = "SELECT * FROM admin_panel ORDER BY DATETIME desc LIMIT " . $numberToLoad;
        $postCountQuery = "SELECT COUNT(*) FROM admin_panel";
        $postCount = mysqli_query($conn, $postCountQuery);
        $execute = mysqli_query($conn, $Viewquery);
        $Rows_Approved = mysqli_fetch_array($postCount);
        $Total_Count = array_shift($Rows_Approved);
        
        if (!$execute) {       //TEST***********************
            printf("Error: %s\n", mysqli_error($conn));
            exit();
        }
        $count = 0;
        while ($DataRows = mysqli_fetch_array($execute)) {
            $PostID = $DataRows ["ID"];
            $DateTime = $DataRows ["DATETIME"];
            $Title = $DataRows ["TITLE"];
            $Category = $DataRows ["CATEGORY"];
            $Admin = $DataRows ["AUTHOR"];
            $Image = $DataRows ["IMAGE"];
            $Post = $DataRows ["POST"];
            $count += 1;
            ?>
            <div id="post<?php echo $count; ?>" class="inlineBlock">
                <div class="demo-card-wide mdl-card mdl-shadow--2dp" >
                <div class="mdl-card__title" style="background: url('http://localhost/ProjectUIT/Upload/<?php echo $Image; ?>') center / cover;">
                  <h2 class="mdl-card__title-text"><?php echo htmlentities($Title); ?></h2>
                </div>
                <div class="mdl-card__supporting-text">
                  <?php
                                      if (strlen($Post) > 150) {
                                          $Post = substr($Post, 0, 150) . '...';
                                      }
                                      echo $Post;
                                      ?>
                    <p>
                </div>
                <div class="mdl-card__actions mdl-card--border">
    <a href="?PageName=Full_Post&id=<?php echo $PostID; ?> " class="mdl-button mdl-button--colored mdl-js-button mdl-js-
ripple-effect">
      Read More 
    </a>
   <div style="float:right; color:#555;">Category: <?php echo htmlentities($Category); ?><br><?php echo htmlentities($DateTime); ?></div>
  </div>
  <div class="mdl-card__menu">
    <button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect">
      <i class="material-icons">share</i>
    </button>
  </div>
</div>
            </div>
        <?php } ?>
        <?php
        if ($Total_Count >= $numberToLoad) {
            echo '<a href=index.php?PageName=Home&load=' . ($numberToLoad + 2) . '#post' . ($numberToLoad ) . '>Load More</a>';
        }
        ?>
    </div>
</div>
