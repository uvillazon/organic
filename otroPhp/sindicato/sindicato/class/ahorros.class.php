<?php
class ahorro
{
	var $parameter=array();
	function SetParameter($name,$value)
	{
		$this->parameter[$name]=$value;
	}
	function mostrarregistro(){
		$template=new template;
		$template->SetTemplate('html/registro.html');
		if($_GET['error']){
			$template->SetParameter('error',"DATOS MALOS INGRESADOS");
		}
		else{
			$template->SetParameter('error',"");
		}
		return $template->Display();
	}
	function mostrarregistro1(){
		$template=new template;
		$template->SetTemplate('html/logen.html');
		$query=new query;
		$id=$_SESSION['id'];
		$row=$query->getRow("*","usuario","where id_usuario=$id");
		$nombre=" ".$row['nombre_usuario']." ".$row['apellido1_usuario'];
		$template->SetParameter('name',$nombre);
		
		return $template->Display();
	}
	function registrarAhorro(){
		$query = new query;
		$template = new template;
		$template->SetTemplate('html/form_ahorro.html');
        $template->SetParameter('numeroMovil',"<input name=\"movil\" type=\"text\" id=\"movil\" onblur=\"if(document.mframe.movil.value > 0){ajax('datosMovil','ahorro.php?accion=buscarMovil&movil=' + document.mframe.movil.value, '');}\" size=\"3\">");
		$template->SetParameter('nombreSocio','');
	
		$template->SetParameter('numChofer',"<input name=\"numChofer\" type=\"text\" id=\"numChofer\" value=\"0\" onblur=\"if(document.mframe.numChofer.value > 0) {ajax('datosChofer','ahorro.php?accion=buscarChofer&numChofer=' + document.mframe.numChofer.value, '');}\" size=\"3\">");
		$template->SetParameter('nombreChofer','');
	
		$hoy=date("Y-m-d");
			$template->SetParameter('montoPrestamo','');
		$template->SetParameter('fecha_pago',$hoy);
		$template->SetParameter('fecha_ahorro',$hoy);
			$template->SetParameter('concepto','');
			$template->SetParameter('accion','guardarPago');
        $template->SetParameter('boton','REGISTRAR');
		return $template->Display();
	}
    function buscarMovil(){
        $query = new query;
        //$linea = $query->getRow("linea","linea","where id_linea = ".$_GET['idlinea']);
        $nombreSocio = $query->getRow("m.id_movil, nombre_socio, apellido1_socio, apellido2_socio, placa_movilidad, estado_socio","socio s, movil m, pertenece p","where (m.num_movil like '132_".$_GET['movil']."' or m.num_movil like '131_".$_GET['movil']."') and m.id_movil = p.id_movil and p.id_socio = s.id_socio");
        if($nombreSocio['estado_socio'] == 'activo')
            $nombreCompleto = $nombreSocio['nombre_socio']." ".$nombreSocio['apellido1_socio']." ".$nombreSocio['apellido2_socio'];
        else
            $nombreCompleto = $nombreSocio['nombre_socio']." ".$nombreSocio['apellido1_socio']." ".$nombreSocio['apellido2_socio']." (Tiene deudas pendientes)";
		return "<span>".$nombreCompleto."</span><input type=\"hidden\" name=\"id_movil\" value=\"".$nombreSocio['id_movil']."\">";
	}
	 function buscaridMovil(){
        $query = new query;
        //$linea = $query->getRow("linea","linea","where id_linea = ".$_GET['idlinea']);
        $nombre = $query->getRow("m.id_movil, nombre_socio, apellido1_socio, apellido2_socio, placa_movilidad, estado_socio","socio s, movil m, pertenece p","where m.num_movil like '%_".$_GET['movil']."' and m.id_movil = p.id_movil and p.id_socio = s.id_socio");
         return "<span>".$nombre['id_movil']."</span><input type=\"hidden\" name=\"id_movil\" value=\"".$nombre['id_movil']."\">";
	}
    function buscarChofer(){
        $query = new query;
        $nombreChofer = $query->getRow("nombre_chofer, id_chofer","chofer","where num_chofer = ".$_GET['numChofer']);
		return "<span>".$nombreChofer['nombre_chofer']."</span><input type=\"hidden\" name=\"id_chofer\" value=\"".$nombreChofer['id_chofer']."\">";
	}
    
    function buscarSocio(){
        $query = new query;
        $nombreSocio = $query->getRow("*","socio","where num_licencia = ".$_GET['licencia']);
        $nombreCompleto = $nombreSocio['nombre_socio']." ".$nombreSocio['apellido1_socio']." ".$nombreSocio['apellido2_socio'];
		return "<span>".$nombreCompleto."</span><input type=\"hidden\" name=\"idSocio\" value=\"".$nombreSocio['id_socio']."\">";
	}
    
	
    
    
	function deletePago(){
        $query = new query;
		
		//$ide=$_GET['id'];
		//$deposito=$query->getRows("*","deposito","WHERE id_deposito = ".$_GET['id']);
	 
		  if($query->dbDelete("pago_ahorro","WHERE id_ahorro = ".$_GET['id']))
		  { 
          echo "<script>alert('Pago eliminado exitosamente')</script>";
          echo "<script>window.location.href='ahorro.php'</script>";
	       }
		
		else
	      echo "<script>alert('Fallo la eliminacion')</script>";
          echo "<script>window.location.href='ahorro.php'</script>";
	}
	function ingresarPago()//list of all payments and new ones
	{
		$template = new template;
		$template->SetTemplate('html/lista_pagoshechos_ahorro1.html'); //sets the template for this function
		$confirm="javascript:return confirm('Esta seguro de eliminar este pago?');";
                $id_movil = $_GET[id];
        
		$query = new query;
	//$ahorro = $query -> getRows("*","pago_ahorro","where id_movil = ".$_GET[id]);
        $ahorro = $query -> getRows("*","pago_ahorro","where id_movil =".$_GET['id']." ORDER by id_ahorro");
        
	
		 $numdeposito = count($ahorro);
        if($numdeposito > 0) {
            $list ='<center><table border = "2">
              <thead><tr>
                <th>Fecha</th>
                <th>Monto de ahorro</th>
		<th>Fecha de ahorro</th>
		<th>Concepto</th>
		<th></th>
		<th></th>
              </tr></thead>';
            $x = 0;
			$totalDepositos=0;
            foreach ($ahorro as $key=>$value) {
                $x++;
                if(($x%2)==0)
                    $par = "class='TdAlt'";
                else $par = "";
                    $list .= '<tbody><tr '.$par.'>
                  <td>'.$value["fecha_cobro"].' </td>
				  <td>'.$value["monto_pago_ahorro"].' Bs.</td>
				  <td>'.$value["fecha_ahorro_dia"].'</td>
				  <td>'.$value["concepto"].'</td>
				 
				   <td><a href="imprimirReciboahorro.php?numHoja='.$value["id_ahorro"].'" target="_blank" onClick="window.open(this.href, this.target); return false;" title="Imprimir Recibo">[Imprimir]</a></td>
				  <td><a href="ahorro.php?accion=deleteP&id='.$value["id_ahorro"].'" onClick="'.$confirm.'" title="Eliminar Ahorro"><img src="images/delete.gif"></a></td>

                  </tr></tbody>';
				  $totalDepositos += $value["monto_pago_ahorro"];
				
				 
            }
			$list .= '<tbody><tr '.$par.'>
                  <td><strong>Total pagado</strong></td>
				  <td><strong>'.$totalDepositos.' Bs.</strong></td>
				 
                  </tr>
				  <tr '.$par.'>
                  		 
                  </tr>
				  </tbody>';
            $list.='</table></center>';
        } else $list = '<div>No existen pagos registrados</div>';
	$template->SetParameter('fechafin',$fechaF);
        $movil = $query -> getRow("*","movil","where id_movil = ".$_GET[id]);
        $pertenece = $query -> getRow("*","pertenece","where id_movil = ".$_GET[id]);
        $socio = $query -> getRow("*","socio","where id_socio = ".$pertenece['id_socio']);
				$soloNum = split("_",$movil['num_movil']);
        
		$nombreSocio = $socio['nombre_socio']." ".$socio['apellido1_socio']." ".$socio['apellido2_socio'];
        $fechaInicio = $_GET[fi];
        $fechaFin = $_GET[ff];
	$ahorro = $_GET[ahorro];
		$hoy=date("Y-m-d");
	
		$fecha=$fechaInicio; // El formato que te entrega MySQL es Y-m-d 
                $fechaIni=date("d-m-Y",strtotime($fecha)); 
		$template->SetParameter('fechainicio',$fechaIni);
		$fecha2=$fechaFin; // El formato que te entrega MySQL es Y-m-d 
                $fechaF=date("d-m-Y",strtotime($fecha2)); 
              $template->SetParameter('fechafin',$fechaF);
		
	      $id_movil = $_GET[id];
        	$template->SetParameter('id_movil',$movil['id_movil']);
			
		$template->SetParameter('nombreSocio',"<span>".$nombreSocio."</span><input type=\"hidden\" name=\"idSocio\" value=\"".$socio['id_socio']."\">");
		$template->SetParameter('lineas',$soloNum[0]);
		$template->SetParameter('numeroMovil',$soloNum[1]);
			$template->SetParameter('fecha_pago',$hoy);
			$template->SetParameter('fecha_ahorro',$fecha2);
			$template->SetParameter('concepto','');
			
			$template->SetParameter('total',$ahorro);
         //$buttonAdd = '<input type="button" value="GUARDAR" onclick="window.location.href=\'ahorro.php?accion=guardarPago&id="141"\'">';
	
	$buttonAdd = '<input type="button" value="GUARDAR" onclick="window.location.href=\'ahorro.php?accion=guardarPago&id='.$_GET['id'].'\'">';
		$template->SetParameter('accion','guardarPago');
        $template->SetParameter('Add','');//$buttonAdd);
		$template->SetParameter('contenido',$list);
		return $template->Display();
	}
	
	function guardarPago()
	{
		$query = new query;
		  $fechaInicio = $_GET['fi'];
        $fechaFin = $_GET['ff'];

		$resultprestamo = $query -> getRow("*","movil","where id_movil = ".$_POST[id_movil]);
		
		$fecha_pago = date('Y-m-d', strtotime("now"));
		$insert['id_movil'] = $_POST['id_movil'];
		$insert['id_chofer'] = "0";
		
		
		$insert['monto_pago_ahorro'] = $_POST['deposito'];
		$insert['concepto'] = $_POST['concepto'];
		
		$insert['fecha_cobro'] = $fecha_pago;
		 $insert['fecha_ahorro_dia'] = $_POST['fecha_ahorro'];
       
		if($query->dbInsert($insert,"pago_ahorro"))//{ save in the data base	
		//echo "<script>window.open('imprimirRecibo2.php?numHoja=".$insert['id_prestamo']."');</script>";
		//}
		//echo "<script>window.location.href='ahorro.php'</script>";
		echo "<script>window.location.href='ahorro.php?accion=pago&id=".$_POST['id_movil']."&ff=".$_POST['fecha_ahorro']."'</script>";
		//<td><a href="ahorro.php?accion=pago&id='.$id_movil.'&ahorro='.$saldoahorro.'&fi='.$_GET["fechaInicio"].'&ff='.$_GET["fechaFin"].'" title="Pagar Ahorros"><img src="images/pago.gif"></a></td>
	                               
	          
	}
	function guardarPagoChofer()
	{
		$query = new query;
		$resultprestamo = $query -> getRow("*","chofer","where id_chofer = ".$_POST[id_chofer]);
		
		$fecha_pago = date('Y-m-d', strtotime("now"));
		$insert['id_movil'] = "0";
		$insert['id_chofer'] = $_POST['id_chofer'];
		
		
		$insert['monto_pago_ahorro'] = $_POST['deposito'];
		$insert['concepto'] = $_POST['concepto'];
		
		$insert['fecha_cobro'] = $fecha_pago;
		 $insert['fecha_ahorro_dia'] = $_POST['fecha_ahorro'];
       
		if($query->dbInsert($insert,"pago_ahorro"))//{ save in the data base	
		//echo "<script>window.open('imprimirRecibo2.php?numHoja=".$insert['id_prestamo']."');</script>";
		//}
		//echo "<script>window.location.href='ahorro.php'</script>";
		echo "<script>window.location.href='ahorro.php?accion=pagochofer&id=".$_POST['id_chofer']."&fi&ff=".$_POST['fecha_ahorro']."'</script>";
	   	      
	}
	
	function ingresarPagoChofer()//list of all payments and new ones
	{
		$template = new template;
		$template->SetTemplate('html/lista_pagoshechos_ahorro2.html'); //sets the template for this function
		$confirm="javascript:return confirm('Esta seguro de eliminar este pago?');";
                $id_chofer = $_GET[id];
        
		$query = new query;
	//$ahorro = $query -> getRows("*","pago_ahorro","where id_movil = ".$_GET[id]);
        $ahorro = $query -> getRows("*","pago_ahorro","where id_chofer =".$_GET['id']." ORDER by id_ahorro");
        
	
		 $numdeposito = count($ahorro);
        if($numdeposito > 0) {
            $list ='<center><table border = "2">
              <thead><tr>
                <th>Fecha</th>
                <th>Monto de ahorro</th>
		<th>Fecha de ahorro</th>
		<th>Concepto</th>
		<th></th>
		<th></th>
              </tr></thead>';
            $x = 0;
			$totalDepositos=0;
            foreach ($ahorro as $key=>$value) {
                $x++;
                if(($x%2)==0)
                    $par = "class='TdAlt'";
                else $par = "";
                    $list .= '<tbody><tr '.$par.'>
                  <td>'.$value["fecha_cobro"].' </td>
				  <td>'.$value["monto_pago_ahorro"].' Bs.</td>
				  <td>'.$value["fecha_ahorro_dia"].'</td>
				  <td>'.$value["concepto"].'</td>
				 
				   <td><a href="imprimirReciboahorro.php?numHoja='.$value["id_ahorro"].'" target="_blank" onClick="window.open(this.href, this.target); return false;" title="Imprimir Recibo">[Imprimir]</a></td>
				  <td><a href="ahorro.php?accion=deleteP&id='.$value["id_ahorro"].'" onClick="'.$confirm.'" title="Eliminar Ahorro"><img src="images/delete.gif"></a></td>

                  </tr></tbody>';
				  $totalDepositos += $value["monto_pago_ahorro"];
				
				 
            }
			$list .= '<tbody><tr '.$par.'>
                  <td><strong>Total pagado</strong></td>
				  <td><strong>'.$totalDepositos.' Bs.</strong></td>
				 
                  </tr>
				  <tr '.$par.'>
                  		 
                  </tr>
				  </tbody>';
            $list.='</table></center>';
        } else $list = '<div>No existen pagos registrados</div>';
	$template->SetParameter('fechafin',$fechaF);
        $chofer = $query -> getRow("*","chofer","where id_chofer = ".$_GET[id]);
        		
		$nombreSocio = $chofer['nombre_chofer']." ".$chofer['num_chofer'];
        $fechaInicio = $_GET[fi];
        $fechaFin = $_GET[ff];
	$ahorro = $_GET[ahorro];
		$hoy=date("Y-m-d");
	
		$fecha=$fechaInicio; // El formato que te entrega MySQL es Y-m-d 
                $fechaIni=date("d-m-Y",strtotime($fecha)); 
		$template->SetParameter('fechainicio',$fechaIni);
		$fecha2=$fechaFin; // El formato que te entrega MySQL es Y-m-d 
                $fechaF=date("d-m-Y",strtotime($fecha2)); 
              $template->SetParameter('fechafin',$fechaF);
		
	      $id_movil = $_GET[id];
        	$template->SetParameter('id_movil',$movil['id_movil']);
			
		$template->SetParameter('nombreSocio',"<span>".$nombreSocio."</span><input type=\"hidden\" name=\"id_chofer\" value=\"".$chofer['id_chofer']."\">");
			$template->SetParameter('fecha_pago',$hoy);
			$template->SetParameter('fecha_ahorro',$fecha2);
			$template->SetParameter('concepto','');
			
			$template->SetParameter('total',$ahorro);
         //$buttonAdd = '<input type="button" value="GUARDAR" onclick="window.location.href=\'ahorro.php?accion=guardarPago&id="141"\'">';
	
	$buttonAdd = '<input type="button" value="GUARDAR" onclick="window.location.href=\'ahorro.php?accion=guardarPagoChofer&id='.$_GET['id'].'&fi='.$_GET['fi'].'&ff='.$_GET['ff'].'\'">';
		$template->SetParameter('accion','guardarPagoChofer');
        $template->SetParameter('Add','');//$buttonAdd);
		$template->SetParameter('contenido',$list);
		return $template->Display();
	}
	
    function listarAhorros() //list for default the all items
	{
		$template = new template;
		$template->SetTemplate('html/lista_ahorro.html'); //sets the template for this function
		$template->SetParameter('hoy',date('d-M-Y'));
                $template->SetParameter('filtroFecha','');
                $hoy = date('Y-m-d');
		
		//DataBase Conexion//
		$query = new query;
        $confirm="javascript:return confirm('Esta seguro de eliminar este ahorro?');";
          $resultprestamo = $query->getRows("*","pago_ahorro","where fecha_cobro = '".$hoy."' ORDER BY id_ahorro");
      
        //$init = (($_GET['page'] == "" ? 1 : $_GET['page']) - 1) * 10;
  $resultprestamo1 = $query->getRows("*","pago_ahorro","where fecha_cobro = '".$hoy."' ORDER BY id_ahorro");
        $numprestamo = count($resultprestamo1);
        if($numprestamo > 0) {
            $list ='<table border = "1">
              <thead><tr>
	        <th>Nro</th>
                <th>Fecha</th>
                <th>Linea</th>
		<th>Movil</th>
		<th>Socio</th>
                <th>Conductor </th>
                <th>Tipo</th>
		<th>Concepto</th>
		<th>Monto Pago ahorro</th>
                <th></th>
                <th>Eliminar</th>
              </tr></thead>';
            $x = 0;
            foreach ($resultprestamo1 as $key=>$value) {
                $x++;
                if(($x%2)==0)
                    $par = "class='TdAlt'";
                else $par = "";
	//	$movil=$value['id_movil'];
	
         if($value["id_movil"]!=0)
		{	
		 $movil = $query -> getRow("*","movil","where id_movil = ".$value['id_movil']);
        $pertenece = $query -> getRow("*","pertenece","where id_movil =  ".$value['id_movil']);
        $socio = $query -> getRow("*","socio","where id_socio = ".$pertenece['id_socio']);
	
                //$socio = $query->getRow("*","socio","where id_socio = ".$value['id_socio']);
                $nombreCompleto = $socio['nombre_socio']." ".$socio['apellido1_socio']." ".$socio['apellido2_socio'];
		$linea = $query->getRow("linea, num_movil","linea l, movil m","where m.id_movil = ".$value['id_movil']." and m.id_linea = l.id_linea");
                $numMovil = split('_',$linea["num_movil"]);
		$linea =$linea["linea"];
                $movil = $numMovil[1];
		$tipo = "-";
                
		}
		else  if($value["id_movil"]==0)
	{
		$chofer = $query -> getRow("*","chofer","where id_chofer = ".$value['id_chofer']);
  //$alquiler = $query -> getRow("nombre_chofer","chofer","where tipo_chofer='alquiler' AND id_chofer = ".$value['id_alquiler']);
		$linea ="-";
                $movil = "-";
                $nombreCompleto ="-";
		
	 }     
	 $chofer = $query -> getRow("*","chofer","where id_chofer = ".$value['id_chofer']);
	  if($chofer["tipo_chofer"]=='Permanente')
	  $tipo = "Chofer";
	  else if ($chofer["tipo_chofer"]=='alquiler')
             $tipo = "Alquiler";

	 
                $list .= '<tbody><tr '.$par.'>
	          <td>'.$value["id_ahorro"].'</td>
                  <td>'.$value["fecha_cobro"].'</td>
		  <td>'.$linea.'</td>
                  <td>'.$movil.'</td>
                  <td>'.$nombreCompleto.'</td>
                  <td>'.$chofer["nombre_chofer"].'</td>
                   <td>'.$tipo.'</td>
                  <td>'.$value["concepto"].'</td>
		  <td>'.$value["monto_pago_ahorro"].'</td>
		  <td><a href="imprimirReciboahorro.php?numHoja='.$value["id_ahorro"].'" target="_blank" onClick="window.open(this.href, this.target); return false;" title="Imprimir hoja">[Imprimir]</a></td>
                  <td><a href="ahorro.php?accion=deleteP&id='.$value["id_ahorro"].'" onClick="'.$confirm.'" title="Eliminar Ahorro"><img src="images/delete.gif"></a></td>
                  

                  </tr></tbody>';
            }
            $list.='</table>';
            //$list .= paging::navigation(count($resultprestamo),"ahorro.php",10);
        } else $list = '<div>No existen prestamos registrados</div>';
        $buttonAdd = '<input type="button" value="Nuevo" onclick="window.location.href=\'ahorro.php?accion=registro\'">';
        $template->SetParameter('add',$buttonAdd);
		$totalDiaBs = $query->getRow("SUM(monto_pago_ahorro) as totalDiabs","pago_ahorro","where fecha_cobro = '".$hoy."'");
        
		//$totalDiaBs = $query->getRow("SUM(monto_deposito) as totalDiabs","deposito","where fecha_deposito = '".$hoy."'");
        $template->SetParameter('totalDia',"<br />Total egreso en pago de ahorros de hoy: ".$totalDiaBs['totalDiabs']." bs ");
		
		$template->SetParameter('contenido',$list);
		return $template->Display();
	}
     function filtroFecha() //list for default the all items
	{
        $fechaFiltro = $_GET['filtro'];
		$query = new query;
        $resulthoja = $query->getRows("*","pago_ahorro","where fecha_cobro = '".$fechaFiltro."' ORDER BY id_ahorro");
        //$init = (($_GET['page'] == "" ? 1 : $_GET['page']) - 1) * 20;
        $resulthoja1 = $query->getRows("*","pago_ahorro","where fecha_cobro = '".$fechaFiltro."' ORDER BY id_ahorro");
        $numhoja = count($resulthoja1);
	$totalDia = $query->getRow("SUM(monto_pago_ahorro) as totalDia","pago_ahorro","where fecha_cobro = '".$fechaFiltro."'");
      $totalbs = $totalDia['totalDia'];
       
        $list = '<form name="formRecibir" method="POST" action="ahorro.php?accion=recibir">';
        if($numhoja > 0) {
           $list ='<table border = "1">
              <thead>
	      <tr><b>Total Bs:<b>'.$totalbs.'<tr></tr>
		
	      <tr>
                <th>Nro</th>
                <th>Fecha</th>
                <th>Linea</th>
		<th>Movil</th>
		<th>Socio</th>
                <th>Conductor </th>
                <th>Tipo</th>
		<th>Concepto</th>
		<th>Monto Pago ahorro</th>
                <th></th>
                </tr></thead>'; 
		$x = 0;
            foreach ($resulthoja1 as $key=>$value) {
                $x++;
                if(($x%2)==0)
                    $par = "class='TdAlt'";
                else $par = "";
				/////////////////////////////////////////////////
		if($value["id_movil"]!=0)
		{	
		 $movil = $query -> getRow("*","movil","where id_movil = ".$value['id_movil']);
        $pertenece = $query -> getRow("*","pertenece","where id_movil =  ".$value['id_movil']);
        $socio = $query -> getRow("*","socio","where id_socio = ".$pertenece['id_socio']);
	
                //$socio = $query->getRow("*","socio","where id_socio = ".$value['id_socio']);
                $nombreCompleto = $socio['nombre_socio']." ".$socio['apellido1_socio']." ".$socio['apellido2_socio'];
		$linea = $query->getRow("linea, num_movil","linea l, movil m","where m.id_movil = ".$value['id_movil']." and m.id_linea = l.id_linea");
                $numMovil = split('_',$linea["num_movil"]);
		$linea =$linea["linea"];
                $movil = $numMovil[1];
		$tipo = "-";
                
		}
		else  if($value["id_movil"]==0)
	{
		$chofer = $query -> getRow("*","chofer","where id_chofer = ".$value['id_chofer']);
  //$alquiler = $query -> getRow("nombre_chofer","chofer","where tipo_chofer='alquiler' AND id_chofer = ".$value['id_alquiler']);
		$linea ="-";
                $movil = "-";
                $nombreCompleto ="-";
		
	 }     
	 $chofer = $query -> getRow("*","chofer","where id_chofer = ".$value['id_chofer']);
	  if($chofer["tipo_chofer"]=='Permanente')
	  $tipo = "Chofer";
	  else if ($chofer["tipo_chofer"]=='alquiler')
             $tipo = "Alquiler";

	 
                $list .= '<tbody><tr '.$par.'>
	          <td>'.$value["id_ahorro"].'</td>
                  <td>'.$value["fecha_cobro"].'</td>
		  <td>'.$linea.'</td>
                  <td>'.$movil.'</td>
                  <td>'.$nombreCompleto.'</td>
                  <td>'.$chofer["nombre_chofer"].'</td>
                   <td>'.$tipo.'</td>
                  <td>'.$value["concepto"].'</td>
		  <td>'.$value["monto_pago_ahorro"].'</td>
		  

                  </tr></tbody>';
            }
            $list.='</table>';
           // $list .= paging::navigation(count($resulthoja),"ingresos.php",20);
        } else $list = '<div>No existen egresos para la fecha '.$fechaFiltro.'</div>';
		return $list;
	}

	function Display(){
		$template=new template;
		
		if(!$_SESSION['tipo']){
		
			$template->SetTemplate('html/home12.html');
			$template->SetParameter('registro',$this->mostrarregistro());
		}
		if($_SESSION['tipo']==1){
			$template->SetTemplate('html/home1.html');
			$template->SetParameter('registro',$this->mostrarregistro1());
		}
		if($_SESSION['tipo']==2){
			$template->SetTemplate('html/home2.html');
			$template->SetParameter('registro',$this->mostrarregistro1());
		}
		if($_SESSION['tipo']==3){
			$template->SetTemplate('html/home.html');
			$template->SetParameter('registro',$this->mostrarregistro1());
		}
        if($_GET['accion']==""){
            $template->SetParameter('contenido',$this->listarAhorros());
        }
        if($_GET['accion']=="registro"){
            $template->SetParameter('contenido',$this->registrarAhorro());
        }
        if($_GET['accion']=="modificar"){
            $template->SetParameter('contenido',$this->modificarPrestamo());
        }
        if($_GET['accion']=="plan"){
            $template->SetParameter('contenido',$this->planPagos());
        }
		if($_GET['accion']=="pago"){
            $template->SetParameter('contenido',$this->ingresarPago());
        }
		if($_GET['accion']=="pagochofer"){
            $template->SetParameter('contenido',$this->ingresarPagoChofer());
        }
		
		if($_GET['accion']=="guardarPago"){
            $template->SetParameter('contenido',$this->guardarPago());
        }
		if($_GET['accion']=="guardarPagoChofer"){
            $template->SetParameter('contenido',$this->guardarPagoChofer());
        }
		if($_GET['accion']=="calcularPlan"){
            $template->SetParameter('contenido',$this->calcularPlan());
        }
		if($_GET['accion']=="imprimir"){
            $template->SetParameter('contenido',$this->imprimirReporte());
        }
		$template->SetParameter('pie',navigation::showpie());
		return $template->Display();
	}
}
?>
