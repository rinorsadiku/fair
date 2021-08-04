<?php include_once('../../../../private/initialize.php') ?>
<?php require_login(); ?>
<?php $page_title = "Delete Question"; ?>
<?php  
$id = $_GET['id'];
$question = find_question_by_id($id);
if (is_post_request()) {
	$result = delete_question($id);
	$_SESSION['status_message'] = "Question has been succesfully deleted";
	redirect_to(url_for('staff/quiz_cms/questions/index.php?set_num='.$question['set_num']));
}
?>
<?php include(SHARED_PATH . '/cms_header.php'); ?>
<div id="content">
	<a href="<?php echo url_for('staff/quiz_cms/questions/index.php?set_num='.$question['set_num']); ?>">Back to list</a>
	<div class="page delete">
		<h3>Are you sure you want to delete this question?</h3>
		<h2 style="color: red"><?php echo $question['question']; ?></h2>

		<form method="POST" action="<?php echo url_for('staff/quiz_cms/questions/delete.php?id='.h(u($id))); ?>">
			<input type="submit" name="commit" value="Delete Question">
		</form>
	</div>
</div>
<?php include(SHARED_PATH . '/cms_footer.php'); ?>