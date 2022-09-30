<?php
session_start();
if (isset($_SESSION['idUsuario'])) {
    require('../templates/privateTemplates.php');
    require('../../helpers/database.php');
    require('../../helpers/validator.php');
    require('../../models/partyType.php');

    ini_set('date.timezone', 'America/El_Salvador');//Inicializacion de fecha y hora

    $pdf = new PDF('P','mm','Letter');
    $product = new partyType(); 

    $pdf->head('Reporte de Producto por Tipo de Evento');
    $pdf->SetFont('Times','',12);
    $pdf->SetWidths(Array(50,80,30,30));
    $pdf->SetLineHeight(5);
    $type = '';
    $data = $product->getTypeProd();

    foreach($data as $index){
        if(utf8_decode($index['tipoevento']) != $type){
            $pdf->Ln(5);
            $pdf->SetTextColor(255,255,255); 
            $pdf->SetFillColor(28, 185, 158); 
            $pdf->SetFont('Times','B',12);
            $pdf->Cell(190,10,utf8_decode($index['tipoevento']),0,0,'L',true);
            $pdf->Ln(15);
            $pdf->SetFillColor(184,227,219); 
            $pdf->SetTextColor(0,0,0);
            $pdf->Cell(50,7,utf8_decode('Nombre'),1,0,'C',true);
            $pdf->Cell(80,7,utf8_decode('Descripción'),1,0,'C',true);
            $pdf->Cell(30,7,utf8_decode('Precio ($)'),1,0,'C',true);
            $pdf->Cell(30,7,utf8_decode('Cantidad'),1,1,'C',true);
            $pdf->SetFont('Times','',12);
            $type = utf8_decode($index['tipoevento']);
        }
        $pdf->Row(Array(
            $index['nombreProducto'],
            $index['descripcionProducto'],
            number_format($index['precioProducto'],2,".",","),
            $index['cantidadProducto']
        ));
    }
    $pdf->Output();
} else {
    header('location: ../../../views/dashboard/');    
}
?>