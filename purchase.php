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
        <title>StrikeREAD - Purchase</title>    

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
<div class="page-toolbar-title">Purchase</div>
<div class="page-toolbar-subtitle">Purchase membership</div>
</div>
<ul class="breadcrumb">
<li><a href="index.php">STRIKEREAD</a></li>
<li class="active">Purchase</li>
</ul>
<div id="div" style="display:inline"></div>
</div>
<div class="row">
<div class="col-md-6">
<div class="block">
<div class="block-content">			
<div class="form-group">
      <?php
				$plansfunc = "<script type='text/javascript'>
						function Plan() {
						var id = document.getElementById('plan').value;";
				$SQLGetPlans = $odb -> query("SELECT * FROM `plans` ORDER BY `price` ASC");
				$plans = "<select class=\"form-control chained_group\" id='plan' onChange='Plan()'>
				<option value=\"0\">Select a Plan</option>";
				while ($getInfo = $SQLGetPlans -> fetch(PDO::FETCH_ASSOC))
                {
					$name = $getInfo['name'];
					$price = $getInfo['price'];
					$length = $getInfo['length'];
					$unit = $getInfo['unit'];
					$concurrents = $getInfo['concurrents'];
					$mbt = $getInfo['mbt'];
					$ID = $getInfo['ID'];
					 	$plansfunc .= '
						if (id == '.$ID.') {
							document.getElementById("price").innerText = "Price: $'.$price.'";
							document.getElementById("btime").innerText = "Boot Time (Seconds): '.$mbt.'";
							document.getElementById("buynow").href = "order.php?id='.$ID.'";
						}
						';
						$plans .= "<option value=".$ID.">".$name."</option>";
				}
				$plans .= "</select>";
				$plansfunc .= "}";
			 	$plansfunc .= "</script>";
				echo $plansfunc;
				echo $plans;
				?>

        
                		<br>
						<div id="price">Price: $0</div>
                        <div id="btime">Max Stress Time	: 0</div>
						<div>All Methods : YES</div>
						<div>Unlimited Attacks : YES</div>
						<div id="buynowdiv">
                        </div>
                    </div>
			
            <div class="form-actions">
				<div id="buynowdiv">
                <a id="buynow" href="#">
              <span class="btn btn-success">Purchase Now</span>
            </button>
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