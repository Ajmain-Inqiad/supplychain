<?php
require_once 'dbconnect.php';
$search = $_POST['name'];
$query = "SELECT * FROM client WHERE fullname LIKE '%$search%' ";
$result = $connect->query($query); ?>
 <p style="text-align: center"> <b> Current Client list </b></p>
<table class="table table-hover" style="width:100%;">
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

  <tbody>
<?php
while ($row = $result->fetch_assoc()) { ?>
      <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['fullname']; ?></td>
        <td><?php echo $row['email']; ?></td>
        <td><?php echo $row['phone']; ?></td>
        <td><?php echo $row['address']; ?></td>
        <td><button type="button" class="btn btn-danger"> Delete</button></td>
      </tr>
  <?php
}
?>
  </tbody>
</table>
