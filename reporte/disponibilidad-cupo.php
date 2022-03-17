<?php
#Se activa el almacenamiento en el buffer
ob_start();
if (strlen(session_id()) < 1) 
  session_start();

if (!isset($_SESSION['idusuario'])) {
  echo "Debe ingresar al sistema correctamete para visualizar el reporte";
}
else{
if (isset($_SESSION['permisos']['inscripcion']) && in_array('ver' , $_SESSION['permisos']['inscripcion'])) {

#Se incluye el modelo de Inscripcion
require_once '../modelos/inscripcion/Inscripcion.php';

#Se instancia el objeto de Inscripcion
$Inscripcion = new Inscripcion();

// Datos de la institución
$datos_institucion = $Inscripcion->traerdatosinstitucion();
if ( empty($datos_institucion) ) die('Debe rellenar los datos de la institución en "Configuración" -> "Institución", para poder generar el reporte.'); 

$director = $Inscripcion->traerdatosdirector();

if ( empty($director) ) die('Debe establecer el director de la institución en "Personal", para poder generar el reporte.'); 

// Varibles que se van a recibir por get necesarias para generar el reporte
$grado = isset($_GET['grado']) ? limpiarCadena($_GET['grado']) : '';


$periodo_escolar = $Inscripcion->consultarperiodo();
$periodo_escolar = !empty($periodo_escolar) ? $periodo_escolar['periodo'] : '';

if ( empty($periodo_escolar) ) die('Debe establecer el período escolar en "Operaciones" -> "Período escolar", para poder generar el reporte.'); 

#Establece la zona horaria
setlocale(LC_TIME, "spanish");
date_default_timezone_set('America/Caracas');

include_once("cabecera-disponibilidad-cupo.php");
$pdf=new PDF('P','mm','A4'/*array(150,85)*/);
    $pdf->codigo_qr = $datos_institucion['codigo_qr'];
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Ln(10);
$pdf->SetFont('Arial','B',12);

$pdf->Cell(45,6,'',0,0,'C');
$pdf->Cell(100,6,utf8_decode('Disponibilidad de cupo'),5,1,'C');
$pdf->Ln(25);


$texto = utf8_decode("Quién suscribe ".(($director['genero'] == 'M') ? 'Lcdo. ' : 'Lcda. ')." ".ucwords($director['p_nombre'].' '.$director['p_apellido']).", portador de la Cédula de Identidad Nº "
	.$director['cedula'].", en mi carácter de ".($director['genero'] == 'M' ? 'Director' : 'Directora')." de la ".ucwords($datos_institucion['nombre']).", ubicada en ".$datos_institucion['direccion'].", Código DEA ".$datos_institucion['cod_dea'].", hago constar por medio de la presente que existe disponibilidad de cupo para el (la) estudiante: ________________________________________ , siendo su representante legal ________________________________________ , C.I _____________________ , para el ".$grado."º grado, en el año escolar ".$periodo_escolar.".
		");

$duracion = utf8_decode("Constancia que se expide a solicitud de parte interesada a los ".date('d')." días del Mes de ".ucfirst(strftime("%B"))." del Año ".date('Y').". ");


$pdf->SetFont('Arial','',10);
$pdf->setX(30);
$pdf->MultiCell(150,6,$texto,0,'J');
$pdf->Ln(20);


$pdf->setX(30);
$pdf->MultiCell(150,6,$duracion,0,'J');
$pdf->Ln(70);


$pdf->SetFont('Arial','B',10);

$pdf->setX(80);
$pdf->Cell(50,5,'_____________________',0,1,'C');

$pdf->setX(80);
$pdf->Cell(50,5, ($director['genero'] == 'M') ? 'Lcdo. ' : 'Lcda. '.$director['p_nombre'].' '.$director['p_apellido'],0,1,'C');
$pdf->Ln(1);

$pdf->setX(80);
$pdf->Cell(50,5,($director['genero'] == 'M') ? 'Director' : 'Directora',0,1,'C');
$pdf->Ln(5);

$pdf->Output(utf8_decode('disponibilidad-de-cupo-para-'.$grado.'-grado'.'.pdf'),'I',true);


}
else{
  echo "No tiene permiso para visualizar el reporte";
}

}
ob_end_flush();
?>