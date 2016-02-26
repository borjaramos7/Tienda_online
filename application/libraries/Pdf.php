<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pdf extends FPDF {
        
        public function PedidoPdf($pedido,$lineas,$enviar=false) {
            
                
                
                $pdf= new FPDF();
                $pdf->AddPage();
                $pdf->SetFont('Arial','B',14);
                $pdf->Cell(40,7,"Pedido: ".$pedido['idpedido'],0);
                $pdf->Cell(70,7,"Estado: ".$pedido['estado_ped'],0);
                $pdf->Cell(70,7,"Fecha: ".$pedido['fecha_pedido'],0);
                $pdf->Ln();
                $pdf->Ln();
                $pdf->Ln();
                $pdf->Cell(70,7,"Nombre del producto",1);
                $pdf->Cell(26,7,"Cantidad",1); 
                $pdf->Cell(40,7,"Precio",1); 
                $pdf->Cell(40,7,"Precio Final *",1);
                $pdf->Ln();
                
                foreach ($lineas as $linea) {   
                $pdf->Cell(70,7,$linea['nombrepro'],1);
                $pdf->Cell(26,7,$linea['cantidad'],1); 
                $pdf->Cell(40,7,$linea['preciopro'].iconv('UTF-8', 'windows-1252', '€'),1); 
                $pdf->Cell(40,7,$linea['precio_ped'].iconv('UTF-8', 'windows-1252', '€'),1);
                $pdf->Ln();
                }
                $pdf->Ln();
                $pdf->Ln();
                $pdf->Cell(100,7,"Total del pedido: ".$pedido['total_ped'].iconv('UTF-8', 'windows-1252', '€'),1);
                $pdf->Ln();
                $pdf->Ln();
                $pdf->Ln();
                $pdf->Cell(100,7,"* Impuestos y descuento aplicados ",0);
                if ($enviar==false)
                $pdf->Output();
                else 
                    $pdf->Output('F','asset/pedidocorreo/pedido.pdf',true);
        }
        
 
}