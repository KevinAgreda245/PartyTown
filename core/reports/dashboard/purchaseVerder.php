<?php
session_start();
if (isset($_SESSION['idUsuario'])) {
    require('../templates/publicTemplates.php');
    require('../../helpers/database.php');
    require('../../helpers/validator.php');
    require('../../models/invoices.php');

    $pdf = new PDF('P','mm','Letter');
    $invoices = new Invoices(); 

    $pdf->head('Comprobante de Factura');
    if($invoices->setId($_SESSION['idInvoices'])){
        $data = $invoices->getInvoices();
        if($data){
            $pdf->SetFont('Times','I',15);
            $pdf->Cell(120,10,utf8_decode('Factura No.'.$_SESSION['idInvoices']),0,0,'L');
            $pdf->SetFont('Times','B',12);
            $pdf->Cell(14,10,utf8_decode('Fecha:'),0,0,'L');
            $pdf->SetFont('Times','',12);
            $date = date_create($data['fechahoraFactura']);
            $pdf->Cell(22,10,utf8_decode(date_format($date,'d/m/Y')),0,0,'R');
            $pdf->SetFont('Times','B',12);
            $pdf->Cell(15,10,utf8_decode('Hora:'),0,0,'R');
            $pdf->SetFont('Times','',12);
            $pdf->Cell(17,10,utf8_decode(date_format($date,'g:i A')),0,1,'L');
            $pdf->SetFont('Times','B',12);
            $pdf->Cell(15,10,utf8_decode('Cliente:'),0,0,'L');
            $pdf->SetFont('Times','',12);
            $pdf->Cell(27,10,utf8_decode($data['nombreCliente'].' '.$data['apellidoCliente']),0,1,'L');
            $pdf->SetFont('Times','B',12);
            $pdf->Cell(20,10,utf8_decode('Dirección:'),0,0,'L');
            $pdf->SetFont('Times','',12);
            $pdf->Cell(27,10,utf8_decode($data['direccionFactura']),0,1,'L');
            $pdf->Ln(4);
            $productos = $invoices->getProduct();
            if($productos){
                $pdf->SetFillColor(142,197,187); 
                $pdf->SetFont('Times','B',12);
                $pdf->Cell(70,7,utf8_decode('Producto'),1,0,'C',true);
                $pdf->Cell(40,7,utf8_decode('Cantidad'),1,0,'C',true);
                $pdf->Cell(40,7,utf8_decode('Precio ($)'),1,0,'C',true);
                $pdf->Cell(40,7,utf8_decode('Sub Total ($)'),1,1,'C',true);
                $pdf->SetFont('Times','',12);
                $subtotal = 0;
                $total = 0;
                foreach($productos as $datos){
                    $subtotal = ($datos['precioProducto'] * $datos['cantidad']);
                    $total += $subtotal;
                    $pdf->Cell(70,10,utf8_decode($datos['nombreProducto']),1,0,'L');
                    $pdf->Cell(40,10,utf8_decode($datos['cantidad']),1,0,'L');
                    $pdf->Cell(40,10,utf8_decode(number_format($datos['precioProducto'],2,".",",")),1,0,'L');
                    $pdf->Cell(40,10,utf8_decode(number_format($subtotal,2,".",",")),1,1,'L');
                    $subtotal = 0;
                }
                $pdf->SetFont('Times','B',12);
                $pdf->Cell(150,10,utf8_decode('TOTAL($):'),1,0,'R');
                $pdf->SetFont('Times','',12);
                $pdf->Cell(40,10,utf8_decode(number_format($total,2,".",",")),1,1,'L');
            } else {
                $pdf->SetFont('Times','I',15);
                $pdf->Cell(190,10,utf8_decode('No posee productos'),0,1,'L');        
            }
        } else {
            $pdf->SetFont('Times','I',15);
            $pdf->Cell(27,10,utf8_decode('Factura Inexistente'),0,1,'L');
        }
    } else {
        $pdf->SetFont('Times','I',15);
        $pdf->Cell(27,10,utf8_decode('Factura Incorrecta'),0,1,'L');
    }

    $pdf->Output();
} else {
    header('location: ../../../views/dashboard/');      
}
?>