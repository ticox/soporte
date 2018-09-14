<?php

class loginajaxController extends Controller
{
    private $_login;
    
    public function __construct(){
        parent::__construct();
        $this->_login = $this->loadModel('login');
     
    }
    
    public function index()
    {

        
       
 
            $row = $this->_login->getUsuario(
                    $this->getAlphaNum('login'),
                    $this->getSql('clave')
                    );
            
            if(!$row){
                echo '0';
                return;
            }
        
            

            Session::set('autenticado', true);
            Session::set('level', $row['role']);
            Session::set('usuario', $row['login']);
            Session::set('id_usuario', $row['id_usuario']);
            Session::set('tiempo', time());
            
            echo $this->_view->getMenu();
       
        
    }
    
    public function usuario()
    {

     echo json_encode($this->_login->traerid_enc(Session::get('id_usuario'))); 
    }


}

?>
