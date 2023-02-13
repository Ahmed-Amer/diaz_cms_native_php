<?php


function get_featured_post()
{
    global $connection;  // for accessing global connection var
    $query_featured_post = "SELECT * FROM posts WHERE post_type = 'featured' ORDER By post_date DESC LIMIT 1";
    $featured_post = mysqli_query($connection, $query_featured_post);
    if (mysqli_num_rows($featured_post) > 0) {
        return $featured_post;
    }
    return false;
}


function get_all_categories()
{
    global $connection;  // for accessing global connection var
    $query_select_all_categories = "SELECT * FROM categories";
    $all_categories_results = mysqli_query($connection, $query_select_all_categories);
    if (mysqli_num_rows($all_categories_results) > 0) {
        return $all_categories_results;
    }
    return false;
}


function get_all_users()
{
    global $connection;  // for accessing global connection var
    $query_select_all_users = "SELECT * FROM users";
    $all_users_results = mysqli_query($connection, $query_select_all_users);
    if (mysqli_num_rows($all_users_results) > 0) {
        return $all_users_results;
    }
    return false;
}

// get user with id
function get_user($id)
{
    global $connection;  // for accessing global connection var
    $query_select_user = "SELECT * FROM users where id = $id LIMIT 1";
    $user_results = mysqli_query($connection, $query_select_user);
    if (mysqli_num_rows($user_results) > 0) {
        return $user_results;
    }
    return false;
}

// get post with id
function get_post($id)
{
    global $connection;  // for accessing global connection var
    $query_select_post = "SELECT * FROM posts where post_id = $id LIMIT 1";
    $post_results = mysqli_query($connection, $query_select_post);
    if (mysqli_num_rows($post_results) > 0) {
        return $post_results;
    }
    return false;
}

// get category with id
function get_category($id)
{
    global $connection;  // for accessing global connection var
    $query_select_category = "SELECT * FROM categories where cat_id = $id LIMIT 1";
    $category_results = mysqli_query($connection, $query_select_category);
    if (mysqli_num_rows($category_results) > 0) {
        return $category_results;
    }
    return false;
}

//get all posts
function get_all_posts()
{
    global $connection; // for accessing global connection var
    $query_select_all_posts = "SELECT * FROM posts";
    $all_posts_results = mysqli_query($connection, $query_select_all_posts);
    if (mysqli_num_rows($all_posts_results) > 0) {
        return $all_posts_results;
    }
    return false;
}

//get posts with specific category
function get_category_posts($category_id)
{
    global $connection; // for accessing global connection var
    $query_select_all_category_posts = "SELECT * FROM posts WHERE post_category_id=$category_id";
    $all_category_posts_results = mysqli_query($connection, $query_select_all_category_posts);
    if (mysqli_num_rows($all_category_posts_results) > 0) {
        return $all_category_posts_results;
    }
    return false;
}

//get all comments
function get_all_comments()
{
    global $connection; // for accessing global connection var
    $query_select_all_comments = "SELECT * FROM comments";
    $all_comments_results = mysqli_query($connection, $query_select_all_comments);
    if (mysqli_num_rows($all_comments_results) > 0) {
        return $all_comments_results;
    }
    return false;
}

//get all comments
function get_post_approved_comments($post_id)
{
    global $connection; // for accessing global connection var
    $query_select_all_post_comments = "SELECT * FROM comments WHERE comment_post_id = $post_id AND comment_status = 'approved' ORDER BY comment_id DESC";
    $all_post_comments_results = mysqli_query($connection, $query_select_all_post_comments);
    if (mysqli_num_rows($all_post_comments_results) > 0) {
        return $all_post_comments_results;
    }
    return false;
}


function unlink_img($post_id)
{
    global $connection; // for accessing global connection var
    $query_post_img = "SELECT * FROM posts WHERE post_id = $post_id LIMIT 1";
    $the_post_img = mysqli_query($connection, $query_post_img);
    $row = mysqli_fetch_assoc($the_post_img);
    $img_path = "../images/" . $row['post_image'];
    unlink($img_path);
}

function users_online()
{
    global $connection; // for accessing global connection var
    $session = session_id();
    $time = time();
    $time_out_in_seconds = 20;
    $time_out = $time - $time_out_in_seconds;

    $query = "SELECT * FROM users_online WHERE session = '$session'";
    $send_query = mysqli_query($connection, $query);

    $count = mysqli_num_rows($send_query);

    if ($count == NULL) {
        mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES('$session', '$time')");
    } else {
        mysqli_query($connection, "UPDATE users_online SET time = '$time' WHERE session = '$session'");
    }

    $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out'");
    $count_user = mysqli_num_rows($users_online_query);
    return $count_user;
}
