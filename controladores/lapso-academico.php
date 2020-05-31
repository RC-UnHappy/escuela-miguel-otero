<?php 

#Se inicia la sesión
if (strlen(session_id() < 1)) session_start(); 

#Se incluye el modelo de Lapso Académico
require_once '../modelos/LapsoAcademico.php';

#Se instancia el objeto de Lapso Académico
$LapsoAcademico = new LapsoAcademico();

$idperiodo_escolar = isset($_POST['idperiodo_escolar']) ? limpiarCadena($_POST['idperiodo_escolar']) : '';
$idlapsoacademico = isset($_POST['idlapsoacademico']) ? limpiarCadena($_POST['idlapsoacademico']) : '';
$lapso_academico = isset($_POST['lapso_academico']) ? limpiarCadena($_POST['lapso_academico']) : '';
$fecha_inicio = isset($_POST['fecha_inicio']) ? limpiarCadena($_POST['fecha_inicio']) : '';
$fecha_fin = isset($_POST['fecha_fin']) ? limpiarCadena($_POST['fecha_fin']) : '';
$estatus = isset($_POST['estatus']) ? limpiarCadena($_POST['estatus']) : '';

#Se ejecuta un caso dependiendo del valor del parámetro GET
switch ($_GET['op']) {

	case 'guardaryeditar':

		#Se deshabilita el guardado automático de la base de datos
		autocommit(FALSE);

		#Variable para comprobar que todo salió bien al final
		$sw = TRUE;

		#Si la variable esta vacía quiere decir que es un nuevo registro
		if (empty($idlapsoacademico)) {
			
			#Se registra el lapso académico
			$LapsoAcademico->insertar($idperiodo_escolar, $lapso_academico, $fecha_inicio, $fecha_fin , $estatus) or $sw = FALSE;

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
    else {

      #Se edita el lapso académico
			$LapsoAcademico->editar($idlapsoacademico, $fecha_inicio, $fecha_fin) or $sw = FALSE;
      
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

		break;

	case 'listar':
    $periodo_activo = $LapsoAcademico->verificar_periodo_activo();
    $idperiodo_activo = !empty($periodo_activo) ? $periodo_activo['id'] : '';

    $lapso_activo = $LapsoAcademico->verificar_lapso_activo();
    $lapso_activo = !empty($lapso_activo) ? $lapso_activo['lapso'] : '';

    $ultimo_lapso_finalizado = $LapsoAcademico->verificar_fecha_fin_ultimo_lapso($idperiodo_activo);
    $ultimo_lapso_finalizado = !empty($ultimo_lapso_finalizado) ? $ultimo_lapso_finalizado['lapso'] : '';

    $siguiente_lapso = '';

    if ($ultimo_lapso_finalizado != '') {
      $siguiente_lapso = ($ultimo_lapso_finalizado + 1);
    }

		$rspta = $LapsoAcademico->listar($idperiodo_activo);

		if ($rspta->num_rows != 0) {		
			while ($reg = $rspta->fetch_object()) {

        if ($reg->estatus == 'Planificado') {
          $badge = '<span class="badge badge-pill badge-warning">Planificado</span>';
        }
        elseif($reg->estatus == 'Activo'){
          $badge = '<span class="badge badge-pill badge-success">Activo</span>';
        }
        else {
          $badge = '<span class="badge badge-pill badge-danger">Finalizado</span>';
        }
        
        $opciones = '';

        // if ($reg->estatus == 'Activo') {
        //   $opciones = ' <button class="btn btn-outline-danger" title="Finalizar" onclick="finalizar('.$reg->id.')"> <i class="fas fa-times"> </i></button> 
              
        //   <button class="btn btn-outline-primary" title="Editar" onclick="mostrar('.$reg->id.')" data-toggle="modal" data-target="#periodoModal"><i class="fa fa-edit"></i></button>';
        // }
        // elseif($reg->estatus == 'Planificado') {
        //   $opciones = '<button class="btn btn-outline-primary" title="Editar" onclick="mostrar('.$reg->id.')" data-toggle="modal" data-target="#periodoModal"><i class="fa fa-edit"></i></button>';
        // }

        if ($ultimo_lapso_finalizado != '') {
          if ($lapso_activo != '') {
            if ($reg->estatus == 'Activo') {


              $opciones = 

              // Se verifica que tenga el permiso de eliminar para mostrar o no el botón
              ( ( isset($_SESSION['permisos']['lapso-academico']) && 
                  in_array('activar-desactivar' , $_SESSION['permisos']['lapso-academico']) ) ?

              ' <button class="btn btn-outline-danger" title="Finalizar" onclick="finalizar('.$reg->id.')"> <i class="fas fa-times"> </i></button>' : '');


              
              $opciones .= 
              // Se verifica que tenga el permiso de editar para mostrar o no el botón
              ( ( isset($_SESSION['permisos']['lapso-academico']) && 
                      in_array('editar' , $_SESSION['permisos']['lapso-academico']) ) ?

              '<button class="btn btn-outline-primary" title="Editar" onclick="mostrar('.$reg->id.')" data-toggle="modal" data-target="#lapsoModal"><i class="fa fa-edit"></i></button>' : '');
            }
            elseif ($reg->estatus == 'Planificado') {

              $opciones = 

              ( ( isset($_SESSION['permisos']['lapso-academico']) && 
                  in_array('editar' , $_SESSION['permisos']['lapso-academico']) ) ?

              '<button class="btn btn-outline-primary" title="Editar" onclick="mostrar('.$reg->id.')" data-toggle="modal" data-target="#lapsoModal"><i class="fa fa-edit"></i></button>' : '');
            }
            else{
              $opciones = '';
            }
          }
          else{
            if ($siguiente_lapso == $reg->lapso) {

              
              $opciones = 
              ( ( isset($_SESSION['permisos']['lapso-academico']) && 
                      in_array('activar-desactivar' , $_SESSION['permisos']['lapso-academico']) ) ?

              ' <button class="btn btn-outline-success" title="Activar" onclick="activar('.$reg->id.' , '.$reg->lapso.')"><i class="fa fa-check"></i></button> ' : '');

            }
            elseif ($reg->estatus == 'Planificado') {

              $opciones = 

              ( ( isset($_SESSION['permisos']['lapso-academico']) && 
                  in_array('editar' , $_SESSION['permisos']['lapso-academico']) ) ?

              '<button class="btn btn-outline-primary" title="Editar" onclick="mostrar('.$reg->id.')" data-toggle="modal" data-target="#lapsoModal"><i class="fa fa-edit"></i></button>' : '');
            }
            else {
              $opciones = '';
            }
          }
        }
        else{
          
          if ($lapso_activo != '' ) {
            if ($reg->estatus == 'Activo') {

              $opciones =

              ( ( isset($_SESSION['permisos']['lapso-academico']) && 
                  in_array('activar-desactivar' , $_SESSION['permisos']['lapso-academico']) ) ?

              '<button class="btn btn-outline-danger" title="Finalizar" onclick="finalizar('.$reg->id.')"> <i class="fas fa-times"> </i></button>' : '');

              $opciones .=

              ( ( isset($_SESSION['permisos']['lapso-academico']) && 
                  in_array('editar' , $_SESSION['permisos']['lapso-academico']) ) ?

              '<button class="btn btn-outline-primary" title="Editar" onclick="mostrar('.$reg->id.')" data-toggle="modal" data-target="#lapsoModal"><i class="fa fa-edit"></i></button>' : '');

            }
            else {
              $opciones = 

              ( ( isset($_SESSION['permisos']['lapso-academico']) && 
                  in_array('editar' , $_SESSION['permisos']['lapso-academico']) ) ?

              '<button class="btn btn-outline-primary" title="Editar" onclick="mostrar('.$reg->id.')" data-toggle="modal" data-target="#lapsoModal"><i class="fa fa-edit"></i></button>' : '');
            }
          }
          else {
            if ($reg->lapso == 1) {
              $opciones = 

              ( ( isset($_SESSION['permisos']['lapso-academico']) && 
                  in_array('activar-desactivar' , $_SESSION['permisos']['lapso-academico']) ) ?

              ' <button class="btn btn-outline-success" title="Activar" onclick="activar('.$reg->id.' , '.$reg->lapso.')"><i class="fa fa-check"></i></button>' : '');

              $opciones .= 

              ( ( isset($_SESSION['permisos']['lapso-academico']) && 
                  in_array('editar' , $_SESSION['permisos']['lapso-academico']) ) ?

              '<button class="btn btn-outline-primary" title="Editar" onclick="mostrar('.$reg->id.')" data-toggle="modal" data-target="#lapsoModal"><i class="fa fa-edit"></i></button>' : '');     
            }
            else {
              $opciones =

              ( ( isset($_SESSION['permisos']['lapso-academico']) && 
                  in_array('editar' , $_SESSION['permisos']['lapso-academico']) ) ?

              '<button class="btn btn-outline-primary" title="Editar" onclick="mostrar('.$reg->id.')" data-toggle="modal" data-target="#lapsoModal"><i class="fa fa-edit"></i></button>' : '');  
            }
          }
          
        }

        list($ano_creacion, $mes_creacion, $dia_creacion) = explode('-',$reg->fecha_inicio);
        $fecha_creacion = $dia_creacion.'-'.$mes_creacion.'-'.$ano_creacion;

        list($ano_finalizacion, $mes_finalizacion, $dia_finalizacion) = explode('-',$reg->fecha_fin);
        $fecha_finalizacion = $dia_finalizacion.'-'.$mes_finalizacion.'-'.$ano_finalizacion;

        $data[] = array('0' => $opciones,

            '1' => $reg->lapso,
            '2' => $fecha_creacion,
            '3' => $fecha_finalizacion,
					 	'4' => $badge);
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
    
  case 'activar': 

		#Se deshabilita el guardado automático de la base de datos
		autocommit(FALSE);

		#Variable para comprobar que todo salió bien al final
    $sw = TRUE;
    
    if ($lapso_academico == 1) {
      
      // Aquí se verifica que todos los estudiantes que tengan un estatus de inscrito, tengan una inscripción activa antes de iniciar el lapso
      $verificar_ultima_inscripcion = $LapsoAcademico->verificar_ultima_inscripcion();
      
      // var_dump($verificar_ultima_inscripcion);
      // die;
      if ($verificar_ultima_inscripcion->num_rows != 0) {
        while ($reg = $verificar_ultima_inscripcion->fetch_object()) {
          if ($reg->estatus != 'CURSANDO') {
            echo 'estudiantes_no_inscritos';
            die;
          }
        }
      }    
    }
		
		$rspta = $LapsoAcademico->activar($idlapsoacademico) or $sw = FALSE;

		#Se verifica que todo saliío bien y se guardan los datos o se eliminan todos
		if ($sw) {
			commit();
			echo 'true';
		}
		else {
			rollback();
			echo 'false';
		}

		break;

	case 'finalizar': 

		#Se deshabilita el guardado automático de la base de datos
		autocommit(FALSE);

		#Variable para comprobar que todo salió bien al final
    $sw = TRUE;

    $periodo_activo = $LapsoAcademico->verificar_periodo_activo();
    $idperiodo_activo = !empty($periodo_activo) ? $periodo_activo['id'] : '';

    $lapso_activo = $LapsoAcademico->verificar_lapso_activo();
    $lapso_activo = !empty($lapso_activo) ? $lapso_activo['lapso'] : '';
    
    // Se traen las planificaciones activas
    $planificaciones = $LapsoAcademico->traer_planificaciones_activas();

    // Aquí se almacenan los id de todas las planificaciones activas
    $arreglo_planificaciones = [];
    if ($planificaciones->num_rows != 0) {
      while ($reg = $planificaciones->fetch_object()) {
        array_push($arreglo_planificaciones, $reg->id);
      }
    }

    // Aquí consulto cuantos indicadores ha creado cada planificación (profesor), y la cantidad de indicadores la ingreso en un arreglo que tiene por indice el id de la planificación
    $total_indicadores_planificacion = [];
    foreach ($arreglo_planificaciones as $key => $value) {
      $total_indicadores = $LapsoAcademico->traer_total_indicadores($value, $lapso_activo);
      $total_indicadores_planificacion[$value] = $total_indicadores['total'];
    }


    $estudiantes_planificacion = [];
    /**
     * Aquí traigo todas la inscripciones de cada planificación, y luego en un arreglo ingreso todos los id de todos los estudiantes agrupados por el id de la planificación
     */
    foreach ($arreglo_planificaciones as $key => $value) {
      $idestudiantes = $LapsoAcademico->traer_inscripciones_planificacion($value, $idperiodo_activo);

      if ($idestudiantes->num_rows != 0) {
        while ($reg = $idestudiantes->fetch_object()) {
          $estudiantes_planificacion[$value][] = $reg->idestudiante;
        }
      }
    }


    /**
     * Aquí se verifica que el estudiante tenga la misma cantidad de indicadores corregidos como indicadores haya creado el docente para ese lapso
    */
    $estudiantes_sin_notas_completas = [];
    foreach ($estudiantes_planificacion as $key => $value) {
      $cantidad_indicadores = $total_indicadores_planificacion[$key];

      foreach ($value as $key1 => $value1) {
        $cantidad_indicadores_estudiante = $LapsoAcademico->comprobar_cantidad_indicadores_estudiante($key, $value1, $lapso_activo);

        $cantidad_indicadores_estudiante = !empty($cantidad_indicadores_estudiante) ? $cantidad_indicadores_estudiante['cantidad_notas'] : '';


        if ($cantidad_indicadores != $cantidad_indicadores_estudiante) {
          $estudiantes_sin_notas_completas[$key][] = $value1;
        }
      }
    }



    if (!empty($estudiantes_sin_notas_completas)) {
      $collapse = '<div class="accordion" id="accordionExample">';
      foreach ($estudiantes_sin_notas_completas as $key => $value) {
        $datos_planificacion = $LapsoAcademico->traerplanificacion($key);
        
        $collapse .= '
          
            <div class="card">
              <div class="card-header" id="heading'.$key.'">
                <h2 class="mb-0">
                  <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse'.$key.'" aria-expanded="true" aria-controls="collapse'.$key.'">
                    '.$datos_planificacion['grado'].'º "'.$datos_planificacion['seccion'].'" - '.$datos_planificacion['p_nombre'].' '.$datos_planificacion['p_apellido'].'
                  </button>
                </h2>
              </div>

              <div id="collapse'.$key.'" class="collapse show" aria-labelledby="heading'.$key.'" data-parent="#accordionExample">
                <div class="card-body">
                  <ul class="list-group">';
                    foreach ($value as $key2 => $value2) {
                      $datos_estudiante = $LapsoAcademico->traerestudiante($value2);
                      $collapse .= '<li class="list-group-item">'.$datos_estudiante['cedula'].' - '.ucfirst($datos_estudiante['p_nombre']).' '.ucfirst($datos_estudiante['p_apellido']).'</li>';
                    }

        $collapse .= 
                '</ul>
              </div>
            </div>
          </div>';
        // var_dump($collapse);
        // die;
      }
      $collapse .= '</div>';

      echo $collapse;
    }
    else {

      // $ultimo_lapso = $LapsoAcademico->traerultimolapso($idperiodo_activo);
      // if ($ultimo_lapso['id'] == $idlapsoacademico) {
      //   $LapsoAcademico->finalizarplanificaciones($idperiodo_activo) or $sw = FALSE;
      //   $LapsoAcademico->finalizarpic($idperiodo_activo) or $sw = FALSE;
      // }

      $rspta = $LapsoAcademico->finalizar($idlapsoacademico) or $sw = FALSE;
  
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
		

    break;
    
  case 'mostrar':
	
		$rspta = $LapsoAcademico->mostrar($idlapsoacademico);

		#Se codifica el resultado utilizando Json
		echo json_encode($rspta);

		break;

	case 'traerlapsos': 

    $idperiodo_escolar = $LapsoAcademico->verificar_periodo_activo();
    $idperiodo_escolar = !empty($idperiodo_escolar) ? $idperiodo_escolar['id'] : '';

    $rspta = $LapsoAcademico->traerlapsos($idperiodo_escolar);
    
    $data = array();
		if ($rspta->num_rows != 0) {
			while ($reg = $rspta->fetch_object()) {

				$data[] = ['id' => $reg->id,
                   'lapso' => $reg->lapso];
			}
		}
		#Se codifica el resultado utilizando Json
		echo json_encode($data);
  break;
  
  case 'verificarfechainicio':
    $fecha_inicio = isset($_POST['fecha_inicio']) ? $_POST['fecha_inicio'] : '';
    $lapso_academico = isset($_POST['lapso_academico']) ? $_POST['lapso_academico'] : '';
    $periodo_escolar = isset($_POST['periodo_escolar']) ? $_POST['periodo_escolar'] : '';
    /**
     * Si el lapso es igual a 1 entonces verificará la fecha de fin del último lapso del período anterior
     */
    if ($lapso_academico == 1) {

      // Primero se verificará que la fecha de inicio del lapso sea igual o mayor que la del período escolar
      $periodoactivo = $LapsoAcademico->verificar_periodo_activo();
      
      if (!empty($periodoactivo)) {
        if ($fecha_inicio < $periodoactivo['fecha_creacion']) {
          echo 'fecha_inicio_erronea';
          die;
        }
      }


      list($ano_inicio, $ano_fin) = explode('-', $periodo_escolar);
      $periodo_anterior = ($ano_inicio - 1).'-'.($ano_fin - 1);
      
      $periodo_anterior = $LapsoAcademico->verificar_por_periodo($periodo_anterior);
      $idperiodo_anterior = !empty($periodo_anterior) ? $periodo_anterior['id'] : '';
      
      if ($idperiodo_anterior != '') {
        $fecha_fin_lapso_anterior = $LapsoAcademico->verificar_fecha_fin_ultimo_lapso($idperiodo_anterior);
        $fecha_fin_lapso_anterior = !empty($fecha_fin_lapso_anterior) ? $fecha_fin_lapso_anterior['fecha_fin'] : '';
        
        echo ($fecha_inicio > $fecha_fin_lapso_anterior) ? 'true' : 'false';      
      }
      else {
        echo 'true'; 
      }
    }
    /**
     * Si el lapso es diferente de 1 entonces le restará 1 y buscará la fecha de fin del lapso anterior
     */
    else {
      
      $lapso_academico = ($lapso_academico - 1);
      $idperiodo_escolar = $LapsoAcademico->verificar_por_periodo($periodo_escolar);
      $idperiodo_escolar = !empty($idperiodo_escolar) ? $idperiodo_escolar['id'] : '';
      
      $fecha_fin_lapso_anterior = $LapsoAcademico->verificar_fecha_fin_lapso($lapso_academico, $idperiodo_escolar);
      $fecha_fin_lapso_anterior = !empty($fecha_fin_lapso_anterior) ? $fecha_fin_lapso_anterior['fecha_fin'] : '';
      
      echo ($fecha_inicio > $fecha_fin_lapso_anterior && $fecha_fin_lapso_anterior != '') ? 'true' : 'false';
    }

    break;

  case 'verificarfechafin':
    $fecha_fin = isset($_POST['fecha_fin']) ? $_POST['fecha_fin'] : '';

    // Primero se verificará que la fecha de fin del lapso sea menor o igual que la del período escolar
      $periodoactivo = $LapsoAcademico->verificar_periodo_activo();
      
      if (!empty($periodoactivo)) {
        if ($fecha_fin > $periodoactivo['fecha_finalizacion']) {
          echo 'fecha_fin_erronea';
          die;
        }
      }

    $lapso_academico = isset($_POST['lapso_academico']) ? $_POST['lapso_academico'] : '';
    $periodo_escolar = isset($_POST['periodo_escolar']) ? $_POST['periodo_escolar'] : '';
    $idperiodo_escolar = $LapsoAcademico->verificar_por_periodo($periodo_escolar);
    $idperiodo_escolar = !empty($idperiodo_escolar) ? $idperiodo_escolar['id'] : '';

    $lapso_academico = ($lapso_academico + 1);
    $fecha_inicio_lapso_siguiente = $LapsoAcademico->verificar_fecha_inicio_lapso($lapso_academico, $idperiodo_escolar);
    $fecha_inicio_lapso_siguiente = !empty($fecha_inicio_lapso_siguiente) ? $fecha_inicio_lapso_siguiente['fecha_inicio'] : '';
    
    echo ($fecha_fin < $fecha_inicio_lapso_siguiente || $fecha_inicio_lapso_siguiente == '') ? 'true' : 'false';

    break;

  case 'traerperiodoactivo':
    
    $periodo_actual = $LapsoAcademico->verificar_periodo_activo();
    echo json_encode($periodo_actual);
    
    break;

}