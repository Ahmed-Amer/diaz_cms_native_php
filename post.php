<?php include_once "config/db.php"; ?>
<?php include_once "functions/functions.php"; ?>
<?php include_once "includes/header.php"; ?>

<!-- Responsive navbar-->
<?php include_once "includes/navbr.php"; ?>


<!-- Page Content -->
<div class="container" style="margin-top: 50px; margin-bottom: 50px">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">


            <?php

            if (isset($_GET['id']) && !empty($_GET['id'])) {
                $post_id = $_GET['id'];
                $post_result = get_post($post_id);

                if ($post_result != false) {
                    $post_raw = mysqli_fetch_assoc($post_result);
                    $post_category_id   = $post_raw['post_category_id'];
                    $post_title         = $post_raw['post_title'];
                    $user_id        = $post_raw['user_id'];
                    $date_format      = new DateTime($post_raw['post_date']);
                    $post_date          = $date_format->format('M d, Y');
                    $post_image         = $post_raw['post_image'];
                    $post_content       = $post_raw['post_content'];
                    $post_tags          = $post_raw['post_tags'];
                    $post_comment_count = $post_raw['post_comment_count'];
                    $post_status        = $post_raw['post_status'];
                    $post_type        = $post_raw['post_type'];
                    $post_views_count = $post_raw['post_views_count'];
                } else {
                    echo "<h2 class='text-center text-danger'>No posts</h2>";
                }
            }
            ?>

            <?php
            //get user name
            $post_user_result = get_user($user_id);
            if ($post_user_result != false) {
                $user_raw = mysqli_fetch_assoc($post_user_result);
                $username        = $user_raw['username'];
            }

            ?>

            <!-- First Blog Post -->
            <h2>
                <?php echo $post_title; ?>
            </h2>
            <p class="lead">
                by <a href="#"><?php echo $username; ?></a>
            </p>
            <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date; ?></p>
            <hr>
            <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
            <hr>
            <p><?php echo $post_content; ?></p>


            <hr>


            <!-- Blog Comments -->

            <?php

            if (isset($_POST['create_comment'])) {
                $comment_post_id = $_GET['id'];

                $comment_author = mysqli_real_escape_string($connection, trim($_POST['comment_author']));
                $comment_email  = mysqli_real_escape_string($connection, trim($_POST['comment_email']));
                $commet_content = mysqli_real_escape_string($connection, trim($_POST['comment_content']));

                if (!empty($comment_author) && !empty($comment_email) && !empty($commet_content)) {
                    $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, 
                            comment_content) VALUES($comment_post_id, 
                            '$comment_author', '$comment_email', '$commet_content')";

                    $result = mysqli_query($connection, $query);

                    if (!$result) {
                        die("Query failed " . mysqli_error($connection));
                    }

                    // $query = "UPDATE posts SET post_comment_count = post_comment_count + 1 
                    //         WHERE post_id = $the_get_post_id";
                    // $increasing_commet_count = mysqli_query($connection, $query);
                } else {
                    echo "<script>alert('Fields cannot be empty')</script>";
                }
            }

            ?>


            <!-- Comments Form -->
            <div class="well">
                <h4>Leave a Comment:</h4>
                <form action="" method="post" role="form">
                    <div class="form-group">
                        <label for="comment_author">Author</label>
                        <input type="text" name="comment_author" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="comment_email">Email</label>
                        <input type="email" name="comment_email" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="comment_content">Content</label>
                        <textarea name="comment_content" class="form-control" rows="3"></textarea>
                    </div>

                    <button name="create_comment" type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>

            <hr> <h2>Comments</h2> <hr>

            <!-- Posted Comments -->
            <?php
            $all_comments = get_post_approved_comments($post_id);
            if ($all_comments != false) {
                while ($row = mysqli_fetch_assoc($all_comments)) {
                    $comment_id         = $row['comment_id'];
                    $comment_author    = $row['comment_author'];
                    $comment_email      = $row['comment_email'];
                    $comment_content    = $row['comment_content'];
                    $comment_date       = $row['comment_date'];

            ?>

                        <!-- Comment -->
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <img src="http://placehold.it/64x64" alt="...">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="mt-0"><?php echo $comment_author; ?> </h5><small><?php echo $comment_date;
                                                                                        ?> </small>
                            <?php echo $comment_content;
                            ?>
                        </div>
                    </div> <hr>

      
            <?php
                }
            }
            ?>

        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include("includes/sidebar.php"); ?>

    </div>
    <!-- /.row -->
</div>


<?php include("includes/footer.php"); ?>