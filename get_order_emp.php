<?php require_once ("class.phpmailer.php"); ?>
<?php require_once ("class.smtp.php"); ?>
<?php require_once ("PHPMailerAutoload.php"); ?>
<?php
require_once 'dbconnect.php';
if(isset($_POST["type"])){
    $type = $_POST["type"];
    $jobtype = $_POST['job'];
    if($type=="allorder" && $jobtype=="Manager"){
      $sql = "SELECT * FROM orders WHERE approved='yes' ORDER BY id DESC";
      $result = $connect->query($sql);
      if($result->num_rows > 0){
        $output = "
        <p style='text-align:center'><b>Approved Order</b></p>
        <table class='table table-hover' style='width:100%;'>
          <thead>
              <tr>
                <th>Order ID</th>
                <th>Client</th>
                <th>Details</th>
                <th>Ordered date</th>
                <th>Delivery date</th>
                <th>Manager</th>
                <th>Supervisor</th>
              </tr>
          </thead>
          <tbody>";
        while($order = $result->fetch_assoc()){
          $client_id=$order['client_id'];
          $query = $connect->query("SELECT fullname FROM client WHERE id='$client_id'");
          $client = $query->fetch_assoc();
          $client_name = $client['fullname'];
          $order_id = $order['id'];
          $ordered_date = $order['ordering_date'];
          $delivery_date = $order['delivery_date'];
          $details = $order['details'];
          $manager = $order['manager'];
          $manresult = $connect->query("SELECT fullname FROM employee WHERE username='$manager'");
          $manrow = $manresult->fetch_assoc();
          $manfullname = $manrow['fullname'];
          $supervisor = $order['supervisor'];
          $supresult = $connect->query("SELECT fullname FROM employee WHERE id='$supervisor'");
          $suprow = $supresult->fetch_assoc();
          $supfullname = $suprow['fullname'];
          if($supfullname == ""){
              $supfullname = "<b><i>Not assigned yet</i><b>";
          }
          $output .= "
          <tr>
            <td>$order_id</td>
            <td>$client_name</td>
            <td>$details</td>
            <td>$ordered_date</td>
            <td>$delivery_date</td>
            <td>$manfullname</td>
            <td>$supfullname</td>
          </tr>
          ";
        }
        $output .="</tbody></table>";
      }else{
        $output="<br><p style='text-align:center; color:red'><i>No approve order</i></p>";
      }
      echo $output;
  }else if($type=="assignedorder" && $jobtype=="Manager"){
      $sessusername = $_SESSION['username'];
      $sql = "SELECT * FROM orders WHERE approved='yes' AND manager='$sessusername' ORDER BY priority ASC, id DESC";
      $result = $connect->query($sql);
      if($result->num_rows > 0){
        $output = "<table class='table table-hover' style='width:100%;'>
          <thead>
              <tr>
                <th>Order ID</th>
                <th>Client</th>
                <th>Details</th>
                <th>Manager</th>
                <th>Ordered date</th>
                <th>Delivery date</th>
                <th>Supervisor</th>
                <th>Raw Material</th>
              </tr>
          </thead>
          <tbody>";
        while($order = $result->fetch_assoc()){
          $client_id=$order['client_id'];
          $query = $connect->query("SELECT fullname, address FROM client WHERE id='$client_id'");
          $client = $query->fetch_assoc();
          $client_name = $client['fullname'];
          $order_id = $order['id'];
          $ordered_date = $order['ordering_date'];
          $delivery_date = $order['delivery_date'];
          $details = $order['details'];
          $manager = $order['manager'];
          $managersql = $connect->query("SELECT fullname FROM employee WHERE username='$manager'");
          $managerrow = $managersql->fetch_assoc();
          $managername = $managerrow['fullname'];
          $supervisor = $order['supervisor'];
          $supresult = $connect->query("SELECT fullname FROM employee WHERE id='$supervisor'");
          $suprow = $supresult->fetch_assoc();
          $supfullname = $suprow['fullname'];
          $recieve = ucfirst($order['raw']);
          if($supfullname == ""){
              $output .= "
              <tr>
                <td>$order_id</td>
                <td>$client_name</td>
                <td>$details</td>
                <td>$managername</td>
                <td>$ordered_date</td>
                <td>$delivery_date</td>
                <td><button type='button' class='btn btn-success' id='assignsup' data-toggle='modal' data-target='#exampleModal' data-whatever='$order_id'> Assign </button></td>
                <td>$recieve</td>
              </tr>
              ";
          }else{
              $output .= "
              <tr>
                <td>$order_id</td>
                <td>$client_name</td>
                <td>$details</td>
                <td>$managername</td>
                <td>$ordered_date</td>
                <td>$delivery_date</td>

                <td>$supfullname</td>
                <td>$recieve</td>
              </tr>
              ";
          }

        }
        $output .="</tbody></table>";
      }else{
        $output="<br><p style='text-align:center; color:red'><i>No assigned order to show</i></p>";
      }
      echo $output;
  }elseif ($type=="recievedorder" && $jobtype=="Manager") {
      $sql = "SELECT * FROM orders WHERE recieved='yes' OR recieved='part' ORDER BY id DESC";
      $result = $connect->query($sql);
      if($result->num_rows > 0){
        $output = "
        <p style='text-align:center'><b>Received Order</b></p>
        <table class='table table-hover' style='width:100%;'>
          <thead>
              <tr>
                <th>Order ID</th>
                <th>Client</th>
                <th>Details</th>
                <th>Ordered date</th>
                <th>Delivery date</th>
                <th>Manager</th>
                <th>Supervisor</th>
                <th>Recieve</th>
              </tr>
          </thead>
          <tbody>";
        while($order = $result->fetch_assoc()){
          $client_id=$order['client_id'];
          $query = $connect->query("SELECT fullname FROM client WHERE id='$client_id'");
          $client = $query->fetch_assoc();
          $client_name = $client['fullname'];
          $order_id = $order['id'];
          $ordered_date = $order['ordering_date'];
          $delivery_date = $order['delivery_date'];
          $details = $order['details'];
          $manager = $order['manager'];
          $manresult = $connect->query("SELECT fullname FROM employee WHERE username='$manager'");
          $manrow = $manresult->fetch_assoc();
          $manfullname = $manrow['fullname'];
          $supervisor = $order['supervisor'];
          $supresult = $connect->query("SELECT fullname FROM employee WHERE id='$supervisor'");
          $suprow = $supresult->fetch_assoc();
          $supfullname = $suprow['fullname'];
          if($supfullname == ""){
              $supfullname = "<b><i>Not assigned yet</i><b>";
          }
          $recieve = $order['recieved'];
          if($recieve=="part"){
              $recieve = "Partial";
          }elseif ($recieve=="yes") {
              $recieve="Full";
          }
          $output .= "
          <tr>
            <td>$order_id</td>
            <td>$client_name</td>
            <td>$details</td>
            <td>$ordered_date</td>
            <td>$delivery_date</td>
            <td>$manfullname</td>
            <td>$supfullname</td>
            <td>$recieve</td>
          </tr>
          ";
        }
        $output .="</tbody></table>";
      }else{
        $output="<br><p style='text-align:center; color:red'><i>No recieve order</i></p>";
      }
      echo $output;
  }elseif ($type=="assignedorder" && $jobtype="Supervisor") {
      $username = $_SESSION['username'];
      $sql = "SELECT id, fullname FROM employee WHERE username='$username'";
      $result = $connect->query($sql);
      $row = $result->fetch_assoc();
      $supid = $row['id'];
      $supname = $row['fullname'];
      $sql = "SELECT * FROM orders WHERE supervisor='$supid' ORDER BY id DESC";
      $result = $connect->query($sql);
      if($result->num_rows > 0){
        $output = "
        <p style='text-align:center'><b>Approved Order</b></p>
        <table class='table table-hover' style='width:100%;'>
          <thead>
              <tr>
                <th>Order ID</th>
                <th>Client</th>
                <th>Details</th>
                <th>Ordered date</th>
                <th>Delivery date</th>
                <th>Manager</th>
                <th>Supervisor</th>
                <th>Raw Material</th>
              </tr>
          </thead>
          <tbody>";
        while($order = $result->fetch_assoc()){
          $client_id=$order['client_id'];
          $query = $connect->query("SELECT fullname FROM client WHERE id='$client_id'");
          $client = $query->fetch_assoc();
          $client_name = $client['fullname'];
          $order_id = $order['id'];
          $ordered_date = $order['ordering_date'];
          $delivery_date = $order['delivery_date'];
          $details = $order['details'];
          $manager = $order['manager'];
          $manresult = $connect->query("SELECT fullname FROM employee WHERE username='$manager'");
          $manrow = $manresult->fetch_assoc();
          $manfullname = $manrow['fullname'];
          $raw = $order['raw'];
          if($raw == "yes"){
              $output .= "
              <tr>
                <td>$order_id</td>
                <td>$client_name</td>
                <td>$details</td>
                <td>$ordered_date</td>
                <td>$delivery_date</td>
                <td>$manfullname</td>
                <td>$supname</td>
                <td>Received</td>
              </tr>
              ";
          }else{
              $output .= "
              <tr>
                <td>$order_id</td>
                <td>$client_name</td>
                <td>$details</td>
                <td>$ordered_date</td>
                <td>$delivery_date</td>
                <td>$manfullname</td>
                <td>$supname</td>
                <td><button type='button' class='btn btn-success' id='receiveraw' data-whatever='$order_id'> Receiving </button></td>
              </tr>
              ";
          }
        }
        $output .="</tbody></table>";
      }else{
        $output="<br><p style='text-align:center; color:red'><i>No assigned order</i></p>";
      }
      echo $output;
  }elseif ($type=="rawreceive" && $jobtype="Supervisor") {
      $orderid = $_POST['orderid'];
      $sql = "UPDATE orders SET raw='yes' WHERE id='$orderid'";
      $result = $connect->query($sql);
      if(result){
          echo "sucess";
      }else{
          echo "failed";
      }
  }elseif ($type=="assignsup" && $jobtype=="Manager") {
      $orderid = $_POST['orderid'];
      $supusername = $_POST['super'];
      $msg = $_POST['msg'];
      $sql = "SELECT email,id FROM employee WHERE username='$supusername'";
      $supresult = $connect->query($sql);
      $suprow = $supresult->fetch_assoc();
      $email = $suprow['email'];
      $id = $suprow['id'];
      $sql = "UPDATE orders SET supervisor='$id' WHERE id='$orderid'";
      $result = $connect->query($sql);
      $output="";
      if($result){
          $output = "Supervisor assigned successfully.";
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
              $mail->Body = $msg;
              $mail->Subject = "Mail from Our Deal";
              if(!$mail->Send()) {
                  echo "Mailer Error: " . $mail->ErrorInfo;
              }else{
                  $output .= " Mail also has sent to supervisor";
              }
          }catch (Exception $e) {
              #print_r($e->getMessage());
              file_put_contents($logfile, "Error: \n", FILE_APPEND);
              file_put_contents($logfile, $e->getMessage() . "\n", FILE_APPEND);
              file_put_contents($logfile, $e->getTraceAsString() . "\n\n", FILE_APPEND);
          }
          echo $output;
      }
  }
}

?>
