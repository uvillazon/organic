function validar(forma)
{
  if (forma.nom_ni.value.length == 0)
  {
    alert("Debes ingresar el nombre.!!!!!");
    forma.nom_ni_n.focus();
	/*  theField.select()
    alert(s)
    statBar(pPrompt + s)*/
    return false;
  }
 if (forma.ape_ni.value.length == 0)
  {
    alert("Debes ingresar el Apellido.!!!!!");
    forma.institucion.focus();
    return false;
  }
 
 


 

 return true;
}
