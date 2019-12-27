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
	function insertar($nombre, $telefono, $correo, $dependencia, $cod_dea, $cod_estadistico, $cod_dependencia, $cod_electoral, $idestado, $idmunicipio, $idparroquia, $direccion, $fecha_fundada, $fecha_bolivariana, $clase_plantel, $categoria, $condicion_estudio, $tipo_matricula, $turno, $horario)
	{
		$sql = "INSERT INTO institucion (id, nombre, telefono, correo, dependencia, cod_dea, cod_estadistico, cod_dependencia, cod_electoral, idestado, idmunicipio, idparroquia, direccion, fecha_fundada, fecha_bolivariana, clase_plantel, categoria, condicion_estudio, tipo_matricula, turno, horario) VALUES(NULL, '$nombre', '$telefono', '$correo', '$dependencia', '$cod_dea', '$cod_estadistico', '$cod_dependencia', '$cod_electoral', '$idestado', '$idmunicipio', '$idparroquia', '$direccion', '$fecha_fundada', '$fecha_bolivariana', '$clase_plantel', '$categoria', '$condicion_estudio', '$tipo_matricula', '$turno', '$horario')";

		return ejecutarConsulta($sql);
	}

	#Método para editar registros
	function editar($idinstitucion, $nombre, $telefono, $correo, $dependencia, $cod_dea, $cod_estadistico, $cod_dependencia, $cod_electoral, $idestado, $idmunicipio, $idparroquia, $direccion, $fecha_fundada, $fecha_bolivariana, $clase_plantel, $categoria, $condicion_estudio, $tipo_matricula, $turno, $horario)
	{
		$sql = "UPDATE institucion SET nombre = '$nombre', telefono = '$telefono', correo = '$correo', dependencia = '$dependencia', cod_dea = '$cod_dea', cod_estadistico = '$cod_estadistico', cod_dependencia = '$cod_dependencia', cod_electoral = '$cod_electoral', idestado = '$idestado', idmunicipio = '$idmunicipio', idparroquia = '$idparroquia', direccion = '$direccion', fecha_fundada = '$fecha_fundada', fecha_bolivariana = '$fecha_bolivariana', clase_plantel = '$clase_plantel', categoria = '$categoria', condicion_estudio = '$condicion_estudio', tipo_matricula = '$tipo_matricula', turno = '$turno', horario = '$horario' WHERE id = '$idinstitucion'";

		return ejecutarConsulta($sql);

	}

	#Método para mostrar los datos de la institución
	public function mostrardatosinstitucion()
	{
		$sql = "SELECT i.id, i.nombre, i.direccion, i.idmunicipio, i.idparroquia, i.idestado, i.telefono, i.correo, i.dependencia, i.cod_dea, i.cod_estadistico, i.cod_dependencia, i.cod_electoral, i.fecha_fundada, i.fecha_bolivariana, i.clase_plantel, i.categoria, i.condicion_estudio, i.tipo_matricula, i.turno, i.horario, e.estado, m.municipio, p.parroquia, COUNT(esp.cargo) as especialistas, COUNT(doc.cargo) as docentes, COUNT(obr.cargo) as obreros, COUNT(adm.cargo) as administrativos, COUNT(vig.cargo) as vigilantes, COUNT(var.id) as varones, COUNT(hem.id) as hembras, COUNT(estu.id) as estudiantes FROM institucion i INNER JOIN estado e ON i.idestado = e.id INNER JOIN municipio m ON i.idmunicipio = m.id INNER JOIN parroquia p ON i.idparroquia = p.id LEFT JOIN personal esp ON esp.cargo LIKE '%Especialista%' LEFT JOIN personal doc ON doc.cargo LIKE '%Docente%' LEFT JOIN personal obr ON obr.cargo LIKE '%Obrero%' LEFT JOIN personal adm ON adm.cargo LIKE '%Administrativo%' LEFT JOIN personal vig ON vig.cargo LIKE '%Vigilante%' INNER JOIN persona per INNER JOIN estudiante var ON var.idpersona = per.id AND per.genero LIKE '%M%' INNER JOIN estudiante estu LEFT JOIN estudiante hem ON hem.idpersona = per.id AND per.genero LIKE '%F%' ORDER BY i.id DESC LIMIT 1";

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

}