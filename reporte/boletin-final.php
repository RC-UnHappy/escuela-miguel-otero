<?php
#Se activa el almacenamiento en el buffer
ob_start();
if (strlen(session_id()) < 1) 
  session_start();

if (!isset($_SESSION['idusuario'])) {
  echo "Debe ingresar al sistema correctamete para visualizar el reporte";
}
else{
if (isset($_SESSION['permisos']['boletin-final']) && in_array('ver' , $_SESSION['permisos']['boletin-final'])) {

#Se incluye el modelo de BoletinFinal
require_once '../modelos/BoletinFinal.php';

#Se instancia el objeto de BoletinFinal
$BoletinFinal = new BoletinFinal();

// Varibles que se van a recibir por get necesarias para generar el reporte
$idplanificacion = isset($_GET['idplanificacion']) ? limpiarCadena($_GET['idplanificacion']) : '';

$idestudiante = isset($_GET['idestudiante']) ? limpiarCadena($_GET['idestudiante']) : '';

// $periodo_escolar = $BoletinParcial->consultarperiodo();
// $periodo_escolar = !empty($periodo_escolar) ? $periodo_escolar['periodo'] : '';


// Datos principales del reporte como nombre del estudiante, seccion, grado
$datos_reporte = $BoletinFinal->datos_reporte($idplanificacion, $idestudiante);

// Datos de la institución
$datos_institucion = $BoletinFinal->datos_institucion();


#Establece la zona horaria
setlocale(LC_TIME, "spanish");
// Se establece la zona horaria
date_default_timezone_set('America/Caracas');
$fecha = date('Y-m-d');



include_once("cabecera-boletin-final.php");
$pdf=new PDF('P','mm','A4'/*array(150,85)*/);
    $pdf->codigo_qr = $datos_institucion['codigo_qr'];
$pdf->AliasNbPages();

// $pdf->periodo_escolar = $periodo_escolar;
$pdf->nombre_institucion = $datos_institucion['nombre'];

// Se formatea la fecha de nacimiento del estudiante
$newDate = date("d-m-Y", strtotime($datos_reporte["f_nac"]));
$pdf->AddPage();
$pdf->Ln(17);


$pdf->SetFont('Arial','B',12);
$pdf->setX(55);
$pdf->Cell(100,5,utf8_decode(strtoupper($datos_institucion['nombre'])),0,1,'C');
$pdf->SetFont('Arial','',8);
$pdf->Ln(3);
#Cuadro de codigos
$pdf->setX(62);
$pdf->Cell(40,5,utf8_decode("Código DEA"),1,0,'L');
$pdf->Cell(40,5,$datos_institucion['cod_dea'],1,1,'C');
$pdf->setX(62);
$pdf->Cell(40,5,utf8_decode("Código de Dependencia"),1,0,'L');
$pdf->Cell(40,5,$datos_institucion['cod_dependencia'],1,1,'C');
$pdf->setX(62);
$pdf->Cell(40,5,utf8_decode("Código SMEE"),1,0,'L');
$pdf->Cell(40,5,$datos_institucion['cod_smee'],1,1,'C');

$pdf->Ln(3);
#Datos de identificacion del estudiante
$pdf->SetFont('Arial','B',10);
$pdf->setX(55);
$pdf->Cell(100,5,utf8_decode('DATOS DE IDENTIFICIÓN DEL ESTUDIANTE'),0,1,'C');
$pdf->Ln(5);

$pdf->SetFont('Arial','',10);
$pdf->setX(30);
$pdf->Cell(190,5,utf8_decode("Apellido y Nombres: ".ucwords($datos_reporte['p_apellido_estudiante'].' '.$datos_reporte['s_apellido_estudiante'].' '.$datos_reporte['p_nombre_estudiante'].' '.$datos_reporte['s_nombre_estudiante'])),0,1,'L');
$pdf->setX(30);
$pdf->Cell(95,5,utf8_decode("Fecha de Nacimiento: ".$newDate),0,0,'L');
$pdf->Cell(90,5,utf8_decode("Cedula de Identidad: ". $datos_reporte['cedula']),0,1,'L');
$pdf->setX(30);
$pdf->Cell(95,5,utf8_decode("Lugar de Nacimiento: ". $datos_reporte['municipio']),0,0,'L');
$pdf->Cell(90,5,utf8_decode("Estado: ".$datos_reporte['estado']),0,1,'L');
$pdf->setX(30);
$pdf->Cell(20,5,utf8_decode("Grado: ". $datos_reporte['grado']),0,0,'L');
$pdf->Cell(25,5,utf8_decode("Sección: ". '"'.$datos_reporte['seccion'].'"'),0,0,'L');
$pdf->Cell(20,5,utf8_decode("Año Escolar: ". $datos_reporte['periodo']),0,1,'L');
$pdf->Ln(15);


$pdf->SetFont('Arial','B',10);
$pdf->setX(55);
$pdf->Cell(100,5,utf8_decode('INFORME DESCRIPTIVO FINAL'),0,1,'C');
$pdf->Ln(10);

$texto_descriptivo = utf8_decode($datos_reporte['descriptivo_final']);


$pdf->SetFont('Arial','',10);
$pdf->setX(30);
$pdf->MultiCell(150,4,$texto_descriptivo,0,'J');
// $pdf->Ln(2);
// $pdf->setX(55);
// $pdf->Cell(100,5,utf8_decode("Excelente el trabajo, felicitaciones!"),0,1,'C');
$pdf->Ln(15);


$pdf->SetFont('Arial','',10);
$pdf->setX(30);
$pdf->Cell(73,5,utf8_decode("EXPRESIÓN LITERAL:      ".$datos_reporte['literal']),0,1,'L');
$pdf->setX(30);
$pdf->MultiCell(150,5,utf8_decode("INTERPRETACIÓN: ".$datos_reporte['interpretacion']),0,'L');

$pdf->Ln(30);

$pdf->SetY(-60);
$pdf->setX(30);
$pdf->SetFont('Arial','',10);
$pdf->Cell(25,5,'Directivo',0,0,'L');
$pdf->setX(160);
$pdf->Cell(25,5,'Docente',0,0,'C');
$pdf->Ln(10);
$pdf->setX(50);
$pdf->Cell(100,5,'Acarigua,' . date('d'). ' de ' .ucfirst(strftime("%B")). ' de ' . date('Y') ,0,0,'C');
$pdf->Ln(10);
$pdf->SetFont('Arial','B',10);
$pdf->setX(55);
$pdf->Cell(100,5,utf8_decode('28 DE MARZO DE 2019 BICENTENARIO DEL CONGRESO DE AGOSTURA '),0,1,'C');

$pdf->Output(utf8_decode($datos_reporte['grado'].'_'.$datos_reporte['seccion'].'_'.$datos_reporte['cedula'].'_'.$datos_reporte['p_nombre_estudiante'].'_'.$datos_reporte['p_apellido_estudiante'].'.pdf'),'D',true);


}
else{
  echo "No tiene permiso para visualizar el reporte";
}

}
ob_end_flush();
?>