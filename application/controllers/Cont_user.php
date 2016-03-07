<?php
/**
 * En este controlador estan las funciones relacionadas con la gestion de usuarios 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Cont_user extends CI_Controller {

	public function index()
	{
		$this->CargaPlantilla();
                
                
	}
        /**
         * Llama a la vista donde esta el formulario de registro
         */
        public function Registro(){
                    $this->CargaPlantilla(
                            $this->load->view('reg_user',"",TRUE));
        }
        /**
         * Llama a la vista de logueo, en caso de error en el logueo le pasa un mensaje de error. 
         * @param type $error
         */
        public function Login($error=""){
                    $this->CargaPlantilla(
                            $this->load->view('login',array(
                'error'=>$error),TRUE),"Introduce tus datos de usuario");
        }

        protected function CargaPlantilla($cuerpo='',$encabezado="") {
            $categ=$this->Modelo_tv->Categorias();
            $this->load->view('vista_principal',array(
                'categorias'=>$categ,
                'cuerpo'=>$cuerpo,
                'encabezado'=>$encabezado
                ));   
           }
          
        /**
         * Funcion encargada de filtrar los datos introducidos en el formulario de registro y en caso de que no haya error
         * de inseertarlo en la BBDD.
         */
        public function VerificaDatosUsuario()
        {
             $this->CargaReglas();

            if   ($this->form_validation->run() == FALSE)
                {
                    $this->CargaPlantilla(
                            $this->load->view('reg_user',"",TRUE));
                }
                else 
                {
                    $cont_encrip=md5($this->input->post('pass'));
                    $datosuser= array(
                        'dni'=>$this->input->post('dni'),
                        'nombreus'=>$this->input->post('nombreuser'),                        
                        'contrasena'=>$cont_encrip,
                        'nombre'=>$this->input->post('nombre'),
                        'apellidos'=>$this->input->post('apellidos'),
                        'direccion'=>$this->input->post('dire'),
                        'cp'=>$this->input->post('cp'),
                        'provincia'=>$this->input->post('prov'),
                        'email'=>$this->input->post('correo'),
                        'estado'=>'ok');
                    
                    $this->Modelo_tv->AltaUsuario($datosuser);
                    echo "<div style='color:blue; border:2px red;'>!Te has registrado con exito¡</div>";
                }
        }
        
        /**
         * Aqui definimos las  reglas de filtrado para el registro de usuarios
         */
        public function CargaReglas()
        {
                $this->form_validation->set_rules('nombre','nombre','required');
                $this->form_validation->set_rules('apellidos','apellidos','required');
                $this->form_validation->set_rules('dni','dni','required|callback_CompDni');
                $this->form_validation->set_rules('nombreuser','Nombre de usuario','required|callback_CompExisteNombreus');
                $this->form_validation->set_rules('correo', 'Email', 'required|valid_email');
                $this->form_validation->set_rules('pass', 'Contraseña', 'required|matches[repass]');
                $this->form_validation->set_rules('repass', 'Confirmar Contraseña', 'required');
        }
        
        /**
         * Llama al modelo para que compruebe si el usuario y contraseña introducidos son correctos
         * en caso de que sean incorrectos llama a Login pasandole el error para que lo muestre al usuario.
         */
        public function VerificaLogin() {
            $contr_login=md5($this->input->post('cont'));
            $existe=$this->Modelo_tv->CompUser(
                    $this->input->post('user'),
                    $contr_login
                    );
            
            if ($existe)
            {
                $newdata = array(
                
                'username' => $this->input->post('user'),
                'logged_in' => TRUE,
                 'id'=>$this->Modelo_tv->SacaIdUser($this->input->post('user')),
                 'correo'=>$this->Modelo_tv->SacaEmailUser($this->input->post('user'))
                );
                $this->session->set_userdata($newdata);
                
                //if () por aqui vas
                redirect('', 'location', 301);
            }
            else $this->Login("Usuario o contraseña incorrectos");
        }
        
        /**
         * Destruye la sesion
         */
        public function LogOut() {
            $this->session->sess_destroy();
            redirect('', 'location', 301);
        }
        
        /**
         * Cambia el estado del usuario a dado de baja
         */
        public function DarBajaUsuario() {
            $this->Modelo_tv->BajaUsuario();
            $this->LogOut();
        }
        
        /**
         * Devuelve verdadero si el dni es correcto o falso si no lo es.
         * @return boolean
         */
        public function CompDni (){
            
            $resdni=dni_valida_nif_cif_nie($this->input->post('dni'));
            $this->form_validation->set_message('CompDni', 'El DNI no es correcto');
            
            if ($resdni<=3 && $resdni>0) {
            return true;
            } else
            return false;
        }
        
        /**
         * Comprueba si el nombre de usuario con el que intenta registrarse ya esta en la BBDD.
         * @return boolean
         */
        public function CompExisteNombreus() {
            $existenombre=$this->Modelo_tv->CompNombreUser($this->input->post('nombreuser'));
            $this->form_validation->set_message('CompExisteNombreus', 'El nombre de usuario ya existe');
            
            if ($existenombre) {
            return false;
            } else
            return true;
        }
        /**
         * Carga los datos del usuario para mostralos a la hora de modificarlos.
         */
        public function CargaDatosUs() {
            $user=$this->Modelo_tv->SacaUsuario($this->session->userdata('username')); 
		$this->CargaPlantilla(
                        $this->load->view('Mod_user', array(
                            'usuarios'=>$user,
                        ), TRUE)
                        );
        }
        
        /**
         * Comprueba que los datos modificados cumplen con las reglas de filtrado, si las cumplen las inserta en la BBDD.
         */
        public function VerificaDatosUsuarioMod()
        {
             $this->CargaReglasMod();

            if   ($this->form_validation->run() == FALSE)
                {
                    $this->CargaDatosUs();
                }
                else 
                {
                    $datosuser= array(
                        'dni'=>$this->input->post('dni'),                     
                        //'contrasena'=>$this->input->post('pass'),
                        'nombre'=>$this->input->post('nombre'),
                        'apellidos'=>$this->input->post('apellidos'),
                        'direccion'=>$this->input->post('dire'),
                        'cp'=>$this->input->post('cp'),
                        'provincia'=>$this->input->post('prov'),
                        'email'=>$this->input->post('correo'),
                        'estado'=>'ok');
                    
                    $this->Modelo_tv->ModificaUsuario($datosuser);
                    redirect('', 'location', 301);
                }
        }
        /**
         * Reglas de validacion para el modificado de usuarios
         */
        public function CargaReglasMod()
        {
                $this->form_validation->set_rules('nombre','nombre','required');
                $this->form_validation->set_rules('apellidos','apellidos','required');
                $this->form_validation->set_rules('dni','dni','required|callback_CompDni');
                $this->form_validation->set_rules('correo', 'Email', 'required|valid_email');
                //$this->form_validation->set_rules('pass', 'Contraseña', 'required|matches[repass]');
                //$this->form_validation->set_rules('repass', 'Confirmar Contraseña', 'required');
        }
}