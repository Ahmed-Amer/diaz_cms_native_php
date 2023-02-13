<?php include_once "config/db.php"; ?>
<?php include_once "functions/functions.php"; ?>
<?php include_once "includes/header.php"; ?>


<?php
if(isset($_SESSION['username'])){
    echo 'profile ' . $_SESSION['username'];
}
?>

