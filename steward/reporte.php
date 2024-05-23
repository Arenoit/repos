<?php
require_once('../database/conexion.php');
require_once('../fpdf/fpdf.php');
session_start();
class PDF extends FPDF{
   // Cabecera de página
   function Header(){
      $this->Image('../images/logo-istvl-normal.jpg',185,5,20); //logo de la empresa,moverDerecha,moverAbajo,tamañoIMG; acepta PNG y JPG excepción JPEG
      $this->SetFont('Arial','B',19); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(45); // Movernos a la derecha
      $this->SetTextColor(0, 0, 0); //color
      //creamos una celda o fila
      $this->Cell(110,15,utf8_decode('Reporte de Actividades'),0,1,'C',0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
      $this->Ln(3); // Salto de línea
      $this->SetTextColor(103); //color

      /*BUSQUEDA POR:*/
      $this->Cell(10);  // mover a la derecha
      $this->SetFont('Arial','B',10);
      $this->Cell(96, 10, utf8_decode("Busqueda por"),0,0,'',0);
      $this->Ln(5);
      /*AÑO*/
      $this->Cell(11);  // mover a la derecha
      $this->SetFont('Arial','B',10);
      $this->Cell(59, 10, utf8_decode("Año: " . (!empty($_SESSION['year'])?$_SESSION['year']:"Todos")),0,0,'',0);
      $this->Ln(5);
      /*MES*/
      $this->Cell(11);  // mover a la derecha
      $this->SetFont('Arial','B',10);
      $this->Cell(85, 10, utf8_decode("Mes: ". (!empty($_SESSION['month'])?$_SESSION['month']:"Todos")),0,0,'',0);
      $this->Ln(10);
   }
   // Pie de página
   function Footer()
   {
      $this->SetY(-15); // Posición: a 1,5 cm del final
      $this->SetFont('Arial','I',8); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->AliasNbPages();
      $this->Cell(0,10,utf8_decode('Página ') . $this->PageNo() . '/{nb}',0,0,'C'); //pie de pagina(numero de pagina)

      $this->SetY(-15); // Posición: a 1,5 cm del final
      $this->SetFont('Arial','I',8); //tipo fuente, cursiva, tamañoTexto
      $hoy = date('d/m/Y');
      $this->Cell(355, 10, utf8_decode($hoy), 0, 0, 'C'); // pie de pagina(fecha de pagina)
   }
}

$year=$_SESSION['year'];$month=$_SESSION['month'];
$espace=!empty($year&&$month)?" AND ":" ";$where=!empty($year||$month)?"WHERE":"";
$item1=(!empty($month))?"MONTH(posts_fec_posts)=$month":"";$item2=(!empty($year))?"YEAR(posts_fec_posts)=$year":"";
// Crear la primera página PDF
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
/* TITULO DE LA TABLA */
//color
$pdf->SetTextColor(93,105,117);
$pdf->Cell(50); // mover a la derecha
$pdf->SetFont('Arial','B',15);
$pdf->Cell(100,10,utf8_decode("Reporte de Descargas"),0,1,'C',0);
$pdf->Ln(7);
/* CAMPOS DE LA TABLA */
//color
$pdf->SetFillColor(37,27,27); //colorFondo
$pdf->SetTextColor(255,255,255); //colorTexto
$pdf->SetDrawColor(163,163,163); //colorBorde
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(35,10,utf8_decode('Fecha'),1,0,'C',1);
$pdf->Cell(85,10,utf8_decode('Carrera'),1,0,'C',1);
$pdf->Cell(35,10,utf8_decode('Cantidad'),1,0,'C',1);
$pdf->Cell(35,10,utf8_decode('%'),1,1,'C',1);
$graph=mysqli_query($con,"SELECT MONTH(vist.posts_fec_posts) months,YEAR(vist.posts_fec_posts) years,car.carer_nom_carer,COUNT(car.carer_nom_carer) stat FROM acacolec erv JOIN acaprojc prj ON erv.colec_cod_colec=prj.projc_cod_colec JOIN acacarer car ON car.carer_cod_carer=erv.colec_cod_carer JOIN acaposts vist ON vist.posts_file_down=prj.projc_cod_projc $where $item1 $espace $item2 GROUP BY car.carer_nom_carer ORDER BY stat ASC LIMIT 5");
/* TABLA */
$suma_total = 0;
foreach($graph as $piegraph){
   $suma_total += $piegraph['stat'];
}
foreach($graph as $piegraph){
   $pdf->SetTextColor(0,0,0);
   $num=empty($_SESSION['year']||$_SESSION['month'])?"Todos":"$piegraph[months]/$piegraph[years]";
   $pdf->Cell(35,10,utf8_decode($num),1,0,'C',0);
   $pdf->Cell(85,10,utf8_decode($piegraph['carer_nom_carer']),1,0,'C',0);
   $pdf->Cell(35,10,utf8_decode($piegraph['stat']),1,0,'C',0);
   $pdf->Cell(35,10,utf8_decode(number_format(($piegraph['stat']*100)/$suma_total,2))."%",1,1,'C',0);
}



// Crear la segunda página PDF
$pdf->Ln(7);
$pdf->SetFont('Arial','B',12);
/* TITULO DE LA TABLA */
//color
$pdf->SetTextColor(93,105,117);
$pdf->Cell(50); // mover a la derecha
$pdf->SetFont('Arial','B',15);
$pdf->Cell(100,10,utf8_decode("Reporte de Visitas"),0,1,'C',0);
$pdf->Ln(7);
/* CAMPOS DE LA TABLA */
//color
$pdf->SetX(($pdf->GetPageWidth()-95)/2);
$pdf->SetFillColor(37,27,27); //colorFondo
$pdf->SetTextColor(255,255,255); //colorTexto
$pdf->SetDrawColor(163,163,163); //colorBorde
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(35,10,utf8_decode('Fecha'),1,0,'C',1);
$pdf->Cell(35,10,utf8_decode('Cantidad'),1,0,'C',1);
$pdf->Cell(35,10,utf8_decode('%'),1,1,'C',1);
$chart = mysqli_query($con,"SELECT YEAR(posts_fec_posts) years,MONTH(posts_fec_posts) months,COUNT(posts_fec_posts) stat FROM acaposts WHERE posts_file_down=0".(!empty($item1||$item2)?" AND ":" ")."$item1 $espace $item2 GROUP BY months ORDER BY MOD(MONTH(posts_fec_posts) - MONTH(NOW()) + 12, 12) LIMIT 5");
/* TABLA */
$suma_total = 0;
foreach($chart as $barschart){
   $suma_total += $barschart['stat'];
}
foreach($chart as $barschart){
   $pdf->SetTextColor(0,0,0);
   $num=empty($_SESSION['year']||$_SESSION['month'])?"Todos":"$barschart[months]/$barschart[years]";
   $pdf->SetX(($pdf->GetPageWidth()-95)/2);
   $pdf->Cell(35,10,utf8_decode($num),1,0,'C',0);
   $pdf->Cell(35,10,utf8_decode($barschart['stat']),1,0,'C',0);
   $pdf->Cell(35,10,utf8_decode(number_format(($barschart['stat']*100)/$suma_total,2))."%",1,1,'C',0);
}
// Generar archivos PDF
$pdf->Output('reporte.pdf','I');//nombreDescarga, Visor(I->visualizar - D->descargar)
?>