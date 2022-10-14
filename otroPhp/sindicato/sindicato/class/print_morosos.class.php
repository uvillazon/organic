<?php
class print_morosos
{

function Display()

{
      
		$query = new query;
        $hoy = date("Y-m-d");
		$fecha=date("d-m-Y",strtotime($hoy)); 
		$str = "-1 week";
		$fecha_anterior = date('Y-m-d', strtotime($str));
		$fecha_actual = date('Y-m-d', strtotime("now"));
        $resultprestamo = $query->getRows("*","plan_de_pagos","WHERE fecha_pago>='".$fecha_anterior."' and fecha_pago<'".$fecha_actual."'");
        $numprestamo = count($resultprestamo);
        if($numprestamo > 0) {
            $list ='<table border = "1">
              <thead>
			  <tr>Lista de Morosos </tr></br>
			  <tr>A la Fecha :<tr>'.$fecha.'</tr> 
			  <tr>
                <th>Socio</th>
                <th>Chofer</th>
                <th>Deuda</th>
                <th>Monto esperado</th>
				<th>Monto pagado</th>
                <th>Fecha pago</th></br>
				<tr>Comunicado a socios y choferes, Se recuerda a los socios y/o choferes pasar</br> a cancelar sus deudas pendientes </tr>
              </tr></thead>';
            $x = 0;
            foreach ($resultprestamo as $key=>$value) {
				//
				//verifyng if has debts
				$id_prestamo = $value['id_prestamo'];
				$resultdeposito = $query->getRow("sum(monto_deposito) as totaldeposito","deposito","WHERE id_prestamo=".$id_prestamo);
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
					$fechapago = $value['fecha_pago'];
					$fechap=date("d-m-Y",strtotime($fechapago)); 
	                $list .= '<tbody><tr '.$par.'>
	                  <td>'.$nombreCompleto.'</td>
					  <td>'.$chofer["nombre_chofer"].'</td>
					  <td>'.$deuda.'</td>
	                  <td>'.$deudaalafecha.'</td>
					  <td>'.$resultdeposito["totaldeposito"].'</td>
	                  <td>'.$fechap.'</td>
					  
	                  </tr></tbody>';
	            }
			}
            $list.='</table>';
        } else $list = '<div>No existen morosos </div>';
		return $list;
		
		
		return $template->Display();
	}
}
?>