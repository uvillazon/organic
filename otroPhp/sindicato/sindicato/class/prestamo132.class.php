<?php
class prestamo
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
		$template->SetTemplate('html/form_prestamo132.html');
        $template->SetParameter('licencia',"<input name=\"licencia\" type=\"text\" id=\"licencia\" onblur=\"if(document.mframe.licencia.value > 0) {ajax('nombreSocio','prestamo132.php?accion=buscarSocio&licencia=' + document.mframe.licencia.value, '');}\" size=\"8\">");
		
		$template->SetParameter('licencia2',"<input name=\"licencia2\" type=\"text\" id=\"licencia2\" onblur=\"if(document.mframe.licencia2.value > 0) {ajax('nombreChofer','prestamo132.php?accion=buscarChofer&licencia=' + document.mframe.licencia2.value, '');}\" size=\"8\">");
		
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
		$template->SetTemplate('html/form_prestamo132.html');
        $template->SetParameter('licencia',"<input name=\"licencia\" type=\"text\" id=\"licencia\" onblur=\"if(document.mframe.licencia.value > 0) {ajax('nombreSocio','prestamo132.php?accion=buscarSocio&licencia=' + document.mframe.licencia.value, '');}\" size=\"8\" value=".$socio['num_licencia'].">");
		
		$template->SetParameter('licencia2',"<input name=\"licencia2\" type=\"text\" id=\"licencia2\" onblur=\"if(document.mframe.licencia2.value > 0) {ajax('nombreChofer','prestamo132.php?accion=buscarChofer&licencia=' + document.mframe.licencia2.value, '');}\" size=\"8\" value=".$chofer['num_chofer'].">");
		
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
          echo "<script>window.location.href='prestamo132.php'</script>";
	       }
	    }
		}
		
		else
		if($query->dbDelete("prestamo_socio","WHERE id_prestamo = ".$_GET['id']))
		   
          echo "<script>alert('Prestamo elminado exitosamente')</script>";
          echo "<script>window.location.href='prestamo132.php'</script>";
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
			echo "<script>window.location.href='prestamo132.php'</script>";
		}
		else{ //error
			echo "<script>alert('Error en el registro');</script>";
			echo "<script>window.location.href='prestamo132.php'</script>";
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
			echo "<script>window.location.href='prestamo132.php'</script>";
		}
		else{ //error
			echo "<script>alert('Error en el registro');</script>";
			echo "<script>window.location.href='prestamo132.php'</script>";
		}
    }
	
	function calcularPlan()
	{
		$query = new query;
		//clean all plan
		if($query->dbDelete("plan_de_pagos","WHERE id_prestamo = ".$_POST['id_prestamo']))
            echo "";//"<script>alert('Pagos elminado exitosamente')</script>";
		$resultprestamo = $query -> getRow("*","prestamo_socio","where id_prestamo = ".$_POST[id_prestamo]);
		$interes = $query ->getRow("*","tipo_prestamo","where id_tipo_prestamo = ".$resultprestamo['id_tipo_prestamo']);
		$saldo = $_POST['total'];
		$numero_semana = $_POST['numero_semana'];
		$update['semanas'] =$numero_semana;
		$query->dbUpdate($update,"prestamo_socio","where id_prestamo = ".$_POST['id_prestamo']);
		
		$interes = $resultprestamo['monto_prestamo']*$interes['interes']/100;
		$capitalSem = $resultprestamo['monto_prestamo']/$numero_semana;
		$interesSem = $interes/$numero_semana;
		$monto_semana = $resultprestamo['monto_prestamo']/$numero_semana;
        for ($m=1;$m<=$numero_semana;$m++)
		{
			$str = "+".$m." week";
			$fecha_pago = date('Y-m-d', strtotime($str));
			$insert['id_prestamo'] = $_POST['id_prestamo'];
	        $insert['capitalsem']= $capitalSem;
			$insert['interessem'] = $interesSem;
			$insert['monto_pago'] = $monto_semana + $interesSem;
			$insert['fecha_pago'] = $fecha_pago;
	        $insert['saldo_pago'] = $_POST['total'] - (($monto_semana + $interesSem)*$m);
			$insert['semana'] = $m;
			$insert['monto_semana'] = $resultprestamo['monto_prestamo'] + $interesSem*$m;
			$insert['pagado'] = $resultprestamo['monto_prestamo'] = $interesSem*$m;
			if($query->dbInsert($insert,"plan_de_pagos")){ //save in the data base	
			}
		}
		echo "<script>window.location.href='prestamo132.php?accion=plan&id=".$_POST['id_prestamo']."'</script>";
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
		echo "<script>window.location.href='prestamo132.php?accion=pago&id=".$_POST['id_prestamo']."'</script>";
	}
	function deletePago(){
        $query = new query;
		
		//$ide=$_GET['id'];
		//$deposito=$query->getRows("*","deposito","WHERE id_deposito = ".$_GET['id']);
	 
		  if($query->dbDelete("deposito","WHERE id_deposito = ".$_GET['id']))
		  { 
          echo "<script>alert('Deposito eliminado exitosamente')</script>";
          echo "<script>window.location.href='prestamo132.php'</script>";
	       }
		
		else
	      echo "<script>alert('Fallo la eliminacion')</script>";
          echo "<script>window.location.href='prestamo132.php'</script>";
	}

	function planPagos()
	{
		$template = new template;
		$template->SetTemplate('html/lista_pagos132.html'); //sets the template for this function
		
		//DataBase Conexion//
		$query = new query;
		$resultprestamo = $query -> getRow("*","prestamo_socio","where id_prestamo = ".$_GET[id]);
        $socio = $query -> getRow("*","socio","where id_socio = ".$resultprestamo['socio']);
		$chofer = $query ->getRow("*","chofer","where id_chofer = ".$resultprestamo['chofer']);
		$interes = $query ->getRow("*","tipo_prestamo","where id_tipo_prestamo = ".$resultprestamo['id_tipo_prestamo']);
        $resultplan = $query->getRows("*","plan_de_pagos","WHERE id_prestamo=".$_GET['id']." ORDER by id_plan");
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
				<th>Capital</th>
                <th>Interes</th>
				<th>Monto a Pagar</th>
                <th>Saldo</th>
				<th>Monto adelantado</th>
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
				    <td>'.$value["fecha_pago"].'</td>
				  <td>'.$value["capitalsem"].'</td>
				  <td>'.$value["interessem"].'</td>
                  <td>'.$value["monto_pago"].'</td>
				  <td>'.$value["saldo_pago"].'</td>
				  <td>'.$value["monto_semana"].'</td>
                  </tr></tbody>';
				  
$numerarcpx=$numerarcpx+1;

            }
            $list.='</table></center>';
        } else $list = '<div>No existe un Plan de pagos registrado</div>';
		$selectweeks=0;
		for($m=4;$m<25;$m++)
			$selectweeks .= "<option value='".$m."'>".$m."</option>";
		$totalPago = $resultprestamo['monto_prestamo'] + ($resultprestamo['monto_prestamo']*$interes['interes']/100);
		$nombreSocio = $socio['nombre_socio']." ".$socio['apellido1_socio']." ".$socio['apellido2_socio'];
		$template->SetParameter('nombreSocio',"<span>".$nombreSocio."</span><input type=\"hidden\" name=\"idSocio\" value=\"".$socio['id_socio']."\">");
		$template->SetParameter('nombreChofer',"<span>".$chofer['nombre_chofer']."</span><input type=\"hidden\" name=\"idChofer\" value=\"".$chofer['idchofer']."\">");
        $template->SetParameter('montoPrestamo',$resultprestamo['monto_prestamo']);
		$template->SetParameter('id_prestamo',$resultprestamo['id_prestamo']);
		$template->SetParameter('descripcionPrestamo',$resultprestamo['descripcion_prestamo']);
		$template->SetParameter('weeks',$selectweeks);
		$template->SetParameter('tipoprestamo',$script);
		$template->SetParameter('interes',$interes['interes']);
		$template->SetParameter('total',$totalPago);
        $buttonAdd = '<input type="button" value="CALCULAR Y GUARDAR" onclick="window.location.href=\'prestamo132.php?accion=calcularPlan&id='.$_GET['id'].'\'">';
		$template->SetParameter('accion','calcularPlan');
        $template->SetParameter('Add','');//$buttonAdd);
		$template->SetParameter('contenido',$list);
		return $template->Display();
	}
	
	function ingresarPago()//list of all payments and new ones
	{
		$template = new template;
		$template->SetTemplate('html/lista_pagoshechos132.html'); //sets the template for this function
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
				  <td><a href="prestamo132.php?accion=deleteP&id='.$value["id_deposito"].'" onClick="'.$confirm.'" title="Eliminar Deposito"><img src="images/delete.gif"></a></td>

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
        $buttonAdd = '<input type="button" value="GUARDAR" onclick="window.location.href=\'prestamo132.php?accion=guardarPago&id='.$_GET['id'].'\'">';
		$template->SetParameter('accion','guardarPago');
        $template->SetParameter('Add','');//$buttonAdd);
		$template->SetParameter('contenido',$list);
		return $template->Display();
	}
	
    function listarPrestamos() //list for default the all items
	{
		$template = new template;
		$template->SetTemplate('html/lista_prestamo132.html'); //sets the template for this function
		$template->SetParameter('hoy',date('d-M-Y'));
        $hoy = date('Y-m-d');
		
		//DataBase Conexion//
		$query = new query;
        $confirm="javascript:return confirm('Esta seguro de eliminar este prestamo?');";
		//$resultprestamo = $query->getRows("*","prestamo_socio a, tipo_prestamo b","WHERE a.id_tipo_prestamo=b.id_tipo_prestamo");
        //$init = (($_GET['page'] == "" ? 1 : $_GET['page']) - 1) * 10;
 //$resultprestamo1 = $query->getRows("*","prestamo_socio  a, tipo_prestamo b","WHERE b.interes!='0.00' and a.id_tipo_prestamo=b.id_tipo_prestamo ORDER by id_prestamo DESC");
        
        $resultprestamo1 = $query->getRows("*","prestamo_socio a, tipo_prestamo b ","WHERE a.id_tipo_prestamo=b.id_tipo_prestamo ORDER by id_prestamo DESC");
  //$resultprestamo = $query->getRows("*","prestamo_socio a, tipo_prestamo b","WHERE a.id_tipo_prestamo=b.id_tipo_prestamo");
            
	  //$init = (($_GET['page'] == "" ? 1 : $_GET['page']) - 1) * 10;
// $resultprestamo1 = $query->getRows("*","prestamo_socio  a, tipo_prestamo b","WHERE b.interes!='0.00' and a.id_tipo_prestamo=b.id_tipo_prestamo ORDER by id_prestamo DESC");
              
	   //$resultprestamo1 = $query->getRows("*","prestamo_socio  a, tipo_prestamo b","WHERE a.id_tipo_prestamo=b.id_tipo_prestamo ");
        $numprestamo = count($resultprestamo1);
        if($numprestamo > 0) {
            $list ='<table border = "1">
              <thead><tr>
			  
                <th>Fecha</th>
                <th>Monto</th>
                <th>Razon de Prestamo</th>
                <th>Tipo</th>
				<th>Socio</th>
                <th>Pagado</th>
		<th>Por pagar</th>
				
		<th>Plan</th>
				<th>Pagos</th>
                <th>Modificar</th>
                <th>Eliminar</th>
              </tr></thead>';
            $x = 0;
            foreach ($resultprestamo1 as $key=>$value) {
                $x++;
                if(($x%2)==0)
                    $par = "class='TdAlt'";
                else $par = "";
                $socio = $query->getRow("*","socio","where id_socio = ".$value['socio']);
                $nombreCompleto = $socio['nombre_socio']." ".$socio['apellido1_socio']." ".$socio['apellido2_socio'];
                $chofer = $query -> getRow("nombre_chofer","chofer","where id_chofer = ".$value['chofer']);
		
		//hola
	$interes = $query ->getRow("*","tipo_prestamo","where id_tipo_prestamo = ".$value['id_tipo_prestamo']);
                   $totalinteres = $value['monto_prestamo']*$interes['interes']/100;        	
			$totalPago = $value['monto_prestamo'] + ($value['monto_prestamo']*$interes['interes']/100);
			
				$total = $query -> getRow("SUM(monto_deposito) as total","deposito","where id_prestamo = ".$value['id_prestamo']);
				$falta = $totalPago - $total["total"];
				
                $list .= '<tbody><tr '.$par.'>
				
                  <td>'.$value["fecha_prestamo"].'</td>
				  <td>'.$value["monto_prestamo"].'</td>
                  <td>'.$value["descripcion_prestamo"].'</td>
				  <td>'.$value["tipo_prestamo"].'</td>
                  <td>'.$nombreCompleto.'</td>
                      <td>'.$total["total"].'</td>
                  <td>'.$falta.'</td>
                 
				  <td><a href="prestamo132.php?accion=plan&id='.$value["id_prestamo"].'" title="Plan de pagos"><img src="images/plan.gif"></a></td>
				  <td><a href="prestamo132.php?accion=pago&id='.$value["id_prestamo"].'" title="Pagar Prestamo"><img src="images/pago.gif"></a></td>
                  <td><a href="prestamo132.php?accion=modificar&id='.$value["id_prestamo"].'" title="Modificar Prestamo"><img src="images/edit.gif"></a></td>
                  <td><a href="prestamo132.php?accion=delete&id='.$value["id_prestamo"].'" onClick="'.$confirm.'" title="Eliminar prestamo"><img src="images/delete.gif"></a></td>
				  
				  <td><a href="print_plan.php?accion=imprimir&id='.$value["id_prestamo"].'" 
				 target="_blank" onClick="window.open(this.href, this.target); return false;"  title="Imprimir Plan de pagos">[Imprimir plan]</a></td>
                  

                  </tr></tbody>';
            }
            $list.='</table>';
            //$list .= paging::navigation(count($resultprestamo),"prestamo132.php",10);
        } else $list = '<div>No existen prestamos registrados</div>';
        $buttonAdd = '<input type="button" value="Nuevo" onclick="window.location.href=\'prestamo132.php?accion=registro\'">';
        $template->SetParameter('add',$buttonAdd);
		$totalDiaBs = $query->getRow("SUM(monto_deposito) as totalDiabs","deposito d, prestamo_socio a, tipo_prestamo b","where b.interes!='0.00' and a.id_prestamo=d.id_prestamo and a.id_tipo_prestamo=b.id_tipo_prestamo and d.fecha_deposito = '".$hoy."'");
        
		//$totalDiaBs = $query->getRow("SUM(monto_deposito) as totalDiabs","deposito","where fecha_deposito = '".$hoy."'");
        $template->SetParameter('totalDia',"<br />Total ingreso en Depositos de hoy: ".$totalDiaBs['totalDiabs']." bs ");
		
		$template->SetParameter('contenido',$list);
		return $template->Display();
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
