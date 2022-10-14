<?php
class arqueo
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
	function registrarPrestamo(){
		$query = new query;
		$template = new template;
		$template->SetTemplate('html/form_prestamo.html');
        $template->SetParameter('licencia',"<input name=\"licencia\" type=\"text\" id=\"licencia\" onblur=\"if(document.mframe.licencia.value > 0) {ajax('nombreSocio','arqueo.php?accion=buscarSocio&licencia=' + document.mframe.licencia.value, '');}\" size=\"8\">");
		
		$template->SetParameter('licencia2',"<input name=\"licencia2\" type=\"text\" id=\"licencia2\" onblur=\"if(document.mframe.licencia2.value > 0) {ajax('nombreChofer','arqueo.php?accion=buscarChofer&licencia=' + document.mframe.licencia2.value, '');}\" size=\"8\">");
		
		$tipoprestamolist = $query->getRows("*","tipo_prestamo");
	    foreach($tipoprestamolist as $tipoprestamo)
	    {
	      $script .= '<option value="'.$tipoprestamo['id_tipo_prestamo'].'"';
	      $script .= '>'.$tipoprestamo['tipo_prestamo'].'</option>'."\n";
	    }
		$hoy=date("Y-m-d");
		$template->SetParameter('nombreSocio','');
		$template->SetParameter('nombreChofer','');
        $template->SetParameter('montoPrestamo','');
		$template->SetParameter('fecha_creacion',$hoy);
		$template->SetParameter('descripcionPrestamo','');
		$template->SetParameter('tipoprestamo',$script);
		$template->SetParameter('accion','savePrestamo');
        $template->SetParameter('boton','REGISTRAR');
		return $template->Display();
	}
    function modificarPrestamo(){
        $query = new query;
        $resultprestamo = $query -> getRow("*","prestamo_socio","where id_prestamo = ".$_GET[id]);
        $socio = $query -> getRow("*","socio","where id_socio = ".$resultprestamo['socio']);
		$chofer = $query ->getRow("*","chofer","where id_chofer = ".$resultprestamo['chofer']);
		$template = new template;
		$template->SetTemplate('html/form_prestamo.html');
        $template->SetParameter('licencia',"<input name=\"licencia\" type=\"text\" id=\"licencia\" onblur=\"if(document.mframe.licencia.value > 0) {ajax('nombreSocio','arqueo.php?accion=buscarSocio&licencia=' + document.mframe.licencia.value, '');}\" size=\"8\" value=".$socio['num_licencia'].">");
		
		$template->SetParameter('licencia2',"<input name=\"licencia2\" type=\"text\" id=\"licencia2\" onblur=\"if(document.mframe.licencia2.value > 0) {ajax('nombreChofer','arqueo.php?accion=buscarChofer&licencia=' + document.mframe.licencia2.value, '');}\" size=\"8\" value=".$chofer['num_chofer'].">");
		
		$tipoprestamolist = $query->getRows("*","tipo_prestamo");
	    foreach($tipoprestamolist as $tipoprestamo)
	    {
	      $script .= '<option value="'.$tipoprestamo['id_tipo_prestamo'].'"';
		  if ($tipoprestamo['id_tipo_prestamo'] == $resultprestamo['id_tipo_prestamo'])
			$script .= ' selected ';
	      $script .= '>'.$tipoprestamo['tipo_prestamo'].'</option>'."\n";
	    }
		$nombreSocio = $socio['nombre_socio']." ".$socio['apellido1_socio']." ".$socio['apellido2_socio'];
		$template->SetParameter('nombreSocio',"<span>".$nombreSocio."</span><input type=\"hidden\" name=\"idSocio\" value=\"".$socio['id_socio']."\">");
		$template->SetParameter('nombreChofer',"<span>".$chofer['nombre_chofer']."</span><input type=\"hidden\" name=\"idChofer\" value=\"".$chofer['idchofer']."\">");
        $template->SetParameter('montoPrestamo',$resultprestamo['monto_prestamo']);
		$template->SetParameter('fecha_creacion',$resultprestamo['fecha_prestamo']);
		$template->SetParameter('descripcionPrestamo',$resultprestamo['descripcion_prestamo']);
		$template->SetParameter('tipoprestamo',$script);
        $template->SetParameter('accion','saveUpdatePrestamo&id='.$_GET['id']);
        $template->SetParameter('boton','MODIFICAR');
		return $template->Display();
	}
    
    function buscarSocio(){
        $query = new query;
        $nombreSocio = $query->getRow("*","socio","where num_licencia = ".$_GET['licencia']);
        $nombreCompleto = $nombreSocio['nombre_socio']." ".$nombreSocio['apellido1_socio']." ".$nombreSocio['apellido2_socio'];
		return "<span>".$nombreCompleto."</span><input type=\"hidden\" name=\"idSocio\" value=\"".$nombreSocio['id_socio']."\">";
	}
    
	function buscarChofer(){
        $query = new query;
        $nombreChofer = $query->getRow("*","chofer","where num_chofer = ".$_GET['licencia']);
        $nombreCompleto = $nombreChofer['nombre_chofer'];
		return "<span>".$nombreCompleto."</span><input type=\"hidden\" name=\"idChofer\" value=\"".$nombreChofer['id_chofer']."\">";
	}
    
    function deletePrestamo(){
        $query = new query;
		
		//$ide=$_GET['id'];
		$deposito=$query->getRows("*","deposito","WHERE id_prestamo = ".$_GET['id']);
		if(count($deposito) != 0) {
		 $query->dbDelete("deposito","WHERE id_prestamo = ".$_GET['id']);
		  $plan=$query->getRows("*","plan_de_pagos","WHERE id_prestamo = ".$_GET['id']);
		    if(count($plan) != 0) {
			$query->dbDelete("plan_de_pagos","WHERE id_prestamo = ".$_GET['id']);
		 
		  if($query->dbDelete("prestamo_socio","WHERE id_prestamo = ".$_GET['id']))
		  { 
          echo "<script>alert('Prestamo elminado exitosamente')</script>";
          echo "<script>window.location.href='arqueo.php'</script>";
	       }
	    }
		}
		
		else
		if($query->dbDelete("prestamo_socio","WHERE id_prestamo = ".$_GET['id']))
		   
          echo "<script>alert('Prestamo elminado exitosamente')</script>";
          echo "<script>window.location.href='arqueo.php'</script>";
	}
    
    function saveUpdatePrestamo() //save the new Item
    {
        $query = new query;
        $update['socio'] = $_POST['idSocio'];
        $update['chofer'] = $_POST['idChofer'];
        $update['id_tipo_prestamo'] = $_POST['tipo_prestamo'];
        $update['monto_prestamo'] = $_POST['monto_prestamo'];
        $update['fecha_prestamo'] = $_POST['fecha_creacion'];
        $update['descripcion_prestamo'] = $_POST['descripcion_prestamo'];
		if($query->dbUpdate($update,"prestamo_socio","where id_prestamo = ".$_GET['id'])){ //save in the data base		   
			echo "<script>window.location.href='arqueo.php'</script>";
		}
		else{ //error
			echo "<script>alert('Error en el registro');</script>";
			echo "<script>window.location.href='arqueo.php'</script>";
		}
    }
    
    function savePrestamo() //save the new Item
    {
        $query = new query;
        $insert['socio'] = $_POST['idSocio'];
        $insert['chofer'] = $_POST['idChofer'];
        $insert['id_tipo_prestamo'] = $_POST['tipo_prestamo'];
        $insert['monto_prestamo'] = $_POST['monto_prestamo'];
        $insert['fecha_prestamo'] = $_POST['fecha_creacion'];
        $insert['descripcion_prestamo'] = $_POST['descripcion_prestamo'];
		if($query->dbInsert($insert,"prestamo_socio")){ //save in the data base
			echo "<script>window.location.href='arqueo.php'</script>";
		}
		else{ //error
			echo "<script>alert('Error en el registro');</script>";
			echo "<script>window.location.href='arqueo.php'</script>";
		}
    }
	
	
	//registraarqueo
	function calcularPlan()
	{
		$query = new query;
		//clean all plan
	       
	//$query->dbUpdate($update,"caja","where idcaja =".$idcajan //save in the data base		   
		//	echo "<script>window.location.href='arqueo.php'</script>";
		// $totalDiaBs = $query->getRow("SUM(i.monto_pago_ingreso) as totalDiabs","ingreso i,tipo_ingreso t","where i.id_tipo_ingreso=t.id_tipo_ingreso and t.linea='1' and i.arqueo='0'");
	$hoy = date('Y-m-d');
		
		$resulthoja = $query->getRows("*","hoja_control","where fecha_de_compra = '".$hoy."' ORDER BY numero_hoja");
       
   //$totalPago = $query->getRow("SUM(monto_ingreso_dolar) as total","ingreso","where fecha_ingreso='".$hoy."'");
    //  $ingresosus = $totalPago['total'];
	 $resultplan = $query->getRow("SUM(i.monto_pago_ingreso)AS totalbs","linea l, movil m, ingreso i,tipo_ingreso t","where i.id_tipo_ingreso=t.id_tipo_ingreso and l.id_linea=m.id_linea and m.id_movil=i.id_movil and l.id_linea='1' and  i.fecha_ingreso='".$hoy."'");

	//$resultplan = $query->getRow("SUM(i.monto_pago_ingreso)AS totalbs","ingreso i,tipo_ingreso t","WHERE i.id_tipo_ingreso=t.id_tipo_ingreso and t.linea='1' and i.fecha_ingreso='".$hoy."'");
	$ingresobs = $resultplan['totalbs'];
	$resultplan1 = $query->getRow("SUM(i.monto_ingreso_dolar)AS totalbs","linea l, movil m, ingreso i,tipo_ingreso t","where i.id_tipo_ingreso=t.id_tipo_ingreso and l.id_linea=m.id_linea and m.id_movil=i.id_movil and l.id_linea='1' and  i.fecha_ingreso='".$hoy."'");

	//$resultplan1 = $query->getRow("SUM(i.monto_ingreso_dolar)AS totalbs","ingreso i,tipo_ingreso t","WHERE i.id_tipo_ingreso=t.id_tipo_ingreso and t.linea='1' and i.fecha_ingreso='".$hoy."'");
	$ingresosus = $resultplan1['totalbs'];
	//$totalDiaBs = $query->getRow("SUM(i.monto_pago_ingreso) as totalDiabs","ingreso i,tipo_ingreso t","where i.id_tipo_ingreso=t.id_tipo_ingreso and t.linea='1' and i.arqueo='0'");
    $totalDiaBs = $query->getRow("SUM(i.monto_pago_ingreso) as totalDiabs","ingreso i,tipo_ingreso t","where i.id_tipo_ingreso=t.id_tipo_ingreso and t.linea='1' and i.fecha_ingreso='".$hoy."'");
   
	//  $totalDiaDs = $query->getRow("SUM(i.monto_ingreso_dolar) as totalDiadl","ingreso i,tipo_ingreso t","where i.id_tipo_ingreso=t.id_tipo_ingreso and t.linea='1' and i.arqueo='0'");
	
	 $resultplan2 = $query->getRow("SUM(monto_egreso) as total","egresos","WHERE fecha='".$hoy."'");
	 $egresobs = $resultplan2['total'];
  	$resultplan3 = $query->getRow("SUM(monto_dolar) as total","egresos","WHERE fecha='".$hoy."'");
  	 $egresosus = $resultplan3['total'];
	
	$totalPagoa = $query->getRow("SUM(h.aporte) as total","linea l, movil m, hoja_control h","where l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='1' and  h.fecha_de_compra='".$hoy."'");
      $ingresohojasaporte = $totalPagoa['total'];

	  $totalPagob = $query->getRow("SUM(h.adeporte) as total","linea l, movil m, hoja_control h","where l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='1' and  h.fecha_de_compra='".$hoy."'");
     $ingresohojasdeporte = $totalPagob['total'];
	 
	  $totalIngresosBS = $ingresobs + $ingresohojasaporte +$ingresohojasdeporte;
			$interes = $query ->getRow("MAX(idcaja) as ultimo","caja");
 $idcajan = $interes['ultimo'];

	 $cajaanteriorbs = $query->getRow("cajanueva as total","caja","where idcaja='".$idcajan."'");
	  $cajaanteriorbs = $cajaanteriorbs['total'];
     $cajaanteriorsus = $query->getRow("cajanuevasus as total","caja","where idcaja='".$idcajan."'");
	 	  $cajaanteriorsus = $cajaanteriorsus['total'];

$totaldisponible= $totalIngresosBS - $egresobs + $cajaanteriorbs;
		
		$totaldisponiblesus= $ingresosus - $egresosus + $cajaanteriorsus;
		
	$fecha_pago = date('Y-m-d', strtotime($str));
			$insert['saldocaja']= $cajaanteriorbs;
			$insert['saldocajasus'] = $cajaanteriorsus;
			$insert['estado'] = "activado";
			
			$insert['efecbsingreso'] = $totalIngresosBS;
			$insert['efecsusingreso'] = $ingresosus;
	     	$insert['efecbsegreso'] = $egresobs;
			$insert['efecsusegreso'] = $egresosus;
			$insert['cajanueva'] = $totaldisponible;
			$insert['cajanuevasus'] = $totaldisponiblesus;
				$insert['fecharegistro'] = $hoy;
			//$insert['pagado'] = $resultprestamo['monto_prestamo'] = $interesSem*$m;
			if($query->dbInsert($insert,"caja")){ //save in the data base	
			}
		
	//	echo "<script>window.location.href='arqueo.php?accion=plan&id=".$_POST['id_prestamo']."'</script>";
	}
	
	function guardarPago()
	{
		$query = new query;
		$resultprestamo = $query -> getRow("*","prestamo_socio","where id_prestamo = ".$_POST[id_prestamo]);
		
		$fecha_pago = date('Y-m-d', strtotime("now"));
		$insert['id_prestamo'] = $_POST['id_prestamo'];
		$insert['monto_deposito'] = $_POST['deposito'];
		//$insert['fecha_deposito'] = $fecha_pago;
		 $insert['fecha_deposito'] = $_POST['fecha_pago'];
       
		if($query->dbInsert($insert,"deposito"))//{ save in the data base	
		//echo "<script>window.open('imprimirRecibo2.php?numHoja=".$insert['id_prestamo']."');</script>";
		//}
		echo "<script>window.location.href='arqueo.php?accion=pago&id=".$_POST['id_prestamo']."'</script>";
	}
	function deletePago(){
        $query = new query;
		
		//$ide=$_GET['id'];
		//$deposito=$query->getRows("*","deposito","WHERE id_deposito = ".$_GET['id']);
	 
		  if($query->dbDelete("deposito","WHERE id_deposito = ".$_GET['id']))
		  { 
          echo "<script>alert('Deposito eliminado exitosamente')</script>";
          echo "<script>window.location.href='arqueo.php'</script>";
	       }
		
		else
	      echo "<script>alert('Fallo la eliminacion')</script>";
          echo "<script>window.location.href='arqueo.php'</script>";
	}
//resumen
	function planPagos()
	{
		$template = new template;
		$template->SetTemplate('html/lista_arqueoitems.html'); //sets the template for this function
		
		//DataBase Conexion//
		$query = new query;
		
       		$hoy=date("Y-m-d");

$resultplan = $query->getRows("i.id_movil,t.tipo_ingreso,i.fecha_ingreso,i.numero_registro,i.monto_pago_ingreso,i.monto_ingreso_dolar","linea l, movil m, ingreso i,tipo_ingreso t","where i.id_tipo_ingreso=t.id_tipo_ingreso and l.id_linea=m.id_linea and m.id_movil=i.id_movil and l.id_linea='1' and  i.fecha_ingreso='".$hoy."'");
$numcp='15';
		$ini='0';
		$hojax='1';
		$mostrarsolo=$_GET["numcp"];
$iniciarde=$_GET["ini"];		 
$numerarcpx=$iniciarde;
		$numplan = count($resultplan);
        if($numplan > 0) {
            $list ='<center><table border = "1">
              <thead><tr>
			    <th>Nro</th>
				<th>Fecha</th>
                <th>Detalle</th>
				<th>N. Recibo</th>
				<th>Cant.</th>
                <th>Bolivianos</th>
                <th>Dolares</th>
			
              </tr></thead>';
            $x = 0;
            foreach ($resultplan as $key=>$value) {
                $x++;
                if(($x%2)==0)
                    $par = "class='TdAlt'";
                else $par = "";
                $numero=($numerarcpx+1);
              
                $list .= '<tbody><tr '.$par.'>
				  <td>'.$numero.'</td>
				    <td>'.$value["fecha_ingreso"].'</td>
					 <td>'.$value["tipo_ingreso"].'</td>
					 <td>'.$value["numero_registro"].'</td>
					 <td>'.$value["cantidad"].'</td>
				  <td>'.$value["monto_pago_ingreso"].'</td>
				  <td>'.$value["monto_ingreso_dolar"].'</td>
                 
                  </tr></tbody>';
				  
$numerarcpx=$numerarcpx+1;
$totalIngresosBS += $value["monto_pago_ingreso"];
$totalIngresosSUS += $value["monto_ingreso_dolar"];
            }
			
		$totalPagoa = $query->getRow("SUM(h.aporte) as total","linea l, movil m, hoja_control h","where l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='1' and  h.fecha_de_compra='".$hoy."'");
      $ingresohojasaporte = $totalPagoa['total'];
	  $totalPagoa = $query->getRow("COUNT( h.numero_hoja ) AS numero","linea l, movil m, hoja_control h","where l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='1' and  h.fecha_de_compra='".$hoy."'");
      $cantidadhojas = $totalPagoa['numero'];
	  $totalPagob = $query->getRow("SUM(h.adeporte) as total","linea l, movil m, hoja_control h","where l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='1' and  h.fecha_de_compra='".$hoy."'");
     $ingresohojasdeporte = $totalPagob['total'];
	 
	 $totalIngresosBS = $totalIngresosBS + $ingresohojasaporte +$ingresohojasdeporte;
         $list .= '<tbody><tr '.$par.'>
                  <td><strong>Venta</strong></td><td>Hojas</td><td>Aporte Sindical</td><td></td><td>'.$cantidadhojas.'</td>
				  <td>'.$ingresohojasaporte.'</td> <td></td>
				 
                  </tr>
				  <tr '.$par.'>
                  <td><strong></strong></td><td></td><td>Aporte Pro Deporte</td><td></td><td>'.$cantidadhojas.'</td>
				  <td>'.$ingresohojasdeporte.'</td> <td></td>
				 
                  </tr>
				  <tr '.$par.'>
                  <td><strong>Total Ingresos</strong></td><td></td><td></td><td></td><td></td>
				  <td><strong>'.$totalIngresosBS.'</strong></td> <td><strong>'.$totalIngresosSUS.'</strong></td>
				 
                  </tr>
				
				  </tbody>';
            $list.='</table></center>';
			
        } else $list = '<div>No existen ingresos</div>';
		//egresos
		   $resultplan = $query->getRows("*","egresos","WHERE fecha='".$hoy."'");
        $numcp='15';
		$ini='0';
		$hojax='1';
		$mostrarsolo=$_GET["numcp"];
$iniciarde=$_GET["ini"];		 
$numerarcpx=$iniciarde;
		$numplan = count($resultplan);
        if($numplan > 0) {
            $list2 ='<center><table border = "1">
              <thead><tr>
			    <th>Nro</th>
				
                <th>Fecha</th>
				<th>Detalle</th>
				<th>N. REC/FAC</th>
                <th>Bolivianos</th>
                <th>Dolares</th>
				
              </tr></thead>';
            $x = 0;
            foreach ($resultplan as $key=>$value) {
                $x++;
                if(($x%2)==0)
                    $par = "class='TdAlt'";
                else $par = "";
                $numero=($numerarcpx+1);
              
                $list2 .= '<tbody><tr '.$par.'>
				  <td>'.$numero.'</td>
				    <td>'.$value["fecha"].'</td>
					 <td>'.$value["concepto"].'</td>
					 	 <td>'.$value["numero"].'</td>
				  <td>'.$value["monto_egreso"].'</td>
				  <td>'.$value["monto_dolar"].'</td>
                 
                  </tr></tbody>';
				  
$numerarcpx=$numerarcpx+1;
$totalEgresossBS += $value["monto_egreso"];
$totalEgresosSUS += $value["monto_dolar"];
            }
             $list2 .= '<tbody><tr '.$par.'>
                  <td><strong>Total Egresos</strong></td><td></td><td></td><td></td>
				  <td><strong>'.$totalEgresossBS.'</strong></td> <td><strong>'.$totalEgresosSUS.'</strong></td>
				 
                  </tr>
				
				  </tbody>';
            $list2.='</table></center>';
        } else $list2 = '<div>No existes egresos</div>';
		//fin egresos
		
		$selectweeks=0;
					$interes = $query ->getRow("MAX(idcaja) as ultimo","caja");
 $idcajan = $interes['ultimo'];

	 $cajaanteriorbs = $query->getRow("cajanueva as total","caja","where idcaja='".$idcajan."'");
	  $cajaanteriorbs = $cajaanteriorbs['total'];
     $cajaanteriorsus = $query->getRow("cajanuevasus as total","caja","where idcaja='".$idcajan."'");
	 	  $cajaanteriorsus = $cajaanteriorsus['total'];
		  
      // $totalDiaBs = $query->getRow("cajanueva as totalDiabs","caja","where estado='activado'");
       // $totalDiaDs = $query->getRow("cajanuevasus as totalDiadl","caja","where estado='activado'");
		
		$template->SetParameter('saldoAntB',$cajaanteriorbs);
		$template->SetParameter('saldoAntS',$cajaanteriorsus);
		//$resultplan = $query->getRows("","ingreso i,tipo_ingreso t","WHERE i.id_tipo_ingreso=t.id_tipo_ingreso and t.linea='1' and i.arqueo='0'");
    
 // $totalDiaBs = $query->getRow("SUM(i.monto_pago_ingreso) as totalDiabs","ingreso i,tipo_ingreso t","where i.id_tipo_ingreso=t.id_tipo_ingreso and t.linea='1' and i.arqueo='0'");
      //  $totalDiaDs = $query->getRow("SUM(i.monto_ingreso_dolar) as totalDiadl","ingreso i,tipo_ingreso t","where i.id_tipo_ingreso=t.id_tipo_ingreso and t.linea='1' and i.arqueo='0'");
		$totaldisponible= $cajaanteriorbs+ $totalIngresosBS;
		
		$totaldisponiblesus= $cajaanteriorsus + $totalIngresosSUS;
		$totalSaldoBsDia=$totalIngresosBS- $totalEgresossBS;
		$totalSaldoSusDia=$totalIngresosSUS - $totalEgresosSUS;
		
		$template->SetParameter('totalDispB',$totaldisponible);
		$template->SetParameter('totalDispS',$totaldisponiblesus);
		$totalSaldoBs = $totaldisponible - $totalEgresossBS;
		$totalSaldoSus=$totaldisponiblesus - $totalEgresosSUS;
		$template->SetParameter('saldoDispB',$totalSaldoBs);
		$template->SetParameter('saldoDispS',$totalSaldoSus);
		
		$template->SetParameter('saldoDiaB',$totalSaldoBsDia);
		$template->SetParameter('saldoDiaS',$totalSaldoSusDia);
		//$template->SetParameter('total',$totalPago);
        $buttonAdd = '<input type="button" value="Arquear" onclick="window.location.href=\'arqueo.php?accion=calcularPlan&id='.$_GET['id'].'\'">';
		$template->SetParameter('accion','calcularPlan');
        $template->SetParameter('Add','');//$buttonAdd);
		//$template->SetParameter('contenido',$list3);
		$template->SetParameter('contenido',$list);
		
		$template->SetParameter('contenido2',$list2);
		$template->SetParameter('contenido3',$list3);
		return $template->Display();
	}
	
function planPagos2()
	{
		$template = new template;
		$template->SetTemplate('html/lista_arqueoitems2.html'); //sets the template for this function
		
		//DataBase Conexion//
		$query = new query;
		
       		$hoy=date("Y-m-d");

$resultplan = $query->getRows("i.id_movil,t.tipo_ingreso,i.fecha_ingreso,i.numero_registro,i.monto_pago_ingreso,i.monto_ingreso_dolar","linea l, movil m, ingreso i,tipo_ingreso t","where i.id_tipo_ingreso=t.id_tipo_ingreso and l.id_linea=m.id_linea and m.id_movil=i.id_movil and l.id_linea='1' and  i.fecha_ingreso='".$hoy."'");
$numcp='15';
		$ini='0';
		$hojax='1';
		$mostrarsolo=$_GET["numcp"];
$iniciarde=$_GET["ini"];		 
$numerarcpx=$iniciarde;
		$numplan = count($resultplan);
        if($numplan > 0) {
            $list ='<center><table border = "1">
              <thead><tr>
			    <th>Nro</th>
				<th>Fecha</th>
                <th>Detalle</th>
				<th>N. Recibo</th>
				<th>Cant.</th>
                <th>Bolivianos</th>
                <th>Dolares</th>
			
              </tr></thead>';
            $x = 0;
            foreach ($resultplan as $key=>$value) {
                $x++;
                if(($x%2)==0)
                    $par = "class='TdAlt'";
                else $par = "";
                $numero=($numerarcpx+1);
              
                $list .= '<tbody><tr '.$par.'>
				  <td>'.$numero.'</td>
				    <td>'.$value["fecha_ingreso"].'</td>
					 <td>'.$value["tipo_ingreso"].'</td>
					 <td>'.$value["numero_registro"].'</td>
					 <td>'.$value["cantidad"].'</td>
				  <td>'.$value["monto_pago_ingreso"].'</td>
				  <td>'.$value["monto_ingreso_dolar"].'</td>
                 
                  </tr></tbody>';
				  
$numerarcpx=$numerarcpx+1;
$totalIngresosBS += $value["monto_pago_ingreso"];
$totalIngresosSUS += $value["monto_ingreso_dolar"];
            }
			
		$totalPagoa = $query->getRow("SUM(h.aporte) as total","linea l, movil m, hoja_control h","where l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='1' and  h.fecha_de_compra='".$hoy."'");
      $ingresohojasaporte = $totalPagoa['total'];
	  $totalPagoa = $query->getRow("COUNT( h.numero_hoja ) AS numero","linea l, movil m, hoja_control h","where l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='1' and  h.fecha_de_compra='".$hoy."'");
      $cantidadhojas = $totalPagoa['numero'];
	  $totalPagob = $query->getRow("SUM(h.adeporte) as total","linea l, movil m, hoja_control h","where l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='1' and  h.fecha_de_compra='".$hoy."'");
     $ingresohojasdeporte = $totalPagob['total'];
	 
	 $totalIngresosBS = $totalIngresosBS + $ingresohojasaporte +$ingresohojasdeporte;
         $list .= '<tbody><tr '.$par.'>
                  <td><strong>Venta</strong></td><td>Hojas</td><td>Aporte Sindical</td><td></td><td>'.$cantidadhojas.'</td>
				  <td>'.$ingresohojasaporte.'</td> <td></td>
				 
                  </tr>
				  <tr '.$par.'>
                  <td><strong></strong></td><td></td><td>Aporte Pro Deporte</td><td></td><td>'.$cantidadhojas.'</td>
				  <td>'.$ingresohojasdeporte.'</td> <td></td>
				 
                  </tr>
				  <tr '.$par.'>
                  <td><strong>Total Ingresos</strong></td><td></td><td></td><td></td><td></td>
				  <td><strong>'.$totalIngresosBS.'</strong></td> <td><strong>'.$totalIngresosSUS.'</strong></td>
				 
                  </tr>
				
				  </tbody>';
            $list.='</table></center>';
			
        } else $list = '<div>No existen ingresos</div>';
		//egresos
		   $resultplan = $query->getRows("*","egresos","WHERE fecha='".$hoy."'");
        $numcp='15';
		$ini='0';
		$hojax='1';
		$mostrarsolo=$_GET["numcp"];
$iniciarde=$_GET["ini"];		 
$numerarcpx=$iniciarde;
		$numplan = count($resultplan);
        if($numplan > 0) {
            $list2 ='<center><table border = "1">
              <thead><tr>
			    <th>Nro</th>
				
                <th>Fecha</th>
				<th>Detalle</th>
				<th>N. REC/FAC</th>
                <th>Bolivianos</th>
                <th>Dolares</th>
				
              </tr></thead>';
            $x = 0;
            foreach ($resultplan as $key=>$value) {
                $x++;
                if(($x%2)==0)
                    $par = "class='TdAlt'";
                else $par = "";
                $numero=($numerarcpx+1);
              
                $list2 .= '<tbody><tr '.$par.'>
				  <td>'.$numero.'</td>
				    <td>'.$value["fecha"].'</td>
					 <td>'.$value["concepto"].'</td>
					 	 <td>'.$value["numero"].'</td>
				  <td>'.$value["monto_egreso"].'</td>
				  <td>'.$value["monto_dolar"].'</td>
                 
                  </tr></tbody>';
				  
$numerarcpx=$numerarcpx+1;
$totalEgresossBS += $value["monto_egreso"];
$totalEgresosSUS += $value["monto_dolar"];
            }
             $list2 .= '<tbody><tr '.$par.'>
                  <td><strong>Total Egresos</strong></td><td></td><td></td><td></td>
				  <td><strong>'.$totalEgresossBS.'</strong></td> <td><strong>'.$totalEgresosSUS.'</strong></td>
				 
                  </tr>
				
				  </tbody>';
            $list2.='</table></center>';
        } else $list2 = '<div>No existes egresos</div>';
		//fin egresos
		
		$selectweeks=0;
					$interes = $query ->getRow("MAX(idcaja) as ultimo","caja");
 $idcajan = $interes['ultimo'];

	 $cajaanteriorbs = $query->getRow("cajanueva as total","caja","where idcaja='".$idcajan."'");
	  $cajaanteriorbs = $cajaanteriorbs['total'];
     $cajaanteriorsus = $query->getRow("cajanuevasus as total","caja","where idcaja='".$idcajan."'");
	 	  $cajaanteriorsus = $cajaanteriorsus['total'];
		  
      // $totalDiaBs = $query->getRow("cajanueva as totalDiabs","caja","where estado='activado'");
       // $totalDiaDs = $query->getRow("cajanuevasus as totalDiadl","caja","where estado='activado'");
		
		$template->SetParameter('saldoAntB',$cajaanteriorbs);
		$template->SetParameter('saldoAntS',$cajaanteriorsus);
		//$resultplan = $query->getRows("","ingreso i,tipo_ingreso t","WHERE i.id_tipo_ingreso=t.id_tipo_ingreso and t.linea='1' and i.arqueo='0'");
    
 // $totalDiaBs = $query->getRow("SUM(i.monto_pago_ingreso) as totalDiabs","ingreso i,tipo_ingreso t","where i.id_tipo_ingreso=t.id_tipo_ingreso and t.linea='1' and i.arqueo='0'");
      //  $totalDiaDs = $query->getRow("SUM(i.monto_ingreso_dolar) as totalDiadl","ingreso i,tipo_ingreso t","where i.id_tipo_ingreso=t.id_tipo_ingreso and t.linea='1' and i.arqueo='0'");
		$totaldisponible= $cajaanteriorbs+ $totalIngresosBS;
		
		$totaldisponiblesus= $cajaanteriorsus + $totalIngresosSUS;
		$totalSaldoBsDia=$totalIngresosBS- $totalEgresossBS;
		$totalSaldoSusDia=$totalIngresosSUS - $totalEgresosSUS;
		
		$template->SetParameter('totalDispB',$totaldisponible);
		$template->SetParameter('totalDispS',$totaldisponiblesus);
		$totalSaldoBs = $totaldisponible - $totalEgresossBS;
		$totalSaldoSus=$totaldisponiblesus - $totalEgresosSUS;
		$template->SetParameter('saldoDispB',$totalSaldoBs);
		$template->SetParameter('saldoDispS',$totalSaldoSus);
		
		$template->SetParameter('saldoDiaB',$totalSaldoBsDia);
		$template->SetParameter('saldoDiaS',$totalSaldoSusDia);
		//$template->SetParameter('total',$totalPago);
        $buttonAdd = '<input type="button" value="Arquear" onclick="window.location.href=\'arqueo.php?accion=calcularPlan&id='.$_GET['id'].'\'">';
		$template->SetParameter('accion','calcularPlan');
        $template->SetParameter('Add','');//$buttonAdd);
		//$template->SetParameter('contenido',$list3);
		$template->SetParameter('contenido',$list);
		
		$template->SetParameter('contenido2',$list2);
		$template->SetParameter('contenido3',$list3);
		return $template->Display();
	}
		function ingresarPago()//list of all payments and new ones
	{
		$template = new template;
		$template->SetTemplate('html/lista_pagoshechos.html'); //sets the template for this function
		$confirm="javascript:return confirm('Esta seguro de eliminar este deposito?');";
        
		//DataBase Conexion//
		$query = new query;
		$resultprestamo = $query -> getRow("*","prestamo_socio","where id_prestamo = ".$_GET[id]);
        $socio = $query -> getRow("*","socio","where id_socio = ".$resultprestamo['socio']);
		$chofer = $query ->getRow("*","chofer","where id_chofer = ".$resultprestamo['chofer']);
		$interes = $query ->getRow("*","tipo_prestamo","where id_tipo_prestamo = ".$resultprestamo['id_tipo_prestamo']);
        $resultdeposito = $query->getRows("*","deposito","WHERE id_prestamo=".$_GET['id']." ORDER by id_deposito");
		$totalPago = $resultprestamo['monto_prestamo'] + ($resultprestamo['monto_prestamo']*$interes['interes']/100);
		$resultPlan = $query -> getRow("*","plan_de_pagos","where id_prestamo = ".$_GET[id]);
        $numdeposito = count($resultdeposito);
        if($numdeposito > 0) {
            $list ='<center><table border = "2">
              <thead><tr>
                <th>Fecha</th>
                <th>Monto depositado</th>
				
				<th></th>
              </tr></thead>';
            $x = 0;
			$totalDepositos=0;
            foreach ($resultdeposito as $key=>$value) {
                $x++;
                if(($x%2)==0)
                    $par = "class='TdAlt'";
                else $par = "";
                    $list .= '<tbody><tr '.$par.'>
                  <td>'.$value["fecha_deposito"].' </td>
				  <td>'.$value["monto_deposito"].' Bs.</td>
				 
				   <td><a href="imprimirRecibo2.php?numHoja='.$value["id_deposito"].'" target="_blank" onClick="window.open(this.href, this.target); return false;" title="Imprimir Recibo">[Imprimir]</a></td>
				  <td><a href="arqueo.php?accion=deleteP&id='.$value["id_deposito"].'" onClick="'.$confirm.'" title="Eliminar Deposito"><img src="images/delete.gif"></a></td>

                  </tr></tbody>';
				  $totalDepositos += $value["monto_deposito"];
				    $resultprestamo = $query -> getRow("*","prestamo_socio","where id_prestamo = ".$_GET[id]);
        $interes = $query ->getRow("*","tipo_prestamo","where id_tipo_prestamo = ".$resultprestamo['id_tipo_prestamo']);
        $totalPago = $resultprestamo['monto_prestamo'] + ($resultprestamo['monto_prestamo']*$interes['interes']/100);
		
				  $saldo= $totalPago - $totalDepositos;
				 
            }
			$list .= '<tbody><tr '.$par.'>
                  <td><strong>Total depositado</strong></td>
				  <td><strong>'.$totalDepositos.' Bs.</strong></td>
				 
                  </tr>
				  <tr '.$par.'>
                  <td><strong>Saldo por pagar</strong></td>
				  <td><strong>'.$saldo.' Bs.</strong></td>
				 
                  </tr>
				  </tbody>';
            $list.='</table></center>';
        } else $list = '<div>No existen depositos registrados</div>';
		$hoy=date("Y-m-d");
		
		$nombreSocio = $socio['nombre_socio']." ".$socio['apellido1_socio']." ".$socio['apellido2_socio'];
		$template->SetParameter('nombreSocio',"<span>".$nombreSocio."</span><input type=\"hidden\" name=\"idSocio\" value=\"".$socio['id_socio']."\">");
		$template->SetParameter('nombreChofer',"<span>".$chofer['nombre_chofer']."</span><input type=\"hidden\" name=\"idChofer\" value=\"".$chofer['idchofer']."\">");
        $template->SetParameter('montoPrestamo',$resultprestamo['monto_prestamo']);
		$template->SetParameter('id_prestamo',$resultprestamo['id_prestamo']);
		$template->SetParameter('descripcionPrestamo',$resultprestamo['descripcion_prestamo']);
		$template->SetParameter('fecha_pago',$hoy);
		
		$template->SetParameter('semanal',$resultPlan['monto_pago']);
		$template->SetParameter('interes',$interes['interes']);
		$template->SetParameter('total',$totalPago);
        $buttonAdd = '<input type="button" value="GUARDAR" onclick="window.location.href=\'arqueo.php?accion=guardarPago&id='.$_GET['id'].'\'">';
		$template->SetParameter('accion','guardarPago');
        $template->SetParameter('Add','');//$buttonAdd);
		$template->SetParameter('contenido',$list);
		return $template->Display();
	}
	
    function listarPrestamos() //list for default the all items
	{
		$template = new template;
		$template->SetTemplate('html/lista_arqueo.html'); //sets the template for this function
		//$template->SetParameter('hoy',date('d-M-Y'));
        //$hoy = date('Y-m-d');
		$template->SetParameter('hoy',date('d-M-Y'));
                $template->SetParameter('filtroFecha','');
                $hoy = date('Y-m-d');
		
		 	//$hoy=date("Y-m-d");
		//DataBase Conexion//
		$query = new query;
        $confirm="javascript:return confirm('Esta seguro de eliminar?');";
       // $resultprestamo = $query->getRows("*","prestamo_socio a, tipo_prestamo b","WHERE a.id_tipo_prestamo=b.id_tipo_prestamo");
        //$init = (($_GET['page'] == "" ? 1 : $_GET['page']) - 1) * 10;
						$interes = $query ->getRow("MAX(idcaja) as ultimo","caja");
 $idcajan = $interes['ultimo'];
		
 $resultprestamo1 = $query->getRows("*","caja","WHERE idcaja='".$idcajan."'");
              
	   //$resultprestamo1 = $query->getRows("*","prestamo_socio  a, tipo_prestamo b","WHERE a.id_tipo_prestamo=b.id_tipo_prestamo ");
        $numprestamo = count($resultprestamo1);
        if($numprestamo > 0) {
            $list ='<table border = "1">
              <thead><tr>
			  
                <th>Fecha Registro</th>
			    <th>Saldo Anterior</th>
                <th>Ingresos Bs</th>
                <th>Ingresos Sus</th>
				<th>Egresos Bs</th>
                <th>Egresos Sus</th>
		        <th>Saldo Bs</th>
				<th>Saldo Sus</th>
		<th>Arquear</th>
		
              </tr></thead>';
            $x = 0;
            foreach ($resultprestamo1 as $key=>$value) {
                $x++;
                if(($x%2)==0)
                    $par = "class='TdAlt'";
                else $par = "";
          //     	".$value['id_movil']."
		//hola
	
	 $totalPagoa = $query->getRow("SUM(h.aporte) as total","linea l, movil m, hoja_control h","where l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='1' and  h.fecha_de_compra='".$hoy."'");
      $ingresohojasaporte = $totalPagoa['total'];
	  $totalPagob = $query->getRow("SUM(h.adeporte) as total","linea l, movil m, hoja_control h","where l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='1' and  h.fecha_de_compra='".$hoy."'");
     $ingresohojasdeporte = $totalPagob['total'];
	 
	 // $totalPago = $query->getRow("SUM(monto_pago_ingreso) as total","ingreso","where fecha_ingreso='".$hoy."'");
     // $ingresobs = $totalPago['total'];
	  $totalPago = $query->getRow("SUM(i.monto_pago_ingreso) as total","ingreso i,linea l, movil m","where l.id_linea=m.id_linea and m.id_movil=i.id_movil and l.id_linea='1' and i.fecha_ingreso='".$hoy."'");
      $ingresobs = $totalPago['total'];
	  
	  $ingresobsfin =$ingresobs + $ingresohojasaporte + $ingresohojasdeporte;
	   $totalPago = $query->getRow("SUM(i.monto_ingreso_dolar) as total","ingreso i,linea l, movil m","where l.id_linea=m.id_linea and m.id_movil=i.id_movil and l.id_linea='1' and i.fecha_ingreso='".$hoy."'");
      $ingresosus = $totalPago['total'];
	//     $totalPago = $query->getRow("SUM(monto_ingreso_dolar) as total","ingreso","where fecha_ingreso='".$hoy."'");
     // $ingresosus = $totalPago['total'];
	  $totalPago = $query->getRow("SUM(monto_egreso) as total","egresos","where fecha='".$hoy."'");
      $egresobs = $totalPago['total'];
	  
	   $totalPago = $query->getRow("SUM(monto_dolar) as total","egresos","where fecha='".$hoy."'");
      $egresosus = $totalPago['total'];
	 
		 $cajaanterior = $value["cajanueva"];
		 $cajaanteriorsus = $value["cajanuevasus"];
				$saldobs = $cajaanterior + $ingresobs  + $ingresohojasaporte + $ingresohojasdeporte - $egresobs;
				$saldosus = $cajaanteriorsus + $ingresosus - $egresosus;
				
				//$total = $query -> getRow("SUM(monto_deposito) as total","deposito","where id_prestamo = ".$value['id_prestamo']);
				//$falta = $totalPago - $total["total"];
				
                $list .= '<tbody><tr '.$par.'>
				
                  <td>'.$hoy.'</td>
				     <td>'.$value["cajanueva"].'</td>
                     <td>'.$ingresobsfin.'</td>
                  <td>'.$ingresosus.'</td>
				  <td>'.$egresobs.'</td>
                  <td>'.$egresosus.'</td>
                <td>'.$saldobs.'</td>
                  <td>'.$saldosus.'</td>
				  <td><a href="arqueo.php?accion=plan&id='.$value["id_caja"].'" title="Ver detalle movimiento"><img src="images/plan.gif"></a></td>
				  <td><a href="arqueo.php?accion=planprint&id='.$value["id_caja"].'" 
				 target="_blank" onClick="window.open(this.href, this.target); return false;"  title="Imprimir Informe">[Imprimir detalle]</a></td>
                  

                  </tr></tbody>';
            }
            $list.='</table>';
            //$list .= paging::navigation(count($resultprestamo),"arqueo.php",10);//lorgio
			// <td><a href="arqueo.php?accion=delete&id='.$value["id_caja"].'" onClick="'.$confirm.'" title="Eliminar "><img src="images/delete.gif"></a></td>
				 
        } else $list = '<div>No existen montos registrados</div>';
        $buttonAdd = '<input type="button" value="Nuevo" onclick="window.location.href=\'arqueo.php?accion=registro\'">';
        $template->SetParameter('add',$buttonAdd);
		$totalDiaBs1 = $query->getRow("SUM(monto_deposito) as totalDiabs","deposito d, prestamo_socio a, tipo_prestamo b","where b.interes!='0.00' and a.id_prestamo=d.id_prestamo and a.id_tipo_prestamo=b.id_tipo_prestamo and d.fecha_deposito = '".$hoy."'");
        
		//$totalDiaBs = $query->getRow("SUM(monto_deposito) as totalDiabs","deposito","where fecha_deposito = '".$hoy."'");
        $template->SetParameter('totalDia',"<br />: ".$totalDiaBs2['totalDiabs']."");
		
		$template->SetParameter('contenido',$list);
		return $template->Display();
	}
    function filtroFecha() //list for default the all items
	{
        $fechaFiltro = $_GET['filtro'];
		$query = new query;
								$interes = $query ->getRow("MAX(idcaja) as ultimo","caja");
 $idcajan = $interes['ultimo'];
		
 $resulthoja1 = $query->getRows("*","caja","WHERE idcaja='".$idcajan."'");

       // $resulthoja = $query->getRows("*","ingreso","where fecha_ingreso = '".$fechaFiltro."' ORDER BY numero_registro");
        //$init = (($_GET['page'] == "" ? 1 : $_GET['page']) - 1) * 20;
        $resulthoja1 = $query->getRows("*","caja","where fecharegistro = '".$fechaFiltro."' ORDER BY idcaja ");
        $numhoja = count($resulthoja1);
		
	$totalDia = $query->getRow("SUM(cajanueva) as totalDia","caja","where fecharegistro = '".$fechaFiltro."'");
      $totalbs = $totalDia['totalDia'];
       $totalDl = $query->getRow("SUM(cajanuevasus) as totalD","caja","where fecharegistro = '".$fechaFiltro."'");
      $totaldolar = $totalDl['totalD'];
      
        $list = '<form name="formRecibir" method="POST" action="ingreso.php?accion=recibir">';
        if($numhoja > 0) {
           $list ='<table border = "1">
              <thead>
	      <tr><b>Caja Bs:<b>'.$totalbs.'<tr><b> Caja Dolar <b>'.$totaldolar.'</tr>
		
	      <tr>
          <th>Fecha Registro</th>
			    <th>Saldo Anterior</th>
                <th>Ingresos Bs</th>
                <th>Ingresos Sus</th>
				<th>Egresos Bs</th>
                <th>Egresos Sus</th>
		        <th>Saldo Bs</th>
				<th>Saldo Sus</th>
		
		</tr></thead>';
            $x = 0;
            foreach ($resulthoja1 as $key=>$value) {
                $x++;
                if(($x%2)==0)
                    $par = "class='TdAlt'";
                else $par = "";
				/////////////////////////////////////////////////
				$totalPagoa = $query->getRow("SUM(h.aporte) as total","linea l, movil m, hoja_control h","where l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='1' and  h.fecha_de_compra='".$fechaFiltro."'");
      $ingresohojasaporte = $totalPagoa['total'];
	  $totalPagob = $query->getRow("SUM(h.adeporte) as total","linea l, movil m, hoja_control h","where l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='1' and  h.fecha_de_compra='".$fechaFiltro."'");
     $ingresohojasdeporte = $totalPagob['total'];
	 
	  $totalPago = $query->getRow("SUM(monto_pago_ingreso) as total","ingreso","where fecha_ingreso='".$fechaFiltro."'");
      $ingresobs = $totalPago['total'];
	  $ingresobsfin =$ingresobs + $ingresohojasaporte + $ingresohojasdeporte;
	   $totalPago = $query->getRow("SUM(monto_ingreso_dolar) as total","ingreso","where fecha_ingreso='".$fechaFiltro."'");
      $ingresosus = $totalPago['total'];
	  $totalPago = $query->getRow("SUM(monto_egreso) as total","egresos","where fecha='".$fechaFiltro."'");
      $egresobs = $totalPago['total'];
	  
	   $totalPago = $query->getRow("SUM(monto_dolar) as total","egresos","where fecha='".$fechaFiltro."'");
      $egresosus = $totalPago['total'];
	 
		 $cajaanterior = $value["cajanueva"];
		 $cajaanteriorsus = $value["cajanuevasus"];
				$saldobs = $cajaanterior + $ingresobs  + $ingresohojasaporte + $ingresohojasdeporte - $egresobs;
				$saldosus = $cajaanteriorsus + $ingresosus - $egresosus;
				
				//$total = $query -> getRow("SUM(monto_deposito) as total","deposito","where id_prestamo = ".$value['id_prestamo']);
				//$falta = $totalPago - $total["total"];
				
                $list .= '<tbody><tr '.$par.'>
				
                  <td>'.$fechaFiltro.'</td>
				     <td>'.$value["cajanueva"].'</td>
                     <td>'.$ingresobsfin.'</td>
                  <td>'.$ingresosus.'</td>
				  <td>'.$egresobs.'</td>
                  <td>'.$egresosus.'</td>
                <td>'.$saldobs.'</td>
                  <td>'.$saldosus.'</td>
		   <td><a href="arqueo.php?accion=planprint&id='.$fechaFiltro.'" 
				 target="_blank" onClick="window.open(this.href, this.target); return false;"  title="Imprimir Informe">[Imprimir detalle]</a></td>
                 
              
	     </tr></tbody>';
            }
            $list.='</table>';
           // $list .= paging::navigation(count($resulthoja),"ingresos.php",20);
        } else $list = '<div>No existen registros para la fecha '.$fechaFiltro.'</div>';
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
            $template->SetParameter('contenido',$this->listarPrestamos());
        }
        if($_GET['accion']=="registro"){
            $template->SetParameter('contenido',$this->registrarPrestamo());
        }
        if($_GET['accion']=="modificar"){
            $template->SetParameter('contenido',$this->modificarPrestamo());
        }
        if($_GET['accion']=="plan"){
            $template->SetParameter('contenido',$this->planPagos());
        }
		if($_GET['accion']=="planprint"){
            $template->SetParameter('contenido',$this->planPagos2());
        }
		if($_GET['accion']=="pago"){
            $template->SetParameter('contenido',$this->ingresarPago());
        }
		if($_GET['accion']=="guardarPago"){
            $template->SetParameter('contenido',$this->guardarPago());
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
