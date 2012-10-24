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
        <h1>Add Album</h1>
        <br><br><br>

        <?php

          $goal = $_GET['g'];

          if(isset($_COOKIE['user']))
          {

            if(!isset($_GET['id']))
            {

              $permissions = $facebook->api("/me/permissions");
              if (array_key_exists('user_photos', $permissions['data'][0])) 
              {
                  $user_albums = $facebook->api('/me/albums');

                  echo "<p>Pick which album you would like to add photos from</p><br>";

                  foreach ($user_albums['data'] as $album)
                  {
                    echo "<a href='add_album.php?g=".$goal."&id=".$album['id']."'>Go to ".$album['name']."</a><br><br>";
                  }

              }
              else
              {
                  $login_params = array(
                  'scope' => 'user_photos',
                  'redirect_uri' => "http://localhost/IDidIt/add_album.php"
                  );
                $loginUrl = $facebook->getLoginUrl($login_params);
                echo "<a href='".$loginUrl."'>Add an album (we need your permission)</a>";
              }
            }
            else
            {
              $album_id = $_GET['id'];

              $user_album = $facebook->api('/'.$album_id.'/photos');

              if(!isset($_GET['mode']))
                echo "<p>Click on the pictures you would like to add to this achievement, then click the 'Add Pictures' buttton.</p><br>";
              else
                echo "<p>Click on the pictures you would like to add to this achievement, then click the 'Update' button.</p><br>";

              if(!isset($_GET['mode']))
              {
                ?><br><br><div class='submit'><input type='submit' value='Add Pictures!' onclick='get_and_add_pictures("<?php echo $goal; ?>", "<?php echo $album_id; ?>")'></div><?php
              }
              else
              {
                ?><br><br><div class='submit'><input type='submit' value='Update' onclick='get_and_add_pictures("<?php echo $goal; ?>", "<?php echo $album_id; ?>")'></div><?php
              }
              echo "<br>";
              echo "<br>";
              echo "<br>";
              echo "<input type='submit' value='Select All' onclick='select_all_pics_toggle()'>";

              echo '<div class="photo-selector">';

              $goal_info = fetch_user_goal($goal);

              $album = $goal_info[16];
              $album = explode(",", str_replace('"', "", substr($album, 4)));

              foreach ($user_album['data'] as $image) 
              {
                if(isset($_GET['mode']) && in_array($image['source'], $album))
                {
                  echo "<div class='photo-select'><a href='#'><img src='".$image['source']."' class='selected'></a></div>";
                }
                else
                {
                  echo "<div class='photo-select'><a href='#'><img src='".$image['source']."'></a></div>";
                }
              }
              echo '</div>'; 
            }
          }
          else
          {
            echo "Please login";
          }
    ?>

      </div>
    </div>
    <script type="text/javascript" src="scripts/functions.js"></script>
    <?php include("Components/footer.php"); ?>
  </body>
</html>