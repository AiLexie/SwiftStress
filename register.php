<?php

	require('includes/db.php');

	require('includes/init.php');

	if($user -> LoggedIn()){

		header('location: index.php');

		die();

	}

?>
<!DOCTYPE html>
<html lang="en">
    <head>        
        <title>StrikeREAD - Register</title>    

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <link href="css/styles.css" rel="stylesheet" type="text/css" />
        <!--[if lt IE 10]><link rel="stylesheet" type="text/css" href="css/ie.css"/><![endif]-->
        
        <script type="text/javascript" src="js/plugins/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="js/plugins/jquery/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>
        
        <script type="text/javascript" src="js/plugins/jquery-validation/jquery.validate.min.js"></script>
        
        <script type="text/javascript" src="js/plugins.js"></script>        
        <script type="text/javascript" src="js/demo.js"></script>
        <script type="text/javascript" src="js/actions.js"></script>        
        
    </head>
    <body>
        
        <div class="page-container">
            
            <div class="page-content page-content-default">
            
                <div class="block-login">
                    <div class="block-login-logo">
                        <h1 class="Estilo1"><strong>StrikeREAD</strong></h1>
                    </div>
                    <div class="block-login-content">
                        <h1><strong>Register</strong></h1>
                        <form action="" id="validate" class="form" method="POST">
						<?php

									if(isset($_POST['registerBtn'])){

										require_once('includes/recaptchalib.php');

										$privatekey = "6Le15dMSAAAAAMt993qrA52wyqkzPlgRuLqehtiN";

										$resp = recaptcha_check_answer ($privatekey,

										$_SERVER["REMOTE_ADDR"],

										$_POST["recaptcha_challenge_field"],

										$_POST["recaptcha_response_field"]);

										$username = $_POST['username'];

										$password = $_POST['password'];

										$rpassword = $_POST['rpassword'];

										$email = $_POST['email'];

										$uid = $_POST['uid'];

										$checkUsername = $odb->prepare("SELECT COUNT(*) FROM `users` WHERE `username` = :username");

										$checkUsername->execute(array(':username' => $username));

										$countUsername = $checkUsername -> fetchColumn(0);

										$checkUID = $odb->prepare("SELECT COUNT(*) FROM `users` WHERE `uid` = :uid");

										$checkUID->execute(array(':uid' => $uid));

										$countUID = $checkUID -> fetchColumn(0);

										$checkEmail = $odb->prepare("SELECT COUNT(*) FROM `users` WHERE `email` = :email");

										$checkEmail->execute(array(':email' => $email));

										$countEmail = $checkEmail -> fetchColumn(0);

										if(empty($username) || empty($password) || empty($rpassword) || empty($email) || empty($uid)){

											echo $design->alert('danger', 'Error', 'Please Fill In All Fields!');

										} elseif(!isset($_POST['tos'])) {

											echo $design->alert('danger', 'Error', 'You Must Agree To The Terms of Service!');

										} elseif(!$resp->is_valid) {

											echo $design->alert('danger', 'Error', 'Error, you entered a invalid captcha!!');

										} else {

											if(!ctype_alnum($username) || strlen($username) < 4 || strlen($username) > 15){

												echo $design->alert('danger', 'Error', 'Username Must Be 4 - 16 Characters!');

											} elseif(strlen($uid) < 1) {

												echo $design->alert('danger', 'Error', 'Hackforums UID Must Be At Least 1 Character!');

											} else {

												if(!($countEmail == 0)){

													echo $design->alert('danger', 'Error', 'Email Address Is Already Taken!');

												} elseif(!($countUsername == 0)) {

													echo $design->alert('danger', 'Error', 'Username Is Already Taken!');

												}
												else {

													if(!filter_var($email, FILTER_VALIDATE_EMAIL)){

														echo $design->alert('danger', 'Error', 'Invalid Email!');

													} else {

														if($password != $rpassword){

															echo $design->alert('danger', 'Error', 'Passwords Do Not Match!');

														} else {

															if(isset($_SESSION['referral'])){

																$checkIP = $odb -> prepare("SELECT * FROM `referuser` WHERE `ip`='".SHA1($_SERVER['REMOTE_ADDR'])."'");

																$checkIP -> execute();

																$countIP = $checkIP -> rowCount();

																if($countIP != 1){

																	$checkUser = $odb -> prepare("SELECT * FROM `refers` WHERE `user`='".$_SESSION['referral']."'");

																	$checkUser -> execute();

																	$countUser = $checkUser -> rowCount();

																	if($countUser != 1){

																		$Insrefer = $odb -> prepare("INSERT INTO `refers` (user, referals) VALUES('".$_SESSION['referral']."', 1)");

																		$Insrefer -> execute();

																	} else {

																		$Insrefer = $odb -> prepare("UPDATE `refers` SET `referals`=`referals`+1 WHERE `user`='".$_SESSION['referral']."'");

																		$Insrefer -> execute();

																	}

																	$ReferUser = $odb -> prepare("INSERT INTO `referuser` (referrer, referred, ip) VALUES('".$_SESSION['referral']."', '".$username."', '".SHA1($_SERVER['REMOTE_ADDR'])."')");

																	$ReferUser -> execute();

																}

																session_unset($_SESSION['referral']);

															}

															$insertUser = $odb->prepare("INSERT INTO `users` VALUES(NULL, :username, :password, :email, :uid , 0, 0, 0, 0)");

															$insertUser->execute(array(':username' => $username, ':password' => SHA1($password), ':email' => $email, ':uid' => $uid));

															echo $design->alert('success', 'Success', 'Successfully Registered!');

															echo '<meta http-equiv="refresh" content="2;url=login.php">';

														}

													}

												}

											}

										}

									}

								?>

								<script type="text/javascript">

									var RecaptchaOptions = {

										theme : 'black'

									};

								</script>
							<p>&nbsp;</p>
                            
                        <div class="form-group">                        
                            <label>Login:</label>
                            <input type="text" name="username" id="username" maxlength="15" class="form-control" placeholder="Your username" value=""/>
							<div class="clear"></div>
                        </div>
                        <div class="form-group">                        
                            <label>Password:</label>
                            <input type="password" name="password" class="form-control" placeholder="Your password" id="pass" value=""/>
							<div class="clear"></div>
                        </div>
                        <div class="form-group">                        
                            <label>Re-password:</label>
                            <input type="password" name="rpassword" class="form-control" placeholder="Repeat password" id="rpass" value=""/>
							<div class="clear"></div>
                        </div>
						
                        <div class="sp"></div>
						
                        <div class="form-group">                        
                            <label>E-mail:</label>
                            <input type="email" name="email" class="form-control" placeholder="Your e-mail" id="email" value=""/>
							<div class="clear"></div>
                        </div>
						
						<div class="form-group">                        
                            <label>Skype:</label>
							<input class="form-control" placeholder="Skype" name="uid" type="text"/>
							<div class="clear"></div>
                        </div>
                        
						<div class="sp"></div>
						
						<?php

										require_once('includes/recaptchalib.php');

										$publickey = "6Le15dMSAAAAABc-TeLmqmXqmjkSG2IWe2MVx1ym";

										echo recaptcha_get_html($publickey);

									?>
									
						<div class="sp"></div>
						
                        <div class="pull-left">
                            <div class="form-group">                                 
                                <div class="checkbox">
                                    <label><input type="checkbox" name="tos"/> Accept TOS</label>
                                </div>
                            </div>
                        </div>                                                            

                        <button class="btn btn-primary btn-block" value="Register" name="registerBtn" type="submit"><strong>Register</strong></button>
                        
                        </form>
						
						<div class="sp"></div>

                        <button class="btn btn-success btn-block" onClick="location.href='tos.php'"><strong>Read TOS</strong></button>                                   

                        <div class="sp"></div>
                        <div class="pull-left">
                            All Rights Reserved StrikeREAD 2014
                        </div>
                    </div>
                </div>
				<br>
            </div>
        </div>
        
        <script type="text/javascript">
        $("#signupForm").validate({
		rules: {
			login: {
				required: true,
				minlength: 2
			},
			password: {
				required: true,
				minlength: 5
			},
			're-password': {
				required: true,
				minlength: 5,
				equalTo: "#password"
			},
			email: {
				required: true,
				email: true
			},
                        name: "required"			
		}
	});            
        </script>
        
    </body>
</html>
