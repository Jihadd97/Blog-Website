<?php
include_once("partials/header.php");

// fetch current user's posts from database
$current_userId = $_SESSION['userId'];
$query = "SELECT id, title, category_id FROM posts WHERE author_id=$current_userId ORDER BY id DESC";
$posts = mysqli_query($connection, $query);
?>



<section class="dashboard">
    <?php if (isset($_SESSION['addPost_success'])) : // shows if post is added successfully
    ?>
        <div class="alert_message success container">
            <p>
                <?= $_SESSION['addPost_success'];
                unset($_SESSION['addPost_success']);
                ?>
            </p>
        </div>
        <?php elseif (isset($_SESSION['addPost'])) : // shows if post is not added successfully
    ?>
        <div class="alert_message error container">
            <p>
                <?= $_SESSION['addPost'];
                unset($_SESSION['addPost']);
                ?>
            </p>
        </div>
        <?php elseif (isset($_SESSION['editPost_success'])) : // shows if post is updated successfully
    ?>
        <div class="alert_message success container">
            <p>
                <?= $_SESSION['editPost_success'];
                unset($_SESSION['editPost_success']);
                ?>
            </p>
        </div>
        <?php elseif (isset($_SESSION['editPost'])) : // shows if post is not updated successfully
    ?>
        <div class="alert_message error container">
            <p>
                <?= $_SESSION['editPost'];
                unset($_SESSION['editPost']);
                ?>
            </p>
        </div>
        <?php elseif (isset($_SESSION['deletePost_success'])) : // shows if post is deleted successfully
    ?>
        <div class="alert_message success container">
            <p>
                <?= $_SESSION['deletePost_success'];
                unset($_SESSION['deletePost_success']);
                ?>
            </p>
        </div>
        <?php elseif (isset($_SESSION['deletePost'])) : // shows if post is not deleted successfully
    ?>
        <div class="alert_message error container">
            <p>
                <?= $_SESSION['deletePost'];
                unset($_SESSION['deletePost']);
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
                    <a href="index.php" class="active"><i class="fa-solid fa-address-card"></i>
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
                        <a href="manageCategory.php"><i class="fa-solid fa-list-ul"></i>
                            <h5>Manage Categories</h5>
                        </a>
                    </li>
                <?php endif ?>
            </ul>
        </aside>
        <main>
            <h2>Manage Posts</h2>
            <?php if (mysqli_num_rows($posts) > 0) : ?>
                <table class="text-center">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($post = mysqli_fetch_assoc($posts)) : ?>
                            <!-- get category title of each post from categories table-->
                            <?php
                            $category_id = $post['category_id'];
                            $category_query = "SELECT title from categories WHERE id= $category_id";
                            $category_result = mysqli_query($connection, $category_query);
                            $category = mysqli_fetch_assoc($category_result);
                            ?>
                            <tr>
                                <td><?= $post['title'] ?></td>
                                <td><?= $category['title'] ?></td>
                                <td><a href="<?= ROOT_URL ?>admin/editPost.php?id=<?= $post['id'] ?>" class="btn sm ">Edit</a></td>
                                <td><a href="<?= ROOT_URL ?>admin/deletePost.php?id=<?= $post['id'] ?>" class="btn sm danger">Delete</a></td>
                            </tr>
                        <?php endwhile ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="alert_message error"><?= "No posts found!" ?></div>
            <?php endif ?>
        </main>
    </div>
</section>

<?php
include_once("../partials/footer.php");
?>