<?php
class index
{
	var $parameter = array();
	function SetParameter($name, $value)
	{
		$this->parameter[$name] = $value;
	}
	function mostrarPiePagina()
	{
		$template = new template;
		$template->SetTemplate('html/pie_pagina.html');
		return $template->Display();
	}
	function mostrarCabeceraPrincipal()
	{
		$template = new template;
		$template->SetTemplate('html/cabecera_principal.html');
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
		$template->SetTemplate('html/template_index.html');
		
		$template->SetParameter('cabecera_principal', $this->mostrarCabeceraPrincipal());
		$template->SetParameter('pie_pagina', $this->mostrarPiePagina());
		// $template->SetParameter('contenido', $this->mostrarContenido());
		return $template->Display();
	}
}
