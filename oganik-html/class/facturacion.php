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
	function mostrarContenido()
	{
		$template = new template;
		// $template->SetTemplate('html/form_facturacion.html');
		// $template->SetTemplate('html/detalle_facturas.html');
		$template->SetTemplate('html/factura.html');
		return $template->Display();
	}
	function mostrarFacturas()
	{
		$template = new template;
		// $template->SetTemplate('html/form_facturacion.html');
		$template->SetTemplate('html/detalle_facturas.html');
		// $template->SetTemplate('html/factura.html');
		return $template->Display();
	}
	function Display()
	{
		$template = new template;
		$template->SetTemplate('html/template.html');
		$template->SetParameter('cabecera_menu', $this->mostrarCabeceraMenu());
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
