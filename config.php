<?php



$dsn = "mysql:host=localhost;dbname=php63";
$username="root";
$password="";




// exception handling
try{
$con = new PDO($dsn , $username , $password);

}


catch(PDOException $e){
echo $e;
}







?>