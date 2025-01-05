<?php
require 'config/database.php';

if(isset($_POST['submit'])) {
    // Get updated form data
    $id = $_POST['id'];
    $previous_thumbnail_name = $_POST['previous_thumbnail_name'];
    $title = mysqli_real_escape_string($connection, $_POST['title']);
    $body = mysqli_real_escape_string($connection, $_POST['body']);
    $category_id = $_POST['category'];
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    $thumbnail = $_FILES['thumbnail'];

    // Validate input values
    if (!$title || !$body || !$category_id) {
        $_SESSION['editPost'] = "All fields are required.";
        header('location: ' . ROOT_URL . 'admin/');
        die();
    }

    // Handle thumbnail upload if provided
    if ($thumbnail['name']) {
        $time = time(); // Create a unique name using the current timestamp
        $thumbnail_name = $time . $thumbnail['name'];
        $thumbnail_tmp_name = $thumbnail['tmp_name'];
        $thumbnail_destination_path = '../images/' . $thumbnail_name;

        // Validate file type and size
        $allowed_files = ['png', 'jpg', 'jpeg'];
        $extension = strtolower(pathinfo($thumbnail_name, PATHINFO_EXTENSION));
        if (in_array($extension, $allowed_files) && $thumbnail['size'] < 2_000_000) {
            if (move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path)) {
                // Delete the old thumbnail
                if (!empty($previous_thumbnail_name)) {
                    $previous_thumbnail_path = '../images/' . $previous_thumbnail_name;
                    if (file_exists($previous_thumbnail_path)) {
                        unlink($previous_thumbnail_path);
                    }
                }
            } else {
                $_SESSION['editPost'] = "Failed to upload thumbnail.";
                header('location: ' . ROOT_URL . 'admin/');
                die();
            }
        } else {
            $_SESSION['editPost'] = "Invalid thumbnail file. Only png, jpg, jpeg files under 2MB are allowed.";
            header('location: ' . ROOT_URL . 'admin/');
            die();
        }
    }

    // Use the new thumbnail name or keep the old one
    $thumbnail_to_insert = $thumbnail_name ?? $previous_thumbnail_name;

    // Set all posts to not featured if this post is featured
    if ($is_featured == 1) {
        mysqli_query($connection, "UPDATE posts SET is_featured = 0");
    }

    // Update the post in the database
    $query = "UPDATE posts 
              SET title='$title', body='$body', thumbnail='$thumbnail_to_insert', 
                  category_id='$category_id', is_featured=$is_featured 
              WHERE id=$id";

    if (!mysqli_query($connection, $query)) {
        $_SESSION['editPost'] = "Failed to update post.";
    } else {
        $_SESSION['editPost_success'] = "Post updated successfully.";
    }

    // Redirect back to the admin page
    header('location: ' . ROOT_URL . 'admin/');
    die();
}
