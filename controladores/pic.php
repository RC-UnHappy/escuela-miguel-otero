<?php 

#Se inicia la sesión
if (strlen(session_id() < 1)) session_start(); 

#Se incluye el modelo de Pic
require_once '../modelos/Pic.php';

#Se instancia el objeto de Pic
$Pic = new Pic();

$idpic = isset($_POST['idpic']) ? limpiarCadena($_POST['idpic']) : '';
$idperiodo_escolar = isset($_POST['idperiodo_escolar']) ? limpiarCadena($_POST['idperiodo_escolar']) : '';
$pic = isset($_POST['pic']) ? limpiarCadena($_POST['pic']) : '';
$estatus = isset($_POST['estatus']) ? limpiarCadena($_POST['estatus']) : '';

#Se ejecuta un caso dependiendo del valor del parámetro GET
switch ($_GET['op']) {

	case 'guardaryeditar':

		#Se deshabilita el guardado automático de la base de datos
		autocommit(FALSE);

		#Variable para comprobar que todo salió bien al final
		$sw = TRUE;

		#Si la variable esta vacía quiere decir que es un nuevo registro
		if (empty($idpic)) {
			
			#Se registra el pic
			$Pic->insertar($idperiodo_escolar, $pic, $estatus) or $sw = FALSE;

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

			#Se edita la pic
			$Pic->editar($idpic, $idperiodo_escolar, $pic, $estatus) or $sw = FALSE;

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

    $rspta = $Pic->listar();
    
    $idperiodo_actual = $Pic->consultarperiodo();
    $idperiodo_actual = !empty($idperiodo_actual) ? $idperiodo_actual['id'] : '';

		if ($rspta->num_rows != 0) {
			
			while ($reg = $rspta->fetch_object()) {

        $opciones = '';
        if ($idperiodo_actual == $reg->idperiodo_escolar && $reg->estatus == 'Planificado') {
          $opciones = ' <button class="btn btn-outline-success" title="Activar" onclick="activar('.$reg->id.')"><i class="fa fa-check"></i></button> <button class="btn btn-outline-primary" title="Editar" onclick="mostrar('.$reg->id.')" data-toggle="modal" data-target="#picModal"><i class="fa fa-edit"></i></button>';
        }
        elseif ($reg->estatus == 'Planificado') {
          $opciones = '<button class="btn btn-outline-primary" title="Editar" onclick="mostrar('.$reg->id.')" data-toggle="modal" data-target="#picModal"><i class="fa fa-edit"></i></button>';
        }

        $badge = '';
        if ($reg->estatus == 'Activo') 
          $badge = '<span class="badge badge-pill badge-success">Activo</span>';
        elseif($reg->estatus == 'Planificado')
          $badge = '<span class="badge badge-pill badge-warning">Planificado</span>';
        else 
          $badge = '<span class="badge badge-pill badge-danger">Finalizado</span>';

				$data[] = array('0' => $opciones,

            '1' => $reg->periodo,
            '2' => $reg->pic,
            '3' => $badge);
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
	
		$rspta = $Pic->mostrar($idpic);

		#Se codifica el resultado utilizando Json
		echo json_encode($rspta);

		break;

	case 'activar': 

		$rspta = $Pic->activar($idpic);
		echo $rspta ? 'true' : 'false';
    break;
    
  case 'consultarperiodo': 
    $periodo_actual = $Pic->consultarperiodo();
    $periodo_actual = !empty($periodo_actual) ? $periodo_actual['id'] : '';

    echo $periodo_actual;
    break;

  case 'traerperiodossinproyecto': 
    
    $rspta = $Pic->traer_periodos_sin_proyecto();

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
}