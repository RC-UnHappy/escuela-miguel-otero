<?php

#Se incluye la conexión a la base de datos
require_once '../config/conexion.php';

/**
 * Modelo de Profesion
 */
class Profesion
{

    #Constructor de la clase
    public function __construct()
    {
    }

    #Método para insertar registros
    function insertar($idaspecto_fisiologico, $diversidad)
    {
        $sw = TRUE;

        if ($diversidad != '') {
            for ($i = 0; $i < count($diversidad); $i++) {
                $sql = "INSERT INTO diversidad_funcionals (id, idaspecto_fisiologico, diversidad) VALUES(NULL, '$idaspecto_fisiologico' ,'$diversidad[$i]')";

                ejecutarConsulta($sql) or $sw = FALSE;
            }
        }

        return $sw;
    }

    #Método para eliminar registros
    function eliminar($idaspecto_fisiologico)
    {
        $sql = "DELETE FROM diversidad_funcionals WHERE idaspecto_fisiologico = '$idaspecto_fisiologico'";

        return ejecutarConsulta($sql);
    }

    #Método para insertar registros
    function insertar_crud($profesion, $estatus)
    {
        $sql = "INSERT INTO profesion (profesion, estatus) VALUES('$profesion', '$estatus')";

        return ejecutarConsulta($sql);
    }

    function editar($idprofesion, $profesion, $estatus)
    {
        $sql = "UPDATE profesion SET profesion='$profesion', estatus = '$estatus' WHERE id = '$idprofesion'";

        return ejecutarConsulta($sql);
    }

    function listar()
    {
        $sql = "SELECT * FROM profesion";

        return ejecutarConsulta($sql);
    }

    function mostrar($idprofesion)
    {
        $sql = "SELECT * FROM profesion WHERE id = '$idprofesion'";

        return ejecutarConsultaSimpleFila($sql);
    }

    function desactivar($idprofesion)
    {
        $sql = "UPDATE profesion SET estatus = '0' WHERE id = '$idprofesion'";

        return ejecutarConsulta($sql);
    }

    function activar($idprofesion)
    {
        $sql = "UPDATE profesion SET estatus = '1' WHERE id = '$idprofesion'";

        return ejecutarConsulta($sql);
    }

    function buscar($profesion) {
        $sql = "SELECT * FROM profesion WHERE profesion = '$profesion'";
        return ejecutarConsulta($sql); 
    }
}
