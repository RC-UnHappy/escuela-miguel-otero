<?php 

#Se inicia la sesión
if (strlen(session_id() < 1)) session_start(); 

#Se incluye el modelo de Representante
require_once '../modelos/Representante.php';

#Se instancia el objeto de Representante
$representante = new Representante();

#Se reciben los datos por POST y se asignan a variables

$idrepresentante = isset($_POST['idrepresentante']) ? limpiarCadena($_POST['idrepresentante']) : '';
$personaId = isset($_POST['idpersona']) ? limpiarCadena($_POST['idpersona']) : '';
$cedula = isset($_POST['cedula']) ? limpiarCadena($_POST['cedula']) : '';
$p_nombre = isset($_POST['p_nombre']) ? limpiarCadena($_POST['p_nombre']) : '';
$s_nombre = isset($_POST['s_nombre']) ? limpiarCadena($_POST['s_nombre']) : '';
$p_apellido = isset($_POST['p_apellido']) ? limpiarCadena($_POST['p_apellido']) : '';
$s_apellido = isset($_POST['s_apellido']) ? limpiarCadena($_POST['s_apellido']) : '';
$genero = isset($_POST['genero']) ? limpiarCadena($_POST['genero']) : '';
$f_nac = isset($_POST['f_nac']) ? limpiarCadena($_POST['f_nac']) : '';
$instruccion = isset($_POST['instruccion']) ? limpiarCadena($_POST['instruccion']) : '';
$oficio = isset($_POST['oficio']) ? limpiarCadena($_POST['oficio']) : '';
$email = isset($_POST['email']) ? limpiarCadena($_POST['email']) : '';
$celular = isset($_POST['celular']) ? limpiarCadena($_POST['celular']) : '';
$fijo = isset($_POST['fijo']) ? limpiarCadena($_POST['fijo']) : '';

$estado_trabajo = isset($_POST['estado_trabajo']) ? limpiarCadena($_POST['estado_trabajo']) : '';
$municipio_trabajo = isset($_POST['municipio_trabajo']) ? limpiarCadena($_POST['municipio_trabajo']) : '';
$parroquia_trabajo = isset($_POST['parroquia_trabajo']) ? limpiarCadena($_POST['parroquia_trabajo']) : '';
$direccion_trabajo = isset($_POST['direccion_trabajo']) ? $_POST['direccion_trabajo'] : '';

$estado_residencia = isset($_POST['estado_residencia']) ? limpiarCadena($_POST['estado_residencia']) : '';
$municipio_residencia = isset($_POST['municipio_residencia']) ? limpiarCadena($_POST['municipio_residencia']) : '';
$parroquia_residencia = isset($_POST['parroquia_residencia']) ? limpiarCadena($_POST['parroquia_residencia']) : '';
$direccion_residencia = isset($_POST['direccion_residencia']) ? $_POST['direccion_residencia'] : '';


#Se ejecuta un caso dependiendo del valor del parámetro GET
switch ($_GET['op']) {
	case 'guardaryeditar':

		#Se incluye el modelo de Persona
		require_once '../modelos/Persona.php';
		$persona = new Persona();

		#Se incluye el modelo de Teléfono
		require_once '../modelos/Telefono.php';
		$telefono = new Telefono();

		#Se incluye el modelo de Dirección
		require_once '../modelos/Direccion.php';
		$Direccion = new Direccion();

		#Se incluye el modelo de DirecciónTrabajo
		require_once '../modelos/DireccionTrabajo.php';
		$DireccionTrabajo = new DireccionTrabajo();

		#Se deshabilita el guardado automático de la base de datos
		autocommit(FALSE);

		#Si la variable esta vacía quiere decir que es un nuevo registro
		if (empty($idrepresentante) && empty($personaId)) {
			
			#Variable para comprobar que todo salió bien al final
			$sw = TRUE;

			#Se registra la persona y se devuelve el id del registro
			$idpersona = $persona->insertar($cedula, $p_nombre, $s_nombre, $p_apellido, $s_apellido, $genero, $f_nac, $email) or $sw = FALSE;
			
			#Se registra la dirección de residencia del representante
			$Direccion->insertar($idpersona, $parroquia_residencia, $direccion_residencia) or $sw = FALSE;

			#Se registra la dirección de trabajo del representante
			$DireccionTrabajo->insertar($idpersona, $parroquia_trabajo, $direccion_trabajo) or $sw = FALSE;

			#Verifica que las variables de los teléfonos contengan datos y los guarda
			if (!empty($celular)) {
				$telefono->insertar($idpersona, $celular, 'M') or $sw = FALSE;
			}
			if (!empty($fijo)) {
				$telefono->insertar($idpersona, $fijo, 'F') or $sw = FALSE;
			}

			#Se registra el representante
			$rspta = $representante->insertar($idpersona, $instruccion, $oficio) or $sw = FALSE;

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
		#Ésto es cuando la persona ya estaba registrada en el sistema pero no como representante
		elseif (!empty($personaId) && empty($idrepresentante)) {
			#Variable para comprobar que todo salió bien al final
			$sw = TRUE;

			#Se editan los datos de la persona
			$persona->editar($personaId, $cedula, $p_nombre, $s_nombre, $p_apellido, $s_apellido, $genero, $f_nac, $email) or $sw = FALSE;

			if ($Direccion->verificar($personaId)) {
				#Se edita la dirección de residencia del representante
				$Direccion->editar($personaId, $parroquia_residencia, $direccion_residencia) or $sw = FALSE;
			} else {
				#Se registra la dirección de residencia del representante
				$Direccion->insertar($personaId, $parroquia_residencia, $direccion_residencia) or $sw = FALSE;
			}

			if ($DireccionTrabajo->verificar($personaId)) {
				#Se edita la dirección de trabajo del representante
				$DireccionTrabajo->editar($personaId, $parroquia_trabajo, $direccion_trabajo) or $sw = FALSE;
			} else {
				$DireccionTrabajo->insertar($personaId, $parroquia_trabajo, $direccion_trabajo) or $sw = FALSE;
			}

			#Verifica que las variables de los teléfonos contengan datos y los guarda
			if (!empty($celular)) {
				$telefono->eliminar($personaId, 'M') or $sw = FALSE;
				$telefono->insertar($personaId, $celular, 'M') or $sw = FALSE;
			}
			else {
				$telefono->eliminar($personaId, 'M') or $sw = FALSE;
			}
			if (!empty($fijo)) {
				$telefono->eliminar($personaId, 'F') or $sw = FALSE;
				$telefono->insertar($personaId, $fijo, 'F') or $sw = FALSE;
			}
			else {
				$telefono->eliminar($personaId, 'F') or $sw = FALSE;
			}

			#Se registra el representante
			$rspta = $representante->insertar($personaId, $instruccion, $oficio) or $sw = FALSE;

			#Se verifica que todo salió bien y se guardan los datos o se eliminan todos
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
			#Variable para comprobar que todo salió bien al final
			$sw = TRUE;

			#Se obtiene el id de la persona 
			$idpersona = $representante->idpersona($idrepresentante);
			$idpersona = $idpersona['idpersona'];

			#Se editan los datos de la persona
			$persona->editar($idpersona, $cedula, $p_nombre, $s_nombre, $p_apellido, $s_apellido, $genero, $f_nac, $email) or $sw = FALSE;

			if ($Direccion->verificar($idpersona)) {
				#Se edita la dirección de residencia del representante
				$Direccion->editar($idpersona, $parroquia_residencia, $direccion_residencia) or $sw = FALSE;
			} else {
				#Se registra la dirección de residencia del representante
				$Direccion->insertar($idpersona, $parroquia_residencia, $direccion_residencia) or $sw = FALSE;
			}

			if ($DireccionTrabajo->verificar($idpersona)) {
				#Se edita la dirección de trabajo del representante
				$DireccionTrabajo->editar($idpersona, $parroquia_trabajo, $direccion_trabajo) or $sw = FALSE;
			} else {
				#Se edita la dirección de trabajo del representante
				$DireccionTrabajo->insertar($idpersona, $parroquia_trabajo, $direccion_trabajo) or $sw = FALSE;
			}

			#Verifica que las variables de los teléfonos contengan datos y los guarda
			if (!empty($celular)) {
				$telefono->eliminar($idpersona, 'M') or $sw = FALSE;
				$telefono->insertar($idpersona, $celular, 'M') or $sw = FALSE;
			}
			else {
				$telefono->eliminar($idpersona, 'M') or $sw = FALSE;
			}
			if (!empty($fijo)) {
				$telefono->eliminar($idpersona, 'F') or $sw = FALSE;
				$telefono->insertar($idpersona, $fijo, 'F') or $sw = FALSE;
			}
			else {
				$telefono->eliminar($idpersona, 'F') or $sw = FALSE;
			}

			#Se edita el representante
			$rspta = $representante->editar($idrepresentante, $instruccion, $oficio) or $sw = FALSE;

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
		$rspta = $representante->listar();

		$data = array();

		if ($rspta->num_rows != 0) {
			
			while ($reg = $rspta->fetch_object()) {

				$data[] = array('0' => 

					($reg->estatus) ? 

					( ( isset($_SESSION['permisos']['representante']) && 
                  	  in_array('editar' , $_SESSION['permisos']['representante']) ) ?

					'<button class="btn btn-outline-primary " title="Editar" onclick="mostrar('.$reg->id.')"><i class="fas fa-edit"></i></button>' : '').

					( ( isset($_SESSION['permisos']['representante']) && 
                  	  in_array('activar-desactivar' , $_SESSION['permisos']['representante']) ) ?

					' <button class="btn btn-outline-danger" title="Desactivar" onclick="desactivar('.$reg->id.')"> <i class="fas fa-times"> </i></button> ' : '')

					:

					( ( isset($_SESSION['permisos']['representante']) && 
                  	  in_array('editar' , $_SESSION['permisos']['representante']) ) ?

					 '<button class="btn btn-outline-primary" title="Editar" onclick="mostrar('.$reg->id.')"><i class="fa fa-edit"></i></button>' : '').


					( ( isset($_SESSION['permisos']['representante']) && 
                  	  in_array('activar-desactivar' , $_SESSION['permisos']['representante']) ) ?

					 ' <button class="btn btn-outline-success" title="Activar" onclick="activar('.$reg->id.')"><i class="fa fa-check"></i></button> ' : ''),

					 	'1' => $reg->cedula,
					 	'2' => $reg->p_nombre,
					 	'3' => $reg->p_apellido,
						'4' => $reg->email,
						'5' => $reg->movil,
						'6' => $reg->fijo,
						'7' => $reg->direccion,
						'8' => $reg->oficio );
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

	case 'listarestados':
		$idpais = isset($_GET['idpais']) ? $_GET['idpais'] : NULL;
		$rspta = $representante->listarestados($idpais);

		while ($estado = $rspta->fetch_object()) {
			echo '<option value="' . $estado->id . '">' . $estado->estado . '</option>';
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

	case 'comprobarpersona': 
		$cedula = $_POST['cedula'];
		$rspta = $representante->comprobarpersona($cedula);
		echo json_encode($rspta->fetch_object());
		break;

}