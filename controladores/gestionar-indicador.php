<?php 

#Se inicia la sesión
if (strlen(session_id() < 1)) session_start(); 

#Se incluye el modelo de GestionarIndicador
require_once '../modelos/GestionarIndicador.php';

#Se instancia el objeto de GestionarIndicador
$GestionarIndicador = new GestionarIndicador();

/**
 * Variables de proyecto de aprendizaje
 */
$idplanificacion = isset($_POST['idplanificacion']) ? limpiarCadena($_POST['idplanificacion']) : '';
$lapso = isset($_POST['lapso']) ? limpiarCadena($_POST['lapso']) : '';
$idproyecto_aprendizaje = isset($_POST['idproyecto_aprendizaje']) ? limpiarCadena($_POST['idproyecto_aprendizaje']) : '';
$proyecto_aprendizaje = isset($_POST['proyecto_aprendizaje']) ? limpiarCadena($_POST['proyecto_aprendizaje']) : '';
$editar_proyecto_aprendizaje = isset($_POST['editar_proyecto_aprendizaje']) ? limpiarCadena($_POST['editar_proyecto_aprendizaje']) : '';

/**
 * Variable de gestionar indicador
 */
$idindicador = isset($_POST['idindicador']) ? limpiarCadena($_POST['idindicador']) : '';
$idplanificacion_indicador = isset($_POST['idplanificacion_indicador']) ? limpiarCadena($_POST['idplanificacion_indicador']) : '';
$lapso_indicador = isset($_POST['lapso_indicador']) ? limpiarCadena($_POST['lapso_indicador']) : '';
$idmateria_indicador = isset($_POST['idmateria_indicador']) ? limpiarCadena($_POST['idmateria_indicador']) : '';
$indicador = isset($_POST['indicador']) ? limpiarCadena($_POST['indicador']) : '';


#Se ejecuta un caso dependiendo del valor del parámetro GET
switch ($_GET['op']) {

	case 'guardaryeditar':

		#Se deshabilita el guardado automático de la base de datos
		autocommit(FALSE);

		#Variable para comprobar que todo salió bien al final
		$sw = TRUE;

		#Si la variable esta vacía quiere decir que es un nuevo registro
		if (empty($idindicador)) {

			#Se registra el indicador
			$GestionarIndicador->insertar_indicador($idplanificacion_indicador, $idmateria_indicador, $lapso_indicador,  $indicador) or $sw = FALSE;

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

			#Se edita el indicador
			$GestionarIndicador->editar($idindicador, $idplanificacion_indicador, $idmateria_indicador, $lapso_indicador, $indicador) or $sw = FALSE;

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
    
	case 'guardaryeditarproyectoaprendizaje':

		#Se deshabilita el guardado automático de la base de datos
		autocommit(FALSE);

		#Variable para comprobar que todo salió bien al final
		$sw = TRUE;

		#Si la variable esta vacía quiere decir que es un nuevo registro
		if (empty($idproyecto_aprendizaje)) {
      #Se registra el proyecto de aprendizaje
			$GestionarIndicador->insertar_proyecto_aprendizaje($idplanificacion, $lapso, $proyecto_aprendizaje) or $sw = FALSE;
      
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

			#Se edita el proyecto de aprendizaje
			$GestionarIndicador->editar_proyecto_aprendizaje($idproyecto_aprendizaje, $editar_proyecto_aprendizaje) or $sw = FALSE;

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
    
    $idplanificaciones = isset($_GET['idplanificaciones']) ? $_GET['idplanificaciones'] : '';
    $lapsos = isset($_GET['lapsos']) ? $_GET['lapsos'] : '';
  
    $idperiodo_escolar = $GestionarIndicador->consultarperiodo();
    $idperiodo_escolar = !empty($idperiodo_escolar) ? $idperiodo_escolar['id'] : '';

      /**
       * Lógica para mostrar o no los botones de opciones en la lista dependiendo de si el lapso está activo
       */
      $lapsos_finalizados = $GestionarIndicador->seleccionar_lapsos_finalizados($idperiodo_escolar);

      $arreglo_lapsos_finalizados = [];
      if ($lapsos_finalizados->num_rows != 0) {
        while ($resultado = $lapsos_finalizados->fetch_object()) {
          array_push($arreglo_lapsos_finalizados, $resultado->lapso);
        }
      }

    if (!empty($idplanificaciones)){
      $rspta = $GestionarIndicador->listar($idplanificaciones, $lapsos);

      if ($rspta->num_rows != 0) {
        while ($reg = $rspta->fetch_object()) {
  
          $data[] = array('0' => !in_array($reg->lapso_academico, $arreglo_lapsos_finalizados) ? '<button class="btn btn-outline-primary " title="Editar" onclick="mostrar('.$reg->id.')" data-toggle="modal" data-target="#gestionarIndicadoresModal"><i class="fas fa-edit"></i></button>'
          .
          ' <button class="btn btn-outline-danger" title="Eliminar" onclick="eliminar('.$reg->id.')"> <i class="fas fa-times"> </i></button> '
          :
  
          '',
  
          '1' => $reg->lapso_academico.'º Lapso',
          '2' => $reg->materia,
          '3' => $reg->indicador);
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
    	
  case 'listarproyectoaprendizaje':
    
    $idplanificacion = isset($_GET['idplanificacion']) ? $_GET['idplanificacion'] : '';

    if (!empty($idplanificacion)) {
      $rspta = $GestionarIndicador->listarproyectoaprendizaje($idplanificacion);

      $idperiodo_escolar = $GestionarIndicador->consultarperiodo();
      $idperiodo_escolar = !empty($idperiodo_escolar) ? $idperiodo_escolar['id'] : '';

      /**
       * Lógica para mostrar o no los botones de opciones en la lista dependiendo de si el lapso ha finalizado
       */
      $lapsos_finalizados = $GestionarIndicador->seleccionar_lapsos_finalizados($idperiodo_escolar);

      $arreglo_lapsos_finalizados = [];
      if ($lapsos_finalizados->num_rows != 0) {
        while ($resultado = $lapsos_finalizados->fetch_object()) {
          array_push($arreglo_lapsos_finalizados, $resultado->lapso);
        }
      }
      
      if ($rspta->num_rows != 0) {
        while ($reg = $rspta->fetch_object()) {         
  
          $data[] = array('0' => !in_array($reg->lapso_academico, $arreglo_lapsos_finalizados) ? 
            
            '<button class="btn btn-outline-primary " title="Editar" onclick="mostrarProyectoAprendizaje('.$reg->id.')" data-toggle="modal" data-target="#editarProyectoAprendizajeModal"><i class="fas fa-edit"></i></button>'
  
               :
  
             '',
  
               '1' => $reg->lapso_academico.'º Lapso',
               '2' => $reg->proyecto_aprendizaje);
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
	
		$rspta = $GestionarIndicador->mostrar($idindicador);
    
		#Se codifica el resultado utilizando Json
		echo json_encode($rspta);

    break;
    
	case 'mostrarproyectoaprendizaje':
    
		$rspta = $GestionarIndicador->mostrarproyectoaprendizaje($idproyecto_aprendizaje);

		#Se codifica el resultado utilizando Json
		echo json_encode($rspta);

		break;

	case 'eliminar': 

    $rspta = $GestionarIndicador->eliminar($idindicador);
    echo $rspta ? 'true' : 'false';
		break;

  case 'comprobarproyectoaprendizaje': 
    $proyecto_aprendizaje = $GestionarIndicador->comprobar_proyecto_aprendizaje($idplanificacion_indicador, $lapso_indicador);
    $proyecto_aprendizaje = !empty($proyecto_aprendizaje) ? $proyecto_aprendizaje['proyecto_aprendizaje'] : '';

    echo $proyecto_aprendizaje;
    break;

  case 'traerplanificaciones': 
    #Traer la planificaciones activas

    // Se determina el rol que tiene el usuario
    $rol_usuario = isset($_SESSION) ? $_SESSION['rol'] : '';
    $id_usuario = isset($_SESSION) ? $_SESSION['idusuario'] : '';

    $id_docente = $GestionarIndicador->traerpersonal($id_usuario);
    $id_docente = !empty($id_docente) ? $id_docente['id'] : '';

    if ($rol_usuario == 'Docente') {
      $rspta = $GestionarIndicador->traerplanificaciones($id_docente);    
      $data = array();
      if ($rspta->num_rows != 0) {
        while ($reg = $rspta->fetch_object()) {    
          $data[] = [
            'id' => $reg->id,
            'grado' => $reg->grado,
            'seccion' => $reg->seccion,
            'nombre_docente' => $reg->p_nombre,
            'apellido_docente' => $reg->p_apellido
          ];
        }
      }
    }
    else {
      $rspta = $GestionarIndicador->traerplanificaciones();    
      $data = array();
      if ($rspta->num_rows != 0) {
        while ($reg = $rspta->fetch_object()) {    
          $data[] = [
            'id' => $reg->id,
            'grado' => $reg->grado,
            'seccion' => $reg->seccion,
            'nombre_docente' => $reg->p_nombre,
            'apellido_docente' => $reg->p_apellido
          ];
        }
      }
    }
    #Se codifica el resultado utilizando Json
    echo json_encode($data);
    break;

  case 'traermaterias': 
    #Traer la planificaciones activas
    $rspta = $GestionarIndicador->traermaterias();    
    $data = array();
    if ($rspta->num_rows != 0) {
      while ($reg = $rspta->fetch_object()) {    
        $data[] = [
          'id' => $reg->id,
          'materia' => $reg->materia
        ];
      }
    }
    #Se codifica el resultado utilizando Json
    echo json_encode($data);
    break;

  case 'traerlapsos': 
    #Traer lapsos académicos activos
    $idperiodo_escolar = $GestionarIndicador->consultarperiodo();
    $idperiodo_escolar = !empty($idperiodo_escolar) ? $idperiodo_escolar['id'] : '';

    $rspta = $GestionarIndicador->traerlapsos($idperiodo_escolar, $idplanificacion);  

    $data = array();
    if ($rspta->num_rows != 0) {
      while ($reg = $rspta->fetch_object()) {    
        $data[] = [
          'id' => $reg->id,
          'lapso' => $reg->lapso
        ];
      }
    }
    #Se codifica el resultado utilizando Json
    echo json_encode($data);
    break;

    case 'traerlapsosgeneral': 
    #Traer lapsos académicos activos
    $idperiodo_escolar = $GestionarIndicador->consultarperiodo();
    $idperiodo_escolar = !empty($idperiodo_escolar) ? $idperiodo_escolar['id'] : '';

    $rspta = $GestionarIndicador->traerlapsosgeneral($idperiodo_escolar);  

    $data = array();
    if ($rspta->num_rows != 0) {
      while ($reg = $rspta->fetch_object()) {    
        $data[] = [
          'id' => $reg->id,
          'lapso' => $reg->lapso
        ];
      }
    }
    #Se codifica el resultado utilizando Json
    echo json_encode($data);
    break;

}