<?php require_once 'boot.php'; ?>
<?php require_once ("class.phpmailer.php"); ?>
<?php require_once ("class.smtp.php"); ?>
<?php require_once ("PHPMailerAutoload.php"); ?>
<?php require_once 'dbconnect.php'; ?>
<?php require_once ('includes/client_header.php'); ?>
<?php
$transid="";
if(isset($_POST['product'])){
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
  $priority = $_POST['prority'];
  $product = $_POST['product'];
  $amount = $_POST['amount'];
  $price = $_POST['priced'] * 80;
  if($priority==1){
    $date = new DateTime();
    $date->add(new DateInterval('P7D'));
    $delivery = $date->format('Y-m-d');
  } elseif ($priority==5) {
    $date = new DateTime();
    $date->add(new DateInterval('P10D'));
    $delivery = $date->format('Y-m-d');
  }
  $details = "" . $amount . " boxes of " . $product;
  if(empty($_POST['payment_method_nonce'])){
      header("Location: test.php");
  }
  $unit = $_POST['priced'] / $amount ;
  $result = Braintree_Transaction::sale([
  'amount' => $_POST['priced'],
  'paymentMethodNonce' => $_POST['payment_method_nonce'],
  'options' => [
    'submitForSettlement' => True
  ]
]);
  $msg="";
  if($result->success == true){
  }else{
      var_dump($result->errors);
  }
  $transid = $result->transaction->id;
  $mail = new PHPMailer(); // create a new object
  $mail->IsSMTP(); // enable SMTP
  $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
  $mail->SMTPAuth = true; // authentication enabled
  #$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
  $mail->Host = "smtp.ourdeal.bid";
  $mail->Port = 587; // or for ssl port=465 or 25=non-ssl
  $mail->IsHTML(true);
  $mail->Username = "customerservice@ourdeal.bid";
  $mail->Password = "12345678";
  $mail->SetFrom("customerservice@ourdeal.bid");
  $mail->AddAddress($email);
  try {
      $mail->Body = "Transaction id is: " . $result->transaction->id . " And order is recieved";
      $mail->Subject = "Mail from Our Deal";
      if(!$mail->Send()) {
          echo "Mailer Error: " . $mail->ErrorInfo;
      }
  }catch (Exception $e) {
      #print_r($e->getMessage());
      file_put_contents($logfile, "Error: \n", FILE_APPEND);
      file_put_contents($logfile, $e->getMessage() . "\n", FILE_APPEND);
      file_put_contents($logfile, $e->getTraceAsString() . "\n\n", FILE_APPEND);
  }
  $query = "INSERT INTO orders (client_id, details, ordering_date, delivery_date, approved, completed, priority, orderAmount, doneAmount, recieved, cost, raw) VALUES ('$id', '$details', '$today', '$delivery', 'no', 'no', '$priority', '$amount', '0', 'no', '$price', 'no')";
  $result = $connect->query($query);
  if($result){
    $msg="success";
  }else{
    $msg="wrong";
  }

}else{
  header("Location: makeorder.php");
}


?>
            <div class="side-menu-container">
                <ul class="nav navbar-nav">
                    <li><a href="client.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
                    <li class="active"><a href="makeorder.php"><span class="glyphicon glyphicon-shopping-cart"></span>Give Order</a></li>
                    <li><a href="checkorder.php"><span class="glyphicon glyphicon-saved"></span>Placed Order</a></li>
                    <li><a href="trackproduct.php"><span class="glyphicon glyphicon-map-marker"></span>Product Location </a></li>
                    <li><a href="clientsetting.php"><span class="glyphicon glyphicon-cog"></span>Profile Setting </a></li>
                    <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span>Logout</a></li>

                </ul>
            </div><!-- /.navbar-collapse -->
            </nav>

            </div>
            <div class="container-fluid">
                <div class="side-body">
                    <br>
                    <div class="row">
                      <div class="col-md-12">
                        <?php
                        if($msg == "success"){?>
                          <br>
                          <div class="alert alert-success" style="text-align:center">
                            <strong>Successful!</strong> <?php echo "Transaction id is: " . $transid . " And order is recieved"; ?>
                          </div>
                        <?php
                      }elseif($msg=="error"){?>
                        <br>
                        <div class="alert alert-danger" style="text-align:center">
                          <strong>Error!</strong> order is failed.
                        </div>
                      <?php
                    }
                         ?>
                      </div>
                    </div>
                </div>
             </div>
         </div>
     </div>
     <?php require_once ('includes/client_footer.php'); ?>
