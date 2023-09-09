<?php
require('fpdf.php');
require_once "/home/customer/www/rifadiaz.net/public_html/controladores/xRecibos.controlador.php";
require_once "/home/customer/www/rifadiaz.net/public_html/modelos/xRecibos.modelo.php";

$codigo = $_GET['codigo'];

$detalle = ControladorRecibosLoteria::ctrMostrarRECLoteria($codigo);
$cantidad = count($detalle);

class PDF extends FPDF
{

    function Cell($w, $h = 0, $t = '', $b = 0, $l = 0, $a = '', $f = false, $y = '')
    {
        parent::Cell($w, $h, iconv('UTF-8', 'windows-1252', $t), $b, $l, $a, $f, $y);
    }
}


$pdf = new PDF($orientation = 'P', $unit = 'mm', array(45, 350));
$pdf->AddPage();
$pdf->setX(2);
$pdf->SetFont('Helvetica', 'B', 18);
$pdf->cell(41, 7, 'RIFA DÍAZ', 0, 0, 'C');
$pdf->Ln();


$pdf->SetFont('Helvetica', '', 10);
$pdf->setX(2);
$pdf->cell(41, 3, 'Boleto: ' . $codigo, 0, 0, 'C');

$fecha = $detalle[0]['fecha'];
$hora = $detalle[0]['hora'];

$pdf->Ln();
$pdf->setX(2);
$pdf->SetFont('Helvetica', '', 8);
$pdf->Cell(41, 4, $fecha . ' | ' . $hora, 0, 0, 'C');


$pdf->Ln();
$pdf->SetFont('Helvetica', '', 10);
$pdf->setX(2);
$pdf->cell(41, 4, 'Sorteo 6:00 PM', 0, 0, 'C');


$pdf->SetFont('Helvetica', '', 5);    //Letra Helvetica, negrita (Bold), tam. 20
$pdf->Ln();
$pdf->Ln();
$pdf->setX(2);


$pdf->SetFont('Helvetica', 'B', 10);
$pdf->cell(13, 4, 'Número', 'B', 0, 'C');
$pdf->cell(14, 4, 'Monto', 'B', 0, 'C');
$pdf->cell(14, 4, 'Premio', 'B', 0, 'C');

$pdf->SetFont('Helvetica', '', 10);
$pdf->Ln();

$suma = 0;

foreach ($detalle as $value) {
    $numero = str_pad($value["numero"], 2, "0", STR_PAD_LEFT);

    $pdf->setX(2);
    $pdf->cell(13, 4, $numero, 0, 0, 'C');
    $pdf->setX(15);
    $pdf->cell(14, 4, $value["inversion"], 0, 0, 'C');
    $pdf->setX(29);
    $pdf->cell(14, 4, $value["premio"], 0, 0, 'C');
    $pdf->Ln();

    $suma += $value["inversion"];
}

$pdf->Ln();
$pdf->SetFont('Helvetica', '', 10);
$pdf->setX(2);
$pdf->cell(41, 3, 'Total: C$ ' . $suma, 0, 0, 'C');

$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Helvetica', '', 8);
$pdf->setX(2);
$pdf->cell(41, 3, 'Vendedor: ' . $detalle[0]['vende'], 0, 0, 'C');

$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Helvetica', '', 6);
$pdf->setX(2);
$pdf->cell(41, 3, 'NO SE ACEPTAN RECLAMOS', 0, 0, 'C');
$pdf->Ln();
$pdf->setX(2);
$pdf->cell(41, 3, 'Revisa antes de Pagar', 0, 0, 'C');
$pdf->Ln();
$pdf->setX(2);
$pdf->cell(41, 3, 'Sin ticket no hay premio', 0, 0, 'C');

$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Helvetica', '', 8);
$pdf->setX(2);
$pdf->cell(41, 6, '++++++++++++++++++++++++++++++', 0, 0, 'C');

$pdf->Output('I', $codigo . '.pdf', false);
