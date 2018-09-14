<?php

class inaController extends Controller
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
       
        $this->_view->titulo = 'OrienteX';
       	//$this->_view->setJs(array('js','validate'));
        $this->_view->setJs(array('index','flipcountdown'));
        $this->_view->setCss(array('index','flipcountdown'));
        
          $this->app= $this->loadModel('app');
       if($this->app->bloqueo()==true){
        $this->_view->renderizar('index');
       
       }else{
       
       $this->redireccionar();

       }
     
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
