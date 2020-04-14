<?php
include_once("ex_cabecera_carta.php");
$pdf=new PDF('P','mm','A4'/*array(150,85)*/);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Ln(10);

$republica = utf8_decode("      República Bolivariana De Venezuela
						  Ministerio del Poder Popular para la Educación
						Vice ministerio de Participación y Apoyo Académico
					   Dirección General de Registro y Control de Académico ");


$pdf->SetFont('Arial','',10);
$pdf->setX(55);
$pdf->MultiCell(100,6,$republica,0,'C');
$pdf->Ln(10);


$pdf->SetFont('Arial','B',12);
$pdf->Cell(50,6,'',0,0,'C');
$pdf->Cell(100,6,utf8_decode('Constancia de inscripción'),5,0,'C');
$pdf->Ln(25);

$licenciado="Luis Marin";
$cedula_licenciado = 29629048;

$texto = utf8_decode("Quién suscribe Lcdo. ".$licenciado.", portador (a) de la Cédula de Identidad Nº "
	.$cedula_licenciado.", Director (a) de la Escuela Básica Bolivariana 'Miguel Otero Silva', certifica por medio de la presente que el (la) estudiante:___________________________________________, portador(a) de la Cédula de Identidad Nº ___________________, nacido(a) en __________________, fecha  ___________, cursó y aprobó el ______________________Grado  del Nivel de Educación Primaria, donde alcanzó las competencias previstas para el grado, correspondiéndole  la escala  alfabética _____________ durante el Año Escolar  _____________________ y fue promovido al  _____________________ grado, previo cumplimiento de los requisitos exigidos en la normativa legal vigente.
");

$duracion = utf8_decode("Certificado que se expide en Acarigua a los ____ días del mes de _____________ del _________. ");

$pdf->SetFont('Arial','',10);
$pdf->setX(30);
$pdf->MultiCell(150,7,$texto,0,'J');
$pdf->Ln(20);

$pdf->setX(30);
$pdf->MultiCell(150,6,$duracion,0,'J');
$pdf->Ln(50);

$pdf->SetFont('Arial','B',10);
$pdf->setX(30);
$pdf->Cell(50,5,'Director',0,1,'C');
$pdf->Ln(5);

$pdf->setX(30);
$pdf->Cell(50,5,'_____________________',0,1,'C');



$pdf->setX(30);
$pdf->Cell(50,5,'Lcdo. '.$licenciado,0,1,'C');
$pdf->Ln(5);


$pdf->setX(80);
$pdf->Cell(50,5,'Sello',0,1,'C');


$pdf->setY(234);
$pdf->setX(130);
$pdf->Cell(50,5,'Docente de grado',0,1,'C');
$pdf->Ln(5);

$pdf->setX(130);
$pdf->Cell(50,5,'_____________________',0,1,'C');
$pdf->setX(130);
$pdf->Cell(50,5,'Maestra. ',0,1,'C');
$pdf->Ln(5);





$pdf->Output();
?>