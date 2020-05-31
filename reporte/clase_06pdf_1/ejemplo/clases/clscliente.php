<?php
// Esta clase permite registrar, modificar, eliminar y buscar un docente
require_once("clsbd.php"); //llamado de la clase clsbd
class cliente // declaracion de laclase
{
    private $cedula;
    //Contructor de la clase
    public function __construct($cedula)
	{
		 $this->cedula = $cedula;
    }
    //Ficha de un registro de la base de datos
    public function buscar() {
        $Sql = "select * from personal where (cedula = '$this->cedula')";
        $objDatos = new clsbd();
        $lrTb=$objDatos->filtro($Sql);

        include_once("../clases/cls_repPDF.php");
    	$pdf=new PDF('P','mm',array(150,85));
        $pdf->AliasNbPages();
    	$pdf->AddPage();
    	$pdf->Ln(4);

		while($Reg_Per=$objDatos->proximo($lrTb)){

        	$pdf->SetFont('Arial','',14);
        	$pdf->Cell(26,6,'Cedula',0,0);
        	$pdf->Cell(0,6,': '.$Reg_Per['cedula'],0,1);

        	$pdf->Cell(26,6,'Nombre',0,0);
        	$pdf->Cell(0,6,': '.$Reg_Per['nombre'],0,1);

        	$pdf->Cell(26,6,'Edad',0,0);
        	$pdf->Cell(0,6,': '.$Reg_Per['edad'],0,1);

        	$pdf->Cell(26,6,'Sexo',0,0);
        	$pdf->Cell(0,6,': '.$Reg_Per['sexo'],0,1);

        	$pdf->Cell(26,6,'Fecha Nac.',0,0);
        	$pdf->Cell(0,6,': '.$Reg_Per['fecha_n'],0,1);
        	$pdf->Ln();
		}
        
        $pdf->Output();
        $objDatos->cerrarfiltro($lrTb);
        $objDatos->desconectar();
    }
    //Lista todos de la base de datos
    public function repTodos() {
        $Sql = "select * from personal";
        $objDatos = new clsbd();
        $lrTb=$objDatos->filtro($Sql);

        include_once("../clases/cls_repPDF.php");
        $pdf=new PDF('P','mm','Letter');
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->Ln(1);

        $pdf->SetFont('Arial','',14);
        $pdf->Cell(26,8,'Cedula','B',0);
        $pdf->Cell(70,8,'Nombre','B',0);
        $pdf->Cell(20,8,'Edad','B',0);
        $pdf->Cell(30,8,'Sexo','B',0);
        $pdf->Cell(50,8,'Fecha Nac.','B',1);
        $pdf->Ln(2);
        while($Reg_Per=$objDatos->proximo($lrTb)){
            $pdf->Cell(26,7,$Reg_Per['cedula'],1,0);
            $pdf->Cell(70,7,$Reg_Per['nombre'],0,0);
            $pdf->Cell(20,7,$Reg_Per['edad'],0,0);
            $pdf->Cell(30,7,$Reg_Per['sexo'],0,0);
            $pdf->Cell(30,7,$Reg_Per['fecha_n'],0,1);
        }
        $pdf->Ln();
        $pdf->Output();
        $objDatos->cerrarfiltro($lrTb);
        $objDatos->desconectar();
    }
}
?>
