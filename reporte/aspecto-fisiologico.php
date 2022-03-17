<?php
#Se activa el almacenamiento en el buffer
ob_start();
if (strlen(session_id()) < 1)
  session_start();

if (!isset($_SESSION['idusuario'])) {
  echo "Debe ingresar al sistema correctamete para visualizar el reporte";
} else {
  if (isset($_SESSION['permisos']['aspecto-fisiologico']) && in_array('ver', $_SESSION['permisos']['aspecto-fisiologico'])) {

    #Se incluye el modelo de AspectoFisiologico
    require_once '../modelos/AspectoFisiologico.php';
    #Se instancia el objeto de AspectoFisiologico
    $AspectoFisiologico = new AspectoFisiologico();

    // Varibles que se van a recibir por get necesarias para generar el reporte
    $idplanificacion = isset($_GET['idplanificacion']) ? limpiarCadena($_GET['idplanificacion']) : '';


    // Datos principales del reporte
    $datos_reporte = $AspectoFisiologico->datos_reporte($idplanificacion);

    // Datos de la planificación
    $datos_planificacion = $AspectoFisiologico->datos_planificacion($idplanificacion);

    // Se establece la zona horaria
    date_default_timezone_set('America/Caracas');
    $fecha = date('Y-m-d');


    include_once("cabecera-aspecto-fisiologico.php");

    require_once '../modelos/Estudiante.php';
    $Estudiante = new Estudiante();
    // Datos de la institución
    $datos_institucion = $Estudiante->traerdatosinstitucion();

    $pdf = new PDF('L', 'mm', 'legal');
    $pdf->codigo_qr = $datos_institucion['codigo_qr'];
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 10);

    #Textos horizontales
    $pdf->TextWithDirection(131, 64, utf8_decode('Tiene Todas Las'), 'U');
    $pdf->TextWithDirection(136, 58, utf8_decode('Vacunas'), 'U');

    $pdf->TextWithDirection(149, 58, utf8_decode('Es Alérgíco'), 'U');




    $pdf->Cell(45, 6, utf8_decode('Año Escolar: ' . $datos_planificacion['periodo']), 0, 0, 'L');
    $pdf->Cell(20, 6, utf8_decode('Grado: ' . $datos_planificacion['grado']), 0, 0, 'L');
    $pdf->Cell(25, 6, utf8_decode('Sección: "' . $datos_planificacion['seccion'] . '"'), 0, 0, 'L');
    $pdf->Cell(40, 6, utf8_decode(ucwords('Docente: ' . $datos_planificacion['p_nombre'] . ' ' . $datos_planificacion['p_apellido'])), 0, 0, 'L');
    $pdf->setX(135);
    $pdf->Cell(100, 6, utf8_decode('Aspecto Fisiológico'), 5, 0, 'C');
    $pdf->Ln(10);


    $pdf->cell(65, 40, 'Nombre y apellido del Estudiante', 1, 0, 'C');
    $pdf->cell(10, 40, 'Edad', 1, 0, 'C');
    $pdf->cell(10, 40, 'Sexo', 1, 0, 'C');
    $pdf->cell(15, 40, 'Peso', 1, 0, 'C');
    $pdf->cell(15, 40, 'Talla', 1, 0, 'C');
    $pdf->cell(15, 40, '', 1, 0, 'C');
    $pdf->cell(15, 40, '', 1, 0, 'C');
    $pdf->cell(60, 10, 'Diversidad Funcional que presenta', 1, 0, 'C');
    $pdf->cell(15, 40, 'C', 1, 0, 'C');
    $pdf->cell(20, 40, 'Alimentos', 1, 0, 'C');
    $pdf->cell(15, 40, utf8_decode('Útiles'), 1, 0, 'C');
    $pdf->cell(80, 10, 'Enfermedad que Padece Especifique', 1, 1, 'C'); #Salto de linea
    $pdf->setX(155); #Truco para la siguiente celda
    $pdf->cell(20, 30, utf8_decode("Motora"), 1, 0, 'C');
    $pdf->cell(20, 30, utf8_decode("Autista"), 1, 0, 'C');
    $pdf->cell(20, 10, utf8_decode("Síndrome"), 0, 1, 'C'); #Salto de linea
    $pdf->setX(195); #Truco para la siguiente celda
    $pdf->cell(20, 10, utf8_decode("De"), 0, 1, 'C'); #Salto de linea
    $pdf->setX(195); #Truco para la siguiente celda
    $pdf->cell(20, 10, utf8_decode("Asperght"), 0, 0, 'C');
    $pdf->setY(40);
    $pdf->setX(265);
    $pdf->cell(23, 30, utf8_decode("Respiratorias"), 1, 0, 'C');
    $pdf->setY(40);
    $pdf->setX(288);
    $pdf->cell(19, 30, utf8_decode("Renal"), 1, 0, 'C');
    $pdf->setY(40);
    $pdf->setX(307);
    $pdf->cell(19, 30, utf8_decode("Visual"), 1, 0, 'C');
    $pdf->setY(40);
    $pdf->setX(326);
    $pdf->cell(19, 30, utf8_decode("Auditiva"), 1, 1, 'C'); #Salto de linea.

    // # resultados:
    // $rs = 24; # resultados de la base de datos ej: 15

    $pdf->SetFont('Arial', '', 10); # letra normal


    if ($datos_reporte->num_rows != 0) {
      while ($reg = $datos_reporte->fetch_object()) {

        if (!empty($reg->f_nac)) {
          list($anoN, $mesN, $diaN) = explode('-', $reg->f_nac);
          list($anoA, $mesA, $diaA) = explode('-', date('Y-m-d'));

          if ($mesN == $mesA) {
            if ($diaN == $diaA) {
              $edad = $anoA - $anoN;
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
        } else {
          $edad = 'No';
        }

        $pdf->cell(65, 5, utf8_decode(ucwords($reg->p_apellido . ' ' . $reg->s_apellido . ' ' . $reg->p_nombre . ' ' . $reg->s_nombre)), 1, 0, 'L'); #Estudiante
        $pdf->cell(10, 5, $edad, 1, 0, 'C'); #Edad
        $pdf->cell(10, 5, $reg->genero, 1, 0, 'C'); #Sexo
        $pdf->cell(15, 5, $reg->peso, 1, 0, 'C'); #Peso
        $pdf->cell(15, 5, $reg->talla, 1, 0, 'C'); #Talla
        $pdf->cell(15, 5, ($reg->todas_vacunas == 1) ? 'Si' : 'No', 1, 0, 'C'); #Vacuna
        $pdf->cell(15, 5, ($reg->alergia == 1) ? 'Si' : 'No', 1, 0, 'C'); #Alergico
        $pdf->cell(20, 5, (strpos($reg->diversidades_funcionales, 'motora') !== false) ? 'x' : '', 1, 0, 'C');   #Diversidad funcional motora
        $pdf->cell(20, 5, (strpos($reg->diversidades_funcionales, 'autismo') !== false) ? 'x' : '', 1, 0, 'C');   #Diversidad funcional autista
        $pdf->cell(20, 5, (strpos($reg->diversidades_funcionales, 'asperger') !== false) ? 'x' : '', 1, 0, 'C');   #Diversidad funcional sindrome
        $pdf->cell(15, 5, ($reg->c == 1) ? 'Si' : 'No', 1, 0, 'C');   #C "No se que mierda es esa"
        $pdf->cell(20, 5, ($reg->alimentos == 1) ? 'Si' : 'No', 1, 0, 'C'); #Alimentos
        $pdf->cell(15, 5, ($reg->utiles == 1) ? 'Si' : 'No', 1, 0, 'C'); #Utiles
        $pdf->cell(23, 5, (strpos($reg->enfermedades, 'respiratoria') !== false) ? 'x' : '', 1, 0, 'C');  #Enfermedad respiratoria
        $pdf->cell(19, 5, (strpos($reg->enfermedades, 'renal') !== false) ? 'x' : '', 1, 0, 'C');   #Enfermedad Renal
        $pdf->cell(19, 5, (strpos($reg->enfermedades, 'visual') !== false) ? 'x' : '', 1, 0, 'C');   #Enfermedad visual
        $pdf->cell(19, 5, (strpos($reg->enfermedades, 'auditiva') !== false) ? 'x' : '', 1, 1, 'C');   #Enfermedad auditiva   "Salto de linea"
      }
    }


    $pdf->Output(utf8_decode($datos_planificacion['periodo'] . '_' . $datos_planificacion['grado'] . '_' . $datos_planificacion['seccion'] . '_datos_fisiologicos.pdf'), 'D', true);
  } else {
    echo "No tiene permiso para visualizar el reporte";
  }
}
ob_end_flush();
