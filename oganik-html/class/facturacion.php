<?php
class facturacion
{
	var $parameter = array();
	function SetParameter($name, $value)
	{
		$this->parameter[$name] = $value;
	}
	function mostrarCabeceraMenu()
	{
		$template = new template;
		$template->SetTemplate('html/cabecera_menu.html');
		$template->SetParameter('menu', "Factura Electronica");
		return $template->Display();
	}
	function mostrarCabeceraPrincipal()
	{
		$template = new template;
		$template->SetTemplate('html/cabecera_principal.html');
		// $template->SetParameter('menu', "Factura Electronica");
		return $template->Display();
	}
	function mostrarPiePagina()
	{
		$template = new template;
		$template->SetTemplate('html/pie_pagina.html');
		// $template->SetParameter('menu', "Factura Electronica");
		return $template->Display();
	}

	function mostrarContenido()
	{
		$template = new template;
		// $template->SetTemplate('html/form_facturacion.html');
		// $template->SetTemplate('html/detalle_facturas.html');
		$template->SetTemplate('html/factura.html');
		return $template->Display();
	}
	function mostrarDetalle($row){
		$template = new template;
		$template->SetTemplate('html/detalle.html');
		$template->SetParameter('nro_factura', $row["nro_factura"]);
		$template->SetParameter('importe', $row["importe"]);
		$template->SetParameter('fecha', $row["fecha"]);
		$template->SetParameter('url_factura', $row["url_factura"]);
		$template->SetParameter('url_xml', $row["url_xml"]);
		$template->SetParameter('razon_social', $row["razon_social"]);
		return $template->Display();
	}
	function mostrarDetalleSinDato(){
		$template = new template;
		$template->SetTemplate('html/detalle_sd.html');
		return $template->Display();
	}
	function mostrarFacturas()
	{
		$template = new template;
		$query = new query;
		// $where = "where nit=".$_POST["nit_ci"]. " AND nro_factura = ".$_POST["num_fact"]." AND BETWEEN ".$_POST["date_fact_ini"]." AND  ".$_POST["date_fact_fin"].";
		$where = sprintf("WHERE nit = %d AND nro_factura = %d AND fecha BETWEEN '%s' AND '%s'", $_POST["nit_ci"], $_POST["num_fact"] , $_POST["date_fact_ini"] , $_POST["date_fact_fin"]);
		// $where = sprintf("WHERE id = 1");

		// var_dump($where);
		$row = $query->getRow("*", "facturas", $where);
		// var_dump($row);
		// var_dump($_POST);
		
		// die();
		// $template->SetTemplate('html/form_facturacion.html');
		$template->SetTemplate('html/detalle_facturas.html');
		if(is_null($row)){
			$template->SetParameter('detalle',$this->mostrarDetalleSinDato());
		}
		else{
			$template->SetParameter('detalle',$this->mostrarDetalle($row));
		}
		// $template->SetTemplate('html/factura.html');
		return $template->Display();
	}
	function Display()
	{
		$template = new template;
		$template->SetTemplate('html/template.html');
		$template->SetParameter('pagina', "Facturacion");
		$template->SetParameter('cabecera_menu', $this->mostrarCabeceraMenu());
		$template->SetParameter('cabecera_principal', $this->mostrarCabeceraPrincipal());
		$template->SetParameter('pie_pagina', $this->mostrarPiePagina());

		$accion  = isset($_GET['accion']) ? null : 'aa';
		if (isset($_GET['accion'])) {
			if ($_GET['accion'] == "consultar") {
				$template->SetParameter('contenido', $this->mostrarFacturas());
			}
		} else {
			$template->SetParameter('contenido', $this->mostrarContenido());
		}
		return $template->Display();
	}
}
