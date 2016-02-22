<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pdf extends FPDF {
        
        public function Prueba($idpedido) {
                $pdf= new FPDF();
                $pdf->AddPage();
                $pdf->SetFont('Arial','B',16);
                $pdf->Cell(40,10,'¡Mi primera página pdf con FPDF!');
                $pdf->Output();
        }
}