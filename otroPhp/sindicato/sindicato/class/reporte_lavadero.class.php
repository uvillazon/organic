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
$resultmovil1 = $query->getRows("*","egreso_lubricante","WHERE fecha >= '".$fechaInicio."' and fecha <= '".$fechaFin."' AND tipo='1' ORDER BY fecha DESC");
		        $hoy = date("Y-m-d");
        $numsocio = count($resultmovil1);
         $totalDiaBs = $query->getRow("SUM(montoingreso) as totalDiabs","ingresolubricante i, control_lubricante c","where i.id_control_lubricante=c.id_control_lubricante AND i.fecha >= '".$fechaInicio."' and i.fecha <= '".$fechaFin."'");
		 $recaudado = $totalDiaBs['totalDiabs'];
		  $totalD = $query->getRow("SUM(monto_egreso) as totalDiabs","egreso_lubricante","where  tipo='1' AND fecha >= '".$fechaInicio."' and fecha <= '".$fechaFin."'");
		 $totalventas = $totalD['totalDiabs'];
      $otros = $recaudado - $totalventas;
      $totalDiaDinero = $query->getRow("SUM(monto_egreso) as totalDiabs","egreso_lubricante","where fecha >= '".$fechaInicio."' and fecha <= '".$fechaFin."'");
      $dinero = $totalDiaDinero['totalDiabs'];
        $saldo = $recaudado - $dinero;
		 //cuidado
		 
	 $totalDiaBsla = $query->getRow("SUM(montoingreso) as totalDiabs","ingresolubricante i","where i.tipo='1' AND i.fecha >= '".$fechaInicio."' and i.fecha <= '".$fechaFin."'");
		 $ingresola = $totalDiaBsla['totalDiabs'];
		$totalDiaDinerola = $query->getRow("SUM(monto_egreso) as totalDiabs","egreso_lubricante","where tipo='1' AND fecha >= '".$fechaInicio."' and fecha <= '".$fechaFin."'");
      $egresola = $totalDiaDinerola['totalDiabs'];
       $saldola = $ingresola - $egresola;
	     
	 //ojo lavado
$resultlavado = $query->getRow("SUM(montoingreso)as totallavado","ingresolubricante i, control_lubricante c","where c.id_control_lubricante=i.id_control_lubricante AND i.fecha >= '".$fechaInicio."' and i.fecha <= '".$fechaFin."' AND i.id_control_lubricante='6' ");
		 	  $ingresolav = $resultlavado['totallavado'];   
		$resultlavado1 = $query->getRow("COUNT(i.id_control_lubricante)as totallav","ingresolubricante i, control_lubricante c","WHERE c.id_control_lubricante=i.id_control_lubricante AND i.fecha >= '".$fechaInicio."' and i.fecha <= '".$fechaFin."' AND i.id_control_lubricante='6' ");
		 	  $cantidadlav = $resultlavado1['totallav'];  
	
	
			  
 //fumi
 $resultfumi = $query->getRow("SUM(montoingreso)as totalfumi","ingresolubricante i, control_lubricante c","WHERE c.id_control_lubricante=i.id_control_lubricante AND i.fecha >= '".$fechaInicio."' and i.fecha <= '".$fechaFin."' AND i.tipo='1' AND i.id_control_lubricante='7' ");
		 	  $ingresofumi = $resultfumi['totalfumi'];   
		$resultfumig = $query->getRow("COUNT(i.id_control_lubricante)as totalfumig","ingresolubricante i, control_lubricante c","WHERE c.id_control_lubricante=i.id_control_lubricante AND i.fecha >= '".$fechaInicio."' and i.fecha <= '".$fechaFin."' AND i.tipo='1' AND c.id_control_lubricante='7' ");
		 	  $cantidadfumi = $resultfumig['totalfumig'];   
 //fumi y lav
 $resultlavf= $query->getRow("SUM(montoingreso)as totallavf","ingresolubricante i, control_lubricante c","WHERE c.id_control_lubricante=i.id_control_lubricante AND i.fecha >= '".$fechaInicio."' and i.fecha <= '".$fechaFin."' AND i.tipo='1' AND i.id_control_lubricante='5' ");
		 	  $ingresofumil = $resultlavf['totallavf'];   
		$resultlavfl = $query->getRow("COUNT(i.id_control_lubricante)as totalavf","ingresolubricante i, control_lubricante c","WHERE c.id_control_lubricante=i.id_control_lubricante AND i.fecha >= '".$fechaInicio."' and i.fecha <= '".$fechaFin."' AND i.tipo='1' AND c.id_control_lubricante='5' ");
		 	  $cantidadfumil = $resultlavfl['totalavf'];   
 //fin
		$list = '<form name="formPermiso" method="POST" action="lista_prestamo.php?accion=saveUpdatePermiso">';
        if($numsocio > 0) {
            $list .='<table border = "1">
              <thead>
			      <tr>Totales</tr>					  
			 <tr>
                
				</tr>
				  
				  
				  <tr><td><b>CONCEPTO<b></td><td><b>INGRESOS<b></td><td><b>EGRESOS<b></td><td><b>SALDO<b></td></tr>
				  
				  <tr><td><b>LAVADERO<b></td><td>'.$ingresola.'</td><td>'.$egresola.'</td><td><b>'.$saldola.'</td></tr>
				 	<tr>Detalle Ingresos</tr>					  
			 <tr>
         <th>Tipo ingreso</th>
		<th></th>
		<th>Cantidad</th>
        <th>Total Ingresos</th>
                
		
				</tr>
				
                  <tr><td><b>LAVADO<b></td><td></td><td>'.$cantidadlav.'</td><td><b>'.$ingresolav.'</td></tr>
				  <tr><td><b>ASPIRADO<b></td><td></td><td>'.$cantidadfumi.'</td><td><b><b>'.$ingresofumi.'</td></tr>
				 <tr><td><b>LAVADO Y ASPIRADO<b></td><td></td><td>'.$cantidadfumil.'</td><td><b><b>'.$ingresofumil.'</td></tr>
				  <tr><td><b>TOTAL<b></td><td></td><td></td><td><b><b>'.$ingresola.'</td></tr>
				<tr>Detalle Egresos</tr>			
			 <tr>
         <th>Egreso</th>
		<th>Concepto</th>
		
		<th>Recibo</th>
        <th>Total Egresos</th>
                
		
				</tr>
				</thead>';
            $x = 0;
            foreach ($resultmovil1 as $key=>$value) {
            
			    $x++;
                if(($x%2)==0)
                    $par = "class='TdAlt'";
                else $par = "";
	        	//$ingreso= $query->getRow("SUM(monto_egreso)as total","egreso_lubricante","where id_ = ".$value['id_control_lubricante']);	 
               
				//$registro = $ingreso["total"];
                
				
                $list .= '<tbody>
							<tr '.$par.'>
                  <td>'.$value["fecha"].'</td>
		          <td>'.$value["concepto"].'</td>
                  <td>'.$value["numero"].'</td>
				  <td>'.$value["monto_egreso"].'</td>
				  
                                  </tr></tbody>';
            }
             $list.='<th>Totales
			   <th></th>
			   <th></th>
			 
			   <th><b>Total:<b>'.$totalventas.'</th>
			  
			   </th></table>';
			   //lista adicional

			   //fin lista
			
        } else $list = '<div>No existe ningun egreso registrado/Debe registrar por lo menos un egreso para el lavadero/ De no existir ninguno introdusca uno con la denominacion ninguno y un monto "00.00" Gracias por su comprension</div>';
		
		return $list;
	}
    
    function FiltrarFechas() //list for default the all items
	{
		$template = new template;
		$template->SetTemplate('html/reporte_lavadero.html'); //sets the template for this function
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