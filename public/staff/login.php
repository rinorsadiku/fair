<?php 
require_once('../../private/initialize.php');

$errors = [];
$username = '';
$password = '';

if (is_post_request()) {
	$username  = $_POST['username'] ?? "";
	$password = $_POST['password'] ?? "";

	// validations
	if (is_blank($username)) {
		$errors[] = "Username cannot be blank";
	}
	if (is_blank($password)) {
		$errors[] = "Password cannot be blank";
	}

	if (empty($errors)) {

		$admin = find_admin_by_username($username);
		if ($admin) {
			// Do Nothing... Just move into the password validation
			if (password_verify($password, $admin['hashed_password'])) {
				log_in_admin($admin);
				redirect_to(url_for('staff/quiz_cms/index.php'));
			} else {
				// The password doesnt match the username
				$errors[] = "Your password doesn't match the username"; 
			}

		} else {
			$errors[] = "The username given doesn't exist";
		} 
	}
}

?>
<?php $page_title = "Log In"; ?>
<?php include_once(SHARED_PATH . "/cms_header.php") ?>
<div id="content">
	<h1>Log In</h1>
	<?php echo display_errors($errors); ?>
	<form action="login.php" method="POST">
		Usename: <br>
		<input type="text" name="username" value="<?php echo h($username); ?>">
		<br>
		Password: <br>
		<input type="password" name="password" value="<?php echo h($password); ?>">
		<br>
		<button type="submit" name="submit">Submit</button>
	</form>
</div>

<?php include_once(SHARED_PATH . "/cms_footer.php") ?>