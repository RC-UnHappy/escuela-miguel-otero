<?php

#Se incluye la conexión a la base de datos
require_once '../config/conexion.php';

/**
 * Modelo de Parentesco
 */
class Parentesco
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
    function insertar_crud($parentesco, $estatus)
    {
        $sql = "INSERT INTO parentesco (parentesco, estatus) VALUES('$parentesco', '$estatus')";

        return ejecutarConsulta($sql);
    }

    function editar($idparentesco, $parentesco, $estatus)
    {
        $sql = "UPDATE parentesco SET parentesco='$parentesco', estatus = '$estatus' WHERE id = '$idparentesco'";

        return ejecutarConsulta($sql);
    }

    function listar()
    {
        $sql = "SELECT * FROM parentesco";

        return ejecutarConsulta($sql);
    }

    function mostrar($idparentesco)
    {
        $sql = "SELECT * FROM parentesco WHERE id = '$idparentesco'";

        return ejecutarConsultaSimpleFila($sql);
    }

    function desactivar($idparentesco)
    {
        $sql = "UPDATE parentesco SET estatus = '0' WHERE id = '$idparentesco'";

        return ejecutarConsulta($sql);
    }

    function activar($idparentesco)
    {
        $sql = "UPDATE parentesco SET estatus = '1' WHERE id = '$idparentesco'";

        return ejecutarConsulta($sql);
    }
}
