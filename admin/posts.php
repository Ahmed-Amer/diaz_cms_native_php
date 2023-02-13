<?php include_once "../config/db.php"; ?>
<?php include_once "../functions/functions.php"; ?>
<!-- header -->
<?php include_once "includes/header.php"; ?>

<!-- top navbar -->
<?php include_once "includes/navbar.php"; ?>




<div id="layoutSidenav">

    <!-- side navbar -->
    <?php include_once "includes/sidenav.php"; ?>

    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">

                <?php $action = isset($_GET['action']) ? $_GET['action'] : null; ?>

                <h1 class="mt-4">Manage Posts</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">
                        <!-- show correct breadcrumb -->
                        <?php
                        if (empty($action) || $action == 'view') {
                            echo 'View All';
                        } elseif ($action == 'edit') {
                            echo 'Edit Post';
                        }elseif ($action = 'create'){
                            echo 'Create Post';
                        }
                        ?>
                    </li>
                </ol>

                <?php
                switch ($action) {
                    case 'view':
                        include_once "includes/posts/view_all_posts.php";
                        break;
                    case 'create':
                        include_once "includes/posts/create_post.php";
                        break;
                    case 'edit':
                        include_once "includes/posts/edit_post.php";
                        break;
                    default:
                        include_once "includes/posts/view_all_posts.php";
                        break;
                }
                ?>



            </div>
        </main>

        <!-- footer -->
        <?php include_once "includes/footer.php"; ?>

    </div>
</div>

<!-- footer scripts -->
<?php include_once "includes/scripts.php"; ?>

</body>

</html>