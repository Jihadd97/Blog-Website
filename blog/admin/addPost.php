<?php
include_once("partials/header.php");

// fetch categories from database
$query = "SELECT * FROM categories";
$categories = mysqli_query($connection, $query);

// get back form data if form was invalid
$title = $_SESSION['addPost_data']['title'] ?? null;
$body = $_SESSION['addPost_data']['body'] ?? null;

// delete form data session
unset($_SESSION['addPost_data']);

?>


<section class="form_section">
    <div class="container form_section_container">
        <h2>Add Post</h2>
        <?php if (isset($_SESSION['addPost'])): ?>
            <div class="alert_message error">
                <p>
                    <?= $_SESSION['addPost'];
                    unset($_SESSION['addPost']);

                    ?>
                </p>
            </div>
        <?php endif ?>
        <form action="<?= ROOT_URL ?>admin/addPost_logic.php" enctype="multipart/form-data" method="POST">
            <input type="text" name="title" value="<?=$title?>" placeholder="Post Title">
            <select name="category">
                <?php while ($category = mysqli_fetch_assoc($categories)): ?>
                    <option value="<?= $category['id'] ?>"><?= $category["title"] ?></option>
                <?php endwhile ?>
            </select>
            <textarea rows="10" name="body" placeholder="Body"<?=$body?>></textarea>

            <!-- this condition for allowing only the admin to feature a post -->
            <?php if (isset($_SESSION['user_is_admin'])): ?>
                <div class="form_control inline">
                    <input type="checkbox" name="is_featured" value="1" id="is_featured" checked>
                    <label for="is_featured">Featured</label>
                </div>
            <?php endif ?>
            <div class="form_control">
                <label for="thumbnail">Add thumbnail</label>
                <input type="file" name="thumbnail" id="thumbnail">
            </div>
            <button type="submit" name="submit" class="btn">Add Post</button>
        </form>
    </div>
</section>
<!------------------------------- END OF FORM ------------------------------------>


<?php
include_once("../partials/footer.php");
?>