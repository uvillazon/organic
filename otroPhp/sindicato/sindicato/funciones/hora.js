// JavaScript Document
var timerID = null;
var timerRunning = false;
var id,pause=0,position=0;

function stopclock (){
        if(timerRunning)
                clearTimeout(timerID);
        timerRunning = false;
}
// Similar a reloj_barra. En este caso, no se asigna el valor a la barra de estado, sino a un elemnto del formulario. Un cuadro de texto.
function showtime () {
        var now = new Date();
        var hours = now.getHours();
        var minutes = now.getMinutes();
        var seconds = now.getSeconds()
        var timeValue = "" + ((hours >12) ? hours -12 :hours)
        timeValue += ((minutes < 10) ? ":0" : ":") + minutes
        timeValue += ((seconds < 10) ? ":0" : ":") + seconds
        timeValue += (hours >= 12) ? " P.M." : " A.M."
        document.clock.face.value = timeValue;   // Asignación de timevalue al cuadro de texto.
        timerID = setTimeout("showtime()",1000);
        timerRunning = true;
}
function startclock () {
        stopclock();
        showtime();
}

//********************************************************************************************
//------------------------------ Para los avisos del index -----------------------------------
//********************************************************************************************
var tamAvisos = 0;   //Tamaño por defecto para todos los avisos, sera cambiado como la primera accion
var numAvisos = 0;     //El numero de avisos tiene la pagina
var pos = 0;           //Posicion para la rotacion  
var tamAviso = 0;    //El tamaño maximo que puede tener un aviso      
var avisos_mostrados;     //Un arreglo para los nombres de los avisos existentes

var ultimoAviso;    //Una cadena con el nombre del ultimo aviso
var avisoCola;      //Es el nombre del aviso que ira a la cola del arreglo, para simular el arreglo circular
var tiempoEspera;   //El tiempo de espera que se realize la siguiente iteracion



function initAvisos_mostrados(){
    for(i=0; i<numAvisos; i++ )
        avisos_mostrados[i] = "aviso"+i;

    tiempoEspera = 200;
}

function setNumAvisos( num ){
  numAvisos = num;
  avisos_mostrados = new Array( numAvisos );
  initAvisos_mostrados();
}

function setTamAviso( tam ){
  tamAviso = tam;
  tamAvisos = tamAviso*3;       //Mostrare 3 avisos como maximo
}

function moverAvisos(){  
   if( numAvisos > 3 ){ 
   if( pos == 0 )
        tiempoEspera = 70;
   for(i=0; i<numAvisos; i++){
     var aviso = document.getElementById( avisos_mostrados[i] );
     aviso.style.position = "absolute";
     aviso.style.top = (pos+tamAviso*i)+"px";
   }
   pos--;
   if( pos < (tamAviso*(-1))){
      pos = 0;
      avisoCola = avisos_mostrados[0];
      for(j=0; j<numAvisos-1; j++)
        avisos_mostrados[j] = avisos_mostrados[j+1];
      avisos_mostrados[numAvisos-1] = avisoCola;
      tiempoEspera = 5000;
    }
    
    setTimeout("moverAvisos()", tiempoEspera);
   }
 }

/************************* Fin de Avisos del index ************************************************/
