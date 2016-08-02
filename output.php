<?php 
require('./fpdf/fpdf.php');

class PDF extends FPDF {
	var $widths;
	var $aligns;
	function SetWidths($w) {
		$this->widths=$w;
	}
	function SetAligns($a) {
		$this->aligns=$a;
	}
	function Header($resultFor) {
		$this->SetY(20);
		$this->SetFont('Times', 'B', 14);
		$this->Cell(0, 10, 'Result ' . $resultFor, 0, 1, 'C', false);
		$this->Cell(0, 20, '', 0 ,1 , 'C', false);
	}
	function Footer() {
		$this->SetY(-20);
		$this->SetFont('Times', '', 9);
		$this->Cell(0, 6, 'Page ' . $this->PageNo() . ' of {nb}', 0, 0, 'C', false);
	}
	function LoadData($file) {
		// Read file lines
		$lines = file($file);
		$data = array();
		foreach($lines as $line) {
			$data[] = explode(';', trim($line));
		}
		return $data;
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
			$this->SetXY($x+$w, $y);
    	}
    	$this->Ln($h);
		// Closing line
		// $this->Cell(array_sum($w), 0 , '', 'T');
		
	}
	function CheckPageBreak($h) {
		//If the height h would cause an overflow, add a new page immediately
		if($this->GetY()+$h>$this->PageBreakTrigger)
			$this->AddPage($this->CurOrientation);
	}
	function NbLines($w,$txt) {
		//Computes the number of lines a MultiCell of width w will take
		$cw=&$this->CurrentFont['cw'];
		if($w==0)
			$w=$this->w-$this->rMargin-$this->x;
		$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
		$s=str_replace("\r",'',$txt);
		$nb=strlen($s);
		if($nb>0 and $s[$nb-1]=="\n")
			$nb--;
		$sep=-1;
		$i=0;
		$j=0;
		$l=0;
		$nl=1;
		while($i<$nb)
		{
			$c=$s[$i];
			if($c=="\n")
			{
				$i++;
				$sep=-1;
				$j=$i;
				$l=0;
				$nl++;
				continue;
			}
			if($c==' ')
				$sep=$i;
			$l+=$cw[$c];
			if($l>$wmax)
			{
				if($sep==-1)
				{
					if($i==$j)
						$i++;
				}
				else
					$i=$sep+1;
				$sep=-1;
				$j=$i;
				$l=0;
				$nl++;
			}
			else
				$i++;
		}
		return $nl;
	}
}
//&& !in_array(false, $rowComplete)
if(!in_array(true, $contactMissing) ) {
	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->SetMargins(20, 20, 20);
	$pdf->SetWidths(array(10, 50, 50, 15, 15, 15, 15));
	$pdf->SetAligns(array('C', 'L', 'L', 'C', 'C', 'C', 'C'));
	$header = array('No', 'Subject (English)', 'Subject (German)', 'Result', 'Note', 'Status', 'Attempt');
	$data = $pdf->LoadData('countries.txt');
	$pdf->AddPage();
	$pdf->Header($contactInfo[8]);
	$pdf->tableHeader($header);
	$fill = false;
	foreach ($data as $row){
		$pdf->tableContent($row, $fill);
		$fill = !$fill;
	}
	$pdf->Output();
}
?>