// JavaScript Document
function foco(mforma,campo)
{
  eval('document.'+mforma+'.'+campo+'.focus()');
}


function cambiarName(myradio,num,id,nombres)
{ var radio=null;
  for ( i = 1 ; i < 6 ;i++)
  { radio = document.getElementById(id+i);
    radio.name=nombres;
    //alert(radio.name+" = "+i);
  }
  myradio.name="tiqueado"+num;    
}
function cambiarsino(myradio,pos,myname,num)
{ var radio=document.getElementById("1des"+num);
  radio.name=myname;
 // alert(radio.name +" "+ radio.id);  
  radio=document.getElementById("2des"+num);
  radio.name=myname;
  //alert(radio.name +" "+ radio.id);  
  myradio.name="tiqueado"+pos;    
  //alert(myradio.name+" "+ myradio.id);  
}

function foco(mforma,campo)
{
  eval('document.'+mforma+'.'+campo+'.focus()');
}
function bajar(e,forma,campo) {
 tecla = (document.all) ? e.keyCode : e.which; 
 if (tecla == 13) 
   { 
     eval('document.'+forma+'.' + campo + '.focus()')
	 return false;
   }
}


function enviar(f)
{ 
   if(validar(f)){
	   if(confirm("¿Estas seguro de querer Enviar los Datos?"))
		f.submit();
		else
		alert("Entonces te quedaras ahi");
	}
}

//valida literales
 function literal(e) 
 { tecla = (document.all) ? e.keyCode : e.which; 
//   alert(tecla);
   if (tecla==8) return true; 
   if (tecla==34 || tecla==39 || tecla==47 || tecla==96 || tecla==94 || tecla==92 || tecla==180 ) return false; 
     patron = /\D/;
     te = String.fromCharCode(tecla); 
     return patron.test(te); 
 }
 //valida numeros
 function numeral(e) 
 { tecla = (document.all) ? e.keyCode : e.which; 
   if (tecla==8) return true; 
     patron = /\d/; //Solo acepta números 
     te = String.fromCharCode(tecla); 
     return patron.test(te); 
 }
 
 
 function literal_numeral(e) 
 { tecla = (document.all) ? e.keyCode : e.which; 
   if (tecla==8) return true;   
   if (tecla==34 || tecla==39 || tecla==47 || tecla==96 || tecla==94 || tecla==92 || tecla==180 ) return false; 
   else return true;
 }