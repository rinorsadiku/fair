<p class="welcome"><a href="<?php echo url_for('index.php'); ?>">Take The Quiz</a></p>
<?php 
$_SESSION['set_num'] = rand(1, 5); 	
?>
<a class="btn" href="<?php echo url_for("index.php?id=1&set_num=".h(u($_SESSION['set_num']))); ?>">Get Started</a>
