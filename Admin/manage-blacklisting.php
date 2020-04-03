<?php
	$page = 'Admin Panel - Manage Blacklisting';
	$pageIcon = 'ban';
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
?><html lang="en">    <head>                <title>StrikeREAD [ADMIN] - Edit Settings</title>            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />        <meta http-equiv="X-UA-Compatible" content="IE=edge" />        <meta name="viewport" content="width=device-width, initial-scale=1" />        <link href="../css/styles.css" rel="stylesheet" type="text/css" />        <!--[if lt IE 10]><link rel="stylesheet" type="text/css" href="css/ie.css"/><![endif]-->                <script type="text/javascript" src="../js/plugins/jquery/jquery.min.js"></script>        <script type="text/javascript" src="../js/plugins/jquery/jquery-ui.min.js"></script>        <script type="text/javascript" src="../js/plugins/bootstrap/bootstrap.min.js"></script>        <script type="text/javascript" src="../js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>		<script type="text/javascript" src="../js/plugins/sparkline/jquery.sparkline.min.js"></script>           <script type='text/javascript' src='../js/plugins/knob/jquery.knob.js'></script>          <script type="text/javascript" src="../js/plugins.js"></script>        <script type="text/javascript" src="../js/actions.js"></script>              </head>    <body>                <div class="page-container">                        <?php	include("head.php");	include("sidebar.php");?><div class="page-content"><div class="container"><div class="page-toolbar"><div class="page-toolbar-block"><div class="page-toolbar-title">BlackList</div><div class="page-toolbar-subtitle">Edit BlackList</div></div><ul class="breadcrumb"><li><a href="index.php">STRIKEREAD</a></li><li><a href="admin/index.php">Admin</a></li><li class="active">Blacklist</li></ul><div id="div" style="display:inline"></div></div><div class="row"><div class="col-md-12"><div class="block"><div class="block-content"><form method="POST">
										<?php 
											if(isset($_POST['addBtn'])){
												$ipAdd = $_POST['ipAdd'];
												$noteAdd = $_POST['noteAdd'];
												$errors = array();
												if(!filter_var($ipAdd, FILTER_VALIDATE_IP)){
													$errors[] = 'IP is invalid';
												}
												if(empty($ipAdd)){
													$errors[] = 'Please verify all fields';
												}
												if(empty($errors)){
													$SQLinsert = $odb->prepare("INSERT INTO `blacklist` VALUES(NULL, :ip, :note)");
													$SQLinsert->execute(array(':ip' => $ipAdd, ':note' => $noteAdd));
													echo $design->alert('success', 'Success', 'IP Has Been Added!');
												} else {
													echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Error:</strong> <br/>';
													foreach($errors as $error){
														echo '- '.$error.'!<br/>';
													}
													echo ' </div>';
												}
											}
										?>
										<div class="form-group">
											<label>IP Address</label>
											<input type="text" class="form-control" name="ipAdd" placeholder="IP Address Here!"/>
										</div>
										<div class="form-group">
											<label>Reason</label>
											<textarea class="form-control" name="noteAdd" placeholder="Reason Here!" rows="12"></textarea>
										</div>
										<button type="submit" name="addBtn" class="btn btn-default">Add</button>
									</form>
									<!-- <div class="portlet-body"> -->
									<form method="POST">
										<?php
											if(isset($_POST['deleteBtn'])){
												if(empty($_POST['deleteCheck'])){
													echo $design->alert('danger', 'Error', 'Nothing Is Checked!');
												} else {
													$deletes = $_POST['deleteCheck'];
													foreach($deletes as $delete){
														$SQL = $odb->prepare("DELETE FROM `blacklist` WHERE `ID` = :id LIMIT 1");
														$SQL->execute(array(':id' => $delete));
													}
													echo $design->alert('success', 'Success', 'IP(s) Have Been Been Removed!');
												}
											}
										?>
										<div class="table-responsive">
											<table class="table table-striped table-bordered table-hover table-green" id="example">
												<thead>
													<tr>
														<th>Checkbox</th>
														<th>IP</th>
														<th>Note</th>
													</tr>
												</thead>
												<tbody>
													<?php
														$SQLSelect = $odb->query("SELECT * FROM `blacklist` ORDER BY `ID` DESC");
														while($show = $SQLSelect->fetch(PDO::FETCH_ASSOC)){
															$ipShow = $show['IP'];
															$noteShow = $show['note'];
															$rowID = $show['ID'];
													?>
													<tr>
														<td><input type="checkbox" name="deleteCheck[]" value="<?php echo $rowID; ?>"/></td>
														<td><?php echo $ipShow; ?></td>
														<td><?php echo htmlentities($noteShow); ?></td>
													</tr>
												<?php
													}
												?>
												</tbody>
											</table>
											<button type="submit" name="deleteBtn" class="btn btn-default">Delete</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>			</div>		</div>
</body></html>