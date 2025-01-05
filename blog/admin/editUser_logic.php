<?php
require 'config/database.php';

if (isset($_POST['submit'])) {
    // Get updated form data
    $id = $_POST['id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $is_admin = $_POST['userrole'];

    // Handle Avatar Upload
    $avatar = $_FILES['avatar'];
    $user_query = "SELECT avatar FROM users WHERE id = $id LIMIT 1";
    $user_result = mysqli_query($connection, $user_query);
    $user = mysqli_fetch_assoc($user_result);
    $previous_avatar_name = $user['avatar']; // Fetch current avatar name

    $password = $_POST['password'] ?? '';  // Use an empty string if no password is entered
    $password_query = '';  // Initialize password query part

    // Check for valid form input
    if (!$firstname || !$lastname || !$username) {
        $_SESSION['editUser'] = "Invalid form input.";
    } else {
        // If a new password is provided, hash and update it
        if ($password) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $password_query = ", password='$hashed_password'";  // Append password update to the query
        }

        // Handle avatar upload if provided
        if ($avatar['name']) {
            $time = time(); // Create a unique name using the current timestamp
            $avatar_name = $time . $avatar['name'];
            $avatar_tmp_name = $avatar['tmp_name'];
            $avatar_destination_path = '../images/' . $avatar_name;

            // Validate file type and size
            $allowed_files = ['png', 'jpg', 'jpeg'];
            $extension = strtolower(pathinfo($avatar_name, PATHINFO_EXTENSION));
            if (in_array($extension, $allowed_files) && $avatar['size'] < 2_000_000) {
                if (move_uploaded_file($avatar_tmp_name, $avatar_destination_path)) {
                    // Delete the old avatar if new one uploaded
                    if (!empty($previous_avatar_name)) {
                        $previous_avatar_path = '../images/' . $previous_avatar_name;
                        if (file_exists($previous_avatar_path)) {
                            unlink($previous_avatar_path);  // Delete old avatar
                        }
                    }
                } else {
                    $_SESSION['editUser'] = "Failed to upload avatar.";
                    header('location: ' . ROOT_URL . 'admin/manageUsers.php');
                    die();
                }
            } else {
                $_SESSION['editUser'] = "Invalid avatar file. Only png, jpg, jpeg files under 2MB are allowed.";
                header('location: ' . ROOT_URL . 'admin/manageUsers.php');
                die();
            }
        }

        // Use the new avatar name or keep the old one
        $avatar_to_insert = $avatar_name ?? $previous_avatar_name;

        // Update user data (including password if provided)
        $query = "UPDATE users SET 
                    firstname='$firstname', 
                    lastname='$lastname', 
                    username='$username', 
                    is_admin=$is_admin 
                    $password_query,
                    avatar='$avatar_to_insert'
                    WHERE id=$id LIMIT 1";

        // Execute the query
        if (mysqli_query($connection, $query)) {
            $_SESSION['editUser_success'] = "User updated successfully.";
        } else {
            $_SESSION['editUser'] = "Failed to update user.";
        }
    }
}

// Redirect back to manage users page after processing
header('location: ' . ROOT_URL . 'admin/manageUsers.php');
die();
