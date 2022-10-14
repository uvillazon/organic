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
       	 $resultmovil1 = $query->getRows("*","egreso_lubricante","WHERE tipo='1' AND fecha >= '".$fechaInicio."' and fecha <= '".$fechaFin."' ORDER BY fecha DESC");
		        $hoy = date("Y-m-d");
        $numsocio = count($resultmovil1);
         $totalDiaBs = $query->getRow("SUM(monto_egreso) as totalDiabs","egreso_lubricante","where tipo='1' AND fecha >= '".$fechaInicio."' and fecha <= '".$fechaFin."'");
		 $totalventas = $totalDiaBs['totalDiabs'];
		  $totalDiaDinerolu = $query->getRow("SUM(monto_egreso) as totalDiabs","egreso_lubricante","where tipo='1' AND fecha >= '".$fechaInicio."' and fecha <= '".$fechaFin."'");
      $egresolu = $totalDiaDinerolu['totalDiabs'];
      // $totalDiaDinerolu1= $query->getRow("SUM(monto_egreso) as totalDiabs","egreso_lubricante","where tipo='1' AND fecha >= '".$fechaInicio."' and fecha <= '".$fechaFin."'");
      //$egresolu1 = $totalDiaDinerolu1['totalDiabs'];
       
	 //'.$ingresola.'
		$list = '<form name="formPermiso" method="POST" action="lista_prestamo.php?accion=saveUpdatePermiso">';
        if($numsocio > 0) {
            $list .='<table border = "1">
              <thead>
			    			  
			 <tr>
                <td>Total Egresos</td> 			 
                <td>'.$egresolu.'</td>
				</tr>
				  
				 				  
			 <tr>
          <th>Codigo</th>
                <th>Recibo</th>
				
				<th>Detalle</th>
				 <th>Monto Bs.</th>
                  <th>Fecha </th>
				   <th>Tipo egreso</th>
                
				</tr></thead>';
            $x = 0;
            foreach ($resultmovil1 as $key=>$value) {
            
			    $x++;
                if(($x%2)==0)
                    $par = "class='TdAlt'";
                else $par = "";
	        
			//	$interesprestamo =($prestamo['monto_prestamo']*$interes['interes']/100);
		if($value['tipo'] == 0)
				{ $tipoeg="Lubricantes";}
				 else{
				 				  			  
				$tipoeg="Lavadero";}
				
                $list .= '<tbody>
							<tr '.$par.'>
                  <td>'.$value["id_egreso"].'</td>
				 <td>'.$value["numero"].'</td>
				 <td>'.$value["concepto"].'</td>
				  <td>'.$value["monto_egreso"].'</td>
				   <td>'.$value["fecha"].'</td>
				   <td>'.$tipoeg.'</td>
				  
				  
                                  </tr></tbody>';
            }
             $list.='<th>Totales
			   <th></th>
			   <th></th>
			 
			   <th><b>Total:<b>'.$totalventas.'</th>
			   <th></th>
			   <th></th>
			   </th></table>';
			   //lista adicional

			   //fin lista
			
        } else $list = '<div>No existen prestamos registrados</div>';
		
		return $list;
	}
    
    function FiltrarFechas() //list for default the all items
	{
		$template = new template;
		$template->SetTemplate('html/reporte_egresos_lavadero.html'); //sets the template for this function
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