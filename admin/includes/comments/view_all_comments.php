<?php

//comment delete

if (isset($_GET['delete']) && !empty($_GET['delete'])) {

    $delete_comment_id = mysqli_real_escape_string($connection, trim($_GET['delete']));


    $query = "DELETE FROM comments WHERE comment_id = $delete_comment_id LIMIT 1";
    $result = mysqli_query($connection, $query);

    if (!$result) {
        echo "Failed. " . mysqli_error($connection);
    } else {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
        echo 'Comment <strong>Deleted</strong> Successfully';
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    }

    // header("Location: posts.php");
}



//comment approve

if (isset($_GET['approve']) && !empty($_GET['approve'])) {

    $approve_comment_id = mysqli_real_escape_string($connection, trim($_GET['approve']));


    $query = "UPDATE comments set comment_status = 'approved' WHERE comment_id = $approve_comment_id";
    $result = mysqli_query($connection, $query);

    if (!$result) {
        echo "Failed. " . mysqli_error($connection);
    } else {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
        echo 'Comment <strong>Approved</strong> Successfully';
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
                    <th>Post Id</th>
                    <th>Author</th>
                    <th>Comment</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>In Response To</th>
                    <th>Date</th>
                    <th>Approve</th>
                    <th>Delete</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $all_comments = get_all_comments();
                if ($all_comments != false) {
                    while ($row = mysqli_fetch_assoc($all_comments)) {
                        $comment_id         = $row['comment_id'];
                        $comment_post_id    = $row['comment_post_id'];
                        $comment_author    = $row['comment_author'];
                        $comment_email      = $row['comment_email'];
                        $comment_content    = $row['comment_content'];
                        $comment_status     = $row['comment_status'];
                        $comment_date       = $row['comment_date'];
                ?>


                        <tr>
                            <td><?= $comment_id ?></td>
                            <td><?= $comment_post_id ?></td>
                            <!-- username -->
                            <td><?= $comment_author ?></td>


                            <td><?= $comment_content ?></td>
                            <td><?= $comment_email ?></td>
                            <td><?= $comment_status ?></td>
                            <td>
                                <?php
                                $post_result = get_post($comment_post_id);

                                if ($post_result != false) {
                                    $post_raw = mysqli_fetch_assoc($post_result);
                                    $post_title         = $post_raw['post_title']; 
                                }
                                ?>
                               <a href='./../post.php?id=<?= $comment_post_id ?>'><?= $post_title ?></a>
                               

                            </td>
                            <td><?= $comment_date ?></td>
                            <td><a class='btn btn-sm btn-success' href='comments.php?approve=<?= $comment_id ?>'>Approve</a></td>
                            <td><a class='btn btn-sm btn-danger' href='comments.php?delete=<?= $comment_id ?>'>Delete</a></td>
                        </tr>


                <?php
                    }
                }
                ?>


            </tbody>
        </table>
    </div>
</div>