<?php


class admin_serviciosController extends Controller
{
	
	private $_index;
    public function __construct() {
        parent::__construct();
  	 $this->_index=$this->loadModel('admin_servicios');	
      
    }

    public function index()
    {


			
			$this->_view->setJs(array('principal'));
			$this->_view->setCss(array('css','style'));
        	$this->_view->titulo = 'Pedido/Servicio - COTEDEM';

        	$servicios=$this->_index->buscar_servicios_admin();
            $servicio_r=$this->_index->buscar_servicios_admin_solucionados();
        	
        	$this->_view->servicio_r=$servicio_r;
            $this->_view->servicio=$servicios;
			$this->_view->renderizar('index');

							
			
	}

	function registrar_servicio(){
       $this->_index->registrar_servicio($_POST);
    }


    function buscar_servicio_usuario(){
       echo json_encode( $this->_index->buscar_servicio_usuario($_POST['servicio']));
    }


    function cambiar_estatus_servicio(){
       $this->_index->cambiar_estatus_servicio($_POST);
    }



	function buscar_servicio_solucionado(){
       echo json_encode( $this->_index->buscar_servicio_solucionado($_POST['servicio']));
    }
	
}


?>