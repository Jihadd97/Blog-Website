<?php
require 'config/database.php';
//check login status
if(!isset($_SESSION['userId'])) {
    header('location: ' . ROOT_URL . 'login.php');
    die();
}

//fetch current user from database
if(isset($_SESSION['userId'])){
    $id = $_SESSION['userId'];
    $query = "SELECT avatar FROM users WHERE id=$id";
    $result = mysqli_query($connection, $query);
    $avatar = mysqli_fetch_assoc( $result );
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP & MySQL Blog</title>
    <link rel="stylesheet" href="<?= ROOT_URL ?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= ROOT_URL ?>/css/all.css">
    <link rel="stylesheet" href="<?= ROOT_URL ?>/css/style.css">
</head>

<body>
    <nav>
        <div class="container nav_container">
            <a href="<?= ROOT_URL ?>index.php" class="nav_logo">Traveler</a>
            <ul class="nav_items show">
                <li><a href="<?= ROOT_URL ?>blog.php">Blog</a></li>
                <li><a href="<?= ROOT_URL ?>about.php">About</a></li>
                <li><a href="<?= ROOT_URL ?>services.php">Services</a></li>
                <li><a href="<?= ROOT_URL ?>contact.php">Contact</a></li>
                <?php if (isset($_SESSION['userId'])): ?>
                    <li class="nav_profile">
                        <div class="avatar">
                            <img src="<?= ROOT_URL . 'images/'. $avatar['avatar']?>" alt="profile1">
                        </div>
                        <ul>
                            <li><a href="<?= ROOT_URL ?>admin/index.php">Dashboard</a></li>
                            <li><a href="<?= ROOT_URL ?>logout.php">Logout</a></li>
                        </ul>
                    </li>
                <?php else : ?>
                    <li><a href="<?= ROOT_URL ?>login.php">Login</a></li>
                <?php endif ?>

            </ul>
            <button id="open_nav-btn"><i class="fa-solid fa-bars"></i></button>
            <button id="close_nav-btn"><i class="fa-solid fa-xmark"></i></button>
        </div>
    </nav>

    <!------------------------------- END OF NAV ------------------------------------>
