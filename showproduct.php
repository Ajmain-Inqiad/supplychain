<?php require_once ("dbconnect.php"); ?>
<?php
$result = $connect->query("SELECT * FROM product");
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Products</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="css/product.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
    </head>
    <body>
        <div class="container">
            <br>
            <p style="text-align:center;"> <b>Product list</b></p>
            <div class="panel panel-default panel-order">
              <div class="panel-body">

            <?php
            while ($row = $result->fetch_assoc()) {?>
              		<div class="row">
            			  <div class="col-md-1"><img src="<?php echo $row['image']; ?>" class="media-object"></div>
            			  <div class="col-md-11">
            				<div class="row">
            				  <div class="col-md-12">
            					<div class="pull-right"><i class="fa fa-money"></i> <?php echo $row['price']; ?> BDT</div>
            					<span><strong><?php echo ucfirst($row['name']); ?></strong></span> <span class="label label-info"><?php echo ucfirst($row['category']); ?></span><br>
            					<?php echo $row['description']; ?>
            				  </div>
            				  <div class="col-md-12">
            					<a href="makeorder.php"> Order page, You need an account </a>
            				  </div>
            				</div>
            			  </div>
            			</div>

            <?php } ?>
            </div>
          </div>
        </div>

    </body>
</html>
