<?php
class verificar
{
	function verificarlicencia()
	{
		$query=new query;
		$row=$query->getRow("*","socio","WHERE  NUM_LINCENCIA= '{$_GET['name']}'");
		if (!$row){
			$nombre=$row['NOMBRE_SOCIO']." ".$row['APELLIDO1_SOCIO'];
			return "<input class=\"AcceptUsername\" readonly name='nombre' type='text' value=''/><br><input type=\"hidden\" name=\"extra\" value=\"true\"/>";
		}
		else{
			return "<input class=\"RejectUsername\" readonly name='nombre' type='text' value='{$row['NOMBRE_SOCIO']} {$row['APELLIDO1_SOCIO']}'><br><input type=\"hidden\" name=\"extra\" value=\"false\"/>";
		}
			
	}
	function verificarmovil()
	{
		$query=new query;
		$row=$query->getRow("*","socio as s,movil as m","WHERE m.ID_SOCIO=s.ID_SOCIO AND m.NUM_MOVIL='{$_GET['name']}'");
		if (!$row){
			$nombre=$row['NOMBRE_SOCIO']." ".$row['APELLIDO1_SOCIO'];
			return "<input class=\"AcceptUsername\" readonly name='nombre' type='text' value=''/><br><input type=\"hidden\" name=\"extra\" value=\"true\"/>";
		}
		else{
			return "<input class=\"RejectUsername\" readonly name='nombre' type='text' value='{$row['NOMBRE_SOCIO']} {$row['APELLIDO1_SOCIO']}'><br><input type=\"hidden\" name=\"extra\" value=\"false\"/>";
		}
			
	}
}
?>