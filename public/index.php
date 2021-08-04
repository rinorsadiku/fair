<?php  
	include_once('../private/initialize.php');
	$end = false;
	if (isset($_GET['end']) && $_GET['end'] !== "") {
		$end = true;

	} elseif (isset($_GET['id']) && $_GET['id'] !== "") {
		
		$id = $_GET['id'];
		$set_num = $_SESSION['set_num'];
		$question = find_question_by_s_id($id, $set_num, ['visible' => true]);
		$answers_result = find_question_answers_by_q_id($question['id']);
		if (!$question['visible']) {
			$id++;
			redirect_to(url_for('index.php?id='.h(u($id)).'&set_num='.h(u($set_num))));
		}
	
	if (is_post_request()) {
		$answer = $_POST['answer'] ?? "";
		if (is_blank($answer)) {
			$careful = "Ju lutem zgjidhni nje pergjigje";
		} else {
			$correct = validate_correct_answer($answer, $question['id']);
			if ($correct) {
				++$_SESSION['score_message'];
			} 
			$id++;
			if ($id > 10) {
				redirect_to(url_for('index.php?end=true'));
			}
			redirect_to(url_for('index.php?id='.h(u($id)).'&set_num='.h(u($set_num))));	
		}
	}	 
}

?>
<?php include(SHARED_PATH . '/public_header.php'); ?>
<?php 
if ($end) {
	include(SHARED_PATH . '/congrats.php');

} elseif (isset($question) && isset($answers_result)) {?>
	<div class="form_box">
		<h1><?php echo $question['question'] ?></h1>
		<form method="POST" action="<?php echo url_for('index.php?id='.h(u($id))); ?>">
			<br>
		<?php while($answers = mysqli_fetch_assoc($answers_result)) { ?>
			<input class="form_radio" type="radio" name="answer" value="<?php echo $answers['answer']; ?>"><p><?php echo h($answers['answer']); ?></p>
		<?php } ?>
		<h4 class="careful"><?php echo $careful ?? ""; ?></h4>
		<br>
		<button name="button" type="submit">Next</button>
		</form>
	</div>

	<?php
} else {

	// this include file will only work 
 	// when no id was present in the URL 	
	include(SHARED_PATH . '/static_homepage.php'); 
}

?>
<?php include(SHARED_PATH . '/public_footer.php'); ?>