<?php 

#Se inicia la sesión
if (strlen(session_id() < 1)) session_start(); 

#Se incluye el modelo de Modulo
require_once '../modelos/Modulo.php';

#Se instancia el objeto de Modulo
$Modulo = new Modulo();

#Se ejecuta un caso dependiendo del valor del parámetro GET
switch ($_GET['op']) {

	case 'listar':

		$rspta = $Modulo->listar();

		if ($rspta->num_rows != 0) {
			
			while ($reg = $rspta->fetch_object()) {

				$data[] = array('0' => $reg->id,
					 	            '1' => $reg->modulo);
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