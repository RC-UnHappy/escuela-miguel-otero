<?php 
include_once("ex_ins_inicial.php");

$pdf=new PDF('P','mm','A3');
$pdf->AliasNbPages();
$pdf->AddPage(400);
$pdf->Ln(10);
$pdf->SetFont('Arial','B',10);


$pdf->Cell(150,6,'',0,0,'C');
$pdf->Cell(100,6,'Inscripcion inicial',5,0,'C');
$pdf->Ln(10);
#Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
$pdf->cell(40,10,'Cedula escolar',1,0,'C');
$pdf->cell(60,10,'Nombres y apellidos',1,0,'C');
$pdf->cell(13,10,'Sexo',1,0,'C');
$pdf->cell(39,5,'Fecha de Nacimiento',1,0,'C');
$pdf->cell(13,10,'Edad',1,0,'C');
$pdf->cell(13,10,'Talla',1,0,'C');
$pdf->cell(13,10,'Peso',1,0,'C');
$pdf->cell(25,10,'L/n',1,0,'C');
$pdf->cell(30,5,'Repite',1,1,'C'); # << salto de linea
$pdf->setX(123); # << aqui el truco, ladilloso pero funciona
$pdf->cell(13,5,'Dia',1,0,'C');
$pdf->cell(13,5,'Mes',1,0,'C');
$pdf->cell(13,5,'Ano',1,0,'C');
$pdf->setX(226); # << aqui el truco, ladilloso pero funciona
$pdf->cell(15,5,'SI',1,0,'C');
$pdf->cell(15,5,'NO',1,0,'C');
$pdf->setY(40); # << posicion vertical (ladilloso)
$pdf->setX(256); # << luego horizontal 
$pdf->cell(40,10,'Representante',1,1,'C'); # salto de linea
$pdf->setY(40);
$pdf->setX(296);
$pdf->cell(20,10,'Cedula',1,1,'C');
$pdf->setY(40);
$pdf->setX(316);
$pdf->cell(30,10,'Ocupacion',1,1,'C');
$pdf->setY(40);
$pdf->setX(346);
$pdf->cell(30,10,'Telefono',1,1,'C');
$pdf->setY(40);
$pdf->setX(376);
$pdf->cell(40,10,'Direccion',1,1,'C');

# resultados:
/*$rs = 20; # resultados de la base de datos ej: 15

$pdf->SetFont('Arial','',10); # letra normal
for($i=0; $i<=$rs ; $i++) { 
	$pdf->cell(40,5,'010203040',1,0,'C');
	$pdf->cell(60,5,'Estudiante '.$i,1,0,'C');
	$pdf->cell(13,5,'00',1,0,'C');
	$pdf->cell(13,5,'00',1,0,'C');
	$pdf->cell(13,5,'00',1,0,'C');
	$pdf->cell(15,5,'',1,0,'C');
	$pdf->cell(15,5,'X',1,0,'C'); # salto de linea
	$pdf->cell(60,5,'Representante '.$i,1,1,'C'); # salto de linea
	$pdf->cell(30,5,'26992848',1,1,'C');
	$pdf->cell(40,5,'Obrero',1,0,'C');
	$pdf->cell(40,5,'0424',1,0,'C');
	$pdf->cell(40,5,'Pimpinela',1,0,'C');
}*/


$pdf->Output();

?>