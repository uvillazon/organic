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
		//DataBase Conexion//
		$query = new query;
       // $resultsocio= $query->getRows("*","pertenece p","order by p.id_socio");
		//$resultmovil1 = $query->getRows("*","movil","order by id_movil ");
		$resultmovil1 = $query->getRows("*","movil m ","where id_linea= '2'");
		
		//if($tener['estado']=""){
        /*$resultmovil1 = $query->getRows("*","socio m,pertenece p, hoja_control h","where m.id_socio=h.id_socio and p.id_socio=h.id_socio and h.fecha_a_usar >= '".$fechaInicio."' and h.fecha_a_usar <= '".$fechaFin."'");
        */
        $hoy = date("Y-m-d");
        //$numsocio = count($resultsocio);
        $numsocio = count($resultmovil1);
        
		//$list = '<div>N° Dias Hábiles de Trabajo: </div><br />';
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
				<th>Total Ahorro</th>
      
       
	          </tr></thead>';
            $x = 0;
            //foreach ($resultsocio as $key=>$value) {
            foreach ($resultmovil1 as $key=>$value) {
            
			    $x++;
                if(($x%2)==0)
                    $par = "class='TdAlt'";
                else $par = "";
				  $pertenece = $query->getRow("id_socio, placa_movilidad","pertenece","where id_movil = ".$value['id_movil']);
                $socio = $query->getRow("*","socio","where id_socio = ".$pertenece['id_socio']);
                //$socio = $query->getRow("*","socio","where id_socio = 1");
                $nombreCompleto = $socio['nombre_socio']." ".$socio['apellido1_socio']." ".$socio['apellido2_socio'];
                $linea = $query -> getRow("linea","linea","where id_linea = ".$value['id_linea']);
				$hojas = $query->getRows("*","hoja_control","where id_movil = ".$value['id_movil']." and alquiler='0' and fecha_de_compra >= '".$fechaInicio."' and fecha_de_compra <= '".$fechaFin."'");
               $numHojas = count($hojas);
                
				$soloNum = split("_",$value['num_movil']);
              $tener = $query -> getRow("estado","tener","where id_linea = ".$value['id_linea']);
				
			   
                $ahorros = $query->getRows("*","hoja_control h,movil m","where h.id_movil=m.id_movil and alquiler='0'  and m.id_linea='2' and h.id_movil = ".$value['id_movil']." and fecha_de_compra >= '".$fechaInicio."' and fecha_de_compra <= '".$fechaFin."'");
				$numahorro = count($ahorros);
                
				
				$hojaschofer = $query->getRows("*","hoja_control","where id_movil = ".$value['id_movil']." and id_chofer !='0' and alquiler='0'  and fecha_de_compra >= '".$fechaInicio."' and fecha_de_compra <= '".$fechaFin."'");
				$diaschofer = count($hojaschofer);
				$dias_sinchofer=$numHojas - $diaschofer;
				$transaccion2 = $query -> getRow("*","tipo_transaccion","where id_tipo_transaccion = '3'");
				$transaccion = $query -> getRow("*","tipo_transaccion","where id_tipo_transaccion = '2'");
			
				$ahorroSocio = $transaccion['monto_transaccion']*$numahorro;
             
				$ahorrocomochofer=$transaccion2['monto_transaccion']*$dias_sinchofer;
				$totalahorro=$ahorrocomochofer + $ahorroSocio;
                
				
				$list .= '<tbody><tr '.$par.'>
                  <td>'.$soloNum[1].'</td>
                  <td>'.$soloNum[0].'</td>
				  <td>'.$socio["num_licencia"].'</td>
				  <td>'.$socio["nombre_socio"].' '.$socio["apellido1_socio"].' '.$socio["apellido2_socio"].'</td>
                  <td>'.$numHojas.'</td>
				  <td>'.$dias_sinchofer.'</td>
				  
				  <td>'.$ahorrocomochofer.'</td>
                  <td>'.$ahorroSocio.'</td>
                  <td>'.$totalahorro.'</td>
				  
				  <td><a href="print_reporte_socio.php?accion=imprimir&id='.$value["id_movil"].'&fi='.$_GET["fechaInicio"].'&ff='.$_GET["fechaFin"].'" 
				 target="_blank" onClick="window.open(this.href, this.target); return false;"  title="Imprimir Reporte">[Ver Informe]</a></td>
                                  </tr></tbody>';
            }
            $list.='</table>';
        } else $list = '<div>No existen socios registrados</div>';
		return $list;
	}
    
    function FiltrarFechas() //list for default the all items
	{
		$template = new template;
		$template->SetTemplate('html/reporte_socio.html'); //sets the template for this function
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