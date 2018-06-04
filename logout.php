<?php
require_once 'dbconnect.php';
$type=$_SESSION['type'];
$user = $_SESSION['username'];
if($type=="admin"){
  $sql = "UPDATE admin SET logged_in='no' WHERE username='$user'";
  $result = $connect->query($sql);
}
if($type=="client"){
  $sql = "UPDATE client SET logged_in='no' WHERE username='$user'";
  $result = $connect->query($sql);
}
if($type=="employee"){
    $sql = "UPDATE employee SET logged_in='no' WHERE username='$user' LIMIT 1";
    $result = $connect->query($sql);
}
if(isset($_SESSION['type']) && isset($_SESSION['username'])){
  $_SESSION['type'] = null;
  $_SESSION['username'] = null;
}elseif (isset($_SESSION['type']) && isset($_SESSION['username']) && isset($_SESSION['job_type'])) {
    $_SESSION['type'] = null;
    $_SESSION['username'] = null;
    $_SESSION['job_type'] = null;
}
session_destroy();
header("Location: index.php");
?>
