<?php
require_once 'dbconnect.php';
if(isset($_POST["type"])){
    $type = $_POST["type"];
    if($type == "reqclient"){
      $query = "SELECT * FROM req_client ORDER BY id DESC";
      $result = $connect->query($query);
      if($result->num_rows > 0){
        $output="
         <p style='text-align: center'> <b> Requested Client list </b></p>
        <table class='table table-hover' style='width:100%;'>
          <thead>
              <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Action</th>
              </tr>
          </thead>

          <tbody>";
          while ($row = $result->fetch_assoc()) {
            $id=$row['id'];
            $fullname=$row['fullname'];
            $email = $row['email'];
            $phone = $row['phone'];
            $address = $row['address'];
            $output .= "
            <tr>
              <td>$id</td>
              <td>$fullname</td>
              <td>$email</td>
              <td>$phone</td>
              <td>$address</td>
              <td>
                <button type='button' class='btn btn-danger' id='delete' data-toggle='modal' data-target='#exampleModal' data-whatever='$email deletereqclient'> Delete </button>
                <button type='button' class='btn btn-success' id='approve' data-toggle='modal' data-target='#exampleModal' data-whatever='$email approvereqclient'> Approve </button>
              </td>
            </tr>

            ";
          }
          $output .="</tbdoy></table>";
      }else{
        $output = "<br><p style='text-align:center; color:red'><i>No New Client Request</i></p>";
      }
        echo $output;
    }elseif ($type=="currentclient") {
      $query = "SELECT * FROM client";
      $result = $connect->query($query);
      if($result->num_rows > 0){
        $output="
        <p style='text-align: center'> <b> Current Client list </b></p>
        <table class='table table-hover' style='width:100%;'>
          <thead>
              <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Address</th>
                <th>Action</th>
              </tr>
          </thead>

          <tbody>";
          while ($row = $result->fetch_assoc()) {
            $id=$row['id'];
            $fullname=$row['fullname'];
            $email = $row['email'];
            $address = $row['address'];
            $output .= "
            <tr>
              <td>$id</td>
              <td>$fullname</td>
              <td>$email</td>
              <td>$address</td>
              <td>
                <button type='button' class='btn btn-danger' id='delete' data-toggle='modal' data-target='#exampleModal' data-whatever='$email deletecurrentclient'> Delete </button>
              </td>
            </tr>

            ";
          }
          $output .="</tbdoy></table>";
      }else{
        $output = "<br><p style='text-align:center; color:red'><i>No New Client Request</i></p>";
      }
      echo $output;
    }

}

?>
