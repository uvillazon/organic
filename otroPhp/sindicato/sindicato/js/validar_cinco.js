function validar(frmatr)
{
  if (frmatr.nom_ni_n.value.length == 0)
  {
    alert("Debe ingresar el nombre.!!!!!");
    frmatr.nom_ni_n.focus();
	/*  theField.select()
    alert(s)
    statBar(pPrompt + s)*/
    return false;
  }
 if (frmatr.ape_ni_nu.value.length == 0)
  {
    alert("Debe ingresar el apellido del niño.!!!!!");
    frmatr.ape_ni_nu.focus();
    return false;
  }
 
  /*Control del los titulos*/  

 
  /*Fin Control del los titulos*/
  
 /*if(!(frmatr.plano[0].checked || frmatr.plano[1].checked))
  { 
    alert("Debes escoger una opcion entre Femenino y Masculino.!!!!!");
	frmatr.plano[0].focus();
    return false;  
  }  */
   
 
   
 return true;
}
