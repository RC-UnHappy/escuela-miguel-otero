<?php 

#Se inicia la sesión
if (strlen(session_id() < 1)) session_start(); 

#Se incluye el modelo de Planificación
require_once '../modelos/Planificacion.php';

#Se instancia el objeto de Planificación
$Planificacion = new Planificacion();

$idplanificacion = isset($_POST['idplanificacion']) ? limpiarCadena($_POST['idplanificacion']) : '';
$idperiodo_escolar = isset($_POST['idperiodo_escolar']) ? limpiarCadena($_POST['idperiodo_escolar']) : '';
$idgrado = isset($_POST['idgrado']) ? limpiarCadena($_POST['idgrado']) : '';
$idseccion = isset($_POST['idseccion']) ? limpiarCadena($_POST['idseccion']) : '';
$idambiente = isset($_POST['idambiente']) ? limpiarCadena($_POST['idambiente']) : '';
$iddocente = isset($_POST['iddocente']) ? limpiarCadena($_POST['iddocente']) : '';
$cupo = isset($_POST['cupo']) ? limpiarCadena($_POST['cupo']) : '';

#Se ejecuta un caso dependiendo del valor del parámetro GET
switch ($_GET['op']) {

	case 'guardaryeditar':

		#Se deshabilita el guardado automático de la base de datos
		autocommit(FALSE);

		#Variable para comprobar que todo salió bien al final
		$sw = TRUE;

		#Si la variable esta vacía quiere decir que es un nuevo registro
		if (empty($idplanificacion)) {


			#Se trae el id del período escolar en curso
			$idperiodo_escolar_actual = $Planificacion->consultarperiodo();
			
	      	$idperiodo_escolar_actual = !empty($idperiodo_escolar_actual) ? $idperiodo_escolar_actual['id'] : '';
	      
	      	$estatus = '';
	      	if ($idperiodo_escolar_actual == $idperiodo_escolar)
	        	$estatus = 'Activo';
      		else 
        		$estatus = 'Planificado';

			#Se registra la planificación
			$Planificacion->insertar($idperiodo_escolar, $idgrado, $idseccion, $idambiente, $iddocente, $cupo, $cupo, $estatus) or $sw = FALSE;

			#Se verifica que todo saliío bien y se guardan los datos o se eliminan todos
			if ($sw) {
				commit();
				echo 'true';
			}
			else {
				rollback();
				echo 'false';
			}

		}
		else{
      		#Se consulta el cupo anterior
      		$cupoanterior = $Planificacion->verificarcupo($idplanificacion, 'cupo');
      		$cupoanterior = $cupoanterior['cupo'];

			#Se consulta el cupo disponible
			$cupodisponible = $Planificacion->verificarcupo($idplanificacion, 'cupo_disponible');
      		$cupodisponible = $cupodisponible['cupo_disponible'];

     		#Cantidad de estudiantes inscritos
      		$cantidad_estudiantes = ($cupoanterior - $cupodisponible);

			if(($cupo - $cantidad_estudiantes) < 0)
				$sw = FALSE;

			#Se edita la planificación
			$Planificacion->editar($idplanificacion, $idgrado, $idseccion, $idambiente, $iddocente, $cupo, ($cupo - $cantidad_estudiantes)) or $sw = FALSE;

			#Se verifica que todo saliío bien y se guardan los datos o se eliminan todos
			if ($sw) {
				commit();
				echo 'update';
			}
			else {
				rollback();
				echo 'false';
			}
		}
	break;

	case 'listar':
    	$idperiodo = isset($_GET['idperiodo']) ? $_GET['idperiodo'] : '';

		$rspta = $Planificacion->listar($idperiodo);
    
		if ($rspta->num_rows != 0) {
      while ($reg = $rspta->fetch_object()) {
        
        /**
         * Lógica para mostrar o no los botones de opciones en la lista dependiendo de si la planificación tiene una inscripción activa
         */
        $idplanificaciones = $Planificacion->seleccionar_inscripciones_por_idplanificacion($reg->id);

        $arreglo_idplanificaciones = [];
        if ($idplanificaciones->num_rows != 0) {
          while ($resultado = $idplanificaciones->fetch_object()) {
            array_push($arreglo_idplanificaciones, $resultado->idplanificacion);
          }
        }

        $badge = '';
        if ($reg->estatus == 'Activo') 
          $badge = '<span class="badge badge-pill badge-success">Activo</span>';
        elseif($reg->estatus == 'Planificado')
          $badge = '<span class="badge badge-pill badge-warning">Planificado</span>';
        else 
          $badge = '<span class="badge badge-pill badge-danger">Finalizado</span>';

				$data[] = array('0' => 

					( ($reg->estatus == 'Activo') ? 

					( !in_array($reg->id, $arreglo_idplanificaciones) ?

					( ( isset($_SESSION['permisos']['planificacion']) && 
                  	  in_array('editar' , $_SESSION['permisos']['planificacion']) ) ? 
					
					'<button class="btn btn-outline-primary " title="Editar" onclick="mostrar('.$reg->id.')" data-toggle="modal" data-target="#planificacionModal"><i class="fas fa-edit"></i></button>' : '').


					( ( isset($_SESSION['permisos']['planificacion']) && 
                  	  in_array('activar-desactivar' , $_SESSION['permisos']['planificacion']) ) ?

					' <button class="btn btn-outline-danger" title="Eliminar" onclick="eliminar('.$reg->id.')"> <i class="fas fa-times"> </i></button> ' : '')

					:

					( ( isset($_SESSION['permisos']['planificacion']) && 
                  	  in_array('editar' , $_SESSION['permisos']['planificacion']) ) ? 

					 '<button class="btn btn-outline-primary " title="Editar" onclick="mostrar('.$reg->id.')" data-toggle="modal" data-target="#planificacionModal"><i class="fas fa-edit"></i></button>' : '') ) : ''),

					 	'1' => $reg->grado.' º',
					 	'2' => '"'.$reg->seccion.'"',
					 	'3' => $reg->ambiente,
					 	'4' => $reg->p_nombre.' '.$reg->p_apellido,
					 	'5' => $reg->cupo,
            '6' => $reg->periodo,
            '7' => $badge);
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

	case 'mostrar':
	
		$rspta = $Planificacion->mostrar($idplanificacion);

		#Se codifica el resultado utilizando Json
		echo json_encode($rspta);

		break;

	case 'eliminar': 
    $idplanificaciones = $Planificacion->seleccionar_inscripciones_por_idplanificacion($idplanificacion);

    if ($idplanificaciones->num_rows == 0) {
      $rspta = $Planificacion->eliminar($idplanificacion);
      echo $rspta ? 'true' : 'false';
    }
    else {
      echo 'inscritos';
    }
		break;

	case 'traergrados': 

		$rspta = $Planificacion->traergrados();

		$data = array();
		if ($rspta->num_rows != 0) {
			while ($reg = $rspta->fetch_object()) {

				$data[] = ['id' => $reg->id,
              'grado' => $reg->grado];

			}

		}

		#Se codifica el resultado utilizando Json
		echo json_encode($data);
		break;

	case 'traersecciones': 
		#idplanificación es un parámetro que puede o no estar vacío
		$rspta = $Planificacion->traersecciones($idgrado, $idplanificacion, $idperiodo_escolar);

		$data = array();
		if ($rspta->num_rows != 0) {
			while ($reg = $rspta->fetch_object()) {

				$data[] = ['id' => $reg->id,
						  'seccion' => $reg->seccion];
			}

		}

		#Se codifica el resultado utilizando Json
		echo json_encode($data);
		break;

	case 'traerambientes': 

		#idambiente es un parámetro que puede o no estar vacío
		$rspta = $Planificacion->traerambientes($idambiente, $idperiodo_escolar);

		$data = array();
		if ($rspta->num_rows != 0) {
			while ($reg = $rspta->fetch_object()) {

				$data[] = ['id' => $reg->id,
              'ambiente' => $reg->ambiente,
              'capacidad' => $reg->capacidad];
			}

		}

		#Se codifica el resultado utilizando Json
		echo json_encode($data);
		break;

	case 'traerdocentes': 
		
		#iddocente es un parámetro que puede o no estar vacío
		$rspta = $Planificacion->traerdocentes($iddocente, $idperiodo_escolar);

		$data = array();
		if ($rspta->num_rows != 0) {
			while ($reg = $rspta->fetch_object()) {

				$data[] = ['id' => $reg->id,
						  'p_nombre' => $reg->p_nombre,
						  'p_apellido' => $reg->p_apellido];
			}

		}

		#Se codifica el resultado utilizando Json
		echo json_encode($data);
    break;
    
  case 'traerperiodosescolares': 
    
    $rspta = $Planificacion->traer_periodos_escolares();

		$data = array();
		if ($rspta->num_rows != 0) {
			while ($reg = $rspta->fetch_object()) {

				$data[] = ['id' => $reg->id,
						      'periodo' => $reg->periodo];
			}

		}

		#Se codifica el resultado utilizando Json
    echo json_encode($data);
    break;

  case 'traerperiodosactivoplanificados': 
    
    $rspta = $Planificacion->traer_periodos_activo_planificados();

		$data = array();
		if ($rspta->num_rows != 0) {
			while ($reg = $rspta->fetch_object()) {

				$data[] = ['id' => $reg->id,
						      'periodo' => $reg->periodo];
			}

		}

		#Se codifica el resultado utilizando Json
    echo json_encode($data);
    break;

  case 'consultarperiodo': 
    $periodo_actual = $Planificacion->consultarperiodo();
    $periodo_actual = !empty($periodo_actual) ? $periodo_actual['id'] : '';

    echo $periodo_actual;
    break;

}