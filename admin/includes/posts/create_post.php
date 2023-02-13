<?php

if (isset($_POST['create_post'])) {
    $post_title          = mysqli_real_escape_string($connection, trim($_POST['post_title']));
    $post_category_id    = mysqli_real_escape_string($connection, trim($_POST['post_category_id']));
    $user_id           = mysqli_real_escape_string($connection, trim($_POST['user_id']));  //to be changed later
    $post_status         = mysqli_real_escape_string($connection, trim($_POST['post_status']));
    $post_type         = mysqli_real_escape_string($connection, trim($_POST['post_type']));

    $post_image          = $_FILES['image']['name'];
    $post_image_tmp      = $_FILES['image']['tmp_name'];

    $post_tags           = mysqli_real_escape_string($connection, trim($_POST['post_tags']));
    $post_content        = mysqli_real_escape_string($connection, trim($_POST['post_content']));

    //$post_comment_count  = 4;


    

    $query = "INSERT INTO posts (post_category_id, user_id, post_title, post_date, post_image, 
                post_content, post_tags, post_status, post_type) VALUES($post_category_id, $user_id ,
                '$post_title', now(), '$post_image', '$post_content', '$post_tags',  
                '$post_status', '$post_type')";

    $result = mysqli_query($connection, $query);

    if (!$result) {
        echo "Failed. " . mysqli_error($connection);
    } else {
        move_uploaded_file($post_image_tmp, "../images/$post_image");
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
        echo 'Post <strong>Created</strong> Successfully';
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
        <input type="text" name="post_title" class="form-control">
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

            ?>
                <option value='<?= $category_id ?>'><?= $category_title ?></option>
            <?php
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

            ?>
                <option value='<?= $id ?>'><?= $username ?></option>
            <?php
                }
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="post_status">Post Status</label>
        <select name="post_status" class="form-control">
            <option value="draft">Select Options</option>
            <option value="published">Publish</option>
            <option value="draft">Draft</option>
        </select>
    </div>

    <div class="form-group">
        <label for="post_type">Post Type</label>
        <select name="post_type" class="form-control">
            <option value="normal">Select Options</option>
            <option value="featured">Featured</option>
            <option value="normal">normal</option>
        </select>
    </div>

    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name="image" class="form-control">
    </div>

    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" name="post_tags" class="form-control">
    </div>

    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea name="post_content" class="form-control" cols="30" rows="10"></textarea>
    </div>
    <br>
    <div class="form-group">
        <input type="submit" value="Publish Post" name="create_post" class="btn btn-primary">
    </div>

</form>