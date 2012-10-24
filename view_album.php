<?php include("functions.php"); ?>
<html>
  <title>IDidIt</title>
  <head>
    <link href="styles/style.css" rel="stylesheet" type="text/css">
  </head>
  <script type="text/javascript" src="scripts/jquery.js"></script>
  <body>
    <?php include("Components/header.php"); ?>

    <div class="page">
      <div class="content">
        <h1>View Album</h1>
        <br><br><br>

        <?php

              $goal = $_GET['g'];

              $goal_info = fetch_user_goal($goal);

              $album = $goal_info[16];
              $album = str_replace('"', "", substr($album, 4));
              $album = substr($album, 0, (strlen($album)-1));
              $album = explode(",", $album);

              echo '<div class="photo-selector">';
              foreach ($album as $image) 
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