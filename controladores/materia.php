<?php 

#Se inicia la sesión
if (strlen(session_id() < 1)) session_start(); 

#Se incluye el modelo de Materia
require_once '../modelos/Materia.php';

#Se instancia el objeto de Materia
$Materia = new Materia();

$idmateria = isset($_POST['idmateria']) ? limpiarCadena($_POST['idmateria']) : '';
$materia = isset($_POST['materia']) ? limpiarCadena(mb_strtoupper($_POST['materia'])) : '';
$estatus = isset($_POST['estatus']) ? limpiarCadena($_POST['estatus']) : '';

#Se ejecuta un caso dependiendo del valor del parámetro GET
switch ($_GET['op']) {
	
	case 'comprobarmateria': 

		$rspta = $Materia->comprobarmateria($materia);
		echo json_encode($rspta->fetch_object());
		break;

	case 'guardaryeditar':

		#Se deshabilita el guardado automático de la base de datos
		autocommit(FALSE);

		#Variable para comprobar que todo salió bien al final
		$sw = TRUE;

		#Si la variable esta vacía quiere decir que es un nuevo registro
		if (empty($idmateria)) {
			
			#Se registra la materia
			$Materia->insertar($materia, $estatus) or $sw = FALSE;

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

			#Se edita la materia
			$Materia->editar($idmateria, $materia, $estatus) or $sw = FALSE;

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

		$rspta = $Materia->listar();

		if ($rspta->num_rows != 0) {
			
			while ($reg = $rspta->fetch_object()) {

				$data[] = array('0' => 
					($reg->estatus) ? 

					// Se verifica que tenga el permiso de editar para mostrar o no el botón
					 ( ( isset($_SESSION['permisos']['materia']) && 
                  	  in_array('editar' , $_SESSION['permisos']['materia']) ) ?

					'<button class="btn btn-outline-primary " title="Editar" onclick="mostrar('.$reg->id.')" data-toggle="modal" data-target="#materiaModal"><i class="fas fa-edit"></i></button>' : '').

					 // Se verifica que tenga el permiso de eliminar para mostrar o no el botón
					( ( isset($_SESSION['permisos']['materia']) && 
                  	  in_array('activar-desactivar' , $_SESSION['permisos']['materia']) ) ?

					' <button class="btn btn-outline-danger" title="Desactivar" onclick="desactivar('.$reg->id.')"> <i class="fas fa-times"> </i></button> ' : '')

					:

					( ( isset($_SESSION['permisos']['materia']) && 
                  	  in_array('editar' , $_SESSION['permisos']['materia']) ) ?

					 '<button class="btn btn-outline-primary" title="Editar" onclick="mostrar('.$reg->id.')" data-toggle="modal" data-target="#materiaModal"><i class="fa fa-edit"></i></button>' : '').

					( ( isset($_SESSION['permisos']['materia']) && 
                  	  in_array('activar-desactivar' , $_SESSION['permisos']['materia']) ) ?

					 ' <button class="btn btn-outline-success" title="Activar" onclick="activar('.$reg->id.')"><i class="fa fa-check"></i></button> ' : ''),

					 	'1' => $reg->materia);
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
	
		$rspta = $Materia->mostrar($idmateria);

		#Se codifica el resultado utilizando Json
		echo json_encode($rspta);

		break;

	case 'desactivar': 

		$rspta = $Materia->desactivar($idmateria);
		echo $rspta ? 'true' : 'false';
		break;

	case 'activar': 

		$rspta = $Materia->activar($idmateria);
		echo $rspta ? 'true' : 'false';
		break;
}