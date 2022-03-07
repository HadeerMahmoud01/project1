<?php session_start(); ?>
<?php include "config.php"?>
<?php include "includes/header.php"?>
<?php include "includes/navbar.php"?>


<?php
if(isset($_GET["action"])){
    $do=$_GET["action"];
}else{
    $do="index";
}
?>


<?php if($do=="index"):?>
    <h1> hello from index page </h1>

<?php 
$stmt =$con->prepare("SELECT * FROM `customers`");
$stmt->execute();
$customers=$stmt->fetchAll();
?>

<div class="container">
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">username</th>
      <th scope="col">created_at</th>
      <th scope="col">controls</th>
    </tr>
  </thead>
  <tbody>
      <?php foreach ($customers as $customer):?>

    <tr>
      <th scope="row"><?=$customer['id']?></th>
      <td><?=$customer['username']?></td>
      <td><?=$customer['created-at']?></td>
      <td>
                <a class="btn btn-primary" href="?action=show&customerid=<?= $customer['id']?>">show</a>
                <a class="btn btn-primary" href="?action=edit&customerid=<?= $customer['id']?> ">edit</a>
                <!-- <a class="btn btn-primary">delete</a> -->
                
                
                <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal<?=$customer['id']?>">
  Delete
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal<?=$customer['id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
        <a class= "btn btn-primary" href="?action=delete&userid=<?=$customer['id']?>">yes</a>
      </div>
    </div>
  </div>
</div>

      </td>
    </tr>
<?php endforeach ?>
  </tbody>
</table>
<a class="btn btn-primary" href="?action=create">Add user</a>
</div>



 <?php elseif ($do=="create"):?>
    <h1 class="text-center">add user</h1>   
<div class="container">

<form method="post" action="?action=store">
<div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">username</label>
    <input type="text" class="form-control" name="username">
    
  </div>   
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Email address</label>
    <input type="email" class="form-control" name="email">
    
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="password" class="form-control" name="password">
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">phone</label>
    <input type="number" class="form-control" name="phone">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
 </div>


 <?php elseif ($do=="store"):?>
     
    <?php 
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $username=$_POST['username'];
        $email=$_POST['email'];
        $password=sha1($_POST['password']);
        $phone=$_POST['phone'];
    $stmt =$con->prepare("INSERT INTO `customers`( `email`, `username`, `password`, `role`, `phone`, `img`, `created-at`) VALUES (?,?,?,2,?,null,now())");  
    $stmt->execute(array($email,$username,$password,$phone));
    header("location:member.php");


    }else {
        echo "sorry";
    }







?>
    




 <?php elseif ($do=="edit"):?>

<?php 

$customerid = $_GET['customerid'];
$stmt = $con->prepare("SELECT * FROM `customers` WHERE `id` = ?");
$stmt->execute(array($customerid));
$customer = $stmt->fetch();
$count = $stmt->rowCount();
?>
<?php if($count ==1): ?>

    <h1>hello from edit page</h1> 
    <div class="container">

<form method="post" action="?action=storeupdate">
<input type="text" class="form-control" name="username" value="<?=$customer['id']?>"hidden>
    
<div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">username</label>
    <input type="text" class="form-control" name="username" value="<?=$customer['username']?>">
    
  </div>   
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Email address</label>
    <input type="email" class="form-control" name="email"value="<?=$customer['email']?>">
     
    
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="password" class="form-control" name="password">
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">phone</label>
    <input type="number" class="form-control" name="phone" value="<?=$customer['phone']?>">
    >
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
 </div>    
   <?php else:?>
   <script>
   window.history.back(); </script>
   <?php endif?> 














<?php elseif ($do=="update"):?>
    <h1>hello from update page</h1>

<?php if($_SERVER['REQUEST_METHOD']='POST'){
    $customerid=$_POST['id'];
    $username=$_POST['username'];
    $email=$_POST['email'];
    $phone=$_POST['phone'];

 
 $password= !empty($_POST['newpassword'])?sha1($_POST['nwepassword']):$_POST['oldpassword'];
 $stmt=$con->prepare("UPDATE `customers` SET `email`=?, `username`=?, `phone`=?,`password`=? WHERE `id`=?");
 $stmt->execute(array($email,$username,$phone,$password,$customerid));
 header("location:member.php");
 
 
 
 
 
 
 
  }
?>








    <?php elseif ($do=="show"):?>
      <?php
      $customerid =$_GET['customerid'];
      $stmt=$con->prepare("SELECT * FROM `customers`WHERE `id`=?");
      $stmt->execute(array($customerid));
      $customer=$stmt->fetch();
      echo"<pre>";
      print_r($customer);
      echo"<pre>";
      ?>









    <h1>hello from show page</h1>

 <?php elseif ($do=="delete"):?>
    <h1>hello from delete page</h1>  
    
    <?php
    $customerid=$_GET['userid'];
    $stmt=$con->prepare("DELETE FROM `customers` WHERE `id`=?");
    $stmt->execute(array($customerid));
    header("location:member.php");
    ?>
<?php else: ?>
        <h1> 404 page </h1>
<?php endif ?>










<?php include "includes/footer.php"?>