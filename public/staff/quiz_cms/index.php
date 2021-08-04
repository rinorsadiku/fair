<?php include_once('../../../private/initialize.php') ?>
<?php require_login(); ?>
<?php $page_title = "Quiz Index" ?>

<?php include(SHARED_PATH . '/cms_header.php'); ?>
<div id="content">
	<h2>Quiz Menu</h2>
	<ul>
		<li><a href="<?php echo url_for('staff/quiz_cms/questions/index.php'); ?>">Questions</a></li>
		<li><a href="<?php echo url_for('staff/quiz_cms/admins/index.php'); ?>">Admins</a></li>
	</ul>
</div>
<?php include(SHARED_PATH . '/cms_footer.php'); ?>