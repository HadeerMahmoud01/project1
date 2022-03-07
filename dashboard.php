<?php session_start(); ?>
<?php include "config.php"?>
<?php include "includes/header.php"?>



<?php

if(isset($_SESSION['lang']) &&  $_SESSION['lang']=='ar'){
    include "lang/ar.php";
}else{
    include "lang/ar.php";
}









?>

<?php include "includes/navbar.php"?>




<?php include "includes/footer.php"?>