<?php
include_once("ex_r_estadistico.php");
$pdf=new PDF('P','mm','A3');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Ln(10);
$pdf->SetFont('Arial','B',10);

$pdf->setX(95);
$pdf->Cell(100,5,utf8_decode('RESUMEN ESTADISTICO MENSUAL'),0,1,'C');
$pdf->Ln(2);

#DATOS AL COMENZAR LA HOJA///////////////////////////////////////////
$pdf->setX(30);
$pdf->Cell(80,5,utf8_decode("Localidad: Acarigua"),0,0,'L');
$pdf->Cell(80,5,utf8_decode("Distrito Escolar N°2"),0,0,'C');
$pdf->Cell(80,5,utf8_decode("Zona Escolar N°11"),0,1,'C');
$pdf->Ln(2);
$pdf->setX(30);
$pdf->Cell(60,5,utf8_decode("Mes: Noviembre"),0,0,'L');
$pdf->Cell(60,5,utf8_decode("Año Escolar 2020-2021"),0,0,'L');
$pdf->Cell(55,5,utf8_decode("Dias Hábiles: ___"),0,0,'L');
$pdf->Cell(45,5,utf8_decode("Dias Trabajados: ___"),0,1,'C');
$pdf->Ln(2);
$pdf->setX(30);
$pdf->Cell(60,5,utf8_decode("Docente: Carlos Diamon"),0,0,'L');
$pdf->Cell(30,5,utf8_decode("Grado: 5"),0,0,'L');
$pdf->Cell(30,5,utf8_decode("Sección: A"),0,1,'L');
$pdf->Ln(15);


#COLUMNAS DEL CUADRO DE LOS DIAS DEL MES///////////////////////
$pdf->setX(30);
$pdf->Cell(15,5,utf8_decode("Dia"),1,0,'C');
$pdf->Cell(20,5,utf8_decode("Fecha"),1,0,'C');
$pdf->Cell(10,5,utf8_decode("V"),1,0,'C');
$pdf->Cell(10,5,utf8_decode("H"),1,0,'C');
$pdf->Cell(15,5,utf8_decode("Total"),1,1,'C');



$total = 0;
$fecha = ["30/03/2020","01/02/1999","14/11/1999"];
$varones = [5,6,7];
$hembras = [1,2,3];

$rs = 31;
for ($i=1; $i<=$rs; $i++){
$pdf->setX(30);
$pdf->Cell(15,5,utf8_decode($i),1,0,'C');
$pdf->Cell(20,5,utf8_decode($fecha[$i-1]),1,0,'C');
$pdf->Cell(10,5,utf8_decode($varones[$i-1]),1,0,'C');
$pdf->Cell(10,5,utf8_decode($hembras[$i-1]),1,0,'C');
$pdf->Cell(15,5,utf8_decode(""),1,1,'C');
}

#ULTIMA FILA DEL CUADRO DE LOS DIAS DEL MES/////////////
$pdf->setX(45);
$pdf->Cell(20,5,utf8_decode("Total"),1,0,'C');
$pdf->Cell(10,5,utf8_decode(""),1,0,'C');
$pdf->Cell(10,5,utf8_decode(""),1,0,'C');
$pdf->Cell(15,5,utf8_decode(""),1,1,'C');
#PROMEDIO Y PORCENTAJE/////////////////////////////////
$pdf->setY(250);
$pdf->setX(45);
$pdf->Cell(20,5,utf8_decode(""),1,0,'C');
$pdf->Cell(10,5,utf8_decode("V"),1,0,'C');
$pdf->Cell(10,5,utf8_decode("H"),1,0,'C');
$pdf->Cell(15,5,utf8_decode("Total"),1,1,'C');

$pdf->setX(45);
$pdf->Cell(20,5,utf8_decode("Promedio"),1,0,'C');
$pdf->Cell(10,5,utf8_decode(""),1,0,'C'); #VARONES
$pdf->Cell(10,5,utf8_decode(""),1,0,'C'); #HEMBRAS
$pdf->Cell(15,5,utf8_decode(""),1,1,'C'); #TOTAL

$pdf->setX(45);
$pdf->Cell(20,5,utf8_decode("Porcentaje"),1,0,'C');
$pdf->Cell(10,5,utf8_decode(""),1,0,'C'); #VARONES
$pdf->Cell(10,5,utf8_decode(""),1,0,'C'); #HEMBRAS
$pdf->Cell(15,5,utf8_decode(""),1,0,'C'); #TOTAL




#COLUMNAS DEL CUADRO "MATRICULA"//////////////////////////////
$pdf->setY(70);
$pdf->setX(160);
$pdf->Cell(40,5,utf8_decode("Matricula"),1,0,'C');
$pdf->Cell(10,5,utf8_decode("V"),1,0,'C');
$pdf->Cell(10,5,utf8_decode("H"),1,0,'C');
$pdf->Cell(10,5,utf8_decode("T"),1,1,'C');

#FILAS DEL CUADRO "MATRICULA"
$pdf->setY(75);
$pdf->setX(160);
$pdf->Cell(40,5,utf8_decode("Inscripción inicial"),1,0,'C');
$pdf->Cell(10,5,utf8_decode(""),1,0,'C');
$pdf->Cell(10,5,utf8_decode(""),1,0,'C');
$pdf->Cell(10,5,utf8_decode(""),1,1,'C');
$pdf->setX(160);
$pdf->Cell(40,5,utf8_decode("Matricula del mes"),1,0,'C');
$pdf->Cell(10,5,utf8_decode(""),1,0,'C');
$pdf->Cell(10,5,utf8_decode(""),1,0,'C');
$pdf->Cell(10,5,utf8_decode(""),1,1,'C');
$pdf->setX(160);
$pdf->Cell(40,5,utf8_decode("Ingresos"),1,0,'C');
$pdf->Cell(10,5,utf8_decode(""),1,0,'C');
$pdf->Cell(10,5,utf8_decode(""),1,0,'C');
$pdf->Cell(10,5,utf8_decode(""),1,1,'C');
$pdf->setX(160);
$pdf->Cell(40,5,utf8_decode("Suma"),1,0,'C');
$pdf->Cell(10,5,utf8_decode(""),1,0,'C');
$pdf->Cell(10,5,utf8_decode(""),1,0,'C');
$pdf->Cell(10,5,utf8_decode(""),1,1,'C');
$pdf->setX(160);
$pdf->Cell(40,5,utf8_decode("Egresos"),1,0,'C');
$pdf->Cell(10,5,utf8_decode(""),1,0,'C');
$pdf->Cell(10,5,utf8_decode(""),1,0,'C');
$pdf->Cell(10,5,utf8_decode(""),1,1,'C');
$pdf->setX(160);
$pdf->Cell(40,5,utf8_decode("Resta"),1,0,'C');
$pdf->Cell(10,5,utf8_decode(""),1,0,'C');
$pdf->Cell(10,5,utf8_decode(""),1,0,'C');
$pdf->Cell(10,5,utf8_decode(""),1,1,'C');
$pdf->setX(160);
$pdf->Cell(40,5,utf8_decode("Matricula (ultimo mes)"),1,0,'C');
$pdf->Cell(10,5,utf8_decode(""),1,0,'C');
$pdf->Cell(10,5,utf8_decode(""),1,0,'C');
$pdf->Cell(10,5,utf8_decode(""),1,1,'C');
$pdf->Ln(5);

#CLASIFICACIÓN DE LA MATRICULA POR EDAD Y SEXO/////////////////////////
$pdf->setX(140);
$pdf->Cell(100,5,utf8_decode("Clasificación por edad y sexo"),0,0,'C');
$pdf->Ln(10);
#FILAS DEL CUADRO DE LA MATRICULA POR EDAD Y SEXO
$pdf->setX(140);
$pdf->Cell(15,5,utf8_decode("Edades"),1,0,'C');
$pdf->Cell(10,5,utf8_decode("V"),1,0,'C');
$pdf->Cell(10,5,utf8_decode("H"),1,0,'C');
$pdf->Cell(15,5,utf8_decode("Total"),1,0,'C');
$pdf->Cell(15,5,utf8_decode("Edades"),1,0,'C');
$pdf->Cell(10,5,utf8_decode("V"),1,0,'C');
$pdf->Cell(10,5,utf8_decode("H"),1,0,'C');
$pdf->Cell(15,5,utf8_decode("Total"),1,1,'C');


#CICLO PARA GENERAR FILAS DE LA MATRICUA POR SEXO Y EDAD
$r_matricula_edad_sexo = 4;
for ($i=0; $i < $r_matricula_edad_sexo; $i++) { 
	$pdf->setX(140);
	$pdf->Cell(15,5,utf8_decode(""),1,0,'C');
	$pdf->Cell(10,5,utf8_decode(""),1,0,'C');
	$pdf->Cell(10,5,utf8_decode(""),1,0,'C');
	$pdf->Cell(15,5,utf8_decode(""),1,0,'C');
	$pdf->Cell(15,5,utf8_decode(""),1,0,'C');
	$pdf->Cell(10,5,utf8_decode(""),1,0,'C');
	$pdf->Cell(10,5,utf8_decode(""),1,0,'C');
	$pdf->Cell(15,5,utf8_decode(""),1,1,'C');
	
}
#Ingresos///////////////////////////////////////////
$pdf->Ln(5);
$pdf->setX(140);
$pdf->Cell(100,5,utf8_decode("Ingresos"),0,0,'C');
$pdf->Ln(10);
#FILAS
$pdf->setX(120);
$pdf->Cell(35,5,utf8_decode("Apellido y Nombre"),1,0,'C');
$pdf->Cell(30,5,utf8_decode("L / N"),1,0,'C');
$pdf->Cell(20,5,utf8_decode("F / N"),1,0,'C');
$pdf->Cell(10,5,utf8_decode("Sexo"),1,0,'C');
$pdf->Cell(10,5,utf8_decode("Edad"),1,0,'C');
$pdf->Cell(20,5,utf8_decode("F / Ingreso"),1,0,'C');
$pdf->Cell(20,5,utf8_decode("Causa"),1,0,'C');

#CICLO PARA GENERAR FILAS DE LA MATRICULA POR INGRESOS
$r_ingresos = 5;
for ($i=0; $i < $r_ingresos ; $i++) { 
	$pdf->setX(120);
	$pdf->Cell(35,5,utf8_decode(""),1,0,'C');
	$pdf->Cell(30,5,utf8_decode(""),1,0,'C');
	$pdf->Cell(20,5,utf8_decode(""),1,0,'C');
	$pdf->Cell(10,5,utf8_decode(""),1,0,'C');
	$pdf->Cell(10,5,utf8_decode(""),1,0,'C');
	$pdf->Cell(20,5,utf8_decode(""),1,0,'C');
	$pdf->Cell(20,5,utf8_decode(""),1,1,'C');
}

#Egresos///////////////////////////////////////////////
$pdf->Ln(5);
$pdf->setX(140);
$pdf->Cell(100,5,utf8_decode("Egresos"),0,0,'C');
$pdf->Ln(10);
#FILAS
$pdf->setX(120);
$pdf->Cell(35,5,utf8_decode("Apellido y Nombre"),1,0,'C');
$pdf->Cell(30,5,utf8_decode("L / N"),1,0,'C');
$pdf->Cell(20,5,utf8_decode("F / N"),1,0,'C');
$pdf->Cell(10,5,utf8_decode("Sexo"),1,0,'C');
$pdf->Cell(10,5,utf8_decode("Edad"),1,0,'C');
$pdf->Cell(20,5,utf8_decode("F / Ingreso"),1,0,'C');
$pdf->Cell(20,5,utf8_decode("Causa"),1,0,'C');
#CICLO PARA GENERAR FILAS DE LA MATRICULA POR EGRESOS
$r_egresos = 5;
for ($i=0; $i < $r_egresos ; $i++) { 
	$pdf->setX(120);
	$pdf->Cell(35,5,utf8_decode(""),1,0,'C');
	$pdf->Cell(30,5,utf8_decode(""),1,0,'C');
	$pdf->Cell(20,5,utf8_decode(""),1,0,'C');
	$pdf->Cell(10,5,utf8_decode(""),1,0,'C');
	$pdf->Cell(10,5,utf8_decode(""),1,0,'C');
	$pdf->Cell(20,5,utf8_decode(""),1,0,'C');
	$pdf->Cell(20,5,utf8_decode(""),1,1,'C');
}

#Observacion///////////////////////////////
$pdf->Ln(5);
$pdf->setX(120);
$pdf->Cell(100,5,utf8_decode("Observación:"),0,0,'L');
$pdf->Ln(10);
#GENERACION DE LAS FILAS PARA LAS OBSERVACIONES
$observacion = 8;
for ($i=0; $i < $observacion; $i++) { 
	$pdf->setX(120);
	$pdf->Cell(145,5,utf8_decode(""),1,1,'C');
}


















$pdf->Output();
?>