<?php require "boot.php"; ?>
<?php require_once ("dbconnect.php"); ?>
<?php require_once ('includes/client_header.php'); ?>
<?php
$username =  $_SESSION['username'];
$query="SELECT * FROM client WHERE username='$username' LIMIT 1";
$result = $connect->query($query);
$row = $result->fetch_assoc();
$id = $row['id'];
$name = $row['fullname'];
$email = $row['email'];
$address = $row['address'];
$phone = $row['phone'];
$today=date('Y-m-d');
$delivery =date('Y-m-d');
$priority = $_POST['priority'];
$product = $_POST['product'];
$amount = $_POST['amount'];
$price = $_POST['price'];
 if(empty($_POST['payment_method_nonce'])){
     header("Location: test.php");
 }
 $result = Braintree_Transaction::sale([
     'amount' => $_POST['amount'],
     'paymentMethodNonce' => $_POST['payment_method_nonce'],
     'options' => [
         'submitForSettlement' => true
     ]
 ]);
 if($result->success === true){

 }else{
     print_r($result->errors);
     die();
 }
 ?>
 <html>
   <head>
     <meta charset="utf-8">
     <title></title>
   </head>
   <body>
 	  <form class="payment-form">
          <input type="text" name="transaction" id="transaction" value="<?php echo $result->transaction->id; ?>" disabled><br>
 		  <br>
 		  <input type="text" name="amount" id="amount" value="<?php echo $result->transaction->price; ?>" disabled>
 		  <br>
 		  <br>
          <input type="text" name="status" id="status" value="Success" disabled>
 	  </form>
   </body>
 </html>
