<?php
include_once("partials/header.php");

// fetch posts if id is set
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM posts WHERE category_id=$id ORDER BY date_time DESC";
    $posts = mysqli_query($connection, $query);
} else {
    header('location: ' . ROOT_URL . 'blog.php');
    die();
}

?>

<header class="categoryTitle">
    <h2><?php
    // fetch category from categories table using category_id of post

    $category_id = $id;
    $category_query = "SELECT * FROM categories WHERE id=$id";
    $category_result = mysqli_query($connection, $category_query);
    $category = mysqli_fetch_assoc($category_result);
    echo $category['title'];
    ?>
    </h2>
</header>

<!------------------------------- END OF CATEGORY TITLE ------------------------------------>

<section class="posts">
    <div class="container posts_container">
        <?php while ($post = mysqli_fetch_assoc($posts)): ?>
            <article class="post">
                <div class="post_thumbnail">
                    <img src="images/<?= $post['thumbnail'] ?>">
                </div>
                <div class="post_info">
        
                    <h3 class="post_title">
                        <a href="<?= ROOT_URL ?>post.php?id=<?= $post['id'] ?>"><?=  substr($post['title'],0,50) ?>..</a>
                    </h3>
                    <p class="post_body">
                        <?= substr($post['body'], 0, 150) ?>...
                    </p>

                    <div class="post_author">
                        <?php
                        // fetch author from users table using author_id
                        $author_id = $post['author_id'];
                        $author_query = "SELECT * FROM users WHERE id=$author_id";
                        $author_result = mysqli_query($connection, $author_query);
                        $author = mysqli_fetch_assoc($author_result);
                        ?>
                        <div class="post_author_avatar">
                            <img src="images/<?= $author['avatar'] ?>" alt="author1">
                        </div>
                        <div class="author_info">
                            <h5>By : <?= "{$author['firstname']} {$author['lastname']}" ?></h5>
                            <small><?= date("M d, Y - H:i", strtotime($post['date_time'])) ?></small>
                        </div>
                    </div>
                </div>
            </article>
        <?php endwhile ?>
    </div>
</section>
<!------------------------------ END OF POSTS ---------------------------------->

<section class="category_btns">
    <div class="container category_btns_container">
        <?php
        $all_categories = "SELECT * FROM categories";
        $all_categories_result = mysqli_query($connection, $all_categories);
        ?>
        <?php while ($category = mysqli_fetch_assoc($all_categories_result)): ?>
            <a href="<?= ROOT_URL ?>categoryPosts.php?id=<?= $category['id'] ?>" class="category_btn"><?= $category['title'] ?></a>
        <?php endwhile ?>
    </div>
</section>
<!------------------------------ END OF CATEGORY BUTTONS---------------------------------->

<?php
include_once("partials/footer.php");
?>
