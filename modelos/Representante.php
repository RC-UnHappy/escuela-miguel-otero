<?php 

#Se incluye la conexión a la base de datos
require_once '../config/conexion.php';

#Se incluye la clase Persona
require_once 'Persona.php';

/**
 * Modelo de Representante
 */
class Representante
{
	
	#Constructor de la clase
	public function __construct()
	{
		
	}

	#Método para insertar registros
	function insertar($idpersona, $instruccion, $oficio)
	{
		$sql = "INSERT INTO representante (id, idpersona, instruccion, oficio, estatus) VALUES(NULL, '$idpersona', '$instruccion', '$oficio', '1')";

		return ejecutarConsulta($sql);

	}

	#Método para editar registros
	function editar($id, $instruccion, $oficio)
	{
		$sql = "UPDATE representante SET instruccion='$instruccion', oficio = '$oficio' WHERE id = '$id'";

		return ejecutarConsulta($sql);

	}

	#Método para listar todos los representantes
	function listar()
	{
		$sql = "SELECT p.cedula, p.p_nombre, p.p_apellido, p.email, r.oficio, r.estatus, r.id, (SELECT telefono FROM telefono WHERE tipo = 'M' AND p.id = idpersona) as movil, (SELECT telefono FROM telefono WHERE tipo = 'F' AND p.id = idpersona) as fijo, d.direccion FROM persona as p INNER JOIN representante as r ON p.id = r.idpersona INNER JOIN direccion d ON d.idpersona = p.id";

		return ejecutarConsulta($sql);
	}

	#Método para mostrar un representante
	function mostrar($idrepresentante)
	{
		$sql = "SELECT p.id as idpersona, r.id as idrepresentante, p.cedula, p.p_nombre, p.s_nombre, p.p_apellido, p.s_apellido, p.genero, p.f_nac, p.email,   r.instruccion, r.oficio , dr.idparroquia as idparroquiaresidencia, dr.direccion as direccionresidencia, dt.idparroquia as idparroquiatrabajo, dt.direccion as direcciontrabajo, (SELECT telefono FROM telefono WHERE tipo = 'M' AND idpersona = p.id) as movil, (SELECT telefono FROM telefono WHERE tipo = 'F' AND idpersona = p.id) as fijo, (SELECT idmunicipio FROM parroquia WHERE id = dr.idparroquia ) as idmunicipioresidencia, (SELECT idestado FROM municipio WHERE id = idmunicipioresidencia) as idestadoresidencia, (SELECT municipio FROM municipio WHERE id = idmunicipioresidencia) as municipioresidencia, (SELECT parroquia FROM parroquia WHERE id = dr.idparroquia) as parroquiaresidencia, (SELECT estado FROM estado WHERE id = idestadoresidencia) as estadoresidencia, (SELECT idmunicipio FROM parroquia WHERE id = dt.idparroquia ) as idmunicipiotrabajo, (SELECT idestado FROM municipio WHERE id = idmunicipiotrabajo) as idestadotrabajo, (SELECT municipio FROM municipio WHERE id = idmunicipiotrabajo) as municipiotrabajo, (SELECT parroquia FROM parroquia WHERE id = dt.idparroquia) as parroquiatrabajo, (SELECT estado FROM estado WHERE id = idestadotrabajo) as estadotrabajo FROM representante r INNER JOIN persona p ON p.id = r.idpersona LEFT JOIN direccion dr ON dr.idpersona = p.id LEFT JOIN direccion_trabajo dt ON dt.idpersona = p.id WHERE r.id = '$idrepresentante'";

		return ejecutarConsulta($sql);
	}

	#Método para obtener el id de la persona
	function idpersona($idrepresentante)
	{
		$sql = "SELECT idpersona FROM representante WHERE id = '$idrepresentante'";

		return ejecutarConsultaSimpleFila($sql);
	}

	#Método para desactivar representantes
	function desactivar($idrepresentante)
	{
		$sql = "UPDATE representante SET estatus = '0' WHERE id = '$idrepresentante'";

		return ejecutarConsulta($sql);

	}

	#Método para desactivar representantes
	function activar($idrepresentante)
	{
		$sql = "UPDATE representante SET estatus = '1' WHERE id = '$idrepresentante'";

		return ejecutarConsulta($sql);

	}

	#Método para listar los paises
	function listarpaises()
	{
		$sql = "SELECT * FROM pais";

		return ejecutarConsulta($sql);
	}

    #Método para listar los estados
    function listarestados($idpais)
    {
		if ($idpais !== NULL)
			$sql = "SELECT * FROM estado WHERE idpais = '$idpais'";
		else
			$sql = "SELECT * FROM estado WHERE idpais = '232'";

		return ejecutarConsulta($sql);
    }

    #Método para listar los municipios
    function listarmunicipios($idestado)
    {
    	$sql = "SELECT * FROM municipio WHERE idestado = '$idestado'";

		return ejecutarConsulta($sql);
    }

    #Método para listar las parroquias
    function listarparroquias($idmunicipio)
    {
    	$sql = "SELECT * FROM parroquia WHERE idmunicipio = '$idmunicipio'";

		return ejecutarConsulta($sql);
    }

    #Método para comprobar si existe el representante
	function comprobarrepresentante($cedula)
	{
		$sql = "SELECT p.p_nombre, p.p_apellido FROM persona p INNER JOIN representante r ON r.idpersona = p.id WHERE p.cedula = '$cedula'";
		return ejecutarConsulta($sql);
	}

	#Método para comprobar si existe la persona
	function comprobarpersona($cedula)
	{
		$sql = "SELECT p.id, p.cedula, p.p_nombre, p.s_nombre, p.p_apellido, p.s_apellido, p.genero, p.f_nac, p.email, d.idparroquia, d.direccion , pa.idmunicipio, pa.parroquia, mu.idestado, mu.municipio, es.estado, GROUP_CONCAT(IF(t.tipo = 'M', t.telefono, null)) celular, GROUP_CONCAT(IF(t.tipo = 'F', t.telefono, null)) fijo FROM persona p  LEFT JOIN direccion d ON d.idpersona = p.id LEFT JOIN parroquia pa ON pa.id = d.idparroquia LEFT JOIN municipio mu ON pa.idmunicipio = mu.id LEFT JOIN estado es ON mu.idestado = es.id LEFT JOIN telefono t ON p.id = t.idpersona WHERE p.cedula = '$cedula'";	
		return ejecutarConsulta($sql);
	}
}


