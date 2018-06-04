<?php require_once ("class.phpmailer.php"); ?>
<?php require_once ("class.smtp.php"); ?>
<?php require_once ("PHPMailerAutoload.php"); ?>
<?php require_once('dbconnect.php'); ?>
<?php require_once('function.php'); ?>
<?php
$randomval = rand(1000,10000);
if(isset($_POST["submit"])){
  $name = $connect->real_escape_string($_POST['name']);
  $username = $connect->real_escape_string($_POST['username']);
  $email = $_POST["email"];
  $password = $_POST["password"];
  $address = $_POST["address"];
  $phone = $_POST["phone"];
  $division = $_POST['division'];
  $random = $_POST['random'];
  $latval = $_POST['latval'];
  $longval = $_POST['longval'];
  $query = $connect->query("SELECT * FROM client WHERE username='$username' AND email='$email' AND fullname='$name'");
  $query2 = $connect->query("SELECT * FROM admin WHERE username='$username'");
  $query3 = $connect->query("SELECT * FROM employee WHERE username='$username'");
  $query4 = $connect->query("SELECT * FROM req_client WHERE username='$username'");
  if(($query->num_rows == 0) && ($query2->num_rows == 0) && ($query3->num_rows == 0) && ($query4->num_rows == 0)){
    $hashed_pass = password_encrypt($password);
    $sql = "INSERT INTO req_client (fullname, username, password, email, address, phone, division, code, lat, longti) VALUES('$name', '$username', '$hashed_pass','$email','$address','$phone', '$division', '$random', '$latval', '$longval')";
    //echo $sql;
    $result = $connect->query($sql);
    if($result){
    //     echo "
    //     <script>
    //     alert('Registration Successful.');
    //     </script>
    //     <p style='text-align:center;color:red;padding-top:10px;'>Wait for admin acceptance</p>
    //     <a href='index.php' style='text-align:center; text-decoration:none;'>Back to Login</a>
    //     ";
    // }else{
    //     var_dump($result->error);
    // }
        $mail = new PHPMailer(); // create a new object
        $mail->IsSMTP(); // enable SMTP
        $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
        $mail->SMTPAuth = true; // authentication enabled
        #$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
        $mail->Host = "smtp.ourdeal.bid";
        $mail->Port = 587; // or for ssl port=465 or 25=non-ssl
        $mail->IsHTML(true);
        $mail->Username = "customerservice@ourdeal.bid";
        $mail->Password = "12345678";
        $mail->SetFrom("customerservice@ourdeal.bid");
        $mail->AddAddress($email);
        try {
            $msg1 = "============================= <br> Your username: $username <br> Password:  $password <br> ========================== <br> Validation link: <a href='ourdeal.bid/checkregister.php?username=$username&code=$random'> Click here </a>";
            $mail->Body = $msg1;
            $mail->Subject = "Mail from Our Deal";
            if(!$mail->Send()) {
                echo "Mailer Error: " . $mail->ErrorInfo;
            }else{
                echo "<script> alert('Please check your email for validation.'); </script>'";
            }
        }catch (Exception $e) {
            #print_r($e->getMessage());
            file_put_contents($logfile, "Error: \n", FILE_APPEND);
            file_put_contents($logfile, $e->getMessage() . "\n", FILE_APPEND);
            file_put_contents($logfile, $e->getTraceAsString() . "\n\n", FILE_APPEND);
        }
    }
  }else{
    echo "
    <p style='text-align:center;color:red;padding-top:10px;'>Username/email/Company Name already exists</p>
    ";
  }

}

?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Registration</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/i18n/defaults-*.min.js"></script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAYRKN2Ws4VtVfD6V5HYiddvlcxsv8CODM">
    </script>
    <style media="screen">
    body, html{
      height: 100%;
      background-repeat: no-repeat;
 	    background-color: #d3d3d3;
 	    font-family: sans-serif;
    }
    .main{
     	margin-top: 30px;
    }

    h1.title {
    	font-size: 50px;
    	font-family: cursive;
    	font-weight: 400;
    }

    hr{
    	width: 10%;
    	color: #fff;
    }

    .form-group{
    	margin-bottom: 15px;
    }

    label{
    	margin-bottom: 15px;
    }

    input,
    input::-webkit-input-placeholder {
        font-size: 11px;
        padding-top: 3px;
    }

    .main-login{
     	background-color: #fff;
        /* shadows and rounded borders */
        -moz-border-radius: 2px;
        -webkit-border-radius: 2px;
        border-radius: 2px;
        -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);

    }

    .main-center{
     	margin-top: 30px;
     	margin: 0 auto;
     	max-width: 330px;
      padding: 40px 40px;

    }

    .login-button{
    	margin-top: 5px;
    }

    .login-register{
    	font-size: 11px;
    	text-align: center;
    }

    </style>

  </head>
  <body>
    <div class="container">
			<div class="row main">
				<div class="panel-heading">
	               <div class="panel-title text-center">
	               		<h1 class="title">Company Name</h1>
	               		<hr />
	               	</div>
	            </div>
				<div class="main-login main-center">
					<form class="form-horizontal" method="post" action="#">

						<div class="form-group">
							<label for="name" class="cols-sm-2 control-label">Company Name</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-briefcase" aria-hidden="true"></i></span>
									<input type="text" class="form-control" name="name" id="name"  placeholder="Enter your Name" required/>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="email" class="cols-sm-2 control-label">Email</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-envelope" aria-hidden="true"></i></span>
									<input type="text" class="form-control" name="email" id="email"  placeholder="Enter your Email" reuired/>
								</div>
                <div id="status">
                </div>
							</div>
						</div>

						<div class="form-group">
							<label for="username" class="cols-sm-2 control-label">Username</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
									<input type="text" class="form-control" name="username" id="username"  placeholder="Enter your Username" required/>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="password" class="cols-sm-2 control-label">Password</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
									<input type="password" class="form-control" name="password" id="password"  placeholder="Enter your Password" required/>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="confirm" class="cols-sm-2 control-label">Confirm Password</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
									<input type="password" class="form-control" name="confirm" id="confirm"  placeholder="Confirm your Password" required/>
								</div>
                <div id="msg">
                </div>
							</div>
						</div>

            <div class="form-group">
							<label for="password" class="cols-sm-2 control-label">Address</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-home" aria-hidden="true"></i></span>
									<input type="text" class="form-control" name="address" id="address"  placeholder="Enter Address" required/>
                                    <input type="hidden" class="form-control" name="random" id="random"  value="<?php echo $randomval; ?>" required/>
                                    <input type="hidden" class="form-control" name="latval" id="latval" required/>
                                    <input type="hidden" class="form-control" name="longval" id="longval" required/>
								</div>
							</div>
						</div>
                        <div class="form-group">
							<label for="division" class="cols-sm-2 control-label">Division</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-home" aria-hidden="true"></i></span>
									<input type="text" class="form-control" name="division" id="division"  placeholder="Enter your Division" required/>
								</div>
							</div>
						</div>

            <div class="form-group">
              <label for="password" class="cols-sm-2 control-label">Phone Number</label>
              <div class="cols-sm-10">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-phone" aria-hidden="true"></i></span>
                  <input type="text" class="form-control" name="phone" id="phone"  placeholder="Enter Phone Number" onkeyup="validatephone(this);" required/>
                </div>
              </div>
            </div>

						<div class="form-group ">
							<button type="submit" name="submit" class="btn btn-primary btn-lg btn-block login-button">Register</button>
						</div>
					</form>
				</div>
			</div>
		</div>
    <script type="text/javascript">
    $(document).ready(function(){
      $('#confirm').keyup(function(){
        var pass= $(this).val();
        var password = $("#password").val();
        if(pass!=password){
          $("#msg").html("<p style='color:red'>Password does not match</p>");
        }else{
          $("#msg").html("<p style='color:green'>Password matched</p>");
        }
      });
      $("#email").keyup(function(){
        var email = $(this).val();
        var regMail = /^([_a-zA-Z0-9-]+)(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,3})$/;
        if(regMail.test(email) == false){
          $("#status").html("<p style='color:red'>Email address is not valid yet</p>");
        }else{
          $("#status").html("<p style='color:green'>Thanks, valid Email address!</p>");
        }
      });
    });
    function validatephone(phone)
    {
        var maintainplus = '';
        var numval = phone.value;
        if ( numval.charAt(0)=='+' )
        {
            var maintainplus = '';
        }
        curphonevar = numval.replace(/[\\A-Za-z!"£$%^&\,*+_={};:'@#~,.Š\/<>?|`¬\]\[]/g,'');
        phone.value = maintainplus + curphonevar;
        var maintainplus = '';
        phone.focus;
    }
    $(document).ready(function(){
        $("#address").keyup(function() {
            var address = $(this).val();
            $.getJSON("https://maps.googleapis.com/maps/api/geocode/json?address="+address+"&key=AIzaSyAYRKN2Ws4VtVfD6V5HYiddvlcxsv8CODM", function(data) {
                var text = data.results[0].geometry.location.lat;
                var text2 = data.results[0].geometry.location.lng;
                $("#latval").val(text);
                $("#longval").val(text2);
            });
        });
    });
    </script>
  </body>
</html>
