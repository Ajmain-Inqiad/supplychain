<?php
session_start();
$host = "localhost";
$user = "root";
$password = "";
$connect = new mysqli($host, $user, $password);

if($connect->connect_error){
  die("Connection failed" . $connect->connect_error);
}
else{
  $sql = "CREATE DATABASE supplychain";
  if($connect->query($sql)){
    $connect->select_db("supplychain");
  }else{
    $connect->select_db("supplychain");
  }
}

?>
