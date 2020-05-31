<?php 

#Se inicia la sesión
if (strlen(session_id() < 1)) session_start(); 

#Se incluye el modelo de Permiso
require_once '../modelos/Permiso.php';

#Se instancia el objeto de Permiso
$permiso = new Permiso();

#Se reciben los datos por POST y se asignan a variables
$nombre = isset($_POST['permiso']) ? limpiarCadena($_POST['permiso']) : '';


#Se ejecuta un caso dependiendo del valor del parámetro GET
switch ($_GET['op']) {
	case 'guardaryeditar':
		
		break;

	#Lista todos los permisos
	case 'listar': 
		$rspta = $permiso->listar();
		
		#Declaración de arreglo
		$data = array();

		#En este bucle se sacan los datos del objeto resultante de la base de datos y se le asignan a la variable data

		if ($rspta->num_rows != 0) {

			while ($reg = $rspta->fetch_object()) {
				$data[] =  array('0' => $reg->permiso);
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
}