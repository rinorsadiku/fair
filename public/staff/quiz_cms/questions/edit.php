<?php include_once('../../../../private/initialize.php') ?>
<?php require_login(); ?>
<?php $page_title = "Edit Question"; ?>
<?php  
$id = $_GET['id'];
if (is_post_request()) {
	$question['id'] = $id;
	$question['question'] = $_POST['question'] ?? "";
	$question['s_id'] = $_POST['s_id'] ?? "";
	$question['set_num'] = $_POST['set_num'] ?? "";
	$question['visible'] = $_POST['visible'] ?? "";

	$result = update_question($question);
	if ($result === true) {
		$_SESSION['status_message'] = "Question has been succesfully modified";
		redirect_to(url_for('/staff/quiz_cms/questions/show.php?id='.h(u($id))));
	} else {
		$errors = $result;
	}
	
} 
	$question = find_question_by_id($id) ?? "";
	$count = count_questions_by_set($question['set_num']);

?>
<?php include(SHARED_PATH . '/cms_header.php'); ?>
<div id="content">
	<a href="<?php echo url_for('staff/quiz_cms/questions/index.php?set_num='.h(u($question['set_num']))); ?>">Back to list</a>
	<div class="page listing">
		<h3>Edit Question</h3>
		<?php echo display_errors($errors); ?>
		<form action="<?php echo url_for('staff/quiz_cms/questions/edit.php?id='.h(u($id))); ?>" method="POST">
			<dl>
				<dt>Question</dt>
				<dd><input type="text" name="question" value="<?php echo h($question['question']); ?>"></dd>
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
				<input type="submit" value="Edit Question">
			</div>
		</form>

	</div>

</div>

<?php include(SHARED_PATH . '/cms_footer.php'); ?>