<!-- Responsive navbar-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="index.php">CMS</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <?php
                            $query_select_categories = "SELECT * FROM categories LIMIT 5";
                            $categories_results = mysqli_query($connection , $query_select_categories);
                            while($row = mysqli_fetch_assoc($categories_results)){
                                $cat_id = $row['cat_id'];
                                $cat_title = $row['cat_title'];
                            ?>
                                <li class="nav-item"><a class="nav-link" href="category.php?name=<?= $cat_title ?>&id=<?= $cat_id ?>"><?php echo $cat_title; ?></a></li>
                            <?php }?>
                            <li class="nav-item"><a class="nav-link" href="./admin/posts.php">Admin</a></li>
                      
                    </ul>
                </div>
            </div>
        </nav>