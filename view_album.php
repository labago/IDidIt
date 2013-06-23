<?php include("functions.php"); ?>
<html>
  <title>IDidIt - Album View</title>
  <head>
    <link href="styles/style.css" rel="stylesheet" type="text/css">
  </head>
  <script type="text/javascript" src="scripts/jquery.js"></script>
  <body>
    <?php include("Components/header.php"); ?>

    <div class="content">
      <div class="main-content">
        <h1>View Album</h1>
        <br><br><br>

        <?php

              $goal = $_GET['g'];

              $goal_info = fetch_user_goal($goal);
              $album_info = fetch_album($goal_info[8]);

              $fb_pics = $album_info[5];
              $fb_pics = str_replace('"', "", substr($fb_pics, 4));
              $fb_pics = substr($fb_pics, 0, (strlen($fb_pics)-1));
              $fb_pics = explode(",", $fb_pics);

              $local_pics = $album_info[2];
              $local_pics = str_replace('"', "", substr($local_pics, 4));
              $local_pics = substr($local_pics, 0, (strlen($local_pics)-1));
              $local_pics = explode(",", $local_pics);

              echo '<div class="photo-selector">';
              foreach ($fb_pics as $image) 
              {
                echo "<div class='photo-select'><img src='".$image."' class='not-selected'></div>";
              }
              foreach ($local_pics as $image) 
              {
                echo "<div class='photo-select'><img src='".$image."' class='not-selected'></div>";
              }
              echo '</div>'; 
        ?>

      </div>
    </div>
    <script type="text/javascript" src="scripts/functions.js"></script>
    <?php include("Components/footer.php"); ?>
  </body>
</html>