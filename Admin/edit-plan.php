<?php
	$page = 'Admin Panel - Manage Plan';
	$pageIcon = 'asterisk';
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
	$SQLGetInfo = $odb -> prepare("SELECT * FROM `plans` WHERE `ID` = :id LIMIT 1");
	$SQLGetInfo -> execute(array(':id' => $_GET['id']));
	$planInfo = $SQLGetInfo -> fetch(PDO::FETCH_ASSOC);
	$currentName = $planInfo['name'];
	$currentDescription = $planInfo['description'];
	$currentMbt = $planInfo['mbt'];
	$currentUnit = $planInfo['unit'];
	$currentPrice = $planInfo['price'];
	$currentLength = $planInfo['length'];
	function selectedUnit($check, $currentUnit){
		if($currentUnit == $check){
			return 'selected="selected"';
		}
	}
?>
				<html lang="en">
    
<head>        
        <title>StrikeREAD [ADMIN] - Plan Edit</title>    

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
<div class="page-toolbar-title">Plans</div>
<div class="page-toolbar-subtitle">Edit Plan</div>
</div>
<ul class="breadcrumb">
<li><a href="index.php">STRIKEREAD</a></li>
<li><a href="admin/index.php">Admin</a></li>
<li class="active">Edit Plan</li>
</ul>
<div id="div" style="display:inline"></div>
</div>
<div class="row">
<div class="col-md-12">
<div class="block">
<div class="block-content">
<form method="POST">
										<?php
											if(isset($_POST['updateBtn'])){
												$updateName = $_POST['nameAdd'];
												$updateDescription = $_POST['descriptionAdd'];
												$updateUnit = $_POST['unit'];
												$updateLength = $_POST['lengthAdd'];
												$updateMbt = intval($_POST['mbt']);
												$updatePrice = floatval($_POST['price']);
												$errors = array();
												if(empty($updatePrice) || empty($updateName) || empty($updateDescription) || empty($updateUnit) || empty($updateLength) || empty($updateMbt)){
													$errors[] = 'Fill in all fields';
												}
												if(empty($errors)){
													$SQLinsert = $odb -> prepare("UPDATE `plans` SET `name` = :name, `description` = :description, `mbt` = :mbt, `unit` = :unit, `length` = :length, `price` = :price WHERE `ID` = :id");
													$SQLinsert -> execute(array(':name' => $updateName, ':description' => $updateDescription, ':mbt' => $updateMbt, ':unit' => $updateUnit, ':length' => $updateLength, ':price' => $updatePrice, ':id' => $_GET['id']));
													echo '<section class="g_1"><div class="dialog-big success"><h3> SUCCESS: </h3><span>x</span><div> Plan Has Been Updated! </div></div>';
													$currentName = $updateName;
													$currentDescription = $updateDescription;
													$currentUnit = $updateUnit;
													$currentMbt = $updateMbt;
													$currentPrice = $updatePrice;
													$currentLength = $updateLength;
												} else {
													echo '<section class="g_1"><div class="dialog-big error"><h3> ERROR: </h3><span>x</span><div> ';
													foreach($errors as $error){
														echo '- '.$error.'<br />';
													}
													echo ' </div></div>';
												}
											}
										?>
										<div class="form-group">
											<label>Name</label>
											<input type="text" class="form-control" name="nameAdd" placeholder="Name" value="<?php echo htmlentities($currentName); ?>"/>
										</div>
										<div class="form-group">
											<label>Description</label>
											<textarea class="form-control" name="descriptionAdd" placeholder="Description" rows="12"><?php echo htmlentities($currentDescription); ?></textarea>
										</div>
										<div class="form-group">
											<label>Max Boot Time</label>
											<input type="text" class="form-control" name="mbt" placeholder="Max Boot Time" value="<?php echo htmlentities($currentMbt); ?>"/>
										</div>
										<div class="form-group">
											<label>Unit</label>
											<select class="form-control" name="unit">
												<option value="Days" <?php echo selectedUnit('Days',$currentUnit); ?> >Days</option>
												<option value="Weeks" <?php echo selectedUnit('Weeks', $currentUnit); ?> >Weeks</option>
												<option value="Months" <?php echo selectedUnit('Months', $currentUnit); ?> >Months</option>
												<option value="Years" <?php echo selectedUnit('Years', $currentUnit); ?> >Years</option>
											</select>
										</div>
										<div class="form-group">
											<label>Length</label>
											<input type="text" class="form-control" name="lengthAdd" placeholder="Length" value="<?php echo htmlentities($currentLength); ?>"/>
										</div>
										<div class="form-group">
											<label>Price</label>
											<input type="text" class="form-control" name="price" placeholder="Price" value="<?php echo htmlentities($currentPrice);?>"/>
										</div>
										<button type="submit" name="updateBtn" class="btn btn-default">Update</button>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
				</div>
				</div>
				
</body>
</html>