<?php
	$page = 'Admin Panel - View Attack Logs';
	$pageIcon = 'sort-amount-desc';
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
										<?php
											if(isset($_POST['clearAttack'])){
												$SQL = $odb->prepare("TRUNCATE TABLE `logs`");
												$SQL->execute();
												echo $design->alert('success', 'Success', 'You successfully cleared all attack logs!');
											}
										?>
										<div class="table-responsive">
											<table class="table table-striped table-bordered table-hover table-green" id="example">
												<thead>
													<tr>
														<th>User</th>
														<th>IP</th>
														<th>Port</th>
														<th>Time</th>
														<th>Method</th>
														<th>Date</th>
													</tr>
												</thead>
												<tbody>
												<?php
													$attackLogs = $odb->query("SELECT * FROM `logs` ORDER BY `date` DESC");
													while($getInfo = $attackLogs->fetch(PDO::FETCH_ASSOC)){
														$user = $getInfo['user'];
														$IP = $getInfo['ip'];
														$port = $getInfo['port'];
														$method = $getInfo['method'];
														$time = $getInfo['time'];
														$date = date("m-d-Y, h:i:s a" ,$getInfo['date']);
												?>
													<tr>
														<td><?php echo $user; ?></td>
														<td><?php echo $IP; ?></td>
														<td><?php echo $port; ?></td>
														<td><?php echo $method; ?></td>
														<td><?php echo $time; ?></td>
														<td><?php echo $date; ?></td>
													</tr>
												<?php
													}
												?>
												</tbody>
											</table>
											<button type="submit" name="clearAttack" class="btn btn-default">Clear Attack Logs</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
</div>