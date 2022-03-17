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

#Establece la zona horaria
setlocale(LC_TIME, "spanish");
date_default_timezone_set('America/Caracas');

$director = $BoletinFinal->traerdatosdirector();

// Datos de la institución
$datos_institucion = $BoletinFinal->datos_institucion();

// Varibles que se van a recibir por get necesarias para generar el reporte
$datos_estudiante = $BoletinFinal->traerpersonaestudiante($_GET['idpersona'], $_GET['idestudiante']);


list($year, $month, $day) = explode('-', $datos_estudiante['f_nac']);
$fechaNacimientoEstudiate = $day.'-'.$month.'-'.$year;

$grado = isset($_GET['grado']) ? $_GET['grado'] : '';

$literal = isset($_GET['literal']) ? $_GET['literal'] : '';

$periodo_escolar = $BoletinFinal->consultarperiodo();
$periodo_escolar = !empty($periodo_escolar) ? $periodo_escolar['periodo'] : '';

$teacherId = isset($_GET['teacherId']) ? $_GET['teacherId'] : '';

$planificacion = $BoletinFinal->traerplanificaciones($periodo_escolar, $teacherId);

$planificacion = $planificacion->fetch_object();

// // Varibles que se van a recibir por get necesarias para generar el reporte
// $idplanificacion = isset($_GET['idplanificacion']) ? limpiarCadena($_GET['idplanificacion']) : '';


// // Datos principales del reporte
// $datos_reporte = $AspectoFisiologico->datos_reporte($idplanificacion);

// // Datos de la planificación
// $datos_planificacion = $AspectoFisiologico->datos_planificacion($idplanificacion);

// // Se establece la zona horaria
// date_default_timezone_set('America/Caracas');
// $fecha = date('Y-m-d'); 

include_once("cabecera-boleta-promocion.php");

$pdf=new PDF('P','mm','A4'/*array(150,85)*/);
    $pdf->codigo_qr = $datos_institucion['codigo_qr'];
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Ln(25);
$pdf->SetFont('Arial','B',18);

$pdf->Cell(50,6,'',0,0,'C');
$pdf->Cell(94,6, strtoupper( utf8_decode('Constancia de promoción') ),5,1,'C');
$pdf->Cell(195,6, strtoupper( utf8_decode('en el nivel de educación primaria') ),5,0,'C');
$pdf->Ln(25);


$licenciado="Luis Marin";
$cedula_licenciado = 29629048;

$pdf->SetFont('Arial','',10);
$texto = utf8_decode('Quien suscribe, '.( ($director['genero'] == 'M') ? 'LCDO.' : 'LCDA.').' '.strtoupper( $director['p_nombre'].' '.$director['p_apellido'] ).', titular de la Cédula de Identidad Nº '.$director['cedula'].', en su condición de '.($director['genero'] == 'M' ? 'Director' : 'Directora').' de la '.strtoupper($datos_institucion['nombre']).', ubicada '.$datos_institucion['direccion'].', certifica por medio de la presente que '.( ($datos_estudiante['genero'] == 'M') ? 'el' : 'la').' estudiante: '.ucwords($datos_estudiante['p_nombre_estudiante'].' '.$datos_estudiante['s_nombre_estudiante'].' '.$datos_estudiante['p_apellido_estudiante'].' '.$datos_estudiante['s_apellido_estudiante']).', '.( ($datos_estudiante['genero'] == 'M') ? 'portador' : 'portadora').' de la Cédula de Identidad Nº '.$datos_estudiante['cedula'].', '.( ($datos_estudiante['genero'] == 'M') ? 'nacido' : 'nacida').' en: '.ucfirst($datos_estudiante['municipio']).', fecha '.$fechaNacimientoEstudiate.', cursó y aprobó el '.$grado .' Grado  del Nivel de Educación Primaria, donde alcanzó las competencias previstas para el grado, correspondiéndole  la escala  alfabética "'.strtoupper($literal).'" durante el Año Escolar '.$periodo_escolar.'  y fue promovido al  '.($grado+1).' grado, previo cumplimiento de los requisitos exigidos en la normativa legal vigente.');

$duracion = utf8_decode('Certificado que se expide en Acarigua a los '.date('d').' días del mes de '.ucfirst(strftime("%B")).' del '.date('Y').'.');


$pdf->setX(25); 
#$pdf->setY(50);
$pdf->Multicell(150,6,$texto,0,'J');
$pdf->ln(20);

$pdf->setX(25);
$pdf->Multicell(150,6,$duracion,0,'J');
$pdf->ln(20);

$pdf->SetFont('Arial','B',12);
$pdf->setX(25);
$pdf->cell(100,5,"PLANTEL",'LRT',1,'C');
$pdf->setX(25);
$pdf->SetFont('Arial','B',8);
$pdf->cell(100,5,"(Para Validez a Nivel Nacional)",'LRB',0,'C');

$pdf->SetY(176);
$pdf->SetFont('Arial','B',12);
$pdf->setX(125.2);

$pdf->cell(55,5,'AUTORIDAD EDUCATIVA','LRT',1,'C');
$pdf->SetFont('Arial','B',8);
$pdf->setX(125.2);
$pdf->cell(55,5,'(Para Validez a Nivel Internacional)','LRB',1,'C');
$pdf->setX(25);
$pdf->cell(50,5,'DOCENTE DE AULA',1,0,'C');
$pdf->cell(50.1,5,'DIRECTOR',1,0,'C');
$pdf->cell(55,5,'DIRECTOR',1,1,'C');


// $texto_docente = utf8_decode(
// 			"\n"."Nombre: ".$nombre_docente     ."\n".
// 				 "C.I: "        .$cedula_docente."\n".
// 				 "Firma:"                       ."\n".
// 				 "_______________
// 				 "            );

// $texto_director= utf8_decode(
// 			"\n"."Nombre: ".$licenciado     ."\n".
// 				 "C.I: "        .$cedula_licenciado."\n".
// 				 "Firma:"                        ."\n".
// 				 "_______________
// 				 "            );

// $texto_director_eductativa= utf8_decode(
// 			"\n"."Nombre: "     .$licenciado  ."\n".
// 				 "C.I: "        .$cedula_licenciado  ."\n".
// 				 "Firma:"                                    ."\n".
// 				 "_______________
// 				 "            );

$pdf->SetFont('Arial','B',8);
$pdf->setX(25);
$pdf->Multicell(50,10,utf8_decode('NOMBRE: '. strtoupper($planificacion->p_nombre.' '.$planificacion->p_apellido."\n". 'cédula: '. $planificacion->cedula."\n". 'firma: '."\n". '______________________________'  )),1,'J');

$pdf->SetY(191);
$pdf->setX(75);

$pdf->Multicell(50,10,utf8_decode('NOMBRE: '. strtoupper($director['p_nombre'].' '.$director['p_apellido'] ."\n".'cédula: '. $director['cedula']."\n". 'firma: '."\n". '______________________________'  )),1,'J');

$pdf->SetY(191);
$pdf->setX(125);

$pdf->Multicell(55,10,utf8_decode('NOMBRE: '."\n".'CÉDULA: '."\n". 'FIRMA: '."\n". '______________________________'),1,'J');

// $pdf->setY(170);
// $pdf->setX(80);
// $pdf->Multicell(50,5,$texto_director,1,'J');
// $pdf->setY(170);
// $pdf->setX(130);
// $pdf->Multicell(50,5,$texto_director_eductativa,1,'J');


$pdf->Output(utf8_decode('boletin-promocion-' . $datos_estudiante['p_nombre_estudiante'].'-'.$datos_estudiante['p_apellido_estudiante'].'-'.$planificacion->grado.'-grado.pdf'),'D',true);

}
else{
  echo "No tiene permiso para visualizar el reporte";
}

}
ob_end_flush();

