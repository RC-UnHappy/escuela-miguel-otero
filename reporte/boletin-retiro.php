<?php
#Se activa el almacenamiento en el buffer
ob_start();
if (strlen(session_id()) < 1) 
  session_start();

if (!isset($_SESSION['idusuario'])) {
  echo "Debe ingresar al sistema correctamete para visualizar el reporte";
}
else{
if ( isset($_SESSION['permisos']['inscripcion']) && in_array('ver' , $_SESSION['permisos']['inscripcion']) || isset($_SESSION['permisos']['estudiante'])  && in_array('ver' , $_SESSION['permisos']['estudiante']) ) {

#Se incluye el modelo de Estudiante
require_once '../modelos/Estudiante.php';

#Se instancia el objeto de Estudiante
$EstudianteReporte = new Estudiante();

// Datos de la institución
$datos_institucion = $EstudianteReporte->traerdatosinstitucion();

$director = $EstudianteReporte->traerdatosdirector();

// Varibles que se van a recibir por get necesarias para generar el reporte
$datos_estudiante = $EstudianteReporte->traerpersonaestudiante($_GET['idpersona'], $_GET['idestudianteretiro']);

$periodo_escolar = $EstudianteReporte->consultarperiodo();
$periodo_escolar = !empty($periodo_escolar) ? $periodo_escolar['periodo'] : '';

list($anoN, $mesN, $diaN) = explode('-', $datos_estudiante['f_nac']);
list($anoA, $mesA, $diaA) = explode('-', date('Y-m-d'));

if ($mesN == $mesA) {
 	if ($diaN == $diaA) {
    	$edad = $anoA - $anoN;
	}
	elseif ($diaN < $diaA) {
		$edad = $anoA - $anoN;
	}
	else {
		$edad = ($anoA - $anoN) - 1;
	}
}
elseif ($mesN > $mesA ) {
	$edad = ($anoA - $anoN) - 1;
}
else {
	$edad = ($anoA - $anoN);  
}


#Establece la zona horaria
setlocale(LC_TIME, "spanish");
date_default_timezone_set('America/Caracas');

include_once("cabecera-boletin-retiro.php");
$pdf=new PDF('P','mm','A4'/*array(150,85)*/);
		$pdf->codigo_qr = $datos_institucion['codigo_qr'];
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Ln(10);
$pdf->SetFont('Arial','B',12);

$pdf->Cell(45,6,'',0,0,'C');
$pdf->Cell(100,6,utf8_decode('Boleta de retiro'),5,1,'C');
$pdf->Ln(25);

// .(($director['genero'] == 'M') ? 'Lcdo. ' : 'Lcda. ').' '.ucwords($director['p_nombre'].' '.$director['p_apellido']).', portador de la Cédula de Identidad Nº '
// 	.$director['cedula'].', '.($director['genero'] == 'M' ? 'Director' : 'Directora').' de la '.ucwords($datos_institucion['nombre']).', Código DEA '.$datos_institucion['cod_dea'].', ubicada en '.$datos_institucion['direccion'].', hace constar por medio de la presente que '.($datos_estudiante['genero'] == 'M') ? 'el' : 'la'.' estudiante: '.$datos_estudiante['p_nombre'].' '.$datos_estudiante['s_nombre'].' '.$datos_estudiante['p_apellido'].' '.$datos_estudiante['s_apellido'].', titular de la cédula de identidad Nº '.$datos_estudiante['cedula'].', natural de '.$datos_estudiante['municipio'].' estado '.$datos_estudiante['estado'].' de '.$edad.' años de edad, quien '.($condicion_inscripcion == 'CURSANDO') ? 'cursa' : 'cursó'.' '.$ultimo_grado_cursado.' grado de educación primaria en esta institución, año escolar '.$periodo_escolar.' fue '.($datos_estudiante['genero'] == 'M') ? 'retirado' : 'retirada'.', por su representante legal: '.$nombre_completo_representante.' cédula de identidad Nº '.$cedula_representante.'. Causa del retiro '.$causa_retiro

$texto = utf8_decode('Quién suscribe '.( ($director['genero'] == 'M') ? 'Lcdo. ' : 'Lcda.').' '.ucwords( $director['p_nombre'].' '.$director['p_apellido'] ).', portador de la Cédula de Identidad Nº '.$director['cedula'].', '.($director['genero'] == 'M' ? 'Director' : 'Directora').' de la '.ucwords($datos_institucion['nombre']).', Código DEA '.$datos_institucion['cod_dea'].', ubicada en '.$datos_institucion['direccion'].', hace constar por medio de la presente que '.( ($datos_estudiante['genero'] == 'M') ? 'el' : 'la').' estudiante: '.$datos_estudiante['p_nombre_estudiante'].' '.$datos_estudiante['s_nombre_estudiante'].' '.$datos_estudiante['p_apellido_estudiante'].' '.$datos_estudiante['s_apellido_estudiante'].', titular de la cédula de identidad Nº '.$datos_estudiante['cedula'].', natural de '.$datos_estudiante['municipio'].' estado '.$datos_estudiante['estado'].' de '.$edad.' años de edad, quien '.( ($_GET['condicion'] == 'CURSANDO') ? 'cursa' : 'cursó').' '.$_GET['ultimo_grado_cursado'].'º grado de educación primaria en esta institución, año escolar '.$periodo_escolar.' fue '.( ($datos_estudiante['genero'] == 'M')  ? 'retirado' : 'retirada' ).', por su representante legal: '.$_GET['nombre_completo_representante'] .' cédula de identidad Nº '.$_GET['cedula_representante'].'. Causa del retiro: '.$_GET['causa_retiro']
		);


$duracion = utf8_decode('Constancia que se expide a solicitud de parte interesada en Acarigua a los '.date('d').' días del Mes de '.ucfirst(strftime("%B")).' del Año '.date('Y').'. ');


$pdf->SetFont('Arial','',10);
$pdf->setX(30);
$pdf->MultiCell(150,6,$texto,0,'J');
$pdf->Ln(20);


$pdf->setX(30);
$pdf->MultiCell(150,6,$duracion,0,'J');
$pdf->Ln(70);


$pdf->SetFont('Arial','B',10);

$pdf->setX(30);
$pdf->Cell(50,5,'_____________________',0,1,'C');

$pdf->setX(30);
$pdf->Cell(50,5, ($director['genero'] == 'M') ? 'Lcdo. ' : 'Lcda. '.$director['p_nombre'].' '.$director['p_apellido'],0,1,'C');
$pdf->Ln(1);

$pdf->setX(30);
$pdf->Cell(50,5,($director['genero'] == 'M') ? 'Director' : 'Directora',0,1,'C');
$pdf->Ln(5);



$pdf->SetY('211.00125');



$pdf->setX(130);
$pdf->Cell(50,5,'_____________________',0,1,'C');

$pdf->setX(130);
$pdf->Cell(50,5,"Docente de grado",0,1,'C');
$pdf->Ln(5);

$pdf->Output(utf8_decode('boletin-de-retiro-para-'.$_GET['nombre_completo_estudiante'].'.pdf'),'D',true);


}
else{
  echo "No tiene permiso para visualizar el reporte";
}

}
ob_end_flush();
?>