<?php
include_once("ex_cabecera_carta.php");
$pdf=new PDF('P','mm','A4'/*array(150,85)*/);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Ln(10);


$pdf->SetFont('Arial','B',10);
$pdf->setX(55);
$pdf->Cell(100,5,utf8_decode('ESCUELA BOLIVARIANA "MIGUEL OTERO SILVA"'),0,1,'C');
$pdf->SetFont('Arial','',8);
#Cuadro de codigos
$pdf->setX(55);
$pdf->Cell(60,5,utf8_decode("Código DEA"),1,0,'L');
$pdf->Cell(40,5,utf8_decode("Código".$codigo_DEA),1,1,'C');
$pdf->setX(55);
$pdf->Cell(60,5,utf8_decode("Código de Dependencia"),1,0,'L');
$pdf->Cell(40,5,utf8_decode("Código".$dependencia),1,1,'C');
$pdf->setX(55);
$pdf->Cell(60,5,utf8_decode("Código SMEE"),1,0,'L');
$pdf->Cell(40,5,utf8_decode("Código".$codigo_SMEE),1,1,'C');

#Datos de identificacion del estudiante
$pdf->SetFont('Arial','B',10);
$pdf->setX(55);
$pdf->Cell(100,5,utf8_decode('DATOS DE IDENTIFICIÓN DEL ESTUDIANTE'),0,1,'C');
$pdf->Ln(5);

$pdf->SetFont('Arial','',10);
$pdf->setX(30);
$pdf->Cell(190,5,utf8_decode("Nombres y apellidos: CARLOS YHOANN DIAMON ORTEGA"),0,1,'L');
$pdf->setX(30);
$pdf->Cell(95,5,utf8_decode("Fecha de Nacimiento: 14/11/1999"),1,0,'L');
$pdf->Cell(95,5,utf8_decode("Cedula de Identidad: 26992848"),0,1,'L');
$pdf->setX(30);
$pdf->Cell(95,5,utf8_decode("Lugar de Nacimiento: Acarigua"),0,0,'L');
$pdf->Cell(95,5,utf8_decode("Estado: Portuguesa"),0,1,'L');
$pdf->setX(30);
$pdf->Cell(20,5,utf8_decode("Grado: 6"),0,0,'L');
$pdf->Cell(20,5,utf8_decode("Sección: A"),0,0,'L');
$pdf->Cell(20,5,utf8_decode("Año Escolar: 2020-2021"),0,1,'L');
$pdf->Ln(10);


$pdf->SetFont('Arial','B',10);
$pdf->setX(55);
$pdf->Cell(100,5,utf8_decode('INFORME DESCRIPTIVO FINAL'),0,1,'C');
$pdf->Ln(10);

$estudiante = "Ramón";
$texto_descriptivo = utf8_decode($estudiante.", es una niña alegre, solidaria, de buenas costumbres, respetuosa con sus compañeros y responsable en sus actividades escolares, comparte con sus compañeros en el aula de clases y fuera de ella. Redacta cuentos sencillos con coerencia y secuencia lógica.
	Cuenta sus experiencias en forma verbal y escrita. Aplica los conocimientos adquiridos durante la elaboraciíon de los proyectos de aprendizajes. Elabora trabajos escritos respetando las normas establecidas. Analiza textos sencillos para determinar las oraciones que lo integran, así como, sus elementos y las relaciones de forma y sentidos entre ellas como (el articulo, sustantivos, adjetivos, clasificación de palabras según se acento, agudas, graves y esdrújulas). Realiza exposiciones orales con poco dominio del contenido. Realiza libros acerca de los fabulas, leyendas y cuentos de la comunidad. Separa en silabas. Sigue instrucciones a participar en diversas actividades, escucha con atención y entusiasmos las lecturas. Al comunicar y realizar las operaciones matemáticas como la adición, sustracción, multiplicación y división obtiene buenos resultados. Reconoce la importancia de las plantas frutales en el hogar, escuela y comunidad. Es responsable en el cumplimiento de las actividades asignadas dentro y fuera del aula.");


$pdf->SetFont('Arial','',10);
$pdf->setX(30);
$pdf->MultiCell(150,4,$texto_descriptivo,0,'J');
$pdf->Ln(2);
$pdf->setX(55);
$pdf->Cell(100,5,utf8_decode("Excelente el trabajo, felicitaciones!"),0,1,'C');
$pdf->Ln(25);


$pdf->SetFont('Arial','',10);
$pdf->setX(30);
$pdf->Cell(73,5,utf8_decode("EXPRESIÓN LITERAL:       B"),0,0,'L');
$pdf->Cell(100,5,utf8_decode("INTERPRETACIÓN: El alumno alcanzo todas"),0,1,'L');
$pdf->setX(30);
$pdf->Cell(100,5,utf8_decode("las competencias previstas para el grado."),0,1,'L');
$pdf->Ln(30);


$pdf->setX(30);
$pdf->SetFont('Arial','',10);
$pdf->Cell(25,5,'Directivo',0,0,'L');
$pdf->Cell(100,5,'Acarigua, _____ de _______ de ______',0,0,'C');
$pdf->Cell(25,5,'Docente',0,0,'C');
$pdf->Ln(10);

$pdf->SetFont('Arial','B',10);
$pdf->setX(55);
$pdf->Cell(100,5,utf8_decode('28 DE MARZO DE 2019 BICENTENARIO DEL CONGRESO DE AGOSTURA '),0,1,'C');

$pdf->Output();
?>