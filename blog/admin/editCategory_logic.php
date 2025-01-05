<?php
require 'config/database.php';

if (isset($_POST['submit'])) {
    //get updated for data
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    //check for valid input
    if (!$title || !$description) {
        $_SESSION['editCategory'] = "Invalid form input";
    } else {
        //update user
        $query = "UPDATE categories SET title='$title', description='$description' WHERE id=$id";
        $result = mysqli_query($connection, $query);

        if (mysqli_errno($connection)) {
            $_SESSION['editCategory'] = "Failed to update category.";
        } else {
            $_SESSION['editCategory_success'] = "$title category updated successfully.";
        }
    }
}
header('location: ' . ROOT_URL . 'admin/manageCategory.php');
die();
