<?php
ob_start();
error_reporting(0);
require_once 'includes/db.php';
require_once 'includes/init.php';
if (!($user -> LoggedIn()))
{
	header('location: login.php');
	die();
}
if (!($user -> notBanned($odb)))
{
	header('location: login.php');
	die();
}

$plansql = $odb->prepare("SELECT `users`.*,`plans`.`name`, `plans`.`mbt` FROM `users`, `plans` WHERE `plans`.`ID` = `users`.`membership` AND `users`.`ID` = :id LIMIT 1");
	$plansql->execute(array(":id" => $_SESSION['ID']));
	$userInfo = $plansql->fetch(PDO::FETCH_ASSOC);
	$test = $odb->prepare("SELECT `email` FROM `users` WHERE `ID` = :id LIMIT 1");
	$test->execute(array(":id" => $_SESSION['ID']));
	$testInfo = $test->fetch(PDO::FETCH_ASSOC);
	$loginLogs = $odb->query("SELECT COUNT(*) FROM `loginip` WHERE `username` = '{$_SESSION['username']}'");
	$attackLogs = $odb->query("SELECT COUNT(*) FROM `logs` WHERE `user` = '{$_SESSION['username']}'");
	$purchaseLogs = $odb->query("SELECT COUNT(*) FROM `payments` WHERE `user` = '{$_SESSION['ID']}'");
?>
<!DOCTYPE html>
<html lang="en">
    
<head>        
        <title>StrikeREAD - UserCp</title>    

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <link href="css/styles.css" rel="stylesheet" type="text/css" />
        <!--[if lt IE 10]><link rel="stylesheet" type="text/css" href="css/ie.css"/><![endif]-->
        
        <script type="text/javascript" src="js/plugins/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="js/plugins/jquery/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>
		<script type="text/javascript" src="js/plugins/sparkline/jquery.sparkline.min.js"></script>   
        <script type='text/javascript' src='js/plugins/knob/jquery.knob.js'></script>  
        <script type="text/javascript" src="js/plugins.js"></script>
        <script type="text/javascript" src="js/actions.js"></script>  
        
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
<div class="page-toolbar-title">UserCP</div>
<div class="page-toolbar-subtitle">Welcome! <?php echo htmlentities($_SESSION['username']); ?></div>
</div>
<ul class="breadcrumb">
<li><a href="index.php">STRIKEREAD</a></li>
<li class="active">UserCP</li>
</ul>
<div id="div" style="display:inline"></div>
</div>
<div class="row">

                            <div class="col-md-6">
                                <div class="block nav-tabs-vertical">                   
                                    <div class="block-head">                        
                                        <div class="block-title">Your UserCP, <?php echo htmlentities($_SESSION['username']); ?></div>
                                    </div>
                                    <div class="tabs">
                                        <ul class="nav nav-tabs">
                                            <li class="active"><a href="#tab19" data-toggle="tab">Account Information</a></li>
                                            <li><a href="#tab20" data-toggle="tab">My Membership</a></li>
                                            <li><a href="#tab21" data-toggle="tab">Change Password</a></li>
                                        </ul>                    
                                        <div class="block-content tab-content">
                                            <div class="tab-pane active" id="tab19">
											    <div class="table-responsive">
													<table class="table table-hover table-bordered table-striped">
														<tbody>
															<tr>
																<td>Username:</td>
																<td><?php echo htmlentities($_SESSION['username']); ?></td>
															</tr>
															<tr>
																<td>Email Address:</td>
																<td><?php echo $testInfo['email']; ?></td>
															</tr>
															<tr>
																<td>Last IP:</td>
																<td><?php echo $_SERVER['REMOTE_ADDR']; ?></td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>
                                            <div class="tab-pane" id="tab20">
                                                <div class="table-responsive">
													<table class="table table-hover table-bordered table-striped">
														<tbody>
															<tr>
																<td>Plan:</td>
																<td><?php echo $userInfo['name']; ?></td>
															</tr>
															<tr>
																<td>Expires:</td>
																<td><?php echo date('d-m-Y' ,$userInfo['expire']); ?></td>
															</tr>
															<tr>
																<td>Max Boot Time:</td>
																<td><?php echo $userInfo['mbt']; ?> Seconds</td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>
                                            <div class="tab-pane" id="tab21">
                                               <div class="portlet-body">
									<form method="POST">
										<?php 
											if(isset($_POST['updatePassBtn'])){
												$cpassword = $_POST['cpassword'];
												$npassword = $_POST['npassword'];
												$rpassword = $_POST['rpassword'];
												if(!empty($cpassword) && !empty($npassword) && !empty($rpassword)){
													if($npassword == $rpassword){
														$SQLCheckCurrent = $odb->prepare("SELECT COUNT(*) FROM `users` WHERE `username` = :username AND `password` = :password");
														$SQLCheckCurrent->execute(array(':username' => $_SESSION['username'], ':password' => SHA1($cpassword)));
														$countCurrent = $SQLCheckCurrent -> fetchColumn(0);
														if($countCurrent == 1){
															$SQLUpdate = $odb->prepare("UPDATE `users` SET `password` = :password WHERE `username` = :username AND `ID` = :id");
															$SQLUpdate->execute(array(':password' => SHA1($npassword),':username' => $_SESSION['username'], ':id' => $_SESSION['ID']));
															echo $design->alert('success', 'Success', 'Password Has Been Updated!');
														} else {
															echo $design->alert('danger', 'Error', 'Current Password Is Incorrect!');
														}
													} else {
														echo $design->alert('danger', 'Error', 'New Passwords Do Not Match!');
													}
												} else {
													echo $design->alert('danger', 'Error', 'Please Fill In All Fields!');
												}
											}
										?>
										<div class="form-group">
												<label>Current Password</label>
												<input type="password" class="form-control" name="cpassword" placeholder="current password"/>
											</div>
											<div class="form-group">
												<label>New Password</label>
												<input type="password" class="form-control" name="npassword" placeholder="new password"/>
											</div>
											<div class="form-group">
												<label>Repeat New Password</label>
												<input type="password" class="form-control" name="rpassword" placeholder="repeat new password"/>
											</div>
											<button type="submit" name="updatePassBtn" class="btn btn-success">Update Password</button>
										</form>
									</div>
								</div>                        
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="block nav-tabs-vertical">                   
                                    <div class="block-head">                        
                                        <div class="block-title">Your LOGS, <?php echo htmlentities($_SESSION['username']); ?></div>
                                    </div>
                                    <div class="tabs">
                                        <ul class="nav nav-tabs">
                                            <li class="active"><a href="#tab199" data-toggle="tab">Attacks Logs</a></li>
                                            <li><a href="#tab200" data-toggle="tab">Login Logs</a></li>
                                            <li><a href="#tab211" data-toggle="tab">Purchase Logs</a></li>
                                        </ul>                    
                                        <div class="block-content tab-content">
                                            <div class="tab-pane active" id="tab199">
											    <div class="table-responsive">
													<table class="table table-hover table-bordered table-striped">
														<thead>
													<tr>
														<th>IP</th>
														<th>Port</th>
														<th>Time</th>
														<th>Method</th>
														<th>Date</th>
													</tr>
												</thead>
												<tbody>
												<?php
													$attackLogs = $odb->prepare("SELECT * FROM `logs` WHERE `user` = :username ORDER BY `date` DESC");
													$attackLogs->execute(array(':username' => $_SESSION['username']));
													while($getInfo = $attackLogs->fetch(PDO::FETCH_ASSOC)){
														$IP = $getInfo['ip'];
														$port = $getInfo['port'];
														$method = $getInfo['method'];
														$time = $getInfo['time'];
														$date = date("d-m-Y, h:i:s a" ,$getInfo['date']);
												?>
													<tr>
														<td><?php echo $IP; ?></td>
														<td><?php echo $port; ?></td>
														<td><?php echo $time; ?></td>
														<td><?php echo $method; ?></td>
														<td><?php echo $date; ?></td>
													</tr>
												<?php
													}
												?>
												</tbody>
													</table>
												</div>
											</div>
                                            <div class="tab-pane" id="tab200">
                                                <div class="table-responsive">
													<table class="table table-hover table-bordered table-striped">
																<thead>
															<tr>
																<th>User ID</th>
																<th>Username</th>
																<th>Logged</th>
																<th>Date</th>
															</tr>
														</thead>
														<tbody>
														<?php
															$loginLogs = $odb->prepare("SELECT * FROM `loginip` WHERE `username` = :username ORDER BY `date` DESC");
															$loginLogs->execute(array(':username' => $_SESSION['username']));
															while($getInfo = $loginLogs->fetch(PDO::FETCH_ASSOC)){
																$userID = $getInfo['userID'];
																$username = $getInfo['username'];
																$logged = $getInfo['logged'];
																$date = date("d-m-Y, h:i:s a" ,$getInfo['date']);
														?>
															<tr>
																<td><?php echo $userID; ?></td>
																<td><?php echo $username; ?></td>
																<td><?php echo $logged; ?></td>
																<td><?php echo $date; ?></td>
															</tr>
														<?php
															}
														?>
														</tbody>
													</table>
												</div>
											</div>
                                            <div class="tab-pane" id="tab211">
                                               <div class="portlet-body">
									<div class="table-responsive">
													<table class="table table-hover table-bordered table-striped">
													<thead>
													<tr>
														<th>User ID</th>
														<th>Transaction ID</th>
														<th>Date Payed</th>
														<th>Paypal Email</th>
													</tr>
												</thead>
												<tbody>
												<?php
													$paymentLogs = $odb->prepare("SELECT * FROM `payments` WHERE `user` = :userID ORDER BY `date` DESC");
													$paymentLogs->execute(array(':userID' => $_SESSION['ID']));
													while($getInfo = $paymentLogs->fetch(PDO::FETCH_ASSOC)){
														$user = $getInfo['user'];
														$email = $getInfo['email'];
														$tid = $getInfo['tid'];
														$date = date("d-m-Y, h:i:s a" ,$getInfo['date']);
												?>
													<tr>
														<td><?php echo $user; ?></td>
														<td><?php echo $tid; ?></td>
														<td><?php echo $date; ?></td>
														<td><?php echo $email; ?></td>
													</tr>
												<?php
													}
												?>
												</tbody>
													</table>
									</div>
								</div>                        
                                        </div>
                                    </div>
                                </div>
                            </div>

</div>
 <div class="row">
                            <div class="col-md-12">
                                <div class="block">
                                    <div class="block-content">
                                        <h2><strong>Referral</strong> System</h2>
                                        <div>
								<div class="portlet-body">
									<form method="POST">
										<div class="form-group">
											<label>Your Referral Link</label>
											<input type="text" class="form-control" name="cloudflareLink" placeholder="cloudflare link" value="<?php echo $url.'index.php?referral='.strtolower($_SESSION['username']); ?>" disabled readonly/>
										</div>
										<div class="form-group">
											<label>Your Referral Count</label>
											<label>
												<?php
													$SQL = $odb->query("SELECT `referals` FROM `refers` WHERE `user` = '{$_SESSION['username']}'");
													$count =  $SQL->fetchColumn(0);
													if(empty($count)){
														echo '0';
													} else {
														echo $count;
													}
												?>
											</label>
										</div>
										<hr>
										<div class="panel-group" id="cfResolver">
											<div class="panel panel-default">
												<div class="panel-heading">
													<h4 class="panel-title">
														<a data-toggle="collapse" data-parent="#cfResolver" href="#cfResolve">
															View Your Referrals
														</a>
													</h4>
												</div>
												<div id="cfResolve" class="panel-collapse collapse">
													<div class="panel-body">
														<div class="table-responsive">
															<table class="table table-hover table-bordered table-striped">
																<thead>
																		<tr>
																		<th>Username</th>
																		<th>Active Plan?</th>
																	</tr>
																</thead>
																<tbody>
																	<?php
																		$getRefers = $odb->prepare("SELECT * FROM `referuser` WHERE `referrer` = :username");
																		$getRefers->execute(array(':username' => $_SESSION['username']));
																		while($getInfo = $getRefers->fetch(PDO::FETCH_ASSOC)){
																			$referred = $getInfo['referred'];
																	?>
																	<tr>
																		<td><?php echo $referred; ?></td>
																		<td>
																			<?php
																				$activePlan = $odb->prepare("SELECT `expire` FROM `users` WHERE `username` = :username");
																				$activePlan->execute(array(':username' => $referred));
																				$expire = $activePlan->fetchColumn(0);
																				if(time() < $expire){
																					echo 'Yes';
																				} else {
																					echo 'No';
																				}
																			?>
																		</td>
																	</tr>
																	<?php } ?>
																</tbody>
															</table>
														</div>
													</div>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
</div>
</div>
</div>
</div>
</div>
</body>
</html>