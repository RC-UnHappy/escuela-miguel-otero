<?php 
include_once("ex_aspectos.php");

$pdf=new PDF('L','mm', 'legal');
$pdf->AliasNbPages();
$pdf->AddPage();
// $pdf->Ln(10);
$pdf->SetFont('Arial','B',10);

#Textos horizontales
$pdf->TextWithDirection(131,64,utf8_decode('Tiene Todas Las'),'U');
$pdf->TextWithDirection(136,58,utf8_decode('Vacunas'),'U');

$pdf->TextWithDirection(149,58,utf8_decode('Es Alérgíco'),'U');




$pdf->Cell(45,6,utf8_decode('Año Escolar: 2019-2020'),0,0,'L');
$pdf->Cell(20,6,utf8_decode('Grado: 1'),0,0,'L');
$pdf->Cell(25,6,utf8_decode('Sección: "B"'),0,0,'L');
$pdf->Cell(40,6,utf8_decode('Docente: "Roberto Alonso Tercero"'),0,0,'L');
$pdf->setX(135);
$pdf->Cell(100,6,utf8_decode('Aspecto Fisiológico'),5,0,'C');
$pdf->Ln(10);


$pdf->cell(65,40,'Nombre y apellido del Estudiante',1,0,'C');
$pdf->cell(10,40,'Edad',1,0,'C');
$pdf->cell(10,40,'Sexo',1,0,'C');
$pdf->cell(15,40,'Peso',1,0,'C');
$pdf->cell(15,40,'Talla',1,0,'C');
$pdf->cell(15,40,'',1,0,'C');
$pdf->cell(15,40,'',1,0,'C');
$pdf->cell(60,10,'Diversidad Funcional que presenta',1,0,'C');
$pdf->cell(15,40,'C',1,0,'C');
$pdf->cell(20,40,'Alimentos',1,0,'C');
$pdf->cell(15,40,utf8_decode('Útiles'),1,0,'C');
$pdf->cell(80,10,'Enfermedad que Padece Especifique',1,1,'C'); #Salto de linea
$pdf->setX(155); #Truco para la siguiente celda
$pdf->cell(20,30,utf8_decode("Motora"),1,0,'C');
$pdf->cell(20,30,utf8_decode("Autista"),1,0,'C');
$pdf->cell(20,10,utf8_decode("Síndrome"),0,1,'C'); #Salto de linea
$pdf->setX(195); #Truco para la siguiente celda
$pdf->cell(20,10,utf8_decode("De"),0,1,'C'); #Salto de linea
$pdf->setX(195); #Truco para la siguiente celda
$pdf->cell(20,10,utf8_decode("Asperght"),0,0,'C');
$pdf->setY(40);
$pdf->setX(265);
$pdf->cell(23,30,utf8_decode("Respiratorias"),1,0,'C');
$pdf->setY(40);
$pdf->setX(288);
$pdf->cell(19,30,utf8_decode("Renal"),1,0,'C');
$pdf->setY(40);
$pdf->setX(307);
$pdf->cell(19,30,utf8_decode("Visual"),1,0,'C');
$pdf->setY(40);
$pdf->setX(326);
$pdf->cell(19,30,utf8_decode("Auditiva"),1,1,'C'); #Salto de linea.

# resultados:
$rs = 24; # resultados de la base de datos ej: 15

$pdf->SetFont('Arial','',10); # letra normal
for($i=0; $i<=$rs ; $i++){
	$pdf->cell(65,5,'Estudiante '.$i,1,0,'C'); #Estudiante
	$pdf->cell(10,5,'18',1,0,'C'); #Edad
	$pdf->cell(10,5,'M',1,0,'C'); #Sexo
	$pdf->cell(15,5,'40,00',1,0,'C'); #Peso
	$pdf->cell(15,5,'10',1,0,'C'); #Talla
	$pdf->cell(15,5,'Si',1,0,'C'); #Vacuna
	$pdf->cell(15,5,'No',1,0,'C'); #Alergico
	$pdf->cell(20,5,'',1,0,'C');   #Diversidad funcional motora
	$pdf->cell(20,5,'',1,0,'C');   #Diversidad funcional autista
	$pdf->cell(20,5,'',1,0,'C');   #Diversidad funcional sindrome
	$pdf->cell(15,5,'',1,0,'C');   #C "No se que mierda es esa"
	$pdf->cell(20,5,'Si',1,0,'C'); #Alimentos
	$pdf->cell(15,5,'Si',1,0,'C'); #Utiles
	$pdf->cell(23,5,'X',1,0,'C');  #Enfermedad respiratoria
	$pdf->cell(19,5,'',1,0,'C');   #Enfermedad Renal
	$pdf->cell(19,5,'',1,0,'C');   #Enfermedad visual
	$pdf->cell(19,5,'',1,1,'C');   #Enfermedad auditiva   "Salto de linea"


}



$pdf->Output();
?>