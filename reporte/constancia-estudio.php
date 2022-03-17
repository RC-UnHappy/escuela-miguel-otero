<?php
#Se activa el almacenamiento en el buffer
ob_start();
if (strlen(session_id()) < 1)
	session_start();

if (!isset($_SESSION['idusuario'])) {
	echo "Debe ingresar al sistema correctamete para visualizar el reporte";
} else {
	#Se incluye el modelo de Estudiante
	require_once '../modelos/Estudiante.php';
	#Se instancia el objeto de Estudiante
	$Estudiante = new Estudiante();
	require_once '../modelos/Representante.php';
	$Representante = new Representante();

	$idpersonarepresentante 		= isset($_SESSION['idpersona']) ? limpiarCadena($_SESSION['idpersona']) : null;
	$inscripcion = $Estudiante->getActiveRegistrationByStudent($_GET['idestudiante']);
	$grado = !empty($inscripcion) ? $inscripcion['grado'] : '';

	$idrepresentante = !empty($inscripcion) ? $inscripcion['idrepresentante'] : null;

	if (isset($_SESSION['permisos']['estudiante']) && in_array('ver', $_SESSION['permisos']['estudiante']) || $idpersonarepresentante == $Representante->idpersona($idrepresentante)['idpersona']) {


		#Establece la zona horaria
		setlocale(LC_TIME, "spanish");
		date_default_timezone_set('America/Caracas');

		$director = $Estudiante->traerdatosdirector();

		// Datos de la institución
		$datos_institucion = $Estudiante->traerdatosinstitucion();

		// Varibles que se van a recibir por get necesarias para generar el reporte
		$datos_estudiante = $Estudiante->traerpersonaestudiante($_GET['idpersona'], $_GET['idestudiante']);


		list($year, $month, $day) = explode('-', $datos_estudiante['f_nac']);
		$fechaNacimientoEstudiate = $day . '-' . $month . '-' . $year;

		list($anoA, $mesA, $diaA) = explode('-', date('Y-m-d'));

		if ($month == $mesA) {
			if ($day == $diaA) {
				$edad = $anoA - $year;
				$cumple = ' <span class="pull-right badge badge-light"><i class="fa fa-birthday-cake" style="font-size:18px; color: #F06292;"></i></span><span class="sr-only">Cumpleaños</span>';
			} elseif ($day < $diaA) {
				$edad = $anoA - $year;
			} else {
				$edad = ($anoA - $year) - 1;
			}
		} elseif ($month > $mesA) {
			$edad = ($anoA - $year) - 1;
		} else {
			$edad = ($anoA - $year);
		}


		// $grado = $Estudiante->getActiveRegistrationByStudent($_GET['idestudiante']);

		// $grado = !empty($grado) ? $grado['grado'] : '';

		// $literal = isset($_GET['literal']) ? $_GET['literal'] : '';

		$periodo_escolar = $Estudiante->consultarperiodo();
		$periodo_escolar = !empty($periodo_escolar) ? $periodo_escolar['periodo'] : '';

		// $teacherId = isset($_GET['teacherId']) ? $_GET['teacherId'] : '';

		// $planificacion = $Estudiante->traerplanificaciones($periodo_escolar, $teacherId);

		// $planificacion = $planificacion->fetch_object();

		include_once("cabecera-constancia-estudio.php");

		$pdf = new PDF('P', 'mm', 'A4'/*array(150,85)*/);
		$pdf->codigo_qr = $datos_institucion['codigo_qr'];
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->Ln(18);
		$pdf->SetFont('Arial', 'B', 15);

		$pdf->SetLineWidth(0.5);
		$pdf->Cell(60, 6, '', 0, 0, 'C');
		$pdf->Cell(70, 6, strtoupper(utf8_decode('Constancia de Estudio')), 'B', 2, 'C');
		$pdf->Ln(25);


		$pdf->SetFont('Arial', '', 10);
		$texto = utf8_decode('Quién suscribe, ' . (($director['genero'] == 'M') ? 'LCDO.' : 'LCDA.') . ' ' . strtoupper($director['p_nombre'] . ' ' . $director['p_apellido']) . ', ' . (($director['genero'] == 'M') ? 'portador' : 'portadora') . ' de la Cédula de Identidad Nº ' . $director['cedula'] . ', ' . ucfirst(($director['genero'] == 'M' ? 'Director' : 'Directora')) . ' de la ' . strtoupper($datos_institucion['nombre']) . ', ubicada ' . $datos_institucion['direccion'] . ', hace constar por medio de la presente que ' . (($datos_estudiante['genero'] == 'M') ? 'el' : 'la') . ' estudiante: ' . ucwords($datos_estudiante['p_nombre_estudiante'] . ' ' . $datos_estudiante['s_nombre_estudiante'] . ' ' . $datos_estudiante['p_apellido_estudiante'] . ' ' . $datos_estudiante['s_apellido_estudiante']) . ', ' . (($datos_estudiante['genero'] == 'M') ? 'portador' : 'portadora') . ' de la Cédula de Identidad Nº ' . $datos_estudiante['cedula'] . ',  natural de ' . ucfirst($datos_estudiante['municipio']) . ' estado ' . ucfirst($datos_estudiante['estado']) . ', nacido el ' . $fechaNacimientoEstudiate . ', tiene ' . $edad . ' años de edad. Está  ' . (($datos_estudiante['genero'] == 'M') ? 'inscrito' : 'inscrita') . ' y cursa el ' . $grado . ' grado de Educación Primaria en este plantel. Año Escolar ' . $periodo_escolar);

		$duracion = utf8_decode('Constancia que se expide a solicitud de la parte interesada en Acarigua a los ' . date('d') . ' días del mes de ' . ucfirst(strftime("%B")) . ' del ' . date('Y') . '.');


		$pdf->setX(25);
		#$pdf->setY(50);
		$pdf->Multicell(150, 6, $texto, 0, 'J');
		$pdf->ln(20);

		$pdf->setX(25);
		$pdf->Multicell(150, 6, $duracion, 0, 'J');
		$pdf->ln(20);

		$pdf->SetFont('Arial', 'B', 10);

		$pdf->SetY('211.00125');

		$pdf->setX(30);
		$pdf->Cell(50, 5, '_____________________', 0, 1, 'C');

		$pdf->setX(30);
		$pdf->Cell(50, 5, ($director['genero'] == 'M') ? 'Lcdo. ' : 'Lcda. ' . $director['p_nombre'] . ' ' . $director['p_apellido'], 0, 1, 'C');
		$pdf->Ln(1);

		$pdf->setX(30);
		$pdf->Cell(50, 5, ($director['genero'] == 'M') ? 'Director' : 'Directora', 0, 1, 'C');
		$pdf->Ln(5);



		$pdf->SetY('211.00125');



		$pdf->setX(130);
		$pdf->Cell(50, 5, '_____________________', 0, 1, 'C');

		$pdf->setX(130);
		$pdf->Cell(50, 5, "Docente de grado", 0, 1, 'C');
		$pdf->Ln(5);


		$pdf->Output(
			/**utf8_decode('boletin-promocion-' . $datos_estudiante['p_nombre_estudiante'].'-'.$datos_estudiante['p_apellido_estudiante'].'-'.$planificacion->grado.'-grado.pdf'),'D',true**/
		);
	} else {
		echo "No tiene permiso para visualizar el reporte";
	}
}
ob_end_flush();
