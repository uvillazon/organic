<?php
class print_hoja
{
	function Display(){
        $query = new query;
		$template=new template;
		$template->SetTemplate('html/print_hoja_control.html');
        $hoja = $query -> getRow("*","hoja_control","where numero_hoja = ".$_GET['numHoja']);
        $movilSocio = $query->getRow("id_linea, nombre_socio, apellido1_socio, apellido2_socio, num_movil, placa_movilidad, num_licencia","movil m, pertenece p, socio s","where p.id_movil = ".$hoja['id_movil']." and p.id_movil = m.id_movil and p.id_socio = s.id_socio");
        $linea = $query->getRow("linea","linea","where id_linea = ".$movilSocio['id_linea']);
      /*  $detalleImporte = $query->getRows("transaccion, monto_transaccion","tener t, tipo_transaccion tt","where t.id_linea = ".$movilSocio['id_linea']." and t.id_tipo_transaccion = tt.id_tipo_transaccion and t.estado = 'Activo'");
        $detalle = "";
        foreach($detalleImporte as $key=>$value){
            $detalle .= $value['transaccion'].": ".$value['monto_transaccion']." ";
        }*/
$cantidadHojas=$_GET['cantidadHoja'];
	/*$fechacontrol=$hoja['fecha_falta'];

 $valoresPrimera = explode("-", $fechacontrol);
   $anyo   = $valoresPrimera[0];
   $mes  = $valoresPrimera[1];
   $dia    = $valoresPrimera[2];
	$fechaInicio="$anyo-$mes-01";
	$fechaFin=$fechacontrol;
	 $hojas = $query->getRows("*","hoja_control","where id_movil = ".$hoja['id_movil']."  and fecha_falta >= '".$fechaInicio."' and fecha_falta <= '".$fechaFin."'");
                $cantidadHojas = count($hojas);
		*/
		//$detalleImporte = $query->getRows("transaccion, monto_transaccion","tener t, tipo_transaccion tt","where t.id_linea = ".$movilSocio['id_linea']." and t.id_tipo_transaccion = tt.id_tipo_transaccion and t.estado = 'Activo'");
$detalleImporte = $query->getRows("transaccion, monto_transaccion","tipo_transaccion tt","where tt.idaporte='3'");
            
	 $detalle = "";
        foreach($detalleImporte as $key=>$value){
            $detalle .= $value['transaccion'].": ".$value['monto_transaccion']." ";
        }
        $nombreSocio = $movilSocio['nombre_socio']." ".$movilSocio['apellido1_socio']." ".$movilSocio['apellido2_socio'];
        $licenciaSocio = $movilSocio['num_licencia'];
        $nombreConductor = "";
        $licenciaConductor = "";
        if($hoja['id_chofer'] != null){
            $chofer = $query->getRow("nombre_chofer, licencia","chofer","where id_chofer = ".$hoja['id_chofer']);
            $nombreConductor = $chofer['nombre_chofer'];
            $licenciaConductor = $chofer['licencia'];
        } else {
            $nombreConductor = $nombreSocio;
            $licenciaConductor = $licenciaSocio;
        }
        $numMovil = split('_',$movilSocio['num_movil']);
        $template->SetParameter("numHoja",$hoja['numero_hoja']);
        $template->SetParameter("nombreSocio",$nombreSocio);
        $template->SetParameter("numMovil",$numMovil[1]);
        $template->SetParameter("linea",$linea['linea']);
        $template->SetParameter("placa",$movilSocio['placa_movilidad']);
        $template->SetParameter("fechaCompra",$hoja['fecha_de_compra']);
  $template->SetParameter("fechaIniciomes",$hoja['fecha_falta']);

	 $template->SetParameter("numero",$cantidadHojas);
        $template->SetParameter("nombreConductor",$nombreConductor);
        $template->SetParameter("fechaUso",$hoja['fecha_a_usar']);
        $template->SetParameter("totalPago",$hoja['total_hoja']);
        $template->SetParameter("licenciaConductor",$licenciaConductor);
        $template->SetParameter("detalleImporte",$detalle);
        
		return $template->Display();
	}
	function PrimerDiaMes($mes,$anyo)
{
// fecha actual (por ejemplo 2005-08-03)
$date = strtotime($anyo."-".$mes."-01");

// desglosamos la fecha y obtenemos el año, mes y dia del mes (0 hasta 31)
$array_date = getdate($date);
$year = $array_date["year"];
$month = $array_date["mon"];
$month_day = $array_date["mday"];

// construimos una nueva fecha que empieza en el dia "1" por ejemplo 2005-08-01
$array_date = getdate(mktime(0, 0, 0, $month, 1, $year));
return $primerDia = $array_date["wday"];
}
}
?>