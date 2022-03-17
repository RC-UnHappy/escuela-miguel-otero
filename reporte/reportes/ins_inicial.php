<?php
#Se activa el almacenamiento en el buffer
ob_start();
if (strlen(session_id()) < 1)
	session_start();

if (!isset($_SESSION['idusuario'])) {
	echo "Debe ingresar al sistema correctamete para visualizar el reporte";
} else {

	#Se incluye el modelo de Inscripcion
	require_once '../modelos/inscripcion/Inscripcion.php';

	#Se instancia el objeto de Inscripcion
	$Inscripcion = new Inscripcion();

	
	// Varibles que se van a recibir por get necesarias para generar el reporte
	$idplanificacion = isset($_GET['idplanificacion']) ? limpiarCadena($_GET['idplanificacion']) : '';
	
	if (empty($idplanificacion)) die('Faltan datos'); 
	
	$planificacion = $Inscripcion->estudianteplanificacion($idplanificacion);

	var_dump($planificacion);
	die;
	include_once("ex_ins_inicial.php");

	$pdf = new PDF('P', 'mm', 'A3');
	$pdf->AliasNbPages();
	$pdf->AddPage(400);
	$pdf->Ln(10);
	$pdf->SetFont('Arial', 'B', 10);

	$pdf->TextWithDirection(211, 80, 'Lugar de', 'U');
	$pdf->TextWithDirection(218, 80, 'Nacimiento', 'U');
	$pdf->Cell(150, 6, '', 0, 0, 'C');
	$pdf->Cell(100, 6, utf8_decode('Inscripción inicial'), 5, 0, 'C');
	$pdf->Ln(12);

	$docente = "Alexis Cáceres";
	$grado = "5";
	$seccion = "A";
	$ano = "2020-2021";

	$pdf->cell(120, 5, '', 0, 0, 'C');
	$pdf->cell(50, 5, utf8_decode("Docente: " . $docente), 0, 0, 'C');
	$pdf->cell(30, 5, 'Grado: ' . $grado, 0, 0, 'C');
	$pdf->cell(40, 5, utf8_decode('Sección: ' . $seccion), 0, 0, 'C');
	$pdf->cell(30, 5, utf8_decode('Año escolar: ' . $ano), 0, 0, 'C');
	$pdf->Ln(12);
	#Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
	$pdf->cell(40, 30, 'Cedula escolar', 1, 0, 'C');
	$pdf->cell(60, 30, 'Nombres y apellidos', 1, 0, 'C');
	$pdf->cell(13, 30, 'Sexo', 1, 0, 'C');
	$pdf->cell(39, 20, 'Fecha de Nacimiento', 1, 0, 'C');
	$pdf->cell(13, 30, 'Edad', 1, 0, 'C');
	$pdf->cell(13, 30, 'Talla', 1, 0, 'C');
	$pdf->cell(13, 30, 'Peso', 1, 0, 'C');
	$pdf->cell(25, 30, '', 1, 0, 'C');
	$pdf->cell(30, 20, 'Repite', 1, 1, 'C'); # << salto de linea
	$pdf->setX(123); # << aqui el truco, ladilloso pero funciona
	$pdf->cell(13, 10, 'Dia', 1, 0, 'C');
	$pdf->cell(13, 10, 'Mes', 1, 0, 'C');
	$pdf->cell(13, 10, utf8_decode("Año"), 1, 0, 'C');
	$pdf->setX(226); # << aqui el truco, ladilloso pero funciona
	$pdf->cell(15, 10, 'SI', 1, 0, 'C');
	$pdf->cell(15, 10, 'NO', 1, 0, 'C');
	$pdf->setY(54); # << posicion vertical (ladilloso)
	$pdf->setX(256); # << luego horizontal 
	$pdf->cell(40, 30, 'Representante', 1, 1, 'C'); # salto de linea
	$pdf->setY(54);
	$pdf->setX(296);
	$pdf->cell(20, 30, utf8_decode("Cédula"), 1, 1, 'C');
	$pdf->setY(54);
	$pdf->setX(316);
	$pdf->cell(30, 30, utf8_decode("Ocupación"), 1, 1, 'C');
	$pdf->setY(54);
	$pdf->setX(346);
	$pdf->cell(30, 30, 'Telefono', 1, 1, 'C');
	$pdf->setY(54);
	$pdf->setX(376);
	$pdf->cell(40, 30, utf8_decode("Dirección"), 1, 1, 'C');





	# resultados:
	$rs = 10; # resultados de la base de datos ej: 15

	$pdf->SetFont('Arial', '', 10); # letra normal
	for ($i = 0; $i <= $rs; $i++) {
		$pdf->cell(40, 5, '010203040', 1, 0, 'C'); #Cedula estudiantil
		$pdf->cell(60, 5, 'Estudiante ' . $i, 1, 0, 'C'); #Estudiante
		$pdf->cell(13, 5, 'M', 1, 0, 'C'); #Sexo
		$pdf->cell(13, 5, '00', 1, 0, 'C'); #fecha de nacimiento - dia
		$pdf->cell(13, 5, '00', 1, 0, 'C'); #fecha de nacimiento - mes
		$pdf->cell(13, 5, '00', 1, 0, 'C'); #fecha de nacimiento - año
		$pdf->cell(13, 5, '10', 1, 0, 'C'); #Ta
		$pdf->cell(13, 5, '12', 1, 0, 'C');
		$pdf->cell(13, 5, '30,5', 1, 0, 'C');
		$pdf->cell(25, 5, 'Acarigua', 1, 0, 'C');
		$pdf->cell(15, 5, '', 1, 0, 'C');
		$pdf->cell(15, 5, 'X', 1, 0, 'C');
		$pdf->cell(40, 5, 'Representante ' . $i, 1, 0, 'C');
		$pdf->cell(20, 5, '26992848', 1, 0, 'C');
		$pdf->cell(30, 5, 'Obrero', 1, 0, 'C');
		$pdf->cell(30, 5, '04245692123', 1, 0, 'C');
		$pdf->cell(40, 5, 'Pimpinela', 1, 1, 'C'); # salto de linea
	}

	$pdf->Ln(10);
	$pdf->SetFont('Arial', 'B', 10);

	#Matricula Inicial

	$pdf->cell(50, 5, 'Matricula inicial', 1, 0, 'C');
	$pdf->setX(130);
	$pdf->cell(50, 5, 'Clasificacion por edad y sexo', 1, 0, 'C');
	$pdf->setX(230);
	$pdf->cell(50, 5, 'Repitientes', 1, 0, 'C');
	$pdf->setX(330);
	$pdf->cell(50, 5, 'Extranjeros', 1, 1, 'C');


	#Matricula inicial////////////////////////////////////////////////
	$pdf->setX(15);
	$pdf->cell(13, 5, 'V', 1, 0, 'C');
	$pdf->cell(13, 5, 'H', 1, 0, 'C');
	$pdf->cell(13, 5, 'T', 1, 1, 'C');
	$pdf->setX(15);
	$pdf->cell(13, 5, '', 1, 0, 'C');
	$pdf->cell(13, 5, '', 1, 0, 'C');
	$pdf->cell(13, 5, '', 1, 0, 'C');


	#Clasificiacion por edad y sexo///////////////////////////////////

	$pdf->setX(127);
	$pdf->cell(15, 5, 'Edad', 1, 0, 'C');
	$pdf->cell(13, 5, 'V', 1, 0, 'C');
	$pdf->cell(13, 5, 'H', 1, 0, 'C');
	$pdf->cell(15, 5, 'Total', 1, 0, 'C');

	#Clasificacion por repitientes///////////////////////////////////
	$pdf->setX(227);
	$pdf->cell(15, 5, 'Edad', 1, 0, 'C');
	$pdf->cell(13, 5, 'V', 1, 0, 'C');
	$pdf->cell(13, 5, 'H', 1, 0, 'C');
	$pdf->cell(15, 5, 'Total', 1, 0, 'C');

	#Clasificiacion por extranjeros/////////////////////////////////
	$pdf->setX(327);
	$pdf->cell(15, 5, 'Edad', 1, 0, 'C');
	$pdf->cell(13, 5, 'V', 1, 0, 'C');
	$pdf->cell(13, 5, 'H', 1, 0, 'C');
	$pdf->cell(15, 5, 'Total', 1, 1, 'C');

	$filas = 5;
	for ($i = 0; $i < $filas; $i++) {
		$pdf->setX(127); # Sexo y edad
		$pdf->cell(15, 5, '', 1, 0, 'C');
		$pdf->cell(13, 5, '', 1, 0, 'C');
		$pdf->cell(13, 5, '', 1, 0, 'C');
		$pdf->cell(15, 5, '', 1, 0, 'C');
		$pdf->setX(227); #Repitientes
		$pdf->cell(15, 5, '', 1, 0, 'C');
		$pdf->cell(13, 5, '', 1, 0, 'C');
		$pdf->cell(13, 5, '', 1, 0, 'C');
		$pdf->cell(15, 5, '', 1, 0, 'C');
		$pdf->setX(327); #Extranjeros
		$pdf->cell(15, 5, '', 1, 0, 'C');
		$pdf->cell(13, 5, '', 1, 0, 'C');
		$pdf->cell(13, 5, '', 1, 0, 'C');
		$pdf->cell(15, 5, '', 1, 1, 'C');
	}


	$pdf->setX(127); #Totales por sexo y edad
	$pdf->cell(15, 5, 'Total', 1, 0, 'C');
	$pdf->cell(13, 5, '', 1, 0, 'C');
	$pdf->cell(13, 5, '', 1, 0, 'C');
	$pdf->cell(15, 5, '', 1, 0, 'C');

	$pdf->setX(227); #Totales por repitientes
	$pdf->cell(15, 5, 'Total', 1, 0, 'C');
	$pdf->cell(13, 5, '', 1, 0, 'C');
	$pdf->cell(13, 5, '', 1, 0, 'C');
	$pdf->cell(15, 5, '', 1, 0, 'C');

	$pdf->setX(327); #Totales por extranjeros
	$pdf->cell(15, 5, 'Total', 1, 0, 'C');
	$pdf->cell(13, 5, '', 1, 0, 'C');
	$pdf->cell(13, 5, '', 1, 0, 'C');
	$pdf->cell(15, 5, '', 1, 0, 'C');








	$pdf->Output();
}
ob_end_flush();
