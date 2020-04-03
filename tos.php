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
        <title>Faggot</title>    

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
<div class="page-toolbar-title">TOS</div>
<div class="page-toolbar-subtitle">Terms Of Use</div>
</div>
<ul class="breadcrumb">
<li><a href="index.php">STRIKEREAD</a></li>
<li class="active">TOS</li>
</ul>
<div id="div" style="display:inline"></div>
</div>
<div class="row">
<div class="col-md-12">
<div class="block">
<div class="block-content">
<h2><strong>STRIKEREAD</strong> TOS <img id="image" src="img/ajax-loader.gif" style="display:none"/></h2>
<Br />
<center>Please thoroughly read our terms of use and acceptable use policy. By registering and using our services, you agree to these.<br /></center>
<br /><br />
<b>Refunds</b>
<br />
We do not offer refunds for any purchases of our service. This is a strict policy that <u>must be followed</u>.
If you initiate a charge back and/or dispute for your payment, your account will immediately have its subscriptions frozen and all account information (log ins, activity on our website and more) supplied to defend ourselves in the case. <br />
<br />

<b>Uptime Guarantee</b>
<br />
We do our best to hold an uptime guarantee of 99.8%.
We are not responsible for any downtime caused by server reboots, network outages or account login errors. If your account login suddenly no longer works during your subscription and your subscription expires in the meantime, we are not responsible. In the case this does happen, please get in contact with us. We will only compensate on, server-side script errors and administrative errors. Compensations usually are days added onto subscription for our service.<br /><br />

<b>Account ownership</b>
<br />
You are, under any circumstances prohibited to release your account credentials (e.g: giveaway, to a friend, selling) without exclusive consent from an authorized staff member of our service. Any and all accounts on our network determined to be violating this agreement will have their service immediately terminated.
<br /><br />
<b>VPN Service</b><br />
We are not responsible for any client-side related issues whilst using our VPN service. We supply connection information and credentials and the responsibility of the servers are managed by <b>StrikeREAD</b>.
<br /><br />


<center>
We reserve the right, at our sole discretion, to change, modify or otherwise alter your account at any time.</center>
<br />


<a id="#aup"></a>
<center><h3>Acceptable Use Policies</h3></center>
<b>Website Policy</b>
<br />
If you find an exploit, bug, or have any suggestions/feedback for our website, do not hesitate to send them to the website developer at <b>strikeread@gmail.com</b>, it is
greatly appreciated and your account will be credited for your kindness. You are not obligated to report exploits, but if you are found to be using an exploit to abuse our services your account will be terminated.<br />
<br />
<b>Stress test launching</b>
<br />
You are obligated to only launch stress tests against networks, devices and facilities you are legally abide to. We have a strict set of rules which prohibits the act of using our tool maliciously against unwilling networks. You must have explicit permission from bandwidth and device owners to launch the stress test against, otherwise you are in violation with our terms and service and federal laws. If you have any questions on what sort of permission you'd require, please submit a support ticket and we'll provide an example request form.
<br />
<br />
<b>Account Sharing</b>
<br />
<i>Please refer to <u>Account ownership</u> of our terms for more information</i><br />
We do not allow the sharing of any accounts on our network due to abuse. 
<br />
<br />
<b>Support Tickets</b>
<br />
Our support ticket system is the only place you'll find official support. Do not abuse by creating multiple tickets regarding the same topic, by doing so you risk your support ticket rights being revoked. Abuse can also be done by threatening, harrassing or demeaning our staff members. They are here to assist you and reserve the right to refuse support. We do not have a guarantee on support ticket response times. <br />
<br />
<b>Web Tools</b>
<br />
We offer various free of charge tools to our subscribers. We hold no responsibility for the actions of our subscribers with these tools, all tools are provided as is and there are no guarantees of functionality. As most of our tools are powered by third party software and integration, we do not know the effects or usage of our tools.<br />
<br>
<b>Account hijacking on our network</b><br />
We do our best to combat account hijacking on our network, and we have a zero tolerance policy for this type of behavior. Any evidence of any clients of our service attempting, or successfully hijacking another client's account immediately loses all privacy guarantees and will result in immediate termination.
<br /><br />
<b>Automated macros on our network</b><br />
We do not allow the use of automated macros on our website. This degrades the quality of service for our other users, and if you are found in use of a macro, your services will be terminated. This means macros used in a form of spamming any of our pages with data, will result in your account being frozen.

<br><br>
<a id="#pp"></a>
<center><h3>Privacy Policy</h3></center>
<b>What information do we collect?</b><br />
We record information when you register for your account on our website, we record your provided username, e-mail address and your IP address. 
We log all log-in activity for our accounts which include a timestamp and an IP address.<br />
All website activity is logged which includes IP address, username doing the action and all submitted data in POST/GET forms.
<br /><br />
<b>What payment information do we collect?</b>
<br />
When you purchase a subscription through PayPal, our system records the following:
<br />
<ul>
<li>Full name of PayPal account holder</li>
<li>Transaction ID of payment</li>
<li>PayPal e-mail address</li>
<li>Date of transaction</li>
</ul>
<br />
When you purchase a subscription through our credit card processor, our system records the following:<br />
<ul>
<li>Full name of card holder</li>
<li>Payment/Transaction number</li>
<li>E-mail address of buyer</li>
<li>Date of transaction</li>
</ul>
<b>Do we disclose any information?</b>
<br />
We do not sell or trade any of your information to any outside third parties. All your information is confidential and will not be released to any outside parties.
<br /><br />
<i>Key Map</i><br />
<b>frozen -</b> Refers to the temporary revoke of all services on our network for a specified amount of time.
<br /><br />
Thank you for taking the time to read our terms of use and acceptable use policies.
<br />

</div>
</div>
</div>
</div>
</div>
</div>
</div>
</body>
</html>