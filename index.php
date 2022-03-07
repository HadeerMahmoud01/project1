<?php session_start(); ?>
<?php include "config.php"?>
<?php 


if($_SERVER['REQUEST_METHOD']=="POST"){
$email = $_POST['adminemail'];
$password =sha1( $_POST['adminpassword']);
$stmt =$con->prepare("SELECT * FROM `customers` WHERE `email`=? AND `password` =? AND `role`=1");
$stmt->execute(array($email,$password));

$count =$stmt->rowCount();
$user = $stmt->fetch();



if($count==1){
    $_SESSION['ID'] =$user['id'];
    $_SESSION['USERNAME']=$user['username'];
    $_SESSION['Email']=$user['email'];
    $_SESSION['ROLE']=$user['role'];
    header("location:dashboard.php");
}else{
    echo "sorry donot have a permission";
}

}
?>

<?php 
if(isset($_GET['lang'])&& $_GET['lang']=='ar'){
include"lang/ar.php";
} else{
  include"lang/en.php";
}

if(isset($_GET['lang'])){
  $_SESSION['lang']=$_GET['lang'];
}
?>














<?php include "includes/header.php"?>
 <?php include "lang/ar.php"?>
 <a href="?lang-en">ENGLISH</a> <a href="?lang-ar"> عربي</a>
<form method="post" action="index.php">
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label"><?=$lang['email']?></label>
    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="adminemail">
    <div id="emailHelp" class="form-text">.</div>
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label"><?=$lang['password']?></label>
    <input type="password" class="form-control" id="exampleInputPassword1" name="adminpassword">
  </div>
  
  <button type="submit" class="btn btn-primary"><?=$lang['login']?></button>
</form>
<?php include "includes/footer.php"?>