<?php
// Esta clase permite la interaccion del software con la base de datos
class clsbd // Nombre de la clase
{
    private $conectar; // atributo de la clase que contiene la conexion
    function __construct() //contructor de la clase
    {
        $Servidor="localhost"; // variables que indica el nombre del servidor
        $Usuario="root"; // variable que indica usuario del servidor
        $Clave=""; // variable que indica clave del servidor
        $bd="nomina"; // variable que indica la base de datos del software
        //Conexion a la base de datos
        $this->conectar=mysqli_connect($Servidor,$Usuario,$Clave,$bd) ;
        mysqli_set_charset($this->conectar,"utf8");
; // permite la introducir caracteres especiales (ñ, ')
    }
    function __destruct() //destructor de la clase
    {
    }
    function filtro($Sql) //permite extraer datos de la base de datos
    {
        $result = mysqli_query($this->conectar,$Sql);
        return $result;
    }
    function proximo($prTb) //guarda los datos extraidos en un arreglo
    {
        $laRow = mysqli_fetch_array($prTb);
        return $laRow;
    }
    function num_registros($prTb) //muestra el numero de registros afectados en una busqueda
    {
        $lnRegistros = mysqli_num_rows($prTb);
        return $lnRegistros;
    }
    function cerrarfiltro($result)//limpia el bufer de la memoria
    {
        mysqli_free_result($result);
    }
    function ejecutar($Sql) //permite hacer colsultas a la base datos (incluir, modificar y eliminar)
    {
        mysqli_query($this->conectar,$Sql);
    }
    function desconectar() // cierra la conexion
    {
        mysqli_close($this->conectar);
    }
}
?>