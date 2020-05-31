<?php 
include_once("ex_aspectos.php");

$pdf=new PDF('P','mm',array(200,380));
$pdf->AliasNbPages();
$pdf->AddPage(380);
$pdf->Ln(10);
$pdf->SetFont('Arial','B',10);

#Textos Horizontales
$pdf->TextWithDirection(76,75,utf8_decode('Papá'),'U');
$pdf->TextWithDirection(86,76,utf8_decode('Mamá'),'U');
$pdf->TextWithDirection(96,76,utf8_decode('Abuelos'),'U');
$pdf->TextWithDirection(106,73,utf8_decode('Otros'),'U');

$pdf->TextWithDirection(116,76,utf8_decode('Casa'),'U');
$pdf->TextWithDirection(126,76,utf8_decode('Apto'),'U');
$pdf->TextWithDirection(136,76,utf8_decode('Otra'),'U');

$pdf->TextWithDirection(285,76,utf8_decode('N° de Personas que'),'U');
$pdf->TextWithDirection(290,76,utf8_decode('Ingresan al Grupo'),'U');
$pdf->TextWithDirection(295,76,utf8_decode('Familiar'),'U');

$pdf->TextWithDirection(336,68,utf8_decode('Posee Canaima'),'U');

$pdf->TextWithDirection(351,76,utf8_decode('Dañada'),'U');
$pdf->TextWithDirection(366,78,utf8_decode('Operativa'),'U');


$m_hogar = utf8_decode("Personas que mantienen el hogar");
$condiciones = utf8_decode("Condiciones en la que se encuentra la Canaima");


$pdf->setX(150);
$pdf->Cell(100,6,utf8_decode('Aspecto socioecónomico'),5,0,'C');
$pdf->Ln(10);


$pdf->cell(60,40,'Nombres y apellidos del Estudiante',1,0,'C');
$pdf->setX(70);
$pdf->MultiCell(40,10,$m_hogar,1,'C');
$pdf->setY(40);
$pdf->setX(110);
$pdf->cell(30,20,'Tipo de vivienda',1,1,'C');
$pdf->setX(70);
$pdf->cell(10,20,'',1,0,'C');
$pdf->cell(10,20,'',1,0,'C');
$pdf->cell(10,20,'',1,0,'C');
$pdf->cell(10,20,'',1,0,'C');
$pdf->cell(10,20,'',1,0,'C');
$pdf->cell(10,20,'',1,0,'C');
$pdf->cell(10,20,'',1,0,'C');

$pdf->setY(70);
$pdf->setX(327);
$pdf->cell(15,10,'S/N',1,0,'C');
$pdf->setY(60);
$pdf->setX(342);
$pdf->cell(15,20,'',1,0,'C');
$pdf->cell(15,20,'',1,0,'C');

$pdf->setY(40);
$pdf->setX(140);
$pdf->cell(100,40,utf8_decode("Dirección de Habitación"),1,0,'C');
$pdf->cell(40,40,utf8_decode("Telefono  "),1,0,'C');
$pdf->cell(17,40,utf8_decode(""),1,0,'C');
$pdf->cell(30,40,utf8_decode("Ingreso mensual"),1,0,'C');
$pdf->cell(15,30,utf8_decode(""),1,1,'C');

$pdf->setY(40);
$pdf->setX(342);
$pdf->MultiCell(30,5,$condiciones,1,'C');
$pdf->Ln(20);


$resultado = 5;
$pdf->SetFont('Arial','',10);
for($i=0; $i<=$resultado ; $i++){
	$pdf->cell(60,5,'Estudiante '.$i,1,0,'C');#Estudiante
	$pdf->cell(10,5,'X',1,0,'C');#Papá
	$pdf->cell(10,5,'X',1,0,'C');#Mamá
	$pdf->cell(10,5,'X',1,0,'C');#Abuelo
	$pdf->cell(10,5,'X',1,0,'C');#Otros
	$pdf->cell(10,5,'X',1,0,'C');#Casa
	$pdf->cell(10,5,'X',1,0,'C');#Apto
	$pdf->cell(10,5,'X',1,0,'C');#Otra
	$pdf->cell(100,5,'Parroquia Pimpinela, Sector Centro',1,0,'C');#Direccion
	$pdf->cell(40,5,'04245692123',1,0,'C');#Telefono
	$pdf->cell(17,5,'1',1,0,'C'); #N° personas en la casa
	$pdf->cell(30,5,'1000',1,0,'C'); #Ingreso mensual
	$pdf->cell(15,5,'S',1,0,'C'); # Posee canaima, si
	$pdf->cell(15,5,'X',1,0,'C'); # Dañada
	$pdf->cell(15,5,'X',1,1,'C'); # Opertiva


}



$pdf->Output();
?>