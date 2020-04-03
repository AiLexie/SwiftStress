<?php
	$page = 'Admin Panel - View Attack Logs';
	$pageIcon = 'sort-amount-desc';
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
?>				<html lang="en">    <head>                <title>StrikeREAD [ADMIN] - Plan</title>            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />        <meta http-equiv="X-UA-Compatible" content="IE=edge" />        <meta name="viewport" content="width=device-width, initial-scale=1" />        <link href="../css/styles.css" rel="stylesheet" type="text/css" />        <!--[if lt IE 10]><link rel="stylesheet" type="text/css" href="css/ie.css"/><![endif]-->                <script type="text/javascript" src="../js/plugins/jquery/jquery.min.js"></script>        <script type="text/javascript" src="../js/plugins/jquery/jquery-ui.min.js"></script>        <script type="text/javascript" src="../js/plugins/bootstrap/bootstrap.min.js"></script>        <script type="text/javascript" src="../js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>		<script type="text/javascript" src="../js/plugins/sparkline/jquery.sparkline.min.js"></script>           <script type='text/javascript' src='../js/plugins/knob/jquery.knob.js'></script>          <script type="text/javascript" src="../js/plugins.js"></script>        <script type="text/javascript" src="../js/actions.js"></script>              </head>    <body>                <div class="page-container">                        <?php	include("head.php");	include("sidebar.php");?><div class="page-content"><div class="container"><div class="page-toolbar"><div class="page-toolbar-block"><div class="page-toolbar-title">Attacks Logs</div><div class="page-toolbar-subtitle">View Attacks Logs</div></div><ul class="breadcrumb"><li><a href="index.php">STRIKEREAD</a></li><li><a href="admin/index.php">Admin</a></li><li class="active">View Attacks Logs</li></ul><div id="div" style="display:inline"></div></div><div class="row"><div class="col-md-12"><div class="block"><div class="block-content"><form method="POST">
										<?php
											if(isset($_POST['clearAttack'])){
												$SQL = $odb->prepare("TRUNCATE TABLE `logs`");
												$SQL->execute();
												echo $design->alert('success', 'Success', 'You successfully cleared all attack logs!');
											}
										?>
										<div class="table-responsive">
											<table class="table table-striped table-bordered table-hover table-green" id="example">
												<thead>
													<tr>
														<th>User</th>
														<th>IP</th>
														<th>Port</th>
														<th>Time</th>
														<th>Method</th>
														<th>Date</th>
													</tr>
												</thead>
												<tbody>
												<?php
													$attackLogs = $odb->query("SELECT * FROM `logs` ORDER BY `date` DESC");
													while($getInfo = $attackLogs->fetch(PDO::FETCH_ASSOC)){
														$user = $getInfo['user'];
														$IP = $getInfo['ip'];
														$port = $getInfo['port'];
														$method = $getInfo['method'];
														$time = $getInfo['time'];
														$date = date("m-d-Y, h:i:s a" ,$getInfo['date']);
												?>
													<tr>
														<td><?php echo $user; ?></td>
														<td><?php echo $IP; ?></td>
														<td><?php echo $port; ?></td>
														<td><?php echo $method; ?></td>
														<td><?php echo $time; ?></td>
														<td><?php echo $date; ?></td>
													</tr>
												<?php
													}
												?>
												</tbody>
											</table>
											<button type="submit" name="clearAttack" class="btn btn-default">Clear Attack Logs</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
</div></div></body></html>