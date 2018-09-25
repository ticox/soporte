<?php


class principalController extends Controller
{
	
	private $_index;
    public function __construct() {
        parent::__construct();
  	 $this->_index=$this->loadModel('principal');	
      
    }

    public function index()
    {

			if(!Session::get('autenticado')){
            $this->redireccionar('login');
        }
			
			$this->_view->setJs(array('principal','jquery.montage'));
			$this->_view->setCss(array('css','style'));
        	$this->_view->titulo = 'Inicio';
        	
        	
			$this->_view->renderizar('index');
							
			
	}

	
	
}


?>