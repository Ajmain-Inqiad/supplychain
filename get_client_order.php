<?php require_once ("class.phpmailer.php"); ?>
<?php require_once ("class.smtp.php"); ?>
<?php require_once ("PHPMailerAutoload.php"); ?>
<?php
require_once 'dbconnect.php';
$username = $_SESSION['username'];
if(isset($_POST['type'])){
  $type=$_POST['type'];
  if($type=="neworder"){
    $sql = "SELECT id FROM client WHERE username='$username' LIMIT 1";
    $result = $connect->query($sql);
    $row = $result->fetch_assoc();
    $id = $row['id'];
    $sql = "SELECT * FROM orders WHERE client_id='$id' AND approved='no' ORDER BY id DESC";
    $result=$connect->query($sql);
    if($result->num_rows > 0){
      $output="
       <p style='text-align: center'> <b> Requested Order list </b></p>
      <table class='table table-hover' style='width:100%;'>
        <thead>
            <tr>
              <th>Order ID</th>
              <th>Product</th>
              <th>Approve</th>
              <th>Order Date</th>
              <th>Delivery Date</th>
              <th>Cost in BDT</th>
            </tr>
        </thead>

        <tbody>";
        while ($row = $result->fetch_assoc()) {
          $id=$row['id'];
          $details=$row['details'];
          $approved = ucfirst($row['approved']);
          $order = $row['ordering_date'];
          $delivery = $row['delivery_date'];
          $cost = $row['cost'];
          $output .= "
          <tr>
            <td>$id</td>
            <td>$details</td>
            <td>$approved</td>
            <td>$order</td>
            <td>$delivery</td>
            <td>$cost</td>
          </tr>
          ";
        }
        $output .="</tbdoy></table>";
    }else{
      $output = "<br><p style='text-align:center; color:red'><i>No New Order Request</i></p>";
    }
    echo $output;
  }elseif ($type=="recievedorder") {
    $sql = "SELECT id FROM client WHERE username='$username' LIMIT 1";
    $result = $connect->query($sql);
    $row = $result->fetch_assoc();
    $id = $row['id'];
    $sql = "SELECT * FROM orders WHERE client_id='$id' AND recieved='yes' AND completed='yes' ORDER BY id DESC";
    $result=$connect->query($sql);
    if($result->num_rows > 0){
      $output="
       <p style='text-align: center'> <b> Recieved Order list </b></p>
      <table class='table table-hover' style='width:100%;'>
        <thead>
            <tr>
              <th>Order ID</th>
              <th>Product</th>
              <th>Completed</th>
              <th>Order Date</th>
              <th>Delivery Date</th>
              <th>Cost in BDT</th>
            </tr>
        </thead>

        <tbody>";
        while ($row = $result->fetch_assoc()) {
          $id=$row['id'];
          $details=$row['details'];
          $completed = ucfirst($row['completed']);
          if($completed == "Part"){
            $completed = "Partial";
          }
          $order = $row['ordering_date'];
          $delivery = $row['delivery_date'];
          $cost = $row['cost'];
          $output .= "
          <tr>
            <td>$id</td>
            <td>$details</td>
            <td>$completed</td>
            <td>$order</td>
            <td>$delivery</td>
            <td>$cost</td>
          </tr>
          ";
        }
        $output .="</tbdoy></table>";
    }else{
      $output = "<br><p style='text-align:center; color:red'><i>No product is recieved</i></p>";
    }
    echo $output;
  }elseif ($type=="approvedorder") {
    $sql = "SELECT id FROM client WHERE username='$username' LIMIT 1";
    $result = $connect->query($sql);
    $row = $result->fetch_assoc();
    $id = $row['id'];
    $sql = "SELECT * FROM orders WHERE client_id='$id' AND approved='yes' AND recieved='no' ORDER BY id";
    $result=$connect->query($sql);
    if($result->num_rows > 0){
      $output="
       <p style='text-align: center'> <b> Approved Order list </b></p>
      <table class='table table-hover' style='width:100%;'>
        <thead>
            <tr>
              <th>Order ID</th>
              <th>Product</th>
              <th>Completed</th>
              <th>Done Amount</th>
              <th>Cost in BDT</th>
              <th>Delivery Date</th>
              <th>Action</th>
              <th>Order Date</th>
            </tr>
        </thead>

        <tbody>";
        while ($row = $result->fetch_assoc()) {
          $id=$row['id'];
          $details=$row['details'];
          $completed = ucfirst($row['completed']);
          if($completed == "Part"){
            $completed = "Partial";
          }
          $order = $row['ordering_date'];
          $delivery = $row['delivery_date'];
          $done = $row['doneAmount'];
          $orderamount = $row['orderAmount'];
          $cost = $row['cost'];
          if(($done > 0) && ($done == $orderamount)){
            $output .= "
            <tr>
              <td>$id</td>
              <td>$details</td>
              <td>$completed</td>
              <td>$done</td>
              <td>$cost</td>
              <td>$delivery</td>
              <td><button type='button' class='btn btn-success' id='approve' data-id='$id'> Shipment </button> &nbsp;
              <button type='button' class='btn btn-custom' id='recieve' data-id='$id'> Recieve </button>
              </td>
              <td>$order</td>
            </tr>
            ";
          }else{
            $output .= "
            <tr>
              <td>$id</td>
              <td>$details</td>
              <td>$completed</td>
              <td>$done</td>
              <td>$cost</td>
              <td>$delivery</td>
              <td></td>
              <td>$order</td>
            </tr>
            ";
          }

        }
        $output .="</tbdoy></table>";
    }else{
      $output = "<br><p style='text-align:center; color:red'><i>No Approved Order</i></p>";
    }
    echo $output;
  }elseif ($type=="shipment") {
    $orderid=$_POST['order'];
    $sql = "SELECT id FROM client WHERE username='$username' LIMIT 1";
    $result = $connect->query($sql);
    $row = $result->fetch_assoc();
    $clientid = $row['id'];
    $sql="SELECT * FROM orders WHERE client_id='$clientid' AND id='$orderid'";
    $result = $connect->query($sql);
    $row = $result->fetch_assoc();
    $done = $row['doneAmount'];
    $sql="SELECT * FROM shipment_req WHERE client_id='$clientid' AND order_id='$orderid'";
    $result = $connect->query($sql);
    // $count=0;
    // while($row = $result->fetch_assoc()){
    //   $ship = $row['ship_amount'];
    //   $count = $count+$ship;
    // }
    // $newShip = $done - $count;
    if($result->num_rows == 0){
      $sql = "INSERT INTO shipment_req (client_id, order_id, ship_amount, accepted) VALUES ('$clientid', '$orderid', '$done', 'no')";
      $result = $connect->query($sql);
      if($result){
        echo "Shipment Request has accepted successfully. Wait for admin acceptance";
      }else {
        echo "Something went wrong";
      }
    }else{
      echo "Already shipment request send";
    }
  }elseif ($type=="recieve") {
    $orderid=$_POST['order'];
    $sql = "SELECT * FROM client WHERE username='$username' LIMIT 1";
    $result = $connect->query($sql);
    $row = $result->fetch_assoc();
    $clientid = $row['id'];
    $clientemail = $row['email'];
    $sql = "SELECT * FROM shipment_req WHERE client_id='$clientid' AND order_id='$orderid' AND accepted='yes'";
    $result = $connect->query($sql);
    if($result->num_rows > 0){
      $sql="SELECT * FROM orders WHERE client_id='$clientid' AND id='$orderid' AND recieved='no' AND completed='yes'";
      $result = $connect->query($sql);
      $sqlship = "SELECT * FROM shipment WHERE client_id='$clientid' AND order_id='$orderid' AND recieved='no'";
      $result2 = $connect->query($sqlship);
      if($result && $result2){
          $sql="UPDATE orders SET completed='yes', recieved='yes' WHERE client_id='$clientid' AND id='$orderid'";
          $result = $connect->query($sql);
          $sql="UPDATE mohammadpur SET recieved='yes' WHERE client_id='$clientid' AND order_id='$orderid'";
          $result = $connect->query($sql);
          $sql="UPDATE mohakhali SET recieved='yes' WHERE client_id='$clientid' AND order_id='$orderid'";
          $result = $connect->query($sql);
          $sql="UPDATE shipment SET recieved='yes' WHERE client_id='$clientid' AND order_id='$orderid'";
          $result = $connect->query($sql);
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
          $mail->AddAddress($clientemail);
          try {
              $mail->Body = $orderid . " no order has been recieved.";
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
      }else{
          echo "Something wrong happened.";
      }
    //   $row = $result->fetch_assoc();
    //   $order = $row['orderAmount'];
    //   //$sql = "SELECT * FROM shipment WHERE client_id='$clientid' AND order_id='$orderid' AND recieved='no'";
    //   //$result = $connect->query($sql);
    //   $count = $result->num_rows ;
    //   $mail = new PHPMailer(); // create a new object
    //   $mail->IsSMTP(); // enable SMTP
    //   $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
    //   $mail->SMTPAuth = true; // authentication enabled
    //   #$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
    //   $mail->Host = "smtp.ourdeal.bid";
    //   $mail->Port = 587; // or for ssl port=465 or 25=non-ssl
    //   $mail->IsHTML(true);
    //   $mail->Username = "customerservice@ourdeal.bid";
    //   $mail->Password = "12345678";
    //   $mail->SetFrom("customerservice@ourdeal.bid");
    //   $mail->AddAddress($clientemail);
    //   if($count == $order){
    //     $sql="UPDATE orders SET completed='yes', recieved='yes' WHERE client_id='$clientid' AND id='$orderid'";
    //     $result = $connect->query($sql);
    //     $sql="UPDATE mohammadpur SET recieved='yes' WHERE client_id='$clientid' AND order_id='$orderid'";
    //     $result = $connect->query($sql);
    //     $sql="UPDATE mohakhali SET recieved='yes' WHERE client_id='$clientid' AND order_id='$orderid'";
    //     $result = $connect->query($sql);
    //     $sql="UPDATE shipment SET recieved='yes' WHERE client_id='$clientid' AND order_id='$orderid'";
    //     $result = $connect->query($sql);
    //     $mail = new PHPMailer(); // create a new object
    //     $mail->IsSMTP(); // enable SMTP
    //     $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
    //     $mail->SMTPAuth = true; // authentication enabled
    //     #$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
    //     $mail->Host = "smtp.ourdeal.bid";
    //     $mail->Port = 587; // or for ssl port=465 or 25=non-ssl
    //     $mail->IsHTML(true);
    //     $mail->Username = "customerservice@ourdeal.bid";
    //     $mail->Password = "12345678";
    //     $mail->SetFrom("customerservice@ourdeal.bid");
    //     $mail->AddAddress($clientemail);
    //     try {
    //         $mail->Body = $orderid . " no order has been recieved.";
    //         $mail->Subject = "Mail from Our Deal";
    //         if(!$mail->Send()) {
    //             echo "Mailer Error: " . $mail->ErrorInfo;
    //         }
    //     }catch (Exception $e) {
    //         #print_r($e->getMessage());
    //         file_put_contents($logfile, "Error: \n", FILE_APPEND);
    //         file_put_contents($logfile, $e->getMessage() . "\n", FILE_APPEND);
    //         file_put_contents($logfile, $e->getTraceAsString() . "\n\n", FILE_APPEND);
    //     }
    //   }
    //   elseif(($count < $order) && ($count >= 0)){
    //     $sql="UPDATE orders SET completed='part', recieved='part' WHERE client_id='$clientid' AND id='$orderid'";
    //     $result = $connect->query($sql);
    //     $sql="UPDATE mohammadpur SET recieved='yes' WHERE client_id='$clientid' AND order_id='$orderid'";
    //     $result = $connect->query($sql);
    //     $sql="UPDATE mohakhali SET recieved='yes' WHERE client_id='$clientid' AND order_id='$orderid'";
    //     $result = $connect->query($sql);
    //     $sql="UPDATE shipment SET recieved='yes' WHERE client_id='$clientid' AND order_id='$orderid'";
    //     $result = $connect->query($sql);
    //     $mail = new PHPMailer(); // create a new object
    //     $mail->IsSMTP(); // enable SMTP
    //     $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
    //     $mail->SMTPAuth = true; // authentication enabled
    //     #$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
    //     $mail->Host = "smtp.ourdeal.bid";
    //     $mail->Port = 587; // or for ssl port=465 or 25=non-ssl
    //     $mail->IsHTML(true);
    //     $mail->Username = "customerservice@ourdeal.bid";
    //     $mail->Password = "12345678";
    //     $mail->SetFrom("customerservice@ourdeal.bid");
    //     $mail->AddAddress($clientemail);
    //     try {
    //         $mail->Body = $orderid . " no order has been recieved.";
    //         $mail->Subject = "Mail from Our Deal";
    //         if(!$mail->Send()) {
    //             echo "Mailer Error: " . $mail->ErrorInfo;
    //         }
    //     }catch (Exception $e) {
    //         #print_r($e->getMessage());
    //         file_put_contents($logfile, "Error: \n", FILE_APPEND);
    //         file_put_contents($logfile, $e->getMessage() . "\n", FILE_APPEND);
    //         file_put_contents($logfile, $e->getTraceAsString() . "\n\n", FILE_APPEND);
    //     }
    //   }
    //   if($result){
    //     echo "Thanks for using our service";
    //   }else{
    //     echo "Something went wrong";
    //   }
    }else{
        $sql = "SELECT * FROM shipment_req WHERE client_id='$clientid' AND order_id='$orderid' AND accepted='no'";
        $result = $connect->query($sql);
        if($result){
            echo "Wait for shipment acceptance";
        }else{
            echo "Please order for shipment first";
        }

    }
  }
}else{
  header("Location: checkorder.php");
}

?>
