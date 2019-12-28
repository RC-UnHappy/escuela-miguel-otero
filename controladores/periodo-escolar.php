<?php 

#Se inicia la sesión
if (strlen(session_id() < 1)) session_start(); 

#Se incluye el modelo de Período Escolar
require_once '../modelos/PeriodoEscolar.php';

#Se instancia el objeto de Período Escolar
$PeriodoEscolar = new PeriodoEscolar();

$idperiodo = isset($_POST['idperiodo']) ? limpiarCadena($_POST['idperiodo']) : '';
$periodo = isset($_POST['periodo']) ? limpiarCadena($_POST['periodo']) : '';

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
			$PeriodoEscolar->insertar($periodo, 1) or $sw = FALSE;

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
		
		if ($rspta->num_rows != 0) {		
			while ($reg = $rspta->fetch_object()) {

				$data[] = array('0' => ($reg->estatus) ? 
					' <button class="btn btn-outline-danger" title="Finalizar" onclick="finalizar('.$reg->id.')"> <i class="fas fa-times"> </i></button> '
						 :
					 ' ',

					 	'1' => $reg->periodo,
					 	'2' => ($reg->estatus) ? 
					 	'<span class="badge badge-pill badge-success">Activo</span>' :
					 	'<span class="badge badge-pill badge-danger">Finalizado</span>');
			}

			$results = array(
				"draw" => 0, #Esto tiene que ver con el procesamiento del lado del servidor
				"recordsTotal" => count($data), #Se envía el total de registros al datatable
				"recordsFiltered" => count($data), #Se envía el total de registros a visualizar
				"data" => $data #datos en un array

			);
			echo json_encode($results);
		}
		else {
			$results = array(
				"draw" => 0, #Esto tiene que ver con el procesamiento del lado del servidor
				"recordsTotal" => 0, #Se envía el total de registros al datatable
				"recordsFiltered" => 0, #Se envía el total de registros a visualizar
				"data" => '' #datos en un array

			);
			echo json_encode($results);
		}

		break;	

	case 'desactivar': 

		#Se deshabilita el guardado automático de la base de datos
		autocommit(FALSE);

		#Variable para comprobar que todo salió bien al final
		$sw = TRUE;

		$periodo = $PeriodoEscolar->mostrar($idperiodo) or $sw = FALSE;
		$periodo = $periodo['periodo'];
		list($primero, $segundo) = explode('-', $periodo);
		$periodo = ($primero + 1).'-'.($segundo + 1);
		$periodo = $PeriodoEscolar->seleccionar($periodo);
		$periodo = $periodo['id'];
		$rspta = $PeriodoEscolar->desactivar($idperiodo) or $sw = FALSE;
		$rspta = $PeriodoEscolar->activar($periodo) or $sw = FALSE;

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

	case 'verificar': 

		$rspta = $PeriodoEscolar->verificar();

		#Se codifica el resultado utilizando Json
		echo json_encode($rspta);
		break;

	case 'traerultimo': 

		$rspta = $PeriodoEscolar->traerultimo();

		#Se codifica el resultado utilizando Json
		echo json_encode($rspta);
		break;
}