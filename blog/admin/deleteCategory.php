<?php
require 'config/database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // FOR LATER
    // update category_id of posts that belong to this category to id of uncategorized category

    // delete category
    $query = "DELETE FROM categories WHERE id=$id";
    $result = mysqli_query($connection, $query);

    if (!mysqli_errno($connection)) {
        $_SESSION['deleteCategory_success'] = "$title category deleted successfully";
    } else {
        $_SESSION['deleteCategory'] = "$title category delete failed";
    }
}


header('location: ' . ROOT_URL . 'admin/manageCategory.php');
die();
