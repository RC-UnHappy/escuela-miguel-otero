<?php 

#Se inicia la sesión
if (strlen(session_id() < 1)) session_start(); 

#Se incluye el modelo de BoletinParcial
require_once '../modelos/BoletinParcial.php';

#Se instancia el objeto de BoletinParcial
$BoletinParcial = new BoletinParcial();


$idplanificacion = isset($_POST['idplanificacion']) ? limpiarCadena($_POST['idplanificacion']) : '';
$lapso = isset($_POST['lapso']) ? limpiarCadena($_POST['lapso']) : '';
$lapso_en_curso = isset($_POST['lapso_en_curso']) ? limpiarCadena($_POST['lapso_en_curso']) : '';
$planificacion = isset($_POST['planificacion']) ? limpiarCadena($_POST['planificacion']) : '';
$idestudiantes = isset($_POST['idestudiantes']) ? limpiarCadena($_POST['idestudiantes']) : '';
$notas = isset($_POST['notas']) ? $_POST['notas'] : '';
$recomendacion = isset($_POST['recomendacion']) ? limpiarCadena($_POST['recomendacion']) : '';
$idrecomendacion = isset($_POST['idrecomendacion']) ? limpiarCadena($_POST['idrecomendacion']) : '';


#Se ejecuta un caso dependiendo del valor del parámetro GET
switch ($_GET['op']) {

	case 'guardaryeditar':

		#Se deshabilita el guardado automático de la base de datos
		autocommit(FALSE);
    
		#Variable para comprobar que todo salió bien al final
		$sw = TRUE;
    
		#Si la variable redomendación esta vacía quiere decir que es un nuevo registro, porque ella es obligatoria para registrar.
		if (empty($idrecomendacion)) {
      
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
      
      $sw = TRUE;

			#Se eliminan todas las notas del estudiante
			$BoletinParcial->eliminar_indicadores($idplanificacion, $idestudiantes, $lapso_en_curso) or $sw = FALSE;

      #Se registra el indicador y su nota asociado a un estudiante
      $BoletinParcial->insertar($idplanificacion, $idestudiantes, $lapso_en_curso, $notas) or $sw = FALSE;
      
      $BoletinParcial->editar_recomendacion($idrecomendacion, $recomendacion) or $sw = FALSE;

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
    
    $idperiodo_escolar = $BoletinParcial->consultarperiodo();
    $idperiodo_escolar = !empty($idperiodo_escolar) ? $idperiodo_escolar['id'] : '';
    
    /**
     * Lógica para mostrar o no los botones de opciones en la lista dependiendo de si el lapso está activo
     */
    $lapsos_finalizados = $BoletinParcial->seleccionar_lapsos_finalizados($idperiodo_escolar);
    
    $arreglo_lapsos_finalizados = [];
    if ($lapsos_finalizados->num_rows != 0) {
      while ($resultado = $lapsos_finalizados->fetch_object()) {
        array_push($arreglo_lapsos_finalizados, $resultado->lapso);
      }
    }
    
    if (!empty($idplanificacion) && !empty($idestudiantes) && !empty($lapso)){
      $rspta = $BoletinParcial->listar($idplanificacion, $lapso, $idestudiantes);
      
      if ($rspta->num_rows != 0) {
        $solo_uno = 0;
        while ($reg = $rspta->fetch_object()) {
  
          $data[] = array(
          '0' => ($solo_uno) == 0 ? '<a target="_blank" href="../reporte/boletin-informativo.php?idplanificacion='.$idplanificacion.'&lapso='.$lapso.'&idestudiante='.$idestudiantes.'"> <button class="btn btn-primary" title="Boletín Informativo"><i class="fa fa-file"></i></button></a>' : '',
          '1' => $reg->materia,
          '2' => $reg->indicador,
          '3' => $reg->nota);

          $solo_uno = 1;
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

  case 'listarindicadores': 
    
    /**
     * Verifica que idplanificacion no este vacío, si lo está mostrará la tabla en blanco
     */
    if (!empty($idplanificacion)) {
      /**
       * Verifica que idestudiante no esté vacío
       */
      if (!empty($idestudiantes)) {
        $respuesta = $BoletinParcial->seleccionar_notas_estudiante($idestudiantes, $idplanificacion, $lapso_en_curso);
  
        $indicador_nota = array();
        if ($respuesta->num_rows != 0) {
          while ($fila = $respuesta->fetch_object()) {
            $indicador_nota[$fila->idindicador] =  $fila->nota;
          }
        }
  
        $rspta = $BoletinParcial->listarindicadores($idplanificacion, $lapso_en_curso);  
        
        /**
         * Si indicador_nota no está vacío marcará las notas del estudiante, y si está vacío los dejará normal
         */
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
    
	case 'traerrecomendacion':
    
		$rspta = $BoletinParcial->traerrecomendacion($idplanificacion, $idestudiantes, $lapso_en_curso);

		#Se codifica el resultado utilizando Json
		echo json_encode($rspta);

		break;

  case 'traerplanificaciones': 
    #Traer la planificaciones activas

    // Se determina el rol que tiene el usuario
    $rol_usuario = isset($_SESSION) ? $_SESSION['rol'] : '';
    $id_usuario = isset($_SESSION) ? $_SESSION['idusuario'] : '';

    $id_docente = $BoletinParcial->traerpersonal($id_usuario);
    $id_docente = !empty($id_docente) ? $id_docente['id'] : '';

    if ($rol_usuario == 'Docente') {
      $rspta = $BoletinParcial->traerplanificaciones($id_docente);    
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
    }
    #Se codifica el resultado utilizando Json
    echo json_encode($data);
    break;

  case 'traerestudiantes': 
    #Traer los estudiantes activos
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
    $idperiodo_escolar = $BoletinParcial->consultarperiodo();
    $idperiodo_escolar = !empty($idperiodo_escolar) ? $idperiodo_escolar['id'] : '';

    $rspta = $BoletinParcial->traerlapsosgeneral($idperiodo_escolar);  

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