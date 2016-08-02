<?php
/* check contact fields
 * 
 */
$contactMissing = array();
$contactInfo = array();

if (empty($_POST["sender"])) {
	$senderErr = "Name is required";
	$contactMissing[0] = true;
}
else {
	$sender = test_input($_POST["sender"]);
	if (!preg_match("/^[a-zA-Z ]*$/", $sender)) {
		$senderErr = "Only letters and white spaces allowed";
		$contactMissing[0] = true;
	}
	else {
		$contactMissing[0] = false;
		$contactInfo[0] = $sender;
	}
}
if (empty($_POST["nric"])) {
	$nricErr = "IC number is required";
	$contactMissing[1] = true;
}
else {
	$nric = test_input($_POST["nric"]);
	if (!strlen($nric) == 14 || !preg_match("/(\d{6})-(\d{2})-(\d{4})/", $nric)) {
		$nricErr = "Invalid NRIC. Enter in xxxxxx-xx-xxxx format";
		$contactMissing[1] = true;
	}
	else {
		$contactMissing[1] = false;
		$contactInfo[1] = $nric;
	}
}
if (empty($_POST["alg"])) {
	$algErr = "Enter your batch number";
	$contactMissing[2] = true;
}
else {
	$alg = test_input($_POST["alg"]);
	if (!preg_match("/^[0-9]{1,2}$/", $alg)) {
		$algErr = "Enter digit(s) i.e. number(s)";
		$contactMissing[2] = true;
	}
	else {
		$contactMissing[2] = false;
		$contactInfo[2] = $alg;
	}
}
if (empty($_POST["uni"])) {
	$uniErr = "Uni/FH/HS is required";
	$contactMissing[3] = true;
}
else {
	$uni = test_input($_POST["uni"]);
	if (!preg_match("/^[a-zA-Z0-9\x{00DF}\x{00E4}\x{00C4}\x{00F6}\x{00D6}\x{00FC}\x{00DC},. ]*$/", $uni)) {
		$uniErr = "Only letters and white spaces allowed";
		$contactMissing[3] = true;
	}
	else {
		$contactMissing[3] = false;
		$contactInfo[3] = $uni;
	}
}
if (empty($_POST["course"])) {
	$courseErr = "Course name is required";
	$contactMissing[4] = true;
}
else {
	$course = test_input($_POST["course"]);
	if (!preg_match("/^[a-zA-Z0-9\x{00DF}\x{00E4}\x{00C4}\x{00F6}\x{00D6}\x{00FC}\x{00DC},. ]*$/", $course)) {
		$courseErr = "Only letters and white spaces allowed";
		$contactMissing[4] = true;
	}
	else {
		$contactMissing[4] = false;
		$contactInfo[4] = $course;
	}
}
if (empty($_POST["currentSem"])) {
	$currentSemErr = "Enter your current semester";
	$contactMissing[5] = true;
}
else {
	$currentSem = test_input($_POST["currentSem"]);
	if (!preg_match("/^[0-9]{1,2}$/", $currentSem)) {
		$currentSemErr = "Enter digit(s) i.e. number(s)";
		$contactMissing[5] = true;
	}
	else {
		$contactMissing[5] = false;
		$contactInfo[5] = $currentSem;
	}
}
if (empty($_POST["mobile"])) {
	$mobileErr = "Enter your mobile number";
	$contactMissing[6] = true;
}
else {
	$mobile = test_input($_POST["mobile"]);
	if (!preg_match("/^[+0-9 \/\-]*$/", $mobile)) {
		$mobileErr = "Invalid mobile number. Only digits, +, -, /, white spaces";
		$contactMissing[6] = true;
	}
	else {
		$contactMissing[6] = false;
		$contactInfo[6] = $mobile;
	}
}
if (empty($_POST["email"])) {
	$emailErr = "Enter your email address";
	$contactMissing[7] = true;
}
else {
	$email = test_input($_POST["email"]);
	if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $email)) {
		$emailErr = "Invalid email address";
		$contactMissing[7] = true;
	}
	else {
		$contactMissing[7] = false;
		$contactInfo[7] = $email;
	}
}
if (empty($_POST["ssws"])) {
	$sswsErr = "Select SS or WS.";
	$contactMissing[8] = true;
}
else {
	$ssws = $_POST["ssws"];
	$contactMissing[8] = false;
	$contactInfo[8] = $ssws;
}
if (empty($_POST["resultFor"])) {
	$resultForErr = "Enter year exam was taken";
	$contactMissing[9] = true;
}
else {
	$resultFor = test_input($_POST["resultFor"]);
	if (!preg_match("/^[0-9\/\- ]*$/", $resultFor)) {
		$resultForErr = "Invalid year i.e. semester";
		$contactMissing[9] = true;
	}
	else {
		$contactMissing[9] = false;
		$contactInfo[8] .= ' ' . $resultFor;
	}
}
$allowedExt = "pdf";
$tempExt = explode(".", $_FILES["file"]["name"]);
$fileExt = end($tempExt);

if (isset($_FILES["file"])) {
	if ($_FILES["file"]["error"] > 0) {
		$fileErr = "Upload result attachment";
		$file = "No file chosen";
		$contactMissing[10] = true;
	}
	else {
		if ($_FILES["file"]["type"] == 'application/pdf' && $fileExt == $allowedExt) {
			$fileDetail = array("name" => $_FILES["file"]["name"], "type" => $_FILES["file"]["type"],"size" => $_FILES["file"]["size"], "Stored in" => $_FILES["file"]["tmp_name"]);
			$contactMissing[10] = false;
		}
		else {
			$fileErr = 'Only pdf format allowed';
			$contactMissing[10] = true;
		}
		$file = $_FILES["file"]["name"];
	}
}

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data, ENT_QUOTES, 'ISO8859-1');
	return $data;
}

?>