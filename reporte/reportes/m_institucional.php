<?php
include_once("ex_cabecera_carta.php");
$pdf=new PDF('P','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Ln(10);
$pdf->SetFont('Arial','B',12);
#Los textos horizontales "varones, hembras y total", se encuentra antes del $pdf->Output()
#Datos del director
$licenciado="Luis Marin";
$cedula_licenciado = 29629048;

#TITULOS
$pdf->setX(55);
$pdf->Cell(100,5,utf8_decode('Matricula institucional'),0,1,'C');
$pdf->Ln(2);
$pdf->setX(55);
$pdf->Cell(100,5,utf8_decode("Año Escolar: 2020-2021"),0,1,'C');
$pdf->Ln(15);

$pdf->setX(55);
$pdf->Cell(100,5,utf8_decode("Mes: MARZO 2020"),0,1,'C');
$pdf->Ln(20);


$pdf->Cell(24,40,utf8_decode("Sección"),1,0,'C');
$pdf->Cell(24,15,utf8_decode("Primero "),1,0,'C');
$pdf->Cell(24,15,utf8_decode("Segundo "),1,0,'C');
$pdf->Cell(24,15,utf8_decode("Tercero"),1,0,'C');
$pdf->Cell(24,15,utf8_decode("Cuarto"),1,0,'C');
$pdf->Cell(24,15,utf8_decode("Quinto"),1,0,'C');
$pdf->Cell(24,15,utf8_decode("Sexto"),1,0,'C');
$pdf->Cell(24,15,utf8_decode("Totales"),1,1,'C');

$pdf->setX(34);
#primer grado
$pdf->Cell(8,25,utf8_decode(""),1,0,'C');
$pdf->Cell(8,25,utf8_decode(""),1,0,'C');
$pdf->Cell(8,25,utf8_decode(""),1,0,'C');
#segundo grado
$pdf->Cell(8,25,utf8_decode(""),1,0,'C');
$pdf->Cell(8,25,utf8_decode(""),1,0,'C');
$pdf->Cell(8,25,utf8_decode(""),1,0,'C');
#tercer grado
$pdf->Cell(8,25,utf8_decode(""),1,0,'C');
$pdf->Cell(8,25,utf8_decode(""),1,0,'C');
$pdf->Cell(8,25,utf8_decode(""),1,0,'C');
#cuarto grado
$pdf->Cell(8,25,utf8_decode(""),1,0,'C');
$pdf->Cell(8,25,utf8_decode(""),1,0,'C');
$pdf->Cell(8,25,utf8_decode(""),1,0,'C');
#quinto grado
$pdf->Cell(8,25,utf8_decode(""),1,0,'C');
$pdf->Cell(8,25,utf8_decode(""),1,0,'C');
$pdf->Cell(8,25,utf8_decode(""),1,0,'C');
#sexto grado
$pdf->Cell(8,25,utf8_decode(""),1,0,'C');
$pdf->Cell(8,25,utf8_decode(""),1,0,'C');
$pdf->Cell(8,25,utf8_decode(""),1,0,'C');
#total de alumnos
$pdf->Cell(8,25,utf8_decode(""),1,0,'C');
$pdf->Cell(8,25,utf8_decode(""),1,0,'C');
$pdf->Cell(8,25,utf8_decode(""),1,1,'C');


$rs="D";
$pdf->SetFont('Arial','',10);
for ($i="A"; $i<=$rs; $i++){
	$pdf->Cell(24,5,utf8_decode($i),1,0,'C');#Sección
	#Primer grado/////////////////////////////////
	$pdf->Cell(8,5,utf8_decode("1"),1,0,'C');
	$pdf->Cell(8,5,utf8_decode("1"),1,0,'C');
	$pdf->Cell(8,5,utf8_decode("1"),1,0,'C');
	#Segundo grado////////////////////////////////
	$pdf->Cell(8,5,utf8_decode("2"),1,0,'C');
	$pdf->Cell(8,5,utf8_decode("2"),1,0,'C');
	$pdf->Cell(8,5,utf8_decode("2"),1,0,'C');
	#Tercer grado/////////////////////////////////
	$pdf->Cell(8,5,utf8_decode("3"),1,0,'C');
	$pdf->Cell(8,5,utf8_decode("3"),1,0,'C');
	$pdf->Cell(8,5,utf8_decode("3"),1,0,'C');
	#Cuarto grado/////////////////////////////////
	$pdf->Cell(8,5,utf8_decode("4"),1,0,'C');
	$pdf->Cell(8,5,utf8_decode("4"),1,0,'C');
	$pdf->Cell(8,5,utf8_decode("4"),1,0,'C');
	#Quinto grado/////////////////////////////////
	$pdf->Cell(8,5,utf8_decode("5"),1,0,'C');
	$pdf->Cell(8,5,utf8_decode("5"),1,0,'C');
	$pdf->Cell(8,5,utf8_decode("5"),1,0,'C');
	#Sexto grado//////////////////////////////////
	$pdf->Cell(8,5,utf8_decode("6"),1,0,'C');
	$pdf->Cell(8,5,utf8_decode("6"),1,0,'C');
	$pdf->Cell(8,5,utf8_decode("6"),1,0,'C');
	#Totales de estudiantes///////////////////////
	$pdf->Cell(8,5,utf8_decode(""),1,0,'C');#Varones
	$pdf->Cell(8,5,utf8_decode(""),1,0,'C');#Hembras
	$pdf->Cell(8,5,utf8_decode(""),1,1,'C');#Total
}
	$pdf->SetFont('Arial','B',10);
	#TOTALES DE ESTUDIANTES DE TODAS LAS SECCIONES
	$pdf->Cell(24,5,utf8_decode("Totales"),1,0,'C');
	#Primer grado////////////////////////////
	$pdf->Cell(8,5,utf8_decode("1"),1,0,'C');#Total de Varones de primer grado
	$pdf->Cell(8,5,utf8_decode("1"),1,0,'C');#Total de Hembras de primer grado
	$pdf->Cell(8,5,utf8_decode("1"),1,0,'C');#Total de Estudiantes de primer grado
	#Segundo grado////////////////////////////
	$pdf->Cell(8,5,utf8_decode("2"),1,0,'C');#Total de Varones de segundo grado
	$pdf->Cell(8,5,utf8_decode("2"),1,0,'C');#Total de Hembras de segundo grado
	$pdf->Cell(8,5,utf8_decode("2"),1,0,'C');#Total de Estudiantes de segundo grado
	#Tercer grado/////////////////////////////////
	$pdf->Cell(8,5,utf8_decode("3"),1,0,'C');#Total de Varones de tercer grado
	$pdf->Cell(8,5,utf8_decode("3"),1,0,'C');#Total de Hembras de tercer grado
	$pdf->Cell(8,5,utf8_decode("3"),1,0,'C');#Total de Estudiantes de tercer grado
	#Quinto grado/////////////////////////////////
	$pdf->Cell(8,5,utf8_decode("5"),1,0,'C');#Total de Varones de cuarto grado
	$pdf->Cell(8,5,utf8_decode("5"),1,0,'C');#Total de Hembras de cuarto grado
	$pdf->Cell(8,5,utf8_decode("5"),1,0,'C');#Total de Estudiantes de cuarto grado
	#Quinto grado/////////////////////////////////
	$pdf->Cell(8,5,utf8_decode("5"),1,0,'C');#Total de Varones de quinto grado
	$pdf->Cell(8,5,utf8_decode("5"),1,0,'C');#Total de Hembras de quinto grado
	$pdf->Cell(8,5,utf8_decode("5"),1,0,'C');#Total de Estudiantes de quinto grado
	#Sexto grado//////////////////////////////////
	$pdf->Cell(8,5,utf8_decode("6"),1,0,'C');#Total de Varones de sexto grado
	$pdf->Cell(8,5,utf8_decode("6"),1,0,'C');#Total de Hembras de sexto grado
	$pdf->Cell(8,5,utf8_decode("6"),1,0,'C');#Total de Estudiantes de sexto grado

	#TOTAL DE ESTUDIANTES DE TODAS LAS SECCIONES
	$pdf->Cell(8,5,utf8_decode(""),1,0,'C');#Varones
	$pdf->Cell(8,5,utf8_decode(""),1,0,'C');#Hembras
	$pdf->Cell(8,5,utf8_decode(""),1,1,'C');#Total
	$pdf->Ln(60);


$pdf->setX(80);
$pdf->Cell(50,5,'Director',0,1,'C');
$pdf->Ln(5);

$pdf->setX(80);
$pdf->Cell(50,5,'_____________________',0,1,'C');


$pdf->SetFont('Arial','B',10);
$pdf->setX(80);
$pdf->Cell(50,5,'Lcdo. '.$licenciado,0,1,'C');
$pdf->Ln(5);







$pdf->SetFont('Arial','B',12);
#Textos horizontales//////////////////////////////////////
#Primer grado
$pdf->TextWithDirection(39,118,utf8_decode('Varones'),'U');
$pdf->TextWithDirection(47,118,utf8_decode('Hembras'),'U');
$pdf->TextWithDirection(55,115,utf8_decode('Total'),'U');
#Segundo grado
$pdf->TextWithDirection(63,118,utf8_decode('Varones'),'U');
$pdf->TextWithDirection(71,118,utf8_decode('Hembras'),'U');
$pdf->TextWithDirection(79,115,utf8_decode('Total'),'U');
#Tercer grado
$pdf->TextWithDirection(86,118,utf8_decode('Varones'),'U');
$pdf->TextWithDirection(94,118,utf8_decode('Hembras'),'U');
$pdf->TextWithDirection(103,115,utf8_decode('Total'),'U');
#Cuarto grado
$pdf->TextWithDirection(111,118,utf8_decode('Varones'),'U');
$pdf->TextWithDirection(119,118,utf8_decode('Hembras'),'U');
$pdf->TextWithDirection(128,115,utf8_decode('Total'),'U');
#Quinto grado
$pdf->TextWithDirection(135,118,utf8_decode('Varones'),'U');
$pdf->TextWithDirection(143,118,utf8_decode('Hembras'),'U');
$pdf->TextWithDirection(152,115,utf8_decode('Total'),'U');
#Sexto grado
$pdf->TextWithDirection(159,118,utf8_decode('Varones'),'U');
$pdf->TextWithDirection(167,118,utf8_decode('Hembras'),'U');
$pdf->TextWithDirection(176,115,utf8_decode('Total'),'U');
#Totales
$pdf->TextWithDirection(183,118,utf8_decode('Varones'),'U');
$pdf->TextWithDirection(192,118,utf8_decode('Hembras'),'U');
$pdf->TextWithDirection(200,115,utf8_decode('Total'),'U');





$pdf->Output();
?>