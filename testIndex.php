<?php 
error_reporting(E_ALL | E_STRICT);
$sender = $nric = $uni = $course = $currentSem = $mobile = $email = $alg = $ssws = $resultFor = "";
$file = "No file chosen";
$senderErr = $nricErr = $uniErr = $courseErr = $currentSemErr = $mobileErr = $emailErr = $algErr = $sswsErr = $resultForErr = $fileErr ="";
if(!isset($_POST['ssws'])) {
	$_POST['ssws'] = '';
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	require 'result.php';
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Submit Result Beta</title>
<meta name="description" content="Submit Result">
<meta name="keywords" content="submit, result, mgss, ashiq, mohamed,">
<meta name="author" content="Ashiq Mohamed">
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
<script src="result.js"></script>
<link rel="stylesheet" href="result.css"/>
</head>
<body>
<div class="header" id="header">
<h2 style="float:left;">Submit Result Beta</h2>
<input type="button" id="previewPDF" class="previewPDF" value="Preview PDF"/>
<input type="button" id="loadSample" class="loadSample" value="Load Sample Data"/>
</div>
<div class="a4" id="a4">
<form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>" enctype="multipart/form-data">
		<table>
			<tr>
				<td class="noborder"><label for="sender">Name:</label></td>
				<td class="noborder"><input type="text" name="sender" class="contact" id="sender"
					value="<?php echo $sender;?>" /></td>
				<td class="noborder"><span class="error"> <?php  if(isset($senderErr)) echo$senderErr; ?>  </span></td>
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
					value="<?php echo $uni;?>" /><div id="uni_suggest"></div></td>
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
			<!--
			<tr>
				<td class="noborder"><label for="file">Result Attachment:</label></td>
				<td class="noborder">
					<input type="file" name="file" id="file" onchange="setFileName()" style="display:none;"/>
					<input type="text" name="file_text" class="contact"  id="file_text" readonly="readonly" value=" <?php echo $file; ?>"/>
					<input type="button" value="Choose File" id="file_button"/>
				</td>
				<td class="noborder"><span class="error"><?php if(isset($fileErr)) echo $fileErr; ?></span></td>
			</tr>
			-->
		</table>
		<br/>
		<br/>
<input type="button" name="addrow" class="addrow" id="addrow" value="Add Row"/>
<span class="error" id="tableError" style="padding-left:10px;"></span>
<table class="resultTable" id="resultTable">
<tr>
<td class="center">No</td>
<td>Subject (English)</td>
<td>Subject (German)</td>
<td class="center">Result</td>
<td class="center">Note</td>
<td class="center">Status</td>
<td class="center">Attempt</td>
<td class="center">Delete</td>
<td class="noborder"></td>
</tr>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	for ($i = 0; $i < $totalTableRow; $i++) {
		echo '<tr>
		<td class="count center" id="count">' . ($i + 1) .'</td>
		<td><input type="text" name="subjectEnglish[]" class="subjectEnglish" id="subjectEnglish" value="' . $tableValue[$i][1] . '"/></td>
		<td><input type="text" name="subjectGerman[]" class="subjectGerman" id="subjectGerman" value="' . $tableValue[$i][2] . '"/></td>
		<td><select name="result[]" class="result" id="' . ($i + 1) .'" onchange="setNote(this.value, this.id)"  value="' . $tableValue[$i][2] . '">
		    <option class="result_note" id="result_note" value="Note" '. $select_note[$i] . '>Note</option>
		    <option class="schein" id="schein" value="Schein" '. $select_schein[$i] . '>Schein</option>
		</select></td>
		<td><input type="text" name="note[]" class="note" id="note" value="' . $tableValue[$i][4] . '" ' . $noteField[$i] .'/></td>
		<td><select name="status[]" class="status" id="status">
			<option class="pass" id="pass" value="Pass" '. $select_pass[$i] . '>Pass</option>
			<option class="fail" id="fail" value="Fail" '. $select_fail[$i] . '>Fail</option>
			<option class="drop" id="drop" value="Drop" '. $select_drop[$i] . '>Drop</option>
		</select></td>
		<td><input type="text" name="attempt[]" class="attempt" id="attempt" value="' . $tableValue[$i][6] . '"/></td>
		<td><input type="button" name="deleterow" class="deleterow" id="' . ($i + 1) .'" value="Delete" onclick="deleteRow(this.id)"/></td>
		<td class="noborder"><span class="error">' . $rowError[$i] . '</span></td>
		</tr>';
	}
}
else {
	for ($i = 1; $i < 2; $i++) {
		echo '<tr>
		<td class="count center" id="count">' . $i .'</td>
		<td><input type="text" name="subjectEnglish[]" class="subjectEnglish" id="subjectEnglish" /></td>
		<td><input type="text" name="subjectGerman[]" class="subjectGerman" id="subjectGerman" /></td>
		<td><select name="result[]" class="result" id="' . $i .'" onchange="setNote(this.value, this.id)">
		    <option class="result_note" id="result_note" value="Note">Note</option>
		    <option class="schein" id="schein" value="Schein">Schein</option>
		</select></td>
		<td><input type="text" name="note[]" class="note" id="note"/></td>
		<td><select name="status[]" class="status" id="status">
			<option class="pass" id="pass" value="Pass">Pass</option>
			<option class="fail" id="fail" value="Fail">Fail</option>
			<option class="drop" id="drop" value="Drop">Drop</option>
		</select></td>
		<td><input type="text" name="attempt[]" class="attempt" id="attempt"/></td>
		<td><input type="button" name="deleterow" class="deleterow" id="' . $i .'" value="Delete" onclick="deleteRow(this.id)"/></td>
		<td class="noborder"><span class="error"></span></td>
		</tr>';
	}
}
?>
</table>
<input type="submit" name="submit" class="submit" id="submit" value="Send"/>
</form>
</div>
<pre id="debug"><?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
	//echo $totalTableRow;
	//echo var_dump($_POST);
	//echo var_dump($contactInfo);
	//echo var_dump($contactMissing);
	//echo var_dump($missing);
	//echo var_dump($tableValue);
}
?></pre>
</body>
</html>