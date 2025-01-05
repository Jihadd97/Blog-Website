<?php
require "config/database.php";

//get form data if submit button was clicked

if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];

    echo $title, $description;

    // validate input values
    if (!$title) {
        $_SESSION['addCategory'] = "Please enter a title.";
    } elseif (!$description) {
        $_SESSION['addCategory'] = "Please enter a description.";
    }

    // redirect back to add category page if there was any problem
    if (isset($_SESSION['addCategory'])) {
        // pass form data back to add user page
        $_SESSION['addCategory_data'] = $_POST;
        header('location: '. ROOT_URL . 'admin/addCategory.php');
        die();  
    } else {
        // insert category into database
        $query = "INSERT INTO categories (title, description) VALUES ('$title', '$description')";
        $result = mysqli_query($connection, $query);
        if(mysqli_errno($connection)){
            $_SESSION['addCategory'] = "Add category failed.";
            header('location: '. ROOT_URL . 'admin/addCategory.php');
            die();
        } else {
            $_SESSION['addCategory_success'] = "$title category added successfully.";
            header('location: '. ROOT_URL . 'admin/manageCategory.php');
            die();
        }
    }
        
}