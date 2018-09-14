<?php

class legalController extends Controller
{
    private $_aviso;
    
    public function __construct() {
        parent::__construct();
        
        //$this->_aviso = $this->loadModel('aviso');
    }
    
    public function index()
{

       
        $this->_view->titulo = 'Aviso legal - OrienteX';
       
        $this->_view->setJs(array('index'));
        $this->_view->setCss(array('index'));

        $this->_view->renderizar('index');
 
     
}




}

?>
