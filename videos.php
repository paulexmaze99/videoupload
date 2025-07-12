<?php
date_default_timezone_set('Asia/Manila');
require_once 'conn.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Video Upload Gallery</title>

  <!-- Bootstrap 4 CDN -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.6.2/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.6.2/js/bootstrap.min.js"></script>

  <style>
    body {
      background: #f8f9fa;
      padding-top: 40px;
    }
    .video-card {
      background: #fff;
      border-radius: 8px;
      box-shadow: 0 1px 3px rgba(0,0,0,0.1);
      margin-bottom: 20px;
      padding: 15px;
    }
  </style>
</head>
<body>

<div class="container">
  <h3 class="text-center text-primary mb-4">📤 User Video Upload Gallery</h3>

  <div class="text-center mb-4">
    <button class="btn btn-success" data-toggle="modal" data-target="#uploadModal">
      + Upload New Video
    </button>
  </div>

  <?php
  $query = mysqli_query($conn, "SELECT * FROM `video` ORDER BY `video_id` DESC") or die('connection failed');
  if (mysqli_num_rows($query) > 0):
      while ($video = mysqli_fetch_assoc($query)):
  ?>
    <div class="video-card row">
      <div class="col-md-4">
        <h5 class="text-secondary">Video Name:</h5>
        <p class="font-weight-bold"><?php echo htmlspecialchars($video['video_name']); ?></p>
      </div>
      <div class="col-md-8">
        <video width="100%" height="240" controls>
          <source src="<?php echo htmlspecialchars($video['location']); ?>" type="video/mp4">
          Your browser does not support the video tag.
        </video>
      </div>
    </div>
  <?php
      endwhile;
  else:
      echo '<div class="alert alert-info text-center">No videos uploaded yet.</div>';
  endif;
  ?>
</div>

<!-- Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="save_video.php" method="POST" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="uploadModalLabel">Upload New Video</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="video">Select Video File (max 50MB):</label>
            <input type="file" name="video" id="video" class="form-control-file" required accept="video/*">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
          <button name="save" class="btn btn-success">Upload</button>
        </div>
      </div>
    </form>
  </div>
</div>

</body>
</html>
