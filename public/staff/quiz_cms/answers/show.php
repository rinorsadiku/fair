<?php include_once('../../../../private/initialize.php') ?>
<?php require_login(); ?>
<?php $page_title = "Answers Details" ?>
<?php 
	$id = $_GET['id'];
	$answer = find_answer_by_id($id);
	$question  = find_question_by_id($answer['q_id']);
?>
<?php include(SHARED_PATH . '/cms_header.php'); ?>
<div id="content">
	<a href="<?php echo url_for('staff/quiz_cms/questions/show.php?id='.$answer['q_id']); ?>">Back to list</a>
	<h3>Submitted Answer For: <span style="color: red;"><?php echo $question['question']; ?></span></h3>

	<div class="answer show">
		<dl>
			<dt>ID:</dt>
			<dd><?php echo $answer['id']; ?></dd>
		</dl>
		
		<dl>
			<dt>Question ID:</dt>
			<dd><?php echo $answer['q_id']; ?></dd>
		</dl>

		<dl>
			<dt>Answer:</dt>
			<dd><?php echo $answer['answer']; ?></dd>
		</dl>

		<dl>
			<dt>Correct:</dt>
			<dd><?php echo $answer['correct'] == 1 ? 'Yes' : 'No'; ?></dd>
		</dl>

	</div>
	
</div>
<?php include(SHARED_PATH . '/cms_footer.php'); ?>