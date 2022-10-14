<?php
class reporte_alquiler
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

    function imprimirReporte(){
    $fechaInicio = $_GET[fi];
        $fechaFin = $_GET[ff];
		
        $query = new query;
        $movil = $query -> getRow("*","movil","where id_movil = ".$_GET[id]);
        $pertenece = $query -> getRow("*","pertenece","where id_movil = ".$_GET[id]);
        $socio = $query -> getRow("*","socio","where id_socio = ".$pertenece['id_socio']);
		$template = new template;
		$template->SetTemplate('html/form_reporte_movil.html');
		$fecha=$fechaInicio; // El formato que te entrega MySQL es Y-m-d 
             $fechaIni=date("d-m-Y",strtotime($fecha)); 
		$template->SetParameter('fechainicio',$fechaIni);
		$fecha2=$fechaFin; // El formato que te entrega MySQL es Y-m-d 
             $fechaF=date("d-m-Y",strtotime($fecha2)); 
        $template->SetParameter('fechafin',$fechaF);
        
		$template->SetParameter('licencia',$socio['num_licencia']);
        $nombreSocio = $socio['nombre_socio']." ".$socio['apellido1_socio']." ".$socio['apellido2_socio'];
		$template->SetParameter('nombreSocio',$nombreSocio);
               $soloNum = split("_",$movil['num_movil']);
        $template->SetParameter('titulo','REPORTE MOVIL');
        $template->SetParameter('lineas',$soloNum[0]);
		$template->SetParameter('numeroMovil',$soloNum[1]);
		$hojas = $query->getRows("*","hoja_control","where id_movil = ".$pertenece['id_movil']." and fecha_falta >= '".$fechaInicio."' and fecha_falta <= '".$fechaFin."'");
                $hojasUsadas = $query->getRows("*","hoja_control","where id_movil = ".$pertenece['id_movil']." and fecha_falta >= '".$fechaInicio."' and fecha_falta <= '".$fechaFin."'");
$numHojas = count($hojas);
                $numHojasUsadas = count($hojasUsadas);
                $numTrabajados = $numHojas - $numHojasUsadas;
        $template->SetParameter('diastrabajados',$numHojasUsadas);
        $template->SetParameter('hojas',$numHojas);
		$template->SetParameter('diasnotrabajados',$numTrabajados);
		$template->SetParameter('diaspermisoLibre',$pertenece["num_dias_permiso"]);
        $ingreso = $query->getRows("id_tipo_ingreso","ingreso ","where id_tipo_ingreso='5' and id_socio= ".$pertenece['id_socio']."");
		$ingresoa = count($ingreso);
		
		$template->SetParameter('diasatrasotrab',$ingresoa);
		$totalPa = $query->getRow("SUM(monto_pago_ingreso) as total","ingreso ","where id_tipo_ingreso='5' and id_socio= ".$pertenece['id_socio']." and fecha_ingreso >= '".$fechaInicio."' and fecha_ingreso <= '".$fechaFin."'");
		$template->SetParameter('totalatrasotrab',$totalpa['total']);
		
        $ingresob = $query->getRows("id_tipo_ingreso","ingreso ","where id_tipo_ingreso='2' and id_socio= ".$pertenece['id_socio']." and fecha_ingreso >= '".$fechaInicio."' and fecha_ingreso <= '".$fechaFin."'");
		$ingresoc = count($ingresob);
	    $template->SetParameter('diaspermiso',$ingresoc);
		$totalPago = $query->getRow("SUM(monto_pago_ingreso) as total","ingreso ","where id_tipo_ingreso='2' and id_socio= ".$pertenece['id_socio']." and fecha_ingreso >= '".$fechaInicio."' and fecha_ingreso <= '".$fechaFin."'");
        $template->SetParameter('totalpermiso',$totalPago['total']);
		
		//$template->SetParameter('totalpermiso',$ingresoto['total']);
		
		$ingresod = $query->getRows("id_tipo_ingreso","ingreso ","where id_tipo_ingreso='4' and id_socio= ".$pertenece['id_socio']." and fecha_ingreso >= '".$fechaInicio."' and fecha_ingreso <= '".$fechaFin."'");
		$ingresoe = count($ingresod);
	    $template->SetParameter('diasatraso',$ingresoe);
		$totalPag = $query->getRow("SUM(monto_pago_ingreso) as total","ingreso ","where id_tipo_ingreso='4' and id_socio= ".$pertenece['id_socio']." and fecha_ingreso >= '".$fechaInicio."' and fecha_ingreso <= '".$fechaFin."'");
		$template->SetParameter('totalatraso',$totalPag['total']);
		
		$ingresof = $query->getRows("id_tipo_ingreso","ingreso ","where id_tipo_ingreso='3' and id_socio= ".$pertenece['id_socio']." and fecha_ingreso >= '".$fechaInicio."' and fecha_ingreso <= '".$fechaFin."'");
		$ingresog = count($ingresof);
	    $template->SetParameter('diasfalta',$ingresog);
		$totali = $query->getRow("SUM(monto_pago_ingreso) as total","ingreso ","where id_tipo_ingreso='3' and id_socio= ".$pertenece['id_socio']." and fecha_ingreso >= '".$fechaInicio."' and fecha_ingreso <= '".$fechaFin."'");
		$template->SetParameter('totalfalta',$totali['total']);
		
		$ingresoh = $query->getRows("id_tipo_ingreso","ingreso ","where id_tipo_ingreso='9' and id_socio= ".$pertenece['id_socio']." and fecha_ingreso >= '".$fechaInicio."' and fecha_ingreso <= '".$fechaFin."'");
		$ingresoi = count($ingresoh);
	    $template->SetParameter('permisoas',$ingresoa);
		$totalas = $query->getRow("SUM(monto_pago_ingreso) as total","ingreso ","where id_tipo_ingreso='9' and id_socio= ".$pertenece['id_socio']." and fecha_ingreso >= '".$fechaInicio."' and fecha_ingreso <= '".$fechaFin."'");
		$template->SetParameter('totalasamblea',$totalas['total']);
		return $template->Display();
	}
    
    
	
    
    function DiasReporte() //list for default the all items
	{
        $fechaInicio = $_GET[fechaInicio];
        $fechaFin = $_GET[fechaFin];
		//DataBase Conexion//
		$query = new query;
       // $resultsocio= $query->getRows("*","pertenece p","order by p.id_movil");
		$resultmovil1 = $query->getRows("*","chofer","WHERE tipo_chofer = 'alquiler'");
        /*$resultmovil1 = $query->getRows("*","movil m,pertenece p, hoja_control h","where m.id_movil=h.id_movil and p.id_movil=h.id_movil and h.fecha_falta >= '".$fechaInicio."' and h.fecha_falta <= '".$fechaFin."'");
        */
        $hoy = date("Y-m-d");
        //$numsocio = count($resultsocio);
        $numsocio = count($resultmovil1);
        
		//$list = '<div>N° Dias Hábiles de Trabajo: </div><br />';
		$list = '<form name="formPermiso" method="POST" action="reporte_chofer.php?accion=saveUpdatePermiso">';
        if($numsocio > 0) {
            $list .='<table border = "1">
              <thead><tr>
                <th>Numero de Alquiler</th>
				<th>Nombre Completo</th>
                <th> Dias trabajados</th>
                <th>Ahorro en Bolivianos</th>
                <th>Pagado</th>
      			<th>Ahorro Disponible</th>
      			<th></th>
			<th>Pagar</th>
      		
	          </tr></thead>';
            $x = 0;
            //foreach ($resultsocio as $key=>$value) {
            foreach ($resultmovil1 as $key=>$value) {
            
			    $x++;
                if(($x%2)==0)
                    $par = "class='TdAlt'";
                else $par = "";
		$id_chofer = $value['id_chofer'];
				
				 $pertenece = $query->getRow("*","hoja_control h, chofer c","where h.id_chofer = ".$value['id_chofer']);
				 
                
				$hojas = $query->getRows("*","hoja_control h,movil m,linea l","where h.id_movil=m.id_movil and m.id_linea=l.id_linea and id_chofer = ".$value['id_chofer']."  and fecha_falta >= '".$fechaInicio."' and fecha_falta <= '".$fechaFin."'");
				$numHojas = count($hojas);
                
				$transaccion = $query -> getRow("*","tipo_transaccion","where id_tipo_transaccion = '3'");
				$interes = $transaccion['monto_transaccion']*$numHojas;
               $interes=$interes*2;
						//de los pagos de ahorros
	   $ahorropagado = $query->getRow("SUM(a.monto_pago_ahorro) as total","pago_ahorro a, chofer c","where a.id_chofer=c.id_chofer and a.id_chofer = ".$value['id_chofer']." and a.id_movil='0' and a.id_alquiler='0' and a.fecha_ahorro_dia >= '".$fechaInicio."' and a.fecha_ahorro_dia <= '".$fechaFin."'");
              $ahorrocancelado= $ahorropagado['total'];
			  
			$saldoahorro = ($interes - $ahorrocancelado);    
			    //fin
		
                $list .= '<tbody><tr '.$par.'>
                 
                  <td>'.$value["num_chofer"].'</td>
				   <td>'.$value["nombre_chofer"].'</td>
				  <td align="center">'.$numHojas.'</td>
                  <td align="center">'.$interes.'</td>
                  <td>'.$ahorrocancelado.'</td>
				  <td>'.$saldoahorro.'</td>
                                  
                                   <td><a href="ahorro.php?accion=pagochofer&id='.$id_chofer.'&ahorro='.$saldoahorro.'&fi='.$_GET["fechaInicio"].'&ff='.$_GET["fechaFin"].'" title="Pagar Ahorros"><img src="images/pago.gif"></a></td>
	         <td><a href="print_reporte_ahorrochofer2.php?accion=imprimir&id='.$value["id_chofer"].'&fi='.$_GET["fechaInicio"].'&ff='.$_GET["fechaFin"].'" 
				 target="_blank" onClick="window.open(this.href, this.target); return false;"  title="Imprimir Reporte">[Ver Informe]</a></td>
				
                                  </tr></tbody>';
            }
            $list.='</table>';
        } else $list = '<div>No existen registrados</div>';
		
		return $list;
		
		
		
	}
    
    function FiltrarFechas() //list for default the all items
	{
		$template = new template;
		
		$template->SetTemplate('html/reporte_alquiler.html'); //sets the template for this function
		$template->SetParameter('fecha_fin',date('Y-m-d'));
		$template->SetParameter('contenido','');
		
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