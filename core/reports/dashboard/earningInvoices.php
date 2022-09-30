<?php
session_start();
if (isset($_SESSION['idUsuario'])) {
    require('../templates/privateTemplates.php');
    require('../../helpers/database.php');
    require('../../helpers/validator.php');
    require('../../models/invoices.php');

    ini_set('date.timezone', 'America/El_Salvador');//Inicializacion de fecha y hora

    $pdf = new PDF('P','mm','Letter');
    $invoices = new Invoices(); 

    $pdf->head('Reporte de Facturas Pendientes');
    $pdf->SetFont('Times','',12);
    $id = '';
    $total = 0;
    $data = $invoices->getEarning();
    if ($data) {
        foreach($data as $index) {
            if(utf8_decode($index['idCliente']) != $id){
                $pdf->Ln(5);
                $pdf->SetTextColor(255,255,255); 
                $pdf->SetFillColor(28, 185, 158); 
                $pdf->SetFont('Times','B',15);
                $pdf->Cell(190,10,utf8_decode($index['nombreCliente'].' '.$index['apellidoCliente']),0,0,'L',true);
                $pdf->Ln(12);
                $pdf->SetTextColor(0,0,0); 
                $pdf->SetFont('Times','',12);
                $id = $index['idCliente'];
            }
            if($invoices->setId($index['idFactura'])){
                $data2 = $invoices->getProduct();
                foreach($data2 as $index2){
                    $total += ($index2['precioProducto'] * $index2['cantidad']);
                }
            }
            $pdf->SetTextColor(0,0,0); 
            $pdf->SetFillColor(255,255,255); 
            $pdf->SetFont('Times','I',15);
            $pdf->Cell(27,10,utf8_decode('Factura No. '.$index['idFactura']),0,1,'L',true);
            $pdf->SetFont('Times','B',12);
            $pdf->Cell(27,10,utf8_decode('Fecha y Hora:'),0,0,'L',true);
            $pdf->SetFont('Times','',12);
            $pdf->Cell(163,10,utf8_decode($index['fechahoraFactura']),0,1,'L',true);
            $pdf->SetFont('Times','B',12);
            $pdf->Cell(21,10,utf8_decode('Ubicación:'),0,0,'L',true);
            $pdf->SetFont('Times','',12);
            $pdf->Cell(169,10,utf8_decode($index['direccionFactura']),0,1,'L',true);
            $pdf->SetFont('Times','B',12);
            $pdf->Cell(21,10,utf8_decode('Total($):'),0,0,'L',true);
            $pdf->SetFont('Times','',12);
            $pdf->Cell(169,10,utf8_decode(number_format($total,2,".",",")),0,1,'L',true);
            $pdf->Ln(5);
            $pdf->SetFillColor(142,197,187); 
            $pdf->SetFont('Times','B',12);
            $pdf->Cell(70,7,utf8_decode('Producto'),1,0,'C',true);
            $pdf->Cell(40,7,utf8_decode('Cantidad'),1,0,'C',true);
            $pdf->Cell(40,7,utf8_decode('Precio ($)'),1,0,'C',true);
            $pdf->Cell(40,7,utf8_decode('Sub Total ($)'),1,1,'C',true);
            $pdf->SetFont('Times','',12);
            foreach($data2 as $index2){
                $pdf->Cell(70,10,utf8_decode($index2['nombreProducto']),1,0,'L');
                $pdf->Cell(40,10,utf8_decode($index2['cantidad']),1,0,'L');
                $pdf->Cell(40,10,utf8_decode(number_format($index2['precioProducto'],2,".",",")),1,0,'L');
                $pdf->Cell(40,10,utf8_decode(number_format(($index2['precioProducto'] * $index2['cantidad']),2,".",",")),1,1,'L');
            }
            $pdf->Ln(5);
            $total = 0;
        }
    } else {
        $pdf->SetFont('Times','B',15);
        $pdf->Cell(190,10,utf8_decode('No hay facturas pendientes'),0,0,'C');
    }

    $pdf->Output();
} else {
    header('location: ../../../views/dashboard/');
}
?>