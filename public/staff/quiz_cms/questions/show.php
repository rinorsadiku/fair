<?php include_once('../../../../private/initialize.php') ?>
<?php require_login(); ?>
<?php $page_title = "Question Details" ?>
<?php 
	$id = $_GET['id'];
	$question  = find_question_by_id($id);
?>
<?php include(SHARED_PATH . '/cms_header.php'); ?>
<div id="content">
	<a href="<?php echo url_for('staff/quiz_cms/questions/index.php?set_num='.$question['set_num']); ?>">Back to list</a>
	<h3>Question Details: <span style="font-weight: 50;"><?php echo $question['question']; ?></span></h3>

	<div class="question show">
		<dl>
			<dt>ID:</dt>
			<dd><?php echo $question['id']; ?></dd>
		</dl>
			
		<dl>
			<dt>Question:</dt>
			<dd><?php echo $question['question']; ?></dd>
		</dl>

		<dl>
			<dt>Visible:</dt>
			<dd><?php echo $question['visible'] == 1 ? 'true' : 'false'; ?></dd>
		</dl>

	</div>
	<br>
	<hr>

	<h3>Answers</h3>
	<a class="space" href="<?php echo url_for('staff/quiz_cms/answers/new.php?q_id='.h(u($id))); ?>">Add Answer</a>
	<br>
	<?php $result = find_question_answers_by_q_id($id); ?>
	<table class="list">
		<tr>
			<th>ID</th>
			<th>Question ID</th>
			<th>Answer</th>
			<th>Correct</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
		</tr>

		<?php while($answer = mysqli_fetch_assoc($result)) { ?>
		<tr>
			<td><?php  echo $answer['id']; ?></td>
			<td><?php  echo $answer['q_id']; ?></td>
			<td><?php  echo $answer['answer']; ?></td>
			<td class="center"><?php  echo $answer['correct'] == 1 ? '&#10004' : '&#10006'; ?></td>
			<td><a href="<?php echo url_for('/staff/quiz_cms/answers/edit.php?id='.h(u($answer['id']))); ?>">Edit</a></td>
			<td><a href="<?php echo url_for('/staff/quiz_cms/answers/delete.php?id='.h(u($answer['id']))); ?>">Delete</a></td>
			<td><a href="<?php echo url_for('/staff/quiz_cms/answers/show.php?id='.h(u($answer['id']))); ?>">View</a></td>
		</tr>
		<?php  } ?>
	</table>
</div>
<?php include(SHARED_PATH . '/cms_footer.php'); ?>