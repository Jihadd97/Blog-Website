<?php
include_once("partials/header.php");

// get back form data if there was a registeration error
$firstname = $_SESSION["addUser_data"]["firstname"] ?? null;
$lastname = $_SESSION["addUser_data"]["lastname"] ?? null;
$username = $_SESSION["addUser_data"]["username"] ?? null;
$email = $_SESSION["addUser_data"]["email"] ?? null;
$confirmpassword = $_SESSION["addUser_data"]["createpassword"] ?? null;
$confirmpassword = $_SESSION["addUser_data"]["confirmpassword"] ?? null;
?>

<section class="form_section">
    <div class="container form_section_container">
        <h2>Add User</h2>
        <?php if (isset($_SESSION['addUser'])): ?>
            <div class="alert_message error">
                <p>
                    <?= $_SESSION['addUser'];
                    unset($_SESSION['addUser']);

                    ?>
                </p>
            </div>
        <?php endif ?>
        <form action="<?= ROOT_URL ?>admin/addUser_logic.php" method="POST" enctype="multipart/form-data" method="POST">
            <input type="text" name="firstname" value="<?= $firstname ?>" placeholder="First Name" id="first-name" required>
            <input type="text" name="lastname" value="<?= $lastname ?>" placeholder="Last Name" id="last-name" required>
            <input type="text" name="username" value="<?= $username ?>" placeholder="Username" id="username" required>
            <input type="email" name="email" value="<?= $email ?>" placeholder="Email" id="email" required>
            <input type="password" name="createpassword" placeholder="Create Password" id="create-password" required>
            <input type="password" name="confirmpassword" placeholder="Confirm Password" id="confirm-password" required>
            <select name="userrole">
                <option value="0">Author</option>
                <option value="1">Admin</option>
            </select>
            <div class="form_control">
                <label for="avatar">User Avatar</label>
                <input type="file" name="avatar" id="avatar">
            </div>
            <button type="submit" name="submit" class="btn">Add User</button>
        </form>
        <!-- delete signup data session -->
        <?php unset($_SESSION["addUser_data"]); ?>
    </div>
    </section>
    <!------------------------------- END OF FORM ------------------------------------>

    <?php
    include_once("../partials/footer.php");
    ?>