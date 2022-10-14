<?php
class print_prestamo
{

function Display(){
        
		$fechaInicio = $_GET[fi];
        $fechaFin = $_GET[ff];
		$query = new query;
      
     	        $hoy = date("Y-m-d");
				$fecha=$fechaInicio; // El formato que te entrega MySQL es Y-m-d 
             $fechaIni=date("d-m-Y",strtotime($fecha)); 
		
		$fecha2=$fechaFin; // El formato que te entrega MySQL es Y-m-d 
             $fechaF=date("d-m-Y",strtotime($fecha2)); 
        $resultmovil1 = $query->getRows("*","tipo_prestamo order by id_tipo_prestamo");
       
	   $resultmovil2 = $query->getRows("*","deposito","WHERE fecha_deposito >= '".$fechaInicio."' and fecha_deposito <= '".$fechaFin."'");
		       
	   $totalDiaBs = $query->getRow("SUM(monto_deposito) as totalDiabs","deposito","where fecha_deposito >= '".$fechaInicio."' and fecha_deposito <= '".$fechaFin."'");
		 $recaudado = $totalDiaBs['totalDiabs'];
			   $hoy = date("Y-m-d");
        $numsocio = count($resultmovil1);
        
		$list = '<form name="formPermiso" method="POST" action="reporte_prestamos.php?accion=saveUpdatePermiso">';
        if($numsocio > 0) {
            $list .='<table border = "1">
              <thead>
			  <tr>Reporte de Depositos realizados entre las fechas:</tr></br>
			  <tr><b>Del :<tr>'.$fechaIni.'</tr> <b>Al:<tr>'.$fechaF.'</tr>
			  <tr><b>Recaudado:</tr><tr><b>'.$recaudado.'</tr>
			  <tr>
			  <tr>
                <th>Nro Tipo Prestamo</th>
	       	<th>Tipo Prestamo</th>
		    <th>Interes</th>
               <th>Monto Depositado</th>
                <th>----</th>
				</tr></thead>';
            $x = 0;
            foreach ($resultmovil1 as $key=>$value) {
            
			    $x++;
                if(($x%2)==0)
                    $par = "class='TdAlt'";
                else $par = "";
	       
		   $total = $query -> getRow("SUM(monto_deposito) as total","deposito d, prestamo_socio p, tipo_prestamo tp","where d.id_prestamo=p.id_prestamo and p.id_tipo_prestamo = tp.id_tipo_prestamo and tp.id_tipo_prestamo = ".$value['id_tipo_prestamo']." and d.fecha_deposito >= '".$fechaInicio."' and d.fecha_deposito <= '".$fechaFin."'");

				
				$list .= '<tbody><tr '.$par.'>
				   <td>'.$value["id_tipo_prestamo"].'</td>
				     <td>'.$value["tipo_prestamo"].'</td>
					   <td>'.$value["interes"].'</td>
                  <td>'.$total["total"].'</td>
		          <td>'.$nombreCompleto.'</td>
               
                  
				  
                                  </tr></tbody>';
            }
            $list.='</table>';
        } else $list = '<div>No existen socios registrados</div>';
		return $list;
		return $template->Display();
	}
}
?>