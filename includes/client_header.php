<?php
if(!isset($_SESSION['username']) || ($_SESSION['type'] != "client")){
  header("Location: logout.php");
}
$username = $_SESSION['username'];
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.16/jquery.datetimepicker.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.16/jquery.datetimepicker.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.16/jquery.datetimepicker.full.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=key"></script>

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
                          <a class="navbar-brand" href="client.php">
                              Client Dashboard <a href="#" class="buttoncollapse" data-id="1">Open Chat</a>
                          </a>
                      </div>
                  </div>
              </div>
