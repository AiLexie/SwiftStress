<?php
	$page = 'Admin Panel - View Payment Logs';
	$pageIcon = 'money';
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
				<html lang="en">
										<?php
											if(isset($_POST['clearPayment'])){
												$SQL = $odb->prepare("TRUNCATE TABLE `payments`");
												$SQL->execute();
												echo $design->alert('success', 'Success', 'You successfully cleared all payment logs!');
											}
										?>
										<div class="table-responsive">
											<table class="table table-striped table-bordered table-hover table-green" id="example">
												<thead>
													<tr>
														<th>User</th>
														<th>Plan</th>
														<th>Email</th>
														<th>Transaction ID</th>
														<th>Amount</th>
														<th>Date</th>
													</tr>
												</thead>
												<tbody>
												<?php
													$viewPayments = $odb->query("SELECT `payments`.* , `plans`.`name` AS `planname`, `users`.`username` FROM `payments` LEFT JOIN `plans` ON `payments`.`plan` = `plans`.`ID` LEFT JOIN `users` ON `payments`.`user` = `users`.`ID` ORDER BY `ID` DESC");
													while($getInfo = $viewPayments->fetch(PDO::FETCH_ASSOC)){
														$user = $getInfo['username'];
														$plan = $getInfo['planname'];
														$email = $getInfo['email'];
														$tid = $getInfo['tid'];
														$amount = $getInfo['paid'];
														$date = date("m-d-Y, h:i:s a" ,$getInfo['date']);
												?>
													<tr>
														<td><?php echo $user; ?></td>
														<td><?php echo $plan; ?></td>
														<td><?php echo $email; ?></td>
														<td><?php echo $tid; ?></td>
														<td><?php echo $amount; ?></td>
														<td><?php echo $date; ?></td>
													</tr>
												<?php
													}
												?>
												</tbody>
											</table>
											<button type="submit" name="clearLogin" class="btn btn-default">Clear Payment Logs</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
</div>