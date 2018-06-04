<?php require_once 'dbconnect.php'; ?>
<?php
if(isset($_GET['username']) && isset($_GET['code'])){
  $user = $_GET['username'];
  $code = $_GET['code'];
  $sql = "SELECT * FROM req_client WHERE username='$user' AND code='$code'";
  $query = $connect->query($sql);
  if($query){
    $result = $query->fetch_assoc();
    $client_name = $result['fullname'];
    $client_username = $result['username'];
    $client_email = $result['email'];
    $client_password = $result['password'];
    $client_address = $result['address'];
    $client_phone = $result['phone'];
    $client_division = $result['division'];
    $client_lat = $result['lat'];
    $client_long = $result['longti'];
    $check = $connect->query("INSERT INTO client (fullname, username, email, password, address, phone, logged_in, division, lat, longti) VALUES ('$client_name', '$client_username', '$client_email', '$client_password', '$client_address', '$client_phone', 'no', '$client_division', '$client_lat', '$client_long')");
    $connect->query("DELETE FROM req_client WHERE username='$user'");
    if($check){
        echo "Creation success";
    }else{
        echo "Duplicate entry. Create new account";
    }

  }else{
    echo "Account creation failed.";
  }
}
?>
