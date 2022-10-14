<?php
class reporte_movil
{
	var $parameter=array();
	function SetParameter($name,$value)
	{
		$this->parameter[$name]=$value;
	}
	function mostrarRegistro(){
		$template=new template;
		$template->SetTemplate('html/registro.html');
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

   
	
    
    function DiasReporte() //list for default the all items
	{
        $fechaInicio = $_GET[fechaInicio];
        $fechaFin = $_GET[fechaFin];
		$query = new query;
		
		  $resultmovil1 = $query->getRows("*","ingreso","where fecha_ingreso >= '".$fechaInicio."' and fecha_ingreso <= '".$fechaFin."' ");
 
//$resultmovil1 = $query->getRows("c.id_control_lubricante,i.fecha,c.tipo,c.nombre,c.aporte","control_lubricante c,ingresolubricante i","WHERE c.id_control_lubricante=i.id_control_lubricante and i.fecha >= '".$fechaInicio."' and i.fecha <= '".$fechaFin."' GROUP BY c.id_control_lubricante");
 
//$resultmovil1 = $query->getRows("*","control_lubricante","WHERE fecha >= '".$fechaInicio."' and fecha <= '".$fechaFin."' ORDER BY tipo");
		   	  $totalD = $query->getRow("SUM(monto_pago_ingreso) as totalDiabs","ingreso","where  fecha_ingreso >= '".$fechaInicio."' and fecha_ingreso <= '".$fechaFin."'");
		 $totalventas = $totalD['totalDiabs'];
		 $totalD1= $query->getRow("SUM(monto_ingreso_dolar) as totalDiabs","ingreso","where  fecha_ingreso >= '".$fechaInicio."' and fecha_ingreso <= '".$fechaFin."'");
		 $totalAporte = $totalD1['totalDiabs'];
		
$hoy = date("Y-m-d");
        $numsocio = count($resultmovil1);
        
		$list = '<form name="formPermiso" method="POST" action="lista_prestamo.php?accion=saveUpdatePermiso">';
        if($numsocio > 0) {
            $list .='<table border = "1">
              <thead>
			      <tr>Totales</tr>					  
			 <tr>
             
                <th>Numero</th>
				<th>Linea</th>
                <th>Movil</th>
                <th>Socio</th>
                <th>Fecha ingreso</th>
			
                <th>Monto BS</th>
				 <th>Monto SUS</th>
				</tr></thead>';
            $x = 0;
              foreach ($resultmovil1 as $key=>$value) {
            
			    $x++;
                if(($x%2)==0)
                    $par = "class='TdAlt'";
                else $par = "";
	        	//$ingreso= $query->getRow("SUM(monto_egreso)as total","egreso_lubricante","where id_ = ".$value['id_control_lubricante']);	 
               
				//$registro = $ingreso["total"];
				 	$idmovil= $query->getRow("id_movil","ingreso","where id_ingreso= ".$value['id_ingreso']);	 
              
                $linea = $query->getRow("linea, num_movil","linea l, movil m","where m.id_movil = ".$idmovil["id_movil"]." and m.id_linea = l.id_linea");
                $numMovil = split('_',$linea["num_movil"]);
                    $nombreSocio = $query->getRow("nombre_socio, apellido1_socio, apellido2_socio","socio s, pertenece p","where p.id_movil = ".$idmovil["id_movil"]." and p.id_socio = s.id_socio");
                    $nombreChofer = $nombreSocio['nombre_socio']." ".$nombreSocio['apellido1_socio']." ".$nombreSocio['apellido2_socio'];
             
			 $concepto=  $query->getRow("concepto_ingreso","ingreso","where id_ingreso= ".$value['id_ingreso']);	 
              
                $list .= '<tbody>
							<tr '.$par.'>
							 <td>'.$value["numero_registro"].'</td>
							  <td>'.$linea["linea"].'</td>
							  <td>'.$numMovil[1].'</td>
							  <td>'.$nombreChofer.'</td>
                  <td>'.$value["fecha_ingreso"].'</td>
				  <td>'.$value["monto_pago_ingreso"].'</td>
				  <td>'.$value["monto_ingreso_dolar"].'</td>
                                  </tr></tbody>';
            }
             $list.='<th>Totales
			   <th></th>
			   <th></th>
			 <th></th>
			 <th></th>
		
			   <th><b>Total:<b>'.$totalventas.'</th>
			   
			   <th><b>Total:<b>'.$totalAporte.'</th>
			   </th></table>';
			   //lista adicional

			   //fin lista
			
        } else $list = '<div>No existen datos registrados</div>';
		
		return $list;
	}
    
    function FiltrarFechas() //list for default the all items
	{
		$template = new template;
		$template->SetTemplate('html/reporte_lubricante.html'); //sets the template for this function
		$template->SetParameter('fecha_fin',date('Y-m-d'));
		$template->SetParameter('contenido','');
        /*$primera = "2008-12-01";
        $segunda = date("Y-m-d");
        echo "<script> alert('".$this->compararFechas ($primera,$segunda)."');</script>";*/
		return $template->Display();
	}
    
function compararFechas($primera, $segunda)
{
   $valoresPrimera = explode ("-", $primera);
   $valoresSegunda = explode ("-", $segunda);
   $anyoPrimera   = $valoresPrimera[0];
   $mesPrimera  = $valoresPrimera[1];
   $diaPrimera    = $valoresPrimera[2];
   $anyoSegunda  = $valoresSegunda[0];
   $mesSegunda = $valoresSegunda[1];
   $diaSegunda   = $valoresSegunda[2];
   $diasPrimeraJuliano = gregoriantojd($mesPrimera, $diaPrimera, $anyoPrimera);
   $diasSegundaJuliano = gregoriantojd($mesSegunda, $diaSegunda, $anyoSegunda);
   if(!checkdate($mesPrimera, $diaPrimera, $anyoPrimera)){
   // "La fecha ".$primera." no es válida";
    return 0;
   }elseif(!checkdate($mesSegunda, $diaSegunda, $anyoSegunda)){
    // "La fecha ".$segunda." no es válida";
    return 0;
   }else{
    return  $diasSegundaJuliano - $diasPrimeraJuliano;
  }
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
        
        $template->SetParameter('pie',navigation::showpie());
		if($_GET['accion']==""){
            $template->SetParameter('contenido',$this->FiltrarFechas());
        }
		if($_GET['accion']=="imprimir"){
            $template->SetParameter('contenido',$this->imprimirReporte());
        }
		return $template->Display();
	}
}
?>