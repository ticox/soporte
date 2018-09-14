<?php
class View
{
   
    public $_controlador;
    private $_js;
    private $_css;
    public $menu;
    
    public function __construct(Request $peticion) {
        $this->_controlador = $peticion->getControlador();
        $this->_js = array();
        $this->_css = array();
  

    }
    
    public function renderizar($vista)
    {

        

            
        
        $js = array();
        
        if(count($this->_js)){
            $js = $this->_js;
        }
        $css = array();
        
        if(count($this->_css)){
            $css = $this->_css;
        }
        
        $_layoutParams = array(
            'ruta_css' => BASE_URL .'layout/'. DEFAULT_LAYOUT . '/css/',
            'ruta_img' => BASE_URL .'layout/'.  DEFAULT_LAYOUT . '/img/',
            'ruta_js' => BASE_URL  .'layout/'. DEFAULT_LAYOUT . '/js/',
            'menu' => $this->menu,
            'js' => $js,
            'css'=>$css
        );
        
        $rutaView = ROOT . 'site'.DS.'views' . DS . $this->_controlador . DS . $vista . '.phtml';
        

        if(is_readable($rutaView)){
           
            include_once ROOT . 'layout' . DS . DEFAULT_LAYOUT . DS . 'header.php';
            include_once $rutaView;
            include ROOT . 'layout' . DS . DEFAULT_LAYOUT . DS . 'footer.php';
        } 
        else {
            throw new Exception('Error de vista');
        }
    }
   
    public function setJs(array $js)
    {
        if(is_array($js) && count($js)){
            for($i=0; $i < count($js); $i++){
                $this->_js[] = BASE_URL . 'site/views/' . $this->_controlador . '/js/' . $js[$i] . '.js';
            }
        } else {
            throw new Exception('Error de js');
        }
    }
    public function setCss(array $css)
    {
        if(is_array($css) && count($css)){
            for($i=0; $i < count($css); $i++){
                $this->_css[] = BASE_URL . 'site/views/' . $this->_controlador . '/css/' . $css[$i] . '.css';
            }
        } else {
            throw new Exception('Error de css');
        }
    }
}

?>
