<?php 

#Se inicia la sesión
if (strlen(session_id() < 1)) session_start(); 

#Se incluye el modelo de BoletinParcial
require_once '../modelos/BoletinFinal.php';

#Se instancia el objeto de BoletinFinal
$BoletinFinal = new BoletinFinal();


$idplanificacion = isset($_POST['idplanificacion']) ? limpiarCadena($_POST['idplanificacion']) : '';
$idestudiantes = isset($_POST['idestudiantes']) ? limpiarCadena($_POST['idestudiantes']) : '';
$idliteral = isset($_POST['idliteral']) ? $_POST['idliteral'] : '';
$descriptivo_final = isset($_POST['descriptivo_final']) ? limpiarCadena($_POST['descriptivo_final']) : '';
$idboletinfinal = isset($_POST['idboletinfinal']) ? limpiarCadena($_POST['idboletinfinal']) : '';

$return = new stdClass;
$return->estatus = 1;
$return->idpersona = '';
$return->idestudiante = '';
$return->grado = '';
$return->literal = '';
$return->teacherId = '';
$return->msj = '';

#Se ejecuta un caso dependiendo del valor del parámetro GET
switch ($_GET['op']) {

	case 'guardaryeditar':

		#Se deshabilita el guardado automático de la base de datos
		autocommit(FALSE);
    
		#Variable para comprobar que todo salió bien al final
		$sw = TRUE;
    
		#Si la variable idboletinfinal esta vacía quiere decir que es un nuevo registro
		if (empty($idboletinfinal)) {

      
      #Se registra el boletin final a un estudiante
      $BoletinFinal->insertar($idplanificacion, $idestudiantes, $idliteral, $descriptivo_final) or $sw = FALSE;

      #Se obtiene la nota literal
      $literal = $BoletinFinal->obtener_literal($idliteral);
      $literal = !empty($literal) ? $literal['literal'] : '';
      
      #Se cambia el estatus de la inscripción dependiendo del literal asignado
			$BoletinFinal->cambiar_estatus_inscripcion($idplanificacion, $idestudiantes, $literal) or $sw = FALSE;

      $scheduleData = $BoletinFinal->getSchedule($idplanificacion);
      $grade = !empty($scheduleData) ? $scheduleData['grado'] : '';

      // 6to grado es el máximo grado que se cursa en una escuela básica
      if ($grade == 6) {

        if ($literal == 'A' || $literal == 'B' || $literal == 'C' || $literal == 'D') {

          try {

            if ( !empty($idestudiantes)  ) {

              $personId = $BoletinFinal->getPersonFromStudent($idestudiantes);

              if (empty($personId)) {
                throw new Exception('Error al obtener los datos personales del estudiante', 1);
              }

              $personId = $personId['id'];

              $studentRegistrations = $BoletinFinal->getRegistrations($idestudiantes);

              // Se guardarán todas las inscripciones del estudiante
              $inscripciones = [];

              // Si hay inscripciones
              if ($studentRegistrations->num_rows != 0) {

                // Se itera sobre cada inscripcion
                while ($reg = $studentRegistrations->fetch_object()) {
                  
                  $recordHistory = $BoletinFinal->retire($reg->periodo, $reg->turno, $reg->grado, $reg->seccion, $reg->cedula_docente, $reg->nombre_docente, $reg->apellido_docente, $reg->cedula_estudiante, $reg->p_nombre_estudiante, $reg->s_nombre_estudiante, $reg->p_apellido_estudiante, $reg->s_apellido_estudiante, $reg->f_nac_estudiante, $reg->municipio, $reg->genero_estudiante, $reg->literal, $reg->observaciones, $reg->estatus);


                  if (!$recordHistory) throw new Exception('Error al registrar alguna inscripción en el historial', 1);
                  
                  // Aquí se verifica que el representante del estudiante no sea ni representante, madre, o padre, ni personal de la institución para poder eliminarlo
                  $verificar_representante_inscripcion = $BoletinFinal->verificar_representante_inscripcion($reg->idrepresentante, $reg->idestudiante);

                  $verificar_representante_padre = $BoletinFinal->verificar_padre_idrepresentante($reg->idrepresentante, $reg->idestudiante);

                  $verificar_representante_personal = $BoletinFinal->verificar_personal($reg->idrepresentante);

                  if ( empty($verificar_representante_inscripcion) && empty($verificar_representante_padre) && empty($verificar_representante_personal) ) {
                    
                    $eliminar_persona_representante = $BoletinFinal->eliminar_persona_representante($reg->idrepresentante);

                    if (!$eliminar_persona_representante) throw new Exception('Error al eliminar a la persona representante', 1);
                  }

                  // Aquí se verifica que el padre del estudiante no sea ni padre ni representante de otro estudiante ni personal
                  $verificar_padre_inscripcion = $BoletinFinal->verificar_representante_idpersona($reg->idpadre, $reg->idestudiante);
                  
                  $verificar_padre = $BoletinFinal->verificar_padre($reg->idpadre, $reg->idestudiante);

                  $verificar_padre_personal = $BoletinFinal->verificar_padre_personal($reg->idpadre);

                  if ( empty($verificar_padre_inscripcion) && empty($verificar_padre) && empty($verificar_padre_personal) ) {
                    
                    $eliminar_persona_padre = $BoletinFinal->eliminar_persona_padre($reg->idpadre);

                    if (!$eliminar_persona_padre) throw new Exception('Error al eliminar a la persona padre', 1);
                  }


                  // Aquí se verifica que la madre del estudiante no sea ni madre ni representante de otro estudiante ni personal
                  $verificar_madre_inscripcion = $BoletinFinal->verificar_representante_idpersona($reg->idmadre, $reg->idestudiante);
                  
                  $verificar_madre = $BoletinFinal->verificar_padre($reg->idmadre, $reg->idestudiante);
                  
                  $verificar_madre_personal = $BoletinFinal->verificar_padre_personal($reg->idmadre);

                  if ( empty($verificar_madre_inscripcion) && empty($verificar_madre) && empty($verificar_madre_personal) ) {
                    
                    $eliminar_persona_madre = $BoletinFinal->eliminar_persona_padre($reg->idmadre);

                    if (!$eliminar_persona_madre) throw new Exception('Error al eliminar a la persona madre', 1);
                  }

                } // <- cierre del while

              } // <- cierre del if
              
              // Se elimina el estudiante de la tabla persona
              $eliminar_estudiante = $BoletinFinal->eliminar($personId);
              if (!$eliminar_estudiante) throw new Exception('Error al eliminar a la persona estudiante', 1);


            } // <- cierre del if que verifica que no esté vacío idestudiantes
            else {

              throw new Exception("Faltan datos necesarios", 1);
            
            }

          }
          catch (Exception $e) {

            // Se deshacen los cambios en la bd
            rollback();

            $return->estatus = 3;
            $return->msj = $e->getMessage();
            echo json_encode($return);
          }

        }
        
      }

    // Se guardan los datos en la bd  
    commit();

    $idpersona = $BoletinFinal->getPersonFromStudent($idestudiantes);
    $idpersona = !empty($idpersona) ? $idpersona['id'] : '';

    // Se envía el mensaje al front
    $return->msj = 'Boletín final registrado exitosamente';
    // $return->idpersona = $idpersona;
    // $return->idestudiante = $idestudiantes;
    // $return->grado = $grade;
    // $return->literal = $literal;
    // $return->teacherId = $scheduleData['iddocente'];
    echo json_encode($return);

			// #Se verifica que todo saliío bien y se guardan los datos o se eliminan todos
			// if ($sw) {
			// 	commit();
			// 	echo 'true';
			// }
			// else {
			// 	rollback();
			// 	echo 'false';
			// }

		}
		else{
      
      $sw = TRUE;
      
      // Se edita el boletín final
      $BoletinFinal->editar($idboletinfinal, $idliteral, $descriptivo_final) or $sw = FALSE;

      #Se obtiene la nota literal
      $literal = $BoletinFinal->obtener_literal($idliteral);
      $literal = !empty($literal) ? $literal['literal'] : '';
      
      #Se cambia el estatus de la inscripción dependiendo del literal asignado
      $esto = $BoletinFinal->cambiar_estatus_inscripcion($idplanificacion, $idestudiantes, $literal) or $sw = FALSE;

      $scheduleData = $BoletinFinal->getSchedule($idplanificacion);
      $grade = !empty($scheduleData) ? $scheduleData['grado'] : '';

      // 6to grado es el máximo grado que se cursa en una escuela básica
      if ($grade == 6) {

        if ($literal == 'A' || $literal == 'B' || $literal == 'C' || $literal == 'D') {

          try {

            if ( !empty($idestudiantes)  ) {

              $personId = $BoletinFinal->getPersonFromStudent($idestudiantes);

              if (empty($personId)) {
                throw new Exception('Error al obtener los datos personales del estudiante', 1);
              }

              $personId = $personId['id'];

              $studentRegistrations = $BoletinFinal->getRegistrations($idestudiantes);

              // Se guardarán todas las inscripciones del estudiante
              $inscripciones = [];

              // Si hay inscripciones
              if ($studentRegistrations->num_rows != 0) {

                // Se itera sobre cada inscripcion
                while ($reg = $studentRegistrations->fetch_object()) {
                  
                  $recordHistory = $BoletinFinal->retire($reg->periodo, $reg->turno, $reg->grado, $reg->seccion, $reg->cedula_docente, $reg->nombre_docente, $reg->apellido_docente, $reg->cedula_estudiante, $reg->p_nombre_estudiante, $reg->s_nombre_estudiante, $reg->p_apellido_estudiante, $reg->s_apellido_estudiante, $reg->f_nac_estudiante, $reg->municipio, $reg->genero_estudiante, $reg->literal, $reg->observaciones, $reg->estatus);


                  if (!$recordHistory) throw new Exception('Error al registrar alguna inscripción en el historial', 1);
                  
                  // Aquí se verifica que el representante del estudiante no sea ni representante, madre, o padre, ni personal de la institución para poder eliminarlo
                  $verificar_representante_inscripcion = $BoletinFinal->verificar_representante_inscripcion($reg->idrepresentante, $reg->idestudiante);

                  $verificar_representante_padre = $BoletinFinal->verificar_padre_idrepresentante($reg->idrepresentante, $reg->idestudiante);

                  $verificar_representante_personal = $BoletinFinal->verificar_personal($reg->idrepresentante);

                  if ( empty($verificar_representante_inscripcion) && empty($verificar_representante_padre) && empty($verificar_representante_personal) ) {
                    
                    $eliminar_persona_representante = $BoletinFinal->eliminar_persona_representante($reg->idrepresentante);

                    if (!$eliminar_persona_representante) throw new Exception('Error al eliminar a la persona representante', 1);
                  }

                  // Aquí se verifica que el padre del estudiante no sea ni padre ni representante de otro estudiante ni personal
                  $verificar_padre_inscripcion = $BoletinFinal->verificar_representante_idpersona($reg->idpadre, $reg->idestudiante);
                  
                  $verificar_padre = $BoletinFinal->verificar_padre($reg->idpadre, $reg->idestudiante);

                  $verificar_padre_personal = $BoletinFinal->verificar_padre_personal($reg->idpadre);

                  if ( empty($verificar_padre_inscripcion) && empty($verificar_padre) && empty($verificar_padre_personal) ) {
                    
                    $eliminar_persona_padre = $BoletinFinal->eliminar_persona_padre($reg->idpadre);

                    if (!$eliminar_persona_padre) throw new Exception('Error al eliminar a la persona padre', 1);
                  }


                  // Aquí se verifica que la madre del estudiante no sea ni madre ni representante de otro estudiante ni personal
                  $verificar_madre_inscripcion = $BoletinFinal->verificar_representante_idpersona($reg->idmadre, $reg->idestudiante);
                  
                  $verificar_madre = $BoletinFinal->verificar_padre($reg->idmadre, $reg->idestudiante);
                  
                  $verificar_madre_personal = $BoletinFinal->verificar_padre_personal($reg->idmadre);

                  if ( empty($verificar_madre_inscripcion) && empty($verificar_madre) && empty($verificar_madre_personal) ) {
                    
                    $eliminar_persona_madre = $BoletinFinal->eliminar_persona_padre($reg->idmadre);

                    if (!$eliminar_persona_madre) throw new Exception('Error al eliminar a la persona madre', 1);
                  }

                } // <- cierre del while

              } // <- cierre del if
              
              // Se elimina el estudiante de la tabla persona
              $eliminar_estudiante = $BoletinFinal->eliminar($personId);
              if (!$eliminar_estudiante) throw new Exception('Error al eliminar a la persona estudiante', 1);

            } // <- cierre del if que verifica que no esté vacío idestudiantes
            else {

              throw new Exception("Faltan datos necesarios", 1);
            
            }

          }
          catch (Exception $e) {

            // Se deshacen los cambios en la bd
            rollback();

            $return->estatus = 3;
            $return->msj = $e->getMessage();
            echo json_encode($return);
          }

        }
        
      }


      // Se guardan los datos en la bd  
      commit();

      // Se envía el mensaje al front
      $return->estatus = 2;
      $return->msj = 'Boletín final modificado exitosamente';
      // $return->idpersona = $idpersona;
      // $return->idestudiante = $idestudiantes;
      // $return->grado = $grade;
      // $return->literal = $literal;
      // $return->teacherId = $scheduleData['iddocente'];
      echo json_encode($return);
      
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

  case 'listar':
    
    if (!empty($idplanificacion) ){
      $rspta = $BoletinFinal->listar($idplanificacion);
      
      if ($rspta->num_rows != 0) {
        while ($reg = $rspta->fetch_object()) {
  
          $data[] = array(
          '0' =>
          ( ( isset($_SESSION['permisos']['boletin-final']) && 
            in_array('ver' , $_SESSION['permisos']['boletin-final']) ) ?

          '<a target="_blank" href="../reporte/boletin-final.php?idplanificacion='.$idplanificacion.'&idestudiante='.$reg->idestudiante.'"> <button class="btn btn-primary" title="Boletín Informativo Final"><i class="fa fa-file"></i></button></a>' : '').

          ( ( isset($_SESSION['permisos']['boletin-final']) && 
                      in_array('editar' , $_SESSION['permisos']['boletin-final']) ) ?

          ' <button class="btn btn-outline-primary" title="Editar" onclick="mostrar('.$reg->id.')" data-toggle="modal" data-target="#boletinFinalModal"><i class="fa fa-edit"></i></button>' : ''),

          '1' => $reg->cedula.' - '.ucwords($reg->p_nombre. ' '. $reg->p_apellido),
          '2' => $reg->literal,
          '3' => $reg->descriptivo_final);

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

  case 'traerplanificaciones': 
    #Traer las planificaciones cuando todos los lapsos esten finalizados
    $periodo_escolar = $BoletinFinal->consultarperiodo();
    $idperiodo_escolar = !empty($periodo_escolar) ? $periodo_escolar['id'] : '';

    // Se determina el rol que tiene el usuario
    $rol_usuario = isset($_SESSION) ? $_SESSION['rol'] : '';
    $id_usuario = isset($_SESSION) ? $_SESSION['idusuario'] : '';

    $id_docente = $BoletinFinal->traerpersonal($id_usuario);
    $id_docente = !empty($id_docente) ? $id_docente['id'] : '';

    if ($rol_usuario == 'Docente') {
      $rspta = $BoletinFinal->traerplanificaciones($idperiodo_escolar, $id_docente);    
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
      $rspta = $BoletinFinal->traerplanificaciones($idperiodo_escolar);    

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
    $rspta = $BoletinFinal->traerestudiantes($idplanificacion);    
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

  case 'traerliterales': 
    #Traer las notas literales

    $rspta = $BoletinFinal->traerliterales();  

    $data = array();
    if ($rspta->num_rows != 0) {
      while ($reg = $rspta->fetch_object()) {    
        $data[] = [
          'id' => $reg->id,
          'literal' => $reg->literal,
          'interpretacion' => $reg->interpretacion
        ];
      }
    }
    #Se codifica el resultado utilizando Json
    echo json_encode($data);
    break;

  case 'mostrar':

  $rspta = $BoletinFinal->mostrar($idboletinfinal);

  #Se codifica el resultado utilizando Json
  echo json_encode($rspta);

  break;

  case 'reporteboletapromocion':

    #Se obtiene la nota literal
    $literal = $BoletinFinal->obtener_literal($idliteral);
    $literal = !empty($literal) ? $literal['literal'] : '';

    $idpersona = $BoletinFinal->getPersonFromStudent($idestudiantes);
    $idpersona = !empty($idpersona) ? $idpersona['id'] : '';

    $scheduleData = $BoletinFinal->getSchedule($idplanificacion);
    $grade = !empty($scheduleData) ? $scheduleData['grado'] : '';

    if ($literal == 'A' || $literal == 'B' || $literal == 'C' || $literal == 'D')
    {
      $return->idpersona = $idpersona;
      $return->idestudiante = $idestudiantes;
      $return->grado = $grade;
      $return->literal = $literal;
      $return->teacherId = $scheduleData['iddocente'];
      echo json_encode($return);
    }
  break;

}