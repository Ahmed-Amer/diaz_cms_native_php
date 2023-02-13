<?php include_once "config/db.php"; ?>
<?php include_once "functions/functions.php"; ?>
<?php include_once "includes/header.php"; ?>

<!-- Responsive navbar-->
<?php include_once "includes/navbr.php"; ?>


<!-- Page content-->
<div class="container" style="margin-top: 50px;">
    <div class="row">
        <!-- Blog entries-->
        <div class="col-lg-8">

            <!-- Nested row for non-featured blog posts-->
            <div class="row">
                <?php
                if (isset($_GET['id']) && !empty($_GET['id'])) {
                    $category_id = $_GET['id'];
                    $all_category_posts = get_category_posts($category_id);

                    if ($all_category_posts != false) {
                        while ($row = mysqli_fetch_assoc($all_category_posts)) {
                            $post_id            = $row['post_id'];
                            $post_category_id   = $row['post_category_id'];
                            $post_title         = $row['post_title'];
                            $user_id        = $row['user_id'];
                            $date_format      = new DateTime($row['post_date']);
                            $post_date          = $date_format->format('M d, Y');
                            $post_image         = $row['post_image'];
                            $post_content       = substr($row['post_content'], 0, 50);
                            $post_tags          = $row['post_tags'];
                            $post_comment_count = $row['post_comment_count'];
                            $post_status        = $row['post_status'];
                ?>


                            <div class="col-lg-6">
                                <!-- Blog post-->
                                <div class="card mb-4">
                                    <a href="post.php?id=<?= $post_id ?>"><img class="card-img-top" style="max-height: 200px;" src="./images/<?= $post_image ?>" alt="..." /></a>
                                    <div class="card-body">
                                        <div class="small text-muted"><?= $post_date ?></div>
                                        <h2 class="card-title h4"><?= $post_title ?></h2>
                                        <p class="card-text"><?= $post_content . "..." ?></p>
                                        <a class="btn btn-primary" href="post.php?id=<?= $post_id ?>">Read more →</a>
                                    </div>
                                </div>

                            </div>

                <?php
                        }
                    }else{?>
                        <div class="col-lg-6">
                            <h2>No Posts </h2>
                        </div>
                 <?php   }
                }
                ?>


            </div>
            <!-- Pagination-->
            <nav aria-label="Pagination">
                <hr class="my-0" />
                <ul class="pagination justify-content-center my-4">
                    <li class="page-item disabled"><a class="page-link" href="#" tabindex="-1" aria-disabled="true">Newer</a></li>
                    <li class="page-item active" aria-current="page"><a class="page-link" href="#!">1</a></li>
                    <li class="page-item"><a class="page-link" href="#!">2</a></li>
                    <li class="page-item"><a class="page-link" href="#!">3</a></li>
                    <li class="page-item disabled"><a class="page-link" href="#!">...</a></li>
                    <li class="page-item"><a class="page-link" href="#!">15</a></li>
                    <li class="page-item"><a class="page-link" href="#!">Older</a></li>
                </ul>
            </nav>
        </div>


        <!-- Side widgets-->
        <?php include_once "includes/sidebar.php"; ?>

    </div>
</div>
<!-- Footer-->
<?php include_once "includes/footer.php"; ?>