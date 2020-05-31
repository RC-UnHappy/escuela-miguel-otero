<?php 

#Se inicia la sesión
if (strlen(session_id() < 1)) session_start(); 

#Se incluye el modelo de Ambiente
require_once '../modelos/Ambiente.php';

#Se instancia el objeto de Ambiente
$ambiente = new Ambiente();

$idambiente = isset($_POST['idambiente']) ? limpiarCadena($_POST['idambiente']) : '';
$numeroambiente = isset($_POST['ambiente']) ? limpiarCadena($_POST['ambiente']) : '';
$capacidad = isset($_POST['capacidad']) ? limpiarCadena($_POST['capacidad']) : '';
$ubicacion = isset($_POST['ubicacion']) ? limpiarCadena($_POST['ubicacion']) : '';
$estatus = isset($_POST['estatus']) ? limpiarCadena($_POST['estatus']) : '';

#Se ejecuta un caso dependiendo del valor del parámetro GET
switch ($_GET['op']) {
	
	case 'comprobarambiente': 
		$numeroambiente = $_POST['ambiente'];

		$rspta = $ambiente->comprobarambiente($numeroambiente);
		echo json_encode($rspta->fetch_object());
		break;

	case 'guardaryeditar':

		#Se deshabilita el guardado automático de la base de datos
		autocommit(FALSE);

		#Variable para comprobar que todo salió bien al final
		$sw = TRUE;

		#Si la variable esta vacía quiere decir que es un nuevo registro
		if (empty($idambiente)) {
			
			#Se registra el ambiente
			$ambiente->insertar($numeroambiente, $capacidad, $ubicacion, $estatus) or $sw = FALSE;

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

			#Se registra el ambiente
			$ambiente->editar($idambiente, $numeroambiente, $capacidad, $ubicacion, $estatus) or $sw = FALSE;

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

		$rspta = $ambiente->listar();

		if ($rspta->num_rows != 0) {

			while ($reg = $rspta->fetch_object()) {

				$data[] = array('0' =>     

					// Dependiendo del estatus mostrará el botón activar o desactivar
					 ($reg->estatus) ? 

					// Se verifica que tenga el permiso de editar para mostrar o no el botón
					 ( ( isset($_SESSION['permisos']['ambiente']) && 
                  	  in_array('editar' , $_SESSION['permisos']['ambiente']) ) ?

                  	  '<button class="btn btn-outline-primary " title="Editar" onclick="mostrar('.$reg->id.')" data-toggle="modal" data-target="#ambienteModal"><i class="fas fa-edit"></i></button>' : '' ).

					 // Se verifica que tenga el permiso de eliminar para mostrar o no el botón
					( ( isset($_SESSION['permisos']['ambiente']) && 
                  	  in_array('activar-desactivar' , $_SESSION['permisos']['ambiente']) ) ?

					' <button class="btn btn-outline-danger" title="Desactivar" onclick="desactivar('.$reg->id.')"> <i class="fas fa-times"> </i></button> ' : '')

					:

					( ( isset($_SESSION['permisos']['ambiente']) && 
                  	  in_array('editar' , $_SESSION['permisos']['ambiente']) ) ?

					 '<button class="btn btn-outline-primary" title="Editar" onclick="mostrar('.$reg->id.')" data-toggle="modal" data-target="#ambienteModal"><i class="fa fa-edit"></i></button>' : '' ).

					( ( isset($_SESSION['permisos']['ambiente']) && 
                  	  in_array('activar-desactivar' , $_SESSION['permisos']['ambiente']) ) ?

					 ' <button class="btn btn-outline-success" title="Activar" onclick="activar('.$reg->id.')"><i class="fa fa-check"></i></button> ' : '')

					 ,

					 '1' => $reg->ambiente,

           '2' => $reg->capacidad,
           '3' => $reg->ubicacion);
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
	
		$rspta = $ambiente->mostrar($idambiente);

		#Se codifica el resultado utilizando Json
		echo json_encode($rspta);

		break;

	case 'desactivar': 

		$rspta = $ambiente->desactivar($idambiente);
		echo $rspta ? 'true' : 'false';
		break;

	case 'activar': 

		$rspta = $ambiente->activar($idambiente);
		echo $rspta ? 'true' : 'false';
		break;
}