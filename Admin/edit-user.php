<?php
	$page = 'Admin Panel - Manage Users';
	$pageIcon = 'group';
	ob_start();
	require_once('../includes/db.php');
	require_once('../includes/init.php');
	if(!($user->LoggedIn())){
		header('location: ../login.php');
		die();
	}
	if(!($user->isAdmin($odb))){
		header('location: ../index.php');
	}
	if(!($user->notBanned($odb))){
		header('location: ../logout.php');
		die();
	}
	if(!isset($_GET['id'])){
		header('location: ../index.php');
	}
	$id = $_GET['id'];
	$SQLGetInfo = $odb->prepare("SELECT * FROM `users` WHERE `ID` = :id LIMIT 1");
	$SQLGetInfo->execute(array(':id' => $_GET['id']));
	$userInfo = $SQLGetInfo -> fetch(PDO::FETCH_ASSOC);
	$username = $userInfo['username'];
	$password = $userInfo['password'];
	$email = $userInfo['email'];
	$rank = $userInfo['rank'];
	$membership = $userInfo['membership'];
	$status = $userInfo['status'];
?>
<html lang="en">
    
<head>        
        <title>StrikeREAD [ADMIN] - Edit Users</title>    

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <link href="../css/styles.css" rel="stylesheet" type="text/css" />
        <!--[if lt IE 10]><link rel="stylesheet" type="text/css" href="css/ie.css"/><![endif]-->
        
        <script type="text/javascript" src="../js/plugins/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="../js/plugins/jquery/jquery-ui.min.js"></script>
        <script type="text/javascript" src="../js/plugins/bootstrap/bootstrap.min.js"></script>
        <script type="text/javascript" src="../js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>
		<script type="text/javascript" src="../js/plugins/sparkline/jquery.sparkline.min.js"></script>   
        <script type='text/javascript' src='../js/plugins/knob/jquery.knob.js'></script>  
        <script type="text/javascript" src="../js/plugins.js"></script>
        <script type="text/javascript" src="../js/actions.js"></script>  
        
    </head>
    <body>
        
        <div class="page-container">
            
            <?php
	include("head.php");
	include("sidebar.php");
?>
<div class="page-content">
<div class="container">
<div class="page-toolbar">
<div class="page-toolbar-block">
<div class="page-toolbar-title">Users</div>
<div class="page-toolbar-subtitle">Manage Users</div>
</div>
<ul class="breadcrumb">
<li><a href="index.php">STRIKEREAD</a></li>
<li><a href="admin/index.php">Admin</a></li>
<li class="active">Manage Users</li>
</ul>
<div id="div" style="display:inline"></div>
</div>
<div class="row">
<div class="col-md-12">
<div class="block">
<div class="block-content">
<form method="POST">
										<?php
											if(isset($_POST['rBtn'])){
												$sql = $odb->prepare("DELETE FROM `users` WHERE `ID` = :id");
												$sql->execute(array(':id' => $id));
												header('location: users.php');
											}
											if(isset($_POST['updateBtn'])){
												$update = false;
												if($username != $_POST['username']){
													if(ctype_alnum($_POST['username']) && strlen($_POST['username']) >= 4 && strlen($_POST['username']) <= 15){
														$SQL = $odb->prepare("UPDATE `users` SET `username` = :username WHERE `ID` = :id");
														$SQL->execute(array(':username' => $_POST['username'], ':id' => $id));
														$update = true;
														$username = $_POST['username'];
													} else {
														echo $design->alert('danger', 'Error', 'Username Has To Be 4-15 Characters And Alphanumeric!');
													}
												}
												if(!empty($_POST['password'])){
													$SQL = $odb->prepare("UPDATE `users` SET `password` = :password WHERE `ID` = :id");
													$SQL->execute(array(':password' => SHA1($_POST['password']), ':id' => $id));
													$update = true;
													$password = SHA1($_POST['password']);
												}
												if($email != $_POST['email']){
													if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
														$SQL = $odb->prepare("UPDATE `users` SET `email` = :email WHERE `ID` = :id");
														$SQL->execute(array(':email' => $_POST['email'], ':id' => $id));
														$update = true;
														$email = $_POST['email'];
													} else {
														echo $design->alert('danger', 'Error', 'Email Is Invalid!');
													}
												}
												if($rank != $_POST['rank']){
													$SQL = $odb->prepare("UPDATE `users` SET `rank` = :rank WHERE `ID` = :id");
													$SQL->execute(array(':rank' => $_POST['rank'], ':id' => $id));
													$update = true;
													$rank = $_POST['rank'];
												}
												if($membership != $_POST['plan']){
													if($_POST['plan'] == 0){
														$SQL = $odb->prepare("UPDATE `users` SET `expire` = '0', `membership` = '0' WHERE `ID` = :id");
														$SQL->execute(array(':id' => $id));
														$update = true;
														$membership = $_POST['plan'];
													} else {
														$getPlanInfo = $odb->prepare("SELECT `unit`,`length` FROM `plans` WHERE `ID` = :plan");
														$getPlanInfo->execute(array(':plan' => $_POST['plan']));
														$plan = $getPlanInfo->fetch(PDO::FETCH_ASSOC);
														$unit = $plan['unit'];
														$length = $plan['length'];
														$newExpire = strtotime("+{$length} {$unit}");
														$updateSQL = $odb->prepare("UPDATE `users` SET `expire` = :expire, `membership` = :plan WHERE `id` = :id");
														$updateSQL->execute(array(':expire' => $newExpire, ':plan' => $_POST['plan'], ':id' => $id));
														$update = true;
														$membership = $_POST['plan'];
													}
												}
												if($status != $_POST['status']){
													$SQL = $odb->prepare("UPDATE `users` SET `status` = :status WHERE `ID` = :id");
													$SQL->execute(array(':status' => $_POST['status'], ':id' => $id));
													$update = true;
													$status = $_POST['status'];
												}
												if($update == true){
													echo $design->alert('success', 'Success', 'User Has Been Updated!');
												} else {
													echo $design->alert('warning', 'Warning', 'Nothing Was Updated!');
												}
											}
											if(isset($_POST['clearaBtn'])){
												$SQL = $odb->prepare("DELETE FROM `logs` WHERE `user` = :username");
												$SQL->execute(array(':username' => $username));
												echo $design->alert('success', 'Success', 'Attack Logs Have Been Cleared From Users Account!');
											}
											if(isset($_POST['clearlBtn'])){
												$SQL = $odb->prepare("DELETE FROM `loginip` WHERE `username` = :username");
												$SQL->execute(array(':username' => $username));
												echo $design->alert('success', 'Success', 'Login Logs Have Been Cleared From Users Account!');
											}
											if(isset($_POST['clearpBtn'])){
												$SQL = $odb->prepare("DELETE FROM `payments` WHERE `user` = :id");
												$SQL->execute(array(':id' => $_SESSION['ID']));
												echo $design->alert('success', 'Success', 'Payment Logs Have Been Cleared From Users Account!');
											}
										?>
										<div class="form-group">
											<label>Username</label>
											<input type="text" class="form-control" name="username" placeholder="username" value="<?php echo $username;?>"/>
										</div>
										<div class="form-group">
											<label>Password</label>
											<input type="text" class="form-control" name="password" placeholder="password"/>
										</div>
										<div class="form-group">
											<label>Email</label>
											<input type="text" class="form-control" name="email" placeholder="email" value="<?php echo htmlentities($email);?>"/>
										</div>
										<div class="form-group">
											<label>Rank</label>
											<select class="form-control" name="rank">
												<?php
													function selectedR($check, $rank){
														if($check == $rank){
															return 'selected="selected"';
														}
													}
												?>
												<option value="0" <?php echo selectedR(0, $rank); ?> >User</option>
												<option value="1" <?php echo selectedR(1, $rank); ?> >Admin</option>
											</select>
										</div>
										<div class="form-group">
											<label>Plan</label>
											<select class="form-control" name="plan">
												<option value="0">No Membership</option>
												<?php 
													$SQLGetMembership = $odb->query("SELECT * FROM `plans` ORDER BY `price` ASC");
													while($memberships = $SQLGetMembership->fetch(PDO::FETCH_ASSOC)){
														$mi = $memberships['ID'];
														$mn = $memberships['name'];
														$selectedM = ($mi == $membership) ? 'selected="selected"' : '';
														echo '<option value="'.$mi.'" '.$selectedM.'>'.$mn.'</option>';
													}
												?>
											</select>
										</div>
										<div class="form-group">
											<label>Status</label>
											<select class="form-control" name="status">
												<?php
													function selectedS($check, $rank){
														if($check == $rank){
															return 'selected="selected"';
														}
													}
												?>
												<option value="0" <?php echo selectedS(0, $status); ?>>Active</option>
												<option value="1" <?php echo selectedS(1, $status); ?>>Banned</option>
											</select>
										</div>
										<button type="submit" name="updateBtn" class="btn btn-default">Update</button>
										<button type="submit" name="rbtn" class="btn btn-default">Delete</button>
										<button type="submit" name="clearlBtn" class="btn btn-default">Clear Login Logs</button>
										<button type="submit" name="clearaBtn" class="btn btn-default">Clear Attack Logs</button>
										<button type="submit" name="clearpBtn" class="btn btn-default">Clear Payment Logs</button>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
</div></div>
</body>
</html>