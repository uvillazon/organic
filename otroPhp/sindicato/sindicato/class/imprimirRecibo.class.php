<?php
class imprimirRecibo
{
	function Display(){
        $query = new query;
		$template=new template;
		$template->SetTemplate('html/imprimirRecibo.html');
        $hoja = $query -> getRow("*","ingreso","where numero_registro = ".$_GET['numHoja']);
       $movilSocio = $query->getRow("id_linea, m.id_movil,s.id_socio, s.nombre_socio, s.apellido1_socio, s.apellido2_socio, num_movil","movil m,ingreso i, pertenece p, socio s","where i.id_movil=p.id_movil and s.id_socio=p.id_socio and p.id_movil = m.id_movil and i.numero_registro =  ".$_GET['numHoja'] );
        
		/*
		$movilSocio = $query->getRow("id_linea, nombre_socio, apellido1_socio, apellido2_socio, num_movil, placa_movilidad, num_licencia","movil m, pertenece p, socio s","where p.id_movil = ".$hoja['id_movil']." and p.id_movil = m.id_movil and p.id_socio = s.id_socio");*/
		
		$linea = $query->getRow("linea","linea","where id_linea = ".$movilSocio['id_linea']);
        $nombreSocio = $movilSocio['nombre_socio']." ".$movilSocio['apellido1_socio']." ".$movilSocio['apellido2_socio'];
        $nombreConductor = "";
        $licenciaConductor = "";
        $movil = $query->getRow("num_movil","movil","where id_movil = ".$movilSocio['id_movil']);
		
			
//echo $fecha
		
        $tipo = $query->getRow("tipo_ingreso","tipo_ingreso ti, ingreso i","where i.id_tipo_ingreso=ti.id_tipo_ingreso and ti.id_tipo_ingreso= ".$hoja['id_tipo_ingreso']);
        $numMovil = split('_',$movil['num_movil']);
        $monto = '';
        if($hoja["monto_pago_ingreso"]==0)
            $monto = $hoja["monto_ingreso_dolar"]." $";
        else 
            $monto = $hoja["monto_pago_ingreso"]." Bs";
        $template->SetParameter("numHoja",$hoja['numero_registro']);
        $template->SetParameter("nombreSocio",$nombreSocio);
        $template->SetParameter("Movil",$numMovil[1]);
		$template->SetParameter("linea",$linea['linea']);
		$fecha=$hoja['fecha_ingreso']; // El formato que te entrega MySQL es Y-m-d 
             $fecha=date("d-m-Y",strtotime($fecha)); 
        $template->SetParameter("fechaCompra",$fecha);
        $template->SetParameter("totalPago",$monto);
        $template->SetParameter("descripcion",$hoja['concepto_ingreso']);
        $template->SetParameter("concepto",$tipo['tipo_ingreso']);
        
		return $template->Display();
	}
}
?>