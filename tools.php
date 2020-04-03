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
        <title>StrikeREAD - Skype Tools</title>    

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
<div class="page-toolbar-title">Tools</div>
<div class="page-toolbar-subtitle">Skype,Domain,IP Logger, Pinger...</div>
</div>
<ul class="breadcrumb">
<li><a href="index.php">STRIKEREAD</a></li>
<li class="active">Tools</li>
</ul>
<div id="div" style="display:inline"></div>
</div>
<div class="row">
 <div class="col-md-4">
                                <div class="block-content np">
                                    <div class="panel panel-primary">
                                <div class="panel-heading"><h3 class="panel-title">Skype Resolver</h3></div>
                                <div class="panel-body">
								<form method="POST">
										<?php
											$resolved = '';
											if (isset($_POST['resolveBtn']))
											{
												$name = $_POST['skypeName'];
												$resolved = @file_get_contents("http://yourapi.com/api.php?key=xxx&username=$name");
											}
											?>
										<div class="form-group">
											<label>Skype Username</label>
											<input type="text" class="form-control" name="skypeName" id="skypeName" placeholder="skype username" value="<?php echo $name; ?>"/>
										</div>
										<div class="form-group">
											<label>IP Address</label>
											<input type="text" class="form-control" name="skypeResolved" placeholder="idle" value="<?php echo $resolved; ?>" disabled readonly/>
										</div>
										<button type="submit" name="resolveBtn" class="btn btn-primary btn-block">Resolve Skype</button>
									</form>
									</div>
                            </div>
							 </div>
							  </div>
							 <div class="col-md-4">  
							  <div class="block-content np">
							 <div class="panel panel-success">
                                <div class="panel-heading"><h3 class="panel-title">IP To Skype</h3></div>
                                <div class="panel-body"><form method="POST">
										<?php
												$user = '';
												if (isset($_POST['ipBtn']))
												{
													$ip = $_POST['ipName'];
													$user = @file_get_contents("http://yourapi.com/api.php?key=xxx&ip=$ip");
												}
												?>
										<div class="form-group">
											<label>IP Address</label>
											<input type="text" class="form-control" name="ipName" id="ipName" placeholder="skype username" value="<?php echo $ip; ?>"/>
										</div>
										<div class="form-group">
											<label>Username</label>
											<input type="text" class="form-control" name="skypeResolved" placeholder="idle" value="<?php echo $user; ?>" disabled readonly/>
										</div>
										<button type="submit" name="ipBtn" class="btn btn-success btn-block">Resolve IP</button>
									</form>
									</div>                                
                            </div>
							</div>
							</div>
							
							<div class="col-md-4">  
							  <div class="block-content np">
                            <div class="panel panel-info">
                                <div class="panel-heading"><h3 class="panel-title">DB Lookup</h3></div>
                                <div class="panel-body">
								<form method="POST">
										<?php
											$look = '';
											if (isset($_POST['searchBtn']))
											{
												$userr = $_POST['skypeUser'];
												$look = @file_get_contents("http://yourapi.com/api.php?key=xxx&username=$userr");
											}
											?>
										<div class="form-group">
											<label>Skype Username</label>
											<input type="text" class="form-control" name="skypeUser" id="skypeUser" placeholder="skype username" value="<?php echo $userr; ?>"/>
										</div>
										<div class="form-group">
											<label>IP Search</label>
											<input type="text" class="form-control" name="skypeResolved" placeholder="idle" value="<?php echo $look; ?>" disabled readonly/>
										</div>
										<button type="submit" name="searchBtn" class="btn btn-info btn-block">Search Username</button>
									</form>
									</div>                                
                            </div>
							</div>
							</div>
							
							<div class="col-md-4">  
							  <div class="block-content np">
                            <div class="panel panel-warning">
                                <div class="panel-heading"><h3 class="panel-title">Domain Resolver</h3></div>
                                <div class="panel-body">
								<form method="POST">
										<?php
											$dr = '';
											if (isset($_POST['drBtn']))
											{
											$domain = $_POST['domain'];
											$dr = gethostbyname($domain);
											}
											?>
										<div class="form-group">
											<label>Domain</label>
											<input type="text" class="form-control" name="domain" id="domain" placeholder="www.google.es" value="<?php echo $domain; ?>"/>
										</div>
										<div class="form-group">
											<label>IP</label>
											<input type="text" class="form-control" name="dr" placeholder="idle" value="<?php echo $dr; ?>" disabled readonly/>
										</div>
										<button type="submit" name="drBtn" class="btn btn-warning btn-block">Resolve Domain</button>
									</form>
									</div>                                
                            </div>
							</div>
							</div>
							<div class="col-md-4">  
							  <div class="block-content np">
                            <div class="panel panel-danger">
                                <div class="panel-heading"><h3 class="panel-title">IP Logger</h3></div>
                                <div class="panel-body">
								<p>
								Your Link: <strong><input type="text" class="form-control" name="yourLink" placeholder="<?php echo $url.'funny.php?id='.$_SESSION['ID'];?>" value="<?php echo $url.'funny.php?id='.$_SESSION['ID'];?>" disabled readonly/></strong> 
								<br>
								<div class="block-content">
								<button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#modal-example-3">Logs</button>                             
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
</div>
</div>

<div class="modal fade" id="modal-example-3" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">IP Logger Logs</h4>
                    </div>
                    <div class="modal-body">
                        <div class="scroll" style="height: 200px;">
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
															$date = date("d-m-Y, h:i:s a" ,$getInfo['date']);
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
									</form>
						   </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-clean" data-dismiss="modal">Close</button>              
                    </div>
                </div>
            </div>
        </div>

</body>
</html>