<?php

//post delete

if (isset($_GET['delete']) && !empty($_GET['delete'])) {

    $delete_post_id = mysqli_real_escape_string($connection, trim($_GET['delete']));

    unlink_img($delete_post_id);

    $query = "DELETE FROM posts WHERE post_id = $delete_post_id LIMIT 1";
    $result = mysqli_query($connection, $query);

    if (!$result) {
        echo "Failed. " . mysqli_error($connection);
    } else {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
        echo 'Post <strong>Created</strong> Successfully';
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    }

    // header("Location: posts.php");
}

?>



<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
    </div>
    <div class="card-body">
        <table id="datatablesSimple" style="font-size: 12px;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Image</th>
                    <th>Tags</th>
                    <th>Comments</th>
                    <th>Date</th>
                    <th>View</th>
                    <th>Edit</th>
                    <th>Delete</th>
                    <th>Views</th>
                </tr>
            </thead>
         
            <tbody>
                <?php
                $all_posts = get_all_posts();
                if ($all_posts != false) {
                    while ($row = mysqli_fetch_assoc($all_posts)) {
                        $post_id            = $row['post_id'];
                        $post_category_id   = $row['post_category_id'];
                        $post_title         = $row['post_title'];
                        $user_id        = $row['user_id'];
                        $date_format      = new DateTime($row['post_date']);
                        $post_date          = $date_format->format('M d, Y');
                        $post_image         = $row['post_image'];
                        $post_content       = substr($row['post_content'], 0, 20);
                        $post_tags          = $row['post_tags'];
                        $post_comment_count = $row['post_comment_count'];
                        $post_status        = $row['post_status'];
                        $post_views_count = $row['post_views_count'];
                ?>

                        <tr>
                            <td><?= $post_id ?></td>

                            <!-- username -->
                            <td>
                                <?php
                                $user_result = get_user($user_id);
                                if ($user_result != false) {
                                    $row = mysqli_fetch_assoc($user_result);
                                    echo $row['username'];
                                }
                                ?>
                            </td>


                            <td><?= $post_title ?></td>
                            <td>
                                <?php
                                $category_result = get_category($post_category_id);
                                if ($category_result != false) {
                                    $row = mysqli_fetch_assoc($category_result);
                                    echo $row['cat_title'];
                                }
                                ?>

                            </td>
                            <td><?= $post_status ?></td>
                            <td><img class='img-responsive img-thumbnail' width='100' src='../images/<?= $post_image ?>'></td>
                            <td><?= $post_tags ?></td>
                            <td><?= $post_comment_count ?></td>
                            <td><?= $post_date ?></td>
                            <td><a class='btn btn-sm btn-primary' href='#'>View</a></td>
                            <td><a class='btn btn-sm btn-success' href='posts.php?action=edit&id=<?= $post_id ?>'>Edit</a></td>
                            <td><a class='btn btn-sm btn-danger' href='posts.php?delete=<?= $post_id ?>'>Delete</a></td>
                            <td><?= $post_views_count ?></td>
                        </tr>
                <?php
                    }
                }
                ?>


            </tbody>
        </table>
    </div>
</div>