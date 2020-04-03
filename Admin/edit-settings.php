<?php
	$page = 'Admin Panel - Edit Settings';
	$pageIcon = 'cog';
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
<html lang="en">
    
<head>        
        <title>StrikeREAD [ADMIN] - Edit Settings</title>    

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
<div class="page-toolbar-title">Settings</div>
<div class="page-toolbar-subtitle">Edit Settings</div>
</div>
<ul class="breadcrumb">
<li><a href="index.php">STRIKEREAD</a></li>
<li><a href="admin/index.php">Admin</a></li>
<li class="active">Edit Settings</li>
</ul>
<div id="div" style="display:inline"></div>
</div>
<div class="row">
<div class="col-md-12">
<div class="block">
<div class="block-content">
<form method="POST">
										<?php
											if(isset($_POST['changeBtn'])){
												$paypalemail = $_POST['emailChange'];
												$errors = array();
												if(empty($paypalemail)){
													$errors[] = 'Please verify all fields';
												}
												if(empty($errors)){
													$SQLinsert = $odb->prepare("UPDATE `gateway` SET `email` = :newemail");
													$SQLinsert->execute(array(':newemail' => $paypalemail));
													echo $design->alert('success', 'Success', 'Paypal Email Has Been Updated!');
												} else {
													echo $design->alert('danger', 'Error', 'Please Verify All The Fields!');
												}
											}
											if(isset($_POST['changesBtn'])){
												$sitename = $_POST['sitename'];
												$errors = array();
												if(empty($sitename)){
													$errors[] = 'Please verify all fields';
												}
												if(empty($errors)){
													$SQLinsert = $odb->prepare("UPDATE `sitename` SET `sitename` = :sitename");
													$SQLinsert->execute(array(':sitename' => $sitename));
													echo $design->alert('success', 'Success', 'Site Name Has Been Updated!');
												} else {
													echo $design->alert('danger', 'Error', 'Please Verify All The Fields!');
												}
											}
											if(isset($_POST['changessBtn'])){
												$skypeapi= $_POST['skypeapi'];
												$errors = array();
												if(empty($skypeapi)){
													$errors[] = 'Please verify all fields';
												}
												if(empty($errors)){
													$SQLinsert = $odb->prepare("UPDATE `skypeapi` SET `skypeapi` = :skypeapi");
													$SQLinsert->execute(array(':skypeapi' => $skypeapi));
													echo $design->alert('success', 'Success', 'Skype API Has Been Updated!');
												} else {
													echo $design->alert('danger', 'Error', 'Please Verify All The Fields!');
												}
											}
										?>
										<div class="form-group">
											<label>Site Name</label>
											<input type="text" class="form-control" name="sitename" value="<?php echo $odb->query("SELECT `sitename` FROM `sitename` LIMIT 1")->fetchColumn(0); ?>" placeholder="Site Name Here!"/>
										</div>
										<div class="form-group">
											<label>Skype API</label>
											<input type="text" class="form-control" name="skypeapi" value="<?php echo $odb->query("SELECT `skypeapi` FROM `skypeapi` LIMIT 1")->fetchColumn(0); ?>" placeholder="Skype API Here!"/>
										</div>
										<div class="form-group">
											<label>Site Paypal Email</label>
											<input type="text" class="form-control" name="emailChange" value="<?php echo $odb->query("SELECT `email` FROM `gateway` LIMIT 1")->fetchColumn(0); ?>" placeholder="Site Paypal Email Here!"/>
										</div>
										<button type="submit" name="changesBtn" class="btn btn-default">Update Site Name</button>
										<button type="submit" name="changessBtn" class="btn btn-default">Update Skype API</button>
										<button type="submit" name="changeBtn" class="btn btn-default">Update Paypal Email</button>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
				</div>
</body>
</html>