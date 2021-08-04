<?php include_once('../../../../private/initialize.php') ?>
<?php require_login(); ?>
<?php $page_title = "Quiz Questions" ?>
<?php include(SHARED_PATH . '/cms_header.php'); ?>
<div id="content">
	<h3>Questions</h3>
	<?php if (isset($_GET['set_num']) && $_GET['set_num'] !== "") { ?>
	<a href="<?php echo url_for('staff/quiz_cms/questions/index.php'); ?>">Back to list</a>
	<br>
	<br>
	<?php  
		$set = $_GET['set_num'] ?? "";
		$result = find_questions_by_set($set);
	?>
	<a class="space" href="<?php echo url_for('staff/quiz_cms/questions/new.php?set_num='.h(u($set))); ?>">Add Question</a>
	<br>
	<table class="list">
		<tr>
			<th>ID</th>
			<th>S_ID</th>
			<th>Set</th>
			<th>Question</th>
			<th>Visible</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
		</tr>

		<?php while($question = mysqli_fetch_assoc($result)) { ?>
		<tr>
			<td><?php  echo $question['id']; ?></td>
			<td><?php  echo $question['s_id']; ?></td>
			<td><?php  echo $question['set_num']; ?></td>
			<td><?php  echo $question['question']; ?></td>
			<td><?php echo $question['visible'] == 1 ? 'true' : 'false'; ?></td>
			<td><a href="<?php echo url_for('/staff/quiz_cms/questions/edit.php?id='.h(u($question['id']))); ?>">Edit</a></td>
			<td><a href="<?php echo url_for('/staff/quiz_cms/questions/delete.php?id='.h(u($question['id']))); ?>">Delete</a></td>
			<td><a href="<?php echo url_for('/staff/quiz_cms/questions/show.php?id='.h(u($question['id']))); ?>">View</a></td>
		</tr>
		<?php  } ?>
		<?php mysqli_free_result($result); ?>
	</table>

	<?php  } else { ?>

	<ul>
		<li><a href="<?php echo url_for('staff/quiz_cms/questions/index.php?set_num=1'); ?>">SET 1</a></li>
		<li><a href="<?php echo url_for('staff/quiz_cms/questions/index.php?set_num=2'); ?>">SET 2</a></li>
		<li><a href="<?php echo url_for('staff/quiz_cms/questions/index.php?set_num=3'); ?>">SET 3</a></li>
		<li><a href="<?php echo url_for('staff/quiz_cms/questions/index.php?set_num=4'); ?>">SET 4</a></li>
		<li><a href="<?php echo url_for('staff/quiz_cms/questions/index.php?set_num=5'); ?>">SET 5</a></li>
	</ul>
	<?php } ?>
</div>
<?php include(SHARED_PATH . '/cms_footer.php'); ?>
