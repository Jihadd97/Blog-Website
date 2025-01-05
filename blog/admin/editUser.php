<?php
include_once("partials/header.php");
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM users WHERE id=$id";
    $result = mysqli_query($connection, $query);
    $user = mysqli_fetch_assoc($result);
} else {
    header('location: ' . ROOT_URL . 'admin/manageUsers.php');
    die();
}
?>

<section class="form_section">
    <div class="container form_section_container">
        <h2>Update User</h2>
        <form action="<?= ROOT_URL ?>admin/editUser_logic.php" enctype="multipart/form-data" method="POST">
            <input type="hidden" name="id" value="<?= $user['id'] ?>" >
            <input type="hidden" name="previous_avatar_name" value="<?= $user['avatar'] ?>">
            <input type="text" name="firstname" value="<?= $user['firstname'] ?>"  placeholder="First Name">
            <input type="text"  name="lastname"  value="<?= $user['lastname'] ?>" placeholder="Last Name">
            <input type="text"  name="username"  value="<?= $user['username'] ?>" placeholder="Username">
            <input type="password" name="password" placeholder="New Password">

              <!-- Avatar upload without preview -->
            <div class="form_control">
                <label for="avatar">User Avatar</label>
                <input type="file" name="avatar" id="avatar">
            </div>

            <select name="userrole">
                <option value="0" <?= $user['is_admin'] == 0 ? 'selected' : ''; ?>>Author</option>
                <option value="1" <?= $user['is_admin'] == 1 ? 'selected' : ''; ?>>Admin</option>
            </select>
            <button type="submit" name="submit" class="btn">Update User</button>
        </form>
    </div>
</section>
<!------------------------------- END OF FORM ------------------------------------>


<?php
include_once("../partials/footer.php");
?>