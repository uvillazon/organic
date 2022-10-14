<?php
class no_trabajaron
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
    
   
	 function FiltrarFechas() //list for default the all items
	{
		$template = new template;
		
		$template->SetTemplate('html/lista_no_trabajaron.html'); //sets the template for this function
		$template->SetParameter('filtroFecha',date('Y-m-d'));
		$template->SetParameter('contenido','');
		    	return $template->Display();
	}
	  function filtroFecha() //list for default the all items
	{
        $fechaFiltro = $_GET['filtro'];
		$query = new query;
		 $resulthoja = $query->getRows("*","movil order by id_movil");
        //$resulthoja = $query->getRows("*","hoja_control","where fecha_de_compra = '".$fechaFiltro."' ORDER BY numero_hoja");
        //$init = (($_GET['page'] == "" ? 1 : $_GET['page']) - 1) * 20;
        //$resulthoja1 = $query->getRows("*","hoja_control","where fecha_de_compra = '".$fechaFiltro."' ORDER BY numero_hoja LIMIT $init , 20");
        $numhoja = count($resulthoja);
       $list = '<form name="formRecibir" method="POST" action="no_trabajaron.php?accion=recibir&fechaFiltro='.$fechaFiltro.'">'; 
		 // $list = '<form name="formRecibir" method="POST" action="no_trabajaron.php?accion=recibir&id='.$fechaFiltro.'">';
      
        if($numhoja > 0) {
            $list .='<table border = "1">
              <thead><tr>
			   <th>Movil</th>
               
                <th>Linea</th>
               
                <th>Nombre Socio</th>
                  <th>Fecha falta</th>
                <th>Recibir</th>
              </tr></thead>';
            $x = 0;
            foreach ($resulthoja as $key=>$value) {
                $x++;
                if(($x%2)==0)
                    $par = "class='TdAlt'";
                else $par = "";
                $pertenece = $query->getRow("id_socio, placa_movilidad","pertenece","where id_movil = ".$value['id_movil']);
                $socio = $query->getRow("*","socio","where id_socio = ".$pertenece['id_socio']);
                $nombreCompleto = $socio['nombre_socio']." ".$socio['apellido1_socio']." ".$socio['apellido2_socio'];
                $linea = $query -> getRow("linea","linea","where id_linea = ".$value['id_linea']);
                $soloNum = split("_",$value['num_movil']);
                
              $linea3 = $query->getRows("*","dia_no_trabajado","where id_movil = ".$value['id_movil']." and fecha_no_trabajo = '".$fechaFiltro."' ");
			  if(count($linea3)>0)
                  $recibir = "falta";
				else
                    $recibir = '<input type="checkbox" name="numHoja[]" value="'.$value['id_movil'].'">';
				
					 /*$recibir = '<input type="checkbox" name="numHoja[]" value="'.$linea3['id_movil'].'" onclick="ajax('list','no_trabajaron.php?accion=recibir&amp;filtroFecha=' + document.formRecibir.filtroFecha.value ,'');">';
*/
							
				$list .= '<tbody><tr '.$par.'>
                  <td>'.$soloNum[1].'</td>
                  <td>'.$linea["linea"].'</td>
                   <td>'.$nombreCompleto.'</td>
                    <td>'.$linea3["fecha_no_trabajo"].'</td>
                  <td>'.$recibir.'</td>
                  </tr></tbody>';
            }
            $list.='</table><input type="submit" name="recibir" value="Recibir"><input type="button" value="Cancelar" onclick="window.location.href=\'no_trabajaron.php\'"></form>';
        } else $list = '<div>No existen faltas para la fecha '.$fechaFiltro.'</div>';
		return $list;
	}
	
	  function recibirHoja($fechaControl){
        $query = new query;
		//$fechaFiltro = $_GET['filtro'];
		 $hoy = date("Y-m-d");
		//$fechaFiltro = '2009-03-03';// funciona hacer la prubea 
		$fechaFiltro = $fechaControl;// funciona hacer la prubea 
		  
        $hojas = $_POST['numHoja'];
        if(count($hojas)>0) {
            foreach($hojas as $key)
			
            {    $recibir['id_movil'] = $key;
			//$linea3 = $query->getRow("*","pertenece","where id_movil = ".$ingresoAtraso['id_movil']." ");
				
                $recibir['observacion_falta'] = 'Falta';
				//$fechaFiltro = $_GET['filtro'];
               $recibir['fecha_no_trabajo'] =$fechaFiltro;
				 //$guardar = $query->dbInsert($ingresoAtraso,"dia_no_trabajado");
                $recibe = $query->dbInsert($recibir,"dia_no_trabajado");
            }
            echo "<script>alert('Se guardaron los cambios exitosamente.');</script>";
        } else echo "<script>alert('Ocurrio un error, porfavor intente de nuevo');</script>";
        echo "<script>window.location.href=\"no_trabajaron.php\"</script>";
	}
    
    
    function listarHoja() //list for default the all items
	{
		$template = new template;
		$template->SetTemplate('html/lista_no_trabajaron.html'); //sets the template for this function
		$template->SetParameter('hoy',date('d-M-Y'));
		$template->SetParameter('filtroFecha','');
        $hoy = date('Y-m-d');
		
		//DataBase Conexion//
		$query = new query;
           $resulthoja = $query->getRows("*","dia_no_trabajado","where fecha_no_trabajo = '".$hoy."' ORDER BY num_registro");
       // $init = (($_GET['page'] == "" ? 1 : $_GET['page']) - 1) * 20;
        $resulthoja1 = $query->getRows("*","dia_no_trabajado","where fecha_no_trabajo = '".$hoy."' ORDER BY num_registro");
        $numhoja = count($resulthoja1);
        if($numhoja > 0) {
            $list ='<table border = "1">
              <thead><tr>
			  <th>Numero de movil</th>
                <th>Linea</th>
			    <th>Socio</th>
                <th>Numero de placa</th>
                <th>Fecha falta</th>
                <th></th>
              </tr></thead>';
            $x = 0;
            foreach ($resulthoja1 as $key=>$value) {
                $x++;
                if(($x%2)==0)
                    $par = "class='TdAlt'";
                else $par = "";
				 $pertenece = $query->getRow("*","pertenece","where id_movil = ".$value['id_movil']);
               $socio = $query->getRow("*","socio","where id_socio = ".$pertenece['id_socio']);
                $nombreCompleto = $socio['nombre_socio']." ".$socio['apellido1_socio']." ".$socio['apellido2_socio'];
                //$linea = $query -> getRow("*","linea","where id_movil = ".$pertenece['id_movil']);
				 $numero = $query->getRows("*","movil","where id_movil = ".$pertenece['id_movil']);
                 $soloNum = split("_",$numero['num_movil']);
              $list .= '<tbody><tr '.$par.'>
                  <td>'.$soloNum[1].'</td>
				  <td>'.$linea["linea"].'</td>
                 
                  <td>'.$nombreCompleto.'</td>
                  <td>'.$pertenece["placa_movilidad"].'</td>
                  
				  <td>'.$value["fecha_no_trabajo"].'</td>
                  <td>'.$value["observacion_falta"].'</td>
                  </tr></tbody>';
            }
            $list.='</table>';
           // $list .= paging::navigation(count($resulthoja),"hoja_control.php",20);
        }
		
		 else $list = '<div>No existen faltas registrados</div>';
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
		   $template->SetParameter('pie',navigation::showpie());
        
		if($_GET['accion']==""){
            $template->SetParameter('contenido',$this->listarHoja());
        }
		/*if($_GET['accion']==""){
            $template->SetParameter('contenido',$this->listarSocios());
         }*/
		return $template->Display();
	}
}
?>
