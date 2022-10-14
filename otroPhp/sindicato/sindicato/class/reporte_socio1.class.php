<?php
class reporte_socio
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
       $resultmovil1 = $query->getRows("*","movil","where id_linea='1' ");
		
        $hoy = date("Y-m-d");
        $numsocio = count($resultmovil1);
        
		$list = '<form name="formPermiso" method="POST" action="reporte_socio.php?accion=saveUpdatePermiso">';
        if($numsocio > 0) {
            $list .='<table border = "1">
              <thead><tr>
                <th>Num movil</th>
                <th>Linea</th>
				<th>Num de socio</th>
				<th>nombre Socio</th>
				<th>num Hojas</th>
                <th>Dias trabajados socio</th>
			    <th>Ahorro Socio [Bs.]</th>
                <th>Ahorro Movil [Bs.]</th>
				<th>TotalAhorro</th>
                  <th></th>
      			<th>Pagado</th>
      			<th>Ahorro Disponible</th>
      			
			<th>Pagar</th>
      			
	          </tr></thead>';
            $x = 0;
            foreach ($resultmovil1 as $key=>$value) {
            
			    $x++;
                if(($x%2)==0)
                    $par = "class='TdAlt'";
                else $par = "";
		$id_movil = $value['id_movil'];
				
				  $pertenece = $query->getRow("id_socio, placa_movilidad","pertenece","where id_movil = ".$value['id_movil']);
                $socio = $query->getRow("*","socio","where id_socio = ".$pertenece['id_socio']);
                $nombreCompleto = $socio['nombre_socio']." ".$socio['apellido1_socio']." ".$socio['apellido2_socio'];
                $linea = $query -> getRow("linea","linea","where id_linea = ".$value['id_linea']);
				$soloNum = split("_",$value['num_movil']);
             
				$hojas = $query->getRows("*","hoja_control h, movil m, tipo_transaccion tt, tener t, linea l","where h.id_movil = m.id_movil and m.id_linea = l.id_linea and t.id_linea = l.id_linea and tt.id_tipo_transaccion = t.id_tipo_transaccion and t.estado = 'Activo' and tt.id_tipo_transaccion = '1' and h.id_movil = ".$value['id_movil']." and h.alquiler='0' and h.fecha_falta >= '".$fechaInicio."' and h.fecha_falta <= '".$fechaFin."'");
               $numHojas = count($hojas);
			   $hojascontrol = $query->getRows("*","hoja_control","where id_movil = ".$value['id_movil']." and fecha_falta >= '".$fechaInicio."' and fecha_falta <= '".$fechaFin."'");
				  $hojaschofer = $query->getRows("*","hoja_control","where id_movil = ".$value['id_movil']." and id_chofer !='0' and alquiler='0'  and fecha_falta >= '".$fechaInicio."' and fecha_falta <= '".$fechaFin."'");
			  
				$diaschofer = count($hojaschofer);
				$dias_sinchofer=$numHojas - $diaschofer;
				
				$ahorroSocio = $query->getRow("SUM(h.achofer) as total","hoja_control h, movil m, linea l","where h.id_movil = m.id_movil and m.id_linea = l.id_linea and h.id_movil = ".$value['id_movil']." and h.alquiler='0' and h.fecha_falta >= '".$fechaInicio."' and h.fecha_falta <= '".$fechaFin."'");
              $ahorroSo= $ahorroSocio['total'];
              $ahorroChofer = $query->getRow("SUM(h.asocio) as total","hoja_control h, movil m, linea l","where h.id_movil = m.id_movil and m.id_linea = l.id_linea and h.id_movil = ".$value['id_movil']." and h.alquiler='0' and h.fecha_falta >= '".$fechaInicio."' and h.fecha_falta <= '".$fechaFin."'");
        	  $ahorroCho= $ahorroChofer['total'];
			    $totalahorro=$ahorroCho + $ahorroSo;
			   
				
				
			    //de los pagos de ahorros
	   $ahorropagado = $query->getRow("SUM(a.monto_pago_ahorro) as total","pago_ahorro a, movil m","where  a.id_movil=m.id_movil and a.id_movil = ".$value['id_movil']." and a.id_chofer='0' and a.id_alquiler='0' and a.fecha_ahorro_dia >= '".$fechaInicio."' and a.fecha_ahorro_dia <= '".$fechaFin."'");
              $ahorrocancelado= $ahorropagado['total'];
			  
			$saldoahorro = ($totalahorro - $ahorrocancelado);    
			    //fin
			$list .= '<tbody><tr '.$par.'>
                  <td>'.$soloNum[1].'</td>
                  <td>'.$soloNum[0].'</td>
				  <td>'.$socio["num_licencia"].'</td>
				  <td>'.$socio["nombre_socio"].' '.$socio["apellido1_socio"].' '.$socio["apellido2_socio"].'</td>
                 
				 
				  <td>'.$numHojas.'</td>
				  <td>'.$dias_sinchofer.'</td>
				  <td>'.$ahorroCho.'</td>
                  <td>'.$ahorroSo.'</td>
				  <td>'.$totalahorro.'</td>
				  
				  <td><a href="print_reporte_socio1.php?accion=imprimir&id='.$value["id_movil"].'&fi='.$_GET["fechaInicio"].'&ff='.$_GET["fechaFin"].'" 
				 target="_blank" onClick="window.open(this.href, this.target); return false;"  title="Imprimir Reporte">[Ver Informe]</a></td>
				
				<td>'.$ahorrocancelado.'</td>
				  <td>'.$saldoahorro.'</td>
                                  
                                   <td><a href="ahorro.php?accion=pago&id='.$id_movil.'&ahorro='.$saldoahorro.'&fi='.$_GET["fechaInicio"].'&ff='.$_GET["fechaFin"].'" title="Pagar Ahorros"><img src="images/pago.gif"></a></td>
	                  
				 </tr></tbody>';
            }
            $list.='</table>';
        } else $list = '<div>No existen socios registrados</div>';
		return $list;
	}
    
    function FiltrarFechas() //list for default the all items
	{
		$template = new template;
		$template->SetTemplate('html/reporte_socio1.html'); //sets the template for this function
		$template->SetParameter('fecha_ini','2009-04-01');
		
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