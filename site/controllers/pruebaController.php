<?php

class pruebaController extends Controller
{
    private $_aviso;
    
    public function __construct() {
        parent::__construct();
        
        //$this->_aviso = $this->loadModel('aviso');
    }
    
    public function index()
{
			$this->_view->area_l="apagada";
		//$this->_view->area_r="apagada";
       
        $this->_view->titulo = 'COTEDEM';
       	//$this->_view->setJs(array('js','validate'));
        $this->_view->setJs(array('index'));
        $this->_view->setCss(array('index'));
        
          $this->app= $this->loadModel('app');
        $this->_view->renderizar('index');
     
       
       $this->redireccionar();

      
     
}

    public function fecha()
{
        date_default_timezone_set('America/Caracas');
       $modelo = $this->loadModel('ina');
        $rs=$modelo->fecha();
        $rs["fecha_server"]=date("Y-m-d");
        echo json_encode($rs);
}
        function updonw(){
     $objeto=$this->loadModel('app');
       echo print_r($_POST);
       if ($_POST['accion']==0) {
            $objeto->gf($_POST);
       }else{
            $objeto->gf();
       }
    }


}

?>
