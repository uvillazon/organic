<?php
class dias_trabajados
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
  
    
    function saveSocio() //save the new Item
    {
        $query = new query;
        $insert['nombre_socio'] = $_POST[nombre_socio];
        $insert['apellido1_socio'] = $_POST[ape1];
        $insert['apellido2_socio'] = $_POST[ape2];
        $insert['num_licencia'] = $_POST[numero_licencia];
        $insert['direccion_socio'] = $_POST[direccion];
        $insert['telefono_socio'] = $_POST[telefono];
        $insert['fecha_registro_socio'] = date("Y-m-d");
        $insert['estado_socio'] = 'activo';
        $insert['tipo_socio'] = $_POST[tipoSocio];
        $insert['fecha_inicio'] = date("Y-m-d");
        if($insert['tipo_socio'] == "Alquiler")
            $insert['fecha_fin'] = $_POST[fecha_fin];
        if($query->dbInsert($insert,"socio")){ //save in the data base
            echo "<script>alert('Socio registrado exitosamente');</script>";
            echo "<script>window.location.href='socio.php'</script>";
        }
        else{ //error
            echo "<script>alert('Error en el registro');</script>";
            echo "<script>window.location.href='socio.php'</script>";
        }
    }
    
    function DiasTrabajados() //list for default the all items
	{
        $fechaInicio = $_GET[fechaInicio];
        $fechaFin = $_GET[fechaFin];
		//DataBase Conexion//
		$query = new query;
        $resultsocio= $query->getRows("*","pertenece p","order by p.id_movil");
        $hoy = date("Y-m-d");
        $numsocio = count($resultsocio);
        //$list = '<div>N? Dias H?biles de Trabajo: </div><br />';
        if($numsocio > 0) {
            $list .='<table border = "1">
              <thead><tr>
			   <th>Movil</th>
			  <th>Linea</th>
                 <th>Nombre Socio</th>
                <th>Num minimo de dias</th>
                <th>Nro de Hojas Compradas</th>
                <th>Faltas</th>
             
              </tr></thead>';
            $x = 0;
            foreach ($resultsocio as $key=>$value) {
                $x++;
                if(($x%2)==0)
                    $par = "class='TdAlt'";
                else $par = "";
                $hojas = $query->getRows("*","hoja_control","where id_movil = ".$value['id_movil']." and fecha_falta >= '".$fechaInicio."' and fecha_falta <= '".$fechaFin."'");
                //$hojasUsadas = $query->getRows("*","hoja_control","where id_movil = ".$value['id_movil']." and hoja_usada = 'Recibido' and fecha_a_usar >= '".$fechaInicio."' and fecha_a_usar <= '".$fechaFin."'");
                $movil = $query->getRow("num_movil","movil","where id_movil = ".$value['id_movil']);
                $socio = $query->getRow("nombre_socio, apellido1_socio, apellido2_socio, num_licencia","socio","where id_socio = ".$value['id_socio']);
                $separa = split('_',$movil['num_movil']);
                $numHojas = count($hojas);
				 $dia = '18';
				 $diad = '19';
				 $deuda = '0';
				 if($numHojas<$diad) 
                   { 
                     $deuda = $dia - $numHojas; 
                     }
				else {
				     $deuda = $deuda;
					 }	  
                //$numHojasUsadas = count($hojasUsadas);
                //$numTrabajados = $numHojas - $numHojasUsadas;
                $list .= '<tbody><tr '.$par.'>
                <td>'.$separa[1].'</td>
                 <td>'.$separa[0].'</td>
                  <td>'.$socio["nombre_socio"].' '.$socio["apellido1_socio"].' '.$socio["apellido2_socio"].'</td>
                   <td>'.$dia.'</td>
				  <td>'.$numHojas.'</td>
                  <td>'.$deuda.'</td>
                
                  </tr></tbody>';
            }
            $list.='</table>';
        } else $list = '<div>No existen socios registrados</div>';
		return $list;
	}
    
    function FiltrarFechas() //list for default the all items
	{
		$template = new template;
		$template->SetTemplate('html/lista_control_trabajoabril.html'); //sets the template for this function
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
   // "La fecha ".$primera." no es v?lida";
    return 0;
   }elseif(!checkdate($mesSegunda, $diaSegunda, $anyoSegunda)){
    // "La fecha ".$segunda." no es v?lida";
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
		return $template->Display();
	}
}
?>