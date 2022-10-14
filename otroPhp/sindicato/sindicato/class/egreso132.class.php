<?php
class tipoingreso
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
	function registrarTipoIngreso(){
		$template = new template;
		$template->SetTemplate('html/form_egreso132.html');
		$hoy=date("Y-m-d");
		$template->SetParameter('descripcion','');
        $template->SetParameter('monto_tipo_ingreso','');
		 $template->SetParameter('monto_tipo_ingreso2','');
		$template->SetParameter('monto_tipo_ingresoa','');
        $template->SetParameter('fecha_registro_saldo',$hoy);
        $template->SetParameter('accion','saveTipoIngreso');
        $template->SetParameter('boton','REGISTRAR');
		return $template->Display();
	}
    function modificarTipoIngreso(){
        $query = new query;
        $tipoingreso = $query -> getRow("*","egresos132","where id_egreso = ".$_GET[id]);
		$template = new template;
		$template->SetTemplate('html/form_egreso132.html');
       
       $template->SetParameter('descripcion',$tipoingreso["concepto"]);
        $template->SetParameter('monto_tipo_ingreso',$tipoingreso["monto_egreso"]);
		 $template->SetParameter('monto_tipo_ingreso2',$tipoingreso["monto_dolar"]);
		$template->SetParameter('monto_tipo_ingresoa',$tipoingreso["numero"]);
        $template->SetParameter('fecha_registro_saldo',$tipoingreso["fecha"]);
        
		$template->SetParameter('accion','saveUpdateTipoIngreso&id='.$_GET['id']);
        $template->SetParameter('boton','MODIFICAR');
		return $template->Display();
	}
    
    function deleteTipoIngreso(){
        $query = new query;
        if($query->dbDelete("egresos132","WHERE id_egreso = ".$_GET['id']))
            //echo "<script>alert('saldo de ingreso elminado exitosamente')</script>";
        echo "<script>window.location.href='egreso132.php'</script>";
	}
    
    function saveUpdateTipoIngreso() //save the new Item
    {
        $query = new query;
        $update['concepto'] = $_POST['descripcion'];
        $update['monto_egreso'] = $_POST['monto_tipo_ingreso'];  
 $update['monto_dolar'] = $_POST['monto_tipo_ingreso2'];  		
		  $update['numero'] = $_POST['monto_tipo_ingresoa'];        
		$update['fecha'] = $_POST['fecha_registro_saldo'];        
		
		if($query->dbUpdate($update,"egresos132","where id_egreso = ".$_GET['id'])){ //save in the data base
			//echo "<script>alert('Tipo de ingreso modificado exitosamente');</script>";
			echo "<script>window.location.href='egreso132.php'</script>";
		}
		else{ //error
			echo "<script>alert('Error en el registro');</script>";
			echo "<script>window.location.href='egreso132.php'</script>";
		}
    }
    
    function saveTipoIngreso() //save the new Item
    {
        $query = new query;
        $insert['concepto'] = $_POST[descripcion];
        $insert['monto_egreso'] = $_POST[monto_tipo_ingreso];
		$insert['monto_dolar'] = $_POST[monto_tipo_ingreso2];
		$insert['numero'] = $_POST[monto_tipo_ingresoa];
		$insert['fecha'] = $_POST[fecha_registro_saldo];
		$insert['tipo'] = $_POST[tipo];
		
	
		if($query->dbInsert($insert,"egresos132")){ //save in the data base
			//echo "<script>alert('Tipo de ingreso registrado exitosamente');</script>";
			echo "<script>window.location.href='egreso132.php'</script>";
		}
		else{ //error
			echo "<script>alert('Error en el registro');</script>";
			echo "<script>window.location.href='egreso132.php'</script>";
		}
    }
         function listarTipoIngresos() //list for default the all items
	{
		$template = new template;
		$template->SetTemplate('html/lista_egreso132.html'); //sets the template for this function
			$template->SetParameter('hoy',date('d-M-Y'));
                $template->SetParameter('filtroFecha','');
                $hoy = date('Y-m-d');
		
		//DataBase Conexion//
		$query = new query;
        $resulthoja = $query->getRows("*","egresos132","where fecha = '".$hoy."' ORDER BY id_egreso");
        $init = (($_GET['page'] == "" ? 1 : $_GET['page']) - 1) * 20;
        $resulthoja1 = $query->getRows("*","egresos132","where fecha = '".$hoy."' ORDER BY id_egreso LIMIT $init , 20");
        $numhoja = count($resulthoja1);
        if($numhoja > 0) {
            $list ='<table border = "1">
              <thead><tr>
                <th>Numero</th>
                <th>Recibo</th>
				
				<th>Detalle</th>
				 <th>Monto Bs.</th>
				  <th>Monto Sus.</th>
                  <th>Fecha registro</th>
				  
                
				<th>Modificar</th>
                <th>Eliminar</th>
              </tr></thead>';
            $x = 0;
            foreach ($resulthoja1 as $key=>$value) {
                $x++;
                if(($x%2)==0)
                    $par = "class='TdAlt'";
                $monto = '';
                $tipoeg ='';
			
				$list .= '<tbody><tr '.$par.'>
                  <td>'.$value["id_egreso"].'</td>
				 <td>'.$value["numero"].'</td>
				 <td>'.$value["concepto"].'</td>
				  <td>'.$value["monto_egreso"].'</td>
				   <td>'.$value["monto_dolar"].'</td>
				   <td>'.$value["fecha"].'</td>
				
				 
                  <td><a href="egreso132.php?accion=modificar&id='.$value["id_egreso"].'" title="Modificar  "><img src="images/edit.gif"></a></td>
                  <td><a href="egreso132.php?accion=delete&id='.$value["id_egreso"].'" onClick="'.$confirm.'" title="Eliminar "><img src="images/delete.gif"></a></td>
                  </tr></tbody>';
            }
            $list.='</table>';
            $list .= paging::navigation(count($resulthoja),"egreso132.php",20);
        } else $list = '<div>No existen registros</div>';
		 $buttonAdd = '<input type="button" value="Nuevo" onclick="window.location.href=\'egreso132.php?accion=registro\'">';
        //$template->SetParameter('add',$buttonAdd);
		//$template->SetParameter('contenido',$list);
		
        //$buttonAdd = '<input type="button" value="Nuevo" onclick="window.location.href=\'ingresos.php?accion=registro\'">';
        $template->SetParameter('add',$buttonAdd);
        $totalDiaBs = $query->getRow("SUM(monto_egreso) as totalDiabs","egresos132","where fecha = '".$hoy."'");
        $totalDiaDs = $query->getRow("SUM(monto_dolar) as totalDiadl","egresos132","where fecha = '".$hoy."'");
		$template->SetParameter('totalDia',"<br />Total ingreso de hoy: ".$totalDiaBs['totalDiabs']." bs y ".$totalDiaDs['totalDiadl']." $");
		$template->SetParameter('contenido',$list);
		return $template->Display();
	}
    function filtroFecha() //list for default the all items
	{
        $fechaFiltro = $_GET['filtro'];
		$query = new query;
        $resulthoja = $query->getRows("*","egresos132","where fecha = '".$fechaFiltro."' ORDER BY id_egreso");
        //$init = (($_GET['page'] == "" ? 1 : $_GET['page']) - 1) * 20;
        $resulthoja1 = $query->getRows("*","egresos132","where fecha = '".$fechaFiltro."' ORDER BY id_egreso ");
        $numhoja = count($resulthoja1);
	$totalDia = $query->getRow("SUM(monto_egreso) as totalDia","egresos132","where fecha = '".$fechaFiltro."'");
      $totalbs = $totalDia['totalDia'];
       $totalDl = $query->getRow("SUM(monto_dolar) as totalD","egresos132","where fecha = '".$fechaFiltro."'");
      $totaldolar = $totalDl['totalD'];
      
        $list = '<form name="formRecibir" method="POST" action="egreso132.php?accion=recibir">';
        if($numhoja > 0) {
           $list ='<table border = "1">
              <thead>
	      <tr><b>Total Bs:<b>'.$totalbs.'<tr><b> Total Dolar <b>'.$totaldolar.'</tr>
		
	      <tr>
               <th>Numero</th>
                <th>Recibo</th>
				
				<th>Detalle</th>
				 <th>Monto Bs.</th>
				  <th>Monto Sus.</th>
                  <th>Fecha registro</th>
		
		</tr></thead>';
            $x = 0;
            foreach ($resulthoja1 as $key=>$value) {
                $x++;
                if(($x%2)==0)
                    $par = "class='TdAlt'";
                else $par = "";
				/////////////////////////////////////////////////
			
				
				
                $list .= '<tbody><tr '.$par.'>
                <td>'.$value["id_egreso"].'</td>
				 <td>'.$value["numero"].'</td>
				 <td>'.$value["concepto"].'</td>
				  <td>'.$value["monto_egreso"].'</td>
				   <td>'.$value["monto_dolar"].'</td>
				   <td>'.$value["fecha"].'</td>
              
	     </tr></tbody>';
            }
            $list.='</table>';
           // $list .= paging::navigation(count($resulthoja),"ingresos.php",20);
        } else $list = '<div>No existen egresos para la fecha '.$fechaFiltro.'</div>';
		return $list;
	}
	
	function Display(){
		$template = new template;
		
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
            $template->SetParameter('contenido',$this->listarTipoIngresos());
        }
        if($_GET['accion']=="registro"){
            $template->SetParameter('contenido',$this->registrarTipoIngreso());
        }
        if($_GET['accion']=="modificar"){
            $template->SetParameter('contenido',$this->modificarTipoIngreso());
        }
        	$template->SetParameter('pie',navigation::showpie());
		return $template->Display();
	}
}
