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
              $user_album = $facebook->api('/'.$_GET['id'].'/photos');

              echo '<div class="photo-selector">';
              foreach ($user_album['data'] as $image) 
              {
                echo "<div class='photo-select'><a href='#'><img src='".$image['source']."' class='not-selected'></a></div>";
              }
              echo '</div>'; 

              ?><br><br><div class='submit'><input type='submit' value='Add Pictures!' onclick='get_and_add_pictures("<?php echo $goal; ?>")'></div><?php

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