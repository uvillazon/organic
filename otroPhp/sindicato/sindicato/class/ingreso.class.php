<?php
class ingreso
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
    
    
    
    function cambiarfecha($fecha,$dias)
    {
        $datestart= strtotime($fecha);
        $diasemana = date('N',$datestart);
        $totaldias = $diasemana+$dias;
        $findesemana =  intval( $totaldias/5) *1 ; 
        $diasabado = $totaldias % 5 ;
        //if ($diasabado==6) $findesemana++;
        if ($diasabado==0) $findesemana=$findesemana-1;
            $total = (($dias+$findesemana) * 86400)+$datestart ;  
        return $twstart=date('Y-m-d', $total);
    }
	
	function deleteHoja(){
        $query = new query;
        
		{  	$insert['fecha'] = date("Y-m-d");
		$ide=$_SESSION['id'];
		$row=$query->getRow("*","usuario","where id_usuario=$ide");
		$nombre=" ".$row['nombre_usuario']." ".$row['apellido2_usuario'];
        $insert['usuario_actual'] = $nombre;
        $insert['tabla'] = "ingreso";
        $hora = getdate(time());
		$hojac=$query->getRow("*","ingreso","WHERE numero_registro = ".$_GET['id']);
		$num_movil = $query->getRow("num_movil","movil","where id_movil = ".$hojac['id_movil']." ");
	    $horaActual = $hora["hours"] . ":" . $hora["minutes"] . ":" . $num_movil["num_movil"] . ":" . $hojac["id_socio"] . ":" . $hojac["fecha_ingreso"] . ":" . $hojac["monto_pago_ingreso"] . ":" . $hojac["monto_ingreso_dolar"];
		 $insert['numero'] = $hojac['numero_registro'];
       $insert['antiguo_registro'] = $horaActual;
	   $assigned_id = $query->dbInsert($insert, "bitacora_delete");		
		if($query->dbDelete("ingreso","WHERE numero_registro = ".$_GET['id']))
		
		    echo "<script>alert('Recibo de ingreso eliminado exitosamente')</script>";
        else
		{
		echo "<script>window.location.href='ingresos.php'</script>";
		
		}
		 // echo "<script>window.location.href='hoja_control.php'</script>"; 
		}
		  echo "<script>window.location.href='ingresos.php'</script>"; 
	}
    
	function registrarHoja(){
        $query = new query;
		$template = new template;
		$template->SetTemplate('html/form_ingreso.html');
        $mayor = $query->getRow("MAX(numero_registro) as mayor","ingreso");
        $tipoingresolist = $query->getRows("*","tipo_ingreso");
	    foreach($tipoingresolist as $key=>$tipoingreso)
	    {
		$mostrar ="Hide('showDias');";
		if($tipoingreso['tipo_ingreso'] == "Permiso trabajo")
			$mostrar ="Show('showDias');";
	      $script .= "<option value=".$tipoingreso['id_tipo_ingreso']." onclick=\"$mostrar ajax('nombrepago','ingresos.php?accion=buscarPago&idtipoingreso=' + document.mframe.tipo_ingreso.value, '');\"";
	      $script .= '>'.$tipoingreso['tipo_ingreso'].'</option>'."\n";
	    }
		if($mayor['mayor'] == null) {
            $num_hoja = 100001;
        }
        else {
            $num_hoja = $mayor['mayor']+1;
        }
        $template->SetParameter('numHoja',$num_hoja);
        $hoy = date('Y-m-d');
        
        $template->SetParameter('numeroMovil',"<input name=\"movil\" type=\"text\" id=\"movil\" onblur=\"if(document.mframe.movil.value > 0) {ajax('datosMovil','ingresos.php?accion=buscarMovil&movil=' + document.mframe.movil.value, '');}\" size=\"3\">");
	/*$template->SetParameter('numeroMovil',"<input name=\"movil\" type=\"text\" id=\"movil\" onblur=\"if(document.mframe.movil.value > 0){ajax('datosMovil','hoja_control.php?accion=buscaridMovil&movil=' + document.mframe.movil.value, '');}\" size=\"3\">");
	*/	
	$template->SetParameter('dias',"<input name=\"dias\" type=\"text\" id=\"dias\" onblur=\"if(document.mframe.dias.value > 0) {ajax('nombrepago','ingresos.php?accion=calculo&dias=' + document.mframe.dias.value + '&idtipoingreso=' + document.mframe.tipo_ingreso.value, '');}\" size=\"2\">");
		$template->SetParameter('nombreSocio','');
        $tipoConductor = '<input name="tipoConductor" type="radio" value="socio" checked onclick="Hide('."'showNumChofer'".'); Hide('."'showNombreChofer'".');"><label>Socio</label><input name="tipoConductor" type="radio" value="chofer" onclick="Show('."'showNumChofer'".'); Show('."'showNombreChofer'".');"><label>Chofer</label>';
		//
				$template->SetParameter('tipoingreso',"<input name=\"tipoingreso\" type=\"num\" id=\"tipoingreso\" onchange=\"if(document.mframe.tipoingreso.value > 0) {ajax('nombrepago','ingresos.php?accion=buscarPago&tipoingreso=' + document.mframe.tipoingreso.value, '');}\" size=\"20\">");
		
	$template->SetParameter('tipoingreso',$script);
	$template->SetParameter('nombrepago','');
	$ingreso = $query -> getRow("id_tipo_ingreso","tipo_ingreso");
	    $template->SetParameter('ingreso',"<input type=\"hidden\" name=\"monto_tipo_ingreso\" value=\"".$nombrepago['id_tipo_ingreso']."\">");

		//
			 $template->SetParameter('conceptoIngreso','');
		     $template->SetParameter('accion','saveHoja');
             $template->SetParameter('boton','REGISTRAR');
		return $template->Display();
	}
    

	
/*	function buscarMovil(){
        $query = new query;
        //$linea = $query->getRow("linea","linea","where id_linea = ".$_GET['idlinea']);
        $nombreSocio = $query->getRow("m.id_movil, nombre_socio, apellido1_socio, apellido2_socio, placa_movilidad, estado_socio","socio s, movil m, pertenece p","where m.num_movil like '%_".$_GET['movil']."' and m.id_movil = p.id_movil and p.id_socio = s.id_socio");
        if($nombreSocio['estado_socio'] == 'activo')
            $nombreCompleto = $nombreSocio['nombre_socio']." ".$nombreSocio['apellido1_socio']." ".$nombreSocio['apellido2_socio'];
        else
            $nombreCompleto = $nombreSocio['nombre_socio']." ".$nombreSocio['apellido1_socio']." ".$nombreSocio['apellido2_socio']." (Tiene deudas pendientes)";
		return "<span>".$nombreCompleto."</span><input type=\"hidden\" name=\"id_movil\" value=\"".$nombreSocio['id_movil']."\">";
	}*/
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
  function buscarPago(){
      $query = new query;
        $nombrepago = $query->getRow("monto_tipo_ingreso,monto_tipo_dolar, id_tipo_ingreso","tipo_ingreso","where id_tipo_ingreso = '".$_GET['idtipoingreso']."'");
		if($nombrepago["monto_tipo_ingreso"]==0)
			return "<span>".$nombrepago['monto_tipo_dolar']." Sus.</span><input type=\"hidden\" name=\"id_tipo_ingreso\" value=\"".$nombrepago['id_tipo_ingreso']."\">";
                else 
		return "<span>".$nombrepago['monto_tipo_ingreso']."  Bs.</span><input type=\"hidden\" name=\"id_tipo_ingreso\" value=\"".$nombrepago['id_tipo_ingreso']."\">";
	   
	}
	
	
   function calculoMontoDias(){
      $query = new query;
        $nombrepago = $query->getRow("monto_tipo_ingreso, id_tipo_ingreso","tipo_ingreso","where id_tipo_ingreso = '".$_GET['idtipoingreso']."'");
	$total = $nombrepago['monto_tipo_ingreso'] * $_GET['dias'];
	return "<span>".$total."</span><input type=\"hidden\" name=\"montoDias\" value=\"".$total."\"><input type=\"hidden\" name=\"id_tipo_ingreso\" value=\"".$nombrepago['id_tipo_ingreso']."\">";
	}

    /*function deleteHoja(){
        $query = new query;
        if($query->dbDelete("ingreso","WHERE numero_registro = ".$_GET['id']))
            echo "<script>alert('Hoja de control elminado exitosamente')</script>";
        echo "<script>window.location.href='ingreso.php'</script>";
	}*/
    
    function saveHoja() //save the new Item
    {
        $query = new query;
        $insert['id_movil'] = $_POST['id_movil'];
		$insert['id_tipo_ingreso'] = $_POST['id_tipo_ingreso'];
		$id_movil2 = $query->getRow("*","tipo_ingreso","where id_tipo_ingreso = ".$insert['id_tipo_ingreso']." ");
	if($id_movil2['clasificacion'] == "socio")
	        {$id_movil3 = $query->getRow("*","pertenece","where id_socio = ".$insert['id_movil']." ");
	        $insert['id_socio'] = $id_movil3['id_socio'];
			}
			else
	      $insert['id_socio'] = "0";
	
	    $insert['numero_registro'] = $_POST['numero_registro'];
        $insert['concepto_ingreso'] = $_POST['descripcion_ingreso'];
        $insert['fecha_ingreso'] = date("Y-m-d");
		
		$id_movil = $query->getRow("*","tipo_ingreso","where id_tipo_ingreso = ".$insert['id_tipo_ingreso']." ");
	if($id_movil['tipo_ingreso'] == "Permiso trabajo")
	        $insert['monto_pago_ingreso'] = $_POST['montoDias'];
			//$insert['id_movil'] = $_POST['id_movil'];
	else
	      $insert['monto_pago_ingreso'] = $id_movil['monto_tipo_ingreso'];
	/*if($id_movil['tipo_ingreso'] == "Atraso trabajo")
	   			$insert['id_movil'] = $_POST['id_movil'];	*/
	 if($id_movil['monto_tipo_ingreso'] == "0")
	 
	       $insert['monto_ingreso_dolar'] = $id_movil['monto_tipo_dolar'];
					
	    //$insert['monto_pago_ingreso'] = $_POST[nombrepago];
            if($query->dbInsert($insert,"ingreso")){ //save in the data base
			
			/*echo "<script>window.location.href='ingresos.php'</script>";
			*/echo "<script>window.open('imprimirRecibo.php?numHoja=".$insert['numero_registro']."');</script>";
			
			   
		}
		else{ //error
			echo "<script>alert('Error en el registro');</script>";
			echo "<script>window.location.href='ingresos.php'</script>";
		}echo "<script>window.location.href='ingresos.php'</script>";
    }
    
    function listarHoja() //list for default the all items
	{
		$template = new template;
		$template->SetTemplate('html/lista_ingresos.html'); //sets the template for this function
		$template->SetParameter('hoy',date('d-M-Y'));
                $template->SetParameter('filtroFecha','');
                $hoy = date('Y-m-d');
		
		//DataBase Conexion//
		$query = new query;
        $resulthoja = $query->getRows("*","ingreso","where fecha_ingreso = '".$hoy."' ORDER BY numero_registro");
        $init = (($_GET['page'] == "" ? 1 : $_GET['page']) - 1) * 20;
        $resulthoja1 = $query->getRows("*","ingreso","where fecha_ingreso = '".$hoy."' ORDER BY numero_registro LIMIT $init , 20");
        $numhoja = count($resulthoja1);
        if($numhoja > 0) {
            $list ='<table border = "1">
              <thead><tr>
                <th>Numero</th>
				<th>Linea</th>
                <th>Movil</th>
                <th>Socio</th>
                <th>Fecha ingreso</th>
                <th>Monto</th>
				<th></th>
              </tr></thead>';
            $x = 0;
            foreach ($resulthoja1 as $key=>$value) {
                $x++;
                if(($x%2)==0)
                    $par = "class='TdAlt'";
                else $par = "";
				/////////////////////////////////////////////////
				$linea = $query->getRow("linea, num_movil","linea l, movil m","where m.id_movil = ".$value['id_movil']." and m.id_linea = l.id_linea");
                $nombreChofer = "";
                if($value['id_chofer'] == 0) {
                    $nombreSocio = $query->getRow("nombre_socio, apellido1_socio, apellido2_socio","socio s, pertenece p","where p.id_movil = ".$value['id_movil']." and p.id_socio = s.id_socio");
                    $nombreChofer = $nombreSocio['nombre_socio']." ".$nombreSocio['apellido1_socio']." ".$nombreSocio['apellido2_socio'];
                } else {
                    $nombre = $query->getRow("nombre_chofer","chofer","where id_chofer = ".$value['id_chofer']);
                    $nombreChofer = $nombre['nombre_chofer'];
                }
                $numMovil = split('_',$linea["num_movil"]);
                
				/////////////////////////////////////////////////
				
               /* $linea = $query->getRow("linea, num_movil","ingreso i, socio s,pertenece p, movil m, linea l","where s.id_socio = ".$value['id_socio']." and p.id_socio=s.id_socio and p.id_movil=m.id_movil and m.id_linea=l.id_linea");
                $nombreChofer = "";
                if($value['id_chofer'] == null) {
                    $nombreSocio = $query->getRow("nombre_socio, apellido1_socio, apellido2_socio","socio s","where s.id_socio = ".$value['id_socio']." ");
                    $nombreChofer = $nombreSocio['nombre_socio']." ".$nombreSocio['apellido1_socio']." ".$nombreSocio['apellido2_socio'];
                }*/
                $monto = '';
				
               
                if($value["monto_pago_ingreso"]== 0)
                    
					$monto = $value["monto_ingreso_dolar"]." $";
                else 
                    $monto = $value["monto_pago_ingreso"]." Bs";
                $numMovil = split('_',$linea["num_movil"]);
                $list .= '<tbody><tr '.$par.'>
                  <td>'.$value["numero_registro"].'</td>
                  <td>'.$linea["linea"].'</td>
                  <td>'.$numMovil[1].'</td>
                  <td>'.$nombreChofer.'</td>
                  <td>'.$value["fecha_ingreso"].'</td>
                  <td>'.$monto.'</td>
				 
				  <td><a href="imprimirRecibo.php?numHoja='.$value["numero_registro"].'" target="_blank" onClick="window.open(this.href, this.target); return false;" title="Imprimir hoja">[Imprimir]</a></td>
                  <td><a href="ingresos.php?accion=delete&id='.$value["numero_registro"].'" onClick="'.$confirm.'" title="Eliminar Ingresos"><img src="images/delete.gif"></a></td>
                  </tr></tbody>';
            }
            $list.='</table>';
            $list .= paging::navigation(count($resulthoja),"ingresos.php",20);
        } else $list = '<div>No existen hojas de control registrados</div>';
        $buttonAdd = '<input type="button" value="Nuevo" onclick="window.location.href=\'ingresos.php?accion=registro\'">';
        $template->SetParameter('add',$buttonAdd);
        $totalDiaBs = $query->getRow("SUM(monto_pago_ingreso) as totalDiabs","ingreso","where fecha_ingreso = '".$hoy."'");
        $totalDiaDs = $query->getRow("SUM(monto_ingreso_dolar) as totalDiadl","ingreso","where fecha_ingreso = '".$hoy."'");
		$template->SetParameter('totalDia',"<br />Total ingreso de hoy: ".$totalDiaBs['totalDiabs']." bs y ".$totalDiaDs['totalDiadl']." $");
		$template->SetParameter('contenido',$list);
		return $template->Display();
	}
     function filtroFecha() //list for default the all items
	{
        $fechaFiltro = $_GET['filtro'];
		$query = new query;
        $resulthoja = $query->getRows("*","ingreso","where fecha_ingreso = '".$fechaFiltro."' ORDER BY numero_registro");
        //$init = (($_GET['page'] == "" ? 1 : $_GET['page']) - 1) * 20;
        $resulthoja1 = $query->getRows("*","ingreso","where fecha_ingreso = '".$fechaFiltro."' ORDER BY numero_registro ");
        $numhoja = count($resulthoja1);
	$totalDia = $query->getRow("SUM(monto_pago_ingreso) as totalDia","ingreso","where fecha_ingreso = '".$fechaFiltro."'");
      $totalbs = $totalDia['totalDia'];
       $totalDl = $query->getRow("SUM(monto_ingreso_dolar) as totalD","ingreso","where fecha_ingreso = '".$fechaFiltro."'");
      $totaldolar = $totalDl['totalD'];
      
        $list = '<form name="formRecibir" method="POST" action="ingreso.php?accion=recibir">';
        if($numhoja > 0) {
           $list ='<table border = "1">
              <thead>
	      <tr><b>Total Bs:<b>'.$totalbs.'<tr><b> Total Dolar <b>'.$totaldolar.'</tr>
		
	      <tr>
                <th>Numero</th>
		<th>Linea</th>
                <th>Movil</th>
                <th>Socio</th>
                <th>Fecha ingreso</th>
                <th>Monto</th>
		<th>Concepto</th>
		
		</tr></thead>';
            $x = 0;
            foreach ($resulthoja1 as $key=>$value) {
                $x++;
                if(($x%2)==0)
                    $par = "class='TdAlt'";
                else $par = "";
				/////////////////////////////////////////////////
				$linea = $query->getRow("linea, num_movil","linea l, movil m","where m.id_movil = ".$value['id_movil']." and m.id_linea = l.id_linea");
                $nombreChofer = "";
                if($value['id_chofer'] == 0) {
                    $nombreSocio = $query->getRow("nombre_socio, apellido1_socio, apellido2_socio","socio s, pertenece p","where p.id_movil = ".$value['id_movil']." and p.id_socio = s.id_socio");
                    $nombreChofer = $nombreSocio['nombre_socio']." ".$nombreSocio['apellido1_socio']." ".$nombreSocio['apellido2_socio'];
                } else {
                    $nombre = $query->getRow("nombre_chofer","chofer","where id_chofer = ".$value['id_chofer']);
                    $nombreChofer = $nombre['nombre_chofer'];
                }
                $numMovil = split('_',$linea["num_movil"]);
                
		
                $monto = '';
				
               
                if($value["monto_pago_ingreso"]== 0)
                    
					$monto = $value["monto_ingreso_dolar"]." $";
                else 
                    $monto = $value["monto_pago_ingreso"]." Bs";
                $numMovil = split('_',$linea["num_movil"]);
                $list .= '<tbody><tr '.$par.'>
                  <td>'.$value["numero_registro"].'</td>
                  <td>'.$linea["linea"].'</td>
                  <td>'.$numMovil[1].'</td>
                  <td>'.$nombreChofer.'</td>
                  <td>'.$value["fecha_ingreso"].'</td>
                  <td>'.$monto.'</td>
	          <td>'.$value["concepto_ingreso"].'</td>
              
	     </tr></tbody>';
            }
            $list.='</table>';
           // $list .= paging::navigation(count($resulthoja),"ingresos.php",20);
        } else $list = '<div>No existen ingresos para la fecha '.$fechaFiltro.'</div>';
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
		if($_SESSION['tipo']==4){
			$template->SetTemplate('html/home3.html');
			$template->SetParameter('registro',$this->mostrarregistro1());
		}
		if($_GET['accion']==""){
            $template->SetParameter('contenido',$this->listarHoja());
        }
        if($_GET['accion']=="registro"){
            $template->SetParameter('contenido',$this->registrarHoja());
        }
        if($_GET['accion']=="modificar"){
            $template->SetParameter('contenido',$this->modificarHoja());
        }
		$template->SetParameter('pie',navigation::showpie());	
		return $template->Display();
	}
}
?>
