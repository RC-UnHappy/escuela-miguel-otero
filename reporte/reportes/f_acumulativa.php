<?php
include_once("ex_cabecera_carta.php");
$pdf=new PDF('P','mm','A4'/*array(150,85)*/);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Ln(10);
$pdf->SetFont('Arial','B',12);

$pdf->Cell(50,6,'',0,0,'C');
$pdf->Cell(100,6,utf8_decode('Ficha acumulativa'),0,1,'C');
$pdf->Ln(15);

$pdf->Cell(80,6,'Datos del estudiante:',0,1,'C');
$pdf->Ln(5);

#Datos de los estudiantes///////////////////////////////////////////////////////////////////////////

$datos_estudiante = utf8_decode("Nombres:________________________ Apellidos:________________________
Sexo: ____ Edad:____ Fecha de nacimiento:_______ Lugar de nacimiento:___________ Plantel de procedencia:___________________________________________________");

$pdf->SetFont('Arial','',10);
$pdf->setX(28); 
$pdf->Multicell(150,6,$datos_estudiante,0,'J');
$pdf->ln(5);

$pdf->SetFont('Arial','B',12);
$pdf->Cell(80,6,'Datos de los padres:',0,2,'C');

$pdf->setX(28);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(75,5,'Madre',1,0,'C');
$pdf->Cell(75,5,'Padre',1,1,'C');

#Datos de los Padres////////////////////////////////////////////////////////////////////////////////
$pdf->SetFont('Arial','',10);
$pdf->setX(28);
$pdf->Cell(75,5,'C.I: '.$cedula_madre,1,0,'L');

$pdf->setX(103);
$pdf->Cell(75,5,'C.I: '.$cedula_padre,1,1,'L');

$pdf->setX(28);
$pdf->Cell(75,5,utf8_decode('Profesión: '.$profesion_madre),1,0,'L'); #Madre

$pdf->setX(103);
$pdf->Cell(75,5,utf8_decode('Profesión: '.$profesion_padre),1,1,'L'); #Padre

$pdf->setX(28);
$pdf->Cell(75,5,utf8_decode('Dirección de trabajo: '),1,0,'L'); #Madre

$pdf->setX(103);
$pdf->Cell(75,5,utf8_decode('Dirección de trabajo: '),1,1,'L'); #Padre

$pdf->setX(28);
$pdf->Cell(75,5,utf8_decode(''.$d_trabajo_madre),1,0,'L'); #Madre

$pdf->setX(103);
$pdf->Cell(75,5,utf8_decode(''.$d_trabajo_padre),1,1,'L'); #Padre

$pdf->setX(28);
$pdf->Cell(75,5,utf8_decode('Dirección de habitación: '),1,0,'L'); #Madre

$pdf->setX(103);
$pdf->Cell(75,5,utf8_decode('Dirección de habitación'.$d_habitacion_padre),1,1,'L'); #Padre

$pdf->setX(28);
$pdf->Cell(75,5,utf8_decode(''.$d_habitacion_madre),1,0,'L'); #Madre

$pdf->setX(103);
$pdf->Cell(75,5,utf8_decode(''.$d_habitacion_padre),1,1,'L'); #Padre

$pdf->setX(28);
$pdf->Cell(75,5,utf8_decode('Telefono: '.$telefono_madre),1,0,'L'); #Madre

$pdf->setX(103);
$pdf->Cell(75,5,utf8_decode('Telefono: '.$telefono_padre),1,1,'L'); #Padre
$pdf->Ln(5);

#Documentos consignados////////////////////////////////////////////////////////////////////////////////
$pdf->SetFont('Arial','B',12);
$pdf->Cell(90,6,'Documentos consignados:',0,2,'C');


$pdf->setX(28);
$pdf->SetFont('Arial','',10);

$pdf->Cell(10,10,'',1,0,'C');
$pdf->Cell(65,10,utf8_decode('Fotocopia de la cédula de identidad de padres y representantes'),1,0,'L');
$pdf->Cell(10,10,'',1,0,'C');
$pdf->Cell(65,10,utf8_decode('Fotocopia cédula de identidad del estudiante'),1,1,'L');

$pdf->setX(28);
$pdf->Cell(10,5,'',1,0,'C');
$pdf->Cell(65,5,utf8_decode('Fotocopia partida de nacimiento'),1,0,'L');
$pdf->Cell(10,5,'',1,0,'C');
$pdf->Cell(65,5,utf8_decode('Boleta de promoción'),1,1,'L');

$pdf->setX(28);
$pdf->Cell(10,5,'',1,0,'C');
$pdf->Cell(65,5,utf8_decode('Fotos del (la) estudiante'),1,0,'L');
$pdf->Cell(10,5,'',1,0,'C');
$pdf->Cell(65,5,utf8_decode('Constancia de buena conducta'),1,1,'L');

$pdf->setX(28);
$pdf->Cell(10,5,'',1,0,'C');
$pdf->Cell(65,5,utf8_decode('Fotos del representante'),1,0,'L');
$pdf->Cell(10,5,'',1,0,'C');
$pdf->Cell(65,5,utf8_decode('Informe descriptivo final'),1,1,'L');

$pdf->setX(28);
$pdf->Cell(10,5,'',1,0,'C');
$pdf->Cell(65,5,utf8_decode('Fotocopia constancia de vacunas'),1,0,'L');
$pdf->Cell(10,5,'',1,0,'C');
$pdf->Cell(65,5,utf8_decode(''),1,1,'L');
$pdf->Ln(5);


#Inscripcion///////////////////////////////////////////////////////////////////////////////////////////////
$pdf->setX(28);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(100,6,utf8_decode('Inscripción:'),0,2,'L');

$inscripcion = utf8_decode("1.- Fecha: ___________    Grado: ______    Sección: ____  Año Escolar: ____________ 
	Apellidos y nombres del representante: __________________________________________________________ C.I. ____________ Parentesco_______________ Dirección de habitación___________________
______________________________________ Teléfono: _______________________Dirección de trabajo: ___________________________________________ Teléfono: __________ Repite: SI______NO______
Juicio del Docente Guía / Observaciones: __________________________________________________________
Firma del representante: _____________________________
Firma del responsable de inscripción: _________________ Firma del Docente de Grado: _____________
");

$pdf->SetFont('Arial','',10);
$pdf->setX(28); 
$pdf->Multicell(150,6,$inscripcion,0,'J');
$pdf->ln(10);

$pdf->setX(28);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(100,6,utf8_decode('Para el caso de retiro del estudiante: '),0,1,'L');
$pdf->Ln(10);

$retiro = utf8_decode("Causa: _____________________________________________________________________________________
Plantel a ser inscrito:_____________________________________ Lugar:__________________________
Firma del representante:______________________ C.I. ____________________
Firma del responsable del retiro:_____________________________________C.I.___________________
Fecha: ____________________ Observaciones:______________________________________________________");

$pdf->SetFont('Arial','',10);
$pdf->setX(28); 
$pdf->Multicell(150,6,$retiro,0,'J');
$pdf->ln(5);









$pdf->Output();
?>