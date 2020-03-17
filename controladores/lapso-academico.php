<?php 

#Se inicia la sesión
if (strlen(session_id() < 1)) session_start(); 

#Se incluye el modelo de Período Escolar
require_once '../modelos/PeriodoEscolar.php';

#Se instancia el objeto de Período Escolar
$PeriodoEscolar = new PeriodoEscolar();

$idperiodo = isset($_POST['idperiodo']) ? limpiarCadena($_POST['idperiodo']) : '';
$periodo = isset($_POST['periodo']) ? limpiarCadena($_POST['periodo']) : '';
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
		if (empty($idperiodo)) {
			
			#Se registra el período escolar 
			$PeriodoEscolar->insertar($periodo, $fecha_inicio, $fecha_fin, $estatus) or $sw = FALSE;

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
      #Se edita el período escolar 
			$PeriodoEscolar->editar($idperiodo, $periodo, $fecha_inicio, $fecha_fin, $estatus) or $sw = FALSE;

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

		$rspta = $PeriodoEscolar->listar();
    
    $ultimo_periodo_finalizado = $PeriodoEscolar->verificar_ultimo_finalizado();
    $ultimo_periodo_finalizado = !empty($ultimo_periodo_finalizado) ? $ultimo_periodo_finalizado['periodo'] : '';
    $siguiente_periodo = '';
    if ($ultimo_periodo_finalizado != '') {
      list($primer_ano, $segundo_ano) = explode('-', $ultimo_periodo_finalizado);
      $siguiente_periodo = ($primer_ano + 1).'-'.($segundo_ano + 1);
    }

    $periodo_activo = $PeriodoEscolar->verificar_periodo_activo();
    $periodo_activo = !empty($periodo_activo) ? $periodo_activo['periodo'] : '';

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
        if ($ultimo_periodo_finalizado != '') {
          if ($periodo_activo != '') {
            if ($reg->estatus == 'Activo') {
              $opciones = ' <button class="btn btn-outline-danger" title="Finalizar" onclick="finalizar('.$reg->id.')"> <i class="fas fa-times"> </i></button> 
              
              <button class="btn btn-outline-primary" title="Editar" onclick="mostrar('.$reg->id.')" data-toggle="modal" data-target="#periodoModal"><i class="fa fa-edit"></i></button>';
            }
            elseif ($reg->estatus == 'Planificado') {
              $opciones = '<button class="btn btn-outline-primary" title="Editar" onclick="mostrar('.$reg->id.')" data-toggle="modal" data-target="#periodoModal"><i class="fa fa-edit"></i></button>';
            }
            else{
              $opciones = '';
            }
          }
          else{
            if ($siguiente_periodo == $reg->periodo) {
              $opciones = ' <button class="btn btn-outline-success" title="Activar" onclick="activar('.$reg->id.')"><i class="fa fa-check"></i></button> ';
            }
            elseif ($reg->estatus == 'Planificado') {
              $opciones = '<button class="btn btn-outline-primary" title="Editar" onclick="mostrar('.$reg->id.')" data-toggle="modal" data-target="#periodoModal"><i class="fa fa-edit"></i></button>';
            }
            else {
              $opciones = '';
            }
          }
        }
        else{
          
          if ($periodo_activo != '' ) {
            if ($reg->estatus == 'Activo') {
              $opciones = '<button class="btn btn-outline-danger" title="Finalizar" onclick="finalizar('.$reg->id.')"> <i class="fas fa-times"> </i></button>
              <button class="btn btn-outline-primary" title="Editar" onclick="mostrar('.$reg->id.')" data-toggle="modal" data-target="#periodoModal"><i class="fa fa-edit"></i></button>';
            }
            else {
              $opciones = ' 
              <button class="btn btn-outline-primary" title="Editar" onclick="mostrar('.$reg->id.')" data-toggle="modal" data-target="#periodoModal"><i class="fa fa-edit"></i></button>';
            }
          }
          else {
            $opciones = ' <button class="btn btn-outline-success" title="Activar" onclick="activar('.$reg->id.')"><i class="fa fa-check"></i></button>
            <button class="btn btn-outline-primary" title="Editar" onclick="mostrar('.$reg->id.')" data-toggle="modal" data-target="#periodoModal"><i class="fa fa-edit"></i></button>';
          }
          
        }

        list($ano_creacion, $mes_creacion, $dia_creacion) = explode('-',$reg->fecha_creacion);
        $fecha_creacion = $dia_creacion.'-'.$mes_creacion.'-'.$ano_creacion;

        list($ano_finalizacion, $mes_finalizacion, $dia_finalizacion) = explode('-',$reg->fecha_finalizacion);
        $fecha_finalizacion = $dia_finalizacion.'-'.$mes_finalizacion.'-'.$ano_finalizacion;

        $data[] = array('0' => $opciones,

            '1' => $reg->periodo,
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
		
		$rspta = $PeriodoEscolar->activar($idperiodo) or $sw = FALSE;

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
		
		$rspta = $PeriodoEscolar->finalizar($idperiodo) or $sw = FALSE;

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
    
  case 'mostrar':
	
		$rspta = $PeriodoEscolar->mostrar($idperiodo);

		#Se codifica el resultado utilizando Json
		echo json_encode($rspta);

		break;

	case 'traerultimo': 

		$rspta = $PeriodoEscolar->traerultimo();

		#Se codifica el resultado utilizando Json
		echo json_encode($rspta);
    break;
    
  case 'verificarfechainicio':
    $fecha_inicio = isset($_POST['fecha_inicio']) ? $_POST['fecha_inicio'] : '';
    $periodo = isset($_POST['periodo']) ? $_POST['periodo'] : '';
    list($ano_inicio, $ano_fin) = explode('-', $periodo);
    $periodo_anterior = ($ano_inicio - 1).'-'.($ano_fin - 1);

    $fecha_fin_anterior = $PeriodoEscolar->verificar_por_periodo($periodo_anterior);
    $fecha_fin_anterior = !empty($fecha_fin_anterior) ? $fecha_fin_anterior['fecha_finalizacion'] : '';

    if ($fecha_fin_anterior != '') {
      echo ($fecha_inicio > $fecha_fin_anterior) ? 'true' : 'false'; 
    }
    else {
      echo 'true';
    }

    break;

  case 'verificarfechafin':
    $fecha_fin = isset($_POST['fecha_fin']) ? $_POST['fecha_fin'] : '';
    $periodo = isset($_POST['periodo']) ? $_POST['periodo'] : '';

    list($ano_inicio, $ano_fin) = explode('-', $periodo);
    $periodo_siguiente = ($ano_inicio + 1).'-'.($ano_fin + 1);

    $fecha_inicio_siguiente = $PeriodoEscolar->verificar_por_periodo($periodo_siguiente);
    $fecha_inicio_siguiente = !empty($fecha_inicio_siguiente) ? $fecha_inicio_siguiente['fecha_finalizacion'] : '';

    if ($fecha_inicio_siguiente != '') {
      echo ($fecha_fin < $fecha_inicio_siguiente) ? 'true' : 'false'; 
    }
    else {
      echo 'true';
    }

    break;
}