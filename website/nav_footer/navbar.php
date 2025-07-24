<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Website web1/website/database_connection/database.php';

?>

<?php
// OPTIONAL: Avoid repeated DB calls if already available elsewhere
$is_admin = false;

if (isset($_SESSION["user_id"])) {
    $uid = $_SESSION["user_id"];

    $stmt = $conn->prepare("SELECT is_admin FROM users WHERE id = ?");
    $stmt->bind_param("i", $uid);
    $stmt->execute();
    $result = $stmt->get_result();
    $userData = $result->fetch_assoc();

    if ($userData && $userData["is_admin"] == 1) {
        $is_admin = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        .stdfont {
            font-family: 'Times New Roman', Times, serif;
        }
    </style>
</head>

<!-- Navbar -->
<nav class="navbar">
    <div class="container">
        <!-- Left side: Website name as logo -->
        <div class="logo">
            <a style="font-size: 28px;" class="stdfont" href="/website web1/website/index_work.php">Wallora</a>
        </div>

        <!-- Right side: Navigation Links -->
        <ul class="nav-links">
            <li><a class="stdfont" href="/website web1/website/index_work.php">Home</a></li>

            <!-- Categories with Dropdown -->
            <li class="dropdown">
                <a class="stdfont" href="/website web1/website/categories.php">Categories</a>
                <ul class="dropdown-menu">
                    <li><a class="stdfont" href="/website web1/website/categories/aesthetic.php">Aesthetic</a></li>
                    <li><a class="stdfont" href="/website web1/website/categories/animals.php">Animals</a></li>
                    <li><a class="stdfont" href="/website web1/website/categories/anime.php">Anime</a></li>
                    <li><a class="stdfont" href="/website web1/website/categories/cityscapes.php">Cityscapes</a></li>
                    <li><a class="stdfont" href="/website web1/website/categories/dark.php">Dark</a></li>
                    <li><a class="stdfont" href="/website web1/website/categories/dragon.php">Dragon</a></li>
                    <li><a class="stdfont" href="/website web1/website/categories/flowers.php">Flowers</a></li>
                    <li><a class="stdfont" href="/website web1/website/categories/light.php">Light</a></li>
                    <li><a class="stdfont" href="/website web1/website/categories/nature.php">Nature</a></li>
                    <li><a class="stdfont" href="/website web1/website/categories/technology.php">Technology</a></li>
                    <li><a class="stdfont" href="/website web1/website/categories/universe.php">Universe</a></li>
                </ul>
            </li>

            <li><a class="stdfont" href="/website web1/website/contact.php">Contact</a></li>

            <?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true): ?>
                <li><a class="stdfont" href="#">Welcome, <?= htmlspecialchars($_SESSION["username"]) ?></a></li>

                <?php if ($is_admin): ?>
                    <li><a class="stdfont" href="/website web1/website/upload/imgupload.php">Upload</a></li>
                <?php endif; ?>

                <li><a class="stdfont" href="/website web1/website/login_signup/logout.php">Logout</a></li>
            <?php else: ?>
                <li><a class="stdfont" href="/website web1/website/login_signup/login.php">Login</a></li>
                <li><a class="stdfont" href="/website web1/website/login_signup/signup.php">Sign Up</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
