<?php
	$page = 'Admin Panel - Manage Blacklisting';
	$pageIcon = 'ban';
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
											if(isset($_POST['addBtn'])){
												$ipAdd = $_POST['ipAdd'];
												$noteAdd = $_POST['noteAdd'];
												$errors = array();
												if(!filter_var($ipAdd, FILTER_VALIDATE_IP)){
													$errors[] = 'IP is invalid';
												}
												if(empty($ipAdd)){
													$errors[] = 'Please verify all fields';
												}
												if(empty($errors)){
													$SQLinsert = $odb->prepare("INSERT INTO `blacklist` VALUES(NULL, :ip, :note)");
													$SQLinsert->execute(array(':ip' => $ipAdd, ':note' => $noteAdd));
													echo $design->alert('success', 'Success', 'IP Has Been Added!');
												} else {
													echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Error:</strong> <br/>';
													foreach($errors as $error){
														echo '- '.$error.'!<br/>';
													}
													echo ' </div>';
												}
											}
										?>
										<div class="form-group">
											<label>IP Address</label>
											<input type="text" class="form-control" name="ipAdd" placeholder="IP Address Here!"/>
										</div>
										<div class="form-group">
											<label>Reason</label>
											<textarea class="form-control" name="noteAdd" placeholder="Reason Here!" rows="12"></textarea>
										</div>
										<button type="submit" name="addBtn" class="btn btn-default">Add</button>
									</form>
									<!-- <div class="portlet-body"> -->
									<form method="POST">
										<?php
											if(isset($_POST['deleteBtn'])){
												if(empty($_POST['deleteCheck'])){
													echo $design->alert('danger', 'Error', 'Nothing Is Checked!');
												} else {
													$deletes = $_POST['deleteCheck'];
													foreach($deletes as $delete){
														$SQL = $odb->prepare("DELETE FROM `blacklist` WHERE `ID` = :id LIMIT 1");
														$SQL->execute(array(':id' => $delete));
													}
													echo $design->alert('success', 'Success', 'IP(s) Have Been Been Removed!');
												}
											}
										?>
										<div class="table-responsive">
											<table class="table table-striped table-bordered table-hover table-green" id="example">
												<thead>
													<tr>
														<th>Checkbox</th>
														<th>IP</th>
														<th>Note</th>
													</tr>
												</thead>
												<tbody>
													<?php
														$SQLSelect = $odb->query("SELECT * FROM `blacklist` ORDER BY `ID` DESC");
														while($show = $SQLSelect->fetch(PDO::FETCH_ASSOC)){
															$ipShow = $show['IP'];
															$noteShow = $show['note'];
															$rowID = $show['ID'];
													?>
													<tr>
														<td><input type="checkbox" name="deleteCheck[]" value="<?php echo $rowID; ?>"/></td>
														<td><?php echo $ipShow; ?></td>
														<td><?php echo htmlentities($noteShow); ?></td>
													</tr>
												<?php
													}
												?>
												</tbody>
											</table>
											<button type="submit" name="deleteBtn" class="btn btn-default">Delete</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
</body>