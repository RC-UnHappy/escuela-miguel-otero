<?php 

#Se inicia la sesión
if (strlen(session_id() < 1)) session_start(); 

#Se incluye el modelo de HistorialEstudiantil
require_once '../modelos/HistorialEstudiantil.php';

#Se instancia el objeto de HistorialEstudiantil
$HistorialEstudiantil = new HistorialEstudiantil();

$variablesFormulario = ['periodo_escolar', 'turno', 'grado', 'seccion', 'cedula_docente', 'nombre_docente','apellido_docente','cedula_estudiante','p_nombre_estudiante','s_nombre_estudiante','p_apellido_estudiante','s_apellido_estudiante','fecha_nacimiento_estudiante','lugar_nacimiento_estudiante','sexo_estudiante','literal','estatus', 'observaciones'];

// Se establecen todas las variables que vienen por POST por medio de un bucle
foreach ($_POST as $key => $value) {

  if (in_array($key, $variablesFormulario)) {
    $$key = !empty($value) ? limpiarCadena($value) : '';
  }
}

$return = new stdClass;
$return->estatus = 1;
$return->msj = '';


#Se ejecuta un caso dependiendo del valor del parámetro GET
switch ($_GET['op']) {

	case 'guardaryeditar':

		#Se deshabilita el guardado automático de la base de datos
		autocommit(FALSE);

    if ( empty($idhistorialestudiantil) ) {
      try {

        #Se registra el historial
        $registro = $HistorialEstudiantil->insertar($periodo_escolar, $turno, $grado, ucfirst($seccion), $cedula_docente, $nombre_docente, $apellido_docente, $cedula_estudiante, $p_nombre_estudiante, $s_nombre_estudiante, $p_apellido_estudiante, $s_apellido_estudiante, $fecha_nacimiento_estudiante, $lugar_nacimiento_estudiante, $sexo_estudiante, ucfirst($literal), $estatus, $observaciones);

        if ($registro !== true)
          throw new Exception("Error al registrar", 1);
        
        // Se guardan los datos en la bd  
        commit();

        // Se envía el mensaje al front
        $return->msj = 'Historial registrado exitosamente :)';
        echo json_encode($return);

      } catch (Exception $e) {

        // Se deshacen los cambios en la bd
        rollback();

        $return->estatus = 3;
        $return->msj = $e->getMessage();
        echo json_encode($return);
      }
    }
    else {

    }
  break;

  case 'listar':

    $periodo_escolar = (isset($_POST['periodo_escolar']) && !empty($_POST['periodo_escolar'])) ? $_POST['periodo_escolar'] : '';

    if (!empty($periodo_escolar)) {
      $rspta = $HistorialEstudiantil->listar($periodo_escolar);
    }
    else {
      $rspta = $HistorialEstudiantil->listar();
    }
          
    if ($rspta->num_rows != 0) {
      while ($reg = $rspta->fetch_object()) {

        $data[] = array(
        '0' => $reg->periodo_escolar,
        '1' => $reg->turno,
        '2' => $reg->grado,
        '3' => $reg->seccion,
        '4' => $reg->cedula_docente,
        '5' => $reg->nombre_docente,
        '6' => $reg->apellido_docente,
        '7' => $reg->cedula_estudiante,
        '8' => $reg->p_nombre_estudiante,
        '9' => $reg->s_nombre_estudiante,
        '10' => $reg->p_apellido_estudiante,
        '11' => $reg->s_apellido_estudiante,
        '12' => $reg->fecha_nacimiento_estudiante,
        '13' => $reg->lugar_nacimiento_estudiante,
        '14' => $reg->sexo_estudiante,
        '15' => $reg->literal,
        '16' => $reg->observaciones,
        '17' => $reg->estatus

        );

      }

      $results = array(
        "draw" => 0, #Esto tiene que ver con el procesamiento del lado del servidor
        "recordsTotal" => count($data), #Se envía el total de registros al datatable
        "recordsFiltered" => count($data), #Se envía el total de registros a visualizar
        "data" => $data #datos en un array

      );
    }
    else {
      $results = array(
        "draw" => 0, #Esto tiene que ver con el procesamiento del lado del servidor
        "recordsTotal" => 0, #Se envía el total de registros al datatable
        "recordsFiltered" => 0, #Se envía el total de registros a visualizar
        "data" => '' #datos en un array

      );
    }

		echo json_encode($results);

  break;
    
	case 'fecha_creacion_escuela':
    
    $rspta = $HistorialEstudiantil->fecha_creacion_escuela();
    $fecha_fundada = !empty($rspta) ? $rspta['fecha_fundada'] : '';

		#Se codifica el resultado utilizando Json
		echo json_encode($fecha_fundada);

  break;
  
	case 'traer_turno':
    
    $rspta = $HistorialEstudiantil->traer_turno();
    $turno = !empty($rspta) ? $rspta['turno'] : '';

		#Se codifica el resultado utilizando Json
		echo json_encode($turno);

	break;

}