function validar(mframe)
{
  if(mframe.num_caso.value.length ==0)
  {
    alert("Debes ingresar el numero.!!!!!");
    mframe.num_caso.focus();
    return false;
  }
 /*if (forma.nombres.value.length ==0)
  {
    alert("Debes ingresar el nombre del responsable.!!!!!");
    forma.nombres.focus();
    return false;
  }
 if (forma.apellidos.value.length ==0)
  {
    alert("Debes ingresar el apellido del responsable.!!!!!");
    forma.apellidos.focus();
    return false;
  }  
 if (forma.matriculaprof.value.length ==0)
  {
    alert("Debes ingresar la matricula del profesional.!!!!!");
    forma.matriculaprof.focus();
    return false;
  }  
 if (forma.matriculamed.value.length ==0)
  {
    alert("Debes el ingresar la matricula del medico.!!!!!");
    forma.matriculamed.focus();
    return false;
  }   
 if (forma.nit.value.length ==0)
  {
    alert("Debes el ingresar el NIT.!!!!!");
    forma.nit.focus();
    return false;
  }
/* if (forma.padron.value.length ==0)
  {
    alert("Debes ingresar el padron municipal.!!!!!");
    forma.padron.focus();
    return false;
  }  */
/*if(!(forma.tituacadem[0].checked || forma.tituacadem[1].checked))
  { 
    alert("¿Tiene o no titulo academico?");
	forma.tituacadem[0].focus();
    return false;  
  }
  if(forma.tituacadem[0].checked || forma.tituacadem[1].checked)
  { 
        if(forma.tituacadem[0].checked){ 	    
		   if(forma.fechacadem.value.length==0){
            alert("Ingresa la fecha del titulo academico!!!!!");
	   		forma.tituacadem[0].focus();
        	return false; 
		   }
		}
		 if(forma.tituacadem[1].checked){ 	    
		   if(!forma.fechacadem.value.length==0){
            alert("No tiene que tener Fecha Si lo pusiste NO en titulo academico!!");
	   		forma.fechacadem.select();
        	return false; 
		   }
		}
  }
  if(forma.tituprovnal[0].checked || forma.tituprovnal[1].checked)
  { 
        if(forma.tituprovnal[0].checked){  
		   if(forma.fechaprovnal.value.length==0){
            alert("Ingresa la fecha del titulo en provision nacional.!!!!!");
	   		forma.tituprovnal[0].focus();
        	return false; 
		   }
		}
		if(forma.tituprovnal[1].checked){ 
		   if(!forma.fechaprovnal.value.length==0){
            alert("No tiene que tener Fecha Si lo pusiste NO en provision nacional!!");
	   		forma.fechaprovnal.select();
        	return false; 
		   }
		}
  }  */
 return true;
}
