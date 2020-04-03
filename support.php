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
        <title>StrikeREAD - Support</title>    

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
<div class="page-toolbar-title">Support</div>
<div class="page-toolbar-subtitle">You need help?</div>
</div>
<ul class="breadcrumb">
<li><a href="index.php">STRIKEREAD</a></li>
<li class="active">Support</li>
</ul>
<div id="div" style="display:inline"></div>
</div>
<div class="row">
<div class="col-md-4">
                            
                            <div class="widget-window">
                                <div class="window window-dark window-npb">
                                    <div class="window-title"><strong>StrikeREAD</strong></div> 
                                </div>
                                <div class="window window-dark">
                                    <div class="window-block">
                                        <img src="img/user-60.png" class="img-circle img-thumbnail"/>
                                    </div>
                                    <div class="window-block">
                                        <h4>Owner</h4>
										<p>Skype: alediezpd</p>
                                        <h4>WebMaster & Coder</h4>
										<h4>Contact</h4>
										<p>Gmail: strikeread@gmail.com</p>																				
										</div>
                                    </div>
                                </div>                              
                            </div>
                        <div class="col-md-4">                            
                            <div class="block">
                                <div class="block-content">
                                    <h2><strong>Theme </strong> Info</h2>
                                    <ul class="list-group">
                                        <li class="list-group-item">Theme Created by : JohnDoe & Aqvatarius</li>
                                        <li class="list-group-item">Theme Link : http://aqvatarius.com/themes/gemini_v1_4/html/</li>
                                        <li class="list-group-item">Theme Transferred to php : StrikeREAD</li>
                                        <li class="list-group-item">Theme Edits to php : StrikeREAD</li>
                                        <li class="list-group-item">Theme Transferred to booter : StrikeREAD</li>
                                    </ul>
                                    
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
</body>
</html>