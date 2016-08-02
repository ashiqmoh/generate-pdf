<?php 
error_reporting(E_ALL | E_STRICT);
$name = $nric = $uni = $course = $currentSem = $mobile = $email = $alg = $ssws = $resultFor = "";
$file = "No file chosen";
$nameErr = $nricErr = $uniErr = $courseErr = $currentSemErr = $mobileErr = $emailErr = $algErr = $sswsErr = $resultForErr = $fileErr ="";
if(!isset($_POST['ssws'])){
	$_POST['ssws'] = '';
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST["name"])) {
		$nameErr = "Name is required";
	}
	else {
		$name = test_input($_POST["name"]);
		if (!preg_match("/^[a-zA-Z ]*$/", $nameTemp)) {
			$nameErr = "Only letters and white spaces allowed";
		}
	}
	if (empty($_POST["nric"])) {
		$nricErr = "IC number is required";
	}
	else {
		$nric = test_input($_POST["nric"]);
		if (!strlen($nric) == 14 || !preg_match("/(\d{6})-(\d{2})-(\d{4})/", $nric)) {
			$nricErr = "Invalid NRIC. Enter in xxxxxx-xx-xxxx format";
		}
	}
	if (empty($_POST["alg"])) {
		$algErr = "Enter your batch number";
	}
	else {
		$alg = test_input($_POST["alg"]);
		if (!preg_match("/^[0-9]{1,2}$/", $alg)) {
			$algErr = "Enter digit(s) i.e. number(s)";
		}
	}
	if (empty($_POST["uni"])) {
		$uniErr = "Uni/FH/HS is required";
	}
	else {
		$uni = test_input($_POST["uni"]);
		if (!preg_match("/^[a-zA-Z0-9\x{00DF}\x{00E4}\x{00C4}\x{00F6}\x{00D6}\x{00FC}\x{00DC},. ]*$/", $uni)) {
			$uniErr = "Only letters and white spaces allowed";
		}
	}
	if (empty($_POST["course"])) {
		$courseErr = "Course name is required";
	}
	else {
		$course = test_input($_POST["course"]);
		if (!preg_match("/^[a-zA-Z0-9\x{00DF}\x{00E4}\x{00C4}\x{00F6}\x{00D6}\x{00FC}\x{00DC},. ]*$/", $course)) {
			$courseErr = "Only letters and white spaces allowed";
		}
	}
	if (empty($_POST["currentSem"])) {
		$currentSemErr = "Enter your current semester";
	}
	else {
		$currentSem = test_input($_POST["currentSem"]);
		if (!preg_match("/^[0-9]{1,2}$/", $currentSem)) {
			$currentSemErr = "Enter digit(s) i.e. number(s)";
		}
	}
	if (empty($_POST["mobile"])) {
		$mobileErr = "Enter your mobile number";
	}
	else {
		$mobile = test_input($_POST["mobile"]);
		if (!preg_match("/^[+0-9 \/\-]*$/", $mobile)) {
			$mobileErr = "Invalid mobile number. Only digits, +, -, /, white spaces";
		}
	}
	if (empty($_POST["email"])) {
		$emailErr = "Enter your email address";
	}
	else {
		$email = test_input($_POST["email"]);
		if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $email)) {
			$emailErr = "Invalid email address";
		}
	}
	if (empty($_POST["ssws"])) {
		$sswsErr = "Select SS or WS.";
	}
	else {
		$ssws = test_input($_POST["ssws"]);
	}
	if (empty($_POST["resultFor"])) {
		$resultForErr = "Enter year exam was taken";
	}
	else {
		$resultFor = test_input($_POST["resultFor"]);
		if (!preg_match("/^[0-9\/\- ]*$/", $resultFor)) {
			$resultForErr = "Invalid year i.e. semester";
		}
	}
	$allowedExt = "pdf";
	$tempExt = explode(".", $_FILES["file"]["name"]);
	$fileExt = end($tempExt);
	
	if (isset($_FILES["file"])) {
		if ($_FILES["file"]["error"] > 0) {
			$fileErr = "Upload result attachment";
			$file = "No file chosen";
		}
		else {
			if ($_FILES["file"]["type"] == 'application/pdf' && $fileExt == $allowedExt) {
				$fileDetail = array("name" => $_FILES["file"]["name"], "type" => $_FILES["file"]["type"],"size" => $_FILES["file"]["size"], "Stored in" => $_FILES["file"]["tmp_name"]);
			}
			else {
				$fileErr = 'Only pdf format allowed';
			}
			$file = $_FILES["file"]["name"];
		}
	}
}


function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Submit Result</title>
<meta charset="utf-8" />
<script src="result.js"></script>
<link rel="stylesheet" type="text/css" href="result.css"/>
</head>
<body>
<h3>Submit Result Alpha</h3>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
		<table>
			<tr>
				<td class="noborder"><label for="name">Name:</label></td>
				<td class="noborder"><input type="text" name="name" class="contact" id="name"
					value="<?php echo $name;?>" /></td>
				<td class="noborder"><span class="error"> <?php  if(isset($nameErr)) echo$nameErr; ?>  </span></td>
			</tr>
			<tr>
				<td class="noborder"><label for="nric">NRIC:</label></td>
				<td class="noborder"><input type="text" name="nric" class="contact" id="nric"
					value="<?php echo $nric;?>" /></td>
				<td class="noborder"><span class="error"><?php if(isset($nricErr)) echo $nricErr; ?></span></td>
			</tr>
			<tr>
				<td class="noborder"><label for="alg">ALG:</label></td>
				<td class="noborder"><input type="text" name="alg" class="contact" id="alg"
					value="<?php echo $alg;?>" /></td>
				<td class="noborder"><span class="error"><?php echo $algErr; ?></span></td>
			</tr>
			<tr>
				<td class="noborder"><label for="uni">Uni/FH/HS:</label></td>
				<td class="noborder"><input type="text" name="uni" class="contact" id="uni"
					value="<?php echo $uni;?>" /></td>
				<td class="noborder"><span class="error"><?php echo $uniErr; ?></span></td>
			</tr>
			<tr>
				<td class="noborder"><label for="course">Course:</label></td>
				<td class="noborder"><input type="text" name="course" class="contact" id="course"
					value="<?php echo $course;?>" /></td>
				<td class="noborder"><span class="error"><?php echo $courseErr; ?></span></td>
			</tr>
			<tr>
				<td class="noborder"><label for="currentSem">Current Semester:</label></td>
				<td class="noborder"><input type="text" name="currentSem" class="contact" id="currentSem"
					value="<?php echo $currentSem;?>" /></td>
				<td class="noborder"><span class="error"><?php echo $currentSemErr; ?></span></td>
			</tr>
			<tr>
				<td class="noborder"><label for="mobile">Mobile Number:</label></td>
				<td class="noborder"><input type="text" name="mobile" class="contact" id="mobile"
					value="<?php echo $mobile;?>" /></td>
				<td class="noborder"><span class="error"><?php echo $mobileErr; ?></span></td>
			</tr>
			<tr>
				<td class="noborder"><label for="email">Email:</label></td>
				<td class="noborder"><input type="text" name="email" class="contact" id="email"
					value="<?php echo $email; ?>" /></td>
				<td class="noborder"><span class="error"><?php echo $emailErr; ?></span></td>
			</tr>
			<tr>
				<td class="noborder"><label for="resultFor">Result For:</label></td>
				<td class="noborder"><input type="radio" name="ssws"
					<?php if(isset($ssws) && $ssws == "SS") echo "checked";?>
					value="SS" id="SS" />SS <input type="radio" name="ssws"
					<?php if(isset($ssws) && $ssws == "WS") echo "checked";?>
					value="WS" id="WS" />WS <input type="text" name="resultFor"
					class="contact"  id="resultFor" value="<?php echo $resultFor;?>"
					style="width: 153px;" /></td>
				<td class="noborder"><span class="error"><?php echo $sswsErr; ?></span> <span
					class="error"><?php echo $resultForErr; ?></span></td>
			</tr>
			<tr>
				<td class="noborder"><label for="file">Result Attachment:</label></td>
				<td class="noborder">
					<input type="file" name="file" id="file" onchange="setFileName()" style="display:none;"/>
					<input type="text" name="file_text" class="contact"  id="file_text" readonly="readonly" value=" <?php echo $file; ?>" onclick="getFile()"/>
					<input type="button" value="Choose File" id="file_button" onclick="getFile()"/>
				</td>
				<td class="noborder"><span class="error"><?php if(isset($fileErr)) echo $fileErr; ?></span></td>
			</tr>
		</table>
<p>
	<input type="submit" name="submit" id="submit" value="Send" />
</p>
</form>
<pre><?php 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	/*if (!empty($name)) echo $name . '<br/>';
	if (!empty($nric)) echo $nric . '<br/>';
	if (!empty($uni)) echo $uni . '<br/>';
	if (!empty($course)) echo $course . '<br/>';
	if (!empty($currentSem)) echo $currentSem . '<br/>';
	if (!empty($alg)) echo $alg . '<br/>';
	if (!empty($ssws))echo $ssws . '<br/>';
	if (!empty($resultFor))echo $resultFor . '<br/>';
	if (!empty($_FILES['files'])) var_dump($file);*/
	echo var_dump($_POST);
	echo "Name: " . $name . "<br/>";
	echo "NRIC: " . $nric . "<br/>";
	echo "ALG: " . $alg . "<br/>";
	echo "Uni/FH/HS: " . $uni . "<br/>";
	echo "Course: " . $course . "<br/>";
	echo "Current Semester: " . $currentSem . "<br/>";
	echo "Result For: " . $ssws . " " . $resultFor . "<br/>";
	echo "Result Attachment: " . $_FILES['file']['name'] . "<br/>";
	echo $_POST["submit"];
}
?></pre>
</body>
</html>