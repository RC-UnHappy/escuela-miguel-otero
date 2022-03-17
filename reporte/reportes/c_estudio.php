<?php
include_once("ex_cabecera_carta.php");
$pdf=new PDF('P','mm','A4'/*array(150,85)*/);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Ln(10);
$pdf->SetFont('Arial','B',12);

$pdf->Cell(50,6,'',0,0,'C');
$pdf->Cell(100,6,utf8_decode('Constancia de estudio'),5,0,'C');
$pdf->Ln(25);

$licenciado="Luis Marin";
$cedula_licenciado = 29629048;
$calificacion = 'D';

$texto = utf8_decode("Quién suscribe Lcdo. ".$licenciado." portador de la Cédula de Identidad Nº "
	.$cedula_licenciado.", Director de la Escuela Básica Bolivariana 'Rómulo Gallegos', Código DEA OD00041808, Ubicada al Final calle 'G', V Etapa Urb. 'La Goajira' del Municipio Páez, estado Portuguesa. Hace constar por medio de la Presente que el (la) Estudiante: ___________________________________, portador (a) de la Cédula de Identidad Nº________________, Natural de: _____________________Estado: ______________________ Nacido el __________________, tiene ___ años de edad. Está inscrito(a) y cursa el ____ Grado Sección: ___. De Educación Primaria en este plantel. Año Escolar: ________ ");

$duracion = utf8_decode("Constancia que se expide a solicitud de parte interesada en Acarigua a los ___ días del Mes de ______ del Año ______. ");


$pdf->SetFont('Arial','',10);
$pdf->setX(30);
$pdf->MultiCell(150,6,$texto,0,'J');
$pdf->Ln(20);

$pdf->setX(30);
$pdf->MultiCell(150,6,$calificacion,0,'J');
$pdf->Ln(20);

$pdf->setX(30);
$pdf->MultiCell(150,6,$duracion,0,'J');
$pdf->Ln(70);


$pdf->SetFont('Arial','B',10);
$pdf->setX(30);
$pdf->Cell(50,5,'Director',0,1,'C');
$pdf->Ln(5);

$pdf->setX(30);
$pdf->Cell(50,5,'_____________________',0,1,'C');



$pdf->setX(30);
$pdf->Cell(50,5,'Lcdo. '.$licenciado,0,1,'C');
$pdf->Ln(5);

$pdf->setY(232);
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