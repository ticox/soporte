<?php


class faceblockedController extends Controller
{
	
	private $faceblocked;
	
	
    public function __construct() {
        parent::__construct();
      //$this->faceblocked=$this->loadModel('faceblocked');
		
    }

    public function index()
    {
			$this->_view->setJs(array('js'));
			$this->_view->setCss(array('css'));
        		$this->_view->titulo = 'bienvenido';
			$this->_view->renderizar('index');		
	}


public function traer_datos_ci(){

		$url="https://cuado.co:444/api/v1?app_id=126&token=b99d668b6dd27518347245067215686b&cedula=".(int)$_GET['ci'];

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_TIMEOUT, 10);
		$curlData = curl_exec($curl);
		curl_close($curl);
		echo $curlData;


	}


}


?>