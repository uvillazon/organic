<?php
class semillas
{
	var $parameter = array();
	function SetParameter($name, $value)
	{
		$this->parameter[$name] = $value;
	}
	function mostrarCabeceraMenu()
	{
		$template = new template;
		$template->SetTemplate('html/cabecera_menu_producto.html');
		$template->SetParameter('menu', "Semillas");
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
		return $template->Display();
	}

	function mostrarContenido()
	{
		$template = new template;
		$template->SetTemplate('html/semillas.html');
		return $template->Display();
	}
	
	function Display()
	{
		$template = new template;
		$template->SetTemplate('html/template.html');
		$template->SetParameter('pagina', "Semillas");
		$template->SetParameter('cabecera_menu', $this->mostrarCabeceraMenu());
		$template->SetParameter('cabecera_principal', $this->mostrarCabeceraPrincipal());
		$template->SetParameter('pie_pagina', $this->mostrarPiePagina());
		$template->SetParameter('contenido', $this->mostrarContenido());
		return $template->Display();
	}
}
