<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "store_management_system";

try 
{
  
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PdO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
  // echo "connect successfully";

} 


catch (PDOException $e) 
{
  echo "not connect -> ".$e->getMessage();
}



?>