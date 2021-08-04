<?php  

function url_for($script_path) {
  // add the leading '/' if not present
  if($script_path[0] != '/') {
    $script_path = "/" . $script_path;
  }
  return WWW_ROOT . $script_path;
}

function u($string="") {
  return urlencode($string);
}

function raw_u($string="") {
  return rawurlencode($string);
}

function h($string="") {
  return htmlspecialchars($string);
}

function error_404() {
  header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
  exit();
}

function error_500() {
  header($_SERVER["SERVER_PROTOCOL"] . " 500 Internal Server Error");
  exit();
}

function redirect_to($location) {
  header("Location: " . $location);
  exit;
}

function is_post_request() {
  return $_SERVER['REQUEST_METHOD'] == 'POST';
}

function is_get_request() {
  return $_SERVER['REQUEST_METHOD'] == 'GET';
}

function get_and_clear_score_message() {
  if (isset($_SESSION['score_message']) && $_SESSION['score_message'] !== '') {
      $score = $_SESSION['score_message'];
      unset($_SESSION['score_message']);
      return $score;
  }
}

function display_score_message() {
  $score = get_and_clear_score_message();
  if (!is_blank($score)) {
    return "<span>".h($score)."</span>";
  }
}

function display_errors($errors=array()) {
  $output = ' ';
  if (!empty($errors)) {
    $output .= "<div class=\"errors\">";
    $output .= "Please fix the following errors:";
    $output .= "<ul>";
    foreach($errors as $error) {
      $output .= "<li>" .h($error). "</li>";
    };
    $output .= "</ul>";
    $output .= "</div>";
  }
  return $output;
}

function get_and_clear_status_message() {
  if (isset($_SESSION['status_message']) && $_SESSION['status_message'] !== '') {
    $msg = $_SESSION['status_message'];
    unset($_SESSION['status_message']);
    return $msg;
  }
}

function display_status_message() {
  $msg = get_and_clear_status_message();
  if (!is_blank($msg)) {
    return '<div id="message">' . h($msg) . '</div>';
  }
}
