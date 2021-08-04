<?php  

function find_all_questions() {
	global $db;

	$sql = "SELECT * FROM questions ";
	$result = mysqli_query($db, $sql);
	confirm_result_set($result);
	return $result;
}

function find_question_by_id($id) {
	global $db;

	$sql = "SELECT * FROM questions ";
	$sql .= "WHERE id ='".db_escape($db, $id)."' ";
	$sql .= "LIMIT 1";
	$result = mysqli_query($db, $sql);
	confirm_result_set($result);
	$question = mysqli_fetch_assoc($result);
	mysqli_free_result($result);
	return $question;
} 

function find_questions_by_set($set) {
	global $db;

	$sql = "SELECT * FROM questions ";
	$sql .= "WHERE set_num = '".db_escape($db, $set)."'";
	$sql .= "ORDER BY s_id ASC";
	$result = mysqli_query($db, $sql);
	confirm_result_set($result);
	return $result;
}

function find_question_by_s_id($id, $set_num, $options = []) {
	global $db;

	$visible = $options['visible'] ?? false;

	$sql = "SELECT * FROM questions ";
	$sql .= "WHERE s_id = '".db_escape($db, $id)."' ";
	$sql .= "AND set_num = '".db_escape($db, $set_num)."' ";
	if ($visible) {
		$sql .= "and visible = 1";
	}
	$result = mysqli_query($db, $sql);
	confirm_result_set($result);
	$question = mysqli_fetch_assoc($result);
	mysqli_free_result($result);

	return $question;
}

function shift_s_id($start_pos, $end_pos, $set_num, $current_id = 0) {
    global $db;
    
    if ($start_pos === $end_pos) {
        return ;
    }
 
    $sql = "UPDATE questions SET ";
    if ($start_pos == 0) {
        $sql .= "s_id = s_id + 1 ";
        $sql .= "WHERE s_id >= '".db_escape($db, $end_pos)."' ";
        $sql .= "AND id != '".db_escape($db, $current_id)."' ";
    } elseif ($end == 0) {
        $sql .= "s_id = s_id - 1 ";
        $sql .= "WHERE s_id > '".db_escape($db, $start_pos)."' ";
        $sql .= "AND id != '".db_escape($db, $current_id)."' ";
    } elseif($start_pos < $end_pos) {
    	$sql .= "s_id = s_id - 1 ";
    	$sql .= "WHERE s_id > '".db_escape($db, $start_pos)."' ";
    	$sql .= "AND s_id <= '".db_escape($db, $end_pos)."' ";
    	$sql .= "AND id != '".db_escape($db, $current_id)."' ";
    } elseif($start_pos > $end_pos) {
    	$sql .= "s_id = s_id + 1 ";
    	$sql .= "WHERE s_id >= '".db_escape($db, $end_pos)."' ";
    	$sql .= "AND s_id < '".db_escape($db, $start_pos)."' ";
    	$sql .= "AND id != '".db_escape($db, $current_id)."' ";
    }
    $sql .= "AND set_num = '".db_escape($db, $set_num)."'";
    $result = mysqli_query($db, $sql);
    if ($result) {
        return true;
    } else {
        echo mysqli_error($db);
        db_dissconnect($db);
        exit;
    }
}

function validate_question($question) {
	$errors = [];

	if (is_blank($question['question'])) {
		$errors[] = "Please fill in the question";
	} elseif(!has_string($question['question'], '?')) {
		$errors[] = "Please add a question mark";
	}

	return $errors;
}

function insert_question($question) {
	global $db;

	$errors = validate_question($question);
	if (!empty($errors)) {
		return $errors;
	}

	$start_pos = 0;
	$end_pos = $question['s_id'];
	$set_num = $question['set_num'];

	shift_s_id($start_pos, $end_pos, $set_num);
	$sql = "INSERT INTO questions(s_id, set_num, question, visible) ";
	$sql .= "VALUES ( ";
	$sql .= "'".db_escape($db, $question['s_id'])."', ";
	$sql .= "'".db_escape($db, $question['set_num'])."', ";
	$sql .= "'".db_escape($db, $question['question'])."', ";
	$sql .= "'".db_escape($db, $question['visible'])."' ";
	$sql .= ")";
	$result = mysqli_query($db, $sql);
	if ($result) {
		return true;
	} else {
		echo mysqli_error($db);
		db_dissconnect($db);
		exit;
	}
}

function update_question($question) {
	global $db;
	$old_question = find_question_by_id($question['id']);
	$start_pos = $old_question['s_id'];

	$errors = validate_question($question);
	if (!empty($errors)) {
		return $errors;
	}

	$end_pos = $question['s_id'];
	$set_num = $question['set_num'];
	$current_id = $question['id'];

	shift_s_id($start_pos, $end_pos, $set_num, $id);
	$sql = "UPDATE questions SET ";
	$sql .= "s_id = '".db_escape($db, $question['s_id'])."', ";
	$sql .= "set_num = '".db_escape($db, $question['set_num'])."', ";
	$sql .= "question = '".db_escape($db, $question['question'])."', ";
	$sql .= "visible = '".db_escape($db, $question['visible'])."' ";
	$sql .= "WHERE id = '".db_escape($db, $question['id'])."' ";
	$sql .= "LIMIT 1";
	$result = mysqli_query($db, $sql);
	if ($result) {
		return true;
	} else {
		echo mysqli_error($db);
		db_dissconnect($db);
		exit;
	}
}

function delete_question($id) {
	global $db;

	$question = find_question_by_id($id);
	$start_pos = $question['s_id'];
	$end_pos = 0;
	$set_num = $question['set_num'];

	shift_s_id($start_pos, $end_pos, $set_num, $id);
	$sql = "DELETE FROM questions ";
	$sql .= "WHERE id='".db_escape($db, $id)."' ";
	$sql .= "LIMIT 1";
	$result = mysqli_query($db, $sql);
	if ($result) {
		return true;
	} else {
		echo mysqli_error($db);
		db_dissconnect($db);
		exit;
	}
} 

function find_all_answers() {
	global $db;

	$sql = "SELECT * FROM answers ";
	$sql .= "ORDER BY q_id, id ASC";
	$result = mysqli_query($db, $sql);
	confirm_result_set($result);
	return $result;
}

function find_answer_by_id($id) {
	global $db;

	$sql = "SELECT * FROM answers ";
	$sql .= "WHERE id='".db_escape($db, $id)."' ";
	$sql .= "LIMIT 1";
	$result = mysqli_query($db, $sql);
	confirm_result_set($result);
	$answer = mysqli_fetch_assoc($result);
	mysqli_free_result($result);

	return $answer;
}

function validate_answer($answer) {
	$errors = [];

	if (is_blank($answer['answer'])) {
		$errors[] = "Please fill in the answer";
	}

	return $errors;
}

function insert_answer($answer) {
	global $db;

	$errors = validate_answer($answer);
	if (!empty($errors)) {
		return $errors;
	}

	$sql = "INSERT INTO answers (answer, q_id, correct) ";
	$sql .= "VALUES ( ";
	$sql .= "'".db_escape($db, $answer['answer'])."', ";
	$sql .= "'".db_escape($db, $answer['q_id'])."', ";
	$sql .= "'".db_escape($db, $answer['correct'])."' ";
	$sql .= ")";
	$result = mysqli_query($db, $sql);

	if ($result) {
		return true;
	} else {
		echo mysqli_error($db);
		db_dissconnect($db);
		exit;
	}
}

function update_answer($answer) {
	global $db;

	$errors = validate_answer($answer);
	if (!empty($errors)) {
		return $errors;
	}

	$sql = "UPDATE answers SET ";
	$sql .= "answer = '".db_escape($db, $answer['answer'])."', ";
	$sql .= "q_id = '".db_escape($db, $answer['q_id'])."', ";
	$sql .= "correct = '".db_escape($db, $answer['correct'])."' ";
	$sql .= "WHERE id = '".db_escape($db, $answer['id'])."' ";
	$sql .= "LIMIT 1";
	$result = mysqli_query($db, $sql);

	if ($result) {
		return true;
	} else {
		echo mysqli_error($db);
		db_dissconnect($db);
		exit;
	}
}

function delete_answer($id) {
	global $db;

	$sql = "DELETE FROM answers ";
	$sql .= "WHERE id = '".db_escape($db, $id)."' ";
	$sql .= "LIMIT 1";
	$result = mysqli_query($db, $sql);
	if ($result) {
		return true;
	} else {
		echo mysqli_error($db);
		db_dissconnect($db);
		exit;
	}
}

function validate_correct_answer($answer, $q_id) {
	global $db;

	$sql = "SELECT * FROM answers ";
	$sql .= "WHERE answer='".db_escape($db, $answer)."' ";
	$sql .= "AND q_id ='".db_escape($db, $q_id)."' ";
	$sql .= "AND correct = 1";
	$result = mysqli_query($db, $sql);
	$count = mysqli_num_rows($result);
	mysqli_free_result($result);

	return $count > 0 ;
}

function count_all_questions() {
	global $db;

	$sql = "SELECT COUNT(id) FROM questions";
	$result = mysqli_query($db, $sql);
	$counter = mysqli_fetch_row($result);
	mysqli_free_result($result);
	return $counter[0];
}

function count_questions_by_set($set_num, $options = []) {
	global $db;
	$visible = $options['visible'] ?? false;

	$sql = "SELECT COUNT(id) FROM questions ";
	$sql .= "WHERE set_num = '".db_escape($db, $set_num)."' ";
	if (isset($visible) && $visible == true) {
			$sql .= "AND visible = 1";
		}	
	$result = mysqli_query($db, $sql);
	$counter = mysqli_fetch_row($result);
	mysqli_free_result($result);

	return $counter[0];
}

function find_question_answers_by_q_id($q_id) {
	global $db;

	$sql = "SELECT * FROM answers ";
	$sql .= "WHERE q_id = '".db_escape($db, $q_id)."' ";
	$sql .= "ORDER BY id ASC ";
	$result = mysqli_query($db, $sql);
	confirm_result_set($result);
	return $result;
}

function find_question_and_answers_by_id($id) {
	global $db;

	$sql = "SELECT q.question AS question, ";
	$sql .= "a.answer AS answer ";
	$sql .= "FROM questions AS q ";
	$sql .= "JOIN answers AS a ";
	$sql .= "ON q.id = a.q_id ";
	$sql .= "WHERE q.id = '".$id."' ";
	$sql .= "ORDER BY q.id ASC";

	$result = mysqli_query($db, $sql);
	$question_answer = mysqli_fetch_row($result);
	mysqli_free_result($result);
	return $question_answer;
}

function find_all_admins() {
	global $db;

	$sql = "SELECT * FROM admins ";
	$sql .= "ORDER BY id ASC ";
	$result = mysqli_query($db, $sql);
	confirm_result_set($result);	
	 return $result;
}

function find_admin_by_id($id) {
	global $db;

	$sql = "SELECT * FROM admins ";
	$sql .= "WHERE id = '".db_escape($db, $id)."' ";
	$sql .= "LIMIT 1";
	$result = mysqli_query($db, $sql);
	confirm_result_set($result);
	$admin = mysqli_fetch_assoc($result);
	mysqli_free_result($result);

	return $admin;
}

function find_admin_by_username($username) {
	global $db;

	$sql = "SELECT * FROM admins ";
	$sql .= "WHERE username = '".db_escape($db, $username)."' ";
	$sql .= "LIMIT 1";
	$result = mysqli_query($db, $sql);
	confirm_result_set($result);
	$admin = mysqli_fetch_assoc($result);
	mysqli_free_result($result);

	return $admin;
}

function validate_admin($admin, $options = []) {
	$errors = [];

	$password_required = $options['password_required'] ?? true;

	// $admin['first_name']
	if (is_blank($admin['first_name'])) {
		$errors[] = "First Name cannot be blank";
	} elseif(has_length_less_than($admin['first_name'], 2)) {
		$errors[] = "First Name cannot be less than 2 characters";
	}

	// $admin['last_name']
	if (is_blank($admin['last_name'])) {
		$errors[] = "Last Name cannot be blank";
	} elseif(has_length_less_than($admin['last_name'], 2)) {
		$errors[] = "Last Name annot be less than 2 characters";
	}

	// $admin['username']
	if (is_blank($admin['username'])) {
		$errors[] = "Username cannot be blank";
	} elseif(has_length_less_than($admin['username'], 2)) {
		$errors[] = "Username must be longer than 2 characters";
	}

	if (!has_unique_username($admin['username'], $admin['id'] ?? 0)) {
		$errors[] = "Username is not allowed. Please choose another one";
	}

	// $admin['email']
	if (is_blank($admin['email'])) {
		$errors[] = "Email cannot be blank";
	} elseif(!has_valid_email_format($admin['email'])) {
		$errors[] = "Please choose a valid email";
	} elseif(!has_length($admin['email'], array('max' => 255))) {
		$errors[] = "Email must be less than 255 characters";
	}

	// $admin['password']
	if ($password_required) {
		if(is_blank($admin['password'])) {
        $errors[] = "Password cannot be blank.";
      } elseif (!has_length($admin['password'], array('min' => 12))) {
        $errors[] = "Password must contain 12 or more characters";
      } elseif (!preg_match('/[A-Z]/', $admin['password'])) {
        $errors[] = "Password must contain at least 1 uppercase letter";
      } elseif (!preg_match('/[a-z]/', $admin['password'])) {
        $errors[] = "Password must contain at least 1 lowercase letter";
      } elseif (!preg_match('/[0-9]/', $admin['password'])) {
        $errors[] = "Password must contain at least 1 number";
      } elseif (!preg_match('/[^A-Za-z0-9\s]/', $admin['password'])) {
        $errors[] = "Password must contain at least 1 symbol";
      }

      if(is_blank($admin['confirm_password'])) {
        $errors[] = "Confirm password cannot be blank.";
      } elseif ($admin['password'] !== $admin['confirm_password']) {
        $errors[] = "Password and confirm password must match.";
      }
	}

      return $errors;
}

function insert_admin($admin) {
	global $db;

	$errors = validate_admin($admin);
	if (!empty($errors)) {
		return $errors;
	}

	$hashed_password = password_hash($admin['password'], PASSWORD_BCRYPT);

	$sql = "INSERT INTO admins ";
	$sql .= "(first_name, last_name, username, email, hashed_password) ";
	$sql .= "VALUES ( ";
	$sql .= "'".db_escape($db, $admin['first_name'])."', ";
	$sql .= "'".db_escape($db, $admin['last_name'])."', ";
	$sql .= "'".db_escape($db, $admin['username'])."', ";
	$sql .= "'".db_escape($db, $admin['email'])."', ";
	$sql .= "'".db_escape($db, $hashed_password)."' ";
	$sql .= ");";
	$result = mysqli_query($db, $sql);
	
	if ($result) {
		return true;
	} else {
		echo mysqli_error($db);
		db_dissconnect($db);
		exit;
	}
}

function update_admin($admin) {
	global $db;

	$errors = validate_admin($admin, ['password_required' => false]);
	if (!empty($errors)) {
		return $errors;
	}

	$sql = "UPDATE admins SET ";
	$sql .= "first_name = '".db_escape($db, $admin['first_name'])."', ";
	$sql .= "last_name = '".db_escape($db, $admin['last_name'])."', ";
	$sql .= "username = '".db_escape($db, $admin['username'])."', ";
	$sql .= "email = '".db_escape($db, $admin['email'])."', ";
	$sql .= "hashed_password = '".db_escape($db, $admin['password'])."', ";
	$sql .= "first_name = '".db_escape($db, $admin['first_name'])."' ";
	$sql .= "WHERE id = '".db_escape($db, $admin['id'])."'";

	$result = mysqli_query($db, $sql);
	if ($result) {
		return true;
	} else {
		echo mysqli_error($db);
		db_dissconnect($db);
		exit;
	}
}

function delete_admin($id) {
	global $db;

	$sql = "DELETE FROM admins ";
	$sql .= "WHERE id = '".db_escape($db, $id)."' ";
	$sql .= "LIMIT 1";

	$result = mysqli_query($db, $sql);
	if ($result) {
		return true;
	} else {
		echo mysqli_error($db);
		db_dissconnect($db);
		exit;
	}
}
?>