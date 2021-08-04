<?php include_once('../../../../private/initialize.php') ?>
<?php require_login(); ?>
<?php $page_title = "Delete Answer"; ?>
<?php  
$id = $_GET['id'];
if (is_post_request()) {
	$result = delete_admin($id);
	$_SESSION['status_message'] = "Admin has been succesfully deleted";
	redirect_to(url_for('staff/quiz_cms/admins/index.php'));
} else {
	$admin = find_admin_by_id($id);
}
?>
<?php include(SHARED_PATH . '/cms_header.php'); ?>
<div id="content">
	<a href="<?php echo url_for('staff/quiz_cms/questions/show.php?id='.h(u($id))); ?>">Back to list</a>
	<div class="admin delete">
		<h3>Are you sure you want to delete this admin <span style="font-style: italic; color:red;"><?php echo $admin['username']; ?></span></h3>

		<form method="POST" action="<?php echo url_for('staff/quiz_cms/admins/delete.php?id='.h(u($id))); ?>">
			<input type="submit" name="commit" value="Delete Admin">
		</form>
	</div>
</div>
<?php include(SHARED_PATH . '/cms_footer.php'); ?>