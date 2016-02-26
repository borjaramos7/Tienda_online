<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EnviaCorreo extends CI_Controller {

	public function index()
	{
		
	}
        
         public function Enviar($codigopedido,$mail)
	{
		$this->email->from('aula4@iessansebastian.com', 'Pedido Buyphone');
		$this->email->to($mail); 
		//$this->email->cc('another@another-example.com'); 
		//$this->email->bcc('them@their-example.com'); 
		
		$this->email->subject('Datos del pedido');
		$this->email->attach('asset/pedidocorreo/pedido.pdf');
		
		if ( $this->email->send() )
		{
			/*$cuerpo= $this->load->view('Compra_Realizada','', true);
                        $this->load->view('Index', Array('cuerpo' => $cuerpo));*/
                    echo "Correo enviado";
		}
		else 
		{
			echo "</pre>\n\n**** Compra realizada , fallo al enviar correo ****</pre>\n";
		}
		
		//echo $this->email->print_debugger();
                 //Mostramos compra realizada.
            
	}
}