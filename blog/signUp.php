<?php
require("config/constants.php");

// get back form data if there was a registeration error
$firstname = $_SESSION["signUp_data"]["firstname"] ?? null;
$lastname = $_SESSION["signUp_data"]["lastname"]?? null;
$username = $_SESSION["signUp_data"]["username"]?? null;
$email = $_SESSION["signUp_data"]["email"]?? null;
$confirmpassword = $_SESSION["signUp_data"]["createpassword"]?? null;
$confirmpassword = $_SESSION["signUp_data"]["confirmpassword"]?? null;

?>

<!DOCTYPE html>
<html lang="en">
 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Multipage Blog Website</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <section class="form_section m-1">
        <div class="container form_section_container">
            <h2>Sign Up</h2>
            <?php if(isset($_SESSION['signUp'])): ?>
                <div class="alert_message error">
                    <p>
                        <?= $_SESSION['signUp'];
                        unset($_SESSION['signUp']);

                    ?>
                    </p>
                </div>
            <?php endif ?>
            <form action="<?= ROOT_URL ?>signupLogic.php" method="POST" enctype="multipart/form-data">
                <input type="text" name="firstname" value="<?= $firstname ?>" placeholder="First Name" id="first-name">
                <input type="text" name="lastname" value="<?= $lastname ?>" placeholder="Last Name" id="last-name">
                <input type="text" name="username" value="<?= $username ?>" placeholder="Username" id="username">
                <input type="email" name="email" value="<?= $email ?>" placeholder="Email" id="email">
                <input type="password" name="createpassword" placeholder="Create Password" id="create-password">
                <input type="password" name="confirmpassword" placeholder="Confirm Password" id="confirm-password">
                <div class="form_control">
                    <label for="avatar">User Avatar</label>
                    <input type="file" name="avatar" id="avatar">
                </div>
                <button type="submit" name="submit" class="btn">Sign Up</button>
                <small>Already have an account? <a href="login.php">Sign In</a></small>
            </form>

            <!-- delete signup data session -->
            <?php unset($_SESSION["signUp_data"]); ?>
        </div>
    </section>

</body>

</html>