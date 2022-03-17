<?php
include_once("ex_cabecera_carta.php");
$pdf=new PDF('P','mm','A4'/*array(150,85)*/);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Ln(10);
$pdf->SetFont('Arial','B',12);

$pdf->Cell(50,6,'',0,0,'C');
$pdf->Cell(100,6,utf8_decode('Carta de promoción en el nivel de educación primaria'),5,0,'C');
$pdf->Ln(25);


$licenciado="Luis Marin";
$cedula_licenciado = 29629048;

$pdf->SetFont('Arial','',10);
$texto = utf8_decode("Quien suscribe, LCDO ".$licenciado.", titular de la Cédula de Identidad Nº V.-".$cedula_licenciado. ", en su condición de Director(a) de la ESCUELA BÁSICA BOLIVARIANA 'RÓMULO GALLEGOS', ubicada al Final de la Calle G de la Urbanización La Goajira II, Acarigua Estado Portuguesa;  certifica por medio de la presente que el (la) estudiante FENG MORENO LIANG JESUS, portador(a) de la Cédula de Identidad Nº 26.273.102, nacido(a) en: ACARIGUA, ESTADO PORTUGUESA  fecha 26-02-1998 cursó y aprobó el 1er Grado  del Nivel de Educación Primaria, donde alcanzó las competencias previstas para el grado, correspondiéndole  la escala  alfabética 'B' durante el Año Escolar 2005-2006  y fue promovido al  2do grado, previo cumplimiento de los requisitos exigidos en la normativa legal vigente.");

$duracion = utf8_decode("Certificado que se expide en Acarigua a los 25 días del mes de Enero  del 2.018.");


$pdf->setX(30); 
#$pdf->setY(50);
$pdf->Multicell(150,6,$texto,0,'J');
$pdf->ln(20);

$pdf->setX(30);
$pdf->Multicell(150,6,$duracion,0,'J');
$pdf->ln(20);

$pdf->SetFont('Arial','B',12);
$pdf->setX(30);
$pdf->cell(100,10,"Plantel (Para validez a nivel nacional)",1,0,'C');
$pdf->cell(50,10,'Autoridad educativa',1,1,'C');
$pdf->setX(30);
$pdf->cell(50,5,'Docente de aula',1,0,'C');
$pdf->cell(50,5,'Director',1,0,'C');
$pdf->cell(50,5,'Director',1,1,'C');

$nombre_docente = "Carlos Diamon";
$cedula_docente = 26992848;



$texto_docente = utf8_decode(
			"\n"."Nombre: ".$nombre_docente     ."\n".
				 "C.I: "        .$cedula_docente."\n".
				 "Firma:"                       ."\n".
				 "_______________
				 "            );

$texto_director= utf8_decode(
			"\n"."Nombre: ".$licenciado     ."\n".
				 "C.I: "        .$cedula_licenciado."\n".
				 "Firma:"                        ."\n".
				 "_______________
				 "            );

$texto_director_eductativa= utf8_decode(
			"\n"."Nombre: "     .$licenciado  ."\n".
				 "C.I: "        .$cedula_licenciado  ."\n".
				 "Firma:"                                    ."\n".
				 "_______________
				 "            );

$pdf->SetFont('Arial','',10);
$pdf->setX(30);
$pdf->Multicell(50,5,$texto_docente,1,'J');
$pdf->setY(170);
$pdf->setX(80);
$pdf->Multicell(50,5,$texto_director,1,'J');
$pdf->setY(170);
$pdf->setX(130);
$pdf->Multicell(50,5,$texto_director_eductativa,1,'J');





$pdf->Output();
?>