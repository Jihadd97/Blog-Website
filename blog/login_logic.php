<?php
require 'config/database.php';

if (isset($_POST['submit'])) {
    // get form data
    $username_email = $_POST['username_email'];
    $password = $_POST['password'];

    if (!$username_email) {
        $_SESSION['login'] = "Username or Email required";
    } elseif (!$password) {
        $_SESSION["login"] = "Password required";
    } else {
        //fetch user from database
        $fetch_user_query = "SELECT * FROM users WHERE username='$username_email' OR email='$username_email'";
        $fetch_user_result = mysqli_query($connection, $fetch_user_query);

        if (mysqli_num_rows($fetch_user_result) == 1) {
            //convert the record into assoc array
            $user_record = mysqli_fetch_assoc($fetch_user_result);

            $db_password = $user_record['password'];
            //compare form password with database password
            if (password_verify($password, $db_password)) {
                //set session for access control
                $_SESSION['userId'] = $user_record['id'];
                // set session if user is an admin
                if ($user_record['is_admin'] == 1) {
                    $_SESSION['user_is_admin'] = true;
                }
                //log user in
                header('location: ' . ROOT_URL . 'admin/');
            } else {
                $_SESSION['login'] = "Error , try again!";
            }
        } else {
            $_SESSION['login'] = "User not found";
        }
    }
    //if any problem, redirect to login page with data
    if (isset($_SESSION['login'])) {
        $_SESSION['login_data'] = $_POST;
        header('location: ' . ROOT_URL . 'login.php');
        die();
    }
} else {
    header('location: ' . ROOT_URL . 'login.php');
}
