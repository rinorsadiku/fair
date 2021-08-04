<?php
  if(!isset($page_title)) { $page_title = 'Staff Area'; }
?>

<!doctype html>

<html lang="en">
  <head>
    <title>XHD - <?php echo h($page_title); ?></title>
    <meta charset="utf-8">
    <link rel="stylesheet" media="all" href="<?php echo url_for('/stylesheets/staff.css'); ?>" />
  </head>

  <body>
    <header>
      <h1>XHD Staff Area</h1>
    </header>

    <nav>
      <ul>
        <li><a href="<?php echo url_for('/staff/quiz_cms/index.php'); ?>">Menu</a></li>
        <li>User: <?php echo $_SESSION['username'] ?? ""; ?></li>
        <?php if (isset($_SESSION['admin_id']) && $_SESSION['admin_id'] !== "") { ?>
                  <li><a href="<?php echo url_for('staff/logout.php'); ?>">Logout</a></li>
        <?php } ?>
      </ul>
    </nav>

    <?php echo display_status_message(); ?>