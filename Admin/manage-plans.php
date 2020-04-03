<?php
	$page = 'Admin Panel - Manage Plans';
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
?>
				<html lang="en">
    
<head>        
        <title>StrikeREAD [ADMIN] - Plan</title>    

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
<div class="page-toolbar-subtitle">Manage Plans</div>
</div>
<ul class="breadcrumb">
<li><a href="index.php">STRIKEREAD</a></li>
<li><a href="admin/index.php">Admin</a></li>
<li class="active">Manage Plans</li>
</ul>
<div id="div" style="display:inline"></div>
</div>
<div class="row">
<div class="col-md-12">
<div class="block">
<div class="block-content">
<form method="POST">
										<?php
											if(isset($_POST['addBtn'])){
												$nameAdd = $_POST['nameAdd'];
												$descriptionAdd = $_POST['descriptionAdd'];
												$unitAdd = $_POST['unit'];
												$lengthAdd = $_POST['lengthAdd'];
												$mbtAdd = intval($_POST['mbt']);
												$priceAdd = floatval($_POST['price']);
												if(empty($priceAdd) || empty($nameAdd) || empty($descriptionAdd) || empty($unitAdd) || empty($lengthAdd) || empty($mbtAdd)){
													echo $design->alert('danger', 'Error', 'Please Fill In All The Fields!');
												} else {
													$SQLinsert = $odb->prepare("INSERT INTO `plans` VALUES(NULL, :name, :description, :mbt, :unit, :length, :price)");
													$SQLinsert->execute(array(':name' => $nameAdd, ':description' => $descriptionAdd, ':mbt' => $mbtAdd, ':unit' => $unitAdd, ':length' => $lengthAdd, ':price' => $priceAdd));
													echo $design->alert('success', 'Success', 'Plan Has Been Created!');
												}
											}
										?>
										<div class="form-group">
											<label>Plan Name</label>
											<input type="text" class="form-control" name="nameAdd" placeholder="Plan Name!"/>
										</div>
										<div class="form-group">
											<label>Plan Description</label>
											<textarea class="form-control" name="descriptionAdd" placeholder="Plan Description!" rows="12"></textarea>
										</div>
										<div class="form-group">
											<label>Max Boot Time</label>
											<input type="text" class="form-control" name="mbt" placeholder="Max Boot Time!"/>
										</div>
										<div class="form-group">
											<label>Unit</label>
											<select class="form-control" name="unit">
												<option value="Days">Days</option>
												<option value="Weeks">Weeks</option>
												<option value="Months">Months</option>
												<option value="Years">Years</option>
											</select>
										</div>
										<div class="form-group">
											<label>Plan Length</label>
											<input type="text" class="form-control" name="lengthAdd" placeholder="Plan Length!"/>
										</div>
										<div class="form-group">
											<label>Plan Price</label>
											<input type="text" class="form-control" name="price" placeholder="Plan Price!"/>
										</div>
										<button type="submit" name="addBtn" class="btn btn-default">Add</button>
									</form>
								<div class="block-content">
									<form method="POST">
										<?php
											if(isset($_POST['deleteBtn'])){
												if(empty($_POST['deleteCheck'])){
													echo $design->alert('danger', 'Error', 'Nothing Is Checked!');
												} else {
													$deletes = $_POST['deleteCheck'];
													foreach($deletes as $delete){
														$SQL = $odb->prepare("DELETE FROM `plans` WHERE `ID` = :id LIMIT 1");
														$SQL->execute(array(':id' => $delete));
													}
													echo $design->alert('success', 'Success', 'Plan(s) Have Been Removed!');
												}
											}
										?>
										<div class="table-responsive">
											<table class="table table-striped table-bordered table-hover table-green" id="example">
												<thead>
													<tr>
														<th>Checkbox</th>
														<th>Name</th>
														<th>Max Boot Time</th>
														<th>Description</th>
													</tr>
												</thead>
												<tbody>
													<?php
														$SQLSelect = $odb->query("SELECT * FROM `plans` ORDER BY `price` ASC");
														while($show = $SQLSelect->fetch(PDO::FETCH_ASSOC)){
															$planName = $show['name'];
															$noteShow = $show['description'];
															$mbtShow = $show['mbt'];
															$rowID = $show['ID'];
													?>
													<tr>
														<td><input type="checkbox" name="deleteCheck[]" value="<?php echo $rowID; ?>"/></td>
														<td><a href="edit-plan.php?id=<?php echo $rowID; ?>"><?php echo htmlentities($planName); ?></a></td>
														<td><?php echo $mbtShow; ?></td>
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
				</div>
</div>
</div>
</body>
</html>