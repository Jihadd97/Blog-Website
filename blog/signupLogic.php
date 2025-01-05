<?php
require "config/database.php";

//get signup form data if signup button was clicked

if (isset($_POST['submit'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $createpassword = $_POST['createpassword'];
    $confirmpassword = $_POST['confirmpassword'];
    $avatar = $_FILES['avatar'];

    echo $firstname, $lastname, $username, $email, $createpassword, $confirmpassword;

    // validate input values
    if (!$firstname) {
        $_SESSION['signUp'] = "Please enter your First Name.";
    } elseif (!$lastname) {
        $_SESSION['signUp'] = "Please enter your Last Name.";
    } elseif (!$username) {
        $_SESSION['signUp'] = "Please enter your Username.";
    } elseif (!$email) {
        $_SESSION['signUp'] = "Please enter your valid Email.";
    } elseif (!$createpassword || !$confirmpassword) {
        $_SESSION['signUp'] = "Please write a Password.";
    } elseif (strlen($createpassword) < 8 || strlen($confirmpassword) < 8) {
        $_SESSION['signUp'] = "Password should be 8+ characters.";
    } elseif (!$avatar['name']) {
        $_SESSION['signUp'] = "Please add avatar.";
    } else {
        // check if passwords don't match
        if ($createpassword !== $confirmpassword) {
            $_SESSION['signUp'] = "Passwords do not match";
        } else {
            // hash password
            $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);

            // check if username or email already exists in database

            $user_check_query = "SELECT * FROM users WHERE username = '$username' OR email = '$email' ";

            $user_check_result = mysqli_query($connection, $user_check_query);

            if (mysqli_num_rows($user_check_result) > 0) {

                $_SESSION['signUp'] = "Username or Email already exist";
            } else {
                // Work on Avatar
                // rename avatar
                $time = time(); // this will make each uploaded image name unique using current timestamp

                $avatar_name = $time . $avatar['name'];
                $avatar_tmp_name = $avatar['tmp_name'];
                $avatar_destination_path = 'images/' . $avatar_name;

                // make sure file is an image
                $allowed_files = ['png', 'jpg', 'jpeg'];
                $extension = strtolower(pathinfo($avatar_name, PATHINFO_EXTENSION));


                if (in_array($extension, $allowed_files)) {
                    // make sure image is not too large (1mb)
                    if ($avatar['size'] < 1000000) {
                        // upload avatar
                        move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
                    } else {
                        $_SESSION['signUp'] = 'File size is too big. Should be less than 1mb';
                    }
                } else {
                    $_SESSION['signUp'] = "File should be in png, jpg, or jpeg";
                }
            }
        }
    }

    // redirect back to signup page if there was any problem
    if (isset($_SESSION['signUp'])) {
        // pass form data back to signup page
        $_SESSION['signUp_data'] = [
            'firstname' => $firstname,
            'lastname' => $lastname,
            'username' => $username,
            'email' => $email
        ];
        header('location:' . ROOT_URL . 'signUp.php');
        die();
    } else {
        // insert new user into users table
        $insert_user_query  = "INSERT INTO users SET firstname='$firstname', lastname='$lastname', username='$username', email='$email', password='$hashed_password', avatar='$avatar_name', is_admin=0";

        $insert_user_query = mysqli_query($connection, $insert_user_query);

        if (!mysqli_errno($connection)) {
            
            //redirect to login page with success message
            $_SESSION['signUp_success'] = "Registeration successful Please log in.";
            header('location:' . ROOT_URL . 'login.php');
            die();
        }
    }
} else {
    // if button wasn't clicked, bounce back to signup page
    header("location:" . ROOT_URL . 'signUp.php');
    die();
}
