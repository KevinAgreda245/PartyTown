<?php 
/**
 * Se llama al archivo fpfp.php
 */
require('../../libraries/fpdf/fpdf.php');
/**
 * Clase de PDF extendida con la clase FPDF
 */
class PDF extends FPDF
{
    /**
     * Declaración de propiedades
     */
    private $title;

    /**
     * Función para setear la propiedad title, además de agregar página
     * 
     * @param string $title es el título del reporte
     */
    function head($title)
    {
        $this->title = $title;
        $this->AddPage();
        $this->AliasNbPages();
    }

    /**
     * Función para el encabezado del reporte
     */
    function Header()
    {
        //Setear la fuente con Arial, en Negrita y tamaño 16
        $this->SetFont('Arial','B',16);
        //Setear el color de la fuente en formato rgb
        $this->SetTextColor(255,255,255);
        //Setear el color del contenedor en formato rgb
        $this->SetFillColor(238,95,65); 
        //Adjuntar la imagen del logo de la tienda, con el margen, y el tamaño
        $this->Image('../../../resources/img/public/logo/logo.png', 10, 10, 60);
        //Para agregar una celda con el ancho de 65
        $this->Cell(65);
        //Celda donde se aloja el título del reporte
        $this->Cell(125,10,utf8_decode($this->title),0,0,'C',true);
        //Salto de linea
        $this->Ln(15);
    }

    /**
     * Función para el pie del reporte
     */
    function Footer()
    {
        //Setea en el eje Y 
        $this->SetY(-15);
        //Setear el color de la fuente en formato rgb
        $this->SetTextColor(0,0,0);
        //Setear la fuente con Arial, en Cursiva y tamaño 8
        $this->SetFont('Arial','I',8);
        //Celda donde se agrega el número de página
        if ($_GET['lang'] == "ES") {
            $this->Cell(0,10,utf8_decode('Página '.$this->PageNo().' de {nb}'),0,0,'R');
        } else {
            $this->Cell(0,10,utf8_decode('Page '.$this->PageNo().' of {nb}'),0,0,'R');
        }
    }
}
?>