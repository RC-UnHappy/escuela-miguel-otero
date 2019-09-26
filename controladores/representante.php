<?php 

#Se inicia la sesión
if (strlen(session_id() < 1)) session_start(); 

#Se incluye el modelo de Representante
require_once '../modelos/Representante.php';

#Se instancia el objeto de Representante
$representante = new Representante();

#Se reciben los datos por POST y se asignan a variables

$idrepresentante = isset($_POST['idrepresentante']) ? limpiarCadena($_POST['idrepresentante']) : '';
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

$estado = isset($_POST['estado']) ? limpiarCadena($_POST['estado']) : '';
$municipio = isset($_POST['municipio']) ? limpiarCadena($_POST['municipio']) : '';
$parroquia = isset($_POST['parroquia']) ? limpiarCadena($_POST['parroquia']) : '';
$direccion = isset($_POST['direccion']) ? $_POST['direccion'] : '';


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

		#Se deshabilita el guardado automático de la base de datos
		autocommit(FALSE);

		#Si la variable esta vacía quiere decir que es un nuevo registro
		if (empty($idrepresentante)) {
			
			#Variable para comprobar que todo salió bien al final
			$sw = TRUE;

			#Se registra la persona y se devuelve el id del registro
			$idpersona = $persona->insertar($cedula, $p_nombre, $s_nombre, $p_apellido, $s_apellido, $genero, $f_nac, $email) or $sw = FALSE;
			
			#Se registra la dirección del representante
			$Direccion->insertar($idpersona, $parroquia, $direccion) or $sw = FALSE;

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
		else{

			#Variable para comprobar que todo salió bien al final
			$sw = TRUE;

			#Se obtiene el id de la persona 
			$idpersona = $representante->idpersona($idrepresentante);
			$idpersona = $idpersona['idpersona'];

			#Se editan los datos de la persona
			$persona->editar($idpersona, $cedula, $p_nombre, $s_nombre, $p_apellido, $s_apellido, $genero, $f_nac, $email) or $sw = FALSE;
			
			#Se registra la dirección del representante
			$Direccion->editar($idpersona, $parroquia, $direccion) or $sw = FALSE;

			#Verifica que las variables de los teléfonos contengan datos y los guarda
			if (!empty($celular)) {
				$telefono->editar($idpersona, $celular, 'M') or $sw = FALSE;
			}
			if (!empty($fijo)) {
				$telefono->editar($idpersona, $fijo, 'F') or $sw = FALSE;
			}

			#Se registra el representante
			$rspta = $representante->editar($idrepresentante, $instruccion, $oficio) or $sw = FALSE;

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

	case 'verificar':
		
		#Se encripta la contraseña con el algoritmo SHA256
		$clavehash = hash('SHA256', $pass);

		$rspta = $usuario->verificar($user, $clavehash);

		$fetch = $rspta->fetch_object();

		if (isset($fetch)) {
			
			#Declaramos las variables de sesión
			$_SESSION['idusuario'] = $fetch->id;
			$_SESSION['usuario'] = $fetch->usuario;
			$_SESSION['p_nombre'] = $fetch->p_nombre;
			$_SESSION['p_apellido'] = $fetch->p_apellido;
			$_SESSION['email'] = $fetch->email;
			$_SESSION['genero'] = $fetch->genero;
			$_SESSION['img'] = $fetch->img;
			$_SESSION['rol'] = $fetch->rol;

			#Obtenemos los permisos del usuario 
			$marcados = $usuario->listarmarcados($fetch->id);

			#Declaramos el array para almacenar todos los permios marcados
			$valores = array();

			#Almacenamos los permisos marcados en el array
			while ($per = $marcados->fetch_object()) {
				array_push($valores, $per->idpermiso);
			}

			#Determinamos los accesos del usuario
			in_array(1, $valores) ? $_SESSION['escritorio'] = 1 : $_SESSION['escritorio'] = 0; 
			in_array(2, $valores) ? $_SESSION['usuario'] = 1 : $_SESSION['almacen'] = 0;    
		}
		echo json_encode($fetch);

		break;

	case 'salir':
		#Limpiamos las variables de sesión
		session_unset();

		#Destruimos la sesión
		session_destroy();

		#Redireccionamos al login
		header('location: ../index.php');
		
		break;

	case 'desactivar': 

		$rspta = $usuario->desactivar($idusuario);
		echo $rspta ? 'true' : 'false';
		break;

	case 'activar': 

		$rspta = $usuario->activar($idusuario);
		echo $rspta ? 'true' : 'false';
		break;

	case 'comprobarrepresentante': 
		$cedula = $_POST['cedula'];
		$rspta = $representante->comprobarrepresentante($cedula);
		echo json_encode($rspta->fetch_object());
		break;
	
}