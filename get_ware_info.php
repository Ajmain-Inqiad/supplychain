<?php
require_once 'dbconnect.php';
if(isset($_POST["type"])){
    $type = $_POST["type"];
    if($type == "savar"){
        $savarsql = $connect->query("SELECT * FROM shipment");
        $output = "
        <br/>
        <p style='text-align:center;'><b>Savar Warehouse</b></p>
        <table class='table table-hover' style='width:100%;'>
          <thead>
              <tr>
                <th>Order ID</th>
                <th>Client</th>
                <th>Supervisor</th>
                <th>Date</th>
                <th>Completed</th>
                <th>Done Amount</th>
                <th>Recieved</th>
                <th>Truck</th>
              </tr>
          </thead>

          <tbody>";
        while($row = $savarsql->fetch_assoc()){
            $order_id = $row['order_id'];
            $client = $row['client_id'];
            $clientsql = $connect->query("SELECT fullname FROM client WHERE id='$client'");
            $clientrow = $clientsql->fetch_assoc();
            $client_name = $clientrow['fullname'];
            $sup = $row['supervisor'];
            $supsql = $connect->query("SELECT fullname FROM employee WHERE id='$sup'");
            $suprow = $supsql->fetch_assoc();
            $supervisor = $suprow['fullname'];
            $date = $row['date'];
            $completed = ucfirst($row['completed']);
            if($completed == "Part"){
                $completed = "Partial";
            }
            $done = $row['doneAmount'];
            $recieved = ucfirst($row['recieved']);
            $truck = $row['truck'];

            $output .= "
            <tr>
              <td>$order_id</td>
              <td>$client_name</td>
              <td>$supervisor</td>
              <td>$date</td>
              <td>$completed</td>
              <td>$done</td>
              <td>$recieved</td>
              <td>$truck</td>
            </tr>
            ";
        }
        echo $output;
    }elseif ($type=="mohammadpur") {
        $savarsql = $connect->query("SELECT * FROM mohammadpur");
        $output = "
        <br/>
        <p style='text-align:center;'><b>Mohammadpur Warehouse</b></p>
        <table class='table table-hover' style='width:100%;'>
          <thead>
              <tr>
                <th>Order ID</th>
                <th>Client</th>
                <th>Supervisor</th>
                <th>Date</th>
                <th>Recieved</th>
                <th>Truck</th>
              </tr>
          </thead>

          <tbody>";
        while($row=$savarsql->fetch_assoc()){
            $order_id = $row['order_id'];
            $client = $row['client_id'];
            $clientsql = $connect->query("SELECT fullname FROM client WHERE id='$client'");
            $clientrow = $clientsql->fetch_assoc();
            $client_name = $clientrow['fullname'];
            $sup = $row['supervisor'];
            $supsql = $connect->query("SELECT fullname FROM employee WHERE id='$sup'");
            $suprow = $supsql->fetch_assoc();
            $supervisor = $suprow['fullname'];
            $date = $row['checkTime'];
            $recieved = ucfirst($row['recieved']);
            $truck = $row['truck'];

            $output .= "
            <tr>
              <td>$order_id</td>
              <td>$client_name</td>
              <td>$supervisor</td>
              <td>$date</td>
              <td>$recieved</td>
              <td>$truck</td>
            </tr>
            ";
        }
        echo $output;
    }elseif ($type=="mohakhali") {
        $savarsql = $connect->query("SELECT * FROM mohakhali");
        $output = "
        <br/>
        <p style='text-align:center;'><b>Mohakhali Warehouse</b></p>
        <table class='table table-hover' style='width:100%;'>
          <thead>
              <tr>
                <th>Order ID</th>
                <th>Client</th>
                <th>Supervisor</th>
                <th>Date</th>
                <th>Recieved</th>
                <th>Truck</th>
              </tr>
          </thead>

          <tbody>";
        while($row=$savarsql->fetch_assoc()){
            $order_id = $row['order_id'];
            $client = $row['client_id'];
            $clientsql = $connect->query("SELECT fullname FROM client WHERE id='$client'");
            $clientrow = $clientsql->fetch_assoc();
            $client_name = $clientrow['fullname'];
            $sup = $row['supervisor'];
            $supsql = $connect->query("SELECT fullname FROM employee WHERE id='$sup'");
            $suprow = $supsql->fetch_assoc();
            $supervisor = $suprow['fullname'];
            $date = $row['checkTime'];
            $recieved = ucfirst($row['recieved']);
            $truck = $row['truck'];

            $output .= "
            <tr>
              <td>$order_id</td>
              <td>$client_name</td>
              <td>$supervisor</td>
              <td>$date</td>
              <td>$recieved</td>
              <td>$truck</td>
            </tr>
            ";
        }
        echo $output;
    }
}

?>
