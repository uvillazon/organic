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
       	 $resultmovil1 = $query->getRows("*","prestamo_socio a, tipo_prestamo b","WHERE a.id_tipo_prestamo=b.id_tipo_prestamo and a.fecha_prestamo >= '".$fechaInicio."' and a.fecha_prestamo <= '".$fechaFin."'");
$resultmovil1 = $query->getRows("*","prestamo_socio a, tipo_prestamo b","WHERE b.interes!='0.00' and a.id_tipo_prestamo=b.id_tipo_prestamo and a.fecha_prestamo >= '".$fechaInicio."' and a.fecha_prestamo <= '".$fechaFin."'");
		 		 
		 $hoy = date("Y-m-d");
        $numsocio = count($resultmovil1);
        $totalDiaBs = $query->getRow("SUM(monto_deposito) as totalDiabs","deposito","where fecha_deposito >= '".$fechaInicio."' and fecha_deposito <= '".$fechaFin."'");
		// $totalDiaBs = $query->getRow("SUM(monto_deposito) as totalDiabs","deposito d, prestamo_socio a, tipo_prestamo b","where b.interes!='0.00' and d.fecha_deposito >= '".$fechaInicio."' and d.fecha_deposito <= '".$fechaFin."'");
        
		 $recaudado = $totalDiaBs['totalDiabs'];
      
		$list = '<form name="formPermiso" method="POST" action="lista_prestamo.php?accion=saveUpdatePermiso">';
        if($numsocio > 0) {
            $list .='<table border = "1">
              <thead>
			   <tr><b>Monto Total:<b>'.$recaudado.'</tr>
			  <tr>
                <th>Nro Prestamo</th>
		        <th>Nombre Socio</th>
		        <th>Nombre Chofer</th>
                <th>Tipo Prestamo</th>
                <th>Capital + Interes a cobrar</th>
                <th>Capital Recaudado</th>
                <th>Interes Recaudado</th>
                <th>Monto Total</th>
                <th>Monto Adeudado</th>
				</tr></thead>';
            $x = 0;
            foreach ($resultmovil1 as $key=>$value) {
            
			    $x++;
                if(($x%2)==0)
                    $par = "class='TdAlt'";
                else $par = "";
	        				 
                $socio = $query->getRow("*","socio","where id_socio = ".$value['socio']);
                $nombreCompleto = $socio['nombre_socio']." ".$socio['apellido1_socio']." ".$socio['apellido2_socio'];
                $chofer = $query -> getRow("nombre_chofer","chofer","where id_chofer = ".$value['chofer']);
			    
				$interes = $query ->getRow("*","tipo_prestamo","where id_tipo_prestamo = ".$value['id_tipo_prestamo']);
        		$totalPago = $value['monto_prestamo'] + ($value['monto_prestamo']*$interes['interes']/100);
			
				$total = $query -> getRow("SUM(monto_deposito) as total","deposito","where id_prestamo = ".$value['id_prestamo']);
				$falta = $totalPago - $total["total"];
                $capitalrecaudado =($total['total']-$interes['interes']);
		           
				$interesprestamo =($value['monto_prestamo']*$interes['interes']/100);
		
                $list .= '<tbody><tr '.$par.'>
                  <td>'.$value["id_prestamo"].'</td>
		          <td>'.$nombreCompleto.'</td>
                  <td>'.$chofer["nombre_chofer"].'</td>
                  <td>'.$value["tipo_prestamo"].'</td>
                  <td>'.$totalPago.'</td>
                  <td>'.$capitalrecaudado.'</td>
                  <td>'.$interesprestamo.'</td>
		          <td>'.$total["total"].'</td>
                  <td>'.$falta.'</td>
                  
				  
                                  </tr></tbody>';
            }
            $list.='</table>';
        } else $list = '<div>No existen prestamos registrados</div>';
		return $list;
	}
    
    function FiltrarFechas() //list for default the all items
	{
		$template = new template;
		$template->SetTemplate('html/lista_reporte_prestamo.html'); //sets the template for this function
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
   // "La fecha ".$primera." no es v�lida";
    return 0;
   }elseif(!checkdate($mesSegunda, $diaSegunda, $anyoSegunda)){
    // "La fecha ".$segunda." no es v�lida";
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