<?php
class moroso
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
    
    function buscarSocio(){
        $query = new query;
        $nombreSocio = $query->getRow("*","socio","where num_licencia = ".$_GET['licencia']);
        $nombreCompleto = $nombreSocio['nombre_socio']." ".$nombreSocio['apellido1_socio']." ".$nombreSocio['apellido2_socio'];
		return "<span>".$nombreCompleto."</span><input type=\"hidden\" name=\"idSocio\" value=\"".$nombreSocio['id_socio']."\">";
	}
    
	function buscarChofer(){
        $query = new query;
        $nombreChofer = $query->getRow("*","chofer","where num_chofer = ".$_GET['licencia']);
        $nombreCompleto = $nombreChofer['nombre_chofer'];
		return "<span>".$nombreCompleto."</span><input type=\"hidden\" name=\"idChofer\" value=\"".$nombreChofer['id_chofer']."\">";
	}
	
    function listarMorosos() //list for default the all items
	{
		$template = new template;
		$template->SetTemplate('html/lista_moroso132.html'); //sets the template for this function
		$template->SetParameter('hoy',date('d-M-Y'));
                
		//DataBase Conexion//
		$query = new query;
        $confirm="javascript:return confirm('Esta seguro de eliminar esta morosidad?');";
		$str = "-1 week";
		$fecha_anterior = date('Y-m-d', strtotime($str));
		$fecha_actual = date('Y-m-d', strtotime("now"));
		//  $resultprestamo1 = $query->getRows("*","prestamo_socio a, tipo_prestamo b,pertenece p,movil m ","WHERE a.id_tipo_prestamo=b.id_tipo_prestamo and p.id_socio=a.socio and p.id_movil=m.id_movil and m.id_linea='1' ORDER by id_prestamo DESC");
       
        $resultprestamo = $query->getRows("*","plan_de_pagos pp,prestamo_socio a,pertenece p,movil m ","WHERE pp.id_prestamo=a.id_prestamo and p.id_socio=a.socio and p.id_movil=m.id_movil and m.id_linea='2' and pp.fecha_pago>='".$fecha_anterior."' and pp.fecha_pago<'".$fecha_actual."'ORDER by pp.id_prestamo");
        //$resultprestamo = $query->getRows("*","plan_de_pagos","WHERE fecha_pago>='".$fecha_anterior."' and fecha_pago<'".$fecha_actual."'ORDER by id_prestamo");
        
		$numprestamo = count($resultprestamo);
        if($numprestamo > 0) {
            $list ='<table border = "1">
              <thead><tr>
			       <th>Num Prestamo</th>
           
                <th>Socio</th>
                <th>Chofer</th>
                <th>Deuda</th>
               
				<th>Monto pagado</th>
                <th>Fecha pago</th>
				<th>Pagar</th>
              </tr></thead>';
            $x = 0;
            foreach ($resultprestamo as $key=>$value) {
				//
				//verifyng if has debts
				$id_prestamo = $value['id_prestamo'];
				$resultdeposito = $query->getRow("sum(monto_deposito) as totaldeposito","deposito","WHERE id_prestamo=".$id_prestamo);
				$resultprestamo = $query -> getRow("*","prestamo_socio","where id_prestamo=".$id_prestamo);
        $interes = $query ->getRow("*","tipo_prestamo","where id_tipo_prestamo = ".$resultprestamo['id_tipo_prestamo']);
        //$deudaalafecha = $resultprestamo['monto_prestamo'] + ($resultprestamo['monto_prestamo']*$interes['interes']/100);
		//total prestamo    535 ej
		$deudaalafecha = $value['monto_pago'] * $value['semana'];
				if ($deudaalafecha > $resultdeposito['totaldeposito'])
				{
					//showing if has debts
	                $x++;
	                if(($x%2)==0)
	                    $par = "class='TdAlt'";
	                else $par = "";
					$prestamo = $query->getRow("*","prestamo_socio","WHERE id_prestamo=".$id_prestamo);
	                $socio = $query->getRow("*","socio","where id_socio = ".$prestamo['socio']);
	                $nombreCompleto = $socio['nombre_socio']." ".$socio['apellido1_socio']." ".$socio['apellido2_socio'];
	                $chofer = $query -> getRow("nombre_chofer","chofer","where id_chofer = ".$prestamo['chofer']);
					$deuda = $deudaalafecha - $resultdeposito['totaldeposito'];
//  <td>'.$deudaalafecha.'</td>  despues de deuda
										
					$list .= '<tbody><tr '.$par.'>
         <td>'.$resultprestamo['id_prestamo'].'</td>		 		                 
				       
           <td>'.$nombreCompleto.'</td>
					  <td>'.$chofer["nombre_chofer"].'</td>
					  <td>'.$deuda.'</td>
	                  <td>'.$resultdeposito["totaldeposito"].'</td>
	                  <td>'.$value['fecha_pago'].'</td>
					  <td><a href="prestamo132.php?accion=pago&id='.$id_prestamo.'" title="Pagar Prestamo"><img src="images/pago.gif"></a></td>
	                  </tr></tbody>';
	            }
			}
            $list.='</table>';
        } else $list = '<div>No existen morosos a la fecha</div>';
        $template->SetParameter('add','<a href="print_morosos.php" target="_blank" onClick="window.open(this.href, this.target); return false;" title="Lista Morosos">Vista de Impresion</a>
');
		$template->SetParameter('contenido',$list);
		return $template->Display();
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
        if($_GET['accion']==""){
            $template->SetParameter('contenido',$this->listarMorosos());
        }
		$template->SetParameter('pie',navigation::showpie());
		return $template->Display();
	}
}
?>
