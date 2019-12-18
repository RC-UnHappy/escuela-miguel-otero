<?php 

#Se inicia la sesión
if (strlen(session_id() < 1)) session_start(); 

#Se incluye el modelo de Estudiante
require_once '../modelos/Estudiante.php';

#Se instancia el objeto de Estudiante
$estudiante = new Estudiante();

#Se reciben los datos por POST y se asignan a variables

$cedula = isset($_POST['cedula']) ? limpiarCadena($_POST['cedula']) : '';
$p_nombre = isset($_POST['p_nombre']) ? limpiarCadena($_POST['p_nombre']) : '';
$s_nombre = isset($_POST['s_nombre']) ? limpiarCadena($_POST['s_nombre']) : '';
$p_apellido = isset($_POST['p_apellido']) ? limpiarCadena($_POST['p_apellido']) : '';
$s_apellido = isset($_POST['s_apellido']) ? limpiarCadena($_POST['s_apellido']) : '';
$genero = isset($_POST['genero']) ? limpiarCadena($_POST['genero']) : '';
$f_nac = isset($_POST['f_nac']) ? limpiarCadena($_POST['f_nac']) : '';
$parto = isset($_POST['parto']) ? limpiarCadena($_POST['parto']) : '';
$orden = isset($_POST['orden']) ? limpiarCadena($_POST['orden']) : '';
$cedula_madre = isset($_POST['cedula_madre']) ? limpiarCadena($_POST['cedula_madre']) : '';
$cedula_padre = isset($_POST['cedula_padre']) ? limpiarCadena($_POST['cedula_padre']) : '';
$estado = isset($_POST['estado']) ? limpiarCadena($_POST['estado']) : '';
$municipio = isset($_POST['municipio']) ? limpiarCadena($_POST['municipio']) : '';
$parroquia = isset($_POST['parroquia']) ? limpiarCadena($_POST['parroquia']) : '';
$direccion = isset($_POST['direccion']) ? $_POST['direccion'] : '';
$peso = isset($_POST['peso']) ? $_POST['peso'] : '';
$talla = isset($_POST['talla']) ? $_POST['talla'] : '';
$vacunas = isset($_POST['vacunas']) ? $_POST['vacunas'] : '';
$alergia = isset($_POST['alergia']) ? $_POST['alergia'] : '';
$diversidad = isset($_POST['diversidad']) ? $_POST['diversidad'] : '';
$enfermedad = isset($_POST['enfermedad']) ? $_POST['enfermedad'] : '';
$vivienda = isset($_POST['vivienda']) ? $_POST['vivienda'] : '';
$sosten = isset($_POST['sosten']) ? $_POST['sosten'] : '';
$grupo_familiar = isset($_POST['grupo_familiar']) ? $_POST['grupo_familiar'] : '';
$ingreso_mensual = isset($_POST['ingreso_mensual']) ? $_POST['ingreso_mensual'] : '';
$canaima = isset($_POST['canaima']) ? $_POST['canaima'] : '';
$condicion_canaima = isset($_POST['condicion_canaima']) ? $_POST['condicion_canaima'] : '';

#Se ejecuta un caso dependiendo del valor del parámetro GET
switch ($_GET['op']) {
	case 'guardaryeditar':
		var_dump($_POST);
		// #Se incluye el modelo de Persona
		// require_once '../modelos/Persona.php';
		// $persona = new Persona();

		// #Se incluye el modelo de Teléfono
		// require_once '../modelos/Telefono.php';
		// $telefono = new Telefono();

		// #Se incluye el modelo de Dirección
		// require_once '../modelos/Direccion.php';
		// $Direccion = new Direccion();

		// #Se deshabilita el guardado automático de la base de datos
		// autocommit(FALSE);

		// #Si la variable esta vacía quiere decir que es un nuevo registro
		// if (empty($idrepresentante) && empty($personaId)) {
			
		// 	#Variable para comprobar que todo salió bien al final
		// 	$sw = TRUE;

		// 	#Se registra la persona y se devuelve el id del registro
		// 	$idpersona = $persona->insertar($cedula, $p_nombre, $s_nombre, $p_apellido, $s_apellido, $genero, $f_nac, $email) or $sw = FALSE;
			
		// 	#Se registra la dirección del representante
		// 	$Direccion->insertar($idpersona, $parroquia, $direccion) or $sw = FALSE;

		// 	#Verifica que las variables de los teléfonos contengan datos y los guarda
		// 	if (!empty($celular)) {
		// 		$telefono->insertar($idpersona, $celular, 'M') or $sw = FALSE;
		// 	}
		// 	if (!empty($fijo)) {
		// 		$telefono->insertar($idpersona, $fijo, 'F') or $sw = FALSE;
		// 	}

		// 	#Se registra el representante
		// 	$rspta = $representante->insertar($idpersona, $instruccion, $oficio) or $sw = FALSE;

		// 	#Se verifica que todo saliío bien y se guardan los datos o se eliminan todos
		// 	if ($sw) {
		// 		commit();
		// 		echo 'true';
		// 	}
		// 	else {
		// 		rollback();
		// 		echo 'false';
		// 	}

		// }
		// elseif (!empty($personaId) && empty($idrepresentante)) {
		// 	#Variable para comprobar que todo salió bien al final
		// 	$sw = TRUE;

		// 	#Se editan los datos de la persona
		// 	$esto = $persona->editar($personaId, $cedula, $p_nombre, $s_nombre, $p_apellido, $s_apellido, $genero, $f_nac, $email) or $sw = FALSE;

		// 	#Se registra la dirección del representante
		// 	$Direccion->insertar($personaId, $parroquia, $direccion) or $sw = FALSE;

		// 	#Verifica que las variables de los teléfonos contengan datos y los guarda
		// 	if (!empty($celular)) {
		// 		$telefono->eliminar($personaId, 'M') or $sw = FALSE;
		// 		$telefono->insertar($personaId, $celular, 'M') or $sw = FALSE;
		// 	}
		// 	else {
		// 		$telefono->eliminar($personaId, 'M') or $sw = FALSE;
		// 	}
		// 	if (!empty($fijo)) {
		// 		$telefono->eliminar($personaId, 'F') or $sw = FALSE;
		// 		$telefono->insertar($personaId, $fijo, 'F') or $sw = FALSE;
		// 	}
		// 	else {
		// 		$telefono->eliminar($personaId, 'F') or $sw = FALSE;
		// 	}

		// 	#Se registra el representante
		// 	$rspta = $representante->insertar($personaId, $instruccion, $oficio) or $sw = FALSE;

		// 	#Se verifica que todo salió bien y se guardan los datos o se eliminan todos
		// 	if ($sw) {
		// 		commit();
		// 		echo 'update';
		// 	}
		// 	else {
		// 		rollback();
		// 		echo 'false';
		// 	}
		// }
		// else{
		// 	#Variable para comprobar que todo salió bien al final
		// 	$sw = TRUE;

		// 	#Se obtiene el id de la persona 
		// 	$idpersona = $representante->idpersona($idrepresentante);
		// 	$idpersona = $idpersona['idpersona'];

		// 	#Se editan los datos de la persona
		// 	$persona->editar($idpersona, $cedula, $p_nombre, $s_nombre, $p_apellido, $s_apellido, $genero, $f_nac, $email) or $sw = FALSE;
			
		// 	#Se edita la dirección del representante
		// 	$Direccion->editar($idpersona, $parroquia, $direccion) or $sw = FALSE;

		// 	#Verifica que las variables de los teléfonos contengan datos y los guarda
		// 	if (!empty($celular)) {
		// 		$telefono->eliminar($idpersona, 'M') or $sw = FALSE;
		// 		$telefono->insertar($idpersona, $celular, 'M') or $sw = FALSE;
		// 	}
		// 	else {
		// 		$telefono->eliminar($idpersona, 'M') or $sw = FALSE;
		// 	}
		// 	if (!empty($fijo)) {
		// 		$telefono->eliminar($idpersona, 'F') or $sw = FALSE;
		// 		$telefono->insertar($idpersona, $fijo, 'F') or $sw = FALSE;
		// 	}
		// 	else {
		// 		$telefono->eliminar($idpersona, 'F') or $sw = FALSE;
		// 	}

		// 	#Se edita el representante
		// 	$rspta = $representante->editar($idrepresentante, $instruccion, $oficio) or $sw = FALSE;

		// 	#Se verifica que todo saliío bien y se guardan los datos o se eliminan todos
		// 	if ($sw) {
		// 		commit();
		// 		echo 'update';
		// 	}
		// 	else {
		// 		rollback();
		// 		echo 'false';
		// 	}
		// }
		break;

	case 'listar':
		$rspta = $representante->listar();

		$data = array();

		while ($reg = $rspta->fetch_object()) {

			$data[] = array('0' => ($reg->estatus) ? '<button class="btn btn-outline-primary " title="Editar" onclick="mostrar('.$reg->id.')"><i class="fas fa-edit"></i></button>'.

				' <button class="btn btn-outline-danger" title="Desactivar" onclick="desactivar('.$reg->id.')"> <i class="fas fa-times"> </i></button> '

					 :

				 '<button class="btn btn-outline-primary" title="Editar" onclick="mostrar('.$reg->id.')"><i class="fa fa-edit"></i></button>'.

				 ' <button class="btn btn-outline-success" title="Activar" onclick="activar('.$reg->id.')"><i class="fa fa-check"></i></button> ',

				 	'1' => $reg->cedula,
				 	'2' => $reg->p_nombre,
				 	'3' => $reg->p_apellido,
					'4' => $reg->email,
					'5' => $reg->movil,
					'6' => $reg->fijo,
					'7' => $reg->oficio );
		}

		$results = array(
			"draw" => 0, #Esto tiene que ver con el procesamiento del lado del servidor
			"recordsTotal" => count($data), #Se envía el total de registros al datatable
			"recordsFiltered" => count($data), #Se envía el total de registros a visualizar
			"data" => $data #datos en un array

		);

		echo json_encode($results);

		break;

	case 'listarestados':
		$rspta = $representante->listarestados();

		while ($estado = $rspta->fetch_object()) {
			echo '<option value="'.$estado->id.'">'.$estado->estado.'</option>';
		}

		break;

	case 'listarmunicipios':		
		$idestado = $_GET['idestado'];
		$rspta = $representante->listarmunicipios($idestado);

		while ($municipio = $rspta->fetch_object()) {
			echo '<option value="'.$municipio->id.'">'.$municipio->municipio.'</option>';
		}

		break;

	case 'listarparroquias':		
		$idmunicipio = $_GET['idmunicipio'];
		$rspta = $representante->listarparroquias($idmunicipio);

		while ($parroquia = $rspta->fetch_object()) {
			echo '<option value="'.$parroquia->id.'">'.$parroquia->parroquia.'</option>';
		}

		break;

	case 'mostrar':
	
		$rspta = $representante->mostrar($idrepresentante);

		#Se codifica el resultado utilizando Json
		echo json_encode($rspta->fetch_object());

		break;

	case 'desactivar': 
		$rspta = $representante->desactivar($idrepresentante);
		echo $rspta ? 'true' : 'false';
		break;

	case 'activar': 
		$rspta = $representante->activar($idrepresentante);
		echo $rspta ? 'true' : 'false';
		break;

	case 'comprobarrepresentante': 
		$cedula = $_POST['cedula'];
		$rspta = $representante->comprobarrepresentante($cedula);
		echo json_encode($rspta->fetch_object());
		break;

	case 'comprobarpadres': 
		$cedula = $_POST['comprobarpadres'];
		$rspta = $estudiante->comprobarpadres($cedula);
		echo json_encode($rspta->fetch_object());
		break;

}