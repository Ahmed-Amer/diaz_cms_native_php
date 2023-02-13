<?php

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $post_id = $_GET['id'];
    $post_result = get_post($post_id);

    if ($post_result != false) {
        $row = mysqli_fetch_assoc($post_result);
        $post_category_id   = $row['post_category_id'];
        $post_title         = $row['post_title'];
        $user_id        = $row['user_id'];
        // $date_format      = new DateTime($row['post_date']);
        // $post_date          = $date_format->format('M d, Y');
        $date_date      = $row['post_date'];
        $post_image_before_update         = $row['post_image'];
        $post_content       = $row['post_content'];
        $post_tags          = $row['post_tags'];
        $post_comment_count = $row['post_comment_count'];
        $post_status        = $row['post_status'];
        $post_type        = $row['post_type'];
        $post_views_count = $row['post_views_count'];
    }
}
?>


<?php

if (isset($_POST['edit_post'])) {
    $post_title          = mysqli_real_escape_string($connection, trim($_POST['post_title']));
    $post_category_id    = mysqli_real_escape_string($connection, trim($_POST['post_category_id']));
    $user_id           = mysqli_real_escape_string($connection, trim($_POST['user_id']));  //to be changed later
    $post_status         = mysqli_real_escape_string($connection, trim($_POST['post_status']));
    $post_type         = mysqli_real_escape_string($connection, trim($_POST['post_type']));

    $post_image_after_update          = $_FILES['image']['name'];
    $post_image_tmp      = $_FILES['image']['tmp_name'];

    $post_tags           = mysqli_real_escape_string($connection, trim($_POST['post_tags']));
    $post_content        = mysqli_real_escape_string($connection, trim($_POST['post_content']));

    //$post_comment_count  = 4;


    if (empty($post_image_after_update)) {
        echo 'No image';
        //update query with the old image
        $query = "UPDATE posts SET post_category_id = $post_category_id, post_title = '$post_title', 
        user_id = $user_id, post_date = now(), 
        post_content = '$post_content', post_tags = '$post_tags', 
        post_status = '$post_status', post_type = '$post_type'
        WHERE post_id = $post_id";
    } else {
        echo 'image exists';
        //delete old image
        unlink_img($post_id); 
        //update query with new image
        $query = "UPDATE posts SET post_category_id = $post_category_id, post_title = '$post_title', 
        user_id = $user_id, post_date = now(), post_image = '$post_image_after_update',
        post_content = '$post_content', post_tags = '$post_tags', 
        post_status = '$post_status', post_type = '$post_type'
        WHERE post_id = $post_id";
        //upload new image
        move_uploaded_file($post_image_tmp, "../images/$post_image_after_update");
        //update view image at form
        $post_image_before_update = $post_image_after_update;
    }



    $result = mysqli_query($connection, $query);

    if (!$result) {
        echo "Failed. " . mysqli_error($connection);
    } else {
        //move_uploaded_file($post_image_tmp, "../images/$post_image");
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
        echo 'Post <strong>Updated</strong> Successfully';
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    }

    //header("Location: posts.php");

    // $the_get_post_id = mysqli_insert_id($connection);
    // echo "<p class='text-center text-success bg-success'>Post Created. <a href='../post.php?p_id=$the_get_post_id'> View Post</a> Or <a href='posts.php'>Edit More Posts</a></p>";
}


?>

<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="post_title">Post Title</label>
        <input type="text" value="<?= $post_title ?>" name="post_title" class="form-control">
    </div>

    <div class="form-group">
        <label for="post_category">Post Category</label>
        <select name="post_category_id" class="form-control">
            <?php
            $all_categories = get_all_categories();
            if ($all_categories != false) {
                while ($row = mysqli_fetch_assoc($all_categories)) {
                    $category_id            = $row['cat_id'];
                    $category_title         = $row['cat_title'];

                    if ($category_id == $post_category_id) {
                        echo "<option selected value='$category_id'>$category_title </option>";
                    } else {
                        echo "<option value='$category_id '>$category_title</option>";
                    }
                }
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="post_auhtor">Users</label>
        <select name="user_id" class="form-control">
            <?php
            $all_users = get_all_users();
            if ($all_users != false) {
                while ($row = mysqli_fetch_assoc($all_users)) {
                    $id            = $row['id'];
                    $username         = $row['username'];

                    if ($id == $user_id) {
                        echo "<option selected value='$id'> $username </option>";
                    } else {
                        echo "<option value='$id'> $username </option>";
                    }
                }
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="post_status">Post Status</label>
        <select name="post_status" class="form-control">

            <?php
            if ($post_status == 'draft') {
                echo '<option selected value="draft">Draft</option>';
                echo '<option value="published">Published</option>';
            } else {
                echo '<option value="draft">Draft</option>';
                echo '<option selected value="published">Publish</option>';
            }
            ?>

        </select>
    </div>

    <div class="form-group">
        <label for="post_type">Post Type</label>
        <select name="post_type" class="form-control">
            <?php
            if ($post_type == 'normal') {
                echo '<option selected value="normal">Normal</option>';
                echo '<option value="featured">Featured</option>';
            } else {
                echo '<option value="normal">Normal</option>';
                echo '<option selected value="featured">Featured</option>';
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <img style="width: 200px; height: 100px" class="img-responsive img-thumbnail" src="../images/<?=  $post_image_before_update ?>" alt="<?= $post_image_before_update ?>">
        <input type="file" name="image" class="form-control">
    </div>

    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" value="<?= $post_tags ?>" name="post_tags" class="form-control">
    </div>

    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea name="post_content" class="form-control" cols="30" rows="10"><?= $post_content ?></textarea>
    </div>
    <br>
    <div class="form-group">
        <input type="submit" value="Update Post" name="edit_post" class="btn btn-primary">
    </div>

</form>