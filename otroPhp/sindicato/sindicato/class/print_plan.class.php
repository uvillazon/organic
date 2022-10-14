<?php
class print_plan
{

  function Display(){
	$template = new template;
		$template->SetTemplate('html/lista_print_plan.html'); //sets the template for this function
		
		//DataBase Conexion//
		$query = new query;
		$resultprestamo = $query -> getRow("*","prestamo_socio","where id_prestamo = ".$_GET[id]);
        $socio = $query -> getRow("*","socio","where id_socio = ".$resultprestamo['socio']);
		$chofer = $query ->getRow("*","chofer","where id_chofer = ".$resultprestamo['chofer']);
		$interes = $query ->getRow("*","tipo_prestamo","where id_tipo_prestamo = ".$resultprestamo['id_tipo_prestamo']);
        $resultplan = $query->getRows("*","plan_de_pagos","WHERE id_prestamo=".$_GET['id']." ORDER by id_plan");
        $numplan = count($resultplan);
        if($numplan > 0) {
            $list ='<center><table border = "1">
              <thead><tr>
                <th>Fecha</th>
				<th>Capital</th>
                <th>Interes</th>
				<th>Monto a Pagar</th>
                <th>Saldo</th>
				<th>Monto adelantado</th>
              </tr></thead>';
            $x = 0;
            foreach ($resultplan as $key=>$value) {
                $x++;
                if(($x%2)==0)
                    $par = "class='TdAlt'";
                else $par = "";
                
                $list .= '<tbody><tr '.$par.'>
                  <td>'.$value["fecha_pago"].'</td>
				  <td>'.$value["capitalsem"].'</td>
				  <td>'.$value["interessem"].'</td>
                  <td>'.$value["monto_pago"].'</td>
				  <td>'.$value["saldo_pago"].'</td>
				  <td>'.$value["monto_semana"].'</td>
                  </tr></tbody>';
            }
            $list.='</table></center>';
        } else $list = '<div>No existe un Plan de pagos registrado</div>';
		$selectweeks=0;
		for($m=8;$m<25;$m++)
			$selectweeks .= "<option value='".$m."'>".$m."</option>";
		$totalPago = $resultprestamo['monto_prestamo'] + ($resultprestamo['monto_prestamo']*$interes['interes']/100);
		$nombreSocio = $socio['nombre_socio']." ".$socio['apellido1_socio']." ".$socio['apellido2_socio'];
		$template->SetParameter('nombreSocio',"<span>".$nombreSocio."</span><input type=\"hidden\" name=\"idSocio\" value=\"".$socio['id_socio']."\">");
		$template->SetParameter('nombreChofer',"<span>".$chofer['nombre_chofer']."</span><input type=\"hidden\" name=\"idChofer\" value=\"".$chofer['idchofer']."\">");
        $template->SetParameter('montoPrestamo',$resultprestamo['monto_prestamo']);
		$template->SetParameter('id_prestamo',$resultprestamo['id_prestamo']);
		$template->SetParameter('descripcionPrestamo',$resultprestamo['descripcion_prestamo']);
		$template->SetParameter('weeks',$selectweeks);
		$template->SetParameter('tipoprestamo',$script);
		$template->SetParameter('interes',$interes['interes']);
		$template->SetParameter('total',$totalPago);
        $buttonAdd = '<input type="button" value="CALCULAR Y GUARDAR" onclick="window.location.href=\'prestamo.php?accion=calcularPlan&id='.$_GET['id'].'\'">';
		$template->SetParameter('accion','calcularPlan');
        $template->SetParameter('Add','');//$buttonAdd);
		$template->SetParameter('contenido',$list);
		return $template->Display();
	}
}
?>