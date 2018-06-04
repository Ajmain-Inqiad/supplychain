<?php require_once ('dbconnect.php'); ?>
<?php
if(isset($_POST["id"])){
  $id = $_POST['id'];
  $connect->query("DELETE FROM employee WHERE id='$id'");
  echo "success";
}

?>
