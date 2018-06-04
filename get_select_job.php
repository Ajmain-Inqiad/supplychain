<?php
require_once 'dbconnect.php';
if(isset($_POST["type"])){
    $type = $_POST["type"];
    $query = "SELECT * FROM employee WHERE job_type='$type' ORDER BY id ASC";
    if($type=="all"){
      $query = "SELECT * FROM employee ORDER BY id ASC";
    }
    $result = $connect->query($query);
    $output="<table class='table table-hover' style='width:100%;'>
      <thead>
          <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Job Type</th>
            <th>Email</th>
            <th>Image</th>
            <th>Action</th>
          </tr>
      </thead>

      <tbody>";
      while ($row = $result->fetch_assoc()) {
        $id=$row['id'];
        $fullname=$row['fullname'];
        $job_type = $row['job_type'];
        $email = $row['email'];
        $image = $row['image'];
        $output .= "
        <tr>
          <td>$id</td>
          <td>$fullname</td>
          <td>$job_type</td>
          <td>$email</td>
          <td>$image</td>
          <td><button type='button' class='btn btn-danger' id='submit' value='$id'> Delete</button></td>
        </tr>

        ";
      }
      $output .="</tbdoy></table>";
      echo $output;
}

?>
