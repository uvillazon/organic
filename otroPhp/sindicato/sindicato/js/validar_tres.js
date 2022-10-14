function validar(forma)
{
  if(forma.num_caso.value.length ==0)
  {
    alert("Debe ingresar el numero de caso.!!!!!");
    forma.peso_ni.focus();
    return false;
  }
 if(forma.num_ni.value.length ==0)
  {
    alert("Debe ingresar el numero de niño!!!!!");
    forma.peso_ni.focus();
    return false;
  }
  if(forma.nom_ni.value.length ==0)
  {
    alert("Debe ingresar el nombre del afiliado.!!!!!");
    forma.peso_ni.focus();
    return false;
  }
  if(forma.ape_ni.value.length ==0)
  {
    alert("Debe ingresar el apellido del afiliado.!!!!!");
    forma.peso_ni.focus();
    return false;
  }
/*if(!(forma.plano[0].checked || forma.plano[1].checked))
{ 
alert("¿cual es el genero del niño F  o M?");
forma.genero[0].focus();
return false;  
}*/
if (forma.fechaimg.value.length ==0)
  {
    alert("Debes ingresar la fecha de nacimiento.!!!!!");
    forma.fechaimg.focus();
    return false;
  }  
/* if (forma.padron.value.length ==0)
  {
    alert("Debes el ingresar el padron municipal.!!!!!");
    forma.padron.focus();
    return false;
  }
 
*/
/* if(forma.ambr[2].checked)
  { 
		if(forma.equiporx.value.length==0){
        alert("Si elegiste deves ingresar en equipo RX.!!!!!");
	   	forma.equiporx.focus();
       	return false; 
		}
  }*/
 return true;
}
