<?php include_once('../../../../private/initialize.php') ?>
<?php require_login(); ?>
<?php $page_title = "Quiz Admins" ?>
<?php  
	$result = find_all_admins();
?>
<?php include(SHARED_PATH . '/cms_header.php'); ?>
<div id="content">
	<a href="<?php echo url_for('staff/quiz_cms/index.php'); ?>">Back to list</a>
	<h3>Admins</h3>
	<a class="space" href="<?php echo url_for('staff/quiz_cms/admins/new.php'); ?>">Add Admin</a>
	<br>
	<table class="list">
		<tr>
			<th>ID</th>
			<th>Name</th>
			<th>Lastname</th>
			<th>Username</th>
			<th>Email</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
		</tr>

		<?php while($admin = mysqli_fetch_assoc($result)) { ?>
		<tr>
			<td><?php  echo $admin['id']; ?></td>
			<td><?php  echo $admin['first_name']; ?></td>
			<td><?php  echo $admin['last_name']; ?></td>
			<td><?php  echo $admin['username']; ?></td>
			<td><?php  echo $admin['email']; ?></td>
			<td><a href="<?php echo url_for('/staff/quiz_cms/admins/edit.php?id='.h(u($admin['id']))); ?>">Edit</a></td>
			<td><a href="<?php echo url_for('/staff/quiz_cms/admins/delete.php?id='.h(u($admin['id']))); ?>">Delete</a></td>
			<td><a href="<?php echo url_for('/staff/quiz_cms/admins/show.php?id='.h(u($admin['id']))); ?>">View</a></td>
		</tr>
		<?php  } ?>
	</table>
</div>
<?php include(SHARED_PATH . '/cms_footer.php'); ?>
<?php mysqli_free_result($result); ?>