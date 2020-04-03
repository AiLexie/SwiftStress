<?php

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
<!DOCTYPE html>
<html lang="en">
    
<head>        
        <title>StrikeREAD [ADMIN] - Servers</title>    

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
<div class="page-toolbar-title">Servers</div>
<div class="page-toolbar-subtitle">Manage Servers</div>
</div>
<ul class="breadcrumb">
<li><a href="index.php">STRIKEREAD</a></li>
<li><a href="admin/index.php">Admin</a></li>
<li class="active">Manage Servers</li>
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

												$x = $_POST["linkAdd"];

												$m = explode("\n",$x);

												$errors = array();

												if(empty($x)){

													echo $design->alert('danger', 'Error', 'Links Are Missing!');

												} else {

													foreach($m as $val){

														$val = rtrim($val,"\r");

														$SQLinsert = $odb->prepare("INSERT INTO `servers` VALUES(NULL, :linkAdd)");

														$SQLinsert->execute(array(':linkAdd' => $val));

													}

													echo $design->alert('success', 'Success', 'Server(s) Have Been Added!');

												}

											}

										?>

										<div class="form-group">

											<label>Server Links</label>

											<textarea class="form-control" name="linkAdd" placeholder="Server Links Here!" rows="12"></textarea>

										</div>

										<button type="submit" name="addBtn" class="btn btn-default">Add Servers</button>

									</form>

								</div>
								
								
				<div class="row">

					<div class="col-lg-12">

						<div class="portlet portlet-default">

							<div class="portlet-heading">

								<div class="portlet-title">

									<h4>Current Servers(s)</h4>

								</div>

								<div class="clearfix"></div>

							</div>

							<div>

								<div class="portlet-body">

									<form method="POST">

										<?php

											if(isset($_POST['deleteBtn'])){

												if(empty($_POST['deleteCheck'])){

													echo $design->alert('danger', 'Error', 'Nothing Is Checked!');

												} else {

													$deletes = $_POST['deleteCheck'];

													foreach($deletes as $delete){

														$SQL = $odb->prepare("DELETE FROM `servers` WHERE `id` = :id LIMIT 1");

														$SQL->execute(array(':id' => $delete));

													}

													echo $design->alert('success', 'Success', 'Server(s) Have Been Removed!');

												}

											}

										?>

										<div class="table-responsive">

											<table class="table table-striped table-bordered table-hover table-green" id="example">

												<thead>

													<tr>

														<th>Checkbox</th>

														<th>ID</th>

														<th>URL</th>

													</tr>

												</thead>

												<tbody>

													<?php

														$SQLSelect = $odb->query("SELECT * FROM `servers` ORDER BY `id`");

														while($show = $SQLSelect->fetch(PDO::FETCH_ASSOC)){

															$urlShow = $show['url'];

															$rowID = $show['id'];

													?>

													<tr>

														<td><input type="checkbox" name="deleteCheck[]" value="<?php echo $rowID; ?>"/></td>

														<td><?php echo $rowID; ?></td>

														<td><?php echo $urlShow; ?></td>

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
</div>
</body>
</html>