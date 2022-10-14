<?php
class admin{
	function showregistermulta(){
		$template=new template;
		$template->SetTemplate('html/reg_permiso_socio.html');
		return $template->Display();
	}

	function registermulta()
	{
		$query = new query;
		$rows = $query->getRow("*","socio","WHERE NUM_LINCENCIA = '{$_POST['licencia']}'");
		if (!$rows)
		{
			
			echo "<script>
			alert('Por favor ingrese un carnet o Numero de licencia que sea valido. Verifique por favor.');
			window.location.href = '?opc=registermulta'</script>";
		}
		else
		
				$insert['ID_SOCIO']=$rows['ID_SOCIO'];
				$insert['MULTA']="PERMISO A REUNION";
				$insert['CONCEPTO']=$_POST['concepto'];
				$insert['MONTO_MULTA']=$_POST['permiso'];
				//$insert['MULTA_FECHA']="NOW()";
				$insert['FECHA_DE_PAGO']="NOW()";
				$query -> dbInsert($insert,"multa");
			echo '<script language="javascript">alert(\'Inserted Successfully\'); window.location = \'index.php\';</script>';
			
			
	}
	function permisomovil(){
		$template= new template;
		$template->SetTemplate("html/reg_permiso_movil.html");
		return $template->Display();
	}
}
?>