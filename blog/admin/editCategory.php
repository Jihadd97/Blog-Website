<?php
include_once("partials/header.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // fetch category from database
    $query = "SELECT * FROM categories WHERE id=$id";
    $result = mysqli_query($connection, $query);
    if (mysqli_num_rows($result) == 1) {
        $category = mysqli_fetch_assoc($result);
    }
} else {
    header('location: ' . ROOT_URL . 'admin/manageCategory.php');
    die();
}
?>

<section class="form_section">
    <div class="container form_section_container">
        <h2>Update Category</h2>
        <form action="<?= ROOT_URL ?>admin/editCategory_logic.php" method="POST">
            <input type="hidden" name="id" value="<?= $category['id'] ?>">
            <input type="text" name="title" value="<?= $category['title'] ?>" placeholder="Post Title">
            <textarea rows="4" name="description" placeholder="Description"><?= $category['description'] ?></textarea>
            <button type="submit" name="submit" class="btn">Update Category</button>
        </form>
    </div>
</section>
<!------------------------------- END OF FORM ------------------------------------>

<?php
include_once("../partials/footer.php");
?>