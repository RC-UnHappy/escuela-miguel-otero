<?php 

#Se inicia la sesión
if (strlen(session_id() < 1)) session_start(); 

#Se incluye el modelo de Estudiante
require_once '../modelos/Estudiante.php';

#Se instancia el objeto de Estudiante
$Estudiante = new Estudiante();

#Se reciben los datos por POST y se asignan a variables

$idestudiante = isset($_POST['idestudiante']) ? $_POST['idestudiante'] : '';
$cedula = isset($_POST['cedula']) ? limpiarCadena($_POST['cedula']) : '';
$p_nombre = isset($_POST['p_nombre']) ? limpiarCadena($_POST['p_nombre']) : '';
$s_nombre = isset($_POST['s_nombre']) ? limpiarCadena($_POST['s_nombre']) : '';
$p_apellido = isset($_POST['p_apellido']) ? limpiarCadena($_POST['p_apellido']) : '';
$s_apellido = isset($_POST['s_apellido']) ? limpiarCadena($_POST['s_apellido']) : '';
$genero = isset($_POST['genero']) ? limpiarCadena($_POST['genero']) : '';
$f_nac = isset($_POST['f_nac']) ? limpiarCadena($_POST['f_nac']) : '';
$email = isset($_POST['email']) ? limpiarCadena($_POST['email']) : '';
$parto = isset($_POST['parto']) ? limpiarCadena($_POST['parto']) : '';
$orden = isset($_POST['orden']) ? limpiarCadena($_POST['orden']) : '';
$cedula_madre = isset($_POST['cedula_madre']) ? limpiarCadena($_POST['cedula_madre']) : '';
$idmadre = isset($_POST['idmadre']) ? limpiarCadena($_POST['idmadre']) : '';
$cedula_padre = isset($_POST['cedula_padre']) ? limpiarCadena($_POST['cedula_padre']) : '';
$idpadre = isset($_POST['idpadre']) ? limpiarCadena($_POST['idpadre']) : '';
$pais_nacimiento = isset($_POST['pais_nacimiento']) ? limpiarCadena($_POST['pais_nacimiento']) : '';
$estado_nacimiento = isset($_POST['estado_nacimiento']) ? limpiarCadena($_POST['estado_nacimiento']) : '';
$municipio_nacimiento = isset($_POST['municipio_nacimiento']) ? limpiarCadena($_POST['municipio_nacimiento']) : '';
$parroquia_nacimiento = isset($_POST['parroquia_nacimiento']) ? limpiarCadena($_POST['parroquia_nacimiento']) : '';
$estado_residencia = isset($_POST['estado_residencia']) ? limpiarCadena($_POST['estado_residencia']) : '';
$municipio_residencia = isset($_POST['municipio_residencia']) ? limpiarCadena($_POST['municipio_residencia']) : '';
$parroquia_residencia = isset($_POST['parroquia_residencia']) ? limpiarCadena($_POST['parroquia_residencia']) : '';
$direccion = isset($_POST['direccion']) ? $_POST['direccion'] : '';
$vivienda = isset($_POST['vivienda']) ? $_POST['vivienda'] : '';
$sosten = isset($_POST['sosten']) ? $_POST['sosten'] : '';
$grupo_familiar = isset($_POST['grupo_familiar']) ? $_POST['grupo_familiar'] : '';
$ingreso_mensual = isset($_POST['ingreso_mensual']) ? $_POST['ingreso_mensual'] : '';
$canaima = isset($_POST['canaima']) ? $_POST['canaima'] : '';
$condicion_canaima = isset($_POST['condicion_canaima']) ? $_POST['condicion_canaima'] : '';

$idpersona = isset($_SESSION['idpersona']) ? $_SESSION['idpersona'] : null;

$return = new stdClass;
$return->estatus = 1;
$return->msj = '';

#Se ejecuta un caso dependiendo del valor del parámetro GET
switch ($_GET['op']) {
	case 'guardaryeditar':
		#Se incluye el modelo de Persona
		require_once '../modelos/Persona.php';
		$persona = new Persona();

		#Se incluye el modelo de Dirección
		require_once '../modelos/Direccion.php';
		$Direccion = new Direccion();

		#Se incluye el modelo de Lugar Nacimiento
		require_once '../modelos/LugarNacimiento.php';
		$LugarNacimiento = new LugarNacimiento();

		// #Se incluye el modelo de Aspecto Fisiológico
		// require_once '../modelos/AspectoFisiologico.php';
		// $AspectoFisiologico = new AspectoFisiologico();

		// #Se incluye el modelo de Diversidad Funcional
		// require_once '../modelos/DiversidadFuncional.php';
		// $DiversidadFuncional = new DiversidadFuncional();

		// #Se incluye el modelo de Enfermedad
		// require_once '../modelos/Enfermedad.php';
		// $Enfermedad = new Enfermedad();

		#Se incluye el modelo de Aspecto Socioeconómico
		require_once '../modelos/AspectoSocioeconomico.php';
		$AspectoSocioeconomico = new AspectoSocioeconomico();

		#Se incluye el modelo de Canaima
		require_once '../modelos/Canaima.php';
		$Canaima = new Canaima();

		#Se incluye el modelo de Sosten de  Hogar
		require_once '../modelos/SostenHogar.php';
		$SostenHogar = new SostenHogar();

		#Se deshabilita el guardado automático de la base de datos
		autocommit(FALSE);

		#Si la variable esta vacía quiere decir que es un nuevo registro
		if (empty($idestudiante)) {
			
			#Variable para comprobar que todo salió bien al final
			$sw = TRUE;

			#Se registra la persona y se devuelve el id del registro
			$idpersona = $persona->insertar($cedula, $p_nombre, $s_nombre, $p_apellido, $s_apellido, $genero, $f_nac, $email) or $sw = FALSE;
			
			#Se registra la dirección del estudiante
			$Direccion->insertar($idpersona, $parroquia_residencia, $direccion) or $sw = FALSE;

			#Se registra el estudiante
			$estudianteId = $estudiante->insertar($idpersona, $idmadre, $idpadre, $parto, $orden, 'REGISTRADO') or $sw = FALSE;

			#Se registra el lugar de nacimiento del estudiante
			$aquie = $LugarNacimiento->insertar($estudianteId, $parroquia_nacimiento) or $sw = FALSE;

			// #Se registran los aspectos fisiológicos del estudiante
			// $AspectoFisiologico->insertar($estudianteId, $vacunas, $peso, $talla, $alergia) or $sw = FALSE;

			// #Se registran las diversidades funcionales del estudiante
			// $DiversidadFuncional->insertar($estudianteId, $diversidad) or $sw = FALSE;

			// #Se registran las enfermedades del estudiante
			// $Enfermedad->insertar($estudianteId, $enfermedad) or $sw = FALSE;

			#Se registran los aspectos socioeconómicos del estudiante
			$AspectoSocioeconomico->insertar($estudianteId, $vivienda, $grupo_familiar, $ingreso_mensual) or $sw = FALSE;

			#Se registra si el estudiante posee canaima o no
			$Canaima->insertar($estudianteId, $canaima, $condicion_canaima) or $sw = FALSE;
			
			#Se registran los sosten de hogar
			$SostenHogar->insertar($estudianteId, $sosten) or $sw = FALSE;

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
			$idpersona = $estudiante->idpersona($idestudiante);
			$idpersona = $idpersona['idpersona'];

			#Se editan los datos de la persona
			$persona->editar($idpersona, $cedula, $p_nombre, $s_nombre, $p_apellido, $s_apellido, $genero, $f_nac, $email) or $sw = FALSE;
      
			if ($Direccion->verificar($idpersona)) {
        #Se edita la dirección del estudiante
				$Direccion->editar($idpersona, $parroquia_residencia, $direccion) or $sw = FALSE;
			} else {
        #Se edita la dirección del estudiante
				$Direccion->insertar($idpersona, $parroquia_residencia, $direccion) or $sw = FALSE;
			}
      
			// #Se editan los aspectos fisiológicos del estudiante
			// $AspectoFisiologico->editar($idestudiante, $vacunas, $peso, $talla, $alergia) or $sw = FALSE;
      
      
			if ($LugarNacimiento->verificar($idestudiante)) {
        #Se edita el lugar de nacimiento del estudiante
				$LugarNacimiento->editar($idestudiante, $parroquia_nacimiento) or $sw = FALSE;
			}
			else{
        #Se registra el lugar de nacimiento del estudiante
				$LugarNacimiento->insertar($idestudiante, $parroquia_nacimiento) or $sw = FALSE;
			}
      
			
			// #Verifica que la variable de diversidad contenga datos y los guarda
			// if (!empty($diversidad)) {
			// 	$DiversidadFuncional->eliminar($idestudiante) or $sw = FALSE;
			// 	$DiversidadFuncional->insertar($idestudiante, $diversidad) or $sw = FALSE;
			// }
			// else {
			// 	$DiversidadFuncional->eliminar($idestudiante) or $sw = FALSE;
			// }

			// #Verifica que la variable de enfermedad contenga datos y los guarda
			// if (!empty($enfermedad)) {
			// 	$Enfermedad->eliminar($idestudiante) or $sw = FALSE;
			// 	$Enfermedad->insertar($idestudiante, $enfermedad) or $sw = FALSE;
			// }
			// else {
			// 	$Enfermedad->eliminar($idestudiante) or $sw = FALSE;
			// }

      if ($AspectoSocioeconomico->verificar($idestudiante)) {
        #Se editan los aspectos socioeconómicos del estudiante
        $AspectoSocioeconomico->editar($idestudiante, $vivienda, $grupo_familiar, $ingreso_mensual) or $sw = FALSE;      
			}
			else{
        #Se registran los aspectos socioeconómicos del estudiante
			  $AspectoSocioeconomico->insertar($idestudiante, $vivienda, $grupo_familiar, $ingreso_mensual) or $sw = FALSE;
			}
      
			#Verifica que la variable de sosten contenga datos y los guarda
			if (!empty($sosten)) {
        $SostenHogar->eliminar($idestudiante) or $sw = FALSE;
				$SostenHogar->insertar($idestudiante, $sosten) or $sw = FALSE;
			}
			else {
        $SostenHogar->eliminar($idestudiante) or $sw = FALSE;
      }

      # Se verifica la canaima
      if ($Canaima->verificar($idestudiante)) {
        #Se edita si el estudiante posee canaima o no
			  $Canaima->editar($idestudiante, $canaima, $condicion_canaima) or $sw = FALSE;     
			}
			else{
        #Se registra si el estudiante posee canaima o no
			  $Canaima->insertar($idestudiante, $canaima, $condicion_canaima) or $sw = FALSE;
			}
      
			   
			#Se edita el estudiante
			$rspta = $estudiante->editar($idestudiante, $idmadre, $idpadre, $parto, $orden) or $sw = FALSE;
      

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

		require_once '../modelos/Representante.php';
		$Representante = new Representante();

		$representante = $Representante->representanteporidpersona($idpersona);

		$idrepresentante = !empty($representante) ? $representante['id'] : null;
		$rspta = $Estudiante->traerinscripcionesporrepresentante($idrepresentante);

		$data = array();

		#Establece la zona horaria
		date_default_timezone_set('America/Caracas');

		if ($rspta->num_rows != 0) {

			while ($reg = $rspta->fetch_object()) {

				// var_dump($reg);
				// die;
  
	        list($anoN, $mesN, $diaN) = explode('-', $reg->fechaE);
	        list($anoA, $mesA, $diaA) = explode('-', date('Y-m-d'));
        
			if ($mesN == $mesA) {
	         	if ($diaN == $diaA) {
	            	$edad = $anoA - $anoN;
					$cumple = ' <span class="pull-right badge badge-light"><i class="fa fa-birthday-cake" style="font-size:18px; color: #F06292;"></i></span><span class="sr-only">Cumpleaños</span>';
				}
				elseif ($diaN < $diaA) {
	            	$edad = $anoA - $anoN;
				}
				else {
	            	$edad = ($anoA - $anoN) - 1;
				}
			}
			elseif ($mesN > $mesA ) {
	          $edad = ($anoA - $anoN) - 1;
	          
			}
			else {
	          $edad = ($anoA - $anoN);  
	        }
        
			$data[] = array('0' => 

				($reg->estatus_estudiante == 'INSCRITO') ? 

				( ( isset($_SESSION['permisos']['representado']) && 
	              	in_array('ver' , $_SESSION['permisos']['representado']) ) ?

				' <button class="btn btn-outline-primary" title="Ver" onclick="mostrar('.$reg->idE.')"><i class="fa fa-eye"></i></button>' : '').
				
				( ( isset($_SESSION['permisos']['representado']) && 
	              	in_array('ver' , $_SESSION['permisos']['representado']) ) ?

				' <a target="_blank" href="../../reporte/constancia-estudio.php?idpersona='.$reg->idP.'&idestudiante='.$reg->idE.'"> <button class="btn btn-primary" title="Constancia de estudio"><i class="fa fa-file"></i></button></a>' : '')

				 :

				 ( ( isset($_SESSION['permisos']['representado']) && 
	              	  in_array('ver' , $_SESSION['permisos']['representado']) ) ?

				'<button class="btn btn-outline-primary" title="Ver" onclick="mostrar('.$reg->idE.')"><i class="fa fa-eye"></i></button>' : ''),

				 	'1' => $reg->cedulaE,
				 	'2' => $reg->nombreE,
				 	'3' => $reg->apellidoE,
					'4' => $edad.$cumple = isset($cumple) ? $cumple : '',
					'5' => $reg->estatus_estudiante);
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
		return;
		break;

	case 'listarpaises':
		$rspta = $Estudiante->listarpaises();
		
		while ($pais = $rspta->fetch_object()) {
			echo '<option value="' . $pais->id . '">' . $pais->pais . '</option>';
		}
		return;
		break;

	case 'listarestados':
		$idpais = isset($_GET['idpais']) ? $_GET['idpais'] : NULL; 
		$rspta = $Estudiante->listarestados($idpais);

		while ($estado = $rspta->fetch_object()) {
			echo '<option value="'.$estado->id.'">'.$estado->estado.'</option>';
		}

		break;

	case 'listarmunicipios':		
		$idestado = isset($_GET['idestado']) ? $_GET['idestado'] : NULL; 
		$rspta = $estudiante->listarmunicipios($idestado);

		while ($municipio = $rspta->fetch_object()) {
			echo '<option value="'.$municipio->id.'">'.$municipio->municipio.'</option>';
		}

		break;

	case 'listarparroquias':		
		$idmunicipio = isset($_GET['idmunicipio']) ? $_GET['idmunicipio'] : NULL; 
		$rspta = $estudiante->listarparroquias($idmunicipio);

		while ($parroquia = $rspta->fetch_object()) {
			echo '<option value="'.$parroquia->id.'">'.$parroquia->parroquia.'</option>';
		}

		break;

	case 'mostrar':
		require_once '../modelos/LapsoAcademico.php';
		$LapsoAcademico = new LapsoAcademico();


		$rspta = $Estudiante->mostrar($idestudiante);
		$return->estudiante = $rspta->fetch_object();

		$inscripciones = $Estudiante->traerinscripciones($idestudiante);

		$inscripciones = $inscripciones->fetch_all(MYSQLI_ASSOC);

		
		foreach ($inscripciones as $index => $inscripcion) {
			$lapsos = $LapsoAcademico->listar($inscripcion['idperiodo_escolar']);
			
			$inscripciones[$index]['lapsos'] = $lapsos->fetch_all(MYSQLI_ASSOC);		
		}
		
		$return->inscripciones = $inscripciones;
		// var_dump($inscripciones);
		// die;
		#Se codifica el resultado utilizando Json
		echo json_encode($return);
		return;
		break;
	case 'comprobarpadres': 
		$cedula = $_POST['comprobarpadres'];
		$generopadres = $_POST['generopadres'];
		$rspta = $Estudiante->comprobarpadres($cedula, $generopadres);
		echo json_encode($rspta->fetch_object());
		break;

}