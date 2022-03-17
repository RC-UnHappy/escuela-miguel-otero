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

	require_once '../modelos/Estudiante.php';
	$Estudiante = new Estudiante();
	// Datos de la institución
	$datos_institucion = $Estudiante->traerdatosinstitucion();

	require_once '../modelos/AspectoFisiologico.php';
	$AspectoFisiologico = new AspectoFisiologico();



	// Varibles que se van a recibir por get necesarias para generar el reporte
	$idplanificacion = isset($_GET['idplanificacion']) ? limpiarCadena($_GET['idplanificacion']) : '';

	if (empty($idplanificacion)) die('Faltan datos');

	$planificacion = $Inscripcion->estudianteplanificacion($idplanificacion);

	// Datos de la planificación
	$datos_planificacion = $AspectoFisiologico->datos_planificacion($idplanificacion);

	$varones = 0;
	$hembras = 0;
	$total = 0;

	// Estas variables son las que se van a mostrar abajo, en las estadisticas
	$edades = [];
	$edadesrepitientes = [];
	$cantidad = [];
	$cantidadrepitientes = [];

	$planificacion = $planificacion->fetch_all(MYSQLI_ASSOC);

	foreach ($planificacion as $item) {
		$item['genero'] == 'M' ? $varones++ : $hembras++;
		$total++;
	}

	include_once("cabecera_ins_inicial.php");

	$pdf = new PDF('P', 'mm', 'A3');
	$pdf->codigo_qr = $datos_institucion['codigo_qr'];
	$pdf->AliasNbPages();
	$pdf->AddPage(400);
	$pdf->Ln(10);
	$pdf->SetFont('Arial', 'B', 10);

	$pdf->TextWithDirection(211, 80, 'Lugar de', 'U');
	$pdf->TextWithDirection(218, 80, 'Nacimiento', 'U');
	$pdf->Cell(150, 6, '', 0, 0, 'C');
	$pdf->Cell(100, 6, utf8_decode('Inscripción inicial'), 5, 0, 'C');
	$pdf->Ln(12);

	$pdf->cell(80, 5, '', 0, 0, 'C');
	$pdf->cell(50, 5, utf8_decode("Docente: " . utf8_decode($datos_planificacion['p_nombre'] . ' ' . $datos_planificacion['p_apellido'])), 0, 0, 'C');
	$pdf->cell(30, 5, 'Grado: ' . utf8_decode($datos_planificacion['grado']), 0, 0, 'C');
	$pdf->cell(40, 5, utf8_decode('Sección: ' . utf8_decode($datos_planificacion['seccion'])), 0, 0, 'C');
	$pdf->cell(50, 5, utf8_decode('Año escolar: ' . utf8_decode($datos_planificacion['periodo'])), 0, 0, 'C');
	$pdf->cell(30, 5, utf8_decode('Varones: ' . $varones), 0, 0, 'C');
	$pdf->cell(30, 5, utf8_decode('Hembras: ' . $hembras), 0, 0, 'C');
	$pdf->cell(30, 5, utf8_decode('Total: ' . $total), 0, 0, 'C');
	$pdf->Ln(12);
	#Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
	$pdf->cell(10, 30, utf8_decode('N°'), 1, 0, 'C');
	$pdf->cell(60, 30, 'Apellidos y Nombres', 1, 0, 'C');
	$pdf->cell(40, 30, 'Cedula escolar', 1, 0, 'C');
	$pdf->cell(10, 30, utf8_decode('R'), 1, 0, 'C');
	$pdf->cell(13, 30, 'G', 1, 0, 'C');
	$pdf->cell(39, 20, 'Fecha de Nacimiento', 1, 0, 'C');
	$pdf->cell(13, 30, 'E', 1, 0, 'C');
	// $pdf->cell(13, 30, 'Talla', 1, 0, 'C');
	// $pdf->cell(13, 30, 'Peso', 1, 0, 'C');
	$pdf->cell(25, 30, '', 1, 0, 'C');
	$pdf->cell(36, 20, 'Representante', 'T', 1, 'C'); # << salto de linea
	$pdf->setX(143); # << aqui el truco, ladilloso pero funciona
	$pdf->cell(13, 10, 'Dia', 1, 0, 'C');
	$pdf->cell(13, 10, 'Mes', 1, 0, 'C');
	$pdf->cell(13, 10, utf8_decode("Año"), 1, 0, 'C');
	$pdf->setX(226); # << aqui el truco, ladilloso pero funciona
	$pdf->cell(30, 10, '', 0, 0, 'C');
	// $pdf->cell(15, 10, 'NO', 1, 0, 'C');
	$pdf->setY(54); # << posicion vertical (ladilloso)
	$pdf->setX(256); # << luego horizontal 
	$pdf->cell(40, 30, utf8_decode('Cédula'), 1, 1, 'C'); # salto de linea
	$pdf->setY(54);
	$pdf->setX(296);
	$pdf->cell(60, 30, utf8_decode("Dirección"), 1, 1, 'C');
	$pdf->setY(54);
	$pdf->setX(356);
	$pdf->cell(50, 30, utf8_decode("Teléfono"), 1, 1, 'C');


	# resultados:
	$rs = 10; # resultados de la base de datos ej: 15

	$pdf->SetFont('Arial', '', 10); # letra normal

	$index = 1;

	foreach ($planificacion as $item) {
		// var_dump($item);
		// die;

		list($anoN, $mesN, $diaN) = explode('-', $item['f_nac']);
		list($anoA, $mesA, $diaA) = explode('-', date('Y-m-d'));

		if ($mesN == $mesA) {
			if ($diaN == $diaA) {
				$edad = $anoA - $anoN;
				$cumple = ' <span class="pull-right badge badge-light"><i class="fa fa-birthday-cake" style="font-size:18px; color: #F06292;"></i></span><span class="sr-only">Cumpleaños</span>';
			} elseif ($diaN < $diaA) {
				$edad = $anoA - $anoN;
			} else {
				$edad = ($anoA - $anoN) - 1;
			}
		} elseif ($mesN > $mesA) {
			$edad = ($anoA - $anoN) - 1;
		} else {
			$edad = ($anoA - $anoN);
		}

		if (in_array($edad, $edades)) {
			$item['genero'] == 'M' ? $cantidad[$edad]['M'] = $cantidad[$edad]['M'] + 1 : $cantidad[$edad]['F'] = $cantidad[$edad]['F'] + 1;

			$cantidad[$edad]['T'] = $cantidad[$edad]['M'] + $cantidad[$edad]['F'];
		} else {
			$edades[$edad] = [];
			$item['genero'] == 'M' ? $cantidad[$edad]['M'] = 1 : $cantidad[$edad]['F'] = 1;
			$cantidad[$edad]['T'] = 1;
		}


		if ($item['estatus'] == 'REPITE') {
			if (in_array($edad, $edadesrepitientes)) {
				$item['genero'] == 'M' ? $cantidadrepitientes[$edad]['M'] = $cantidadrepitientes[$edad]['M'] + 1 : $cantidadrepitientes[$edad]['F'] = $cantidadrepitientes[$edad]['F'] + 1;

				$cantidadrepitientes[$edad]['T'] = $cantidadrepitientes[$edad]['M'] + $cantidadrepitientes[$edad]['F'];
			} else {
				$edadesrepitientes[$edad] = [];
				$item['genero'] == 'M' ? $cantidadrepitientes[$edad]['M'] = 1 : $cantidadrepitientes[$edad]['F'] = 1;
				$cantidadrepitientes[$edad]['T'] = 1;
			}
		}

		$pdf->cell(10, 5, $index, 1, 0, 'C');
		$pdf->cell(60, 5, utf8_decode($item['p_apellido'] . ' ' . $item['s_apellido'] . ' ' . $item['p_nombre'] . ' ' . $item['s_nombre']), 1, 0, 'C'); #Estudiante
		$pdf->cell(40, 5, $item['cedula'], 1, 0, 'C'); #Cedula estudiantil
		$pdf->cell(10, 5, $item['estatus'] == 'REPITE' ? 'X' : '', 1, 0, 'C');
		$pdf->cell(13, 5, $item['genero'], 1, 0, 'C'); #Sexo
		$pdf->cell(13, 5, $diaN, 1, 0, 'C'); #fecha de nacimiento - dia
		$pdf->cell(13, 5, $mesN, 1, 0, 'C'); #fecha de nacimiento - mes
		$pdf->cell(13, 5, $anoN, 1, 0, 'C'); #fecha de nacimiento - año
		$pdf->cell(13, 5, $edad, 1, 0, 'C');
		$pdf->cell(25, 5, $item['municipio'], 1, 0, 'C');
		$pdf->cell(36, 5, utf8_decode($item['p_nombre_representante'] . ' ' . $item['p_apellido_representante']), 1, 0, 'C');
		$pdf->cell(40, 5, $item['cedula_repre'], 1, 0, 'C');
		$pdf->cell(60, 5, utf8_decode($item['direccion']), 1, 0, 'C');
		$pdf->cell(50, 5, utf8_decode($item['telefono']), 1, 1, 'C');
		// $pdf->cell(40, 5, 'Representante ' . $i, 1, 0, 'C');
		// $pdf->cell(20, 5, '26992848', 1, 0, 'C');
		// $pdf->cell(30, 5, 'Obrero', 1, 0, 'C');
		// $pdf->cell(30, 5, '04245692123', 1, 0, 'C');
		// $pdf->cell(40, 5, 'Pimpinela', 1, 1, 'C'); # salto de linea
		$index++;
	}

	$pdf->Ln(10);
	$pdf->SetFont('Arial', 'B', 10);

	#Matricula Inicial

	// $pdf->cell(50, 5, 'Matricula inicial', 1, 0, 'C');
	// $pdf->setX(130);
	$pdf->setX(17);
	$pdf->cell(60, 5, utf8_decode('Clasificación por edad y sexo'), 1, 0, 'C');
	$pdf->setX(175);
	$pdf->cell(50, 5, utf8_decode('Matrícula Inicial'), 1, 0, 'C');
	$pdf->setX(330);
	$pdf->cell(50, 5, 'Extranjeros', 1, 1, 'C');


	#Matricula inicial////////////////////////////////////////////////
	// $pdf->setX(15);
	// $pdf->cell(13, 5, 'V', 1, 0, 'C');
	// $pdf->cell(13, 5, 'H', 1, 0, 'C');
	// $pdf->cell(13, 5, 'T', 1, 1, 'C');
	// $pdf->setX(15);
	// $pdf->cell(13, 5, '', 1, 0, 'C');
	// $pdf->cell(13, 5, '', 1, 0, 'C');
	// $pdf->cell(13, 5, '', 1, 0, 'C');


	#Clasificiacion por edad y sexo///////////////////////////////////

	$pdf->setX(8);
	$pdf->cell(20, 5, 'Edad', 1, 0, 'C');
	$pdf->cell(20, 5, 'Varones', 1, 0, 'C');
	$pdf->cell(20, 5, 'Hembras', 1, 0, 'C');
	$pdf->cell(20, 5, 'Total', 1, 0, 'C');

	#Clasificacion por Matricula///////////////////////////////////
	$pdf->setX(170);
	$pdf->cell(20, 5, 'Varones', 1, 0, 'C');
	$pdf->cell(20, 5, 'Hembras', 1, 0, 'C');
	$pdf->cell(20, 5, 'Total', 1, 0, 'C');

	#Clasificiacion por repitientes/////////////////////////////////
	$pdf->setX(318);
	$pdf->cell(20, 5, 'Edad', 1, 0, 'C');
	$pdf->cell(20, 5, 'Varones', 1, 0, 'C');
	$pdf->cell(20, 5, 'Hembras', 1, 0, 'C');
	$pdf->cell(20, 5, 'Total', 1, 1, 'C');

	$filas = 5;

	$totalvarones = 0;
	$totalvaronesrepitientes = 0;
	$totalhembras = 0;
	$totalhembrasrepitientes = 0;
	$totalhembrasvarones = 0;
	$totalhembrasvaronesrepitientes = 0;

	foreach ($cantidad as $valor) {
		$totalvarones = $totalvarones + isset($valor['M']) ? $valor['M'] : 0;
		$totalhembras = $totalhembras + isset($valor['F']) ? $valor['F'] : 0;
	}

	foreach ($cantidadrepitientes as $valor) {
		$totalvaronesrepitientes = $totalvaronesrepitientes + isset($valor['M']) ? $valor['M'] : 0;
		$totalhembrasrepitientes = $totalhembrasrepitientes + isset($valor['F']) ? $valor['F'] : 0;
	}

	$totalhembrasvarones = $totalhembras + $totalvarones;
	$totalhembrasvaronesrepitientes = $totalhembrasrepitientes + $totalvaronesrepitientes;

	foreach ($edades as $index => $item) {
		$pdf->setX(8); # Sexo y edad
		$pdf->cell(20, 5, $index, 1, 0, 'C');
		$pdf->cell(20, 5, isset($cantidad[$index]['M']) ? $cantidad[$index]['M'] : '', 1, 0, 'C');
		$pdf->cell(20, 5, isset($cantidad[$index]['F']) ? $cantidad[$index]['F'] : '', 1, 0, 'C');
		$pdf->cell(20, 5, isset($cantidad[$index]['T']) ? $cantidad[$index]['T'] : '', 1, 1, 'C');
	}
	$pdf->setX(8);
	$pdf->cell(20, 5, 'Total', 1, 0, 'C');
	$pdf->cell(20, 5, $totalvarones, 1, 0, 'C');
	$pdf->cell(20, 5, $totalhembras, 1, 0, 'C');
	$pdf->cell(20, 5, $totalhembrasvarones, 1, 0, 'C');

	$pdf->SetY($pdf->GetY() - 5);

	$pdf->setX(170); #Matricula inicial
	$pdf->cell(20, 5, $totalvarones, 1, 0, 'C');
	$pdf->cell(20, 5, $totalhembras, 1, 0, 'C');
	$pdf->cell(20, 5, $totalhembrasvarones, 1, 0, 'C');


	foreach ($edadesrepitientes as $index => $item) {
		$pdf->setX(327); # Sexo y edad
		$pdf->cell(20, 5, $index, 1, 0, 'C');
		$pdf->cell(20, 5, isset($cantidadrepitientes[$index]['M']) ? $cantidadrepitientes[$index]['M'] : '', 1, 0, 'C');
		$pdf->cell(20, 5, isset($cantidadrepitientes[$index]['F']) ? $cantidadrepitientes[$index]['F'] : '', 1, 0, 'C');
		$pdf->cell(20, 5, isset($cantidadrepitientes[$index]['T']) ? $cantidadrepitientes[$index]['T'] : '', 1, 1, 'C');
	}

	// for ($i = 0; $i < $filas; $i++) {
	// 	$pdf->setX(327); #Extranjeros
	// 	$pdf->cell(15, 5, '', 1, 0, 'C');
	// 	$pdf->cell(13, 5, '', 1, 0, 'C');
	// 	$pdf->cell(13, 5, '', 1, 0, 'C');
	// 	$pdf->cell(15, 5, '', 1, 1, 'C');
	// }

	// $pdf->setX(227); #Totales por repitientes
	// $pdf->cell(15, 5, 'Total', 1, 0, 'C');
	// $pdf->cell(13, 5, '', 1, 0, 'C');
	// $pdf->cell(13, 5, '', 1, 0, 'C');
	// $pdf->cell(15, 5, '', 1, 0, 'C');

	$pdf->setX(318); #Totales por repitientes
	$pdf->cell(20, 5, 'Total', 1, 0, 'C');
	$pdf->cell(20, 5, $totalvaronesrepitientes, 1, 0, 'C');
	$pdf->cell(20, 5, $totalhembrasrepitientes, 1, 0, 'C');
	$pdf->cell(20, 5, $totalhembrasvaronesrepitientes, 1, 0, 'C');








	$pdf->Output();
}
ob_end_flush();
