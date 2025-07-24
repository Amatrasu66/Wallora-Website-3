<?php
// Start session only if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login_signup/login.php");
    exit();
}

// Include database
include '../database_connection/database.php';

// Get the logged-in user's admin status
$user_id = $_SESSION['user_id'];
$sql = "SELECT is_admin FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user || $user['is_admin'] != 1) {
    echo "Access denied. You are not authorized to view this page.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Wallora Upload Wallpapers</title>
  <link rel="stylesheet" href="../nav_footer/nav_footer.css">
  <link rel="stylesheet" href="../upload/imgupload.css">
  <link rel="stylesheet" href="../universal_background_css/universal_background.css">
  <style>
    /* .box1{
      border: 5px solid yellow;
    } */
  </style>
</head>
<body>
  <?php include("../nav_footer/navbar.php"); ?>
  <div class="box1">
    <h1>Upload a New Wallpaper</h1>
    <form action="uploadhandler.php" method="post" enctype="multipart/form-data">
    <label>Title:</label><br>
    <input type="text" name="title" required><br><br>

    <label>Category:</label><br>
    <select name="category" required>
      <option value="aesthetic">Aesthetic</option>
      <option value="animals">Animals</option>
      <option value="anime">Anime</option>
      <option value="cityscapes">Cityscapes</option>
      <option value="dark">Dark</option>
      <option value="dragon">Dragon</option>
      <option value="flowers">Flowers</option>
      <option value="light">Light</option>
      <option value="nature">Nature</option>
      <option value="technology">Technology</option>
      <option value="universe">Universe</option>
    </select><br><br>

    <label>Select Image:</label><br>
    <input type="file" name="wallpaper" accept="image/*" required><br><br>

    <button type="submit">Upload</button>
  </form>
</div>
  <?php include("../nav_footer/footer.php"); ?>

</body>
</html>