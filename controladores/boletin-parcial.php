<?php 

#Se inicia la sesión
if (strlen(session_id() < 1)) session_start(); 

#Se incluye el modelo de BoletinParcial
require_once '../modelos/BoletinParcial.php';

#Se instancia el objeto de BoletinParcial
$BoletinParcial = new BoletinParcial();


$idplanificacion = isset($_POST['idplanificacion']) ? limpiarCadena($_POST['idplanificacion']) : '';
$lapso = isset($_POST['lapso']) ? limpiarCadena($_POST['lapso']) : '';
$idboletinparcial = isset($_POST['idboletinparcial']) ? limpiarCadena($_POST['idboletinparcial']) : '';
$lapso_en_curso = isset($_POST['lapso_en_curso']) ? limpiarCadena($_POST['lapso_en_curso']) : '';
$planificacion = isset($_POST['planificacion']) ? limpiarCadena($_POST['planificacion']) : '';
$idestudiantes = isset($_POST['idestudiantes']) ? limpiarCadena($_POST['idestudiantes']) : '';
$notas = isset($_POST['notas']) ? $_POST['notas'] : '';
$recomendacion = isset($_POST['recomendacion']) ? limpiarCadena($_POST['recomendacion']) : '';


#Se ejecuta un caso dependiendo del valor del parámetro GET
switch ($_GET['op']) {

	case 'guardaryeditar':

		#Se deshabilita el guardado automático de la base de datos
		autocommit(FALSE);
    
		#Variable para comprobar que todo salió bien al final
		$sw = TRUE;
    
		#Si la variable esta vacía quiere decir que es un nuevo registro
		if (empty($idboletinparcial)) {
      
      #Se registra el indicador y su nota asociado a un estudiante
			$BoletinParcial->insertar($idplanificacion, $idestudiantes, $lapso_en_curso, $notas) or $sw = FALSE;
      
      $BoletinParcial->insertar_recomendacion($idplanificacion, $idestudiantes, $lapso_en_curso, $recomendacion) or $sw = FALSE;

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

			// #Se edita el indicador
			// $GestionarIndicador->editar($idindicador, $idplanificacion_indicador, $idmateria_indicador, $lapso_indicador, $indicador) or $sw = FALSE;

			// #Se verifica que todo saliío bien y se guardan los datos o se eliminan todos
			// if ($sw) {
			// 	commit();
			// 	echo 'update';
			// }
			// else {
			// 	rollback();
			// 	echo 'false';
			// }
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
    $rspta = $BoletinParcial->traerplanificaciones();    
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
    #Se codifica el resultado utilizando Json
    echo json_encode($data);
    break;

  case 'traerestudiantes': 
    #Traer los estudiantes activas
    $rspta = $BoletinParcial->traerestudiantes($idplanificacion);    
    $data = array();
    if ($rspta->num_rows != 0) {
      while ($reg = $rspta->fetch_object()) {    
        $data[] = [
          'id' => $reg->idestudiante,
          'p_nombre' => ucfirst($reg->p_nombre),
          's_nombre' => ucfirst($reg->s_nombre),
          'p_apellido' => ucfirst($reg->p_apellido),
          's_apellido' => ucfirst($reg->s_apellido)
        ];
      }
    }
    #Se codifica el resultado utilizando Json
    echo json_encode($data);
    break;

  case 'traerlapsoencurso': 
    #Traer lapso académico activo
    $idperiodo_escolar = $BoletinParcial->consultarperiodo();
    $idperiodo_escolar = !empty($idperiodo_escolar) ? $idperiodo_escolar['id'] : '';

    $rspta = $BoletinParcial->traerlapsoencurso($idperiodo_escolar);  

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

    case 'listarindicadores': 
    
    if (!empty($idestudiantes)) {
      $respuesta = $BoletinParcial->seleccionar_notas_estudiante($idestudiantes, $idplanificacion, $lapso_en_curso);

      $indicador_nota = array();
      if ($respuesta->num_rows != 0) {
        while ($fila = $respuesta->fetch_object()) {
          $indicador_nota[$fila->idindicador] =  $fila->nota;
        }
      }

      $rspta = $BoletinParcial->listarindicadores($idplanificacion, $lapso_en_curso);  
      
      if (!empty($indicador_nota)) {
        $data = [];
        $materia_actual = '';
        if ($rspta->num_rows != 0) {
          while ($reg = $rspta->fetch_object()) { 

            $marcar_nota = '';   
            array_key_exists($reg->id, $indicador_nota) ? $marcar_nota = $indicador_nota[$reg->id] : '';
            
            $selects = '';
            if ($marcar_nota == 'C') {
              $selects = 
              '
                <tr>
                  <td>
                    <div class="form-group col-md-12">
                      <div class="input-group ">
                        <select name="notas['.$reg->id.']" class="form-control " required="true">
                          <option value="">Seleccione</option>
                          <option value="C" selected>C - Consolidado</option>
                          <option value="AV">AV - Avanzado</option>
                          <option value="EP">EP - En proceso</option>
                          <option value="I">I - Iniciado</option>
                        </select>
                      </div>
                    </div>
                  </td>
                </tr>
              ';
            }
            else if ($marcar_nota == 'AV'){
              $selects = 
              '
                <tr>
                  <td>
                    <div class="form-group col-md-12">
                      <div class="input-group ">
                        <select name="notas['.$reg->id.']" class="form-control " required="true">
                          <option value="">Seleccione</option>
                          <option value="C" >C - Consolidado</option>
                          <option value="AV" selected>AV - Avanzado</option>
                          <option value="EP">EP - En proceso</option>
                          <option value="I">I - Iniciado</option>
                        </select>
                      </div>
                    </div>
                  </td>
                </tr>
              ';
            }
            else if ($marcar_nota == 'EP') {
              $selects = 
              '
                <tr>
                  <td>
                    <div class="form-group col-md-12">
                      <div class="input-group ">
                        <select name="notas['.$reg->id.']" class="form-control " required="true">
                          <option value="">Seleccione</option>
                          <option value="C">C - Consolidado</option>
                          <option value="AV">AV - Avanzado</option>
                          <option value="EP" selected>EP - En proceso</option>
                          <option value="I">I - Iniciado</option>
                        </select>
                      </div>
                    </div>
                  </td>
                </tr>
              ';
            }
            else if($marcar_nota == 'I') {
              $selects = 
              '
                <tr>
                  <td>
                    <div class="form-group col-md-12">
                      <div class="input-group ">
                        <select name="notas['.$reg->id.']" class="form-control " required="true">
                          <option value="">Seleccione</option>
                          <option value="C">C - Consolidado</option>
                          <option value="AV">AV - Avanzado</option>
                          <option value="EP">EP - En proceso</option>
                          <option value="I" selected>I - Iniciado</option>
                        </select>
                      </div>
                    </div>
                  </td>
                </tr>
              ';
            }
            else {
              $selects = 
              '
                <tr>
                  <td>
                    <div class="form-group col-md-12">
                      <div class="input-group ">
                        <select name="notas['.$reg->id.']" class="form-control " required="true">
                          <option value="">Seleccione</option>
                          <option value="C">C - Consolidado</option>
                          <option value="AV">AV - Avanzado</option>
                          <option value="EP">EP - En proceso</option>
                          <option value="I">I - Iniciado</option>
                        </select>
                      </div>
                    </div>
                  </td>
                </tr>
              ';
            }

            $data[] = array(
              '0' => $reg->materia,
              '1' => $reg->indicador,
              '2' => $selects
            );
            // $materia_actual = $reg->materia;
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
        $data = [];
        $materia_actual = '';
        if ($rspta->num_rows != 0) {
          while ($reg = $rspta->fetch_object()) {    
            $data[] = array(
              '0' => $reg->materia,
              '1' => $reg->indicador,
              '2' => '
                      <tr>
                        <td>
                          <div class="form-group col-md-12">
                            <div class="input-group ">
                              <select name="notas['.$reg->id.']" class="form-control " required="true">
                                <option value="">Seleccione</option>
                                <option value="C">C - Consolidado</option>
                                <option value="AV">AV - Avanzado</option>
                                <option value="EP">EP - En proceso</option>
                                <option value="I">I - Iniciado</option>
                              </select>
                            </div>
                          </div>
                        </td>
                      </tr>
                    '
            );
            // $materia_actual = $reg->materia;
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
    }
    else {
      $results = array(
            "draw" => 0, #Esto tiene que ver con el procesamiento del lado del servidor
            "recordsTotal" => 0, #Se envía el total de registros al datatable
            "recordsFiltered" => 0, #Se envía el total de registros a visualizar
            "data" => '' #datos en un array
          );
    }
    #Se codifica el resultado utilizando Json
		echo json_encode($results);
    break;
}