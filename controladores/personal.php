<?php 

#Se inicia la sesión
if (strlen(session_id() < 1)) session_start(); 

#Se incluye el modelo de Usuario
require_once '../modelos/Usuario.php';

#Se instancia el objeto de Usuario
$usuario = new Usuario();

#Se reciben los datos por POST y se asignan a variables

$idusuario = isset($_POST['idusuario']) ? limpiarCadena($_POST['idusuario']) : '';
$cedula = isset($_POST['cedula']) ? limpiarCadena($_POST['cedula']) : '';
$p_nombre = isset($_POST['p_nombre']) ? limpiarCadena($_POST['p_nombre']) : '';
$s_nombre = isset($_POST['s_nombre']) ? limpiarCadena($_POST['s_nombre']) : '';
$p_apellido = isset($_POST['p_apellido']) ? limpiarCadena($_POST['p_apellido']) : '';
$s_apellido = isset($_POST['s_apellido']) ? limpiarCadena($_POST['s_apellido']) : '';
$genero = isset($_POST['genero']) ? limpiarCadena($_POST['genero']) : '';
$f_nac = isset($_POST['f_nac']) ? limpiarCadena($_POST['f_nac']) : '';
$email = isset($_POST['email']) ? limpiarCadena($_POST['email']) : '';
$celular = isset($_POST['celular']) ? limpiarCadena($_POST['celular']) : '';
$fijo = isset($_POST['fijo']) ? limpiarCadena($_POST['fijo']) : '';
$rol = isset($_POST['rol']) ? limpiarCadena($_POST['rol']) : '';

//Variables para inicio de sesión
$user = isset($_POST['user']) ? limpiarCadena($_POST['user']) : '';
$pass = isset($_POST['pass']) ? limpiarCadena($_POST['pass']) : '';

#Se ejecuta un caso dependiendo del valor del parámetro GET
switch ($_GET['op']) {
	case 'guardaryeditar':

		#Se incluye el modelo de Persona
		require_once '../modelos/Persona.php';
		$persona = new Persona();

		#Se incluye el modelo de Teléfono
		require_once '../modelos/Telefono.php';
		$telefono = new Telefono();

		#Se deshabilita el guardado automático de la base de datos
		autocommit(FALSE);

		#Si la variable esta vacía quiere decir que es un nuevo registro
		if (empty($idusuario)) {
			
			#Variable para comprobar que todo salió bien al final
			$sw = TRUE;

			#Se registra la persona y se devuelve el id del registro
			$idpersona = $persona->insertar($cedula, $p_nombre, $s_nombre, $p_apellido, $s_apellido, $genero, $f_nac, $email) or $sw = FALSE;

			#Verifica que las variables de los teléfonos contengan datos y los guarda
			if (!empty($celular)) {
				$telefono->insertar($idpersona, $celular, 'M') or $sw = FALSE;
			}
			if (!empty($fijo)) {
				$telefono->insertar($idpersona, $fijo, 'F') or $sw = FALSE;
			}


			#Se obtiene la contraseña que es la cédula sin el tipo de documento
			list($documento, $clave) = explode('-', $cedula);

			#Se encripta la clave con el algoritmo SHA256
			$clavehash = hash('SHA256', $clave);

			#Se registra el usuario
			$rspta = $usuario->insertar($idpersona, $cedula, $clavehash, $rol, '', 0, 1, $_POST['permiso']) or $sw = FALSE;

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

		}
		break;

	case 'permisos':
		#Se incluye el modelo de permiso
		require_once '../modelos/Permiso.php';
		$permiso = new Permiso();
		$rspta = $permiso->listar();

		#Se obtiene el id si fué enviado
		$id = isset($_GET['id']) ? $_GET['id'] : '';

		#Sólo se ejecuta si al solicitar listar permisos se envía un id
		if (!empty($id)) {
			$marcados = $usuario->listarmarcados($id);

			$valores = array();

			while ($per = $marcados->fetch_object()) {
				array_push($valores, $per->idpermiso);
			}

			while ($reg = $rspta->fetch_object()) {
			$escritorio = $reg->permiso == 'Escritorio' ? 'checked' : '';
			$sw = in_array($reg->idpermiso, $valores) ? 'checked' : '';
			echo '<div class="custom-control custom-checkbox col-sm-12">
            		<input type="checkbox" class="custom-control-input" id="'.$reg->permiso.'"'.$sw.' '.$escritorio.' name="permiso[]" value="'.$reg->id.'" >
                    <label class="custom-control-label" for="'.$reg->permiso.'">'.ucfirst($reg->permiso).'</label>
                  </div>';
			}	
		}
		else {
			while ($reg = $rspta->fetch_object()) {
				$escritorio = $reg->permiso == 'Escritorio' ? 'checked' : '';
				echo '<div class="custom-control custom-checkbox col-sm-12">
            		<input type="checkbox" class="custom-control-input" id="'.$reg->permiso.'" name="permiso[]" value="'.$reg->id.'" '.$escritorio.'>
                    <label class="custom-control-label" for="'.$reg->permiso.'">'.ucfirst($reg->permiso).'</label>
                  </div>';
			}
		}

		break;

	case 'listar':

		$rspta = $usuario->listar();


		/*=========================================================
		=            Funciones para comprobar Director            =
		=========================================================*/
		
		$comprobardirector = $usuario->comprobardirector();

		$comprobardirector = $comprobardirector->fetch_object();
		$data = array();
		
		/*=====  End of Funciones para comprobar Director  ======*/
		


		/*============================================================
		=            Funciones para comprobar subdirector            =
		============================================================*/

		$comprobarsubdirector = $usuario->comprobarsubdirector();

		$comprobarsubdirector = $comprobarsubdirector->fetch_object();
			
		/*=====  End of Funciones para comprobar subdirector  ======*/
		

		while ($reg = $rspta->fetch_object()) {

			if ($comprobardirector == '') {
				if ($reg->rol == 'Docente' || $reg->rol == 'Personal') {
					$director = ' <button class="btn bg-teal text-white " title="Promover a director" onclick="promoverdirector('.$reg->id.')"><i class="fas fa-chevron-up"></i></button>';
				}
				else {
					$director = '';
				}
			}
			else {
				if ($reg->rol == 'Director(a)') {
					$director = ' <button class="btn bg-teal text-white" title="Docente" onclick="degradardirector('.$reg->id.')"><i class="fas fa-chevron-down"></i></button>';
				}
				else {

					$director = '';
				}
			}


			if ($comprobarsubdirector == '') {
				if ($reg->rol == 'Docente' || $reg->rol == 'Personal') {
					$subdirector = ' <button class="btn bg-indigo text-white" title="Promover a Subdirector" onclick="promoversubdirector('.$reg->id.')"><i class="fas fa-chevron-up"></i></button>';
				}
				else {
					$subdirector = '';
				}
			}
			else {
				if ($reg->rol == 'Subdirector(a)') {
					$subdirector = ' <button class="btn bg-indigo text-white" title="Docente" onclick="degradarsubdirector('.$reg->id.')"><i class="fas fa-chevron-down"></i></button>';
				}
				else {

					$subdirector = '';
				}
			}


			$data[] = array('0' => ($reg->estatus) ? '<button class="btn btn-outline-primary " title="Editar" onclick="editar('.$reg->id.')"><i class="fas fa-edit"></i></button>'.

				' <button class="btn btn-outline-danger" title="Desactivar" onclick="desactivar('.$reg->id.')"> <i class="fas fa-times"> </i></button> '.$director.' '.$subdirector 

					 :

				 '<button class="btn btn-outline-primary" title="Editar" onclick="mostrar('.$reg->id.')"><i class="fa fa-edit"></i></button>'.

				 ' <button class="btn btn-outline-success" title="Activar" onclick="activar('.$reg->id.')"><i class="fa fa-check"></i></button> '.$director.' '.$subdirector,

				 	'1' => $reg->usuario,
				 	'2' => $reg->p_nombre,
				 	'3' => $reg->p_apellido,
					'4' => $reg->email,
					'5' => ucfirst($reg->rol));
		}

		$results = array(
			"draw" => 0, #Esto tiene que ver con el procesamiento del lado del servidor
			"recordsTotal" => count($data), #Se envía el total de registros al datatable
			"recordsFiltered" => count($data), #Se envía el total de registros a visualizar
			"data" => $data #datos en un array

		);

		echo json_encode($results);

		break;

	case 'mostrar':
	
		$rspta = $usuario->mostrar($idusuario);

		#Se codifica el resultado utilizando Json
		echo json_encode($rspta);

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

	case 'comprobarusuario': 
		$cedula = $_POST['cedula'];
		$rspta = $usuario->comprobarusuario($cedula);
		echo json_encode($rspta->fetch_object());
		break;

	case 'promoverdirector': 
		$idusuario = $_POST['idusuario'];
		$rspta = $usuario->promoverdirector($idusuario);
		echo $rspta;
		break;

	case 'degradardirector': 
		$idusuario = $_POST['idusuario'];
		$rspta = $usuario->degradardirector($idusuario);
		echo $rspta;
		break;

	case 'promoversubdirector': 
		$idusuario = $_POST['idusuario'];
		$rspta = $usuario->promoversubdirector($idusuario);
		echo $rspta;
		break;

	case 'degradarsubdirector': 
		$idusuario = $_POST['idusuario'];
		$rspta = $usuario->degradarsubdirector($idusuario);
		echo $rspta;
		break;
	
}