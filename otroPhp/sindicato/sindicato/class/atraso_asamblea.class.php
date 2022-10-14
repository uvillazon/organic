<?php
class atraso_asamblea
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
    
    function saveAtraso(){
        $query = new query;
        $atrasados = $_POST['idSocio'];
        if(count($atrasados)>0) {
            $idTipoIngreso = $query->getRow('id_tipo_ingreso, monto_tipo_ingreso','tipo_ingreso','where tipo_ingreso = "Atraso asamblea"');
            foreach($atrasados as $key)
            {
                $ingresoAtraso['id_socio'] = $key;
				$id_movil = $query->getRow("*","pertenece","where id_socio = ".$ingresoAtraso['id_socio']." ");
				$ingresoAtraso['id_movil'] = $id_movil['id_movil'];
                
                $ingresoAtraso['id_tipo_ingreso'] = $idTipoIngreso['id_tipo_ingreso'];
                $mayor = $query->getRow("MAX(numero_registro) as mayor","ingreso");
                if($mayor['mayor'] == null) {
                    $ingresoAtraso['numero_registro'] = 100001;
                }
                else {
                    $ingresoAtraso['numero_registro'] = $mayor['mayor']+1;
                }
                $ingresoAtraso['concepto_ingreso'] = "Atraso a la asamblea ordinaria";
                $ingresoAtraso['fecha_ingreso'] = date('Y-m-d');
                $ingresoAtraso['monto_pago_ingreso'] = $idTipoIngreso['monto_tipo_ingreso'];
                $guardar = $query->dbInsert($ingresoAtraso,"ingreso");
            }
            echo "<script>alert('Se registraron los atrasos exitosamente.');</script>";
        } else echo "<script>alert('Ocurrio un error, porfavor intente de nuevo');</script>";
        echo "<script>window.location.href=\"atraso_asamblea.php\"</script>";
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
    
    function listarSocios() //list for default the all items
	{
		$template = new template;
		$template->SetTemplate('html/lista_atrasos_asamblea.html'); //sets the template for this function
		
		//DataBase Conexion//
		$query = new query;
        $resultsocio= $query->getRows("*","socio","order by num_licencia");
        $hoy = date("Y-m-d");
        $numsocio = count($resultsocio);
        $list = '<form name="formAtraso" method="POST" action="atraso_asamblea.php?accion=saveAtraso">';
        if($numsocio > 0) {
            $list .='<table border = "1">
              <thead><tr>
                <th>Licencia</th>
                <th>Nombre Socio</th>
                <th>Linea</th>
                <th>Movil</th>
                <th>Tipo socio</th>
                <th>Atraso</th>
              </tr></thead>';
            $x = 0;
            foreach ($resultsocio as $key=>$value) {
                $x++;
                if(($x%2)==0)
                    $par = "class='TdAlt'";
                else $par = "";
                $movil = $query->getRow("num_movil","movil m, pertenece p","where p.id_socio = ".$value['id_socio']." and p.id_movil = m.id_movil");
                $separa = split('_',$movil['num_movil']);
                $idTipoIngreso = $query->getRow('id_tipo_ingreso','tipo_ingreso','where tipo_ingreso = "Atraso asamblea"');
                $ingresoSocio = $query->getRows('fecha_ingreso','ingreso','where id_socio = '.$value['id_socio'].' and fecha_ingreso = "'.$hoy.'" and id_tipo_ingreso = '.$idTipoIngreso['id_tipo_ingreso']);
                if(count($ingresoSocio)>0)
                    $pagoEcho = "Pagado";
                else
                    $pagoEcho = '<input type="checkbox" name="idSocio[]" value="'.$value['id_socio'].'">';
                $list .= '<tbody><tr '.$par.'>
                  <td>'.$value["num_licencia"].'</td>
                  <td>'.$value["nombre_socio"].' '.$value["apellido1_socio"].' '.$value["apellido2_socio"].'</td>
                  <td>'.$separa[0].'</td>
                  <td>'.$separa[1].'</td>
                  <td>'.$value['tipo_socio'].'</td>
                  <td>'.$pagoEcho.'</td>
                  </tr></tbody>';
            }
            $list.='</table><input type="submit" name="guardar" value="Guardar"><input type="button" value="Cancelar" onclick="window.location.href=\'index.php\'"></form>';
        } else $list = '<div>No existen socios registrados</div>';
        $monto = $query->getRow('SUM(monto_pago_ingreso) as monto','ingreso','where fecha_ingreso = "'.$hoy.'" and id_tipo_ingreso = '.$idTipoIngreso['id_tipo_ingreso']);
        $template->SetParameter('monto',$monto['monto']);
        $template->SetParameter('hoy',date('d-M-Y'));
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
            $template->SetParameter('contenido',$this->listarSocios());
            $template->SetParameter('pie',navigation::showpie());
        }
		return $template->Display();
	}
}
?>
