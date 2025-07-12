<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Upload Video</title>
  <style>
    body {
      font-family: sans-serif;
      background: #f2f2f2;
      display: flex;
      justify-content: center;
      padding-top: 60px;
    }
    form {
      background: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    input[type="file"] {
      margin-bottom: 15px;
    }
    button {
      background: #007bff;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    button:hover {
      background: #0056b3;
    }
  </style>
</head>
<body>

  <form method="post" action="upload_handler.php" enctype="multipart/form-data">
    <h2>Upload a Video</h2>
    <input type="file" name="video" required accept="video/*"><br>
    <button type="submit" name="save">Upload</button>
  </form>

</body>
</html>
