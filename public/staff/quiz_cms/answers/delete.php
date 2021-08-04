<?php include_once('../../../../private/initialize.php') ?>
<?php require_login(); ?>
<?php $page_title = "Delete Answer"; ?>
<?php  
$id = $_GET['id'];
if (is_post_request()) {
	$result = delete_answer($id);
	$_SESSION['status_message'] = "Answer has been succesfully deleted";
	redirect_to(url_for('staff/quiz_cms/answers/index.php'));
} else {
	$answer = find_answer_by_id($id);
	$question = find_question_by_id($answer['q_id']);
}
?>
<?php include(SHARED_PATH . '/cms_header.php'); ?>
<div id="content">
	<a href="<?php echo url_for('staff/quiz_cms/questions/show.php?id='.h(u($id))); ?>">Back to list</a>
	<div class="page delete">
		<h3>Are you sure you want to delete this answer associated to <span style="font-style: italic; color:red;"><?php echo $question['question']; ?></span></h3>
		<h2 style="color: red"><?php echo $answer['answer']; ?></h2>

		<form method="POST" action="<?php echo url_for('staff/quiz_cms/answers/delete.php?id='.h(u($id))); ?>">
			<input type="submit" name="commit" value="Delete Answer">
		</form>
	</div>
</div>
<?php include(SHARED_PATH . '/cms_footer.php'); ?>
