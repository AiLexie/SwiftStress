<?php
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
											if(isset($_POST['clearLogin'])){
											$SQL = $odb->prepare("TRUNCATE TABLE `loginip`");
											$SQL->execute();
											echo $design->alert('success', 'Success', 'You successfully cleared all login logs!');
										}
										?>
										<div class="table-responsive">
											<table class="table table-striped table-bordered table-hover table-green" id="example">
												<thead>
													<tr>
														<th>User ID</th>
														<th>Username</th>
														<th>Logged</th>
														<th>Date</th>
													</tr>
												</thead>
												<tbody>
												<?php
													$viewLogin = $odb->query("SELECT * FROM `loginip` ORDER BY `date` DESC");
													while($getInfo = $viewLogin->fetch(PDO::FETCH_ASSOC)){
														$userID = $getInfo['userID'];
														$username = $getInfo['username'];
														$logged = $getInfo['logged'];
														$date = date("m-d-Y, h:i:s a" ,$getInfo['date']);
												?>
													<tr>
														<td><?php echo $userID; ?></td>
														<td><?php echo $username; ?></td>
														<td><?php echo $logged; ?></td>
														<td><?php echo $date; ?></td>
													</tr>
												<?php
													}
												?>
												</tbody>
											</table>
											<button type="submit" name="clearLogin" class="btn btn-default">Clear Login Logs</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
</div>