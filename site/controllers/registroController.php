<?php

class registroController extends Controller
{
    private $_registro;
    
    public function __construct() {

      Session::acceso();
        parent::__construct();
        
        $this->_registro = $this->loadModel('registro');
    }
    
    public function index(){


 
       $this->_view->titulo = 'Registro - OrienteX';
      // $this->_view->setJs(array(''));
       $this->_view->setCss(array('router'));
        
       
       $this->_view->renderizar('router');


    }

 public function agencias()

{
		
	     
       $this->_view->titulo = 'Registro Agencias - OrienteX';
       $this->_view->setJs(array('js','validate_agencia'));
       $this->_view->setCss(array('index'));
        
       
       $this->_view->renderizar('agencias');
     
}
public function nenas()
{
	
		//$this->_view->area_r="apagada";           
     ;	
         $this->_view->titulo = 'Registrar - OrienteX';
       	 $this->_view->setJs(array('rne','validate_nenas'));
     	 $this->_view->setCss(array('index'));
      	 $rs=$this->_registro->get_agencias();

         $this->_view->agencias = $rs;
       
       	 $this->_view->renderizar('nenas');
     
}

public function guardar_publicacion()
{
	

	 $this->_registro->guardar_publicacion($_POST,$_FILES);
               
     $this->redireccionar('registro/nenas');
     
}

public function guardar_agencia()
{
	

	 $this->_registro->guardar_agencia($_POST,$_FILES);
               
     $this->redireccionar('registro/agencias');
     
}











}

?>
