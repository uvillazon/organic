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
		$hojac=$query->getRow("*","ingresolubricante","WHERE numero = ".$_GET['id']);
		$num_movil = $query->getRow("num_movil","movil","where id_movil = ".$hojac['id_movil']." ");
	    $horaActual = $hora["hours"] . ":" . $hora["minutes"] . ":" . $num_movil["num_movil"] . ":" . $hojac["id_socio"] . ":" . $hojac["fecha_ingreso"] . ":" . $hojac["monto_pago_ingreso"] . ":" . $hojac["monto_ingreso_dolar"];
		 $insert['numero'] = $hojac['numero_registro'];
       $insert['antiguo_registro'] = $horaActual;
	   $assigned_id = $query->dbInsert($insert, "bitacora_delete");		
		if($query->dbDelete("ingresolubricante","WHERE numero = ".$_GET['id']))
		
		    echo "<script>alert('Recibo de ingreso eliminado exitosamente')</script>";
        else
		{
		echo "<script>window.location.href='ingresolubricante.php'</script>";
		
		}
		 // echo "<script>window.location.href='hoja_control.php'</script>"; 
		}
		  echo "<script>window.location.href='ingresolubricante.php'</script>"; 
	}
    
	function registrarHoja(){
        $query = new query;
		$template = new template;
		$template->SetTemplate('html/form_ingresolubricante.html');
        $mayor = $query->getRow("MAX(numero) as mayor","ingresolubricante");
        $tipoingresolist = $query->getRows("*","control_lubricante");
	    foreach($tipoingresolist as $key=>$tipoingreso)
	    {
		$mostrar ="Hide('showDias');";
		if($tipoingreso['nombre'] == "Permiso trabajo")
			$mostrar ="Show('showDias');";
	      $script .= "<option value=".$tipoingreso['id_control_lubricante']." onclick=\"$mostrar ajax('nombrepago','ingresolubricante.php?accion=buscarPago&idtipoingreso=' + document.mframe.nombre.value, '');\"";
	      $script .= '>'.$tipoingreso['nombre'].'</option>'."\n";
	    }
		if($mayor['mayor'] == null) {
            $num_hoja = 100001;
        }
        else {
            $num_hoja = $mayor['mayor']+1;
        }
        $template->SetParameter('numHoja',$num_hoja);
        $hoy = date('Y-m-d');
        $template->SetParameter('montoPrestamo','');
		$template->SetParameter('fecha_creacion',$hoy);
		
        $template->SetParameter('numeroMovil',"<input name=\"movil\" type=\"text\" id=\"movil\" onblur=\"if(document.mframe.movil.value > 0) {ajax('datosMovil','ingresos.php?accion=buscarMovil&movil=' + document.mframe.movil.value, '');}\" size=\"3\">");
	/*$template->SetParameter('numeroMovil',"<input name=\"movil\" type=\"text\" id=\"movil\" onblur=\"if(document.mframe.movil.value > 0){ajax('datosMovil','hoja_control.php?accion=buscaridMovil&movil=' + document.mframe.movil.value, '');}\" size=\"3\">");
	*/	
	$template->SetParameter('dias',"<input name=\"dias\" type=\"text\" id=\"dias\" onblur=\"if(document.mframe.dias.value > 0) {ajax('nombrepago','ingresos.php?accion=calculo&dias=' + document.mframe.dias.value + '&idtipoingreso=' + document.mframe.tipo_ingreso.value, '');}\" size=\"2\">");
		$template->SetParameter('nombreSocio','');
        $tipoConductor = '<input name="tipoConductor" type="radio" value="socio" checked onclick="Hide('."'showNumChofer'".'); Hide('."'showNombreChofer'".');"><label>Socio</label><input name="tipoConductor" type="radio" value="chofer" onclick="Show('."'showNumChofer'".'); Show('."'showNombreChofer'".');"><label>Chofer</label>';
		//haydee
				$template->SetParameter('tipoingreso',"<input name=\"tipoingreso\" type=\"num\" id=\"tipoingreso\" onclick=\"if(document.mframe.tipoingreso.value > 0) {ajax('nombrepago','ingresolubricante.php?accion=buscarPago&tipoingreso=' + document.mframe.tipoingreso.value, '');}\" size=\"20\">");
		
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
    
 function buscarPago(){
      $query = new query;
        $nombrepago = $query->getRow("monto_tipo_lubricante, id_control_lubricante","control_lubricante","where id_control_lubricante = '".$_GET['idtipoingreso']."'");
		return "<span>".$nombrepago['monto_tipo_lubricante']."  Bs.</span><input type=\"hidden\" name=\"id_control_lubricante\" value=\"".$nombrepago['id_control_lubricante']."\">";
	   
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
        echo "<script>window.location.href='ingresolubricante.php'</script>";
	}*/
    
    function saveHoja() //save the new Item
    {
        $query = new query;
        $insert['id_movil'] = $_POST['id_movil'];
		$insert['id_control_lubricante'] = $_POST['id_control_lubricante'];
		$id_movil2 = $query->getRow("*","control_lubricante","where id_control_lubricante = ".$insert['id_control_lubricante']." ");
	if($id_movil2['clasificacion'] == "socio")
	        {$id_movil3 = $query->getRow("*","pertenece","where id_socio = ".$insert['id_movil']." ");
	        $insert['id_socio'] = $id_movil3['id_socio'];
			}
			else
	      $insert['id_socio'] = "0";
	
	    $insert['numero'] = $_POST['numero_registro'];
        $insert['concepto'] = $_POST['descripcion_ingreso'];
      $insert['fecha'] = $_POST['fecha_creacion'];
		 $insert['montoingreso'] = $_POST['monto_prestamo'];
        
		$id_movil = $query->getRow("*","control_lubricante","where id_control_lubricante = ".$insert['id_control_lubricante']." ");
	if($id_movil['nombre'] == "Permiso trabajo")
	        $insert['monto_pago_ingreso'] = $_POST['montoDias'];
			//$insert['id_movil'] = $_POST['id_movil'];
	else
	      $insert['monto_tipo_lubricante'] = $id_movil['monto_tipo_lubricante'];
           $insert['montoaporte'] = $id_movil['aporte'];
           $insert['tipo'] = $id_movil['tipo'];
 
				if($query->dbInsert($insert,"ingresolubricante")){ //save in the data base
			
			/*echo "<script>window.location.href='ingresolubricante.php'</script>";
			*/echo "<script>window.open('imprimirRecibolub.php?numHoja=".$insert['numero']."');</script>";
			
			   
		}
		else{ //error
			echo "<script>alert('Error en el registro');</script>";
			echo "<script>window.location.href='ingresolubricante.php'</script>";
		}echo "<script>window.location.href='ingresolubricante.php'</script>";
    }
    
    function listarHoja() //list for default the all items
	{
		$template = new template;
		$template->SetTemplate('html/lista_ingresoslubricante.html'); //sets the template for this function
		$template->SetParameter('hoy',date('d-M-Y'));
                $template->SetParameter('filtroFecha','');
                $hoy = date('Y-m-d');
		
		//DataBase Conexion//
		$query = new query;
        $resulthoja = $query->getRows("*","ingresolubricante","where fecha = '".$hoy."' ORDER BY numero");
        $init = (($_GET['page'] == "" ? 1 : $_GET['page']) - 1) * 20;
        $resulthoja1 = $query->getRows("*","ingresolubricante","where fecha = '".$hoy."' ORDER BY numero LIMIT $init , 20");
        $numhoja = count($resulthoja1);
        if($numhoja > 0) {
            $list ='<table border = "1">
              <thead><tr>
                <th>Numero</th>
				<th>Linea</th>
                <th>Movil</th>
                <th>Socio</th>
				<th>Tipo Ingreso</th>
				<th>Concepto</th>
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
				                $tipoeg ='';
				if($value['tipo'] == 0)
				{ $tipoeg="Lubricantes";}
				 else{
				 				  			  
				$tipoeg="Lavadero";}
				

               
                $list .= '<tbody><tr '.$par.'>
                  <td>'.$value["numero"].'</td>
                  <td>'.$linea["linea"].'</td>
                  <td>'.$numMovil[1].'</td>
                  <td>'.$nombreChofer.'</td>
				  <td>'.$tipoeg.'</td>
				  
				  <td>'.$value["concepto"].'</td>
                  
                  <td>'.$value["fecha"].'</td>
                  <td>'.$value["montoingreso"].'</td>
				 
				  <td><a href="imprimirRecibolub.php?numHoja='.$value["numero"].'" target="_blank" onClick="window.open(this.href, this.target); return false;" title="Imprimir hoja">[Imprimir]</a></td>
                  <td><a href="ingresolubricante.php?accion=delete&id='.$value["numero"].'" onClick="'.$confirm.'" title="Eliminar Ingresos"><img src="images/delete.gif"></a></td>
                  </tr></tbody>';
            }
            $list.='</table>';
            $list .= paging::navigation(count($resulthoja),"ingresolubricante.php",20);
        } else $list = '<div>No existen hojas de control registrados</div>';
        $buttonAdd = '<input type="button" value="Nuevo" onclick="window.location.href=\'ingresolubricante.php?accion=registro\'">';
        $template->SetParameter('add',$buttonAdd);
        $totalDiaBs = $query->getRow("SUM(montoingreso) as totalDiabs","ingresolubricante","where fecha = '".$hoy."'");
        //$totalDiaDs = $query->getRow("SUM(montoingreso) as totalDiadl","ingresolubricante","where fecha = '".$hoy."'");
		$template->SetParameter('totalDia',"<br />Total ingreso de hoy: ".$totalDiaBs['totalDiabs']." bs ");
		$template->SetParameter('contenido',$list);
		return $template->Display();
	}
     function filtroFecha() //list for default the all items
	{
        $fechaFiltro = $_GET['filtro'];
		$query = new query;
        $resulthoja = $query->getRows("*","ingresolubricante","where fecha = '".$fechaFiltro."' ORDER BY numero");
        //$init = (($_GET['page'] == "" ? 1 : $_GET['page']) - 1) * 20;
        $resulthoja1 = $query->getRows("*","ingresolubricante","where fecha = '".$fechaFiltro."' ORDER BY numero ");
        $numhoja = count($resulthoja1);
	$totalDia = $query->getRow("SUM(montoingreso) as totalDia","ingresolubricante","where fecha = '".$fechaFiltro."'");
      $totalbs = $totalDia['totalDia'];
       $totalDl = $query->getRow("SUM(montoingreso) as totalD","ingresolubricante","where fecha = '".$fechaFiltro."'");
      $totaldolar = $totalDl['totalD'];
      
        $list = '<form name="formRecibir" method="POST" action="ingresolubricante.php?accion=recibir">';
        if($numhoja > 0) {
           $list ='<table border = "1">
              <thead>
	      <tr><b>Total Bs:<b>'.$totalbs.'<tr></tr>
		
	      <tr>
                <th>Numero</th>
		<th>Linea</th>
                <th>Movil</th>
                <th>Socio</th>
				<th>Tipo ingreso</th>
				
				<th>Concepto</th>
                <th>Fecha ingreso</th>
                <th>Monto</th>
		
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
                                $tipoeg ='';
				if($value['tipo'] == 0)
				{ $tipoeg="Lubricantes";}
				 else{
				 				  			  
				$tipoeg="Lavadero";}
				

		
                $list .= '<tbody><tr '.$par.'>
                  <td>'.$value["numero"].'</td>
                  <td>'.$linea["linea"].'</td>
                  <td>'.$numMovil[1].'</td>
                  <td>'.$nombreChofer.'</td>
				   <td>'.$tipoeg.'</td>
				  <td>'.$value["concepto"].'</td>
                  <td>'.$value["fecha"].'</td>
                  <td>'.$value["montoingreso"].'</td>
	      
              
	     </tr></tbody>';
            }
            $list.='</table>';
           // $list .= paging::navigation(count($resulthoja),"ingresolubricante.php",20);
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
