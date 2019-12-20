<?php 

#Se incluye la conexión a la base de datos
require_once '../config/conexion.php';

#Se incluye la clase Persona
require_once 'Persona.php';

/**
 * Modelo de Estudiante
 */
class Estudiante
{
	
	#Constructor de la clase
	public function __construct()
	{
		
	}

	#Método para insertar registros
	function insertar($idpersona, $idmadre, $idpadre, $parto_multiple, $orden_nacimiento, $estatus)
	{
		$sql = "INSERT INTO estudiante (id, idpersona, idmadre, idpadre, parto_multiple, orden_nacimiento, estatus) VALUES(NULL, '$idpersona', '$idmadre', '$idpadre', '$parto_multiple', '$orden_nacimiento', '$estatus')";

		return ejecutarConsulta_retornarID($sql);

	}

	#Método para editar registros
	function editar($id, $instruccion, $oficio)
	{
		$sql = "UPDATE representante SET instruccion='$instruccion', oficio = '$oficio' WHERE id = '$id'";

		return ejecutarConsulta($sql);

	}

	#Método para listar todos los estudiantes
	function listar()
	{
		$sql = "SELECT p.id as idP, e.id as idE, p.cedula as cedulaE, p.p_nombre as nombreE, p.p_apellido as apellidoE, p.f_nac as fechaE, e.idmadre, e.idpadre, e.estatus, pm.cedula as cedulaM, pp.cedula as cedulaP FROM estudiante as e INNER JOIN persona as p ON p.id = e.idpersona INNER JOIN persona as pm ON pm.id = e.idmadre INNER JOIN persona as pp ON pp.id = e.idpadre";

		return ejecutarConsulta($sql);
	}

	#Método para mostrar un estudiante
	function mostrar($idestudiante)
	{
		$sql = "SELECT pe.cedula, pe.p_nombre, pe.s_nombre, pe.p_apellido, pe.s_apellido, pe.genero, pe.f_nac, e.idmadre, e.idpadre, e.parto_multiple, e.orden_nacimiento, e.estatus, d.idparroquia, d.direccion, p.idmunicipio, p.parroquia, m.idestado, m.municipio, esta.estado, pm.cedula as cedulaM, pp.cedula as cedulaP, af.todas_vacunas, af.peso, af.talla, af.alergico FROM persona pe INNER JOIN estudiante e ON pe.id = e.idpersona INNER JOIN direccion d ON d.idpersona = pe.id INNER JOIN parroquia p ON d.idparroquia = p.id INNER JOIN municipio m ON m.id = p.idmunicipio INNER JOIN estado esta ON esta.id = m.idestado INNER JOIN persona pm ON pm.id = e.idmadre INNER JOIN persona pp ON pp.id = e.idpadre INNER JOIN aspecto_fisiologico af ON af.idestudiante = e.id WHERE e.id = '$idestudiante'";

		// SELECT pe.cedula, pe.p_nombre, pe.s_nombre, pe.p_apellido, pe.s_apellido, pe.genero, pe.f_nac, e.idmadre, e.idpadre, e.parto_multiple, e.orden_nacimiento, e.estatus, d.idparroquia, d.direccion, p.idmunicipio, p.parroquia, m.idestado, m.municipio, esta.estado, pm.cedula as cedulaM, pp.cedula as cedulaP, GROUP_CONCAT(en.enfermedad) FROM persona pe INNER JOIN estudiante e ON pe.id = e.idpersona INNER JOIN direccion d ON d.idpersona = pe.id INNER JOIN parroquia p ON d.idparroquia = p.id INNER JOIN municipio m ON m.id = p.idmunicipio INNER JOIN estado esta ON esta.id = m.idestado INNER JOIN persona pm ON pm.id = e.idmadre INNER JOIN persona pp ON pp.id = e.idpadre INNER JOIN enfermedad en ON en.idestudiante = e.id

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


    #Método para listar los estados
    function listarestados()
    {
    	$sql = "SELECT * FROM estado";

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
	function comprobarpadres($cedula, $genero)
	{
		$sql = "SELECT id, cedula, p_nombre, p_apellido FROM persona WHERE cedula = '$cedula' AND genero = '$genero'";	
		return ejecutarConsulta($sql);
	}
}


