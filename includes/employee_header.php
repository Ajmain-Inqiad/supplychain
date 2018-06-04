<?php
if(!isset($_SESSION['username']) || ($_SESSION['type'] != "employee")){
  header("Location: logout.php");
}
$username = $_SESSION['username'];
$job_type = $_SESSION['job_type'];
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Welcome <?php echo ucfirst($username); ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">

    <link rel="stylesheet" href="css/admin_nav.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/i18n/defaults-*.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAYRKN2Ws4VtVfD6V5HYiddvlcxsv8CODM"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.js"> </script>


  </head>
  <body>
    <div class="row">
      <div class="side-menu">
          <nav class="navbar navbar-default" role="navigation">

              <div class="navbar-header">
                  <div class="brand-wrapper">
                      <button type="button" class="navbar-toggle">
                          <span class="sr-only">Toggle navigation</span>
                          <span class="icon-bar"></span>
                          <span class="icon-bar"></span>
                          <span class="icon-bar"></span>
                      </button>
                      <div class="brand-name-wrapper">
                          <a class="navbar-brand" href="employee.php">
                              <?php echo $job_type; ?> Dashboard
                          </a>
                      </div>
                  </div>
              </div>
