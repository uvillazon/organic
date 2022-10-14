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
		//DataBase Conexion//
		$query = new query;
       // $resultsocio= $query->getRows("*","pertenece p","order by p.id_movil");
		$resultmovil1 = $query->getRows("*","movil","order by id_movil ");
        /*$resultmovil1 = $query->getRows("*","movil m,pertenece p, hoja_control h","where m.id_movil=h.id_movil and p.id_movil=h.id_movil and h.fecha_a_usar >= '".$fechaInicio."' and h.fecha_a_usar <= '".$fechaFin."'");
        */
        $hoy = date("Y-m-d");
        //$numsocio = count($resultsocio);
        $numsocio = count($resultmovil1);
        
		//$list = '<div>N° Dias Hábiles de Trabajo: </div><br />';
		$list = '<form name="formPermiso" method="POST" action="reporte_movil.php?accion=saveUpdatePermiso">';
        if($numsocio > 0) {
            $list .='<table border = "1">
              <thead><tr>
                <th>Numero de Movil</th>
				<th>Linea</th>
				<th>Nombre Socio</th>
                <th>Licencia</th>
                <th>Numero de placa</th>
                <th>Hojas Compradas</th>
                <th></th>
       
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
               
               
				$pertenece2 = $query -> getRow("*","pertenece p,hoja_control h","where p.id_movil = ".$value['id_movil']." and p.id_movil=h.id_movil and h.fecha_de_compra >= '".$fechaInicio."' and h.fecha_de_compra <= '".$fechaFin."'");
				$hojas = $query->getRows("*","hoja_control","where id_movil = ".$value['id_movil']." and fecha_de_compra >= '".$fechaInicio."' and fecha_de_compra <= '".$fechaFin."'");
				$numHojas = count($hojas);
                
				$soloNum = split("_",$value['num_movil']);
                
				$numfalta = count($pertenece);
                
				$numcobrar = $numTrabajados - $pertenece["num_dias_permiso"];
				
                $list .= '<tbody><tr '.$par.'>
                  <td>'.$soloNum[1].'</td>
                  <td>'.$soloNum[0].'</td>
				  <td>'.$socio["nombre_socio"].' '.$socio["apellido1_socio"].' '.$socio["apellido2_socio"].'</td>
                  <td>'.$socio["num_licencia"].'</td>
                  <td>'.$pertenece["placa_movilidad"].'</td>
				   <td>'.$numHojas.'</td>
                  <td><a href="print_reporte_movil.php?accion=imprimir&id='.$value["id_movil"].'&fi='.$_GET["fechaInicio"].'&ff='.$_GET["fechaFin"].'" 
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
		$template->SetTemplate('html/reporte_movil.html'); //sets the template for this function
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