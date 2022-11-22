<?php
class productos
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
		$template->SetParameter('menu', "Productos");
		return $template->Display();
	}
	function mostrarCabeceraPrincipal()
	{
		$template = new template;
		$template->SetTemplate('html/cabecera_principal.html');
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
		$template->SetTemplate('html/productos.html');
		return $template->Display();
	}
	
	function Display()
	{
		$template = new template;
		$template->SetTemplate('html/template.html');
		$template->SetParameter('pagina', "Productos");
		$template->SetParameter('cabecera_menu', $this->mostrarCabeceraMenu());
		$template->SetParameter('cabecera_principal', $this->mostrarCabeceraPrincipal());
		$template->SetParameter('pie_pagina', $this->mostrarPiePagina());
		$template->SetParameter('contenido', $this->mostrarContenido());
		return $template->Display();
	}
}
