<div class="page-navigation">
<div class="page-navigation-info">
<h1 class="Estilo1">StrikeREAD</h1>
</div>
<div class="profile">
<img src="../img/user.png"/>
<div class="profile-info">
<a href="#" class="profile-title"><strong><?php echo $_SESSION['username']; ?></strong></a>
<?php
			$plansql = $odb->prepare("SELECT `users`.*,`plans`.`name`, `plans`.`mbt` FROM `users`, `plans` WHERE `plans`.`ID` = `users`.`membership` AND `users`.`ID` = :id LIMIT 1");
	$plansql->execute(array(":id" => $_SESSION['ID']));
	$userInfo = $plansql->fetch(PDO::FETCH_ASSOC);
	?>
<span class="profile-subtitle"><?php echo $userInfo['name']; ?></span>
<div class="profile-buttons">
<div class="btn-group">
<a class="but dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cog"></i></a>
<ul class="dropdown-menu" role="menu">
<li><a href="http://strikeread.comuf.com/index.php">Index</a></li>
<li><a href="http://strikeread.comuf.com/logout.php">Logout</a></li>
</ul>
</div>
</div>
</div>
</div>
<ul class="navigation">
<?php
		if ($user -> isAdmin($odb))
		{
		
		?>
		<li class="active"><a href="http://strikeread.comuf.com/index.php"><i class="fa fa-dashboard"></i> Index Normal</a></li>
		<li><a href="hub.php"><i class="fa fa-user"></i> Index Admin</a>
		<li class="ui"><a title=""><i class="fa fa-users"></i> Admin</a>
		    <ul class="sub">
				<li><a href="manage-servers.php" title="">Servers</a></li>
				<li><a href="manage-blacklisting.php" title="">Blacklist</a></li>
                <li><a href="manage-users.php" title="">Manage Users</a></li>
                <li><a href="manage-plans.php" title="">Plans</a></li>
				<li><a href="edit-settings.php" title="">Settings</a></li>
                <li class="last"><a href="view-attack-logs.php" title="">View Attacks Logs</a></li>
				<li class="last"><a href="view-login-logs.php" title="">View Login Logs</a></li>
				<li class="last"><a href="view-payment-logs.php" title="">View Pauments Logs</a></li>
            </ul>
		</li>
		<?php
		}
		?>
		</ul>
</div>