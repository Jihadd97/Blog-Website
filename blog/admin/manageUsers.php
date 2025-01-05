<?php
include_once("partials/header.php");

// fetch users from database but not current user
$current_adminId = $_SESSION['userId'];
$query = "SELECT * FROM users";
$users = mysqli_query($connection, $query);

?>


<section class="dashboard">

    <?php if (isset($_SESSION['editUser_success'])) : // shows if edit user was successful
    ?>
        <div class="alert_message success container">
            <p>
                <?= $_SESSION['editUser_success'];
                unset($_SESSION['editUser_success']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['editUser'])) : // shows if edit user failed
    ?>
        <div class="alert_message error container">
            <p>
                <?= $_SESSION['editUser'];
                unset($_SESSION['editUser']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['deleteUser_success'])) : // shows if delete user is successful
    ?>
        <div class="alert_message success container">
            <p>
                <?= $_SESSION['deleteUser_success'];
                unset($_SESSION['deleteUser_success']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['deleteUser'])) : // shows if edit user failed
    ?>
        <div class="alert_message error container">
            <p>
                <?= $_SESSION['deleteUser'];
                unset($_SESSION['deleteUser']);
                ?>
            </p>
        </div>
    <?php endif ?>

    <div class="container dashboard_container">
        <button id="show_sidebar-btn" class="sidebar_toggle"><i class="fa-solid fa-chevron-right"></i></button>
        <button id="hide_sidebar-btn" class="sidebar_toggle"><i class="fa-solid fa-chevron-left"></i></button>

        <aside class="mt-4">
            <ul class="p-0">
                <li>
                    <a href="addPost.php"><i class="fa-solid fa-pencil"></i>
                        <h5>Add Post</h5>
                    </a>
                </li>
                <li>
                    <a href="index.php"><i class="fa-solid fa-address-card"></i>
                        <h5>Manage Posts</h5>
                    </a>
                </li>
                <?php if (isset($_SESSION['user_is_admin'])): ?>
                    <li>
                        <a href="addUser.php"><i class="fa-solid fa-user-plus"></i>
                            <h5>Add User</h5>
                        </a>
                    </li>
                    <li>
                        <a href="manageUsers.php" class="active"><i class="fa-solid fa-users"></i>
                            <h5>Manage Users</h5>
                        </a>
                    </li>
                    <li>
                        <a href="addCategory.php"><i class="fa-solid fa-pen-to-square"></i>
                            <h5>Add Category</h5>
                        </a>
                    </li>
                    <li>
                        <a href="manageCategory.php"><i class="fa-solid fa-list-ul"></i>
                            <h5>Manage Categories</h5>
                        </a>
                    </li>
                <?php endif ?>
            </ul>
        </aside>
        <main>
            <h2>Manage Users</h2>
            <?php if(mysqli_num_rows($users) > 0) : ?>
            <table  class="text-center">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Edit</th>
                        <th>Delete</th>
                        <th>Admin</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($user = mysqli_fetch_assoc($users)): ?>
                        <tr>
                            <td><?= "{$user['firstname']} {$user['lastname']}" ?></td>
                            <td><?= $user['username'] ?></td>
                            <td><a href="<?= ROOT_URL ?>admin/editUser.php?id=<?= $user['id'] ?>" class="btn sm">Edit</a></td>
                            <td><a href="<?= ROOT_URL ?>admin/deleteUser.php?id=<?= $user['id'] ?>" class="btn sm danger">Delete</a></td>
                            <td><?= $user['is_admin'] ? 'Yes' : 'No' ?></td>
                        </tr>
                    <?php endwhile ?>
                </tbody>
            </table>
            <?php else :  ?>
                <div class="alert_message error"><?= "No users are found!" ?></div>
                <?php endif ?>
        </main>
    </div>
</section>
<?php
include_once("../partials/footer.php");
?>