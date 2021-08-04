<?php include_once('../../../../private/initialize.php') ?>
<?php require_login(); ?>
<?php $page_title = "Edit Answer"; ?>
<?php  
$id = $_GET['id'];
if (is_post_request()) {
	$answer['answer'] = $_POST['answer'];
	$answer['q_id'] = $_POST['q_id'];
	$answer['correct'] = $_POST['correct'];
	$answer['id'] = $id;

	$result = update_answer($answer);
	if ($result === true) {
		$_SESSION['status_message'] = "Answer has been succesfully modified"; 
		redirect_to(url_for('staff/quiz_cms/answers/show.php?id='.h(u($id))));
	} else {
		$errors = $result;
	}
	
} 
	$answer = find_answer_by_id($id);
	$count = count_all_questions();
?>

<?php include(SHARED_PATH . '/cms_header.php'); ?>
<div id="content">
	<a href="<?php echo url_for('staff/quiz_cms/questions/show.php?id='.h(u($answer['q_id']))); ?>">Back to list</a>
	<div class="answer listing">
		<h3>Edit Answer</h3>
		<?php  echo display_errors($errors);  ?>
		<form method="POST" action="<?php echo url_for('staff/quiz_cms/answers/edit.php?id='.h(u($id))); ?>">
				<dl>
			<dt>Answer</dt>
			<dd><input type="text" name="answer" value="<?php echo $answer['answer'] ?>"></dd>
		</dl>

		<dl>
			<dt>Question ID</dt>
			<dd>
				<select name="q_id">
					<?php 
					for($i = 1; $i <= $count; $i++) {
						echo "<option value=\"{$i}\"";
						if ($answer['q_id'] == $i) {
							echo " selected";
						}
						echo " >{$i}</option>";
					}

					?>
				</select>
			</dd>
		</dl>

		<dl>
		  	<dt>Correct</dt>
		  	<dd>
		  		<input type="hidden" name="correct" value="0" />
		  		<input type="checkbox" name="correct" value="1"<?php if($answer['correct'] == "1") { echo " checked"; } ?> />
		  	</dd>
		</dl>	
		<div id="operations">
			<input type="submit" name="commit" value="Edit Answer">
		</div>

		</form>
	</div>
</div>

<?php include(SHARED_PATH . '/cms_footer.php'); ?>
