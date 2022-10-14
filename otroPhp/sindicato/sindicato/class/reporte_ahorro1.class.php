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
      //$resultmovil1 = $query->getRows("*","prestamo_socio a, tipo_prestamo b ","WHERE b.interes!='0.00' and a.id_tipo_prestamo=b.id_tipo_prestamo and a.fecha_prestamo >= '".$fechaInicio."' and a.fecha_prestamo <= '".$fechaFin."' order by id_prestamo");
		      
	   $hoy = date("Y-m-d");
         $resulthoja1 = $query->getRows("*","pago_ahorro","where fecha_cobro >= '".$fechaInicio."' and fecha_cobro <= '".$fechaFin."' ORDER BY id_ahorro");
        $numhoja = count($resulthoja1);
	$totalDia = $query->getRow("SUM(monto_pago_ahorro) as totalDia","pago_ahorro","where fecha_cobro >= '".$fechaInicio."' and fecha_cobro <= '".$fechaFin."'");
      $totalbs = $totalDia['totalDia'];
       
        $list = '<form name="formRecibir" method="POST" action="ahorro.php?accion=recibir">';
        if($numhoja > 0) {
           $list ='<table border = "1">
              <thead>
	      <tr><b>Total Bs:<b>'.$totalbs.'<tr></tr>
		
	      <tr>
                <th>Nro</th>
                <th>Fecha</th>
                <th>Linea</th>
		<th>Movil</th>
		<th>Socio</th>
                <th>Conductor </th>
                <th>Tipo</th>
		<th>Concepto</th>
		<th>Monto Pago ahorro</th>
                <th></th>
                </tr></thead>';
            $x = 0;
            foreach ($resulthoja1 as $key=>$value) {
                $x++;
                if(($x%2)==0)
                    $par = "class='TdAlt'";
                else $par = "";
				/////////////////////////////////////////////////
		if($value["id_movil"]!=0)
		{	
		 $movil = $query -> getRow("*","movil","where id_movil = ".$value['id_movil']);
        $pertenece = $query -> getRow("*","pertenece","where id_movil =  ".$value['id_movil']);
        $socio = $query -> getRow("*","socio","where id_socio = ".$pertenece['id_socio']);
	
                //$socio = $query->getRow("*","socio","where id_socio = ".$value['id_socio']);
                $nombreCompleto = $socio['nombre_socio']." ".$socio['apellido1_socio']." ".$socio['apellido2_socio'];
		$linea = $query->getRow("linea, num_movil","linea l, movil m","where m.id_movil = ".$value['id_movil']." and m.id_linea = l.id_linea");
                $numMovil = split('_',$linea["num_movil"]);
		$linea =$linea["linea"];
                $movil = $numMovil[1];
		$tipo = "-";
                
		}
		else  if($value["id_movil"]==0)
	{
		$chofer = $query -> getRow("*","chofer","where id_chofer = ".$value['id_chofer']);
  //$alquiler = $query -> getRow("nombre_chofer","chofer","where tipo_chofer='alquiler' AND id_chofer = ".$value['id_alquiler']);
		$linea ="-";
                $movil = "-";
                $nombreCompleto ="-";
		
	 }     
	 $chofer = $query -> getRow("*","chofer","where id_chofer = ".$value['id_chofer']);
	  if($chofer["tipo_chofer"]=='Permanente')
	  $tipo = "Chofer";
	  else if ($chofer["tipo_chofer"]=='alquiler')
             $tipo = "Alquiler";

	 
                $list .= '<tbody><tr '.$par.'>
	          <td>'.$value["id_ahorro"].'</td>
                  <td>'.$value["fecha_cobro"].'</td>
		  <td>'.$linea.'</td>
                  <td>'.$movil.'</td>
                  <td>'.$nombreCompleto.'</td>
                  <td>'.$chofer["nombre_chofer"].'</td>
                   <td>'.$tipo.'</td>
                  <td>'.$value["concepto"].'</td>
		  <td>'.$value["monto_pago_ahorro"].'</td>
		  

                  </tr>
			</tbody>';
			}
			
            $list.='<th>Totales
			   <th></th>
			   <th></th>
			   <th></th>
			   <th></th>
			   <th></th>
			   <th></th>
			   <th></th>
			   <th>'.$totalbs.'</th>
			   </th></table>';
			
        } else $list = '<div>No existen pagos registrados</div>';
		
		return $list;
	}
    
    function FiltrarFechas() //list for default the all items
	{
		$template = new template;
		$template->SetTemplate('html/reporte_ahorro.html'); //sets the template for this function
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