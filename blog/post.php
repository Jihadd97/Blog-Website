<?php
include_once("partials/header.php");

// fetch posts from database if id is set
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM posts WHERE id=$id";
    $result = mysqli_query($connection, $query);
    $post = mysqli_fetch_assoc($result);
} else {
    header('location: ' . ROOT_URL . 'blog.php');
    die();
}
?>

<section class="singlePost">
    <div class="container singlePost_container">
        <h2><?= $post['title'] ?></h2>

        <div class="post_author">
            <?php
            // fetch author from users table using author_id
            $author_id = $post['author_id'];
            $author_query = "SELECT * FROM users WHERE id=$author_id";
            $author_result = mysqli_query($connection, $author_query);
            $author = mysqli_fetch_assoc($author_result);
            ?>
            <div class="post_author_avatar">
                <img src="images/<?= $author['avatar'] ?>" alt="author2">
            </div>
            <div class="author_info">
                <h5>By : <?= "{$author['firstname']} {$author['lastname']}" ?></h5>
                <small><?= date("M d, Y - H:i", strtotime($post['date_time'])) ?></small>
            </div>
        </div>
        <div class="singlePost_thumbnail">
            <img src="images/<?=$post['thumbnail']?>" alt="Art">
        </div>
        <p>
            <?=$post['body']?>
        </p>
        <p>

    </div>
</section>

<!---------------------------------- END OF SINGLE POST  ------------------------------------>

<?php
include_once("partials/footer.php");
?>