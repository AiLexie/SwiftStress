<?php
require 'includes/db.php';
require 'includes/init.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>        
        <title>StrikeREAD - Login</title>    

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <link href="css/login.css" rel="stylesheet" type="text/css" />
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
                        <h1><strong>Login</strong></h1>
						 <?php
							if (!($user -> LoggedIn()))
							{
								if (isset($_POST['loginBtn']))
								{
									$username = $_POST['username'];
									$password = $_POST['password'];
									$errors = array();
									if (!ctype_alnum($username) || strlen($username) < 4 || strlen($username) > 15)
									{
										$errors[] = 'Username Must Be  Alphanumberic And 4-15 characters in length';
									}
									
									if (empty($username) || empty($password))
									{
										$errors[] = 'Please fill in all fields';
									}
									
									if (empty($errors))
									{
										$SQLCheckLogin = $odb -> prepare("SELECT COUNT(*) FROM `users` WHERE `username` = :username AND `password` = :password");
										$SQLCheckLogin -> execute(array(':username' => $username, ':password' => SHA1($password)));
										$countLogin = $SQLCheckLogin -> fetchColumn(0);
										if ($countLogin == 1)
										{
											$SQLGetInfo = $odb -> prepare("SELECT `username`, `ID` FROM `users` WHERE `username` = :username AND `password` = :password");
											$SQLGetInfo -> execute(array(':username' => $username, ':password' => SHA1($password)));
											$userInfo = $SQLGetInfo -> fetch(PDO::FETCH_ASSOC);
											if ($userInfo['status'] == 0)
											{
												$_SESSION['username'] = $userInfo['username'];
												$_SESSION['ID'] = $userInfo['ID'];
												echo '<div class="alert alert-success"><p><strong>SUCCESS: </strong>Welcome!! Login Successful.  Redirecting....</p></div><meta http-equiv="refresh" content="3;url=index.php">';
											}
											else
											{
												echo '<div class="alert alert-danger"><p><strong>ERROR: </strong>Your user was banned</p></div>';
											}
										}
										else
										{
											echo '<div class="alert alert-danger"><p><strong>ERROR: </strong>Login Failed</p></div>';
										}
									}
									else
									{
										echo '<div class="alert alert-danger"><p><strong>ERROR:</strong><br />';
										foreach($errors as $error)
										{
											echo '-'.$error.'<br />';
										}
										echo '</div>';
									}
								}
							}
							else
							{
								header('location: index.php');
							}
							?>
							<p>&nbsp;</p>
						<form action="" id="validate" class="form" method="POST">
                            
                        <div class="form-group">  
                            <input type="text" name="username" class="form-control" id="username" placeholder="Your username"/>
							<div class="clear"></div>
						</div>
                        <div class="form-group">           				
                            <input type="password" name="password" class="form-control" id="password" placeholder="Your password" value=""/>
							<div class="clear"></div>
						</div>   

						<div class="sp"></div>
                         <div class="pull-left">
                            <div class="form-group">                                 
                                <div class="checkbox">
                                    <label><input type="checkbox" name="tos"/> Accept TOS</label>
                                </div>
                            </div>
                        </div>   

                        <button class="btn btn-primary btn-block" type="submit" value="Login" name="loginBtn"><strong>Login</strong></button>  
                        
                        </form>
                        <div class="sp"></div>

                        <button class="btn btn-success btn-block" onClick="location.href='register.php'"><strong>Create an account</strong></button>                                   

                        <div class="sp"></div>
                        <div class="pull-left">
                            All Rights Reserved StrikeREAD 2014
                        </div>
                    </div>

                </div>
             
            </div>
        </div>
        
        
    </body>
</html>