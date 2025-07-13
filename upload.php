// Load local .env variables (for localhost testing)
if (file_exists(__DIR__ . '/.env')) {
    $lines = file(__DIR__ . '/.env');
    foreach ($lines as $line) {
        if (trim($line) && strpos($line, '=') !== false) {
            putenv(trim($line));
        }
    }
}

require_once 'conn.php';

$cloudName = getenv('CLOUDINARY_CLOUD_NAME');
$apiKey = getenv('CLOUDINARY_API_KEY');
$apiSecret = getenv('CLOUDINARY_API_SECRET');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['video']) && isset($_POST['name'])) {
    $name = $_POST['name'];
    $videoTmpPath = $_FILES['video']['tmp_name'];

    $data = new CURLFile($videoTmpPath);
    $timestamp = time();
    $params_to_sign = "timestamp=$timestamp";
    $signature = hash_hmac("sha1", $params_to_sign, $apiSecret);

    $post = [
        'file' => $data,
        'api_key' => $apiKey,
        'timestamp' => $timestamp,
        'signature' => $signature
    ];

    $ch = curl_init("https://api.cloudinary.com/v1_1/$cloudName/video/upload");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    $result = json_decode(curl_exec($ch), true);
    curl_close($ch);

    if (isset($result['secure_url'])) {
        $url = $result['secure_url'];
        $stmt = $conn->prepare("INSERT INTO video (name, url) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $url);
        $stmt->execute();
        header("Location: index.php");
        exit();
    } else {
        echo "Upload failed.";
    }
}