<?php
require('clase_06pdf_1/fpdf.php');

class PDF extends FPDF
{
	public $codigo_qr = "";
	//Cabecera de página
	function Header()
	{
		//Logo
		// $this->Image('img_reportes/escudo-romulo.jpg',10,8,15);
		// $this->Image('img_reportes/ministerio.png',180,6,25);
		// //Arial bold 15
		// $this->SetFont('Arial','B',15);
		// //Movernos a la derecha
		// $this->Cell(80);
		// //Título
		// /*$this->Cell(30,10,'Title',1,0,'C');*/
		// //Salto de línea
		// $this->Ln(10);

		//Logo
		$this->Image('img_reportes/cintillo.jpg', 10, 8, 150);
		$this->SetFont('Arial', 'B', 10);
		$this->SetX(135);
		$this->cell(50, 10,  utf8_decode('E.B "RÓMULO GALLEGOS"'));
		$this->Image('img_reportes/escudo-romulo.jpg', 185, 8, 15);
		//Salto de línea
		$this->Ln(10);
	}

	//Pie de página
	function Footer()
	{
		include '../libs/phpqrcode/phpqrcode.php';
		QRcode::png(utf8_decode($this->codigo_qr), "codigo_qr.png");

	    //Posición: a 1,5 cm del final
	    $this->SetY(-15);
	    //Arial italic 8
	    $this->SetFont('Arial','I',8);
	    //Número de página
	    $this->Cell(0,10, utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'R');

		$y = $this->SetY(-30);
		$x = $this->SetX(-30);
		$this->Image('codigo_qr.png', $y, $x, 30, 30);
	}

	function TextWithDirection($x, $y, $txt, $direction='R')
	{
	    if ($direction=='R')
	        $s=sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET',1,0,0,1,$x*$this->k,($this->h-$y)*$this->k,$this->_escape($txt));
	    elseif ($direction=='L')
	        $s=sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET',-1,0,0,-1,$x*$this->k,($this->h-$y)*$this->k,$this->_escape($txt));
	    elseif ($direction=='U')
	        $s=sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET',0,1,-1,0,$x*$this->k,($this->h-$y)*$this->k,$this->_escape($txt));
	    elseif ($direction=='D')
	        $s=sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET',0,-1,1,0,$x*$this->k,($this->h-$y)*$this->k,$this->_escape($txt));
	    else
	        $s=sprintf('BT %.2F %.2F Td (%s) Tj ET',$x*$this->k,($this->h-$y)*$this->k,$this->_escape($txt));
	    if ($this->ColorFlag)
	        $s='q '.$this->TextColor.' '.$s.' Q';
	    $this->_out($s);
	}

	function TextWithRotation($x, $y, $txt, $txt_angle, $font_angle=0)
	{
	    $font_angle+=90+$txt_angle;
	    $txt_angle*=M_PI/180;
	    $font_angle*=M_PI/180;

	    $txt_dx=cos($txt_angle);
	    $txt_dy=sin($txt_angle);
	    $font_dx=cos($font_angle);
	    $font_dy=sin($font_angle);

	    $s=sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET',$txt_dx,$txt_dy,$font_dx,$font_dy,$x*$this->k,($this->h-$y)*$this->k,$this->_escape($txt));
	    if ($this->ColorFlag)
	        $s='q '.$this->TextColor.' '.$s.' Q';
	    $this->_out($s);
	}

}
