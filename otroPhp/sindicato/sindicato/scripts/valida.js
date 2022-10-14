function validaChofer() {
  if (document.mframe.numero_licencia.value == "") {
	  alert("Ingrese un numero de Licencia");
	  return false;
  }
  if (document.mframe.nombre_chofer.value == "") {
	  alert("Ingrese el nombre del Chofer.");
	  return false;
  } 
  return true;
}

function validaSocio() {
  if (document.mframe.numero_licencia.value == "") {
	  alert("Ingrese el Numero de Licencia o CI del socio(a).");
	  return false;
  }
    if (document.mframe.nombre_socio.value == "") {
	  alert("Ingrese el Nombre del socio(a).");
	  return false;
  }
    if (document.mframe.ape1.value == "") {
	  alert("Ingrese el apellido del Socio(a).");
	  return false;
  }


  return true;
}
function validaControl() {
  if (document.mframe.movil.value == "") {
	  alert("Ingrese el Numero de Movil.");element.focus();
	  return false;
  }
   return true;
}
function validaMovil() {
 /* if (document.mframe.licencia.value == "") {
	  alert("Ingrese el Numero de Licencia o CI del socio(a).");
	  return false;
  }
*/
   if (document.mframe.movil.value == "") {
	  alert("Ingrese el Numero de Movil asignado.");
	  return false;
  }
   if (document.mframe.placa.value == "") {
	  alert("Ingrese el Numero de Placa del vehiculo.");
	  return false;
  }
   return true;
}


function validaLinea() {
  if (document.mframe.linea.value == "") {
	  alert("Ingrese el Nombre o numero de la nueva linea.");
	  return false;
  }
   if (document.mframe.descripcion.value == "") {
	  alert("Ingrese una descripcion de la nueva linea.");
	  return false;
  }
   if (document.mframe.fecha_creacion.value == "") {
	  alert("Ingrese la Fecha de creacion de la nueva linea.");
	  return false;
  }
  if (document.mframe.costo.value == "") {
	  alert("Ingrese el costo para socios que tendra la linea .");
	  return false;
  }
   return true;
}

function validaTipoIngreso() {
  if (document.mframe.tipo_ingreso.value == "") {
	  alert("Ingrese el Tipo de Ingreso.");
	  return false;
  }
  if (document.mframe.monto_tipo_ingreso.value == "") {
	  alert("Ingrese el monto de ingreso .");
	  return false;
  }
  return true;
}

function validaTipoPrestamo() {
  if (document.mframe.tipo_prestamo.value == "") {
	  alert("Ingrese el Tipo de Prestamo.");
	  return false;
  }
  if (document.mframe.interes.value == "") {
	  alert("Ingrese el porcentaje de interes .");
	  return false;
  }
  return true;
}

function validaTransaccion() {
  if (document.mframe.tipo_transaccion.value == "") {
	  alert("Ingrese el Tipo de Transaccion que aparecera en la hoja de control.");
	  return false;
  }
  if (document.mframe.monto_transaccion.value == "") {
	  alert("Ingrese el monto asignado a la transaccion.");
	  return false;
  }
  return true;
}
function validaPrestamo() {
  if (document.mframe.licencia.value == "") {
	  alert("Ingrese el Numero de Socio el cual es responsable del prestamo.");
	  return false;
  }
  if (document.mframe.tipo_prestamo.value == "") {
	  alert("Seleccione un tipo de prestamo.");
	  return false;
  }
  if (document.mframe.monto_prestamo.value == "") {
	  alert("Ingrese el monto o valor de prestamo.");
	  return false;
  }
  return true;
}

function validaIngreso() {
  if (document.mframe.movil.value == "") {
	  alert("Ingrese el Movil al que se asigna el ingreso.");
	  return false;
  }
  if (document.mframe.tipoingreso.value == "") {
	  alert("Debe existir un monto..Seleccione un tipo de ingreso.");
	  return false;
  }
  return true;
}