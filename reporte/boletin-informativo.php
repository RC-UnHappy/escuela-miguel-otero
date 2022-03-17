<?php
#Se activa el almacenamiento en el buffer
ob_start();
if (strlen(session_id()) < 1) 
  session_start();

if (!isset($_SESSION['idusuario'])) {
  echo "Debe ingresar al sistema correctamete para visualizar el reporte";
}
else{
if (isset($_SESSION['permisos']['boletin-parcial']) && in_array('ver' , $_SESSION['permisos']['boletin-parcial']) || isset($_SESSION['permisos']['representado'])) {

#Se incluye el modelo de BoletinParcial
require_once '../modelos/BoletinParcial.php';


$BoletinParcial = new BoletinParcial();



// Varibles que se van a recibir por get necesarias para generar el reporte
$idplanificacion = isset($_GET['idplanificacion']) ? limpiarCadena($_GET['idplanificacion']) : '';
$lapso = isset($_GET['lapso']) ? limpiarCadena($_GET['lapso']) : '';
$idestudiante = isset($_GET['idestudiante']) ? limpiarCadena($_GET['idestudiante']) : '';


// Comprueba que el idestudiante pertenezca al representante

if (isset($_SESSION['permisos']['representado'])) {
  require_once '../modelos/Estudiante.php';
  require_once '../modelos/Representante.php';
	$Representante = new Representante();
  $Estudiante = new Estudiante();

	$representante = $Representante->representanteporidpersona($_SESSION['idpersona']);
  $idestudiantes = [];
  $rspta = $Estudiante->traerinscripcionesporrepresentante($representante['id']);
  while ($reg = $rspta->fetch_object()) { 
    array_push($idestudiantes, $reg->idE);
  }
  
  if (!in_array($idestudiante, $idestudiantes)) {
    exit('No tiene permisos para este estudiante');
  }
}


$periodo_escolar = $BoletinParcial->consultarperiodo();
$periodo_escolar = !empty($periodo_escolar) ? $periodo_escolar['periodo'] : '';

$indicadores_nota = [];
// Se traen las materias junto con los indicadores y nota del estudiante
if (!empty($idplanificacion) && !empty($idestudiante) && !empty($lapso)){
  $rspta = $BoletinParcial->listar($idplanificacion, $lapso, $idestudiante);
  if ($rspta->num_rows != 0) {
    // Se agrupan los indicadores por materia
    while ($reg = $rspta->fetch_object()) {
      $indicadores_nota[$reg->materia][] = ['indicador' => $reg->indicador, 'nota' => $reg->nota];     
    }  
  }    
}
else {
  exit('Ocurrió un error');
}

// Datos principales del reporte como nombre del estudiante, profesor, seccion, grado
$datos_reporte = $BoletinParcial->datos_reporte($idplanificacion, $lapso, $idestudiante);

if (empty($datos_reporte)) {
  exit('Ocurrió un error');
}

// Función para transformar números a números romanos
function a_romano($integer, $upcase = true) {
  $table = array('M'=>1000, 'CM'=>900, 'D'=>500, 'CD'=>400, 'C'=>100, 
                  'XC'=>90, 'L'=>50, 'XL'=>40, 'X'=>10, 'IX'=>9,   
                  'V'=>5, 'IV'=>4, 'I'=>1);
  $return = '';
  while($integer > 0) 
  {
      foreach($table as $rom=>$arb) 
      {
          if($integer >= $arb)
          {
              $integer -= $arb;
              $return .= $rom;
              break;
          }
      }
  }
  return $return;
}

// Datos de la institución
$datos_institucion = $BoletinParcial->datos_institucion();

// Se establece la zona horaria
date_default_timezone_set('America/Caracas');
$fecha = date('Y-m-d');

// Se incluye el modelo para el reporte
include_once("cabecera-boletin-informativo.php");
$pdf=new PDF('P','mm','A4'/*array(150,85)*/);
    $pdf->codigo_qr = $datos_institucion['codigo_qr'];
$pdf->AliasNbPages();
$pdf->periodo_escolar = $periodo_escolar;
$pdf->nombre_institucion = $datos_institucion['nombre'];
$pdf->AddPage();
$pdf->Ln(15);

// Se establecen todos los datos de estudiante, profesor, grado etc
$pdf->SetFont('Arial','B',10);
$pdf->Cell(21,5,utf8_decode('Estudiante: '),0,0,'L');
$pdf->Cell(100,5,utf8_decode(ucfirst($datos_reporte['p_nombre_estudiante']).' '.ucfirst($datos_reporte['s_nombre_estudiante']).' '.ucfirst($datos_reporte['p_apellido_estudiante']).' '.ucfirst($datos_reporte['s_apellido_estudiante'])),'B',0,'L');
$pdf->Cell(14,5,utf8_decode('Grado: '),0,0,'L');
$pdf->Cell(15,5,utf8_decode($datos_reporte['grado'].'º'),'B',0,'L');
$pdf->Cell(17,5,utf8_decode('Sección: '),0,0,'L');
$pdf->Cell(15,5,'"'.utf8_decode($datos_reporte['seccion']).'"','B',1,'L');
$pdf->Cell(17,5,utf8_decode('Docente: '),0,0,'L');
$pdf->Cell(45,5,utf8_decode(ucfirst($datos_reporte['p_nombre']).' '.ucfirst($datos_reporte['p_apellido'])),'B',1,'L');
$pdf->Cell(60,5,utf8_decode('Título del Proyecto de Aprendizaje: '),0,0,'L');
$pdf->Cell(122,5,utf8_decode(ucfirst($datos_reporte['proyecto_aprendizaje'])),'B',1,'L');
$pdf->Cell(14,5,utf8_decode('Fecha: '),0,0,'L');
$pdf->Cell(30,5,date('d-m-Y'),'',1,'L');
$pdf->Ln(5);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(50,6,'',0,0,'C');
$pdf->Cell(100,6,utf8_decode('Boletín Informativo del '.a_romano($lapso).' Proyecto de Aprendizaje'),5,0,'C');
$pdf->Ln(8);


#Variable para definir el ancho que tendran las celdas de area
$ancho_area = 24;

// Cabeceras de la tabla de indicadores
$pdf->Cell($ancho_area,5,utf8_decode('Área'),1,0,'C');
$pdf->Cell(125,5,utf8_decode('Indicadores'),1,0,'C');
$pdf->Cell(9,5,utf8_decode('C'),1,0,'C');
$pdf->Cell(9,5,utf8_decode('AV'),1,0,'C');
$pdf->Cell(9,5,utf8_decode('EP'),1,0,'C');
$pdf->Cell(9,5,utf8_decode('I'),1,1,'C');

$pdf->SetFont('Arial','',10);

// Bucle para iterar por cada materia
foreach ($indicadores_nota as $materia => $indicadores_nota) {

  // Aquí se cuenta la cantidad de indicadores que tiene la materia, necesario para mucha lógica futura
  $numero_indicadores = 0;
  foreach ($indicadores_nota as $key => $value) {
    $numero_indicadores++;
  }

  // Se divide la cantidad de letras que tenga la variable materia y se divide entre 10, ya que esta es la cantidad máxima de carácteres que caben en una sóla línea en el multicell y se le aplica la función ceil para que redondee hacia arriba y saber la cantidad de líneas que ocupará la palabra

  $numero_filas = ceil(strlen($materia) / 10);

  $alto_multicell = ($numero_indicadores * 6) / $numero_filas;
  
  // El alto del multicel de area será el número de indicadores que tenga la materia por el alto de los cell de cada indicador dividido entre 2
  $pdf->MultiCell($ancho_area, $alto_multicell, utf8_decode($materia),1,'C');
  
  // Para que los cell de los indicadores aparezcan al lado del multicell es necesario generar unos saltos de línea negativos que serán: el número de indicadores por el alto de cada cell
  $pdf->Ln(-($numero_indicadores * 6));
  foreach ($indicadores_nota as $key => $value) {
    #Primera fila de la primera Area
    $pdf->SetX(34);
    $pdf->Cell(125,6,utf8_decode($value['indicador']),1,0,'L');
    $pdf->Cell(9,6,utf8_decode($value['nota'] == 'C' ? 'x' : ''),1,0,'C');
    $pdf->Cell(9,6,utf8_decode($value['nota'] == 'AV' ? 'x' : ''),1,0,'C');
    $pdf->Cell(9,6,utf8_decode($value['nota'] == 'EP' ? 'x' : ''),1,0,'C');
    $pdf->Cell(9,6,utf8_decode($value['nota'] == 'I' ? 'x' : ''),1,1,'C');
  }


}

$pdf->Ln(4);

$pdf->SetFont('Arial','',10);
$pdf->Cell(40,5,'C: Consolidado',0,0,'C');
$pdf->Cell(50,5,'Av: Avanzado',0,0,'C');
$pdf->Cell(50,5,'EP: En proceso',0,0,'C');
$pdf->Cell(50,5,'I: Iniciado',0,1,'C');
$pdf->Ln(2);
$texto_consolidado = utf8_decode("Consolidado (C): Logra la construcción de su aprendizaje en base a las potencialidades previstas del P.A. Avanzado (Av): Se encuentra progresando en su aprendizaje en base a las potencialidades previstas del P.A. En proceso (EP): Avanza en la construcción de su aprendizaje en base a las potencialidades previstas del P.A. Iniciado (I): Se inicia en la construcción de su aprendizaje en base a las potencialidades previstas del P.A.");

$pdf->SetFont('Arial','',8);
$pdf->MultiCell(185,4,$texto_consolidado,0,'J');
$pdf->Ln(5);

$pdf->MultiCell(185,4,'Recomendaciones: '.utf8_decode(ucfirst($datos_reporte['recomendacion'])),'B','J');
$pdf->Ln(10);

//Posición: a 3 cm del final
$pdf->SetY(-30);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(60,5,'Directivo',0,0,'C');
$pdf->Cell(60,5,'Sello',0,0,'C');
$pdf->Cell(60,5,'Docente',0,0,'C');


$pdf->Output(/*utf8_decode($datos_reporte['grado'].'_'.$datos_reporte['seccion'].'_'.a_romano($lapso).'_'.$datos_reporte['cedula'].'_'.$datos_reporte['p_nombre_estudiante'].'_'.$datos_reporte['p_apellido_estudiante'].'.pdf'),'D',true*/);

}
else{
  echo "No tiene permiso para visualizar el reporte";
}

}
ob_end_flush();
?>