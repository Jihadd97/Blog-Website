<?php
include_once("partials/header.php");

//fetch categories from database
$category_query = "SELECT * FROM categories";
$categories = mysqli_query($connection, $category_query);

//fetch post data from database if id is set
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM posts WHERE id=$id";
    $result = mysqli_query($connection, $query);
    $post = mysqli_fetch_assoc($result);
} else {
    header('location: ' . ROOT_URL . 'admin/');
    die();
}
?>

<section class="form_section">
    <div class="container form_section_container">
        <h2>Update Post</h2>
        <form action="<?= ROOT_URL ?>admin/editPost_logic.php" enctype="multipart/form-data" method="POST">
            <input type="hidden" name="id" value="<?= $post['id'] ?>">
            <input type="hidden" name="previous_thumbnail_name" value="<?= $post['thumbnail'] ?>">
            <input type="text" name="title" value="<?= htmlspecialchars($post['title']) ?>" placeholder="Post Title">

            <select name="category">
                <?php while ($category = mysqli_fetch_assoc($categories)) : ?>
                    <option value="<?= $category['id'] ?>" <?= $post['category_id'] == $category['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($category['title']) ?>
                    </option>
                <?php endwhile ?>
            </select>
            <textarea rows="10" name="body" placeholder="Body"><?= htmlspecialchars($post['body']) ?></textarea>
            <div class="form_control inline">
                <input type="checkbox" name="is_featured" id="is_featured" value="1" <?= $post['is_featured'] == 1 ? 'checked' : '' ?>>
                <label for="is_featured">Featured</label>
            </div>
            <div class="form_control">
                <label for="thumbnail">Change Thumbnail</label>
                <input type="file" name="thumbnail" id="thumbnail" accept="image/*">
                <!-- Thumbnail Preview -->
                <?php if (!empty($post['thumbnail'])): ?>
                    <div id="thumbnail_preview">
                        <img src="../images/<?= htmlspecialchars($post['thumbnail']) ?>"
                            alt="Thumbnail Preview"
                            style="width: 30%; object-fit: cover;">
                    </div>
                <?php endif; ?>
            </div>
            <button type="submit" name="submit" class="btn">Update Post</button>
        </form>
    </div>
</section>
<!------------------------------- END OF FORM ------------------------------------>

<?php
include_once("../partials/footer.php");
?>