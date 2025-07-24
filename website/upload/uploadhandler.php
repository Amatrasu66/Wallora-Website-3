<?php
// Include your DB connection
require_once __DIR__ . '../../database_connection/database.php'; // ✅ Fixed path

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title    = mysqli_real_escape_string($conn, $_POST['title']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $file     = $_FILES['wallpaper'];

    if ($file['error'] !== UPLOAD_ERR_OK) {
        die('Upload error code: ' . $file['error']);
    }

    // Make sure uploads folder exists (it's in root)
    $uploadDir = __DIR__ . '/../../uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $ext     = pathinfo($file['name'], PATHINFO_EXTENSION);
    $newName = uniqid('wp_') . '.' . $ext;
    $target  = $uploadDir . $newName;

    if (!move_uploaded_file($file['tmp_name'], $target)) {
        die('Failed to move uploaded file.');
    }

    $stmt = mysqli_prepare(
        $conn,
        "INSERT INTO wallpapers (filename, title, category) VALUES (?, ?, ?)"
    );
    mysqli_stmt_bind_param($stmt, 'sss', $newName, $title, $category);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) === 1) {
        echo "Upload successful! <a href='imgupload.php'>Upload Again</a>";
    } else {
        echo "DB insert failed: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}