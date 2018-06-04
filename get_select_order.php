<?php
require_once 'dbconnect.php';
if(isset($_POST["type"])){
    $type = $_POST["type"];
    if($type=="neworder"){
      $sql = "SELECT * FROM orders WHERE approved='no' AND completed='no' ORDER BY priority ASC, ordering_date ASC";
      $result = $connect->query($sql);
      if($result->num_rows > 0){
        $output = "<table class='table table-hover' style='width:100%;'>
          <thead>
              <tr>
                <th>Order ID</th>
                <th>Client</th>
                <th>Details</th>
                <th>Ordered date</th>
                <th>Delivery date</th>
                <th>Client Address</th>
                <th>Action</th>
              </tr>
          </thead>

          <tbody>";
        while($order = $result->fetch_assoc()){
          $client_id=$order['client_id'];
          $query = $connect->query("SELECT fullname, address,email FROM client WHERE id='$client_id'");
          $client = $query->fetch_assoc();
          $client_name = $client['fullname'];
          $client_add = $client['address'];
          $client_email = $client['email'];
          $order_id = $order['id'];
          $ordered_date = $order['ordering_date'];
          $delivery_date = $order['delivery_date'];
          $details = $order['details'];
          $output .= "
          <tr>
            <td>$order_id</td>
            <td>$client_name</td>
            <td>$details</td>
            <td>$ordered_date</td>
            <td>$delivery_date</td>
            <td>$client_add</td>
            <td><button type='button' class='btn btn-danger' id='delete' data-toggle='modal' data-target='#exampleModal' data-whatever='$client_email delete $order_id'> Delete</button>
            &nbsp;<button type='button' class='btn btn-success' id='approve' data-toggle='modal' data-target='#exampleModal2' data-whatever='$client_email approve $order_id'> Approve</button>
            &nbsp;<button type='button' class='btn btn-default' id='contact' data-toggle='modal' data-target='#exampleModal' data-whatever='$client_email contact $order_id'> Contact </button>

            </td>
          </tr>
          ";
        }
        $output .="</tbody></table>";
      }else{
        $output="<br><p style='text-align:center; color:red'><i>No new order</i></p>";
      }
      echo $output;
    }else if($type=="approved"){
      $sql = "SELECT * FROM orders WHERE approved='yes' ORDER BY completed ASC, priority ASC";
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
                <th>Client Address</th>
                <th>Completed</th>
              </tr>
          </thead>

          <tbody>";
        while($order = $result->fetch_assoc()){
          $client_id=$order['client_id'];
          $query = $connect->query("SELECT fullname, address FROM client WHERE id='$client_id'");
          $client = $query->fetch_assoc();
          $client_name = $client['fullname'];
          $client_add = $client['address'];
          $order_id = $order['id'];
          $ordered_date = $order['ordering_date'];
          $delivery_date = $order['delivery_date'];
          $details = $order['details'];
          $completed = $order['completed'];
          $manager = $order['manager'];
          $managersql = $connect->query("SELECT fullname FROM employee WHERE username='$manager'");
          $managerrow = $managersql->fetch_assoc();
          $managername = $managerrow['fullname'];
          $output .= "
          <tr>
            <td>$order_id</td>
            <td>$client_name</td>
            <td>$details</td>
            <td>$managername</td>
            <td>$ordered_date</td>
            <td>$delivery_date</td>
            <td>$client_add</td>
            <td>$completed</td>
          </tr>
          ";
        }
        $output .="</tbody></table>";
      }else{
        $output="<br><p style='text-align:center; color:red'><i>No old order to show</i></p>";
      }
      echo $output;
    }
}

?>
