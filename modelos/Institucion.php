<?php 

#Se incluye la conexión a la base de datos
require_once '../config/conexion.php';

/**
 * Modelo de Institución
 */
class Institucion 
{	
	
	#Constructor de la clase
	public function __construct()
	{
		
	}

	#Método para insertar registros
	function insertar($nombre, $telefono, $correo, $dependencia, $cod_dea, $cod_estadistico, $cod_dependencia, $cod_electoral, $cod_smee, $idestado, $idmunicipio, $idparroquia, $direccion, $fecha_fundada, $fecha_bolivariana, $clase_plantel, $categoria, $condicion_estudio, $tipo_matricula, $turno, $horario, $codigo_qr)
	{
		$sql = "INSERT INTO institucion (id, nombre, telefono, correo, dependencia, cod_dea, cod_estadistico, cod_dependencia, cod_electoral, cod_smee, idestado, idmunicipio, idparroquia, direccion, fecha_fundada, fecha_bolivariana, clase_plantel, categoria, condicion_estudio, tipo_matricula, turno, horario, codigo_qr) VALUES(NULL, '$nombre', '$telefono', '$correo', '$dependencia', '$cod_dea', '$cod_estadistico', '$cod_dependencia', '$cod_electoral', '$cod_smee,', '$idestado', '$idmunicipio', '$idparroquia', '$direccion', '$fecha_fundada', '$fecha_bolivariana', '$clase_plantel', '$categoria', '$condicion_estudio', '$tipo_matricula', '$turno', '$horario', '$codigo_qr')";

		return ejecutarConsulta($sql);
	}

	#Método para editar registros
	function editar($idinstitucion, $nombre, $telefono, $correo, $dependencia, $cod_dea, $cod_estadistico, $cod_dependencia, $cod_electoral, $cod_smee, $idestado, $idmunicipio, $idparroquia, $direccion, $fecha_fundada, $fecha_bolivariana, $clase_plantel, $categoria, $condicion_estudio, $tipo_matricula, $turno, $horario, $codigo_qr)
	{
		$sql = "UPDATE institucion SET nombre = '$nombre', telefono = '$telefono', correo = '$correo', dependencia = '$dependencia', cod_dea = '$cod_dea', cod_estadistico = '$cod_estadistico', cod_dependencia = '$cod_dependencia', cod_electoral = '$cod_electoral',cod_smee = '$cod_smee,', idestado = '$idestado', idmunicipio = '$idmunicipio', idparroquia = '$idparroquia', direccion = '$direccion', fecha_fundada = '$fecha_fundada', fecha_bolivariana = '$fecha_bolivariana', clase_plantel = '$clase_plantel', categoria = '$categoria', condicion_estudio = '$condicion_estudio', tipo_matricula = '$tipo_matricula', turno = '$turno', horario = '$horario', codigo_qr = '$codigo_qr' WHERE id = '$idinstitucion'";

		return ejecutarConsulta($sql);

	}

	#Método para mostrar los datos de la institución
	public function mostrardatosinstitucion($rol, $idPlanificacionPersonal)
	{
		if ($rol == 'Docente') {
			$sql = "SELECT i.id, i.nombre, i.direccion, i.idmunicipio, i.idparroquia, i.idestado, i.telefono, i.correo, i.dependencia, i.cod_dea, i.cod_estadistico, i.cod_dependencia, i.cod_electoral, i.cod_smee, i.fecha_fundada, i.fecha_bolivariana, i.clase_plantel, i.categoria, i.condicion_estudio, i.tipo_matricula, i.turno, i.horario, e.estado, m.municipio, p.parroquia, (SELECT COUNT(var.id) FROM estudiante var WHERE var.idpersona IN (SELECT id FROM persona pervar WHERE var.idpersona = pervar.id AND pervar.genero = 'M') AND var.estatus = 'INSCRITO' AND var.id IN (SELECT idestudiante FROM inscripcion WHERE idplanificacion = '$idPlanificacionPersonal') ) as varones, (SELECT COUNT(hem.id) FROM estudiante hem WHERE hem.idpersona IN (SELECT id FROM persona perhem WHERE hem.idpersona = perhem.id AND perhem.genero = 'F') AND hem.estatus = 'INSCRITO' AND hem.id IN (SELECT idestudiante FROM inscripcion WHERE idplanificacion = '$idPlanificacionPersonal')) as hembras, (SELECT COUNT(id) FROM estudiante WHERE estatus = 'INSCRITO' AND id IN (SELECT idestudiante FROM inscripcion WHERE idplanificacion = '$idPlanificacionPersonal') ) as estudiantes FROM institucion i INNER JOIN estado e ON i.idestado = e.id INNER JOIN municipio m ON i.idmunicipio = m.id INNER JOIN parroquia p ON i.idparroquia = p.id ORDER BY i.id DESC LIMIT 1";
		}
		else if ($rol == 'Administrador') {
    		$sql = "SELECT i.id, i.nombre, i.direccion, i.idmunicipio, i.idparroquia, i.idestado, i.telefono, i.correo, i.dependencia, i.cod_dea, i.cod_estadistico, i.cod_dependencia, i.cod_electoral, i.cod_smee, i.fecha_fundada, i.fecha_bolivariana, i.clase_plantel, i.categoria, i.condicion_estudio, i.tipo_matricula, i.turno, i.horario, e.estado, m.municipio, p.parroquia, (SELECT COUNT(esp.id) FROM personal esp WHERE esp.cargo LIKE '%Especialista%') as especialistas , (SELECT COUNT(doc.id) FROM personal doc WHERE doc.cargo LIKE '%Docente%') as docentes, (SELECT COUNT(obr.id) FROM personal obr WHERE obr.cargo LIKE '%Obrero%') as obreros, (SELECT COUNT(adm.id) FROM personal adm WHERE adm.cargo LIKE '%Administrativo%') as administrativos, (SELECT COUNT(vig.id) FROM personal vig WHERE vig.cargo LIKE '%Vigilante%') as vigilantes, (SELECT COUNT(var.id) FROM estudiante var WHERE var.idpersona IN (SELECT id FROM persona pervar WHERE var.idpersona = pervar.id AND pervar.genero = 'M') AND var.estatus = 'INSCRITO') as varones, (SELECT COUNT(hem.id) FROM estudiante hem WHERE hem.idpersona IN (SELECT id FROM persona perhem WHERE hem.idpersona = perhem.id AND perhem.genero = 'F') AND hem.estatus = 'INSCRITO') as hembras, (SELECT COUNT(id) FROM estudiante WHERE estatus = 'INSCRITO') as estudiantes FROM institucion i INNER JOIN estado e ON i.idestado = e.id INNER JOIN municipio m ON i.idmunicipio = m.id INNER JOIN parroquia p ON i.idparroquia = p.id ORDER BY i.id DESC LIMIT 1";
		}

		return ejecutarConsultaSimpleFila($sql);
	}

	#Método para obtener los ambientes
	public function obtenerambientes()
	{
		$sql = "SELECT COUNT(amb.id) ambientes FROM ambiente as amb";

		return ejecutarConsultaSimpleFila($sql);
	}

	#Método para mostrar los datos 
	public function mostrar()
	{
		$sql = "SELECT i.*, e.estado, m.municipio, p.parroquia FROM institucion i INNER JOIN estado e ON i.idestado = e.id INNER JOIN municipio m ON i.idmunicipio = m.id INNER JOIN parroquia p ON i.idparroquia = p.id ORDER BY id DESC LIMIT 1";

		return ejecutarConsultaSimpleFila($sql);
	}

	public function seleccionarIdPersonal($idusuario)
	{
		$sql = "SELECT id FROM personal WHERE idpersona = (SELECT idpersona FROM usuario WHERE id = '$idusuario')";

		return ejecutarConsultaSimpleFila($sql);
	}

	public function seleccionarIdPlanificaionPersonal($idpersonal)
	{
		$sql = "SELECT id FROM planificacion WHERE iddocente = '$idpersonal' AND estatus = 'Activo'";

		return ejecutarConsultaSimpleFila($sql);
	}

}