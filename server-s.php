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
        <title>StrikeREAD - ServerStatus</title>    

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
<div class="page-toolbar-title">Servers Status</div>
<div class="page-toolbar-subtitle">Look Servers Status</div>
</div>
<ul class="breadcrumb">
<li><a href="index.php">STRIKEREAD</a></li>
<li class="active">Servers Status</li>
</ul>
<div id="div" style="display:inline"></div>
</div>
<div class="row">
 <div class="col-md-12">
                            <div class="block">
                                <div class="block-content np">
                                    <table class="table table-bordered table-striped">
                                        <tr>
                                            <th>Server Name</th>
                                            <th>Server Power</th>
                                            <th>Server Type</th>
                                            <th>Server Status</th>
                                        </tr>
                                        <tr>
                                            <td>ServerUSA</td>
                                            <td>10Gb</td>
                                            <td><button type="button" class="btn btn-warning">Spoofed</button></td>
                                            <td><button type="button" class="btn btn-success">Online</button></td>
                                        </tr>
                                        <tr>
                                            <td>ServerESP</td>
                                            <td>10Gb</td>
                                            <td><button type="button" class="btn btn-warning">Spoofed</button></td>
                                            <td><button type="button" class="btn btn-danger">Offline</button></td>
                                        </tr>                                                              
                                    </table>
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
</body>
</html>