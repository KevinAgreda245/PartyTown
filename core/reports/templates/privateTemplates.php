<?php 
/**
 * Se llama al archivo fpfp.php
 */
require_once('../../libraries/fpdf/fpdf.php');

/**
 * 
 */
class PDF extends FPDF
{
    private $title;
    private $widths;
    private $aligns;
    private $lineHeight;

    function head($title)
    {
        $this->title = $title;
        $this->AddPage();
        $this->AliasNbPages();
    }

    function Header()
    {
        $this->SetFont('Arial','B',16);
        $this->SetTextColor(255,255,255);
        $this->SetFillColor(238,95,65); 
        $this->Image('../../../resources/img/public/logo/logo.png', 10, 10, 60);
        $this->Cell(65);
        $this->Cell(125,10,utf8_decode($this->title),0,0,'C',true);
        $this->Ln(15);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetTextColor(0,0,0);
        $this->SetFont('Arial','',8);
        $this->Cell(0,10,utf8_decode("Fecha: ".Date('d/m/y')." Hora: ".Date('g:i:s')." Creado Por: ".$_SESSION['nombreUsuario']),0,0,'L');
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,utf8_decode('Página '.$this->PageNo().' de {nb}'),0,0,'R');
    }

    function SetWidths($w){
        $this->widths=$w;
    }
    
    function SetAligns($a){
        $this->aligns=$a;
    }

    function SetLineHeight($h){
        $this->lineHeight=$h;
    }
    
    function Row($data)
    {
        
        $nb = 0;
        for($i=0;$i<count($data);$i++){
            $nb = max($nb,$this->NbLines($this->widths[$i],$data[$i]));
        }
        $h = $this->lineHeight * $nb;
        $this->CheckPageBreak($h);
        for($i=0;$i<count($data);$i++)
        {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            $x = $this->GetX();
            $y = $this->GetY();
            $this->Rect($x,$y,$w,$h);
            $this->MultiCell($w,5,utf8_decode($data[$i]),0,$a);
            $this->SetXY($x+$w,$y);
        }
        $this->Ln($h);
    }

    function CheckPageBreak($h)
    {
        
        if($this->GetY()+$h>$this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function NbLines($w,$txt)
    {
        $cw = &$this->CurrentFont['cw'];
        if($w==0)
            $w=$this->w-$this->rMargin-$this->x;
        $wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
        $s = str_replace("\r",'',$txt);
        $nb = strlen($s);
        if($nb>0 and $s[$nb-1]=="\n")
            $nb--;
        $sep=-1;
        $i=0;
        $j=0;
        $l=0;
        $nl=1;
        while($i<$nb)
        {
            $c=$s[$i];
            if($c=="\n")
            {
                $i++;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
                continue;
            }
            if($c==' ')
                $sep=$i;
            $l+=$cw[$c];
            if($l>$wmax)
            {
                if($sep==-1)
                {
                    if($i==$j)
                        $i++;
                } else
                    $i=$sep+1;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
            } else
                $i++;
        }
        return $nl;
    }   
}
?>