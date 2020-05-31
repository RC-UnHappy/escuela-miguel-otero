<?php 

#Se inicia la sesión
if (strlen(session_id() < 1)) session_start(); 

#Se incluye el modelo de Grado
require_once '../modelos/Grado.php';

#Se instancia el objeto de Grado
$grado = new Grado();

$idgrado = isset($_POST['idgrado']) ? limpiarCadena($_POST['idgrado']) : '';
$numerogrado = isset($_POST['grado']) ? limpiarCadena($_POST['grado']) : '';
$estatus = isset($_POST['estatus']) ? limpiarCadena($_POST['estatus']) : '';

#Se ejecuta un caso dependiendo del valor del parámetro GET
switch ($_GET['op']) {
	
	case 'comprobargrado': 
		$numerogrado = $_POST['grado'];

		$rspta = $grado->comprobargrado($numerogrado);
		echo json_encode($rspta->fetch_object());
		break;

	case 'guardaryeditar':

		#Se deshabilita el guardado automático de la base de datos
		autocommit(FALSE);

		#Variable para comprobar que todo salió bien al final
		$sw = TRUE;

		#Si la variable esta vacía quiere decir que es un nuevo registro
		if (empty($idgrado)) {
			
			#Se registra el grado
			$grado->insertar($numerogrado, $estatus) or $sw = FALSE;

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

			#Se registra el grado
			$grado->editar($idgrado, $numerogrado, $estatus) or $sw = FALSE;

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

		$rspta = $grado->listar();

		if ($rspta->num_rows != 0) {

			while ($reg = $rspta->fetch_object()) {

				$data[] = array('0' => 

					// Dependiendo del estatus mostrará el botón activar o desactivar
					($reg->estatus) ? 

					// Se verifica que tenga el permiso de editar para mostrar o no el botón
					( ( isset($_SESSION['permisos']['grado']) && 
                  	  in_array('editar' , $_SESSION['permisos']['grado']) ) ?

					'<button class="btn btn-outline-primary " title="Editar" onclick="mostrar('.$reg->id.')" data-toggle="modal" data-target="#gradoModal"><i class="fas fa-edit"></i></button>' : '' ).

					// Se verifica que tenga el permiso de eliminar para mostrar o no el botón
					( ( isset($_SESSION['permisos']['grado']) && 
                  	  in_array('activar-desactivar' , $_SESSION['permisos']['grado']) ) ?

					' <button class="btn btn-outline-danger" title="Desactivar" onclick="desactivar('.$reg->id.')"> <i class="fas fa-times"> </i></button> ' : '')

					:

					( ( isset($_SESSION['permisos']['grado']) && 
                  	  in_array('editar' , $_SESSION['permisos']['grado']) ) ?

					 '<button class="btn btn-outline-primary" title="Editar" onclick="mostrar('.$reg->id.')" data-toggle="modal" data-target="#gradoModal"><i class="fa fa-edit"></i></button>' : '' ).


					( ( isset($_SESSION['permisos']['grado']) && 
                  	  in_array('activar-desactivar' , $_SESSION['permisos']['grado']) ) ?

					 ' <button class="btn btn-outline-success" title="Activar" onclick="activar('.$reg->id.')"><i class="fa fa-check"></i></button> ' : '' ),

					 	'1' => $reg->grado.'º');
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
	
		$rspta = $grado->mostrar($idgrado);

		#Se codifica el resultado utilizando Json
		echo json_encode($rspta);

		break;

	case 'desactivar': 

		$rspta = $grado->desactivar($idgrado);
		echo $rspta ? 'true' : 'false';
		break;

	case 'activar': 

		$rspta = $grado->activar($idgrado);
		echo $rspta ? 'true' : 'false';
		break;
}