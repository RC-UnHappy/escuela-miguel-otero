<?php
	include_once("../clases/clscliente.php");
    $cedula = $_POST['cedula'];
    $objc   = new cliente($cedula);
	if($_POST['cedula']!='')
        $Reg_Per = $objc->buscar();
    else
        $Reg_Per = $objc->repTodos();
?>
