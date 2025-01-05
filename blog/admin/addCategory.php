<?php
    include_once("partials/header.php");
    // get back form data if there was a registeration error
$title = $_SESSION["addCategory_data"]["title"] ?? null;
$description = $_SESSION["addCategory_data"]["description"] ?? null;

unset($_SESSION["addCategory_data"]);
?>

<section class="form_section">
    <div class="container form_section_container">
        <h2>Add Category</h2>
        <?php if (isset($_SESSION['addCategory'])): ?>
            <div class="alert_message error">
                <p>
                    <?= $_SESSION['addCategory'];
                    unset($_SESSION['addCategory']);

                    ?>
                </p>
            </div>
        <?php endif ?>
        <form action="<?=ROOT_URL?>admin/addCategory_logic.php" method="POST">
            <input type="text" value="<?= $title ?>" name="title" placeholder="Post Title" >
            <textarea  rows="4"name="description" placeholder="Description" <?= $description ?> ></textarea>
            <button type="submit" name="submit" class="btn">Add Category</button>
        </form>
    </div>
</section>
    <!------------------------------- END OF FORM ------------------------------------>


    <?php
    include_once("../partials/footer.php");
?>