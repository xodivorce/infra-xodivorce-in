<?php
session_start();

require_once dirname(dirname(__DIR__)) . '/core/vendor/autoload.php';
require_once dirname(__DIR__) . '/init.php'; 
require_once dirname(__DIR__) . '/connection.php';

$clientId     = $_ENV['GOOGLE_CLIENT_ID'];
$clientSecret = $_ENV['GOOGLE_CLIENT_SECRET'];
$refreshToken = $_ENV['GOOGLE_REFRESH_TOKEN'];
$folderId     = $_ENV['GOOGLE_DRIVE_FOLDER_ID'];

if (!$clientId || !$refreshToken) {
    die("Server Error: Google Drive configuration missing.");
}

if (isset($_GET['view_id']) && !empty($_GET['view_id'])) {
    $fileId = $_GET['view_id'];

    try {
        $client = new Google\Client();
        $client->setClientId($clientId);
        $client->setClientSecret($clientSecret);
        $client->refreshToken($refreshToken);
        
        $service = new Google\Service\Drive($client);

        $response = $service->files->get($fileId, ['alt' => 'media']);
        $content = $response->getBody()->getContents();

        header("Content-Type: image/jpeg"); 
        header("Cache-Control: public, max-age=86400"); // Cache for 24h
        echo $content;
        exit; 

    } catch (Exception $e) {
        http_response_code(404);
        die("Image not found.");
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_SESSION['user_id'])) { die("Access denied."); }

    $user_id  = $_SESSION['user_id'];
    $title    = htmlspecialchars(trim($_POST['title']));
    $category = htmlspecialchars(trim($_POST['category']));
    $priority = htmlspecialchars(trim($_POST['priority']));
    $location = htmlspecialchars(trim($_POST['location'])); 
    if ($priority === 'Med') $priority = 'Medium';

    $fileError = $_FILES['evidence']['error'];
    $imagePath = ''; 

    if ($fileError === 0) {
        $fileName    = $_FILES['evidence']['name'];
        $fileTmpName = $_FILES['evidence']['tmp_name'];
        $fileExt     = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowed     = ['jpg', 'jpeg', 'png'];

        if (in_array($fileExt, $allowed) && $_FILES['evidence']['size'] < 5242880) { 
            try {
                $client = new Google\Client();
                $client->setClientId($clientId);
                $client->setClientSecret($clientSecret);
                $client->refreshToken($refreshToken);
                
                $service = new Google\Service\Drive($client);

                $fileMetadata = new Google\Service\Drive\DriveFile([
                    'name'    => 'Report_' . $user_id . '_' . time() . '.' . $fileExt,
                    'parents' => [$folderId] 
                ]);

                $content = file_get_contents($fileTmpName);
                $file = $service->files->create($fileMetadata, [
                    'data'       => $content,
                    'mimeType'   => mime_content_type($fileTmpName),
                    'uploadType' => 'multipart',
                    'fields'     => 'id'
                ]);

                $imagePath = $file->id;

            } catch (Exception $e) {
                header("Location: ../../index.php?page=reports&error=upload_api_failed");
                exit;
            }
        }
    }

    $sql = "INSERT INTO reports (user_id, title, category, priority, location, map_link, image_path, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, 'Open')";

    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("issssss", $user_id, $title, $category, $priority, $location, $location, $imagePath);
        $stmt->execute();
        $stmt->close();
    }
    $conn->close();

    header("Location: ../../index.php?page=reports&success=report_created");
    exit;
}

header("Location: ../../index.php?page=reports");
exit;
?>