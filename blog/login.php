<?php
require 'config/constants.php';

$username_email = $_SESSION['login_data']['username_email']?? null;
$password = $_SESSION['login_data']['password']?? null;

unset($_SESSION['login_data']);
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

    <section class="form_section">
        <div class="container form_section_container">
            <h2>Login In</h2>
            <?php if (isset($_SESSION['signUp_success'])) : ?>
                <div class="alert_message success">
                    <p>
                        <?= $_SESSION['signUp_success'];
                        unset($_SESSION['signUp_success']);
                        ?>
                    </p>
                </div>
            <?php elseif(isset($_SESSION['login'])) : ?>
                <div class="alert_message error">
                    <p>
                        <?= $_SESSION['login'];
                        unset($_SESSION['login']);
                        ?>
                    </p>
                </div>
            <?php endif ?>
            <form action="<?= ROOT_URL ?>login_logic.php" method="POST" enctype="multipart/form-data">
                <input type="text" name="username_email" value="<?= $username_email ?>" placeholder="Username or Email" required>
                <input type="password" value="<?= $password ?>" name="password" placeholder="Password">
                <button type="submit" name="submit" class="btn">Login In</button>
                <small>Don't have an account? <a href="signUp.php">Sign Up</a></small>
            </form>
        </div>
    </section>

</body>

</html>