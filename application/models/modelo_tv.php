<?php
/**
 * Modelo con las llamadas a la base de datos
 */
class Modelo_tv extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();}
        /**
         * Saca todas las categorias
         * @return type
         */
        public function Categorias() {
            
            $cat=$this->db->get('categoria');
            
            return $cat->result_array();
        }
        /**
         * Recibe una id de categoria y devuelve el nombre de dicha categoria
         * @param type $id
         * @return type
         */
        public function SacaNombreCat($id) {
            $query="select nombrecat from categoria where idcat=".$id."";
            $catnom=$this->db->query($query);
            return $catnom->row()->nombrecat;
        }
        /**
         * Recibe la id de un producto y saca su nombre
         * @param type $id
         * @return type
         */
        public function SacaNombrePro($id) {
            $query="select nombrepro from producto where id= ".$id." and oculto=0";
            $pronom=$this->db->query($query);
            return $pronom->row()->nombrepro;
        }
        /**
         * Recibe la id de un producto y devuelve su precio
         * @param type $id
         * @return type
         */
        public function SacaPrecioPro($id) {
            $query="select precio from producto where id= ".$id." and oculto=0";
            $pronom=$this->db->query($query);
            return $pronom->row()->precio;
        }
        /**
         * Recibe la id de un producto y devuelve su stock
         * @param type $id
         * @return type
         */
        public function SacaStockPro($id) {
            $query="select stock from producto where id= ".$id." and oculto=0";
            $pronom=$this->db->query($query);
            return $pronom->row()->stock;
        }
        
         /*Antes paginar   public function ProductosCategoria($categoria, $page, $per_page)
    {
        $qr = $this->db->get_where('producto', array('categoria_idcat'=>$categoria, 'oculto'=>0), $per_page,$page);
        return $qr->result_array();
    }*/
        /**
         * Recibe una id de categoria y devuelve un array con todos los productos de esa categoria
         * @param type $categoria_id
         * @return type
         */
        public function ProductosCategoria($categoria_id) {
            $query="select * from producto where categoria_idcat= ".$categoria_id." and oculto=0 ";
            $procat=$this->db->query($query);
            return $procat->result_array();
        }
        
        /**
         * Devuelve los productos detacados y que las fechas coincidan
         * @return type
         */
        public function ProDestacados() {
            $query="select * from producto where destacado=1 and oculto=0"
                    . " and fechacom<=CURDATE() and fechafin>=CURDATE()";
            $prodes=$this->db->query($query);
            return $prodes->result_array();
        }
       
        /**
         * Saca todos los los productos
         * @return type
         */
        public function SacaTodosProductos(){
            $query="select * from producto";
            $procat=$this->db->query($query);
            return $procat->result_array();
        }
        
        /**
         * Recibe una id de producto y saca todos sus datos
         * @param type $id_pro
         * @return type
         */
        public function SacaProducto($id_pro){
            $query="select * from producto where id= ".$id_pro." and oculto=0";
            $procat=$this->db->query($query);
            return $procat->row();
        }
        
        /**
         * Recibe un array con los datos de un usuario y los inserta en la BBDD
         * @param type $newusuario
         */
        public function AltaUsuario($newusuario){
            $this->db->insert('usuario', $newusuario); 
        }
        /**
         * Recibe un array con los datos de una categoria, los inserta y devuelve la id que se ha autogenerado
         * @param type $cat
         * @return type
         */
        public function AddCategoria($cat){
            $this->db->insert('categoria', $cat);
            
            return $this->db->insert_id();
        }
        
        /**
         * Añade un producto a la BBDD con los datos recibidos
         * @param type $datospro
         */
        public function AddProducto($datospro){
            $this->db->insert('producto', $datospro); 
        }
        
        /**
         * Recibe un usuario y una contraseña y realiza un count para saber si existe en el sistema,
         * si existe devuelve true si no false.
         * @param type $usuario
         * @param type $contr
         * @return boolean
         */
        public function CompUser($usuario,$contr) {
            
            $query="select count(*) as 'total' from usuario where nombreus= '".$usuario."' and contrasena= '".$contr."'"
                    . " and estado='ok'";
            $usuarioexiste=$this->db->query($query);
            echo $query;
            $a=$usuarioexiste->row();
            $a=(array)$a;
            if ($a['total']==1)
                return true;
            else return false;
        }
        
        /**
         * Da de baja al usuario que se encuentra ahora mismo en la sesion
         */
        public function BajaUsuario() {
            $query="UPDATE usuario SET estado='baja' where nombreus= '".$this->session->userdata('username')."'";
            $this->db->query($query);
        }
        
        /**
         * Recibe un nombre de usuario y devuelve su id
         * @param type $nomuser
         * @return type
         */
        public function SacaIdUser($nomuser) {
             $query="select iduser from usuario where nombreus= '".$nomuser."'";
             $idusuario=$this->db->query($query);
             return $idusuario->row()->iduser;
        }
        
        /**
         * Recibe el nombre de usuario de un usuario y devulve su email
         * @param type $nomuser
         * @return type
         */
        public function SacaEmailUser($nomuser) {
             $query="select email from usuario where nombreus= '".$nomuser."'";
             $emailusuario=$this->db->query($query);
             return $emailusuario->row()->email;
        }
        /**
         * A traves de un count comprueba si el nombre de usuario recibido ya esta en el sistema y devuelve verdadero
         * si existe y false si no.
         * @param type $usuario
         * @return boolean
         */
        public function CompNombreUser($usuario) {
            
            $query="select count(*) as 'total' from usuario where nombreus= '".$usuario."'";
            $usuarioexiste=$this->db->query($query);
            $a=$usuarioexiste->row();
            $a=(array)$a;
            if ($a['total']==1)
                return true;
            else return false;
        }
        
        /**
         * Recibe un array con los datos de un pedido y lo inserta
         * @param type $datosped
         */
        public function InsertaPedido($datosped) {
            $this->db->insert('pedido', $datosped); 
        }
        /**
         * Recibe un array con los datos de una linea de pedido y la inserta
         * @param type $datoslinped
         */
        public function InsLineaPedido($datoslinped) {
            $this->db->insert('linea_pedido', $datoslinped); 
        }
        
        /**
         * Recibe la id de un pedido devuelve sus datos
         * @param type $id_ped
         * @return type
         */
        public function SacaPedidoPorID($id_ped){
            $query="select * from pedido where idpedido= ".$id_ped."";
            $pedido=$this->db->query($query);
            return $pedido->row_array();
        }
        /**
         * Saca los pedidos de un usuario n concreto a traves de su id
         * @param type $id_user
         * @return type
         */
        public function SacaPedidosPorUser($id_user){
            $query="select * from pedido where usuario_iduser= ".$id_user."";
            $pedido=$this->db->query($query);
            return $pedido->result_array();
        }
        /**
         * Recibe la id de un pedido y saca todas sus lineas
         * @param type $id_ped
         * @return type
         */
        public function SacaLinPedido($id_ped){
            $query="select * from linea_pedido where pedido_idpedido= ".$id_ped."";
            $lipedido=$this->db->query($query);
            return $lipedido->result_array();
        }
        /**
         * Recibe la id de un pedido y cambia su estado a anulado
         * @param type $idpedido
         */
        public function AnulaPedido($idpedido) {
            $query="UPDATE pedido SET estado_ped='Anulado' where idpedido= ".$idpedido."";
            $this->db->query($query);
        }
        /**
         * Recibe la id de un producto asi como la cantidad a restar y actualiza el stock
         * @param type $idpro
         * @param type $cantpro
         */
        public function AjustaStock($idpro,$cantpro) {
            $newstock=$this->SacaStockPro($idpro)-$cantpro;
            
            $query="UPDATE producto SET stock= ".$newstock." where id= ".$idpro."";
            $this->db->query($query);
        }
        /**
         * Recibe el nombre usuario de un usuario y devulve todos sus datos
         * @param type $usuario
         * @return type
         */
        public function SacaUsuario($usuario){
            $query="select * from usuario where nombreus= '".$usuario."' and estado='ok'";
            $resuser=$this->db->query($query);
            return $resuser->result();
        }
        
        /**
         * Recibe los datos nuevos de un usuario y los modifica en la BBDD
         * @param type $nuevosdatos
         */
        public function ModificaUsuario($nuevosdatos) {
            $this->db->where('nombreus',$this->session->userdata('username'));
            $this->db->update('usuario', $nuevosdatos); 
        }
        /**
         * Recibe la id de una categoria y devulve el numero de productos que tiene
         * @param type $idcat
         * @return type
         */
        public function CuentaProductosXCat($idcat) {
            
            $query="select count(*) as 'total' from producto where categoria_idcat= ".$idcat."";
            $numprods=$this->db->query($query);
            return $numprods->row()->total;
        }
        /**
         * Devuelve el numero de productos destacados
         * @return type
         */
        public function CuentaProductosDes() {
            
            $query="select count(*) as 'total' from producto where destacado=1";
            $numprods=$this->db->query($query);
            return $numprods->row()->total;
        }
}


