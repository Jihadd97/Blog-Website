<?php
require "config/database.php";

//get form data if submit button was clicked

if (isset($_POST['submit'])) {
    $author_id = $_SESSION['userId'];
    $title = mysqli_real_escape_string($connection, $_POST['title']);
    $body = mysqli_real_escape_string($connection, $_POST['body']);
    $category_id = $_POST['category'];
    $is_featured = $_POST['is_featured'];
    $thumbnail = $_FILES['thumbnail'];

    // set is_featured to 0 if unchecked
    $is_featured = $is_featured == 1 ?: 0;

    // validate input values
    if (!$title) {
        $_SESSION['addPost'] = "Please enter post title.";
    } elseif (!$category_id) {
        $_SESSION['addPost'] = "Please select post category";
    } elseif (!$body) {
        $_SESSION['addPost'] = "Please enter post body";
    } elseif (!$thumbnail['name']) {
        $_SESSION['addPost'] = "Please choose post thumbnail.";
    } else {
        // WORK ON THUMBNAIL
        // rename the image
        $time = time(); // this will make each uploaded image name unique using current timestamp
        $thumbnail_name = $time . $thumbnail['name'];
        $thumbnail_tmp_name = $thumbnail['tmp_name'];
        $thumbnail_destination_path = '../images/' . $thumbnail_name;

        // make sure file is an image
        $allowed_files = ['png', 'jpg', 'jpeg'];
        $extension = strtolower(pathinfo($thumbnail_name, PATHINFO_EXTENSION));
        // var_dump($extension);

        if (in_array($extension, $allowed_files)) {
            // make sure image is not too large (2mb+)
            if ($thumbnail['size'] < 2_000_000) {
                // upload thumbnail
                move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);
            } else {
                $_SESSION['addPost'] = 'File size is too big. Should be less than 2mb';
            }
        } else {
            $_SESSION['addPost'] = "File should be in png, jpg, or jpeg";
        }
    }

    // redirect back to add post page if there was any problem
    if (isset($_SESSION['addPost'])) {
        // pass form data back to add post page 
        $_SESSION['addPost_data'] = $_POST;
        header('location:' . ROOT_URL . 'admin/addPost.php');
        die();
    } else {
        // set is_featured of all posts to 0 if is_featured for this post is 1
        if ($is_featured == 1) {
            $zero_all_is_featured_query = "UPDATE posts SET is_featured = 0 ";
            mysqli_query($connection, $zero_all_is_featured_query);
        }

        // insert posts into database
        $query = "INSERT INTO posts (title, body, thumbnail, category_id, author_id, is_featured) 
        VALUES ('$title', '$body', '$thumbnail_name', '$category_id', $author_id, $is_featured)";
        $result = mysqli_query($connection, $query);


        if (!mysqli_errno($connection)) {

            //redirect to manage posts page with success message
            $_SESSION['addPost_success'] = "New post is added successfully!";
            header('location:' . ROOT_URL . 'admin/');
            die();
        }
    }
} else {
    // if button wasn't clicked, bounce back to add post page
    header("location:" . ROOT_URL . 'addPost.php');
    die();
}
