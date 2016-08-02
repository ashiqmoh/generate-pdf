<?php

/* check result table
 *$_POST = array(subjectEnglish[], subjectGerman[], result[], note[], status[], attempt[]);
 *$_POST = array(name, nric, alg, uni, course, currentSem, mobile, email, ssws, resultFor, file_choosen,
 * subjectEnglish[], subjectGerman[], result[], note[], status[], attempt[], submit);
 */

$totalTableRow = count($_POST['subjectEnglish']);
$tableValue = array(array());
$missing = array(array());
$select_note = array();
$select_schein = array();
$noteField = array();
$select_pass = array();
$select_fail = array();
$select_drop = array();
$rowError = array();
$rowComplete = array();

// change $_post[column][row] --> $tableValue[row][column]
// and set $missing[row][column] = true/false
$count = 0;
foreach ($_POST as $name => $value) {
	if(is_array($value)) {
		for ($j = 0; $j < $totalTableRow; $j++) {
			if (empty($_POST[$name][$j])) {
				$missing[$j][$count] = true;
				$tableValue[$j][$count] = '';
			}
			else {
				$missing[$j][$count] = false;
				$_POST[$name][$j] = trim($_POST[$name][$j]);
				$_POST[$name][$j] = stripslashes($_POST[$name][$j]);
				$_POST[$name][$j] = htmlspecialchars($_POST[$name][$j], ENT_QUOTES, 'ISO8859-1');
				$tableValue[$j][$count] = $_POST[$name][$j]; 
			}
		}
		$count++;
	}
}
for ($i = 0; $i < $totalTableRow; $i++) {
	if($tableValue[$i][2] == 'Schein') {
		$missing[$i][3] = false;
	}
	
	if ($tableValue[$i][2] == 'Note') {
		$select_note[$i] = 'selected';
		$noteField[$i] = '';
	}
	else $select_note[$i] = '';
	if ($tableValue[$i][2] == 'Schein') {
		$select_schein[$i] = 'selected';
		$noteField[$i] = 'readonly style="background-color: #dddddd;"';
	}
	else $select_schein[$i] = '';
	if ($tableValue[$i][4] == 'Pass') $select_pass[$i] = 'selected';
	else $select_pass[$i] = '';
	if ($tableValue[$i][4] == 'Fail') $select_fail[$i] = 'selected';
	else $select_fail[$i] = '';
	if ($tableValue[$i][4] == 'Drop') $select_drop[$i] = 'selected';
	else $select_drop[$i] = '';
}

for ($i = 0; $i < $totalTableRow; $i++) {
	if ($missing[$i][0] == true && $missing[$i][1] == true && $missing[$i][3] == true && $missing[$i][5] == true && $totalTableRow > 1) {
		$rowError[$i] = 'Delete this empty row';
		$rowComplete[$i] = false; 
	}
	elseif ($missing[$i][0] == false && $missing[$i][1] == false && $missing[$i][3] == false && $missing[$i][5] == false) {
		$rowError[$i] = '';
		$rowComplete[$i] = true;
	}
	else {
		$rowError[$i] = 'This row is incomplete';
		$rowComplete[$i] = false;
	}
}
for ($i = 0; $i < $totalTableRow; $i++) {
	if ($rowComplete[$i] == true) {
		if (!preg_match('/^[a-zA-Z0-9,. ]*$/', $tableValue[$i][0]) || 
		!preg_match("/^[a-zA-Z0-9\x{00DF}\x{00E4}\x{00C4}\x{00F6}\x{00D6}\x{00FC}\x{00DC},. ]*$/", $tableValue[$i][1])) {
			$rowError[$i] = "Subjects: Only letters, numbers and white spaces. ";
			
		}
		if ($tableValue[$i][2] == 'Note' && !preg_match("/^[0-9]{1}[,]{1}[0-9]{1}$/", $tableValue[$i][3])) {
			$rowError[$i] .= "Note: In X,x format. ";
				
		}
		if (!preg_match("/^[0-9]{1,2}$/", $tableValue[$i][5])) {
			$rowError[$i] .= "Attempt: Max 2 digits";
				
		}
	}
}
?>