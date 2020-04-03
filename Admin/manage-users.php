<?php
	$page = 'Admin Panel - Manage Users';
	$pageIcon = 'group';
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
										<div class="table-responsive">
											<table class="table table-striped table-bordered table-hover table-green" id="example">
												<thead>
													<tr>
														<th>ID</th>
														<th>Username</th>
														<th>Email</th>
														<th>Rank</th>
														<th>Skype</th>
														<th>Manage</th>
													</tr>
												</thead>
												<tbody>
													<?php
														$viewUsers = $odb->query("SELECT * FROM `users` ORDER BY `ID` DESC");
														while($getInfo = $viewUsers->fetch(PDO::FETCH_ASSOC)){
															$id = $getInfo['ID'];
															$uid = $getInfo['uid'];
															$user = $getInfo['username'];
															$email = $getInfo['email'];
															$rank = ($getInfo['rank'] == 1) ? 'Admin' : 'Member';
													?>
													<tr>
														<td><?php echo $id; ?></td>
														<td><?php echo $user; ?></td>
														<td><?php echo $email; ?></td>
														<td><?php echo $rank; ?></td>
														<td><button type="submit" class="btn btn-default" onClick="window.open('skype:add<?php echo $uid; ?>');"><?php echo $uid; ?></button></td>
														<td><button type="submit" class="btn btn-default" onClick="javascript: form.action='edit-user.php?id=<?php echo $id; ?>';">Edit</button></td>
													</tr>
													<?php
														}
													?>
												</tbody>
											</table>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
</html>