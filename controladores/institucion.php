<?php 

#Se inicia la sesión
if (strlen(session_id() < 1)) session_start(); 

#Se incluye el modelo de Institución
require_once '../modelos/Institucion.php';

#Se instancia el objeto de Institución
$Institucion = new Institucion();

$idinstitucion = isset($_POST['idinstitucion']) ? limpiarCadena($_POST['idinstitucion']) : '';
$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
$telefono = isset($_POST['telefono']) ? limpiarCadena($_POST['telefono']) : '';
$correo = isset($_POST['correo']) ? limpiarCadena($_POST['correo']) : '';
$dependencia = isset($_POST['dependencia']) ? limpiarCadena($_POST['dependencia']) : '';
$cod_dea = isset($_POST['cod_dea']) ? limpiarCadena($_POST['cod_dea']) : '';
$cod_estadistico = isset($_POST['cod_estadistico']) ? limpiarCadena($_POST['cod_estadistico']) : '';
$cod_dependencia = isset($_POST['cod_dependencia']) ? limpiarCadena($_POST['cod_dependencia']) : '';
$cod_electoral = isset($_POST['cod_electoral']) ? limpiarCadena($_POST['cod_electoral']) : '';
$cod_smee = isset($_POST['cod_smee']) ? limpiarCadena($_POST['cod_smee']) : '';
$idestado = isset($_POST['idestado']) ? limpiarCadena($_POST['idestado']) : '';
$idmunicipio = isset($_POST['idmunicipio']) ? limpiarCadena($_POST['idmunicipio']) : '';
$idparroquia = isset($_POST['idparroquia']) ? limpiarCadena($_POST['idparroquia']) : '';
$direccion = isset($_POST['direccion']) ? limpiarCadena($_POST['direccion']) : '';
$fecha_fundada = isset($_POST['fecha_fundada']) ? limpiarCadena($_POST['fecha_fundada']) : '';
$fecha_bolivariana = isset($_POST['fecha_bolivariana']) ? limpiarCadena($_POST['fecha_bolivariana']) : '';
$clase_plantel = isset($_POST['clase_plantel']) ? limpiarCadena($_POST['clase_plantel']) : '';
$categoria = isset($_POST['categoria']) ? limpiarCadena($_POST['categoria']) : '';
$condicion_estudio = isset($_POST['condicion_estudio']) ? limpiarCadena($_POST['condicion_estudio']) : '';
$tipo_matricula = isset($_POST['tipo_matricula']) ? limpiarCadena($_POST['tipo_matricula']) : '';
$turno = isset($_POST['turno']) ? limpiarCadena($_POST['turno']) : '';
$horario = isset($_POST['horario']) ? limpiarCadena($_POST['horario']) : '';
$codigo_qr = isset($_POST['codigo_qr']) ? limpiarCadena($_POST['codigo_qr']) : '';

#Se ejecuta un caso dependiendo del valor del parámetro GET
switch ($_GET['op']) {

	case 'guardaryeditar':

		#Se deshabilita el guardado automático de la base de datos
		autocommit(FALSE);

		#Variable para comprobar que todo salió bien al final
		$sw = TRUE;

		#Si la variable esta vacía quiere decir que es un nuevo registro
		if (empty($idinstitucion)) {
			
			#Se registra los datos de la institución
			$Institucion->insertar($nombre, $telefono, $correo, $dependencia, $cod_dea, $cod_estadistico, $cod_dependencia, $cod_electoral, $cod_smee, $idestado, $idmunicipio, $idparroquia, $direccion, $fecha_fundada, $fecha_bolivariana, $clase_plantel, $categoria, $condicion_estudio, $tipo_matricula, $turno, $horario, $codigo_qr) or $sw = FALSE;

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

			#Se editan los datos de la institución
			$Institucion->editar($idinstitucion, $nombre, $telefono, $correo, $dependencia, $cod_dea, $cod_estadistico, $cod_dependencia, $cod_electoral, $cod_smee, $idestado, $idmunicipio, $idparroquia, $direccion, $fecha_fundada, $fecha_bolivariana, $clase_plantel, $categoria, $condicion_estudio, $tipo_matricula, $turno, $horario, $codigo_qr) or $sw = FALSE;

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

	case 'mostrar':
	
		$rspta = $Institucion->mostrar();

		#Se codifica el resultado utilizando Json
		echo json_encode($rspta);

		break;

	case 'mostrardatosinstitucion':
		
		$rol = $_SESSION['rol'];
		$idusuario = $_SESSION['idusuario'];

		$idpersonal = $Institucion->seleccionarIdPersonal($idusuario);
		$idpersonal = !empty($idpersonal) ? $idpersonal['id'] : '';

		$idPlanificacionPersonal = $Institucion->seleccionarIdPlanificaionPersonal($idpersonal);
		$idPlanificacionPersonal = !empty($idPlanificacionPersonal) ? $idPlanificacionPersonal['id'] : '';


		$rspta = $Institucion->mostrardatosinstitucion($rol, $idPlanificacionPersonal);

		$ambientes = $Institucion->obtenerambientes();

		$rspta = array_merge($rspta, $ambientes);

		#Se codifica el resultado utilizando Json
		echo json_encode($rspta);
		break;
}