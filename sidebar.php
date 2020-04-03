<div class="page-navigation">
<div class="page-navigation-info">
<h1 class="Estilo1">StrikeREAD</h1>
</div>
<div class="profile">
<img src="img/user.png"/>
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
<li role="presentation" class="dropdown-header">Profile Menu</li>
<li><a href="profile.php">Profile</a></li>
<li><a href="support.php">Support</a></li>
<li class="divider"></li>
<li><a href="logout.php">Logout</a></li>
</ul>
</div>
</div>
</div>
</div>
<ul class="navigation">
<li class="active"><a href="index.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
<li><a href="hub.php"><i class="fa fa-power-off"></i> Hub</a>
<li><a href="tools.php"><i class="fa fa-gears"></i> Tools</a>
<li><a href="server-s.php"><i class="fa fa-desktop"></i> Server Status</a>
<li><a href="tos.php"><i class="fa fa-warning"></i> TOS</a>
<li><a href="support.php"><i class="fa fa-envelope"></i> Support</a>
<li><a href="purchase.php"><i class="fa fa-credit-card"></i> Purchase</a>
	<?php
		if ($user -> isAdmin($odb))
		{
		
		?>
		<li class="ui"><a title=""><i class="fa fa-users"></i> Admin</a>
		    <ul class="sub">
				<li><a href="admin/manage-servers.php" title="">Servers</a></li>
				<li><a href="admin/manage-blacklisting.php" title="">Blacklist</a></li>
                <li><a href="admin/manage-users.php" title="">Manage Users</a></li>
                <li><a href="admin/manage-plans.php" title="">Plans</a></li>
				<li><a href="admin/edit-settings.php" title="">Settings</a></li>
                <li class="last"><a href="admin/view-attack-logs.php" title="">View Attacks Logs</a></li>
				<li class="last"><a href="admin/view-login-logs.php" title="">View Login Logs</a></li>
				<li class="last"><a href="admin/view-payment-logs.php" title="">View Pauments Logs</a></li>
            </ul>
		</li>
		<?php
		}
		?>
		</ul>
</div>