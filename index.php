<?php
require_once 'conn.php';
$query = $conn->query("SELECT * FROM video ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cloud Video Upload</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
    <div class="container">
        <h2 class="text-primary mb-4">Uploaded Videos</h2>
        <form action="upload.php" method="POST" enctype="multipart/form-data" class="mb-4">
            <input type="file" name="video" accept="video/*" required class="form-control mb-2">
            <input type="text" name="name" placeholder="Video Name" required class="form-control mb-2">
            <button type="submit" class="btn btn-success">Upload</button>
        </form>
        <hr>
        <?php while($row = $query->fetch_assoc()): ?>
            <div class="mb-4">
                <h5><?= htmlspecialchars($row['name']) ?></h5>
                <video width="100%" height="300" controls>
                    <source src="<?= htmlspecialchars($row['url']) ?>" type="video/mp4">
                </video>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>