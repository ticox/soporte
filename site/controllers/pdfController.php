<?php

class pdfController extends Controller
{
    private $_pdf;
	private $_alumno;
    public function __construct() {
        parent::__construct();
        $this->getLibrary('fpdf');
		$this->modelo=$this->loadModel('supervisor');
		
        $this->_pdf = new fpdf;
    }
    
    public function index(){}
	
    public function Reporte_x_empresa()
    {
    		$this->_view->titulo = 'Reporte de solicitudes';
			
			//$this->modelo->buscar_servicios_admin_solucionados_reporte();
			//print_r($this->modelo);
			if($_POST['fecha1']=='' && $_POST['fecha2']=='' ){

    		$this->modelo->buscar_servicios_admin_solucionados_reporte();

    	}


    	if($_POST['fecha1']!='' && $_POST['fecha2']!='' ){

    		$this->modelo->buscar_x_fecha_reporte($_POST['fecha1'],$_POST['fecha2']);

    	}
  
			
			//$this->_pdf = new fpdf('L','mm','A4');
			$this->_pdf->AddPage();
			$this->_pdf->SetFont('Arial','B',12);

			$this->_pdf->SetFont('Arial','B',8);
			$this->_pdf->Cell(($this->_pdf->w)-20,8, utf8_decode('REPORTE DE SOLICITUDES DE '. session::get('empresa')),0,1,'C');
			$this->_pdf->Ln(5);
			$this->_pdf->SetFont('Arial','',6);

			$this->_pdf->Cell(40,4, utf8_decode('USUARIO'),1,0,'C');
			$this->_pdf->Cell(65,4, utf8_decode('SERVICIO'),1,0,'C');
			$this->_pdf->Cell(40,4, utf8_decode('FECHA DE ATENCIÓN'),1,0,'C');
			$this->_pdf->Cell(25,4, utf8_decode('HORA ATENCIÓN'),1,0,'C');
			$this->_pdf->Cell(20,4, utf8_decode('DURACIÓN'),1,1,'C');
			$total_horas_de_servicio=0;
			for ($i=0; $i < count($this->modelo->datoss) ; $i++) { 

				$horaini = $this->modelo->datoss[$i]['hora_inicio'];
						$horafin = $this->modelo->datoss[$i]['hora_solucion'];

			//$newDate = date("D d/m/Y", strtotime($this->modelo->datoss[$i]['fecha_inicio']));	
			
			// En windows
			//setlocale(LC_TIME, 'spanish');
			setlocale(LC_TIME, 'es_ES.UTF-8');
			$newDate=strftime("%A, %d de %B de %Y", strtotime($this->modelo->datoss[$i]['fecha_inicio']));
			
			/*setlocale(LC_TIME, 'es_CO.UTF-8');
			$date = date_create($this->modelo->datoss[$i]['fecha_inicio']);
			$ = strftime("%A, %d %B %G", strtotime($date->date));*/
// Imprime mi�rcoles, 08 de marzo del 2017
					$horai=substr($horaini,0,2);

					$mini=substr($horaini,3,2);

					$segi=substr($horaini,6,2);

				 

					$horaf=substr($horafin,0,2);

					$minf=substr($horafin,3,2);

					$segf=substr($horafin,6,2);

				 

					$ini=((($horai*60)*60)+($mini*60)+$segi);

					$fin=((($horaf*60)*60)+($minf*60)+$segf);

				 

					$dif=$fin-$ini;

				 

					$difh=floor($dif/3600);

					$difm=floor(($dif-($difh*3600))/60);

					$difs=$dif-($difm*60)-($difh*3600);

					$duracion = date("H:i:s",mktime($difh,$difm,$difs));
				
			$this->_pdf->Cell(40,4, utf8_decode($this->modelo->datoss[$i]['nombre'].' '.$this->modelo->datoss[$i]['apellido']),1,0,'L');
			$this->_pdf->Cell(65,4, utf8_decode(substr($this->modelo->datoss[$i]['pedido'], 0, 60).' ...'),1,0,'L');
			$this->_pdf->Cell(40,4, utf8_decode($newDate),1,0,'L');
			$this->_pdf->Cell(25,4, utf8_decode($this->modelo->datoss[$i]['hora_inicio'].' - '.$this->modelo->datoss[$i]['hora_solucion']),1,0,'L');
			$this->_pdf->Cell(20,4, utf8_decode($duracion),1,1,'L');



			}
			//$this->_pdf->Cell(20,4, utf8_decode($total_horas_de_servicio),1,1,'L');

			
			$this->_pdf->Output();
	}
	
	public function Reporte_x_empresa_s()
    {
    		$this->_view->titulo = 'Reporte de solicitudes';
			
			//$this->modelo->buscar_servicios_admin_solucionados_reporte();
			//print_r($this->modelo);
			

    		$this->modelo->buscar_servicios_admin_solucionados_reporte();

    	


    	  
			
			$this->_pdf = new fpdf('L','mm','A4');
			$this->_pdf->AddPage();
			$this->_pdf->SetFont('Arial','B',12);

			$this->_pdf->SetFont('Arial','B',8);
			$this->_pdf->Cell(($this->_pdf->w)-20,8, utf8_decode('REPORTE DE SOLICITUDES DE '. session::get('empresa')),0,1,'C');
			$this->_pdf->Ln(5);
			$this->_pdf->SetFont('Arial','',6);

			$this->_pdf->Cell(35,4, utf8_decode('USUARIO'),1,0,'C');
			$this->_pdf->Cell(65,4, utf8_decode('SERVICIO'),1,0,'C');
			$this->_pdf->Cell(40,4, utf8_decode('FECHA DE ATENCIÓN'),1,0,'C');
			$this->_pdf->Cell(30,4, utf8_decode('HORAS DE SOLUCION:'),1,0,'C');
			$this->_pdf->Cell(30,4, utf8_decode('DURACIÓN'),1,0,'C');
			$this->_pdf->MultiCell(65, 4, utf8_decode('OBSERVACION/SOLUCION'),1,'C',0);
			//$this->_pdf->SetY(31); /* Set 20 Eje Y */
			//$this->_pdf->SetX(70); /* Set 20 Eje Y */
			
			//$this->_pdf->Cell(25,4, utf8_decode('HORA ATENCIÓN'),1,0,'C');
			//$this->_pdf->Cell(20,4, utf8_decode('DURACIÓN'),1,1,'C');
			$total_horas_de_servicio=0;
			for ($i=0; $i < count($this->modelo->datoss) ; $i++) { 

				$horaini = $this->modelo->datoss[$i]['hora_inicio'];
						$horafin = $this->modelo->datoss[$i]['hora_solucion'];

			//$newDate = date("D d/m/Y", strtotime($this->modelo->datoss[$i]['fecha_inicio']));	
			
			// En windows
			//setlocale(LC_TIME, 'spanish');
			setlocale(LC_TIME, 'es_ES.UTF-8');
			$newDate=strftime("%A, %d de %B de %Y", strtotime($this->modelo->datoss[$i]['fecha_inicio']));
			
			/*setlocale(LC_TIME, 'es_CO.UTF-8');
			$date = date_create($this->modelo->datoss[$i]['fecha_inicio']);
			$ = strftime("%A, %d %B %G", strtotime($date->date));*/
// Imprime mi�rcoles, 08 de marzo del 2017
					$horai=substr($horaini,0,2);

					$mini=substr($horaini,3,2);

					$segi=substr($horaini,6,2);

				 

					$horaf=substr($horafin,0,2);

					$minf=substr($horafin,3,2);

					$segf=substr($horafin,6,2);

				 

					$ini=((($horai*60)*60)+($mini*60)+$segi);

					$fin=((($horaf*60)*60)+($minf*60)+$segf);

				 

					$dif=$fin-$ini;

				 

					$difh=floor($dif/3600);

					$difm=floor(($dif-($difh*3600))/60);

					$difs=$dif-($difm*60)-($difh*3600);

					$duracion = date("H:i:s",mktime($difh,$difm,$difs));
				
			$this->_pdf->Cell(35,4, utf8_decode($this->modelo->datoss[$i]['nombre'].' '.$this->modelo->datoss[$i]['apellido']),1,0,'L');
			$this->_pdf->Cell(65,4, utf8_decode(substr($this->modelo->datoss[$i]['pedido'], 0, 60).' ...'),1,0,'L');
			$this->_pdf->Cell(40,4, utf8_decode($newDate),1,0,'L');
			$this->_pdf->Cell(30,4, utf8_decode($this->modelo->datoss[$i]['hora_inicio'].' - '.$this->modelo->datoss[$i]['hora_solucion']),1,0,'L'); 
			$this->_pdf->Cell(30,4, utf8_decode($duracion),1,0,'L');
			$this->_pdf->MultiCell(65,4, utf8_decode($this->modelo->datoss[$i]['observacion']),1);
			
			//$this->_pdf->Cell(25,4, utf8_decode($this->modelo->datoss[$i]['hora_inicio'].' - '.$this->modelo->datoss[$i]['hora_solucion']),1,0,'L');
			//$this->_pdf->Cell(20,4, utf8_decode($duracion),1,1,'L');


			}
			//$this->_pdf->Cell(20,4, utf8_decode($total_horas_de_servicio),1,1,'L');

			
			$this->_pdf->Output();
	}

public function reporte_detallado()
    {
    		$this->_view->titulo = 'Reporte de solicitudes';
			
			//$this->modelo->buscar_servicios_admin_solucionados_reporte();
			//print_r($this->modelo);
			
$this->detalles=$this->loadModel('admin_servicios');
    		$this->detalles->buscar_servicio_solucionado_reporte($_GET['id']);

    	


    	  
			setlocale(LC_TIME, 'es_ES.UTF-8');
			$newDate=strftime("%A, %d de %B de %Y", strtotime($this->detalles->datoss['fecha_inicio']));
			
			$this->_pdf->AddPage();
			$this->_pdf->SetFont('Arial','B',12);

			$this->_pdf->SetFont('Arial','B',8);
			$this->_pdf->Cell(($this->_pdf->w)-20,8, utf8_decode('REPORTE DE DETALLADO'),0,1,'C');
			$this->_pdf->Ln(5);
			$this->_pdf->SetFont('Arial','',6);

			$this->_pdf->Cell(35,4, utf8_decode('USUARIO'),1,0,'C');
			$this->_pdf->Cell(65,4, utf8_decode('SERVICIO'),1,0,'C');
			$this->_pdf->Cell(40,4, utf8_decode('FECHA DE SOLICITUD'),1,0,'C');
			$this->_pdf->Cell(40,4, utf8_decode('HORA DE SOLICITUD'),1,1,'C');
			$this->_pdf->Cell(35,4, utf8_decode($this->detalles->datoss['nombre'].' '.$this->detalles->datoss['apellido']),1,0,'L');
			$this->_pdf->Cell(65,4, utf8_decode(substr($this->detalles->datoss['pedido'], 0, 60).' ...'),1,0,'L');
			$this->_pdf->Cell(40,4, utf8_decode($newDate),1,0,'L');
			$this->_pdf->Cell(40,4, utf8_decode('HORASSSSSS'),1,1,'L');
			$this->_pdf->Cell(35,4, utf8_decode('MANT. SOFTWARE'),1,0,'C');
			$this->_pdf->Cell(65,4, utf8_decode('MANT. HARDWARE'),1,0,'C');
			$this->_pdf->Cell(40,4, utf8_decode('PRUEB. FUNCIONAMIENTO'),1,0,'C');
			$this->_pdf->Cell(40,4, utf8_decode('OTROS'),1,1,'C');
			$this->_pdf->Cell(35,4, utf8_decode('SI'),1,0,'C');
			$this->_pdf->Cell(65,4, utf8_decode('SI'),1,0,'C');
			$this->_pdf->Cell(40,4, utf8_decode('SI'),1,0,'C');
			$this->_pdf->Cell(40,4, utf8_decode('SI'),1,1,'C');

			$this->_pdf->MultiCell(180, 4, utf8_decode('OBSERVACION/SOLUCION'),1,'C',0);
			//$this->_pdf->SetY(31); /* Set 20 Eje Y */
			//$this->_pdf->SetX(70); /* Set 20 Eje Y */
			
			//$this->_pdf->Cell(25,4, utf8_decode('HORA ATENCIÓN'),1,0,'C');
			//$this->_pdf->Cell(20,4, utf8_decode('DURACIÓN'),1,1,'C');
			$total_horas_de_servicio=0;

				$horaini = $this->detalles->datoss['hora_inicio'];
						$horafin = $this->detalles->datoss['hora_solucion'];
			
			// En windows
			//setlocale(LC_TIME, 'spanish');
			
			
			
					$horai=substr($horaini,0,2);

					$mini=substr($horaini,3,2);

					$segi=substr($horaini,6,2);

				 

					$horaf=substr($horafin,0,2);

					$minf=substr($horafin,3,2);

					$segf=substr($horafin,6,2);

				 

					$ini=((($horai*60)*60)+($mini*60)+$segi);

					$fin=((($horaf*60)*60)+($minf*60)+$segf);

				 

					$dif=$fin-$ini;

				 

					$difh=floor($dif/3600);

					$difm=floor(($dif-($difh*3600))/60);

					$difs=$dif-($difm*60)-($difh*3600);

					$duracion = date("H:i:s",mktime($difh,$difm,$difs));
				
			$this->_pdf->MultiCell(180,4, utf8_decode($this->detalles->datoss['observacion']),1);

			$this->_pdf->Cell(65,4, utf8_decode('FECHA INICIO'),1,0,'C');
			$this->_pdf->Cell(40,4, utf8_decode('HORA SOLUCION'),1,0,'C');
			$this->_pdf->Cell(40,4, utf8_decode('DURACION'),1,1,'C');
			
			//$this->_pdf->Cell(25,4, utf8_decode($this->modelo->datoss[$i]['hora_inicio'].' - '.$this->modelo->datoss[$i]['hora_solucion']),1,0,'L');
			//$this->_pdf->Cell(20,4, utf8_decode($duracion),1,1,'L');


			
			//$this->_pdf->Cell(20,4, utf8_decode($total_horas_de_servicio),1,1,'L');

			
			$this->_pdf->Output();
	}


	public function reporte_detallado2()
    {
    		$this->_view->titulo = 'Reporte de solicitudes';
			
			//$this->modelo->buscar_servicios_admin_solucionados_reporte();
			//print_r($this->modelo);
			
$this->detalles=$this->loadModel('admin_servicios');
    		$this->detalles->buscar_servicio_solucionado_reporte($_GET['id']);

    	


    	  
			setlocale(LC_TIME, 'es_ES.UTF-8');
			$newDate=strftime("%A, %d de %B de %Y", strtotime($this->detalles->datoss['fecha_inicio']));
			$fecha_solicitud=strftime("%A, %d de %B de %Y", strtotime($this->detalles->datoss['fecha']));


				$horaini = $this->detalles->datoss['hora_inicio'];
						$horafin = $this->detalles->datoss['hora_solucion'];
			
			// En windows
			//setlocale(LC_TIME, 'spanish');
			
			
			
					$horai=substr($horaini,0,2);

					$mini=substr($horaini,3,2);

					$segi=substr($horaini,6,2);

				 

					$horaf=substr($horafin,0,2);

					$minf=substr($horafin,3,2);

					$segf=substr($horafin,6,2);

				 

					$ini=((($horai*60)*60)+($mini*60)+$segi);

					$fin=((($horaf*60)*60)+($minf*60)+$segf);

				 

					$dif=$fin-$ini;

				 

					$difh=floor($dif/3600);

					$difm=floor(($dif-($difh*3600))/60);

					$difs=$dif-($difm*60)-($difh*3600);

					$duracion = date("H:i:s",mktime($difh,$difm,$difs));
			
			$this->_pdf->AddPage();
			$this->_pdf->SetFont('Arial','B',12);

			$this->_pdf->SetFont('Arial','B',8);
			$this->_pdf->Cell(($this->_pdf->w)-20,8, utf8_decode('REPORTE DETALLADO DE SOLICITUD'),0,1,'C');
			$this->_pdf->Ln(5);
			$this->_pdf->SetFont('Arial','',6);

			$this->_pdf->Cell(60,4, utf8_decode('USUARIO: '.$this->detalles->datoss['nombre'].' '.$this->detalles->datoss['apellido']),0,0,'C');
			$this->_pdf->Cell(60,4, utf8_decode('FECHA DE SOLICITUD: '.$fecha_solicitud),0,0,'C');
			$this->_pdf->Cell(60,4, utf8_decode('HORA DE SOLICITUD: '.$this->detalles->datoss['hora']),0,1,'C');
			//$this->_pdf->SetY(31); /* Set 20 Eje Y */
			$this->_pdf->SetY(40); /* Set 20 Eje Y */
			$this->_pdf->Cell(180,4, utf8_decode('SERVICIO REQUERIDO:'),0,1,'L');
			$this->_pdf->Cell(180,4, utf8_decode($this->detalles->datoss['pedido']),0,1,'L');
			$this->_pdf->SetY(60); /* Set 20 Eje Y */
			$this->_pdf->Cell(180,4, utf8_decode('INFORMACION ADICIONAL:'),0,1,'L');
			$this->_pdf->Cell(50,4, utf8_decode('MANTENIMIENTO DE SOFTWARE:'),0,0,'C');
			$this->_pdf->Cell(50,4, utf8_decode('MANTENIMIENTO DE HARDWARE:'),0,0,'C');
			$this->_pdf->Cell(50,4, utf8_decode('PRUEBAS DE FUNCIONAMIENTO'),0,0,'C');
			$this->_pdf->Cell(50,4, utf8_decode('OTROS'),0,1,'C');
			$this->_pdf->Cell(50,4, utf8_decode('SI'),0,0,'C');
			$this->_pdf->Cell(50,4, utf8_decode('SI'),0,0,'C');
			$this->_pdf->Cell(50,4, utf8_decode('SI'),0,0,'C');
			$this->_pdf->Cell(50,4, utf8_decode('SI'),0,1,'C');
			$this->_pdf->SetY(80); /* Set 20 Eje Y */
			$this->_pdf->Cell(180,4, utf8_decode('SOLUCION / OBSERVACION / ACTIVIDAD:'),0,1,'L');
			$this->_pdf->MultiCell(180,4, utf8_decode($this->detalles->datoss['observacion']),0);
			$this->_pdf->Cell(60,4, utf8_decode('FECHA DE SOLUCION: '.$newDate),0,0,'C');
			$this->_pdf->Cell(60,4, utf8_decode('HORAS DE SOLUCION: '.$this->detalles->datoss['hora_inicio'].' - '.$this->detalles->datoss['hora_solucion'] ),0,0,'C');
			$this->_pdf->Cell(60,4, utf8_decode('DURACION: '.$duracion),0,1,'C');
			
			//$this->_pdf->SetY(31); /* Set 20 Eje Y */
			//$this->_pdf->SetX(70); /* Set 20 Eje Y */
			
			//$this->_pdf->Cell(25,4, utf8_decode('HORA ATENCIÓN'),1,0,'C');
			//$this->_pdf->Cell(20,4, utf8_decode('DURACIÓN'),1,1,'C');
			$total_horas_de_servicio=0;
			
			//$this->_pdf->Cell(25,4, utf8_decode($this->modelo->datoss[$i]['hora_inicio'].' - '.$this->modelo->datoss[$i]['hora_solucion']),1,0,'L');
			//$this->_pdf->Cell(20,4, utf8_decode($duracion),1,1,'L');


			
			//$this->_pdf->Cell(20,4, utf8_decode($total_horas_de_servicio),1,1,'L');

			
			$this->_pdf->Output();
	}
	
	

}

?>
