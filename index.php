<?php
date_default_timezone_set('Asia/Manila');
require_once 'conn.php';

if ($_SERVER['REQUEST_URI'] === '/health') {
    echo 'OK';
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Video Upload</title>
    <link rel="stylesheet" href="css/bootstrap.css" />
</head>
<body>

<div class="container">
    <div class="col-md-8 col-md-offset-2 well">
        <h3 class="text-primary">Video Upload</h3>
        <hr />

        <?php if (isset($_GET['upload']) && $_GET['upload'] === 'success'): ?>
            <div class="alert alert-success">Video uploaded successfully!</div>
        <?php endif; ?>

        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#form_modal">
            <span class="glyphicon glyphicon-plus"></span> Add Video
        </button>
        <br><br>

        <?php
        $query = mysqli_query($conn, "SELECT * FROM `video` ORDER BY `video_id` DESC") or die('Query failed.');
        if (mysqli_num_rows($query) > 0):
            while ($video = mysqli_fetch_assoc($query)):
                $videoName = htmlspecialchars($video['video_name'], ENT_QUOTES, 'UTF-8');
                $videoPath = htmlspecialchars($video['location'], ENT_QUOTES, 'UTF-8');
        ?>
        <div class="row" style="margin-bottom: 30px;">
            <div class="col-xs-12 col-md-4">
                <h4>Video Name</h4>
                <h5 class="text-primary"><?= $videoName ?></h5>
            </div>
            <div class="col-xs-12 col-md-8">
                <?php if (file_exists($videoPath)): ?>
                    <video width="100%" height="240" controls>
                        <source src="<?= $videoPath ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                <?php else: ?>
                    <div class="alert alert-warning">Video file not found.</div>
                <?php endif; ?>
            </div>
        </div>
        <?php endwhile; else: ?>
            <div class="alert alert-info">No videos uploaded yet.</div>
        <?php endif; ?>
    </div>
</div>

<!-- Upload Modal -->
<div class="modal fade" id="form_modal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="save_video.php" method="POST" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="uploadModalLabel">Upload a New Video</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group text-center">
                        <label for="video">Select Video File</label>
                        <input type="file" name="video" class="form-control-file" accept="video/*" required />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                        <span class="glyphicon glyphicon-remove"></span> Close
                    </button>
                    <button type="submit" name="save" class="btn btn-primary">
                        <span class="glyphicon glyphicon-save"></span> Save
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/bootstrap.js"></script>
</body>
</html>
<?php
// Close the database connection
mysqli_close($conn);