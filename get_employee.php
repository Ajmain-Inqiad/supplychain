<?php
require_once 'dbconnect.php';
$search = $_POST['name'];
$query = "SELECT * FROM employee WHERE fullname LIKE '%$search%' ";
$result = $connect->query($query); ?>
<table class="table table-hover" style="width:100%;">
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

  <tbody>
<?php
while ($row = $result->fetch_assoc()) { ?>
      <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['fullname']; ?></td>
        <td><?php echo $row['job_type']; ?></td>
        <td><?php echo $row['email']; ?></td>
        <td><?php echo $row['image']; ?></td>
        <td><button type="button" class="btn btn-danger" id="submit" value="<?php echo $row['id']; ?>"> Delete</button></td>
      </tr>
  <?php
}
?>
  </tbody>
</table>
