<?php include_once('../../../../private/initialize.php') ?>
<?php require_login(); ?>
<?php $page_title = "Edit Admin"; ?>
<?php 
$id = $_GET['id'];

if (is_post_request()) {
	$admin['id'] = $id;
 	$admin['first_name'] = $_POST['first_name'] ?? "";
	$admin['last_name'] = $_POST['last_name'] ?? "";
	$admin['username'] = $_POST['username'] ?? "";
	$admin['email'] = $_POST['email'] ?? "";
	$admin['password'] = $_POST['password'] ?? "";
	$admin['confirm_password'] = $_POST['confirm_password'] ?? "";

	$result = update_admin($admin);
	if ($result === true) {
		$_SESSION['status_message'] = "Admin has been succesfully modified";
		redirect_to(url_for('staff/quiz_cms/admins/show.php?id='.h(u($id))));
	} else {
		$errors = $result;
	}
} else {
	$admin =  find_admin_by_id($id);
}
?>
<?php include(SHARED_PATH . '/cms_header.php'); ?>
<div id="content">
	<a href="<?php echo url_for('staff/quiz_cms/admins/index.php'); ?>">Back</a>
	<h3>Add New Admin</h3>
	<div class="admin listing">
		<?php echo display_errors($errors); ?>
		<form method="POST" action="<?php echo url_for('staff/quiz_cms/admins/edit.php?id='.h(u($id))); ?>">
			<dl>
				<dt>First Name: </dt>
				<dd><input type="text" name="first_name" value="<?php echo $admin['first_name'] ?>"></dd>
			</dl>

			<dl>
				<dt>Last Name: </dt>
				<dd><input type="text" name="last_name" value="<?php echo $admin['last_name'] ?>"></dd>
			</dl>
			
			<dl>
				<dt>Username: </dt>
				<dd><input type="text" name="username" value="<?php echo $admin['username'] ?>"></dd>
			</dl>			

			<dl>
				<dt>Email: </dt>
				<dd><input type="text" name="email" value="<?php echo $admin['email'] ?>"></dd>
			</dl>

			<dl>
				<dt>Password: </dt>
				<dd><input type="password" name="password"></dd>
			</dl>

			<dl>
				<dt>Confirm Password: </dt>
				<dd><input type="password" name="confirm_password"></dd>
			</dl>

			<button type="submit" name="submit">Submit</button>

		</form>
		<p>Password must have 12 or more characters, 1 number, 1 Uppercase letter, 1 Symbol</p>
	</div>
</div>
<?php include(SHARED_PATH . '/cms_footer.php'); ?>
