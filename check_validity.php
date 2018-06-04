<?php
require_once "dbconnect.php";
if(isset($_POST['type'])){
  $type=$_POST['type'];
  if($type=="updateclientname"){
    $sessionusername = $_SESSION['username'];
    $username = $_POST['user'];
    $query = "SELECT username FROM client WHERE username LIKE '%$username%' ";
    $result = $connect->query($query);
    $query2 = "SELECT username FROM admin WHERE username LIKE '%$username%' ";
    $result2 = $connect->query($query2);
    $query3 = "SELECT username FROM employee WHERE username LIKE '%$username%' ";
    $result3 = $connect->query($query3);
    if($result->num_rows > 0){
      $row = $result->fetch_assoc();
      if($sessionusername == $row['username']){
        echo "<p style='color:blue'>Username is yours</p>";
      }else{
        echo "<p style='color:red'>Username is in use already</p>";
      }
  }elseif($result2->num_rows > 0){
      $row2 = $result2->fetch_assoc();
      if($sessionusername == $row2['username']){
        echo "<p style='color:blue'>Username is yours</p>";
      }else{
        echo "<p style='color:red'>Username is in use already</p>";
      }
  }elseif ($result3->num_rows > 0) {
      $row3 = $result3->fetch_assoc();
      if($sessionusername == $row3['username']){
        echo "<p style='color:blue'>Username is yours</p>";
      }else{
        echo "<p style='color:red'>Username is in use already</p>";
      }
  }else{
      echo "<p style='color:green'>Username is valid</p>";
    }
}elseif ($type == "price") {
    $product = $_POST['product'];
    $amount = $_POST['amount'];
    $query = "SELECT price FROM product WHERE name = '$product'";
    $result = $connect->query($query);
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $cost = $amount * $row['price'];
        echo $cost;
    }
}elseif ($type=="addemp") {
    $username = $_POST['user'];
    $query = "SELECT username FROM client WHERE username LIKE '%$username%' ";
    $result = $connect->query($query);
    $query2 = "SELECT username FROM admin WHERE username LIKE '%$username%' ";
    $result2 = $connect->query($query2);
    $query3 = "SELECT username FROM employee WHERE username LIKE '%$username%' ";
    $result3 = $connect->query($query3);
    if($result->num_rows > 0){
      echo "<p style='color:red'>Username is in use already</p>";
  }elseif($result2->num_rows > 0){
      echo "<p style='color:red'>Username is in use already</p>";
  }elseif ($result3->num_rows > 0) {
    echo "<p style='color:red'>Username is in use already</p>";
  }else{
      echo "<p style='color:green'>Username is valid</p>";
    }
}elseif ($type=="searchpro") {
    $product = $_POST['product'];
    $query = "SELECT * FROM product WHERE name LIKE '%$product%'";
    $result = $connect->query($query);
    if($result->num_rows > 0){
        echo "<p style='color:red'>Model name is in use already</p>";
    }else{
        echo "<p style='color:green'>Valid model name</p>";
    }
}elseif($type=="shipaccepting"){
    $orderid = $_POST['order'];
    $clientid = $_POST['client'];
    $shipreq = $_POST['shipreq'];
    $result = $connect->query("INSERT INTO shipment_accept (client_id, order_id) VALUES('$clientid', '$orderid')");
    if($result){
        echo "Shipment Accepted Successfully. Please reload to see changes.";
        $result = $connect->query("UPDATE shipment_req SET accepted='yes' WHERE id='$shipreq'");
    }else{
        echo "Accept error";
    }
}
}
?>
