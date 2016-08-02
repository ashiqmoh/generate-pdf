<?php
$a[]="Hochschule Furtwangen University";
$a[]="Hochschule Heilbronn";
$a[]="Hochschule Ravensburg-Weingarten";
$a[]="Hochschule Mannheim";
$a[]="Hochschule Offenburg";
$a[]="HWTG Konstanz";
$a[]="Hochschule Karlsruhe";
$a[]="Hochschule Esslingen";
$a[]="Hochschule Aalen";
$a[]="Hochschule Ulm";
$a[]="Hochschule Albstadt-Sigmaringen";
$a[]="Hochschule Biberach";
$a[]="Hochschule Aachen";
$a[]="Hochschule Krefeld";

$hint = "";
$q = trim(stripslashes($_GET["q"]));
$q_explode = explode(' ', $q);
if (strlen($q) > 0 && count($q_explode) == 1) {
	sort($a);
	for ($i = 0; $i < count($a); $i++) {
		$aSubString = explode(' ', $a[$i]);
		for ($j = 0; $j < count($aSubString); $j++) {
			if (strtolower($q) == strtolower(substr($aSubString[$j], 0, strlen($q)))) {
				if ($hint == "") {
					//$hint = $a[$i];
					//$hint = '<b>' . substr($a[$i], 0, strlen($q)) . '</b>' . substr($a[$i], strlen($q), strlen($a[$i]));
					$hintTemp = str_ireplace(substr($aSubString[$j], 0, strlen($q)),
							'<b>'. substr($aSubString[$j], 0, strlen($q)) . '</b>',
							substr($aSubString[$j], 0, strlen($q)));
					$hintTemp2 = $hintTemp . substr($aSubString[$j], strlen($q), strlen($aSubString[$j]));
					$hint = str_ireplace($aSubString[$j], $hintTemp2, $a[$i]);
				}
				else {
					$hintTemp = str_ireplace(substr($aSubString[$j], 0, strlen($q)),
							'<b>'. substr($aSubString[$j], 0, strlen($q)) . '</b>',
							substr($aSubString[$j], 0, strlen($q)));
					$hintTemp2 = $hintTemp . substr($aSubString[$j], strlen($q), strlen($aSubString[$j]));
					$hint = $hint . ',' . str_ireplace($aSubString[$j], $hintTemp2, $a[$i]);
				}
			}
		}
	}
}
elseif (strlen($q) > 0 && count($q_explode) > 1) {
	sort($a);
	$hint = "";
	for ($i = 0; $i < count($a); $i++) {
		if (strtolower($q) == strtolower(substr($a[$i], 0, strlen($q)))) {
			//$q_bold = '<b>' . $q . '</b>';
			if ($hint == "") {
				$hint = '<b>' . substr($a[$i], 0, strlen($q)) . '</b>' . substr($a[$i], strlen($q), strlen($a[$i]));
				//$hint = $a[$i];
			}
			else {
				//$hint = $hint . "," . str_ireplace($q, $q_bold, $a[$i]);
				//$hint = $hint . ',' . $a[$i];
				$hint = $hint . ',' . '<b>' . substr($a[$i], 0, strlen($q)) . '</b>' . substr($a[$i], strlen($q), strlen($a[$i]));
				
			}
		}
	}
}

// set output to no suggestion if no hint were found
// or to the correct value
if ($hint == "") {
	$response = "";
}
else {
	$response = $hint;
}

//output the response
echo $response;
?>