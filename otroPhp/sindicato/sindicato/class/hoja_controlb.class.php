<?php
class hoja_control
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



    function cambiarfecha($fecha,$dias)
    {
        $datestart= strtotime($fecha);
        $diasemana = date('N',$datestart);
        $totaldias = $diasemana;
        $findesemana =  intval( $totaldias/6) *1 ;
        $diasabado = $totaldias % 6;
        //if ($diasabado==6) $findesemana++;
        if($diasemana==1) // lunes
        $findesemana=$findesemana;
        if($diasemana==2) // martes
        $findesemana=$findesemana;
        if($diasemana==3) // miercoles
        $findesemana=$findesemana;
        if($diasemana==4) // jueves
        $findesemana=$findesemana;
        if ($diasemana==5) // viernes
        $findesemana=$findesemana+1;
        if ($diasemana==6) // sabado
        $findesemana=$findesemana-1;
        if ($diasemana==7) // domingo
        $findesemana=$findesemana-1;
        $total = (($findesemana+$dias) * 86400)+$datestart ;
        return $twstart=date('Y-m-d', $total);
    }

    function cambiarmes($fecha)
    {
        $fechamodificada1= date('Y-m-d', strtotime('-2 month'));
        $valoresPrimera = explode("-", $fechamodificada1);

        //        $valoresPrimera = explode("-", $fecha);
        $anyo = $valoresPrimera[0];
        $mes2  = $valoresPrimera[1];
        $dia    = $valoresPrimera[2];
        //ver nuevo
        //$mes2 =$mes-2;
        $fechaIniciod="$anyo-$mes2-01";
        $first_of_month2 = mktime (0,0,0, $mes2, 1, $anyo);
        $maxdays2 = date('t', $first_of_month2);
        $dia3 = $maxdays2;
        $fechaFind="$anyo-$mes2-$dia3";

        $mesanterior="$anyo-$mes2-$dia3";
        return $twstart=date($mesanterior);
    }

    function registrarHoja(){
        $query = new query;
        $template = new template;
        $template->SetTemplate('html/form_hoja_controlb.html');
        $mayor = $query->getRow("MAX(numero_hoja) as mayor","hoja_control");
        if($mayor['mayor'] == null) {
            $num_hoja = 100001;
        }
        else {
            $num_hoja = $mayor['mayor']+1;
        }
        $template->SetParameter('numHoja',$num_hoja);
        $hoy = date('Y-m-d');
        $template->SetParameter('fecha_a_usar',$this->cambiarfecha($hoy,'1'));
        //////////////////////////////
        $template->SetParameter('radio'," <input name=\"tipoSocio\" id=\"tipoSocio\" type=\"radio\" checked value=\"1\" /><label>Falta</label>");
        // $template->SetParameter('radio',"<input name=\"tipoSocio\" id=\"tipoSocio\" type=\"radio\" checked value=\"0\" onchange=\"Hide('showFechaFin');\"/><label>Normal</label> <input name=\"tipoSocio\" id=\"tipoSocio\" type=\"radio\" value=\"1\" onchange=\"Show('showFechaFin');\"/><label>Falta</label>");

        //$template->SetParameter('caractFecha','id="showFechaFin" style="display:none;"');
        $template->SetParameter('fecha_falta',$this->cambiarmes($hoy));
        ////////////////////////////////
        $template->SetParameter('numeroMovil',"<input name=\"movil\" type=\"text\" id=\"movil\" onblur=\"if(document.mframe.movil.value > 0){ajax('datosMovil','hoja_controlb.php?accion=buscarMovil&movil=' + document.mframe.movil.value, '');}\" size=\"3\">");
        $template->SetParameter('nombreSocio','');
        /*$tipoConductor = '<input name="tipoConductor" type="radio" value="socio" checked onclick="Hide('."'showNumChofer'".'); Hide('."'showNombreChofer'".');"><label>Socio</label><input name="tipoConductor" type="radio" value="chofer" onclick="Show('."'showNumChofer'".'); Show('."'showNombreChofer'".');"><label>Chofer</label>';
        $template->SetParameter('tipoConductor',$tipoConductor);*/
        $template->SetParameter('numChofer',"<input name=\"numChofer\" type=\"text\" id=\"numChofer\" value=\"0\" onblur=\"if(document.mframe.numChofer.value > 0) {ajax('datosChofer','hoja_controlb.php?accion=buscarChofer&numChofer=' + document.mframe.numChofer.value, '');}\" size=\"3\">");
        $template->SetParameter('nombreChofer','');
        $template->SetParameter('observacion','');
        $template->SetParameter('accion','saveHoja');
        $template->SetParameter('boton','REGISTRAR');
        return $template->Display();
    }

    /*function foco(mframe,movil){
      eval('document.'+mframe+'.'+movil+'.focus()');
      }*/

   /* function buscarMovil(){
        $query = new query;
        //$linea = $query->getRow("linea","linea","where id_linea = ".$_GET['idlinea']);
        $nombreSocio = $query->getRow("m.id_movil, nombre_socio, apellido1_socio, apellido2_socio, placa_movilidad, estado_socio","socio s, movil m, pertenece p","where (m.num_movil like '132_".$_GET['movil']."' or m.num_movil like '131_".$_GET['movil']."') and m.id_movil = p.id_movil and p.id_socio = s.id_socio");
        if($nombreSocio['estado_socio'] == 'activo')
            $nombreCompleto = $nombreSocio['nombre_socio']." ".$nombreSocio['apellido1_socio']." ".$nombreSocio['apellido2_socio'];
        else
            $nombreCompleto = $nombreSocio['nombre_socio']." ".$nombreSocio['apellido1_socio']." ".$nombreSocio['apellido2_socio']." (Tiene deudas pendientes)";
        return "<span>".$nombreCompleto."</span><input type=\"hidden\" name=\"id_movil\" value=\"".$nombreSocio['id_movil']."\">";
    }
   */

    function buscarMovil(){
       
        $query = new query;
        //$linea = $query->getRow("linea","linea","where id_linea = ".$_GET['idlinea']);
        $nombreSocio = $query->getRow("m.id_movil, nombre_socio, apellido1_socio, apellido2_socio, placa_movilidad, estado_socio","socio s, movil m, pertenece p","where (m.num_movil like '132_".$_GET['movil']."' or m.num_movil like '131_".$_GET['movil']."') and m.id_movil = p.id_movil and p.id_socio = s.id_socio");
//        exit();
        $hoy = date('Y-m-d');

        $fechamodificada1= date('Y-m-d', strtotime('-1 month'));

        $valoresPrimera = explode("-", $fechamodificada1);
        $anyo = $valoresPrimera[0];
        $mes1  = $valoresPrimera[1];
        $dia    = $valoresPrimera[2];
        //$mes1 =$mes-1;
        $fechaInicio="$anyo-$mes1-01";
        $first_of_month = mktime (0,0,0, $mes1, 1, $anyo);
      //  echo $first_of_month."ssssssssssss";
        $maxdays = date('t', $first_of_month);
        $dia2 = $maxdays;
        $fechaFin="$anyo-$mes1-$dia2";
        $hojas = $query->getRows("*","hoja_control","where id_movil = '".$nombreSocio['id_movil']."'  and fecha_falta >= '".$fechaInicio."' and fecha_falta <= '".$fechaFin."'");
        $nroHojas = count($hojas);
        $nroHojas2=18-$nroHojas;
        switch($mes1)
        {
            case "01":
                $mes="Enero";
                break;
                case "02":
                    $mes="Febrero";
                    break;
                    case "03":
                        $mes="Marzo";
                        break;
                        case "04":
                            $mes="Abril";
                            break;
                            case "05":
                                $mes="Mayo";
                                break;
                                case "06":
                                    $mes="Junio";
                                    break;
                                    case "07":
                                        $mes="Julio";
                                        break;
                                        case "08":
                                            $mes="Agosto";
                                            break;
                                            case "09":
                                                $mes="Septiembre";
                                                break;
                                                case "10":
                                                    $mes="Octubre";
                                                    break;
                                                    case "11":
                                                        $mes="Noviembre";
                                                        break;
                                                        case "12":
                                                            $mes="Diciembre";
                                                            break;
                                                        }

                                                        // if($nombreSocio['estado_socio'] == 'activo')
                                                        //      $nombreCompleto = $nombreSocio['nombre_socio']." ".$nombreSocio['apellido1_socio']." ".$nombreSocio['apellido2_socio'];
                                                        //  else
                                                        //     $nombreCompleto = $nombreSocio['nombre_socio']." ".$nombreSocio['apellido1_socio']." ".$nombreSocio['apellido2_socio']." (Tiene deudas pendientes)";
                                                        //	return "<span>".$nombreCompleto."</span><input type=\"hidden\" name=\"id_movil\" value=\"".$nombreSocio['id_movil']."\">";
                                                        $alerta = "";
                                                        $nombreCompleto = $nombreSocio['nombre_socio']." ".$nombreSocio['apellido1_socio']." ".$nombreSocio['apellido2_socio'];
                                                        if($nroHojas < 18)
                                                        {
                                                            $alerta = 'Debe '.$nroHojas2.' hojas de '.$mes.' , tiene que ponerse al dia.';
                                                        }
                                                        return "<span style=\"position:absolute; background-color:red;\">".$alerta."</span><br /><span>".$nombreCompleto."</span><input type=\"hidden\" name=\"id_movil\" value=\"".$nombreSocio['id_movil']."\">";


                                                    }




                                                    function buscarChofer(){
                                                        $query = new query;
                                                        $nombreChofer = $query->getRow("nombre_chofer, id_chofer","chofer","where num_chofer = ".$_GET['numChofer']);
                                                        return "<span>".$nombreChofer['nombre_chofer']."</span><input type=\"hidden\" name=\"id_chofer\" value=\"".$nombreChofer['id_chofer']."\">";
                                                    }

                                                    function recibirHoja(){
                                                        $query = new query;
                                                        $hojas = $_POST['numHoja'];
                                                        if(count($hojas)>0) {
                                                            foreach($hojas as $key)
                                                            {
                                                                $recibir['hoja_usada'] = 'Recibido';
                                                                $recibir['fecha_de_uso'] = date('Y-m-d');
                                                                $recibe = $query->dbUpdate($recibir,"hoja_control","where numero_hoja = ".$key);
                                                            }
                                                            echo "<script>alert('Se guardaron los cambios exitosamente.');</script>";
                                                        } else echo "<script>alert('Ocurrio un error, porfavor intente de nuevo');</script>";
                                                        echo "<script>window.location.href=\"hoja_controlb.php\"</script>";
                                                    }

   function saveHoja() //save the new Item
                                                    {
                                                        $query = new query;
                                                        $insert['id_movil'] = $_POST[id_movil];
                                                        $insert['numero_hoja'] = $_POST[numero_hoja];
                                                        $insert['id_chofer'] = $_POST[id_chofer];
                                                        $hora = getdate(time());
                                                        $horaActual = $hora["hours"] . ":" . $hora["minutes"] . ":" . $hora["seconds"];
                                                        $insert['hora_compra'] = $horaActual;
                                                        $insert['hoja_usada'] = "Recibido";

                                                        $insert['fecha_de_compra'] = date("Y-m-d");
                                                        $insert['falta'] = $_POST[tipoSocio];

                                                        $insert['fecha_falta'] = $_POST[fecha_falta];

                                                        $idLinea = $query->getRow('l.id_linea','linea l, movil m','where m.id_movil = '.$insert['id_movil'].' and m.id_linea = l.id_linea');
                                                        $totalPago = $query->getRow("SUM(monto_transaccion) as total","tener t, tipo_transaccion tt","where t.id_linea = ".$idLinea['id_linea']." and t.id_tipo_transaccion = tt.id_tipo_transaccion and t.estado = 'Activo'");
                                                        $insert['total_hoja'] = $totalPago['total'];
														
														 $idLinea = $query->getRow('l.id_linea','linea l, movil m','where m.id_movil = '.$insert['id_movil'].' and m.id_linea = l.id_linea');
        $totalPago = $query->getRow("SUM(monto_transaccion) as total","tener t, tipo_transaccion tt","where t.id_linea = ".$idLinea['id_linea']." and t.id_tipo_transaccion = tt.id_tipo_transaccion and t.estado = 'Activo'");
        
		$insert['total_hoja'] = $totalPago['total'];
		//mod hoja
		$fechafalta= $_POST[fecha_falta];
		$formatear1 = explode( '-' , $fechafalta);
$fechaact = $formatear1[2].'-'.$formatear1[1].'-' .$formatear1[0];
$date = strtotime($fechafalta);
$anio = date("Y", $date); // Year (2003)
$mes= date("m", $date); // Month (12)
//echo date("d", $date); // day (14)
			   //al estilo anterior
//$totalPago11 = $query->getRow("monto_transaccion"," tipo_transaccion tt","where tt.idaporte='2' and tt.id_tipo_transaccion='5'");
 //   $totalPago21 = $query->getRow("monto_transaccion","tipo_transaccion tt","where tt.idaporte='2' and tt.id_tipo_transaccion='6'");
  //  $totalPago31 = $query->getRow("monto_transaccion","tipo_transaccion tt","where tt.idaporte='2' and tt.id_tipo_transaccion='7'");
        	
			 $totalPago11 = $query->getRow("monto_transaccion"," tipo_transaccion tt","where tt.idaporte='3' and tt.id_tipo_transaccion='8'");
    $totalPago21 = $query->getRow("monto_transaccion","tipo_transaccion tt","where tt.idaporte='3' and tt.id_tipo_transaccion='10'");
    $totalPago31 = $query->getRow("monto_transaccion","tipo_transaccion tt","where tt.idaporte='3' and tt.id_tipo_transaccion='9'");
       $totalPago41 = $query->getRow("monto_transaccion","tipo_transaccion tt","where tt.idaporte='3' and tt.id_tipo_transaccion='11'");  	

	$insert['aporte'] = $totalPago11['monto_transaccion'];
		$insert['asocio'] = $totalPago21['monto_transaccion'];
		//$insert['achofer'] = $totalPago3['monto_transaccion'];
		$insert['adeporte'] = $totalPago31['monto_transaccion'];
		$insert['acumple'] = $totalPago41['monto_transaccion'];
		
                                                        $insert['fecha_a_usar'] = date("Y-m-d");
                                                        $insert['observaciones'] = $_POST[observacion];
                                                        $insert['idalquiler'] = $_POST[numChofer];
                                                        if ($insert['idalquiler']!="0"){
                                                            $idalquiler = $query->getRow('tipo_chofer','chofer','where id_chofer = '.$insert['id_chofer'].' ');
                                                            if($idalquiler['tipo_chofer'] == "alquiler")
                                                            {$insert['alquiler'] = "1";
                                                            }
                                                            else
                                                            $insert['alquiler'] = "0";
                                                        }
                                                        $reg = false;
                                                        $resti = $query->getRows("*","hoja_control","WHERE id_movil = '".$insert['id_movil']."' and fecha_a_usar = ".$insert['fecha_a_usar']);
                                                        $fechacontrol=$insert['fecha_falta'];

                                                        $valoresPrimera = explode("-", $fechacontrol);
                                                        $anyo   = $valoresPrimera[0];
                                                        $mes  = $valoresPrimera[1];
                                                        $dia    = $valoresPrimera[2];
                                                        $fechaInicio="$anyo-$mes-01";
                                                        $fechaFin=$fechacontrol;
                                                        $hojas = $query->getRows("*","hoja_control","where id_movil = ".$insert['id_movil']."  and fecha_falta >= '".$fechaInicio."' and fecha_falta <= '".$fechaFin."'");
                                                        $contarhojas = count($hojas);
                                                        //$contarhojas = $contarhojas+1;

                                                        if(count($resti) == 0) {
                                                            for($i=1;$i<=$_POST[cantidadHojas];$i++) {
                                                                //echo "<script>alert('numero de hojas: ".$_POST[cantidadHojas]."');</script>";
                                                                $query->dbInsert($insert,"hoja_control"); //save in the data base
                                                                $contarhojas +=1;
                                                                echo "<script>window.open('print_hoja_control.php?numHoja=".$insert['numero_hoja']."&cantidadHoja=$contarhojas');</script>";
                                                                $aux = $i;
                                                                $insert['numero_hoja'] += 1;
                                                                $insert['fecha_a_usar'] = $this->cambiarfecha($insert['fecha_a_usar'],'1');
                                                                $reg = true;
                                                            }
                                                            if($reg)
                                                            echo "<script>alert('Se registraron ".$_POST['cantidadHojas']." hoja(s) de control');</script>";
                                                            else
                                                            echo "<script>alert('Error en el registro de las hojas de control');</script>";
                                                        } echo "<script>window.location.href='hoja_controlb.php'</script>";
                                                    }

                                                    function filtroFecha() //list for default the all items
                                                    {
                                                        $fechaFiltro = $_GET['filtro'];
                                                        $query = new query;
                                                        $resulthoja = $query->getRows("*","hoja_control","where fecha_de_compra = '".$fechaFiltro."' ORDER BY numero_hoja");
                                                        // $init = (($_GET['page'] == "" ? 1 : $_GET['page']) - 1) * 20;
                                                        $resulthoja1 = $query->getRows("*","hoja_control","where fecha_de_compra = '".$fechaFiltro."' ORDER BY numero_hoja ");
                                                        $numhoja = count($resulthoja1);
                                                        $list = '<form name="formRecibir" method="POST" action="hoja_controlb.php?accion=recibir">';
                                                        if($numhoja > 0) {
                                                            $list .='<table border = "1">
              <thead><tr>
                <th>Numero</th>
                <th>Linea</th>
                <th>Movil</th>
                <th>Nombre Chofer</th>
                <th>Hora Compra</th>
                <th>Monto</th>
                <th>Fecha a usar</th>
                <th>Recibir</th>
              </tr></thead>';
                                                            $x = 0;
                                                            foreach ($resulthoja1 as $key=>$value) {
                                                                $x++;
                                                                if(($x%2)==0)
                                                                $par = "class='TdAlt'";
                                                                else $par = "";
                                                                $linea = $query->getRow("linea, num_movil","linea l, movil m","where m.id_movil = ".$value['id_movil']." and m.id_linea = l.id_linea");
                                                                $nombreChofer = "";
                                                                if($value['id_chofer'] == 0) {
                                                                    $nombreSocio = $query->getRow("nombre_socio, apellido1_socio, apellido2_socio","socio s, pertenece p","where p.id_movil = ".$value['id_movil']." and p.id_socio = s.id_socio");
                                                                    $nombreChofer = $nombreSocio['nombre_socio']." ".$nombreSocio['apellido1_socio']." ".$nombreSocio['apellido2_socio'];
                                                                } else {
                                                                    $nombre = $query->getRow("nombre_chofer","chofer","where id_chofer = ".$value['id_chofer']);
                                                                    $nombreChofer = $nombre['nombre_chofer'];
                                                                }
                                                                $numMovil = split('_',$linea["num_movil"]);
                                                                if($value['fecha_de_uso'] != null)
                                                                $recibir = $value['hoja_usada'].": ".$value['fecha_de_uso'];
                                                                else $recibir = '<input type="checkbox" name="numHoja[]" value="'.$value['numero_hoja'].'">';
                                                                $list .= '<tbody><tr '.$par.'>
                  <td>'.$value["numero_hoja"].'</td>
                  <td>'.$linea["linea"].'</td>
                  <td>'.$numMovil[1].'</td>
                  <td>'.$nombreChofer.'</td>
                  <td>'.$value["hora_compra"].'</td>
                  <td>'.$value["total_hoja"].'</td>
                  <td>'.$value["fecha_a_usar"].'</td>
                  <td>'.$recibir.'</td>
                  </tr></tbody>';
                                                            }
                                                            $list.='</table><input type="submit" name="recibir" value="Recibir"><input type="button" value="Cancelar" onclick="window.location.href=\'hoja_controlb.php\'"></form>';
                                                        } else $list = '<div>No existen hojas de control para la fecha '.$fechaFiltro.'</div>';
                                                        return $list;
                                                    }


    /* function  deleteHoja(){
        $query = new query;
       if($query->dbDelete("hoja_control","WHERE numero_hoja = ".$insert['numero']."");
        {
        $insert['fecha'] = date("Y-m-d");
        $ide=$_SESSION['id'];
        $row=$query->getRow("*","usuario","where id_usuario=$ide");
        $nombre=" ".$row['nombre_usuario']." ".$row['apellido1_usuario'];
        $insert['usuario_actual'] = $nombre;
        $insert['tabla'] = "hoja_control";
        $hora = getdate(time());
        $hojac=$query->getRow("*","hoja_control","WHERE numero_hoja = ".$_GET['id']);
        $num_movil = $query->getRow("num_movil","movil","where id_movil = ".$hojac['id_movil']." ");
        $horaActual = $hora["hours"] . ":" . $hora["minutes"] . ":" . $num_movil["num_movil"] . ":" . $hojac["id_chofer"] . ":" . $hojac["fecha_de_compra"] . ":" . $hojac["idalquiler"];
         $insert['numero'] = $hojac['numero_hoja'];
       $insert['antiguo_registro'] = $horaActual;
      if($query->dbInsert($insert,"bitacora_delete"))
        echo "<script>alert('Tipo de ingreso elminado exitosamente')</script>";
         echo "<script>window.location.href='hoja_control.php'</script>";

      }
    }*/

                                                    function listarHoja() //list for default the all items
                                                    {
                                                        $template = new template;
                                                        $template->SetTemplate('html/lista_hojas_dia.html'); //sets the template for this function
                                                        $template->SetParameter('hoy',date('d-M-Y'));
                                                        $template->SetParameter('filtroFecha','');
                                                        $hoy = date('Y-m-d');

                                                        //DataBase Conexion//
                                                        $query = new query;
                                                        $confirm="javascript:return confirm('Esta seguro de eliminar la hoja de control?');";
                                                        $resulthoja = $query->getRows("*","hoja_control","where fecha_de_compra = '".$hoy."' ORDER BY numero_hoja");
                                                        // $init = (($_GET['page'] == "" ? 1 : $_GET['page']) - 1) * 20;
                                                        $resulthoja1 = $query->getRows("*","hoja_control","where fecha_de_compra = '".$hoy."' ORDER BY numero_hoja");
                                                        $numhoja = count($resulthoja1);
                                                        if($numhoja > 0) {
                                                            $list ='<table border = "1">
              <thead><tr>
                <th>Numero</th>
                <th>Linea</th>
                <th>Movil</th>
                <th>Nombre Chofer</th>
                <th>Hora Compra</th>
                <th>Monto</th>
                <th>Fecha Control</th>
                <th></th>
              </tr></thead>';
                                                            $x = 0;
                                                            foreach ($resulthoja1 as $key=>$value) {
                                                                $x++;
                                                                if(($x%2)==0)
                                                                $par = "class='TdAlt'";
                                                                else $par = "";
                                                                $linea = $query->getRow("linea, num_movil","linea l, movil m","where m.id_movil = ".$value['id_movil']." and m.id_linea = l.id_linea");
                                                                $nombreChofer = "";
                                                                if($value['id_chofer'] == 0) {
                                                                    $nombreSocio = $query->getRow("nombre_socio, apellido1_socio, apellido2_socio","socio s, pertenece p","where p.id_movil = ".$value['id_movil']." and p.id_socio = s.id_socio");
                                                                    $nombreChofer = $nombreSocio['nombre_socio']." ".$nombreSocio['apellido1_socio']." ".$nombreSocio['apellido2_socio'];
                                                                } else {
                                                                    $nombre = $query->getRow("nombre_chofer","chofer","where id_chofer = ".$value['id_chofer']);
                                                                    $nombreChofer = $nombre['nombre_chofer'];
                                                                }
                                                                $numMovil = split('_',$linea["num_movil"]);
                                                                $list .= '<tbody><tr '.$par.'>
                  <td>'.$value["numero_hoja"].'</td>
                  <td>'.$linea["linea"].'</td>
                  <td>'.$numMovil[1].'</td>
                  <td>'.$nombreChofer.'</td>
                  <td>'.$value["hora_compra"].'</td>
                  <td>'.$value["total_hoja"].'</td>
                  <td>'.$value["fecha_falta"].'</td>
                  <!--<td><a href="print_hoja_control.php?numHoja='.$value["numero_hoja"].'" target="_blank" onClick="window.open(this.href, this.target); return false;" title="Imprimir hoja">[Imprimir]</a></td>-->
                  <!--<td><a href="hoja_control.php?accion=delete&id='.$value["numero_hoja"].'" onClick="'.$confirm.'" title="Eliminar hoja control"><img src="images/delete.gif"></a></td>-->
                  </tr></tbody>';
                                                            }
                                                            $list.='</table>';
                                                            // $list .= paging::navigation(count($resulthoja),"hoja_controlb.php",20);
                                                        } else $list = '<div>No existen hojas de control registrados</div>';
                                                        $buttonAdd = '<input type="button" value="Nuevo" onclick="window.location.href=\'hoja_controlb.php?accion=registro\'">';
                                                        $template->SetParameter('add',$buttonAdd);
                                                        $totalDia = $query->getRow("SUM(total_hoja) as totalDia","hoja_control","where fecha_de_compra = '".$hoy."'");
                                                        $template->SetParameter('totalDia',"<br />Total ingreso de hoy: ".$totalDia['totalDia']);
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
                                                        if($_SESSION['tipo']==4){
                                                            $template->SetTemplate('html/home3.html');
                                                            $template->SetParameter('registro',$this->mostrarregistro1());
                                                        }
                                                        if($_GET['accion']==""){
                                                            $template->SetParameter('contenido',$this->listarHoja());
                                                        }
                                                        if($_GET['accion']=="registro"){
                                                            $template->SetParameter('contenido',$this->registrarHoja());
                                                        }
                                                        if($_GET['accion']=="modificar"){
                                                            $template->SetParameter('contenido',$this->modificarHoja());
                                                        }
                                                        $template->SetParameter('pie',navigation::showpie());
                                                        return $template->Display();
                                                    }
                                                }
                                                ?>
