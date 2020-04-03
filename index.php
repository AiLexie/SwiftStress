<?php
	ob_start();
	require_once('includes/db.php');
	require_once('includes/init.php');
	if(!($user->LoggedIn())){
		if(isset($_GET['referral'])){
			$_SESSION['referral'] = preg_replace("/[^A-Za-z0-9-]/","", $_GET['referral']);
			header('Location: register.php');
			die();
		}
		header('location: login.php');
		die();
	}
	if(!($user->notBanned($odb))){
		header('location: logout.php');
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
<title>StrikeREAD - Index</title>    

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <link href="css/styles2.css" rel="stylesheet" type="text/css" />
        <!--[if lt IE 10]><link rel="stylesheet" type="text/css" href="css/ie.css"/><![endif]-->
        
        <script type="text/javascript" src="js/plugins/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="js/plugins/jquery/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>
		<script type="text/javascript" src="js/plugins/sparkline/jquery.sparkline.min.js"></script>   
        <script type='text/javascript' src='js/plugins/knob/jquery.knob.js'></script>  
        <script type="text/javascript" src="js/plugins.js"></script>
        <script type="text/javascript" src="js/actions.js"></script>  
		<script src="https://wallet.google.com/inapp/lib/buy.js" type="text/javascript"></script>  
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
<div class="page-toolbar-title">Dashboard</div>
<div class="page-toolbar-subtitle">Exclusive responsive dashboard</div>
</div>
<div class="page-toolbar-block pull-right">
<div class="widget-info">
<div class="widget-info-title">Total Attacks</div>
<div class="widget-info-value"><?php echo $stats->totalBoots($odb); ?></div>
</div>
<div class="widget-info-chart pull-left">
<span class="sparkline" sparkType="bar" sparkBarColor="#AAD979" sparkWidth="100" sparkHeight="45" sparkBarWidth="5">
<?php echo $stats->totalBoots($odb); ?></span>
</div>
<div class="widget-info">
<div class="pull-left">
<div class="widget-info-title">My Attacks</div>
<div class="widget-info-value"><?php echo $stats->totalBootsForUser($odb, $_SESSION['username']); ?></div>
</div>
<div class="widget-info-chart pull-left">
<span class="sparkline" sparkType="bar" sparkBarColor="#AAD979" sparkWidth="100" sparkHeight="45" sparkBarWidth="5">
0,0,0,0,0,0,0,0, <?php echo $stats->totalBootsForUser($odb, $_SESSION['username']); ?></span>
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-md-4">
<div class="timeline">
<form method="post">
<!-- NOTICIA 1 -->
<div class="timeline-event"><div class="timeline-date"><div><span>04</span> Dic</div></div></div>
<div class="timeline-event">
<div class="timeline-event-icon">
<i class="fa fa-bullhorn"></i></div>
<div class="timeline-event-content">
<div class="event-title">Welcome.</div>
<p>Source Copy by StrikeREAD!</p>
<p>Ty for download!</p>
<div class="event-date"><i class="fa fa-clock-o">
</i> 16:30:34 pm by StrikeREAD</div></div>
</div>
</form>
</div>
</div>
<div class="col-md-4">
<div class="widget-window">
<div class="window window-success window-npb">
<div class="window-title">Total Attacks</div>
</div>
<div class="window window-success tac">
<span class="sparkline" sparkType="line" sparkHighlightSpotColor="#FFF" sparkSpotRadius="5" sparkMaxSpotColor="#FFFFFF" sparkMinSpotColor="#FFFFFF" sparkSpotColor="#FFFFFF" sparkLineColor="#FFFFFF" sparkHeight="100" sparkWidth="300" sparkLineWidth="3" sparkFillColor="false">
0,0,0,0,0,0,0,0,<?php echo $stats->totalBoots($odb); ?></span>
</div>
<div class="window window-dark">
<div class="window-block">
<h4>Total Attacks</h4>
<p><?php echo $stats->totalBoots($odb); ?></p>
<h4>Total Users</h4>
<p><?php echo $stats->totalUsers($odb); ?></p>
<h4>Servers Load</h4>
<p>ServerUSA [10GB] - 100%</p>
<p>ServerESP [10GB] - 50%</p>
</div>
</div>
</div>
</div>
<div class="col-md-4">
<div class="widget-window">
<div class="window window-primary window-npb">
<div class="window-title"><strong><?php echo htmlentities($_SESSION['username']); ?></strong> (<?php echo $testInfo['email']; ?>)</div>
</div>
<div class="window window-primary">
<div class="window-block">
<img src="img/user-60.png" class="img-circle img-thumbnail"/>
</div>
<div class="window-block">
<h4>Membership Name</h4>
<p><?php echo $userInfo['name']; ?></p>
<h4>Membership Expiration</h4>
<p><?php echo date('m-d-Y' ,$userInfo['expire']); ?></p>
</div>
</div>
<div class="window">
<div class="window-block window-wide">
<h4>Max Boot Time (<?php echo $userInfo['mbt']; ?> seconds)</h4>
<div class="progress progress-small">
<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="0" aria-valuemin="0" style="width: <?php echo $userInfo['mbt']; ?>%"></div>
</div>
</div>
<div class="window-block window-wide">
<h4>Your total attacks (<?php echo $stats->totalBootsForUser($odb, $_SESSION['username']); ?>)</h4>
<div class="progress progress-small">
<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="0" aria-valuemin="0" style="width: <?php echo $stats->totalBootsForUser($odb, $_SESSION['username']); ?>%"></div>
</div>
</div>
<button type="button" onclick=" location.href='http://strikeread.comuf.com/purchase.php' " class="btn btn-primary btn-block">Upgrade</button>
<br>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</body>
</html>
