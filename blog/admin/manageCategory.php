<?php
include_once("partials/header.php");
// fetch categories from database 
$query = "SELECT * FROM categories";
$categories = mysqli_query($connection, $query);
?>


<section class="dashboard">
    <?php if (isset($_SESSION['addCategory_success'])) : // shows if category added successfully
    ?>
        <div class="alert_message success container">
            <p>
                <?= $_SESSION['addCategory_success'];
                unset($_SESSION['addCategory_success']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['addCategory'])) : // shows if category added is failed
    ?>
        <div class="alert_message error container">
            <p>
                <?= $_SESSION['addCategory'];
                unset($_SESSION['addCategory']);
                ?>
            </p>
        </div>
        <?php elseif (isset($_SESSION['editCategory_success'])) : // shows if category is updated successfully
    ?>
        <div class="alert_message success container">
            <p>
                <?= $_SESSION['editCategory_success'];
                unset($_SESSION['editCategory_success']);
                ?>
            </p>
        </div>
        <?php elseif (isset($_SESSION['editCategory'])) : // shows if category update is failed
    ?>
        <div class="alert_message error container">
            <p>
                <?= $_SESSION['editCategory'];
                unset($_SESSION['editCategory']);
                ?>
            </p>
        </div>
        <?php elseif (isset($_SESSION['deleteCategory_success'])) : // shows if category is deleted successfully
    ?>
        <div class="alert_message success container">
            <p>
                <?= $_SESSION['deleteCategory_success'];
                unset($_SESSION['deleteCategory_success']);
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
                <!-- check if the user is admin -->
                <?php if (isset($_SESSION['user_is_admin'])): ?>
                    <li>
                        <a href="addUser.php"><i class="fa-solid fa-user-plus"></i>
                            <h5>Add User</h5>
                        </a>
                    </li>
                    <li>
                        <a href="manageUsers.php"><i class="fa-solid fa-users"></i>
                            <h5>Manage Users</h5>
                        </a>
                    </li>
                    <li>
                        <a href="addCategory.php"><i class="fa-solid fa-pen-to-square"></i>
                            <h5>Add Category</h5>
                        </a>
                    </li>
                    <li>
                        <a href="manageCategory.php" class="active"><i class="fa-solid fa-list-ul"></i>
                            <h5>Manage Categories</h5>
                        </a>
                    </li>
                <?php endif ?>
            </ul>
        </aside>
        <main>
            <h2>Manage Categories</h2>
            <?php if (mysqli_num_rows($categories) > 0) : ?>
                <table  class="text-center">
                    <thead>
                        <tr >
                            <th>Title</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($category = mysqli_fetch_assoc($categories)) : ?>
                        <tr>
                            <td><?= $category['title'] ?></td>
                            <td><a href="<?= ROOT_URL ?>admin/editCategory.php?id=<?= $category['id'] ?>" class="btn sm">Edit</a></td>
                            <td><a href="<?= ROOT_URL ?>admin/deleteCategory.php?id=<?= $category['id'] ?>" class="btn sm danger">Delete</a></td>
                        </tr>
                        <?php endwhile ?>
                    </tbody>
                </table>
            <?php else :?>
                <div class="alert_message error"><?= "No categories are found!" ?></div>
            <?php endif ?>
        </main>
    </div>
</section>

<?php
include_once("../partials/footer.php"); ?>