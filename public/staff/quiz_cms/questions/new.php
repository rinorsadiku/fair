<?php include_once('../../../../private/initialize.php') ?>
<?php require_login(); ?>
<?php $page_title = "Add Question"; ?>
<?php  
if (is_post_request()) {
	$question['question'] = $_POST['question'] ?? "";
	$question['s_id'] = $_POST['s_id'] ?? "";
	$question['set_num'] = $_POST['set_num'] ?? "";
	$question['visible'] = $_POST['visible'] ?? "";

	$result = insert_question($question);
	
	if ($result === true) {
		$new_id = mysqli_insert_id($db);
		$_SESSION['status_message'] = "Question has been succesfully inserted";
		redirect_to(url_for('/staff/quiz_cms/questions/show.php?id='.h(u($new_id))));
	} else {
		$errors = $result;
	}

} else {
	$question['set_num'] = $_GET['set_num'];
	$question['s_id'] = '';
	$question['question'] = '';
	$question['visible'] = '';

	$count = count_questions_by_set($question['set_num']) + 1;
}


?>
<?php include(SHARED_PATH . '/cms_header.php'); ?>
<div id="content">
	<a href="<?php echo url_for('staff/quiz_cms/questions/index.php?set_num='.h(u($question['set_num']))); ?>">Back to list</a>
	<div class="page listing">
		<h3>Add Question</h3>
		<?php echo display_errors($errors); ?>
		<form action="<?php echo url_for('staff/quiz_cms/questions/new.php'); ?>" method="POST">
			<dl>
				<dt>Question</dt>
				<dd><input type="text" name="question" value="<?php echo $question['question']; ?>"></dd>
			</dl>

			<dl>
				<dt>Set ID</dt>
				<dd>
					<select name="s_id">
						<?php  
						for($i = 1; $i <= $count; $i++) {
						echo "<option value=\"{$i}\"";
						if ($question['s_id'] == $i) {
							echo " selected";
						}
						echo " >{$i}</option>";
					}
						?>
					</select>
				</dd>
			</dl>

			<dl>
				<dt>Set Num</dt>
				<dd>
					<select name="set_num">
						<?php  
						for($i = 1; $i <= 5; $i++) {
						echo "<option value=\"{$i}\"";
						if ($question['set_num'] == $i) {
							echo " selected";
						}
						echo " >{$i}</option>";
					}
						?>
					</select>
				</dd>
			</dl>

		  	<dl>
		  	  <dt>Visible</dt>
		  	  <dd>
		  	    <input type="hidden" name="visible" value="0" />
		  	    <input type="checkbox" name="visible" value="1"<?php if($question['visible'] == "1") { echo " checked"; } ?> />
		  	 </dd>
		  	</dl>
			<div id="operations">
				<input type="submit" value="Submit Question">
			</div>
		</form>

	</div>

</div>


<?php include(SHARED_PATH . '/cms_footer.php'); ?>