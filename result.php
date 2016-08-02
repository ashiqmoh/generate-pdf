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
		$senderErr = "";
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
	if (!preg_match("/(\d{6})-(\d{2})-(\d{4})/", $nric)) {
		$nricErr = "Invalid NRIC. Enter in xxxxxx-xx-xxxx format";
		$contactMissing[1] = true;
	}
	else {
		$nricErr = "";
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
		$algErr = "";
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
		$uniErr = "";
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
		$courseErr = "";
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
		$currentSemErr = "";
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
		$mobileErr = "";
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
		$emailErr = "";
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
	$sswsErr = "";
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
		$resultForErr = "";
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
		$contactMissing[10] = false;
	}
	else {
		if ($_FILES["file"]["type"] == 'application/pdf' && $fileExt == $allowedExt) {
			$fileDetail = array("name" => $_FILES["file"]["name"], "type" => $_FILES["file"]["type"],"size" => $_FILES["file"]["size"], "Stored in" => $_FILES["file"]["tmp_name"]);
			$fileErr = "";
			$contactMissing[10] = false;
		}
		else {
			$fileErr = 'Only pdf format allowed';
			$contactMissing[10] = false;
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

/* check result table
 * 
 * $_POST = array(name, nric, alg, uni, course, currentSem, mobile, email, ssws, resultFor, file_choosen,
 * subjectEnglish[], subjectGerman[], result[], note[], status[], attempt[]);
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
$count = 1;
foreach ($_POST as $name => $value) {
	if(is_array($value)) {
		for ($j = 0; $j < $totalTableRow; $j++) {
			$missing[$j][0] = false;
			$tableValue[$j][0] = $j + 1;
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
	if($tableValue[$i][3] == 'Schein') {
		$missing[$i][4] = false;
	}

	if ($tableValue[$i][3] == 'Note') {
		$select_note[$i] = 'selected';
		$noteField[$i] = '';
	}
	else $select_note[$i] = '';
	if ($tableValue[$i][3] == 'Schein') {
		$select_schein[$i] = 'selected';
		$noteField[$i] = 'readonly style="background-color: #dddddd;"';
	}
	else $select_schein[$i] = '';
	if ($tableValue[$i][5] == 'Pass') $select_pass[$i] = 'selected';
	else $select_pass[$i] = '';
	if ($tableValue[$i][5] == 'Fail') $select_fail[$i] = 'selected';
	else $select_fail[$i] = '';
	if ($tableValue[$i][5] == 'Drop') $select_drop[$i] = 'selected';
	else $select_drop[$i] = '';
}

for ($i = 0; $i < $totalTableRow; $i++) {
	if ($missing[$i][1] == true && $missing[$i][2] == true && $missing[$i][4] == true && $missing[$i][6] == true && $totalTableRow > 1) {
		$rowError[$i] = 'Delete this empty row';
		$rowComplete[$i] = false;
	}
	elseif ($missing[$i][1] == false && $missing[$i][2] == false && $missing[$i][4] == false && $missing[$i][6] == false) {
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
		if (!preg_match('/^[a-zA-Z0-9,. ]*$/', $tableValue[$i][1]) ||
		!preg_match("/^[a-zA-Z0-9\x{00DF}\x{00E4}\x{00C4}\x{00F6}\x{00D6}\x{00FC}\x{00DC},. ]*$/", $tableValue[$i][1])) {
			$rowError[$i] = "Subjects: Only letters, numbers and white spaces. ";
				
		}
		if ($tableValue[$i][3] == 'Note' && !preg_match("/^[0-9]{1}[,]{1}[0-9]{1}$/", $tableValue[$i][4])) {
			$rowError[$i] .= "Note: In X,x format. ";

		}
		if (!preg_match("/^[0-9]{1,2}$/", $tableValue[$i][6])) {
			$rowError[$i] .= "Attempt: Max 2 digits";

		}
	}
}

/* 
 * Create pdf output
 */

require('../fpdf/fpdf.php');

class PDF extends FPDF {
	var $widths;
	var $aligns;
	function SetWidths($w) {
		$this->widths=$w;
	}
	function SetAligns($a) {
		$this->aligns=$a;
	}
	function customHeader($resultFor) {
		$this->SetY(20);
		$this->SetFont('Times', 'B', 14);
		$this->Cell(0, 10, 'Result '. $resultFor, 0, 1, 'C', false);
		$this->Cell(0, 10, '', 0 ,1 , 'C', false);
	}
	function Footer() {
		$this->SetY(-20);
		$this->SetFont('Times', '', 9);
		$this->Cell(0, 6, 'Page ' . $this->PageNo() . ' of {nb}', 0, 0, 'C', false);
	}
	function senderInfo($info, $infoHeader) {
		$this->SetFont('Times', '', 10);
		$w = array(30, 90);
		for($i = 0; $i < 8; $i++) {
			$this->Cell($w[0], 6, $infoHeader[$i], 0);
			$this->Cell($w[1], 6, $info[$i], 0);
			$this->Ln();
		}
		$this->Cell(0, 10, '', 0 ,1 , 'C', false);
	}
	function tableHeader($header) {
		$this->setFillColor(255, 255, 255);
		$this->SetDrawColor(0, 0, 0);
		$this->SetLineWidth(.1);
		$this->SetFont('Times', 'B', 10);
		$w = array(10, 50, 50, 15, 15, 15, 15);
		//$this->Cell(array_sum($w), 0.2 , '', 'B');
		//$this->Ln();
		$this->Cell($w[0], 6, $header[0], 0, 0, 'C');
		$this->Cell($w[1], 6, $header[1], 0, 0, 'L');
		$this->Cell($w[2], 6, $header[2], 0, 0, 'L');
		$this->Cell($w[3], 6, $header[3], 0, 0, 'C');
		$this->Cell($w[4], 6, $header[4], 0, 0, 'C');
		$this->Cell($w[5], 6, $header[5], 0, 0, 'C');
		$this->Cell($w[6], 6, $header[6], 0, 0, 'C');
		$this->Ln();
		$this->Cell(array_sum($w), 0 , '', 'T');
		$this->Ln();
	}
	function tableContent($data, $fill) {
		// Color and font restoration
		$this->SetFillColor(230, 230, 230);
		$this->SetDrawColor(230, 230, 230);
		$this->SetTextColor(0);
		$this->SetFont('Times', '' , 10);
		// Data
		$nb = 0;
		for($i = 0; $i < count($data); $i++) {
			$nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
		}
		$h = 5*$nb;
		$this->CheckPageBreak($h);
		for($i = 0; $i < count($data); $i++) {
			$w = $this->widths[$i];
			$a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
			$x = $this->GetX();
			$y = $this->GetY();
			if($fill == true) {
				$this->Rect($x, $y, $w, $h, 'F');
			}
			$this->MultiCell($w, 5, $data[$i], 0, $a);
			$this->SetXY($x + $w, $y);
		}
		$this->Ln($h);
		// Closing line
		// $this->Cell(array_sum($w), 0 , '', 'T');

	}
	function CheckPageBreak($h) {
		//If the height h would cause an overflow, add a new page immediately
		if($this->GetY() + $h > $this->PageBreakTrigger) {
			$this->AddPage($this->CurOrientation);
		}
	}
	function NbLines($w, $txt) {
		//Computes the number of lines a MultiCell of width w will take
		$cw = &$this->CurrentFont['cw'];
		if($w == 0) {
			$w = $this->w-$this->rMargin-$this->x;
		}
		$wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
		$s = str_replace("\r",'',$txt);
		$nb = strlen($s);
		if($nb > 0 and $s[$nb-1] == "\n") {
			$nb--;
		}
		$sep = -1;
		$i = 0;
		$j = 0;
		$l = 0;
		$nl = 1;
		while ($i < $nb) {
			$c = $s[$i];
			if ($c == "\n") {
				$i++;
				$sep = -1;
				$j = $i;
				$l = 0;
				$nl++;
				continue;
			}
			if ($c == ' ') {
				$sep = $i;
			}
			$l += $cw[$c];
			if($l > $wmax) {
				if($sep == -1) {
					if($i == $j) {
						$i++;
					}
				}
				else {
					$i = $sep+1;
				}
				$sep = -1;
				$j = $i;
				$l = 0;
				$nl++;
			}
			else {
				$i++;
			}
		}
		return $nl;
	}
}

if(!in_array(true, $contactMissing) && !in_array(false, $rowComplete)) {
	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->SetMargins(20, 20, 20);
	$contactHeader = array('Name:', 'NRIC:', 'ALG:', 'Uni/FH/HS:', 'Course:', 'Current Semester:', 'Mobile Number:', 'Email:');
	$pdf->SetWidths(array(10, 50, 50, 15, 15, 15, 15));
	$pdf->SetAligns(array('C', 'L', 'L', 'C', 'C', 'C', 'C'));
	$header = array('No', 'Subject (English)', 'Subject (German)', 'Result', 'Note', 'Status', 'Attempt');
	$pdf->AddPage();
	$pdf->customHeader($contactInfo[8]);
	$pdf->senderInfo($contactInfo, $contactHeader);
	$pdf->tableHeader($header);
	$fill = false;
	foreach ($tableValue as $row){
		$pdf->tableContent($row, $fill);
		$fill = !$fill;
	}
	$pdf->Output();
}
?>