<?php
require('../fpdf/fpdf.php');
class PDF extends FPDF
	{
		//Cabecera de página
		function Header()
		{
        //Logo
            $this->Image('../img/logo_MES.jpg',10,5,20);
            $this->Ln(4);
   		//Arial bold Italica 12
    		$this->SetFont('Arial','BI',12);
            $this->Ln(2);
    		//Título
    		$this->Cell(0,6,'Datos Personales',0,1,'C');
			$this->Ln(2);
		//Fecha
			$FechaActual=date("d/m/Y");
			$this->SetFont('Arial','I',8);
			$this->Cell(0,6,$FechaActual,'B',1,"R");
		}
		//Pie de página
		function Footer()
		{
		//Posición: a 1.5 cm del final
			$this->SetY(-15);
		//Arial italic 8
			$this->SetFont('Arial','I',6);
			$this->Cell(160,4,'Generado por: JWValera','T',0,' ');
		//Número de página
			$this->Cell(40,4,'Página '.$this->PageNo().'/{nb}','T',1,'R');
		}

		# NUEVOS METODOS MULTICELL ########################

		function SetCol($col)
		{
		    //Establecer la posición de una columna dada
		    $this->col=$col;
		    $x=10+$col*65;
		    $this->SetLeftMargin($x);
		    $this->SetX($x);
		}
	}
?>
