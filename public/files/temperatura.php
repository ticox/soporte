<?php




 $this->_pdf->AddPage();
        $this->_pdf->SetFont('Arial','B',12);
		
		$this->_pdf->Cell(190,10, utf8_decode('ORDEN DE COMPRA'),0,1,'C');
		
		$this->_pdf->Cell(95,10, utf8_decode('Nº de la orden ='.$id_orden ),0,0,'L');
		$this->_pdf->Cell(95,10, utf8_decode( 'Realizada por, '.$this->encargado['nombres'].' '.$this->encargado['apellidos']),0,1,'R');
        
		
		$orden=$this->_inv->get_inv($id_orden);
		
		$this->_pdf->Cell(47,10, 'Cantidad',1,0,'L');
		$this->_pdf->Cell(47,10, 'Nombre',1,0,'L');
		$this->_pdf->Cell(51,10, 'Descripcion',1,0,'L');
		$this->_pdf->Cell(47,10, 'Precio',1,1,'L');
		
		for($i=0;$i<count($orden);$i++):
		
		$this->_pdf->Cell(47,10, $orden[$i]['cantidad'],1,0,'L');
		$this->_pdf->Cell(47,10, $orden[$i]['nombre'],1,0,'L');
		$this->_pdf->Cell(51,10, $orden[$i]['descripcion'],1,0,'L');
		$this->_pdf->Cell(47,10,'              ',1,1,'L');
		
		
		endfor;
		$this->_pdf->SetFont('Arial','B',8);
		
		$this->_pdf->Cell(190,10,'Este documento no respalda juridicamente para transsacciones legales',0,1,'C');
		$this->_pdf->SetFont('Arial','B',12);
		
		$this->_pdf->MultiCell(190,10,'Recuerde que para que cuenten estos productos en su inventario debe dirigirse  a inventario y presionar el boton "Ejecutar"');
		
		
        $this->_pdf->Output();

?>
