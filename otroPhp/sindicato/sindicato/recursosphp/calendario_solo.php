<LINK media=all href="calendario.css" type=text/css rel=stylesheet>
<?php
 $mes = $_REQUEST["nuevo_mes"];
 $ano = $_REQUEST["nuevo_ano"];
 $dia = $_REQUEST["dia"];

if(isset($dia)and isset($mes) and isset($ano)){
    $fecha=$dia . "/" . $mes . "/" . $ano;
	
}else{
	$dia=date("d");
    $mes = date("n");
    $ano = date("Y");
    $fecha=$dia . "/" . $mes . "/" . $ano;
}

$mes_hoy=date("m");
$ano_hoy=date("Y");
if (($mes_hoy <> $mes) || ($ano_hoy <> $ano)) { $hoy=0; } 
    else {
     $hoy=date("d");
 } //tomo el nombre del mes que hay que imprimir 
 $nombre_mes = dame_nombre_mes($mes); //construyo la cabecera de la tabla 
 //border="1" align="center" borderColor="#cccccc"cellSpacing="0" cellPadding="2"
echo "<table width=200  class='calendario'><tr><td colspan=7 align=center>";
echo "<table width=100% class='calendario'><tr><td>";
    //calculo el mes y ano del mes anterior
    $mes_anterior = $mes - 1;
    $ano_anterior = $ano;
    if ($mes_anterior==0){
        $ano_anterior--;
        $mes_anterior=12;
    }
	//<<<<<
    echo "<a href=calendario_solo.php?dia=1&nuevo_mes=$mes_anterior&nuevo_ano=$ano_anterior>&lt;&lt;</a></td>";
       echo "<td align=center><strong>$nombre_mes $ano</strong></td>";
       echo "<td align=right>";
    //calculo el mes y ano del mes siguiente
    $mes_siguiente = $mes + 1;
    $ano_siguiente = $ano;
    if ($mes_siguiente==13){
        $ano_siguiente++;
        $mes_siguiente=1;
    }
//>>>>>>>>
  echo "<a href=calendario_solo.php?dia=1&nuevo_mes=$mes_siguiente&nuevo_ano=$ano_siguiente&nuevo_mes=$mes_siguiente>&gt;&gt;</a></td></tr></table></td></tr>";
    echo "    <tr>
                <td width=14% align=center class='tdnameday'>Lu</td>
                <td width=14% align=center class='tdnameday'>Ma</td>
                <td width=14% align=center class='tdnameday'>Mi</td>
                <td width=14% align=center class='tdnameday'>Ju</td>
                <td width=14% align=center class='tdnameday'>Vi</td>
                <td width=14% align=center class='tdnameday'>Sa</td>
                <td width=14% align=center class='tdnameday'>Do</td>
            </tr>";
    
    //Variable para llevar la cuenta del dia actual
    $dia_actual = 1;
    
    //calculo el numero del dia de la semana del primer dia
    $numero_dia = calcula_numero_dia_semana(1,$mes,$ano);
    //echo "Numero del dia de demana del primer: $numero_dia <br>";
    
    //calculo el último dia del mes
    $ultimo_dia = ultimoDia($mes,$ano);
    
//escribo la primera fila de la semana
    echo "<tr>";
    for ($i=0;$i<7;$i++){
        if ($i < $numero_dia){
            //si el dia de la semana i es menor que el numero del primer dia de la semana no pongo nada en la celda
            echo "<td></td>";
        } else {
        if (($i == 5) || ($i == 6))
        {
                if ($dia_actual == $hoy)
                {// para colorear la fecha de hoy
                    echo "<td class='tdhoy' align=center>$dia_actual</td>";
                }
                else
                {//sabado y domingos
                    echo "<td bgcolor='#E0E0E0' align=center>$dia_actual</td>";
                }
        }
        else
        {            
                if ($dia_actual == $hoy)
                {
                    echo "<td class='mtd' align=center>$dia_actual</td>";
                }
                else
                {
                     echo "<td class='mtd' align=center>$dia_actual</td>";
                }
        }
            $dia_actual++;
        }
    }
    echo "</tr>";
    
    //recorro todos los demás días hasta el final del mes
    $numero_dia = 0;
    while ($dia_actual <= $ultimo_dia){
        //si estamos a principio de la semana escribo el <TR>
        if ($numero_dia == 0)
            echo "<tr>";
        //si es el uñtimo de la semana, me pongo al principio de la semana y escribo el </tr>

            if (($numero_dia == 5) || ($numero_dia == 6))
            {
                if ($dia_actual == $hoy)
                {
                    echo "<td class='tdhoy' align=center>$dia_actual</td>";
                }
                else
                {//sabado y domingo
                    echo "<td bgcolor='#E0E0E0' align=center>$dia_actual</td>";
                }
            }
            else
            {        
                if ($dia_actual == $hoy)
                {// para colorear la fecha de hoy
                    echo "<td class='tdhoy' align=center>$dia_actual</td>";
                }
                else
                {
                    echo "<td class='mtd' align=center>$dia_actual</td>";
                }
            }

            $dia_actual++;
            $numero_dia++;
            if ($numero_dia == 7)
            {
                $numero_dia = 0;
                echo "</tr>";
            }

    }
    
    //compruebo que celdas me faltan por escribir vacias de la última semana del mes
    for ($i=$numero_dia;$i<7;$i++){
        echo "<td></td>";
    }
    
    echo "</tr>";
    echo "</table>";
?>
<?php 
function calcula_numero_dia_semana($dia,$mes,$ano){
    $numerodiasemana = date('w', mktime(0,0,0,$mes,$dia,$ano));
    if ($numerodiasemana == 0) 
        $numerodiasemana = 6;
    else
        $numerodiasemana--;
    return $numerodiasemana;
}

//funcion que devuelve el último día de un mes y año dados
function ultimoDia($mes,$ano){ 
    $ultimo_dia=28; 
    while (checkdate($mes,$ultimo_dia + 1,$ano)){ 
       $ultimo_dia++; 
    } 
    return $ultimo_dia; 
} 

function dame_nombre_mes($mes){
     switch ($mes){
         case 1:
            $nombre_mes="Enero";
            break;
         case 2:
            $nombre_mes="Febrero";
            break;
         case 3:
            $nombre_mes="Marzo";
            break;
         case 4:
            $nombre_mes="Abril";
            break;
         case 5:
            $nombre_mes="Mayo";
            break;
         case 6:
            $nombre_mes="Junio";
            break;
         case 7:
            $nombre_mes="Julio";
            break;
         case 8:
            $nombre_mes="Agosto";
            break;
         case 9:
            $nombre_mes="Septiembre";
            break;
         case 10:
            $nombre_mes="Octubre";
            break;
         case 11:
            $nombre_mes="Noviembre";
            break;
         case 12:
            $nombre_mes="Diciembre";
            break;
    }
    return $nombre_mes;
}
?>

