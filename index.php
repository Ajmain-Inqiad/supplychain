<?php
require_once 'dbconnect.php';
?>
<?php require_once 'function.php'; ?>
<?php
$msg="";
if(isset($_POST['submit'])){
  $username = $connect->real_escape_string($_POST['username']);
  $password = $_POST['password'];
  if(find_admin($username, $password, $connect)){
    $sql = "UPDATE admin SET logged_in = 'yes' WHERE username='$username' LIMIT 1";
    $query = $connect->query($sql);
    $_SESSION['username'] = $username;
    $_SESSION['type'] = 'admin';
    header("Location: admin.php");
}elseif (find_employee($username,$password,$connect)) {
    $sql = "UPDATE employee SET logged_in = 'yes' WHERE username='$username' LIMIT 1";
    $query = $connect->query($sql);
    $sql = "SELECT job_type FROM employee WHERE username='{$username}' LIMIT 1";
    $result = $connect->query($sql);
    $row = $result->fetch_assoc();
    $_SESSION['username'] = $username;
    $_SESSION['type'] = 'employee';
    $_SESSION['job_type'] = $row['job_type'];
    header("Location: employee.php");
}elseif (find_client($username,$password,$connect)) {
    $sql = "UPDATE client SET logged_in = 'yes' WHERE username='$username' LIMIT 1";
    $query = $connect->query($sql);
    $_SESSION['username'] = $username;
    $_SESSION['type'] = 'client';
    header("Location: client.php");
  }
  else{
    $msg="Username or Password is invalid";
  }
}

?>

<html>

<head>
  <title>Welcome to login</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
  <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
  <style media="screen">
  body{
    background-image: url("img/giphy.gif");
    background-repeat: no-repeat;
    background-size: cover;
  }
    .vertical-offset-100 {
      padding-top: 10%;
      padding-left: 30%;
    }
    .panel{
      padding: 10%;
    }
    #error{
      font-family: sans-serif;
      color: red;
    }
    #reg {
      text-decoration: none;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="row vertical-offset-100">
      <div class="col-md-6 col-md-offset-6" style="background-color: #C0C0C0">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Welcome, Log in</h3>
          </div>
          <div class="panel-body">
            <?php if($msg != "") {?>
            <p id="error"><?php echo $msg; ?></p>
            <?php } ?>
            <form accept-charset="UTF-8" role="form" method="post" action="">
              <fieldset>
                <div class="input-group form-group">
                  <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                  <input id="username" type="text" class="form-control" name="username" placeholder="Username" required>
                </div>
                <div class="input-group form-group">
                  <span class="input-group-addon"><i class="fa fa-key" aria-hidden="true"></i></span>
                  <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>
                </div>
                <input class="btn btn-lg btn-success btn-block" type="submit" name="submit" value="Login">
              </fieldset>
            </form>
            <a href="register.php" id="reg">Click here for Client Registration</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>
