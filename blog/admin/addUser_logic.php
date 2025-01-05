<?php
require "config/database.php";

//get form data if submit button was clicked

if (isset($_POST['submit'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $createpassword = $_POST['createpassword'];
    $confirmpassword = $_POST['confirmpassword'];
    $is_admin = $_POST['userrole'];
    $avatar = $_FILES['avatar'];

    // validate input values
    if (!$firstname) {
        $_SESSION['addUser'] = "Please enter your First Name.";
    } elseif (!$lastname) {
        $_SESSION['addUser'] = "Please enter your Last Name.";
    } elseif (!$username) {
        $_SESSION['addUser'] = "Please enter your Username.";
    } elseif (!$email) {
        $_SESSION['addUser'] = "Please enter your valid Email.";
    } elseif (!$createpassword || !$confirmpassword) {
        $_SESSION['addUser'] = "Please write a Password.";
    } elseif (strlen($createpassword) < 8 || strlen($confirmpassword) < 8) {
        $_SESSION['addUser'] = "Password should be 8+ characters.";
    } elseif (!$avatar['name']) {
        $_SESSION['addUser'] = "Please add avatar.";
    } else {
        // check if passwords don't match
        if ($createpassword !== $confirmpassword) {
            $_SESSION['addUser'] = "Passwords do not match";
        } else {
            // hash password
            $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);

            // check if username or email already exists in database

            $user_check_query = "SELECT * FROM users WHERE username = '$username' OR email = '$email' ";

            $user_check_result = mysqli_query($connection, $user_check_query);

            if (mysqli_num_rows($user_check_result) > 0) {

                $_SESSION['addUser'] = "Username or Email already exist";
            } else {
                // Work on Avatar
                // rename avatar
                $time = time(); // this will make each uploaded image name unique using current timestamp
                $avatar_name = $time . $avatar['name'];
                $avatar_tmp_name = $avatar['tmp_name'];
                $avatar_destination_path = '../images/' . $avatar_name;

                // make sure file is an image
                $allowed_files = ['png', 'jpg', 'jpeg'];
                $extension = strtolower(pathinfo($avatar_name, PATHINFO_EXTENSION));


                if (in_array($extension, $allowed_files)) {
                    // make sure image is not too large (1mb)
                    if ($avatar['size'] < 1000000) {
                        // upload avatar
                        move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
                    } else {
                        $_SESSION['addUser'] = 'File size is too big. Should be less than 1mb';
                    }
                } else {
                    $_SESSION['addUser'] = "File should be in png, jpg, or jpeg";
                }
            }
        }
    }

    // redirect back to add user page if there was any problem
    if (isset($_SESSION['addUser'])) {
        // pass form data back to add user page
        $_SESSION['addUser_data'] = $_POST;
        header('location:' . ROOT_URL . 'admin/addUser.php');
        die();
    } else {
        // Hash password and insert user into the database
        $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);

        $insert_user_query = "INSERT INTO users (firstname, lastname, username, email, password, avatar, is_admin) 
                               VALUES ('$firstname', '$lastname', '$username', '$email', '$hashed_password', '$avatar_name', $is_admin)";

        $insert_user_result = mysqli_query($connection, $insert_user_query);

        if ($insert_user_result) {
            // Redirect to manage users page with success message
            $_SESSION['addUser_success'] = "New user added successfully!";
            header('location:' . ROOT_URL . 'admin/manageUsers.php');
            die();
        } else {
            $_SESSION['addUser'] = "Failed to add user. Please try again.";
        }
    }
} else {
    // If submit button wasn't clicked, bounce back to add user page
    header("location:" . ROOT_URL . 'admin/addUser.php');
    die();
}
