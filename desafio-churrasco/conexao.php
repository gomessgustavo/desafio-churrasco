<?php
$dbHost = "localhost:3306";
$dbUser = "root";
$dbPass = "";
$dbDataBase = "desafiochurrasco";

$conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbDataBase);
 
if($conn === false){
  die('Error: connection error. '.mysqli_connect_error());
}
?> 