<?php
date_default_timezone_set('Asia/Manila');
require_once 'conn.php';
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
<div class="container mt-5">
    <div class="card p-4">
        <h3 class="text-primary mb-4">Video Upload</h3>
        <button class="btn btn-primary mb-4" data-toggle="modal" data-target="#form_modal">
            <span class="glyphicon glyphicon-plus"></span> Add Video
        </button>

        <hr class="mb-4" style="border-top: 3px solid #ccc;" />

        <?php
        $query = mysqli_query($conn, "SELECT * FROM `video` ORDER BY `video_id` DESC") or die('Connection failed');
        while ($fetch = mysqli_fetch_array($query)):
        ?>
            <div class="row mb-4">
                <div class="col-md-4">
                    <h5 class="text-muted">Video Name</h5>
                    <h6 class="text-primary">
                        <?= htmlspecialchars($fetch['video_name'], ENT_QUOTES, 'UTF-8') ?>
                    </h6>
                </div>
                <div class="col-md-8">
                    <video width="100%" height="240" controls>
                        <source src="<?= htmlspecialchars($fetch['location'], ENT_QUOTES, 'UTF-8') ?>">
                        Your browser does not support the video tag.
                    </video>
                </div>
            </div>
            <hr />
        <?php endwhile; ?>
    </div>
</div>

<!-- Upload Modal -->
<div class="modal fade" id="form_modal" tabindex="-1" aria-labelledby="form_modal_label" aria-hidden="true">
    <div class="modal-dialog">
        <form action="save_video.php" method="POST" enctype="multipart/form-data" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="form_modal_label">Upload Video</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="video">Video File</label>
                    <input type="file" name="video" id="video" class="form-control" required />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">
                    Close
                </button>
                <button type="submit" name="save" class="btn btn-primary">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>

<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/bootstrap.js"></script>
</body>
</html>
