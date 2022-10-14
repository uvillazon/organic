function validar(forma)
{
  if (forma.titulo_imagen.value.length == 0)
  {
    alert("Debes ingresar el nombre de la imagen.!!!!!");
    forma.titulo_imagen.focus();
    return false;
  }

 return true;
}
