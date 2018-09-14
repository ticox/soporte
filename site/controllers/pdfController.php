<?php

class pdfController extends Controller
{
    private $_pdf;
	private $_alumno;
    public function __construct() {
        parent::__construct();
        $this->getLibrary('fpdf');
		$this->_orden_de_pago=$this->loadModel('orden_de_pago');
		$this->_proveedor=$this->loadModel('proveedor');
		$this->_banco=$this->loadModel('banco');
		$this->includeModel('pago');
		$this->includeModel('transferencia');
		$this->includeModel('cheque');
		$this->includeModel('chequera');
		$this->includeModel('factura');
		$this->includeModel('retencion');
		$this->includeModel('descuento');
				
        $this->_pdf = new fpdf;
    }
    
    public function index(){}
	public function abonos_orden_de_pago($id_factura,$id_orden_de_pago){
		$array_orden=array();
		$array = orden_de_pagoModel::traer_ordenes_de_pago_por_id_factura($id_factura,$id_orden_de_pago);
		for ($i=0; $i < count($array) ; $i++) { 
			$xx= new orden_de_pagoModel;
			$xx->cargar_bd($array[$i]['id_orden_de_pago']);   
			$array_orden[]=$xx;
		}       
		return $array_orden;
	}
    public function generar_orden($id_factura,$rif,$id_orden){

			$factura= new factura;

			$factura->cargar_bd($id_factura);

			$this->_proveedor->_factura=$factura;

			$this->_proveedor->cargar_bd_rif($rif);

			$this->_orden_de_pago->cargar_bd($id_orden);

			//print_r($this->_orden_de_pago);

			$this->_pdf->AddPage();
			$this->_pdf->SetFont('Arial','B',12);


			$this->_pdf->SetFont('Arial','B',12);
			$this->_pdf->Cell(190,8, utf8_decode('orden de pago'),0,1,'C');
			$this->_pdf->Ln(15);
			$this->_pdf->SetFont('Arial','',10);
			$this->_pdf->Cell(63,4, utf8_decode('numero de orden : '.$this->_orden_de_pago->_id ),0,0,'C');
			$this->_pdf->Cell(62,4, utf8_decode('fecha de emicion : '.$this->_orden_de_pago->_fecha_emicion ),0,0,'C');
			$this->_pdf->Cell(62,4, utf8_decode('numero de factura : '.$this->_proveedor->_factura->_id ),0,1,'C');
			$this->_pdf->SetFont('Arial','B',12);
			$this->_pdf->Ln(8);
			$this->_pdf->Cell(190,4, utf8_decode("datos de proveedor"),0,1,'C');
			$this->_pdf->Ln(8);
			$this->_pdf->SetFont('Arial','',8);
			$this->_pdf->Cell(40,4, utf8_decode('nombre  '),0,0,'L');
			$this->_pdf->Cell(40,4, utf8_decode(': '.$this->_proveedor->_nombre ),0,1,'L');
			$this->_pdf->Cell(40,4, utf8_decode('beneficiario  '),0,0,'L');
			$this->_pdf->Cell(40,4, utf8_decode(': '.$this->_proveedor->_beneficiario ),0,1,'L');
			$this->_pdf->Cell(40,4, utf8_decode('Rif  '),0,0,'L');
			$this->_pdf->Cell(40,4, utf8_decode(': '.$this->_proveedor->_rif ),0,1,'L');		
			$this->_pdf->Cell(40,4, utf8_decode('contacto  '),0,0,'L');
			$this->_pdf->Cell(40,4, utf8_decode(': '.$this->_proveedor->_contacto ),0,1,'L');
			$this->_pdf->Cell(40,4, utf8_decode('direccion  '),0,0,'L');
			$this->_pdf->Cell(40,4, utf8_decode(': '.$this->_proveedor->_direccion ),0,1,'L');
			$this->_pdf->Cell(40,4, utf8_decode('tipo de cretito  '),0,0,'L');
			$this->_pdf->Cell(40,4, utf8_decode(': '.$this->_proveedor->_tipo_credito ),0,1,'L');
			$this->_pdf->Cell(40,4, utf8_decode('porcentaje de retencion  '),0,0,'L');
			$this->_pdf->Cell(40,4, utf8_decode(': '.$this->_proveedor->_porcentaje_retencion."%" ),0,1,'L');
			$this->_pdf->Cell(40,4, utf8_decode('telefono  '),0,0,'L');
			$this->_pdf->Cell(40,4, utf8_decode(': '.$this->_proveedor->_tlf ),0,1,'L');

			$this->_pdf->SetFont('Arial','B',12);
			$this->_pdf->Ln(8);
			$this->_pdf->Cell(190,4, utf8_decode("detalles de la factura"),0,1,'C');
			$this->_pdf->Ln(8);
			$this->_pdf->SetFont('Arial','',8);

			$this->_pdf->Cell(52,4, utf8_decode('nro de control  '),0,0,'L');
			$this->_pdf->Cell(52,4, utf8_decode('elavoracion  '),0,0,'L');
			$this->_pdf->Cell(43,4, utf8_decode('recepcion  '),0,0,'L');
			$this->_pdf->Cell(43,4, utf8_decode('vence  '),0,1,'L');
			$this->_pdf->Cell(52,4, utf8_decode($this->_proveedor->_factura->_nro_control),0,0,'L');
			$this->_pdf->Cell(52,4, utf8_decode($this->_proveedor->_factura->_fecha_elavoracion),0,0,'L');
			$this->_pdf->Cell(43,4, utf8_decode($this->_proveedor->_factura->_fecha_recepcion),0,0,'L');
			$this->_pdf->Cell(43,4, utf8_decode($this->_proveedor->_factura->_fecha_vencimiento),0,1,'L');
			$this->_pdf->Ln(8);

			$this->_pdf->Cell(26,4, utf8_decode('cantidad  '),0,0,'L');
			$this->_pdf->Cell(26,4, utf8_decode('descuento  '),0,0,'L');
			$this->_pdf->Cell(26,4, utf8_decode('sub total  '),0,0,'L');
			$this->_pdf->Cell(26,4, utf8_decode('iva  '),0,0,'L');
			$this->_pdf->Cell(26,4, utf8_decode('total  '),0,0,'L');
			$this->_pdf->Cell(26,4, utf8_decode('ret. iva  '),0,0,'L');
			$this->_pdf->Cell(26,4, utf8_decode('neto a pagar  '),0,1,'L');
			$this->_pdf->Cell(26,4, utf8_decode($this->_proveedor->_factura->_monto),0,0,'L');
			$this->_pdf->Cell(26,4, utf8_decode($this->_proveedor->_factura->_descuento),0,0,'L');
			$this->_pdf->Cell(26,4, utf8_decode($this->_proveedor->_factura->_sub_total),0,0,'L');
			$this->_pdf->Cell(26,4, utf8_decode(($this->_proveedor->_factura->_sub_total/100)*$this->_proveedor->_factura->_impuesto),0,0,'L');
			$this->_pdf->Cell(26,4, utf8_decode($this->_proveedor->_factura->_total),0,0,'L');
			$this->_pdf->Cell(26,4, utf8_decode($this->_proveedor->_factura->_retencion->_retencion),0,0,'L');
			$this->_pdf->Cell(26,4, utf8_decode(($this->_proveedor->_factura->_total)-($this->_proveedor->_factura->_retencion->_retencion)),0,0,'L');


			$this->_pdf->SetFont('Arial','B',12);


			$this->_pdf->Cell(190,4, utf8_decode('descuentos y datos bancarios'),0,1,'C');
			$this->_pdf->SetFont('Arial','',8);
			$this->_pdf->Ln(8);

			$this->_pdf->Cell(40,6, utf8_decode('pronto pago'),0,0,'L');
			$this->_pdf->Cell(40,6, utf8_decode('Bs'),1,1,'R');
			$this->_pdf->Ln(2);
			$this->_pdf->Cell(40,6, utf8_decode('pares dañados'),0,0,'L');
			$this->_pdf->Cell(40,6, utf8_decode('Bs'),1,1,'R');	
			$this->_pdf->Ln(2);	
			$this->_pdf->Cell(40,6, utf8_decode('pares faltantes'),0,0,'L');
			$this->_pdf->Cell(40,6, utf8_decode('Bs'),1,1,'R');
			$this->_pdf->Ln(2);
			$this->_pdf->Cell(40,6, utf8_decode('banco'),0,0,'L');
			$this->_pdf->Cell(40,6, utf8_decode(''),1,1,'R');
			$this->_pdf->Ln(2);
			$this->_pdf->Cell(40,6, utf8_decode('tipo de pago'),0,0,'L');
			$this->_pdf->Cell(40,6, utf8_decode(''),1,1,'R');
			$this->_pdf->Ln(2);
			$this->_pdf->Cell(40,6, utf8_decode('abono'),0,0,'L');
			$this->_pdf->Cell(40,6, utf8_decode('Bs'),1,1,'R');







			$this->_pdf->Output();
	}
	
	function completar_orden($orden){

		$this->_orden_de_pago->cargar_bd($orden);

		$this->_orden_de_pago->_abono=$this->abonos_orden_de_pago($this->_orden_de_pago->_factura->_id , $this->_orden_de_pago->_id);
		$this->_proveedor->cargar_bd($this->_orden_de_pago->_factura->_id_proveeodor);








		//print_r($this->_proveedor);
		//print_r($this->_orden_de_pago);

			$_pdf= new fpdf('L','mm','A4');

			$_pdf->AddPage();
			$_pdf->SetFont('Arial','B',10);
			$_pdf->ln(2);
			$_pdf->setx(70);
			$_pdf->Cell(40,6,"ORDEN DE PAGO",0,1,'L');
			$_pdf->SetFont('Arial','',6);
			$_pdf->setx(70);
			$_pdf->Cell(30,4,"DOCUMENTO",0,0,'L');
			$_pdf->Cell(2,4,":",0,0,'L');
			$_pdf->Cell(20,4,$this->_orden_de_pago->_id,0,1,'L');
			$_pdf->setx(70);
			$_pdf->Cell(30,4,"FECHA",0,0,'L');
			$_pdf->Cell(2,4,":",0,0,'L');
			$_pdf->Cell(20,4,date('d-m-Y'),0,1,'L');
			$_pdf->setx(70);
			$_pdf->Cell(30,4,"PROVEEDOR",0,0,'L');
			$_pdf->Cell(2,4,":",0,0,'L');
			$_pdf->Cell(20,4,$this->_proveedor->_nombre ,0,1,'L');
			$_pdf->setx(70);
			$_pdf->Cell(30,4,"R.I.F.",0,0,'L');
			$_pdf->Cell(2,4,":",0,0,'L');
			$_pdf->Cell(20,4,$this->_proveedor->_rif ,0,1,'L');
			$_pdf->setx(70);
			$_pdf->Cell(30,4,"BENEFICIARIO",0,0,'L');
			$_pdf->Cell(2,4,":",0,0,'L');
			$_pdf->Cell(20,4,$this->_proveedor->_beneficiario ,0,1,'L');
			$_pdf->ln(10);


			$columnas=$_pdf->w/15;

			$_pdf->line(10,60,($_pdf->w)-7,60);

			$_pdf->Cell(15,4,"VENCE" ,0,0,'C');
			$_pdf->Cell(12,4,"CODIGO" ,0,0,'C');
		
			$_pdf->Cell($columnas,4,"SUB-TOTAL" ,0,0,'C');
			$_pdf->Cell($columnas,4,"DESC" ,0,0,'C');
			$_pdf->Cell($columnas,4,"TOTAL DESC" ,0,0,'C');
			$_pdf->Cell($columnas,4,"GRAVADO" ,0,0,'C');
			$_pdf->Cell($columnas,4,"IVA" ,0,0,'C');
			$_pdf->Cell($columnas,4,"TOTAL" ,0,0,'C');
			$_pdf->Cell(15,4,"RET.IVA" ,0,0,'C');
			$_pdf->Cell($columnas,4,"desc proto pago" ,0,0,'C');
			$_pdf->Cell($columnas,4,utf8_decode("par dañado") ,0,0,'C');
			$_pdf->Cell($columnas,4,"par faltante " ,0,0,'C');
			$_pdf->Cell($columnas,4,"abono" ,0,0,'C');

			
			$_pdf->Cell($columnas,4,"A PAGAR" ,0,0,'C');
			$_pdf->Cell($columnas,4," PAGO" ,0,1,'C');
	
			if ($this->_orden_de_pago->_factura->_tipo_descuento=="1") {
				$t_d="%";
				$d_d=(((float)$this->_orden_de_pago->_factura->_monto)/100)*((float)$this->_orden_de_pago->_factura->_descuento);
			}else{
				$t_d="Bs";
				$d_d=(float)$this->_orden_de_pago->_factura->_descuento;
			}

			$iva=(float)(($this->_orden_de_pago->_factura->_monto-$d_d)/100)*$this->_orden_de_pago->_factura->_impuesto;
			$gravado=$this->_orden_de_pago->_factura->_monto-$d_d;
			$t=$gravado+$iva;

			$_pdf->ln(5);


			$_pdf->Cell(15,4,$this->_orden_de_pago->_factura->_fecha_vencimiento ,0,0,'L');
			$_pdf->Cell(12,4,$this->_orden_de_pago->_factura->_id ,0,0,'L');
			
			$_pdf->Cell($columnas,4,number_format($this->_orden_de_pago->_factura->_monto,2,',','.'),0,0,'R');
			$_pdf->Cell($columnas,4,$t_d." ".number_format($this->_orden_de_pago->_factura->_descuento,2,',','.'),0,0,'R');
			$_pdf->Cell($columnas,4,number_format($d_d,2,',','.'),0,0,'R');
			$_pdf->Cell($columnas,4,number_format($gravado,2,',','.'),0,0,'R') ;
			$_pdf->Cell($columnas,4,number_format($iva,2,',','.'),0,0,'R');
			$_pdf->Cell($columnas,4,number_format($t,2,',','.') ,0,0,'R');
			$_pdf->Cell(15,4,number_format($this->_orden_de_pago->_factura->_retencion->_retencion,2,',','.')  ,0,0,'R');

			$pago=0;

			for ($j=0; $j < count($this->_orden_de_pago->_abono) ; $j++) { 
				
			
			
			  	$pago+=$this->_orden_de_pago->_abono[$j]->_cheque->_cantidad;
			
		
				$pago+=$this->_orden_de_pago->_abono[$j]->_transferencia->_cantidad;
			

		}


			//print_r($this->_orden_de_pago->_factura->_descuentos);

			$acum_descuentos = 0;
			for ($i=0; $i < 3 ; $i++) { 

				$xx=0.00;

				if (!empty($this->_orden_de_pago->_factura->_descuentos[$i]->_cantidad)) {
					$_pdf->Cell($columnas,4,number_format($this->_orden_de_pago->_factura->_descuentos[$i]->_cantidad,2,',','.') ,0,0,'R');
					$acum_descuentos+=$this->_orden_de_pago->_factura->_descuentos[$i]->_cantidad;
				}else{
					$_pdf->Cell($columnas,4,number_format($xx,2,',','.') ,0,0,'R');
				}

				

			}

			$_pdf->Cell($columnas,4,number_format($pago,2,',','.') ,0,0,'R');




			$_pdf->Cell($columnas,4,number_format(((($t-$pago)-$this->_orden_de_pago->_factura->_retencion->_retencion)-$acum_descuentos),2,',','.') ,0,0,'R');

		$cant_pagar=0;
	
			$cant_pagar+=$this->_orden_de_pago->_transferencia->_cantidad;
		
	
			$cant_pagar+=$this->_orden_de_pago->_cheque->_cantidad;
		






			$_pdf->Cell($columnas,4, number_format($cant_pagar,2,",",".") ,0,0,'R');




			
	
		






			//$_pdf->Cell(40,6,,0,1,'L');
			$_pdf->setx(70);
			//$_pdf->Cell(40,6,,0,1,'L');



			$_pdf->Output();
	}

	function generar_pdf_proveedor(){

		if(!empty($_GET['rif'])){

		$this->banlance_cta_pagar_detallado($_GET['rif']);

		}else{

			$this->banlance_cta_pagar_general();
		}
	
	}





function banlance_cta_pagar_detallado($rif){

		$_pdf= new fpdf('L','mm','A4');
		$_pdf->AddPage();
		$_pdf->SetFont('Arial','B',12);
		$_pdf->Cell(0,4,"Balance de cuentas por pagar" ,0,1,'C');
		$_pdf->SetFont('Arial','B',7);
		$_pdf->ln(2);
		$_pdf->Cell(0,4,"fecha hasta   :   ".date("d/m/Y") ,0,0,'C');
		$_pdf->line(10,37,($_pdf->w)-7,37);
		$_pdf->ln(8);
		$columnas=$_pdf->w/15;
		$this->_proveedor->cargar_bd_rif($rif);
			$this->_proveedor->listar_facturas();
			//print_r($this->_proveedor);
			//print_r($this->_proveedor);
			$_pdf->Cell(15,4,"VENCE" ,0,0,'C');
			$_pdf->Cell(12,4,"CODIGO" ,0,0,'C');
			$_pdf->Cell($columnas,4,"SUB-TOTAL" ,0,0,'C');
			$_pdf->Cell($columnas,4,"DESC" ,0,0,'C');
			$_pdf->Cell($columnas,4,"TOTAL DESC" ,0,0,'C');
			$_pdf->Cell($columnas,4,"GRAVADO" ,0,0,'C');
			$_pdf->Cell($columnas,4,"IVA" ,0,0,'C');
			$_pdf->Cell($columnas,4,"TOTAL" ,0,0,'C');
			$_pdf->Cell(15,4,"RET.IVA" ,0,0,'C');
			$_pdf->Cell($columnas,4,"desc proto pago" ,0,0,'C');
			$_pdf->Cell($columnas,4,utf8_decode("par dañado") ,0,0,'C');
			$_pdf->Cell($columnas,4,"par faltante " ,0,0,'C');
			$_pdf->Cell($columnas,4,"abono" ,0,0,'C');
			
			$_pdf->Cell($columnas,4,"A PAGAR" ,0,1,'C');
			$_pdf->ln(2);
			$_pdf->Cell(0,4,$this->_proveedor->_id."   -   ".$this->_proveedor->_nombre,0,1,'L');

			$_x_grabado=0;
			$_x_t=0;
			$_x_iva=0;
			$_x_re_iva=0;
			$_x_d= array( "0" => 0 , "1" => 0, "2" => 0);
			$_x_abon=0;
			$_x_apagar=0;

			
				for ($i=0; $i < count($this->_proveedor->_factura); $i++):
					if($this->_proveedor->_factura[$i]->_estatus=="no cancelada"){
					$_pdf->Cell(15,4,$this->_proveedor->_factura[$i]->_fecha_vencimiento,0,0,'C');
					$_pdf->Cell(12,4,$this->_proveedor->_factura[$i]->_id ,0,0,'C');
					$_pdf->Cell($columnas,4,number_format($this->_proveedor->_factura[$i]->_monto,2,",",".") ,0,0,'R');

							if ($this->_proveedor->_factura[$i]->_tipo_descuento=="1") {
							$t_d="%";
							$d_d=(((float)$this->_proveedor->_factura[$i]->_monto)/100)*((float)$this->_proveedor->_factura[$i]->_descuento);
							}else{
							$t_d="Bs";
							$d_d=(float)$this->_proveedor->_factura[$i]->_descuento;
							}
							$iva=(float)(($this->_proveedor->_factura[$i]->_monto-$d_d)/100)*$this->_proveedor->_factura[$i]->_impuesto;
							$_x_iva+=$iva;
							$gravado=$this->_proveedor->_factura[$i]->_monto-$d_d;
							$_x_grabado+=$gravado;
							$t=$gravado+$iva;
							$_x_t+=$t;


							$_pdf->Cell($columnas,4,$t_d." ".number_format($this->_proveedor->_factura[$i]->_descuento,2,',','.'),0,0,'R');
					$_pdf->Cell($columnas,4,number_format($d_d,2,',','.'),0,0,'R');
					$_pdf->Cell($columnas,4,number_format($gravado,2,',','.'),0,0,'R') ;

					$_pdf->Cell($columnas,4,number_format($iva,2,',','.'),0,0,'R');
					$_pdf->Cell($columnas,4,number_format($t,2,',','.') ,0,0,'R');
					$_pdf->Cell(15,4,number_format($this->_proveedor->_factura[$i]->_retencion->_retencion,2,',','.')  ,0,0,'R');
					$_x_re_iva+=$this->_proveedor->_factura[$i]->_retencion->_retencion;

							$total_descuentos=0;
							for ($j=0; $j < 3 ; $j++) { 

							$xx=0.00;

							if (!empty($this->_proveedor->_factura[$i]->_descuentos[$j]->_cantidad)) {
							$total_descuentos+=$this->_proveedor->_factura[$i]->_descuentos[$j]->_cantidad;
							$_x_d[$j]+=$this->_proveedor->_factura[$i]->_descuentos[$j]->_cantidad;
							$_pdf->Cell($columnas,4,number_format($this->_proveedor->_factura[$i]->_descuentos[$j]->_cantidad,2,',','.') ,0,0,'R');
							}else{
							$_pdf->Cell($columnas,4,number_format($xx,2,',','.') ,0,0,'R');
							}



							}


							$ordenes=orden_de_pagoModel::traer_ordenes_de_pago_por_id_factura($this->_proveedor->_factura[$i]->_id,"547f8d");
							
							$abono=0;
							for ($v=0; $v < count($ordenes) ; $v++) { 

								$ordenn= new orden_de_pagoModel;

								$ordenn->cargar_bd($ordenes[$v]['id_orden_de_pago']);

								if(isset($ordenn->_cheque->_cantidad)){

									$abono+=$ordenn->_cheque->_cantidad;

								}
								if (isset($ordenn->_transferencia->_cantidad)) {
									$abono+=$ordenn->_transferencia->_cantidad;	
								}

								

							}
							$_x_abon+=$abono;
							
				
					$_pdf->Cell($columnas,4,number_format($abono,2,",",".") ,0,0,'R');


						$pendiente=((($t-$this->_proveedor->_factura[$i]->_retencion->_retencion) -$abono)-$total_descuentos);
						$_x_apagar+=$pendiente;
						$_pdf->Cell($columnas,4,number_format($pendiente,2,",","."),0,1,'R');

					
			
					}
				endfor;

			
		$_pdf->SetFont('Arial','B',7);
		$_pdf->ln();

		$_pdf->line(10,45+(count($this->_proveedor->_factura)*4),($_pdf->w)-7,45+(count($this->_proveedor->_factura)*4));
			$_pdf->Cell(15,4,"" ,0,0,'C');
					$_pdf->Cell(12,4,"" ,0,0,'C');
					$_pdf->Cell($columnas,4,"" ,0,0,'C');
					$_pdf->Cell($columnas,4,"GRAN TOTAL" ,0,0,'C');
					$_pdf->Cell($columnas,4,"" ,0,0,'C');
					$_pdf->Cell($columnas,4,number_format($_x_grabado,2,",",".") ,0,0,'R');
					$_pdf->Cell($columnas,4,number_format($_x_iva,2,",","."),0,0,'R');
					$_pdf->Cell($columnas,4,number_format($_x_t,2,",",".") ,0,0,'R');
					$_pdf->Cell(15,4,number_format($_x_re_iva,2,",",".") ,0,0,'R');
					$_pdf->Cell($columnas,4,number_format($_x_d[0],2,",",".") ,0,0,'R');
					$_pdf->Cell($columnas,4,number_format($_x_d[1],2,",",".")  ,0,0,'R');
					$_pdf->Cell($columnas,4,number_format($_x_d[2],2,",",".")  ,0,0,'R');
					$_pdf->Cell($columnas,4,number_format($_x_abon,2,",",".")  ,0,0,'R');
					
					$_pdf->Cell($columnas,4,number_format($_x_apagar,2,",",".") ,0,1,'R');


$_pdf->Output();

}
	function banlance_cta_pagar_general(){
				$tope=5;
				$ar_pro=array();
				$ar_pro=$this->_proveedor->all();
					
						
					

						$_pdf= new fpdf('L','mm','A4');
						$_pdf->AddPage();
						$_pdf->SetFont('Arial','B',12);
						$_pdf->Cell(0,4,"Balance de cuentas por pagar" ,0,1,'C');
						$_pdf->SetFont('Arial','B',7);
						$_pdf->ln(2);
						$_pdf->Cell(0,4,"fecha hasta   :   ".date("d/m/Y") ,0,0,'C');
						$_pdf->line(10,37,($_pdf->w)-7,37);
						$_pdf->ln(8);
						$columnas=$_pdf->w/15;

						
						

						
							$_pdf->Cell(15,4,"VENCE" ,0,0,'C');
							$_pdf->Cell(12,4,"CODIGO" ,0,0,'C');
							$_pdf->Cell($columnas,4,"SUB-TOTAL" ,0,0,'C');
							$_pdf->Cell($columnas,4,"DESC" ,0,0,'C');
							$_pdf->Cell($columnas,4,"TOTAL DESC" ,0,0,'C');
							$_pdf->Cell($columnas,4,"GRAVADO" ,0,0,'C');
							$_pdf->Cell($columnas,4,"IVA" ,0,0,'C');
							$_pdf->Cell($columnas,4,"TOTAL" ,0,0,'C');
							$_pdf->Cell(15,4,"RET.IVA" ,0,0,'C');
							$_pdf->Cell($columnas,4,"desc proto pago" ,0,0,'C');
							$_pdf->Cell($columnas,4,utf8_decode("par dañado") ,0,0,'C');
							$_pdf->Cell($columnas,4,"par faltante " ,0,0,'C');
							$_pdf->Cell($columnas,4,"abono" ,0,0,'C');
							
							$_pdf->Cell($columnas,4,"A PAGAR" ,0,1,'C');
							$_pdf->ln(2);


							$_xx_grabado=0;
							$_xx_t=0;
							$_xx_iva=0;
							$_xx_re_iva=0;
							$_xx_d= array( "0" => 0 , "1" => 0, "2" => 0);
							$_xx_abon=0;
							$_xx_apagar=0;

						for ($p=0; $p < count($ar_pro) ; $p++):


							if($p==$tope){
							$tope=$tope+$tope;
							$_pdf->AddPage();
							$_pdf->SetFont('Arial','B',12);
						$_pdf->Cell(0,4,"Balance cuentas por pagar" ,0,1,'C');
						$_pdf->SetFont('Arial','B',7);
						$_pdf->ln(2);
						$_pdf->Cell(0,4,"fecha hasta   :   ".date("d/m/Y") ,0,0,'C');
						$_pdf->line(10,37,($_pdf->w)-7,37);
						$_pdf->ln(8);
						$columnas=$_pdf->w/15;

						
						

						
							$_pdf->Cell(15,4,"VENCE" ,0,0,'C');
							$_pdf->Cell(12,4,"CODIGO" ,0,0,'C');
							$_pdf->Cell($columnas,4,"SUB-TOTAL" ,0,0,'C');
							$_pdf->Cell($columnas,4,"DESC" ,0,0,'C');
							$_pdf->Cell($columnas,4,"TOTAL DESC" ,0,0,'C');
							$_pdf->Cell($columnas,4,"GRAVADO" ,0,0,'C');
							$_pdf->Cell($columnas,4,"IVA" ,0,0,'C');
							$_pdf->Cell($columnas,4,"TOTAL" ,0,0,'C');
							$_pdf->Cell(15,4,"RET.IVA" ,0,0,'C');
							$_pdf->Cell($columnas,4,"desc proto pago" ,0,0,'C');
							$_pdf->Cell($columnas,4,utf8_decode("par dañado") ,0,0,'C');
							$_pdf->Cell($columnas,4,"par faltante " ,0,0,'C');
							$_pdf->Cell($columnas,4,"abono" ,0,0,'C');
							
							$_pdf->Cell($columnas,4,"A PAGAR" ,0,1,'C');
							$_pdf->ln(2);

						}





							$this->_proveedor=$this->loadModel('proveedor');
							$this->_proveedor->cargar_bd_rif($ar_pro[$p]['rif']);
							$this->_proveedor->listar_facturas();
							//print_r($this->_proveedor);
							//print_r($this->_proveedor);
							$_pdf->SetFont('Arial','B',8);
							$_pdf->Cell(0,4,$this->_proveedor->_id."   -   ".$this->_proveedor->_nombre,1,1,'L');
							$_pdf->SetFont('Arial','B',7);
							$_x_grabado=0;
							$_x_t=0;
							$_x_iva=0;
							$_x_re_iva=0;
							$_x_d= array( "0" => 0 , "1" => 0, "2" => 0);
							$_x_abon=0;
							$_x_apagar=0;


							for ($i=0; $i < count($this->_proveedor->_factura); $i++):
									if($this->_proveedor->_factura[$i]->_estatus=="no cancelada"){
									$_pdf->Cell(15,4,$this->_proveedor->_factura[$i]->_fecha_vencimiento,0,0,'C');
									$_pdf->Cell(12,4,$this->_proveedor->_factura[$i]->_id ,0,0,'C');
									$_pdf->Cell($columnas,4,number_format($this->_proveedor->_factura[$i]->_monto,2,",",".") ,0,0,'R');

											if ($this->_proveedor->_factura[$i]->_tipo_descuento=="1") {
											$t_d="%";
											$d_d=(((float)$this->_proveedor->_factura[$i]->_monto)/100)*((float)$this->_proveedor->_factura[$i]->_descuento);
											}else{
											$t_d="Bs";
											$d_d=(float)$this->_proveedor->_factura[$i]->_descuento;
											}
											$iva=(float)(($this->_proveedor->_factura[$i]->_monto-$d_d)/100)*$this->_proveedor->_factura[$i]->_impuesto;
											$_x_iva+=$iva;
											$gravado=$this->_proveedor->_factura[$i]->_monto-$d_d;
											$_x_grabado+=$gravado;
											$t=$gravado+$iva;
											$_x_t+=$t;


											$_pdf->Cell($columnas,4,$t_d." ".number_format($this->_proveedor->_factura[$i]->_descuento,2,',','.'),0,0,'R');
									$_pdf->Cell($columnas,4,number_format($d_d,2,',','.'),0,0,'R');
									$_pdf->Cell($columnas,4,number_format($gravado,2,',','.'),0,0,'R') ;

									$_pdf->Cell($columnas,4,number_format($iva,2,',','.'),0,0,'R');
									$_pdf->Cell($columnas,4,number_format($t,2,',','.') ,0,0,'R');
									$_pdf->Cell(15,4,number_format($this->_proveedor->_factura[$i]->_retencion->_retencion,2,',','.')  ,0,0,'R');
									$_x_re_iva+=$this->_proveedor->_factura[$i]->_retencion->_retencion;

											$total_descuentos=0;
											for ($j=0; $j < 3 ; $j++) { 

											$xx=0.00;

											if (!empty($this->_proveedor->_factura[$i]->_descuentos[$j]->_cantidad)) {
											$total_descuentos+=$this->_proveedor->_factura[$i]->_descuentos[$j]->_cantidad;
											$_x_d[$j]+=$this->_proveedor->_factura[$i]->_descuentos[$j]->_cantidad;
											$_pdf->Cell($columnas,4,number_format($this->_proveedor->_factura[$i]->_descuentos[$j]->_cantidad,2,',','.') ,0,0,'R');
											}else{
											$_pdf->Cell($columnas,4,number_format($xx,2,',','.') ,0,0,'R');
											}



											}


											$ordenes=orden_de_pagoModel::traer_ordenes_de_pago_por_id_factura($this->_proveedor->_factura[$i]->_id,"547f8d");
											
											$abono=0;
											for ($v=0; $v < count($ordenes) ; $v++) { 

												$ordenn= new orden_de_pagoModel;

												$ordenn->cargar_bd($ordenes[$v]['id_orden_de_pago']);

												if(isset($ordenn->_cheque->_cantidad)){

													$abono+=$ordenn->_cheque->_cantidad;

												}
												if (isset($ordenn->_transferencia->_cantidad)) {
													$abono+=$ordenn->_transferencia->_cantidad;	
												}

												

											}
											$_x_abon+=$abono;
											
								
									$_pdf->Cell($columnas,4,number_format($abono,2,",",".") ,0,0,'R');


										$pendiente=((($t-$this->_proveedor->_factura[$i]->_retencion->_retencion) -$abono)-$total_descuentos);
										$_x_apagar+=$pendiente;
										$_pdf->Cell($columnas,4,number_format($pendiente,2,",","."),0,1,'R');

									
							
									}



								endfor;

							
				$_pdf->SetFont('Arial','B',7);
				$_pdf->ln();

				//$_pdf->line(10,45+(count($this->_proveedor->_factura)*4),($_pdf->w)-7,45+(count($this->_proveedor->_factura)*4));
					$_pdf->Cell(15,4,"" ,0,0,'C');
							$_pdf->Cell(12,4,"" ,0,0,'C');
							$_pdf->Cell($columnas,4,"" ,0,0,'C');
							$_pdf->SetFont('Arial','B',8);
							$_pdf->Cell($columnas,4,"TOTAL PROVEEDOR" ,0,0,'C');
							$_pdf->SetFont('Arial','B',7);
							$_pdf->Cell($columnas,4,"" ,0,0,'C');
							$_pdf->Cell($columnas,4,number_format($_x_grabado,2,",",".") ,0,0,'R');
							$_pdf->Cell($columnas,4,number_format($_x_iva,2,",","."),0,0,'R');
							$_pdf->Cell($columnas,4,number_format($_x_t,2,",",".") ,0,0,'R');
							$_pdf->Cell(15,4,number_format($_x_re_iva,2,",",".") ,0,0,'R');
							$_pdf->Cell($columnas,4,number_format($_x_d[0],2,",",".") ,0,0,'R');
							$_pdf->Cell($columnas,4,number_format($_x_d[1],2,",",".")  ,0,0,'R');
							$_pdf->Cell($columnas,4,number_format($_x_d[2],2,",",".")  ,0,0,'R');
							$_pdf->Cell($columnas,4,number_format($_x_abon,2,",",".")  ,0,0,'R');
							
							$_pdf->Cell($columnas,4,number_format($_x_apagar,2,",",".") ,0,1,'R');

				$this->_pdf->ln(8);

						$_xx_d[0]+=$_x_d[0];
						$_xx_d[1]+=$_x_d[1];
						$_xx_d[2]+=$_x_d[2];
						$_xx_grabado+=$_x_grabado;
						$_xx_iva+=$_x_iva;
						$_xx_t+=$_x_t;
						$_xx_apagar+=$_x_apagar;
						$_xx_re_iva+=$_x_re_iva;
						$_xx_abon+=$_x_abon;



						endfor;



						$this->_pdf->SetFont('Arial','B',7);
				$_pdf->ln();

				//$_pdf->line(10,45+(count($this->_proveedor->_factura)*4),($_pdf->w)-7,45+(count($this->_proveedor->_factura)*4));
					$_pdf->Cell(15,4,"" ,0,0,'C');
							$_pdf->Cell(12,4,"" ,0,0,'C');
							$_pdf->Cell($columnas,4,"" ,0,0,'C');
							$_pdf->SetFont('Arial','B',8);
							$_pdf->Cell($columnas,4,"GRAN TOTAL" ,0,0,'C');
							$_pdf->SetFont('Arial','B',7);
							$_pdf->Cell($columnas,4,"" ,0,0,'C');
							$_pdf->Cell($columnas,4,number_format($_xx_grabado,2,",",".") ,0,0,'R');
							$_pdf->Cell($columnas,4,number_format($_xx_iva,2,",","."),0,0,'R');
							$_pdf->Cell($columnas,4,number_format($_xx_t,2,",",".") ,0,0,'R');
							$_pdf->Cell(15,4,number_format($_xx_re_iva,2,",",".") ,0,0,'R');
							$_pdf->Cell($columnas,4,number_format($_xx_d[0],2,",",".") ,0,0,'R');
							$_pdf->Cell($columnas,4,number_format($_xx_d[1],2,",",".")  ,0,0,'R');
							$_pdf->Cell($columnas,4,number_format($_xx_d[2],2,",",".")  ,0,0,'R');
							$_pdf->Cell($columnas,4,number_format($_xx_abon,2,",",".")  ,0,0,'R');
							
							$_pdf->Cell($columnas,4,number_format($_xx_apagar,2,",",".") ,0,1,'R');

				$this->_pdf->ln(8);


$_pdf->Output();

	
}






	function reporte_transancciones(){

		if(!empty($_GET['rif'])){

		$this->reporte_transancciones_detallado($_GET['rif']);

		}else{

			$this->reporte_transancciones_general();
		}
	
	}





function reporte_transancciones_detallado($rif){

		$_pdf= new fpdf('L','mm','A4');
		$_pdf->AddPage();
		$_pdf->SetFont('Arial','B',12);
		$_pdf->Cell(0,4,"REPORTES - TRANSACCIONES DE CxP" ,0,1,'C');
		$_pdf->SetFont('Arial','B',7);
		$_pdf->ln(2);
		$_pdf->Cell(0,4,"fecha hasta   :   ".date("d/m/Y") ,0,0,'C');
		$_pdf->line(10,37,($_pdf->w)-7,37);
		$_pdf->ln(8);
		$columnas=$_pdf->w/15;
		$this->_proveedor->cargar_bd_rif($rif);
			$this->_proveedor->listar_facturas_all();
			//print_r($this->_proveedor);
			//print_r($this->_proveedor);
			$_pdf->Cell(15,4,"VENCE" ,0,0,'C');
			$_pdf->Cell(12,4,"CODIGO" ,0,0,'C');
			$_pdf->Cell($columnas,4,"SUB-TOTAL" ,0,0,'C');
			$_pdf->Cell($columnas,4,"DESC" ,0,0,'C');
			$_pdf->Cell($columnas,4,"TOTAL DESC" ,0,0,'C');
			$_pdf->Cell($columnas,4,"GRAVADO" ,0,0,'C');
			$_pdf->Cell($columnas,4,"IVA" ,0,0,'C');
			$_pdf->Cell($columnas,4,"TOTAL" ,0,0,'C');
			$_pdf->Cell(15,4,"RET.IVA" ,0,0,'C');
			$_pdf->Cell($columnas,4,"desc proto pago" ,0,0,'C');
			$_pdf->Cell($columnas,4,utf8_decode("par dañado") ,0,0,'C');
			$_pdf->Cell($columnas,4,"par faltante " ,0,0,'C');
			$_pdf->Cell($columnas,4,"abono" ,0,0,'C');
			
			$_pdf->Cell($columnas,4,"A PAGAR" ,0,1,'C');
			$_pdf->ln(2);
			$_pdf->Cell(0,4,$this->_proveedor->_id."   -   ".$this->_proveedor->_nombre,0,1,'L');

			$_x_grabado=0;
			$_x_t=0;
			$_x_iva=0;
			$_x_re_iva=0;
			$_x_d= array( "0" => 0 , "1" => 0, "2" => 0);
			$_x_abon=0;
			$_x_apagar=0;

			
				for ($i=0; $i < count($this->_proveedor->_factura); $i++):
				
					$_pdf->Cell(15,4,$this->_proveedor->_factura[$i]->_fecha_vencimiento,0,0,'C');
					$_pdf->Cell(12,4,$this->_proveedor->_factura[$i]->_id ,0,0,'C');
					$_pdf->Cell($columnas,4,number_format($this->_proveedor->_factura[$i]->_monto,2,",",".") ,0,0,'R');

							if ($this->_proveedor->_factura[$i]->_tipo_descuento=="1") {
							$t_d="%";
							$d_d=(((float)$this->_proveedor->_factura[$i]->_monto)/100)*((float)$this->_proveedor->_factura[$i]->_descuento);
							}else{
							$t_d="Bs";
							$d_d=(float)$this->_proveedor->_factura[$i]->_descuento;
							}
							$iva=(float)(($this->_proveedor->_factura[$i]->_monto-$d_d)/100)*$this->_proveedor->_factura[$i]->_impuesto;
							$_x_iva+=$iva;
							$gravado=$this->_proveedor->_factura[$i]->_monto-$d_d;
							$_x_grabado+=$gravado;
							$t=$gravado+$iva;
							$_x_t+=$t;


							$_pdf->Cell($columnas,4,$t_d." ".number_format($this->_proveedor->_factura[$i]->_descuento,2,',','.'),0,0,'R');
					$_pdf->Cell($columnas,4,number_format($d_d,2,',','.'),0,0,'R');
					$_pdf->Cell($columnas,4,number_format($gravado,2,',','.'),0,0,'R') ;

					$_pdf->Cell($columnas,4,number_format($iva,2,',','.'),0,0,'R');
					$_pdf->Cell($columnas,4,number_format($t,2,',','.') ,0,0,'R');
					$_pdf->Cell(15,4,number_format($this->_proveedor->_factura[$i]->_retencion->_retencion,2,',','.')  ,0,0,'R');
					$_x_re_iva+=$this->_proveedor->_factura[$i]->_retencion->_retencion;

							$total_descuentos=0;
							for ($j=0; $j < 3 ; $j++) { 

							$xx=0.00;

							if (!empty($this->_proveedor->_factura[$i]->_descuentos[$j]->_cantidad)) {
							$total_descuentos+=$this->_proveedor->_factura[$i]->_descuentos[$j]->_cantidad;
							$_x_d[$j]+=$this->_proveedor->_factura[$i]->_descuentos[$j]->_cantidad;
							$_pdf->Cell($columnas,4,number_format($this->_proveedor->_factura[$i]->_descuentos[$j]->_cantidad,2,',','.') ,0,0,'R');
							}else{
							$_pdf->Cell($columnas,4,number_format($xx,2,',','.') ,0,0,'R');
							}



							}


							$ordenes=orden_de_pagoModel::traer_ordenes_de_pago_por_id_factura($this->_proveedor->_factura[$i]->_id,"547f8d");
							
							$abono=0;
							for ($v=0; $v < count($ordenes) ; $v++) { 

								$ordenn= new orden_de_pagoModel;

								$ordenn->cargar_bd($ordenes[$v]['id_orden_de_pago']);

								

								if(isset($ordenn->_cheque->_cantidad)){

									$abono+=$ordenn->_cheque->_cantidad;

								}


								if (isset($ordenn->_transferencia->_cantidad)) {
									$abono+=$ordenn->_transferencia->_cantidad;	
								}

								

							}
							$_x_abon+=$abono;
							
				
					$_pdf->Cell($columnas,4,number_format($abono,2,",",".") ,0,0,'R');


						$pendiente=((($t-$this->_proveedor->_factura[$i]->_retencion->_retencion) -$abono)-$total_descuentos);
						$_x_apagar+=$pendiente;
						$_pdf->Cell($columnas,4,number_format($pendiente,2,",","."),0,1,'R');

					
			
					
				endfor;

			
		$_pdf->SetFont('Arial','B',7);
		$_pdf->ln();

		$_pdf->line(10,45+(count($this->_proveedor->_factura)*4),($_pdf->w)-7,45+(count($this->_proveedor->_factura)*4));
			$_pdf->Cell(15,4,"" ,0,0,'C');
					$_pdf->Cell(12,4,"" ,0,0,'C');
					$_pdf->Cell($columnas,4,"" ,0,0,'C');
					$_pdf->Cell($columnas,4,"GRAN TOTAL" ,0,0,'C');
					$_pdf->Cell($columnas,4,"" ,0,0,'C');
					$_pdf->Cell($columnas,4,number_format($_x_grabado,2,",",".") ,0,0,'R');
					$_pdf->Cell($columnas,4,number_format($_x_iva,2,",","."),0,0,'R');
					$_pdf->Cell($columnas,4,number_format($_x_t,2,",",".") ,0,0,'R');
					$_pdf->Cell(15,4,number_format($_x_re_iva,2,",",".") ,0,0,'R');
					$_pdf->Cell($columnas,4,number_format($_x_d[0],2,",",".") ,0,0,'R');
					$_pdf->Cell($columnas,4,number_format($_x_d[1],2,",",".")  ,0,0,'R');
					$_pdf->Cell($columnas,4,number_format($_x_d[2],2,",",".")  ,0,0,'R');
					$_pdf->Cell($columnas,4,number_format($_x_abon,2,",",".")  ,0,0,'R');
					
					$_pdf->Cell($columnas,4,number_format($_x_apagar,2,",",".") ,0,1,'R');


$_pdf->Output();

}
	function reporte_transancciones_general(){
				$tope=5;
				$ar_pro=array();
				$ar_pro=$this->_proveedor->all();
					
						
					

						$_pdf= new fpdf('L','mm','A4');
						$_pdf->AddPage();
						$_pdf->SetFont('Arial','B',12);
						$_pdf->Cell(0,4,"REPORTES - TRANSACCIONES DE CxP" ,0,1,'C');
						$_pdf->SetFont('Arial','B',7);
						$_pdf->ln(2);
						$_pdf->Cell(0,4,"fecha hasta   :   ".date("d/m/Y") ,0,0,'C');
						$_pdf->line(10,37,($_pdf->w)-7,37);
						$_pdf->ln(8);
						$columnas=$_pdf->w/15;

						
						

						
							$_pdf->Cell(15,4,"VENCE" ,0,0,'C');
							$_pdf->Cell(12,4,"CODIGO" ,0,0,'C');
							$_pdf->Cell($columnas,4,"SUB-TOTAL" ,0,0,'C');
							$_pdf->Cell($columnas,4,"DESC" ,0,0,'C');
							$_pdf->Cell($columnas,4,"TOTAL DESC" ,0,0,'C');
							$_pdf->Cell($columnas,4,"GRAVADO" ,0,0,'C');
							$_pdf->Cell($columnas,4,"IVA" ,0,0,'C');
							$_pdf->Cell($columnas,4,"TOTAL" ,0,0,'C');
							$_pdf->Cell(15,4,"RET.IVA" ,0,0,'C');
							$_pdf->Cell($columnas,4,"desc proto pago" ,0,0,'C');
							$_pdf->Cell($columnas,4,utf8_decode("par dañado") ,0,0,'C');
							$_pdf->Cell($columnas,4,"par faltante " ,0,0,'C');
							$_pdf->Cell($columnas,4,"abono" ,0,0,'C');
							
							$_pdf->Cell($columnas,4,"A PAGAR" ,0,1,'C');
							$_pdf->ln(2);


							$_xx_grabado=0;
							$_xx_t=0;
							$_xx_iva=0;
							$_xx_re_iva=0;
							$_xx_d= array( "0" => 0 , "1" => 0, "2" => 0);
							$_xx_abon=0;
							$_xx_apagar=0;

						for ($p=0; $p < count($ar_pro) ; $p++):


							if($p==$tope){
							$tope=$tope+$tope;
							$_pdf->AddPage();
							$_pdf->SetFont('Arial','B',12);
						$_pdf->Cell(0,4,"Balance cuentas por pagar" ,0,1,'C');
						$_pdf->SetFont('Arial','B',7);
						$_pdf->ln(2);
						$_pdf->Cell(0,4,"fecha hasta   :   ".date("d/m/Y") ,0,0,'C');
						$_pdf->line(10,37,($_pdf->w)-7,37);
						$_pdf->ln(8);
						$columnas=$_pdf->w/15;

						
						

						
							$_pdf->Cell(15,4,"VENCE" ,0,0,'C');
							$_pdf->Cell(12,4,"CODIGO" ,0,0,'C');
							$_pdf->Cell($columnas,4,"SUB-TOTAL" ,0,0,'C');
							$_pdf->Cell($columnas,4,"DESC" ,0,0,'C');
							$_pdf->Cell($columnas,4,"TOTAL DESC" ,0,0,'C');
							$_pdf->Cell($columnas,4,"GRAVADO" ,0,0,'C');
							$_pdf->Cell($columnas,4,"IVA" ,0,0,'C');
							$_pdf->Cell($columnas,4,"TOTAL" ,0,0,'C');
							$_pdf->Cell(15,4,"RET.IVA" ,0,0,'C');
							$_pdf->Cell($columnas,4,"desc proto pago" ,0,0,'C');
							$_pdf->Cell($columnas,4,utf8_decode("par dañado") ,0,0,'C');
							$_pdf->Cell($columnas,4,"par faltante " ,0,0,'C');
							$_pdf->Cell($columnas,4,"abono" ,0,0,'C');
							
							$_pdf->Cell($columnas,4,"A PAGAR" ,0,1,'C');
							$_pdf->ln(2);

						}





							$this->_proveedor=$this->loadModel('proveedor');
							$this->_proveedor->cargar_bd_rif($ar_pro[$p]['rif']);
							$this->_proveedor->listar_facturas_all();
							//print_r($this->_proveedor);
							//print_r($this->_proveedor);
							$_pdf->SetFont('Arial','B',8);
							$_pdf->Cell(0,4,$this->_proveedor->_id."   -   ".$this->_proveedor->_nombre,1,1,'L');
							$_pdf->SetFont('Arial','B',7);
							$_x_grabado=0;
							$_x_t=0;
							$_x_iva=0;
							$_x_re_iva=0;
							$_x_d= array( "0" => 0 , "1" => 0, "2" => 0);
							$_x_abon=0;
							$_x_apagar=0;


							for ($i=0; $i < count($this->_proveedor->_factura); $i++):
									
									$_pdf->Cell(15,4,$this->_proveedor->_factura[$i]->_fecha_vencimiento,0,0,'C');
									$_pdf->Cell(12,4,$this->_proveedor->_factura[$i]->_id ,0,0,'C');
									$_pdf->Cell($columnas,4,number_format($this->_proveedor->_factura[$i]->_monto,2,",",".") ,0,0,'R');

											if ($this->_proveedor->_factura[$i]->_tipo_descuento=="1") {
											$t_d="%";
											$d_d=(((float)$this->_proveedor->_factura[$i]->_monto)/100)*((float)$this->_proveedor->_factura[$i]->_descuento);
											}else{
											$t_d="Bs";
											$d_d=(float)$this->_proveedor->_factura[$i]->_descuento;
											}
											$iva=(float)(($this->_proveedor->_factura[$i]->_monto-$d_d)/100)*$this->_proveedor->_factura[$i]->_impuesto;
											$_x_iva+=$iva;
											$gravado=$this->_proveedor->_factura[$i]->_monto-$d_d;
											$_x_grabado+=$gravado;
											$t=$gravado+$iva;
											$_x_t+=$t;


											$_pdf->Cell($columnas,4,$t_d." ".number_format($this->_proveedor->_factura[$i]->_descuento,2,',','.'),0,0,'R');
									$_pdf->Cell($columnas,4,number_format($d_d,2,',','.'),0,0,'R');
									$_pdf->Cell($columnas,4,number_format($gravado,2,',','.'),0,0,'R') ;

									$_pdf->Cell($columnas,4,number_format($iva,2,',','.'),0,0,'R');
									$_pdf->Cell($columnas,4,number_format($t,2,',','.') ,0,0,'R');
									$_pdf->Cell(15,4,number_format($this->_proveedor->_factura[$i]->_retencion->_retencion,2,',','.')  ,0,0,'R');
									$_x_re_iva+=$this->_proveedor->_factura[$i]->_retencion->_retencion;

											$total_descuentos=0;
											for ($j=0; $j < 3 ; $j++) { 

											$xx=0.00;

											if (!empty($this->_proveedor->_factura[$i]->_descuentos[$j]->_cantidad)) {
											$total_descuentos+=$this->_proveedor->_factura[$i]->_descuentos[$j]->_cantidad;
											$_x_d[$j]+=$this->_proveedor->_factura[$i]->_descuentos[$j]->_cantidad;
											$_pdf->Cell($columnas,4,number_format($this->_proveedor->_factura[$i]->_descuentos[$j]->_cantidad,2,',','.') ,0,0,'R');
											}else{
											$_pdf->Cell($columnas,4,number_format($xx,2,',','.') ,0,0,'R');
											}



											}


											$ordenes=orden_de_pagoModel::traer_ordenes_de_pago_por_id_factura($this->_proveedor->_factura[$i]->_id,"547f8d");
											
											$abono=0;
											for ($v=0; $v < count($ordenes) ; $v++) { 

												$ordenn= new orden_de_pagoModel;

												$ordenn->cargar_bd($ordenes[$v]['id_orden_de_pago']);

												if(isset($ordenn->_cheque->_cantidad)){

													$abono+=$ordenn->_cheque->_cantidad;

												}
												if (isset($ordenn->_transferencia->_cantidad)) {
													$abono+=$ordenn->_transferencia->_cantidad;	
												}

												

											}
											$_x_abon+=$abono;
											
								
									$_pdf->Cell($columnas,4,number_format($abono,2,",",".") ,0,0,'R');


										$pendiente=((($t-$this->_proveedor->_factura[$i]->_retencion->_retencion) -$abono)-$total_descuentos);
										$_x_apagar+=$pendiente;
										$_pdf->Cell($columnas,4,number_format($pendiente,2,",","."),0,1,'R');

									
							
									



								endfor;

							
				$_pdf->SetFont('Arial','B',7);
				$_pdf->ln();

				//$_pdf->line(10,45+(count($this->_proveedor->_factura)*4),($_pdf->w)-7,45+(count($this->_proveedor->_factura)*4));
					$_pdf->Cell(15,4,"" ,0,0,'C');
							$_pdf->Cell(12,4,"" ,0,0,'C');
							$_pdf->Cell($columnas,4,"" ,0,0,'C');
							$_pdf->SetFont('Arial','B',8);
							$_pdf->Cell($columnas,4,"TOTAL PROVEEDOR" ,0,0,'C');
							$_pdf->SetFont('Arial','B',7);
							$_pdf->Cell($columnas,4,"" ,0,0,'C');
							$_pdf->Cell($columnas,4,number_format($_x_grabado,2,",",".") ,0,0,'R');
							$_pdf->Cell($columnas,4,number_format($_x_iva,2,",","."),0,0,'R');
							$_pdf->Cell($columnas,4,number_format($_x_t,2,",",".") ,0,0,'R');
							$_pdf->Cell(15,4,number_format($_x_re_iva,2,",",".") ,0,0,'R');
							$_pdf->Cell($columnas,4,number_format($_x_d[0],2,",",".") ,0,0,'R');
							$_pdf->Cell($columnas,4,number_format($_x_d[1],2,",",".")  ,0,0,'R');
							$_pdf->Cell($columnas,4,number_format($_x_d[2],2,",",".")  ,0,0,'R');
							$_pdf->Cell($columnas,4,number_format($_x_abon,2,",",".")  ,0,0,'R');
							
							$_pdf->Cell($columnas,4,number_format($_x_apagar,2,",",".") ,0,1,'R');

				$this->_pdf->ln(8);

						$_xx_d[0]+=$_x_d[0];
						$_xx_d[1]+=$_x_d[1];
						$_xx_d[2]+=$_x_d[2];
						$_xx_grabado+=$_x_grabado;
						$_xx_iva+=$_x_iva;
						$_xx_t+=$_x_t;
						$_xx_apagar+=$_x_apagar;
						$_xx_re_iva+=$_x_re_iva;
						$_xx_abon+=$_x_abon;



						endfor;



						$this->_pdf->SetFont('Arial','B',7);
				$_pdf->ln();

				//$_pdf->line(10,45+(count($this->_proveedor->_factura)*4),($_pdf->w)-7,45+(count($this->_proveedor->_factura)*4));
					$_pdf->Cell(15,4,"" ,0,0,'C');
							$_pdf->Cell(12,4,"" ,0,0,'C');
							$_pdf->Cell($columnas,4,"" ,0,0,'C');
							$_pdf->SetFont('Arial','B',8);
							$_pdf->Cell($columnas,4,"GRAN TOTAL" ,0,0,'C');
							$_pdf->SetFont('Arial','B',7);
							$_pdf->Cell($columnas,4,"" ,0,0,'C');
							$_pdf->Cell($columnas,4,number_format($_xx_grabado,2,",",".") ,0,0,'R');
							$_pdf->Cell($columnas,4,number_format($_xx_iva,2,",","."),0,0,'R');
							$_pdf->Cell($columnas,4,number_format($_xx_t,2,",",".") ,0,0,'R');
							$_pdf->Cell(15,4,number_format($_xx_re_iva,2,",",".") ,0,0,'R');
							$_pdf->Cell($columnas,4,number_format($_xx_d[0],2,",",".") ,0,0,'R');
							$_pdf->Cell($columnas,4,number_format($_xx_d[1],2,",",".")  ,0,0,'R');
							$_pdf->Cell($columnas,4,number_format($_xx_d[2],2,",",".")  ,0,0,'R');
							$_pdf->Cell($columnas,4,number_format($_xx_abon,2,",",".")  ,0,0,'R');
							
							$_pdf->Cell($columnas,4,number_format($_xx_apagar,2,",",".") ,0,1,'R');

				$this->_pdf->ln(8);


$_pdf->Output();

	
}


function generar_cheque(){


			$this->_orden_de_pago->cargar_bd($_GET['id_orden']);
			$this->_proveedor->cargar_datos_por_id_factura($this->_orden_de_pago->_id_factura);
			$this->_banco->cargar_datos_por_id_cheque($this->_orden_de_pago->_cheque->_id);

			//print_r($this->_proveedor);
			//print_r($this->_banco);
			//print_r($this->_orden_de_pago);




				$tope=5;

				$_pdf= new fpdf('P','mm','A4');
				$_pdf->AddPage();
				$_pdf->SetFont('Arial','B',12);
				$_pdf->Cell(0,4,"CHEQUE" ,0,1,'C');
				$_pdf->SetFont('Arial','B',7);
				$_pdf->ln(2);
				
				$_pdf->line(10,65,($_pdf->w)-7,65);
				$_pdf->line(10,120,($_pdf->w)-7,120);

			
				$_pdf->ln(8);
				$columnas=$_pdf->w/15;

				$_pdf->sety(39);
				$_pdf->setx(($_pdf->w/4)*2);
				$_pdf->Cell(($_pdf->w/4)-10,4,"DOCUMENTO:",0,0,'L');
				$_pdf->Cell(($_pdf->w/4)-10,6, $this->_orden_de_pago->_id,0,1,'R');

				$_pdf->setx(($_pdf->w/4)*2);
				$_pdf->Cell(($_pdf->w/4)-10,4,"MONTO:",0,0,'L');
				$_pdf->SetFont('Arial','B',13);
				$_pdf->Cell(($_pdf->w/4)-10,4, number_format($this->_orden_de_pago->_cheque->_cantidad,2,',','.') ,0,1,'R');
				$_pdf->SetFont('Arial','B',7);


				$_pdf->Cell(($_pdf->w/5)-10,4,"BENEFICIARIO:",0,0,'L');
				$_pdf->Cell(($_pdf->w/4)-10,4,utf8_decode($this->_proveedor->_beneficiario),0,1,'L');
				$_pdf->Cell(($_pdf->w/5)-10,4,"FECHA:",0,0,'L');
				$_pdf->Cell(($_pdf->w/4)-10,4,$this->invertir_fecha($this->_orden_de_pago->_cheque->_fecha_liberacion),0,1,'L');

				$_pdf->sety(70);

				$_pdf->Cell(($_pdf->w/5)-10,6,"EMPRESA:",0,0,'L');
				$_pdf->Cell(($_pdf->w/4)-10,6,utf8_decode('KEYKO C.A.'),0,1,'L');

				$_pdf->Cell(($_pdf->w/5)-10,6,"TIENDA:",0,0,'L');
				$_pdf->Cell(($_pdf->w/4)-10,6,"00 KEIKO CENTRAL ",0,1,'L');
				$_pdf->Cell(($_pdf->w/5)-10,6,"BANCO:",0,0,'L');
				$_pdf->Cell(($_pdf->w/4)-10,6,$this->_banco->_id ." -- ".utf8_decode($this->_banco->_nombre),0,0,'L');
				$_pdf->Cell(0,6,"CUENTA :".$this->_banco->_nro_cta,0,1,'C');
				$_pdf->Cell(($_pdf->w/5)-10,6,"ORDEN DE PAGO",0,0,'L');
				$_pdf->Cell(($_pdf->w/4)-10,6,$this->_orden_de_pago->_id,0,1,'L');
				$_pdf->Cell(($_pdf->w/5)-10,6,"PROVEEDOR",0,0,'L');
				$_pdf->Cell(($_pdf->w/4)-10,6,$this->_proveedor->_nombre,0,1,'L');



				$_pdf->Output();



}

function invertir_fecha($_fecha){


	$date= new dateTime($_fecha);

	$fecha_invertida=$date->format('d/m/Y');




	return $fecha_invertida;

}


function generar_comprobante_de_retencion(){




				$this->_proveedor->cargar_datos_por_id_factura($_GET['id_factura']);

				$factura=new factura;
				$factura->cargar_bd_nro($_GET['id_factura']);
				//print_r($factura);
				$this->_proveedor->_factura=$factura;

				//print_r($this->_proveedor);

				$tope=5;

				$_pdf= new fpdf('P','mm','A4');
				$_pdf->AddPage();

				$_pdf->SetFont('Arial','',6);
				$_pdf->ln(8);
				$_pdf->Multicell(0,4,utf8_decode(' (Ley iVA- art. 11. Gaceta Oficial 6. 152 Extraordinario: "Seran responsables del pago del impuesto, en calidad de agentes de retencion, quienes por sus funciones públicas o razón de sus actividades privadas intervengan en operaciones gravadas con el impuesto establecido en esta ley") '),0,'J');
				$_pdf->ln(6);
				$_pdf->SetFont('Arial','B',10);
				$_pdf->Cell(0,4,"COMPROBANTE DE RETENCION DEL IMPUESTO AL VALOR AGREGADO",0,0,'C');

			
				$_pdf->SetFont('Arial','',7);
				$_pdf->ln(8);

				$_pdf->Cell(($_pdf->w/7),4,utf8_decode("NRO COMPROBANTE:"),0,0,'L');
				$_pdf->Cell(0,4,$this->_proveedor->_factura->_retencion->_nro_comprobante,0,1,'L');
				$_pdf->Cell(($_pdf->w/7),4,"FECHA DE EMISION",0,0,'L');
				$_pdf->Cell(0,4,date("d/m/Y"),0,1,'L');
				$_pdf->ln(8);
				

				$_pdf->SetFont('Arial','B',10);
				$_pdf->Cell(0,4,utf8_decode("DATOS DEL AGENTE DE RETENCION"),0,1,'L');
				$_pdf->line(10,68,75,68);
				$_pdf->SetFont('Arial','',7);
				$_pdf->ln(3);

				$_pdf->Cell(0,4,"NOMBRE/RAZON SOCIAL           :KEIKO, C.A",0,1,'L');
				$_pdf->Cell(0,4,"NUMERO R.I.F.                             :J080044754",0,1,'L');
				$_pdf->Cell(0,4,"PERIODO FISCAL                        :".utf8_decode('AÑO: ').date('Y')." /  MES: ".date("m")   ,0,1,'L');
				$_pdf->Cell(0,4,"NUMERO R.I.F.                             :J080044754",0,1,'L');





				$_pdf->ln(6);
				$_pdf->SetFont('Arial','B',10);
				$_pdf->Cell(0,4,utf8_decode("DATOS DEL PROVEEDOR"),0,1,'L');
				$_pdf->line(10,97,75,97);
				$_pdf->SetFont('Arial','',7);
				$_pdf->ln(3);

				$_pdf->Cell(0,4,"NOMBRE/RAZON SOCIAL           :".$this->_proveedor->_nombre,0,1,'L');
				$_pdf->Cell(0,4,"NUMERO R.I.F.                             :".$this->_proveedor->_rif,0,1,'L');

				$_pdf->ln(4);

				$_pdf->SetFont('Arial','B',10);
				$_pdf->Cell(0,4,utf8_decode("DATOS DE LA COMPRA"),0,1,'L');
				$_pdf->line(10,116,75,116);
				$_pdf->SetFont('Arial','',7);
				$_pdf->ln(3);


				$UNO  = ($this->_proveedor->_factura->_tipo=='FACTURA') ? $this->_proveedor->_factura->_nro_factura : "" ;
				$DOS  = ($this->_proveedor->_factura->_tipo=='NOTA DE DEBITO') ? $this->_proveedor->_factura->_nro_factura : "" ;
				$TRES = ($this->_proveedor->_factura->_tipo=='NOTA DE CREDITO') ? $this->_proveedor->_factura->_nro_factura : "" ;


				$_pdf->Cell(($_pdf->w/4),4,"NUMERO DE FACTURA",0,0,'L');$_pdf->Cell(($_pdf->w/6),4,":".$UNO,0,1,'L');
				$_pdf->Cell(($_pdf->w/4),4,"NUMERO DE LA NOTA DE DEBITO",0,0,'L');$_pdf->Cell(($_pdf->w/6),4,":".$DOS,0,1,'L');
				$_pdf->Cell(($_pdf->w/4),4,"NUMERO DE LA NOTA DE CREDITO",0,0,'L');$_pdf->Cell(($_pdf->w/6),4,":".$TRES,0,1,'L');
				$_pdf->Cell(($_pdf->w/4),4,"NUMERO DE CONTROL",0,0,'L');$_pdf->Cell(($_pdf->w/6),4,":".$this->_proveedor->_factura->_nro_control,0,1,'L');
				$_pdf->Cell(($_pdf->w/4),4,"NUMERO DE FACTURA AEFECTADA",0,0,'L');$_pdf->Cell(($_pdf->w/6),4,":",0,1,'L');
				$_pdf->Cell(($_pdf->w/4),4,"FECHA DE EMISION",0,0,'L');$_pdf->Cell(($_pdf->w/6),4,":".$this->invertir_fecha($this->_proveedor->_factura->_fecha_recepcion),0,1,'L');
				$_pdf->Cell(($_pdf->w/4),4,"TIPO DE TRANSSACCION",0,0,'L');$_pdf->Cell(($_pdf->w/6),4,":01 Registro",0,1,'L');



				$_pdf->ln(6);
				$_pdf->SetFont('Arial','B',10);
				$_pdf->Cell(0,4,utf8_decode("DETALLES DEL CALCULO DE LA RETENCION"),0,1,'L');
				$_pdf->line(10,157,89,157);
				$_pdf->SetFont('Arial','',7);
				$_pdf->ln(3);
				$_pdf->Cell(0,4,utf8_decode("PORCENTAJE DE RETENCION:                                        ").number_format($this->_proveedor->_porcentaje_retencion,2,',','.')." %",0,1,'L');
				$_pdf->line(10,178,($_pdf->w)-7,178);
						$_pdf->line(10,178.2,($_pdf->w)-7,178.2);

				$_pdf->sety(174);

				$_pdf->Cell(($_pdf->w/6)-5,4,"",0,0,'L');
				$_pdf->Cell(($_pdf->w/6)-5,4,"Total Compras con IVA",0,0,'R');
				$_pdf->Cell(($_pdf->w/6)-5,4,"Sin Derecho a Credito ",0,0,'R');
				$_pdf->Cell(($_pdf->w/6)-5,4,"Base Imponible",0,0,'R');
				$_pdf->Cell(($_pdf->w/6)-5,4,"Ipuesto IVA",0,0,'R');
				$_pdf->Cell(($_pdf->w/6)-5,4,"IVA Retenido",0,1,'R');
				$_pdf->ln(6);

				$_pdf->Cell(($_pdf->w/6)-5,4,"TASA<".number_format($this->_proveedor->_factura->_impuesto,2,',','.')." % >",0,0,'L');
				$_pdf->Cell(($_pdf->w/6)-5,4,number_format($this->_proveedor->_factura->_total,2,',','.'),0,0,'R');
				$_pdf->Cell(($_pdf->w/6)-5,4,"0.00",0,0,'R');
				$_pdf->Cell(($_pdf->w/6)-5,4,number_format($this->_proveedor->_factura->_sub_total,2,',','.'),0,0,'R');

				$iva=($this->_proveedor->_factura->_sub_total/100)*$this->_proveedor->_factura->_impuesto;


				$_pdf->Cell(($_pdf->w/6)-5,4,number_format($iva,2,",","."),0,0,'R');
				$_pdf->Cell(($_pdf->w/6)-5,4,number_format($this->_proveedor->_factura->_retencion->_retencion,2,",","."),0,1,'R');


								
						
							
				$_pdf->line(10,198.2,($_pdf->w)-7,198.2);
								


				$_pdf->line(80,230.2,($_pdf->w)-83,230.2);
				$_pdf->sety(230);

				$_pdf->Cell(0,5,"FIMAR Y SELLO AGENTE DE RETENCION",0,1,'C');
				$_pdf->Cell(0,4,"R.I.F : J310507066",0,0,'C');


$_pdf->Output();
}


function lista_cheque_filtrado(){


				$lista=new cheque;

				$rs = $lista->listar_por_estado_y_fecha($_GET['filtro']);
				//print_r($rs);
				$cheques=array();
			
				for ($i=0; $i < count($rs) ; $i++) { 
				
					$che=new cheque;
					$che->cargar_bd_2($rs[$i]['id_cheque']);
					//$che->_id_orden_de_pago=$rs[$i]['id_orden_de_pago'];
					$cheques[]=$che;
				}
				
				//print_r($cheques);

				$tope=5;

				$_pdf= new fpdf('P','mm','A4');
				$_pdf->AddPage();



				$_pdf->SetFont('Arial','',6);
				$_pdf->ln(8);
				
				$_pdf->SetFont('Arial','B',10);
				$_pdf->Cell(0,4,"lista de cheques",0,0,'C');

			
				$_pdf->SetFont('Arial','',7);
				$_pdf->ln(8);

				$_pdf->Cell(($_pdf->w/6),4,'nro',1,0,'L');
				$_pdf->Cell(($_pdf->w/6),4,'Orden de pago',1,0,'L');
				$_pdf->Cell(($_pdf->w/6),4,'Fecha de elavoracion',1,0,'L');
				$_pdf->Cell(($_pdf->w/6),4,'Fecha de libiracion',1,0,'L');
				$_pdf->Cell(($_pdf->w/6),4,'Cantidad',1,1,'L');
				

				for ($i=0; $i <count($rs) ; $i++) { 
				$_pdf->Cell(($_pdf->w/6),4,$i+1,1,0,'L');
				$_pdf->Cell(($_pdf->w/6),4,$cheques[$i]->_id_orden,1,0,'L');
				$_pdf->Cell(($_pdf->w/6),4,$cheques[$i]->_fecha_emicion,1,0,'L');
				$_pdf->Cell(($_pdf->w/6),4,$cheques[$i]->_fecha_liberacion,1,0,'L');
				$_pdf->Cell(($_pdf->w/6),4,$cheques[$i]->_cantidad,1,1,'L');
				
				}

				$_pdf->ln(8);
				





$_pdf->Output();
}

function reporte_bancos(){


	$id_banco=$_GET['id_banco'];


		if ($id_banco!='') {

		$banco=new bancoModel;
		$banco->cargar_bd($id_banco);
		//print_r($banco);
		$_pdf= new fpdf('P','mm','A4');
		$_pdf->AddPage();
		$_pdf->SetFont('Arial','',6);
		$_pdf->ln(8);
		$_pdf->SetFont('Arial','B',10);
		$_pdf->Cell(0,4,"reporte bancario",0,0,'C');
		$_pdf->SetFont('Arial','',7);
		$_pdf->ln(8);
		$_pdf->Cell(($_pdf->w/6),4,'nro de registro',1,0,'L');
		$_pdf->Cell(($_pdf->w/6),4,$banco->_id,1,1,'L');
		$_pdf->Cell(($_pdf->w/6),4,'Nombre',1,0,'L');
		$_pdf->Cell(($_pdf->w/6),4,$banco->_nombre,1,1,'L');
		$_pdf->Cell(($_pdf->w/6),4,'nro de cuenta',1,0,'L');
		$_pdf->Cell(($_pdf->w/6),4,$banco->_nro_cta,1,1,'L');
		$_pdf->Cell(($_pdf->w/6),4,'saldo',1,0,'L');
		$_pdf->Cell(($_pdf->w/6),4,$banco->_saldo,1,1,'L');

		$_pdf->Cell(($_pdf->w/4)*3,4,'cheques afilidas',1,1,'L');
			$_pdf->Cell($_pdf->w/4,4,'nro de registro',1,0,'L');
			$_pdf->Cell($_pdf->w/4,4,'Codigo',1,0,'L');
			$_pdf->Cell($_pdf->w/4,4,'desde/hasta',1,1,'L');
		for ($i=0; $i < count($banco->_chequera); $i++) { 
			$_pdf->Cell($_pdf->w/4,4,$banco->_chequera[$i]->_id,1,0,'L');
			$_pdf->Cell($_pdf->w/4,4,$banco->_chequera[$i]->_codigo,1,0,'L');
			$_pdf->Cell($_pdf->w/4,4,$banco->_chequera[$i]->_desde .'/'. $banco->_chequera[$i]->_hasta ,1,1,'L');
		}
		




		$_pdf->Output();


		}else{


		$banco=new bancoModel;
		$rs=$banco->listar_todo();
		$array=array();
		 for ($i=0; $i <count($rs) ; $i++) { 
        $banco=$this->loadModel('banco');
        $array[]=$banco->cargar_bd($rs[$i]['id_banco']);
      }
      //	print_r($array);

		$banco->cargar_bd($id_banco);
		//print_r($banco);
		$_pdf= new fpdf('P','mm','A4');
		$_pdf->AddPage();
		$_pdf->SetFont('Arial','',6);
		$_pdf->ln(8);
		$_pdf->SetFont('Arial','B',10);
		$_pdf->Cell(0,4,"reporte bancario",0,0,'C');
		$_pdf->SetFont('Arial','',7);
		$_pdf->ln(8);
		for ($i=0; $i < count($array) ; $i++) { 
		$_pdf->Cell(($_pdf->w/6),4,'nro de registro',1,0,'L');
		$_pdf->Cell(($_pdf->w/6),4,'Nombre',1,0,'L');
		$_pdf->Cell(($_pdf->w/6),4,'tipo de cuenta',1,0,'L');
		$_pdf->Cell(($_pdf->w/6),4,'saldo',1,0,'L');
		$_pdf->Cell(($_pdf->w/6),4,'nro cta',1,1,'L');
		
		$_pdf->Cell(($_pdf->w/6),4,$array[$i]['id_banco'],1,0,'L');
		$_pdf->Cell(($_pdf->w/6),4,$array[$i]['nombre'],1,0,'L');
		$_pdf->Cell(($_pdf->w/6),4,$array[$i]['tipo_cta'],1,0,'L');
		$_pdf->Cell(($_pdf->w/6),4,$array[$i]['saldo'].$array[$i]['moneda'],1,0,'L');
$_pdf->Cell(($_pdf->w/6),4,$array[$i]['nro_cta'],1,1,'L');


		}


	




		$_pdf->Output();



		}
   		
	
				

			
}
























}

?>
