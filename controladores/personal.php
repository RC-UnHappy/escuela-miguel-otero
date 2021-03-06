<?php 

#Se inicia la sesión
if (strlen(session_id() < 1)) session_start(); 

#Se incluye el modelo de Personal
require_once '../modelos/Personal.php';

#Se instancia el objeto de Personal
$Personal = new Personal();

#Se reciben los datos por POST y se asignan a variables

$idpersonal = isset($_POST['idpersonal']) ? limpiarCadena($_POST['idpersonal']) : '';
$idpersona = isset($_POST['idpersona']) ? limpiarCadena($_POST['idpersona']) : '';
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
$cargo = isset($_POST['cargo']) ? limpiarCadena($_POST['cargo']) : '';
$cargo_directivo = isset($_POST['cargo_directivo']) ? $_POST['cargo_directivo'] : '';

#Se ejecuta un caso dependiendo del valor del parámetro GET
switch ($_GET['op']) {
	case 'guardaryeditar':

		#Se incluye el modelo de Persona
		require_once '../modelos/Persona.php';
		$Persona = new Persona();

		#Se incluye el modelo de Teléfono
		require_once '../modelos/Telefono.php';
		$Telefono = new Telefono();

		#Se deshabilita el guardado automático de la base de datos
		autocommit(FALSE);

		#Si la variable esta vacía quiere decir que es un nuevo registro
		if (empty($idpersonal) && empty($idpersona)) {
			
			#Variable para comprobar que todo salió bien al final
			$sw = TRUE;

			#Se registra la persona y se devuelve el id del registro
			$idpersona = $Persona->insertar($cedula, $p_nombre, $s_nombre, $p_apellido, $s_apellido, $genero, $f_nac, $email) or $sw = FALSE;

			#Verifica que las variables de los teléfonos contengan datos y los guarda
			if (!empty($celular)) {
				$Telefono->insertar($idpersona, $celular, 'M') or $sw = FALSE;
			}
			if (!empty($fijo)) {
				$Telefono->insertar($idpersona, $fijo, 'F') or $sw = FALSE;
			}

			#Se registra el personal
      $idpersonal = $Personal->insertar($idpersona, $cargo, '1') or $sw = FALSE;
      

      $idperiodo_escolar = $Personal->consultarperiodo();
      $idperiodo_escolar = !empty($idperiodo_escolar) ? $idperiodo_escolar['id'] : '';

      if (!empty($cargo_directivo) && empty($idperiodo_escolar)) {
        echo 'establecer_periodo_escolar';
        die;
      }
      /**
       * Métodos para asignar cargos directivos
       */
      $Personal->quitar_cargo_directivo($cargo_directivo) or $sw = FALSE;



      $esto =$Personal->asignar_cargo_directivo($idpersonal, $idperiodo_escolar, $cargo_directivo) or $sw = FALSE;

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
		#Ésto es cuando la persona ya estaba registrada en el sistema pero no como personal
		elseif (!empty($idpersona) && empty($idpersonal)) {
			#Variable para comprobar que todo salió bien al final
			$sw = TRUE;

			#Se editan los datos de la persona
			$Persona->editar($idpersona, $cedula, $p_nombre, $s_nombre, $p_apellido, $s_apellido, $genero, $f_nac, $email) or $sw = FALSE;

			#Verifica que las variables de los teléfonos contengan datos y los guarda
			if (!empty($celular)) {
				$Telefono->eliminar($idpersona, 'M') or $sw = FALSE;
				$Telefono->insertar($idpersona, $celular, 'M') or $sw = FALSE;
			}
			else {
				$Telefono->eliminar($idpersona, 'M') or $sw = FALSE;
			}
			if (!empty($fijo)) {
				$Telefono->eliminar($idpersona, 'F') or $sw = FALSE;
				$Telefono->insertar($idpersona, $fijo, 'F') or $sw = FALSE;
			}
			else {
				$telefono->eliminar($personaId, 'F') or $sw = FALSE;
			}

			#Se registra el personal
      $idpersonal = $Personal->insertar($idpersona, $cargo, '1') or $sw = FALSE;
      
      /**
       * Métodos para asignar cargos directivos
       */
      $Personal->quitar_cargo_directivo($cargo_directivo) or $sw = FALSE;

      $idperiodo_escolar = $Personal->consultarperiodo();
      $idperiodo_escolar = $idperiodo_escolar['id'];

      $Personal->asignar_cargo_directivo($idpersonal, $idperiodo_escolar, $cargo_directivo) or $sw = FALSE;

			#Se verifica que todo salió bien y se guardan los datos o se eliminan todos
			if ($sw) {
				commit();
				echo 'update';
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
			$idpersona = $Personal->idpersona($idpersonal);
			$idpersona = $idpersona['idpersona'];

			#Se editan los datos de la persona
			$Persona->editar($idpersona, $cedula, $p_nombre, $s_nombre, $p_apellido, $s_apellido, $genero, $f_nac, $email) or $sw = FALSE;

			#Verifica que las variables de los teléfonos contengan datos y los guarda
			if (!empty($celular)) {
				$Telefono->eliminar($idpersona, 'M') or $sw = FALSE;
				$Telefono->insertar($idpersona, $celular, 'M') or $sw = FALSE;
			}
			else {
				$Telefono->eliminar($idpersona, 'M') or $sw = FALSE;
			}
			if (!empty($fijo)) {
				$Telefono->eliminar($idpersona, 'F') or $sw = FALSE;
				$Telefono->insertar($idpersona, $fijo, 'F') or $sw = FALSE;
			}
			else {
				$Telefono->eliminar($idpersona, 'F') or $sw = FALSE;
			}

			#Se edita el personal
      $rspta = $Personal->editar($idpersonal, $cargo) or $sw = FALSE;
      
      /**
       * Métodos para asignar cargos directivos
       */
      $Personal->quitar_cargo_directivo($cargo_directivo) or $sw = FALSE;

      $idperiodo_escolar = $Personal->consultarperiodo();
      $idperiodo_escolar = $idperiodo_escolar['id'];

      $Personal->asignar_cargo_directivo($idpersonal, $idperiodo_escolar, $cargo_directivo) or $sw = FALSE;

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

		$rspta = $Personal->listar();

		if ($rspta->num_rows != 0) {

			while ($reg = $rspta->fetch_object()) {

				$data[] = array('0' => 

					($reg->estatus) ? 

					( ( isset($_SESSION['permisos']['personal']) && 
                  	  in_array('editar' , $_SESSION['permisos']['personal']) ) ?

					'<button class="btn btn-outline-primary " title="Editar" onclick="mostrar('.$reg->id.')"><i class="fas fa-edit"></i></button>' : '').

					( ( isset($_SESSION['permisos']['personal']) && 
                  	  in_array('activar-desactivar' , $_SESSION['permisos']['personal']) ) ?

					' <button class="btn btn-outline-danger" title="Desactivar" onclick="desactivar('.$reg->id.')"> <i class="fas fa-times"> </i></button> ': '')

					:

					( ( isset($_SESSION['permisos']['personal']) && 
                  	  in_array('editar' , $_SESSION['permisos']['personal']) ) ?

					 '<button class="btn btn-outline-primary" title="Editar" onclick="mostrar('.$reg->id.')"><i class="fa fa-edit"></i></button>' : '').

					( ( isset($_SESSION['permisos']['personal']) && 
                  	  in_array('activar-desactivar' , $_SESSION['permisos']['personal']) ) ?

					 ' <button class="btn btn-outline-success" title="Activar" onclick="activar('.$reg->id.')"><i class="fa fa-check"></i></button> ' : ''),

					 	'1' => $reg->cedula,
					 	'2' => ucfirst($reg->p_nombre),
					 	'3' => ucfirst($reg->p_apellido),
						'4' => $reg->email,
						'5' => $reg->celular,
						'6' => $reg->fijo,
						'7' => $reg->cargo);
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
	
		$rspta = $Personal->mostrar($idpersonal);

		#Se codifica el resultado utilizando Json
		echo json_encode($rspta);

		break;

	case 'desactivar': 

		$rspta = $Personal->desactivar($idpersonal);
		echo $rspta ? 'true' : 'false';
		break;

	case 'activar': 

		$rspta = $Personal->activar($idpersonal);
		echo $rspta ? 'true' : 'false';
		break;

	case 'comprobarpersonal': 
		$cedula = $_POST['cedula'];
		$rspta = $Personal->comprobarpersonal($cedula);
		echo json_encode($rspta->fetch_object());
		break;

	case 'comprobarpersona': 
		$cedula = $_POST['cedula'];
		$rspta = $Personal->comprobarpersona($cedula);
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
    
  case 'traerpersonaldirectivo':
    $director = $Personal->traerpersonaldirectivo('director');
    $subdirector_administrativo = $Personal->traerpersonaldirectivo('subdirector-administrativo');
    $subdirector_academico = $Personal->traerpersonaldirectivo('subdirector-academico');
    
    $directivos = array('director' => !empty($director) ? $director['p_nombre'].' '.$director['p_apellido'] : '',
    'subdirectorAdministrativo' => !empty($subdirector_administrativo) ?  $subdirector_administrativo['p_nombre'].' '.$subdirector_administrativo['p_apellido'] : '',
    'subdirectorAcademico' => !empty($subdirector_academico) ? $subdirector_academico['p_nombre'].' '.$subdirector_academico['p_apellido'] : ''
  
    );

    echo json_encode($directivos);
    break;
	
}