<?php
class print_movil
{
	function Display(){
        $fechaInicio = $_GET[fi];
        $fechaFin = $_GET[ff];
		
        $query = new query;
        $movil = $query -> getRow("*","movil","where id_movil = ".$_GET[id]);
        $pertenece = $query -> getRow("*","pertenece","where id_movil = ".$_GET[id]);
		$permiso = $query -> getRow("*","permiso","where id_movil = ".$_GET[id]);
        $socio = $query -> getRow("*","socio","where id_socio = ".$pertenece['id_socio']);
		$template = new template;
		$template->SetTemplate('html/form_reporte_movil.html');
		$fecha=$fechaInicio; // El formato que te entrega MySQL es Y-m-d 
             $fechaIni=date("d-m-Y",strtotime($fecha)); 
		$template->SetParameter('fechainicio',$fechaIni);
		$fecha2=$fechaFin; // El formato que te entrega MySQL es Y-m-d 
             $fechaF=date("d-m-Y",strtotime($fecha2)); 
        $template->SetParameter('fechafin',$fechaF);
        
		$template->SetParameter('licencia',$socio['num_licencia']);
        $nombreSocio = $socio['nombre_socio']." ".$socio['apellido1_socio']." ".$socio['apellido2_socio'];
		$template->SetParameter('nombreSocio',$nombreSocio);
               $soloNum = split("_",$movil['num_movil']);
        $template->SetParameter('titulo','REPORTE MOVIL');
        $template->SetParameter('lineas',$soloNum[0]);
		$template->SetParameter('numeroMovil',$soloNum[1]);
		$hojas = $query->getRows("*","hoja_control","where id_movil = ".$pertenece['id_movil']." and fecha_de_compra >= '".$fechaInicio."' and fecha_de_compra <= '".$fechaFin."'");
$numHojas = count($hojas);
		$faltas = $query->getRows("*","dia_no_trabajado","where id_movil = ".$pertenece['id_movil']." and observacion_falta = 'Falta' and fecha_no_trabajo >= '".$fechaInicio."' and fecha_no_trabajo <= '".$fechaFin."'");
					$numFaltas = count($faltas);
               /* $hojasUsadas = $query->getRows("*","hoja_control","where id_movil = ".$pertenece['id_movil']." and hoja_usada = 'Recibido' and fecha_de_compra >= '".$fechaInicio."' and fecha_de_compra <= '".$fechaFin."'");*/

                //$numHojasUsadas = count($hojasUsadas);
                //$numTrabajados = $numHojas - $numHojasUsadas;
        //$template->SetParameter('diastrabajados',$numHojasUsadas);
        $template->SetParameter('hojas',$numHojas);
		$template->SetParameter('diasnotrabajados',$numFaltas);
		$template->SetParameter('diaspermisoLibre',$permiso["num_dias_permiso"]);
        $ingreso = $query->getRows("id_tipo_ingreso","ingreso ","where id_tipo_ingreso='5' and id_movil= ".$pertenece['id_movil']." ");
		$ingresoa = count($ingreso);
		
		$template->SetParameter('diasatrasotrab',$ingresoa);
		$totalPa = $query->getRow("SUM(monto_pago_ingreso) as total","ingreso ","where id_tipo_ingreso='5' and id_movil= ".$pertenece['id_movil']."  and fecha_ingreso >= '".$fechaInicio."' and fecha_ingreso <= '".$fechaFin."'");
		$template->SetParameter('totalatrasotrab',$totalpa['total']);
		
        $ingresob = $query->getRows("id_tipo_ingreso","ingreso ","where id_tipo_ingreso='2' and id_movil= ".$pertenece['id_movil']."  and fecha_ingreso >= '".$fechaInicio."' and fecha_ingreso <= '".$fechaFin."'");
		$ingresoc = count($ingresob);
	    $template->SetParameter('diaspermiso',$ingresoc);
		$totalPago = $query->getRow("SUM(monto_pago_ingreso) as total","ingreso ","where id_tipo_ingreso='2' and id_movil= ".$pertenece['id_movil']."  and fecha_ingreso >= '".$fechaInicio."' and fecha_ingreso <= '".$fechaFin."'");
        $template->SetParameter('totalpermiso',$totalPago['total']);
		
		//$template->SetParameter('totalpermiso',$ingresoto['total']);
		
		$ingresod = $query->getRows("id_tipo_ingreso","ingreso ","where id_tipo_ingreso='4' and id_socio= ".$pertenece['id_socio']." and fecha_ingreso >= '".$fechaInicio."' and fecha_ingreso <= '".$fechaFin."'");
		$ingresoe = count($ingresod);
	    $template->SetParameter('diasatraso',$ingresoe);
		$totalPag = $query->getRow("SUM(monto_pago_ingreso) as total","ingreso ","where id_tipo_ingreso='4' and id_socio= ".$pertenece['id_socio']." and fecha_ingreso >= '".$fechaInicio."' and fecha_ingreso <= '".$fechaFin."'");
		$template->SetParameter('totalatraso',$totalPag['total']);
		
		$ingresof = $query->getRows("id_tipo_ingreso","ingreso ","where id_tipo_ingreso='3' and id_socio= ".$pertenece['id_socio']." and fecha_ingreso >= '".$fechaInicio."' and fecha_ingreso <= '".$fechaFin."'");
		$ingresog = count($ingresof);
	    $template->SetParameter('diasfalta',$ingresog);
		$totali = $query->getRow("SUM(monto_pago_ingreso) as total","ingreso ","where id_tipo_ingreso='3' and id_socio= ".$pertenece['id_socio']." and fecha_ingreso >= '".$fechaInicio."' and fecha_ingreso <= '".$fechaFin."'");
		$template->SetParameter('totalfalta',$totali['total']);
		
		$ingresoh = $query->getRows("id_tipo_ingreso","ingreso ","where id_tipo_ingreso='9' and id_socio= ".$pertenece['id_socio']." and fecha_ingreso >= '".$fechaInicio."' and fecha_ingreso <= '".$fechaFin."'");
		$ingresoi = count($ingresoh);
	    $template->SetParameter('permisoas',$ingresoi);
		$totalas = $query->getRow("SUM(monto_pago_ingreso) as total","ingreso ","where id_tipo_ingreso='9' and id_socio= ".$pertenece['id_socio']." and fecha_ingreso >= '".$fechaInicio."' and fecha_ingreso <= '".$fechaFin."'");
		$template->SetParameter('totalasamblea',$totalas['total']);
		return $template->Display();
	}
}
?>