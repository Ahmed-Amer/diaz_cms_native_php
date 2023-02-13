<div class="col-lg-4">
    <!-- Search widget-->
    <div class="card mb-4">
        <div class="card-header">Blog Search</div>
        <div class="card-body">
            <form action="search.php" method="get">
                <div class="input-group">
                    <input class="form-control" type="text" name="text-search" placeholder="Enter search term..." aria-label="Enter search term..." aria-describedby="button-search" />
                    <button class="btn btn-primary" id="button-search" type="submit" name="blog-search">Go!</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Login Form -->







    <div class="card mb-4">
        <?php if (isset($_SESSION['username'])) { ?>

            <h4>Logged in as <?php echo $_SESSION['username']; ?></h4>
            <a href="includes/logout.php" class='btn btn-warning'>Logout</a>

        <?php }else {?>
            <div class="card-header">Login</div>
            <div class="card-body">
                <form action="includes/login.php" method="post">
                    <div class="form-group">
                        <input type="text" name="username" class="form-control" placeholder="Username">
                    </div>
                    <div class="input-group">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                        <button class="btn btn-primary" id="button-search" type="submit" name="login">Login</button>
                    </div>
                    <!-- /.input-group -->
                </form>
            </div>
        <?php } ?>
    </div>


    <!-- Categories widget-->
    <div class="card mb-4">
        <div class="card-header">Categories</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <ul class="list-unstyled">
                        <?php
                        $query_select_categories_sidebar = "SELECT * FROM categories";
                        $categories_results = mysqli_query($connection, $query_select_categories_sidebar);
                        while ($row = mysqli_fetch_assoc($categories_results)) {
                            $cat_id = $row['cat_id'];
                            $cat_title = $row['cat_title'];
                        ?>
                            <li class="nav-item"><a class="nav-link" href="category.php?name=<?= $cat_title ?>&id=<?= $cat_id ?>"><?php echo $cat_title; ?></a></li>
                        <?php } ?>


                    </ul>
                </div>

            </div>
        </div>
    </div>


    <!-- Side widget-->
    <div class="card mb-4">
        <div class="card-header">Side Widget</div>
        <div class="card-body">You can put anything you want inside of these side widgets. They are easy to use, and feature the Bootstrap 5 card component!</div>
    </div>
</div>