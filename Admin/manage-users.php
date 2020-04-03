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
?>
<html lang="en">    <head>                <title>StrikeREAD [ADMIN] - Users</title>            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />        <meta http-equiv="X-UA-Compatible" content="IE=edge" />        <meta name="viewport" content="width=device-width, initial-scale=1" />        <link href="../css/styles.css" rel="stylesheet" type="text/css" />        <!--[if lt IE 10]><link rel="stylesheet" type="text/css" href="css/ie.css"/><![endif]-->                <script type="text/javascript" src="../js/plugins/jquery/jquery.min.js"></script>        <script type="text/javascript" src="../js/plugins/jquery/jquery-ui.min.js"></script>        <script type="text/javascript" src="../js/plugins/bootstrap/bootstrap.min.js"></script>        <script type="text/javascript" src="../js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>		<script type="text/javascript" src="../js/plugins/sparkline/jquery.sparkline.min.js"></script>           <script type='text/javascript' src='../js/plugins/knob/jquery.knob.js'></script>          <script type="text/javascript" src="../js/plugins.js"></script>        <script type="text/javascript" src="../js/actions.js"></script>              </head>    <body>                <div class="page-container">                        <?php	include("head.php");	include("sidebar.php");?><div class="page-content"><div class="container"><div class="page-toolbar"><div class="page-toolbar-block"><div class="page-toolbar-title">Users</div><div class="page-toolbar-subtitle">Manage Users</div></div><ul class="breadcrumb"><li><a href="index.php">STRIKEREAD</a></li><li><a href="admin/index.php">Admin</a></li><li class="active">Manage Users</li></ul><div id="div" style="display:inline"></div></div><div class="row"><div class="col-md-12"><div class="block"><div class="block-content"><form method="POST">
										<div class="table-responsive">
											<table class="table table-striped table-bordered table-hover table-green" id="example">
												<thead>
													<tr>
														<th>ID</th>
														<th>Username</th>
														<th>Email</th>
														<th>Rank</th>
														<th>Skype</th>
														<th>Manage</th>
													</tr>
												</thead>
												<tbody>
													<?php
														$viewUsers = $odb->query("SELECT * FROM `users` ORDER BY `ID` DESC");
														while($getInfo = $viewUsers->fetch(PDO::FETCH_ASSOC)){
															$id = $getInfo['ID'];
															$uid = $getInfo['uid'];
															$user = $getInfo['username'];
															$email = $getInfo['email'];
															$rank = ($getInfo['rank'] == 1) ? 'Admin' : 'Member';
													?>
													<tr>
														<td><?php echo $id; ?></td>
														<td><?php echo $user; ?></td>
														<td><?php echo $email; ?></td>
														<td><?php echo $rank; ?></td>
														<td><button type="submit" class="btn btn-default" onClick="window.open('skype:add<?php echo $uid; ?>');"><?php echo $uid; ?></button></td>
														<td><button type="submit" class="btn btn-default" onClick="javascript: form.action='edit-user.php?id=<?php echo $id; ?>';">Edit</button></td>
													</tr>
													<?php
														}
													?>
												</tbody>
											</table>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>				</div>				</div></body>
</html>