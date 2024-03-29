<?php
include_once("ex_cabecera_carta.php");
$pdf=new PDF('P','mm','A4'/*array(150,85)*/);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Ln(10);
$pdf->SetFont('Arial','B',12);

$pdf->Cell(50,6,'',0,0,'C');
$pdf->Cell(100,6,utf8_decode('Boleta de retiro'),5,0,'C');
$pdf->Ln(25);

$licenciado="Luis Marin";
$cedula_licenciado = 29629048;

$texto = utf8_decode("Quién suscribe Lcdo. ".$licenciado.", portador de la Cédula de Identidad Nº "
	.$cedula_licenciado.", Director de la Escuela Básica Bolivariana 'Rómulo Gallegos', Código DEA OD00041808, Ubicada al Final calle 'G', V Etapa Urb. 'La Goajira' del Municipio Páez, estado Portuguesa, hace constar por medio de la presente que el (la) estudiante: ________________________________________, titular de la Cédula de Identidad Nº _________________. Natural de__________________ Estado __________________de ________________ Años de edad, quién cursa_______ o cursó_______  Grado de Educación Primaria en esta Institución, Año escolar__________ fue retirado (a),  por su Representante Legal: _______________________________________ Cédula de Identidad Nº _______________. Causa del Retiro: ___________________________________________________.
		");

$duracion = utf8_decode("Constancia que se expide a solicitud de parte interesada en Acarigua a los ___ días del Mes de ______ del Año ______. ");


$pdf->SetFont('Arial','',10);
$pdf->setX(30);
$pdf->MultiCell(150,6,$texto,0,'J');
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