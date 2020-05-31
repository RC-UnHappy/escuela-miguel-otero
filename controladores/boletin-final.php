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
      
      // Se edita el boletín final
      $BoletinFinal->editar($idboletinfinal, $idliteral, $descriptivo_final) or $sw = FALSE;

      #Se obtiene la nota literal
      $literal = $BoletinFinal->obtener_literal($idliteral);
      $literal = !empty($literal) ? $literal['literal'] : '';
      
      #Se cambia el estatus de la inscripción dependiendo del literal asignado
      $esto = $BoletinFinal->cambiar_estatus_inscripcion($idplanificacion, $idestudiantes, $literal) or $sw = FALSE;
      
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

}