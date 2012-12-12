<?php include("functions.php"); ?>
<html>
  <title>IDidIt - Add Album</title>
  <head>
    <link href="styles/style.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="scripts/multi-upload-file/css/bootstrap.min.css">
    <!-- Bootstrap styles for responsive website layout, supporting different screen sizes -->
    <link rel="stylesheet" href="http://blueimp.github.com/cdn/css/bootstrap-responsive.min.css">
    <!-- Bootstrap CSS fixes for IE6 -->
    <!--[if lt IE 7]><link rel="stylesheet" href="http://blueimp.github.com/cdn/css/bootstrap-ie6.min.css"><![endif]-->
    <!-- Bootstrap Image Gallery styles -->
    <link rel="stylesheet" href="http://blueimp.github.com/Bootstrap-Image-Gallery/css/bootstrap-image-gallery.min.css">
    <!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
    <link rel="stylesheet" href="scripts/multi-upload-file/css/jquery.fileupload-ui.css">
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
              $user_info = fetch_user_info($_COOKIE['user']);

              $token = $user_info[7];

              $permissions = $facebook->api("/me/permissions", array('access_token' => $token));
              if (array_key_exists('user_photos', $permissions['data'][0])) 
              {
                  $user_albums = $facebook->api('/me/albums', array('access_token' => $token));

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

              $user_album = $facebook->api('/'.$album_id.'/photos', array('access_token' => $token));

              if(!isset($_GET['mode']))
                echo "<p>Click on the pictures you would like to add to this achievement, and upload any from your local computer, then click the 'Add Pictures' buttton.</p><br>";
              else
                echo "<p>Click on the pictures you would like to add to this achievement, and upload any from your local computer, then click the 'Update' button.</p><br>";
                if(!isset($_GET['mode']))
                {
                    $crypt = gen_rand_hex();  
                    while(!check_crypt($crypt, 'Album'))
                    {  
                      $crypt = gen_rand_hex();
                    }

                    setcookie("album_id", $crypt, time()+2592000);
                  ?><br><br><div class='submit'><input type='submit' value='Add Pictures!' onclick='get_and_add_pictures("<?php echo $goal; ?>", "<?php echo $album_id; ?>", "<?php echo $crypt; ?>")'></div><?php
                }
                else
                {
                  $album_info = fetch_album($goal);

                  $crypt = $album_info[0];

                  setcookie("album_id", $crypt, time()+2592000);
                  ?><br><br><div class='submit'><input type='submit' value='Update' onclick='get_and_add_pictures("<?php echo $goal; ?>", "<?php echo $album_id; ?>","<?php echo $crypt; ?>")'></div><?php
                }


              echo '<div class="fb-album-buttons">';
                echo "<input type='submit' value='Select All' onclick='select_all_pics_toggle()'>";
              echo '</div>';

              echo '<div style="display: block; clear: both;"></div>';
              echo '<div class="space"></div>';

              echo '<div class="photo-selector">';

              $goal_info = fetch_user_goal($goal);

              $album_info = fetch_album($goal_info[8]);

              if(isset($album_info[1]))
              {
                $fb_pics = $album_info[5];
                $fb_pics = str_replace('"', "", substr($fb_pics, 4));
                $fb_pics = substr($fb_pics, 0, (strlen($fb_pics)-1));
                $fb_pics = explode(",", $fb_pics);
              }

              foreach ($user_album['data'] as $image) 
              {
                if(isset($_GET['mode']) && in_array($image['source'], $fb_pics))
                {
                  echo "<div class='photo-select'><a href='#'><img src='".$image['source']."' class='selected'></a></div>";
                }
                else
                {
                  echo "<div class='photo-select'><a href='#'><img src='".$image['source']."'></a></div>";
                }
              }
              echo '</div>'; 
              ?>

              <div class="multi-file-upload-wrapper">
              <!-- The file upload form used as target for the file upload widget -->
              <form id="fileupload" action="//jquery-file-upload.appspot.com/" method="POST" enctype="multipart/form-data">
                  <!-- Redirect browsers with JavaScript disabled to the origin page -->
                  <noscript><input type="hidden" name="redirect" value="http://blueimp.github.com/jQuery-File-Upload/"></noscript>
                  <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                  <div class="row fileupload-buttonbar">
                      <div class="span7">
                          <!-- The fileinput-button span is used to style the file input field as button -->
                          <input value="Add Files..." type="file" name="files[]" multiple>                    
                          <button type="button" class="delete">
                            Delete
                          </button>
                          Select All <input type="checkbox" class="toggle">
                      </div>
                      <!-- The global progress information -->
                      <div class="span5 fileupload-progress fade">
                          <!-- The global progress bar -->
                          <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                              <div class="bar" style="width:0%;"></div>
                          </div>
                          <!-- The extended global progress information -->
                          <div class="progress-extended">&nbsp;</div>
                      </div>
                  </div>
                  <!-- The loading indicator is shown during file processing -->
                  <div class="fileupload-loading"></div>
                  <br>
                  <!-- The table listing the files available for upload/download -->
                  <table role="presentation" class="table table-striped"><tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"></tbody></table>
              </form>
              <br>
          </div>
          <!-- modal-gallery is the modal dialog used for the image gallery -->
          <div id="modal-gallery" class="modal modal-gallery hide fade" data-filter=":odd" tabindex="-1">
              <div class="modal-header">
                  <a class="close" data-dismiss="modal">&times;</a>
                  <h3 class="modal-title"></h3>
              </div>
              <div class="modal-body"><div class="modal-image"></div></div>
              <div class="modal-footer">
                  <a class="btn modal-download" target="_blank">
                      <i class="icon-download"></i>
                      <span>Download</span>
                  </a>
                  <a class="btn btn-success modal-play modal-slideshow" data-slideshow="5000">
                      <i class="icon-play icon-white"></i>
                      <span>Slideshow</span>
                  </a>
                  <a class="btn btn-info modal-prev">
                      <i class="icon-arrow-left icon-white"></i>
                      <span>Previous</span>
                  </a>
                  <a class="btn btn-primary modal-next">
                      <span>Next</span>
                      <i class="icon-arrow-right icon-white"></i>
                  </a>
              </div>
          </div>
          <!-- The template to display files available for upload -->
          <script id="template-upload" type="text/x-tmpl">
          {% for (var i=0, file; file=o.files[i]; i++) { %}
              <tr class="template-upload fade">
                  <td class="preview"><span class="fade"></span></td>
                  <td class="name"><span>{%=file.name%}</span></td>
                  <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
                  {% if (file.error) { %}
                      <td class="error" colspan="2"><span class="label label-important">Error</span> {%=file.error%}</td>
                  {% } else if (o.files.valid && !i) { %}
                      <td>
                          <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="bar" style="width:0%;"></div></div>
                      </td>
                      <td class="start">{% if (!o.options.autoUpload) { %}
                          <button class="btn btn-primary">
                              <i class="icon-upload icon-white"></i>
                              <span>Start</span>
                          </button>
                      {% } %}</td>
                  {% } else { %}
                      <td colspan="2"></td>
                  {% } %}
                  <td class="cancel">{% if (!i) { %}
                      <button class="btn btn-warning">
                          <i class="icon-ban-circle icon-white"></i>
                          <span>Cancel</span>
                      </button>
                  {% } %}</td>
              </tr>
          {% } %}
          </script>
          <!-- The template to display files available for download -->
          <script id="template-download" type="text/x-tmpl">
          {% for (var i=0, file; file=o.files[i]; i++) { %}
              <tr class="template-download fade">
                  {% if (file.error) { %}
                      <td></td>
                      <td class="name"><span>{%=file.name%}</span></td>
                      <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
                      <td class="error" colspan="2"><span class="label label-important">Error</span> {%=file.error%}</td>
                  {% } else { %}
                      <td class="preview">{% if (file.thumbnail_url) { %}
                          <a href="{%=file.url%}" title="{%=file.name%}" rel="gallery" target="_blank"><img src="{%=file.thumbnail_url%}" class="local_selected"></a>
                      {% } %}</td>
                      <td class="name">
                          <a href="{%=file.url%}" title="{%=file.name%}" rel="{%=file.thumbnail_url&&'gallery'%}" target="_blank" >{%=file.name%}</a>
                      </td>
                      <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
                      <td colspan="2"></td>
                  {% } %}
                  <td class="delete">
                      <button class="btn btn-danger" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}">
                          <i class="icon-trash icon-white"></i>
                          <span>Delete</span>
                      </button>
                      <input type="checkbox" name="delete" value="1">
                  </td>
              </tr>
          {% } %}
          </script>
          </div>
          <?php
            }
          }
          else
          {
            echo "Please login";
          }
    ?>

      </div>
    </div>
    <!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
    <script src="scripts/multi-upload-file/js/vendor/jquery.ui.widget.js"></script>
    <!-- The Templates plugin is included to render the upload/download listings -->
    <script src="scripts/multi-upload-file/js/tmpl.min.js"></script>
    <!-- The Load Image plugin is included for the preview images and image resizing functionality -->
    <script src="scripts/multi-upload-file/js/load-image.min.js"></script>
    <!-- The Canvas to Blob plugin is included for image resizing functionality -->
    <script src="scripts/multi-upload-file/js/canvas-to-blob.min.js"></script>
    <!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
    <script src="scripts/multi-upload-file/js/jquery.iframe-transport.js"></script>
    <!-- The basic File Upload plugin -->
    <script src="scripts/multi-upload-file/js/jquery.fileupload.js"></script>
    <!-- The File Upload file processing plugin -->
    <script src="scripts/multi-upload-file/js/jquery.fileupload-fp.js"></script>
    <!-- The File Upload user interface plugin -->
    <script src="scripts/multi-upload-file/js/jquery.fileupload-ui.js"></script>
    <!-- The main application script -->
    <script src="scripts/multi-upload-file/js/main.js"></script>
    <script type="text/javascript" src="scripts/functions.js"></script>
    <?php include("Components/footer.php"); ?>
  </body>
</html>
<?php $db->db_close(); ?>