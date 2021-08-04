<?php include_once('../../../../private/initialize.php') ?>
<?php require_login(); ?>
<?php $page_title = "Admin Details" ?>
<?php 
	$id = $_GET['id'];
	$admin = find_admin_by_id($id);
?>
<?php include(SHARED_PATH . '/cms_header.php'); ?>
<div id="content">
	<a href="<?php echo url_for('staff/quiz_cms/admins/index.php'); ?>">Back to list</a>
	<h3>Admin Details For: <span style="color: #2c6cd3;"><?php echo $admin['first_name']." ".$admin['last_name']; ?></span></h3>

	<div class="admin show">
		<dl>
			<dt>ID:</dt>
			<dd><?php echo $admin['id']; ?></dd>
		</dl>
		
		<dl>
			<dt>First Name:</dt>
			<dd><?php echo $admin['first_name']; ?></dd>
		</dl>

		<dl>
			<dt>Last Name:</dt>
			<dd><?php echo $admin['last_name']; ?></dd>
		</dl>

		<dl>
			<dt>Username:</dt>
			<dd><?php echo $admin['username']; ?></dd>
		</dl>

		<dl>
			<dt>Email:</dt>
			<dd><?php echo $admin['email']; ?></dd>
		</dl>

	</div>
	
</div>
<?php include(SHARED_PATH . '/cms_footer.php'); ?>