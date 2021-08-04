<?php include_once('../../../../private/initialize.php') ?>
<?php require_login(); ?>
<?php $page_title = "Insert Admin"; ?>
<?php 
if (is_post_request()) {
	$admin['first_name'] = $_POST['first_name'] ?? "";
	$admin['last_name'] = $_POST['last_name'] ?? "";
	$admin['username'] = $_POST['username'] ?? "";
	$admin['email'] = $_POST['email'] ?? "";
	$admin['password'] = $_POST['password'] ?? "";
	$admin['confirm_password'] = $_POST['confirm_password'] ?? "";

	$result = insert_admin($admin);
	if ($result === true) {
		$new_id = mysqli_insert_id($db);
		$_SESSION['status_message'] = "Admin has been succesfully inserted";
		redirect_to(url_for('staff/quiz_cms/admins/show.php?id='.h(u($new_id))));
	} else {
		$errors = $result;
	}
} else {
	$admin['first_name'] = "";
	$admin['last_name'] = "";
	$admin['username'] = "";
	$admin['email'] = "";
	$admin['[password]'] = "";
	$admin['confirm_password'] = "";
}
?>
<?php include(SHARED_PATH . '/cms_header.php'); ?>
<div id="content">
	<a href="<?php echo url_for('staff/quiz_cms/admins/index.php'); ?>">Back</a>
	<h3>Add New Admin</h3>
	<div class="admin listing">
		<?php  echo display_errors($errors); ?>
		<form method="POST" action="<?php echo url_for('staff/quiz_cms/admins/new.php'); ?>">
			<dl>
				<dt>First Name: </dt>
				<dd><input type="text" name="first_name"></dd>
			</dl>

			<dl>
				<dt>Last Name: </dt>
				<dd><input type="text" name="last_name"></dd>
			</dl>
			
			<dl>
				<dt>Username: </dt>
				<dd><input type="text" name="username"></dd>
			</dl>			

			<dl>
				<dt>Email: </dt>
				<dd><input type="text" name="email"></dd>
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
