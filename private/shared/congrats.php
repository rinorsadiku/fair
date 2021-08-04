<?php
$counter = count_questions_by_set($_SESSION['set_num'] ?? 1, ['visible' => true]); 
$score = display_score_message();
unset($_SESSION['set_num']);
?>
<h1 class="welcome">Urime... <br><?php echo $score ?? '0'; ?>/<?php echo $counter; ?></h1>

<a class="back_button" href="<?php echo url_for('index.php'); ?>">Kthehu</a>
