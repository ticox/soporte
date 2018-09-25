<?php

class cambiarController extends Controller
{
    private $_xx;
    public $_usuario;
    
    public function __construct(){
        parent::__construct();
        $this->_xx = $this->loadModel('cambiar');
    }
    
   
   public function index()
    {
if(!Session::get('autenticado')){
            $this->redireccionar('login');
        }
    
        $this->_view->usu = Session::get('usuario');   
        $this->_view->titulo = 'Cambiar contraseña - OrienteX';
        $this->_view->setJs(array('cambiar'));
        
       $this->_view->renderizar('index', 'cambiar');

    }

   /* public function cambiar(){
		 
		  if(!Session::get('autenticado')){
            $this->redireccionar();
			}
		$_usuario=$this->_view->usu = Session::get('usuario');

        $this->_view->titulo = 'Cambiar Contraseña';
         $this->_view->setJs(array('recuperar'));
         $this->_view->renderizar('cambiar', 'recuperar');
    } */
   
  

  public function cambiarclave(){


    $this->_xx->cambiar_clave($_POST['nueva'],session::get('usuario'));


   }
 public function actualizarclave(){



    $this->_xx->actualizar_clave($_POST['nueva'],$_POST['login']);


   }

     public function buscarusuario(){


     echo json_encode ($this->_xx->buscar_usuario($_POST['actual'],Session::get('usuario')));


   }
   
}

?>
