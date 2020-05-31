<?php
include_once("ex_cabecera_carta.php");
$pdf=new PDF('P','mm','A4'/*array(150,85)*/);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Ln(15);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(100,5,utf8_decode('Estudiante: '),0,0,'L');
$pdf->Cell(40,5,utf8_decode('Grado: '),0,0,'L');
$pdf->Cell(40,5,utf8_decode('Sección: '),0,1,'L');
$pdf->Cell(70,5,utf8_decode('Docente: '),0,0,'L');
$pdf->Cell(100,5,utf8_decode('Titulo de Proyecto de aprendizaje: '),0,1,'L');
$pdf->Cell(40,5,utf8_decode('Fecha: '),0,1,'L');
$pdf->Ln(5);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(50,6,'',0,0,'C');
$pdf->Cell(100,6,utf8_decode('Boletin informativo del II Proyecto de aprendizaje'),5,0,'C');
$pdf->Ln(8);

$pdf->Cell(20,5,utf8_decode('Aréa'),1,0,'C');
$pdf->Cell(125,5,utf8_decode(''),1,0,'C');
$pdf->Cell(10,5,utf8_decode('C'),1,0,'C');
$pdf->Cell(10,5,utf8_decode('Av'),1,0,'C');
$pdf->Cell(10,5,utf8_decode('EP'),1,0,'C');
$pdf->Cell(10,5,utf8_decode('I'),1,1,'C');

$pdf->SetFont('Arial','',10);
#Primera Area/////////////////////////////
$pdf->Cell(20,32,utf8_decode(''),1,0,'C');
#Primera fila de la primera Area
$pdf->SetX(30);
$pdf->Cell(125,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,1,'C');
#Segunda fila
$pdf->SetX(30);
$pdf->Cell(125,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,1,'C');
#Tercera fila
$pdf->SetX(30);
$pdf->Cell(125,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,1,'C');
#cuarta fila
$pdf->SetX(30);
$pdf->Cell(125,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,1,'C');
#Segunda Area/////////////////////////////
$pdf->Cell(20,32,utf8_decode(''),1,0,'C');
#primera fila de la segunda Area
$pdf->SetX(30);
$pdf->Cell(125,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,1,'C');
#Segunda fila
$pdf->SetX(30);
$pdf->Cell(125,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,1,'C');
#Tercera fila
$pdf->SetX(30);
$pdf->Cell(125,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,1,'C');
#cuarta fila
$pdf->SetX(30);
$pdf->Cell(125,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,1,'C');
#Tercera Area/////////////////////////////
$pdf->Cell(20,32,utf8_decode(''),1,0,'C');
#primera fila de la Tercera Area
$pdf->SetX(30);
$pdf->Cell(125,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,1,'C');
#Segunda fila
$pdf->SetX(30);
$pdf->Cell(125,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,1,'C');
#Tercera fila
$pdf->SetX(30);
$pdf->Cell(125,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,1,'C');
#cuarta fila
$pdf->SetX(30);
$pdf->Cell(125,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,1,'C');
#Cuarta Area/////////////////////////////
$pdf->Cell(20,32,utf8_decode(''),1,0,'C');
#primera fila de la Cuarta Area
$pdf->SetX(30);
$pdf->Cell(125,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,1,'C');
#Segunda fila
$pdf->SetX(30);
$pdf->Cell(125,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,1,'C');
#Tercera fila
$pdf->SetX(30);
$pdf->Cell(125,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,1,'C');
#cuarta fila
$pdf->SetX(30);
$pdf->Cell(125,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,1,'C');
#Quinta Area/////////////////////////////
$pdf->Cell(20,16,utf8_decode(''),1,0,'C');
#primera fila de la Quinta Area
$pdf->SetX(30);
$pdf->Cell(125,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,1,'C');
#Segunda fila
$pdf->SetX(30);
$pdf->Cell(125,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,1,'C');
#Ultima Area/////////////////////////////
$pdf->Cell(20,8,utf8_decode(''),1,0,'C');
#primera fila de la Ultima Area
$pdf->SetX(30);
$pdf->Cell(125,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,0,'C');
$pdf->Cell(10,8,utf8_decode(''),1,1,'C');

$pdf->SetFont('Arial','',10);
$pdf->Cell(40,5,'C: Consolidado',0,0,'C');
$pdf->Cell(50,5,'Av: Avanzado',0,0,'C');
$pdf->Cell(50,5,'EP: En proceso',0,0,'C');
$pdf->Cell(50,5,'I: Iniciado',0,1,'C');
$pdf->Ln(2);
$texto_consolidado = utf8_decode("Consolidado (C): Logra la construcción de su aprendizaje en base a las potencialidades previstas del P.A. Avanzado (Av): Se encuentra progresando en su aprendizaje en base a las potencialidades previstas del P.A. En proceso (EP): Avanza en la construcción de su aprendizaje en base a las potencialidades previstas del P.A. Iniciado (I): Se inicia en la construcción de su aprendizaje en base a las potencialidades previstas del P.A.");

$recomendaciones = utf8_decode("recomendaciones: ________________________________________________________________________________________________________________________________________________________________________________________________________________________________________");

$pdf->SetFont('Arial','',8);
$pdf->MultiCell(185,4,$texto_consolidado,0,'J');
$pdf->Ln(5);

$pdf->MultiCell(185,4,$recomendaciones,0,'J');
$pdf->Ln(10);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(60,5,'Directivo',0,0,'C');
$pdf->Cell(60,5,'Sello',0,0,'C');
$pdf->Cell(60,5,'Docente',0,0,'C');










$pdf->Output();
?>