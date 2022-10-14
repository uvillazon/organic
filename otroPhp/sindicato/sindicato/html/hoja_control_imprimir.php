<html>
<head>
<title>Mostrar hoja de Control</title>
<link href="estilo.css"type=text/css rel=stylesheet>
<script language="JavaScript" src="js/imprimir.js"></script>
</head>
<body class="sub_body">
<?php
		include("../librerias/my_lib.php");
		conectarDB();			
		$sql1="select * from movil where id_movil='".$_GET['codmovil']."';";		
		$serv=consultaDB($sql1);
		$row=mysql_fetch_array($serv);		
		?>
<table width="38%" border="0" align="center">
  <tr>
    <td height="765" class="outline"><table width="346" border="0" align="center" >
        <tr>
          <td width="282">&nbsp;</td>
          <td width="54"> 
            <?php 

$sql="select h.numero_hoja from hoja_control h, movil m 
where m.id_movil=h.id_movil and
m.id_movil='".$_GET['codmovil']."'";
//    echo $sql;
  $res = consultaDB($sql);			
  $r=mysql_fetch_array($res);
 		echo "No $r[0]";
	
?>
          </td>
        </tr>
      </table>
      
      <table width="102%" height="186"  border="0" align="center">
        <tr> 
            
          <td width="19%"><font color="#FFFFFF" size="3">Propietario:</font></td>
            
          <td width="81%"><?php 

$sql="select s.nombre_socio from socio s, movil m, pertenece p 
where m.id_movil=p.id_movil and s.id_pertenece=p.id_pertenece and
m.id_movil='".$_GET['codmovil']."'";
//    echo $sql;
  $res = consultaDB($sql);			
  $r=mysql_fetch_array($res);
 		echo "$r[0]";
	
?>            <font color="#FFFFFF">
            <?php 

$sql="select s.apellido1_socio from socio s, movil m, pertenece p 
where m.id_movil=p.id_movil and s.id_pertenece=p.id_pertenece and
m.id_movil='".$_GET['codmovil']."'";
//    echo $sql;
  $res = consultaDB($sql);			
  $r=mysql_fetch_array($res);
 		echo "$r[0]";
	
?>
            <?php 

$sql="select s.apellido2_socio from socio s, movil m, pertenece p 
where m.id_movil=p.id_movil and s.id_pertenece=p.id_pertenece and
m.id_movil='".$_GET['codmovil']."'";
//    echo $sql;
  $res = consultaDB($sql);			
  $r=mysql_fetch_array($res);
 		echo "$r[0]";
	
?>
            Movil<b class="titulo">.......</b></font><b class="titulo"> 
            <?php echo $row[2];?></b><font color="#FFFFFF">Linea<b class="titulo">......</b></font>
            <?php 

$sql="select h.numero_hoja from hoja_control h, movil m 
where m.id_movil=h.id_movil and
m.id_movil='".$_GET['codmovil']."'";
//    echo $sql;
  $res = consultaDB($sql);			
  $r=mysql_fetch_array($res);
 		echo "$r[0]";
	
?></td>
        </tr>
		  <tr> 
            
          <td width="39%"><font color="#FFFFFF" size="4">Placa:..............</font>
            <?php 

$sql="select p.placa_movilidad from pertenece p, movil m 
where m.id_movil=p.id_movil and
m.id_movil='".$_GET['codmovil']."'";
//    echo $sql;
  $res = consultaDB($sql);			
  $r=mysql_fetch_array($res);
 		echo "$r[0]";
	
?></td>
          <td width="61%"> <font color="#FFFFFF">Fecha</font></td>
          </tr>
          <tr> 
            
          <td><font color="#FFFFFF">Conductor:</font></td>
            
          <td> 
            <?php 

$sql="select chofer.nombre_chofer
from chofer, hoja_control, movil
where (chofer.idchofer=hoja_control.idchofer)and(movil.id_movil=hoja_control.id_movil)and(movil.id_movil='".$_GET['codmovil']."');";
//    echo $sql;
  $res = consultaDB($sql);			
  $r=mysql_fetch_array($res);
 
		echo "<input name='nom_chofer' type='text' value='$r[0]' checked>";
?>          </td>
          </tr>
		<tr> 
          <td width="19%">&nbsp;</td>
          <td width="81%" valign="middle" align="right"><p>No 
              <?php 

$sql="select h.numero_hoja from hoja_control h, movil m 
where m.id_movil=h.id_movil and
m.id_movil='".$_GET['codmovil']."'";
//    echo $sql;
  $res = consultaDB($sql);			
  $r=mysql_fetch_array($res);
 		echo "$r[0]";
	
?>
            </p>
            <p>
              <?php 

$sql="select h.fecha_de_compra from hoja_control h, movil m 
where m.id_movil=h.id_movil and
m.id_movil='".$_GET['codmovil']."'";
//    echo $sql;
  $res = consultaDB($sql);			
  $r=mysql_fetch_array($res);
 		echo "$r[0]";
	
?>
            </p>
            <p>&nbsp;</p>          </td>
        </tr>
        <tr>        </tr>
      </table>

      <form name="#" method="post" action="ParaInsertar.php">
	    <table width="99%" height="33" border="0" align="center">
          <tr> 
            <td width="17%"><font color="#FFFFFF">Propietario</font>:</td>
            <td width="83%"><?php 

$sql="select s.nombre_socio from socio s, movil m, pertenece p 
where m.id_movil=p.id_movil and s.id_pertenece=p.id_pertenece and
m.id_movil='".$_GET['codmovil']."'";
//    echo $sql;
  $res = consultaDB($sql);			
  $r=mysql_fetch_array($res);
 		echo "$r[0]";
	
?>
              <font color="#FFFFFF">
              <?php 

$sql="select s.apellido1_socio from socio s, movil m, pertenece p 
where m.id_movil=p.id_movil and s.id_pertenece=p.id_pertenece and
m.id_movil='".$_GET['codmovil']."'";
//    echo $sql;
  $res = consultaDB($sql);			
  $r=mysql_fetch_array($res);
 		echo "No $r[0]";
	
?>
              <?php 

$sql="select s.apellido2_socio from socio s, movil m, pertenece p 
where m.id_movil=p.id_movil and s.id_pertenece=p.id_pertenece and
m.id_movil='".$_GET['codmovil']."'";
//    echo $sql;
  $res = consultaDB($sql);			
  $r=mysql_fetch_array($res);
 		echo "No $r[0]";
	
?>
            </font><font color="#FFFFFF">..................................Movil</font><b class="titulo"><?php echo $row[2];?></b><font color="#FFFFFF">Linea<b class="titulo">......</b></font>
            <?php 

$sql="select h.numero_hoja from hoja_control h, movil m 
where m.id_movil=h.id_movil and
m.id_movil='".$_GET['codmovil']."'";
//    echo $sql;
  $res = consultaDB($sql);			
  $r=mysql_fetch_array($res);
 		echo "$r[0]";
	
?></td>
          </tr>
        </table>
		 <table width="99%" border="0" align="center">

          <tr> 
            <td width="39%" height="23"><font color="#FFFFFF" size="4">Placa: 
              </font>
              <?php 

$sql="select p.placa_movilidad from pertenece p, movil m 
where m.id_movil=p.id_movil and
m.id_movil='".$_GET['codmovil']."'";
//    echo $sql;
  $res = consultaDB($sql);			
  $r=mysql_fetch_array($res);
 		echo "$r[0]";
	
?></td>
            <td width="61%"> <font color="#FFFFFF">Fecha:</font></td>
          </tr>
          
          
        </table>
		 <table width="100%" height="26" border="0" align="center">
          <tr> 
            <td width="14%"><font color="#FFFFFF">Ingreso</font>:</td>
            <td width="86%">&nbsp; </td>
          </tr>
        </table>
       
		
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
	
       
	
           
        <table width="100%" height="83" border="0" align="center">
          <tr> 
            <td width="36%" height="30"><font color="#FFFFFF">Nombre Conductor:</font></td>
            <td width="64%"><?php 

$sql="select chofer.nombre_chofer
from chofer, hoja_control, movil
where (chofer.idchofer=hoja_control.idchofer)and(movil.id_movil=hoja_control.id_movil)and(movil.id_movil='".$_GET['codmovil']."');";
//    echo $sql;
  $res = consultaDB($sql);			
  $r=mysql_fetch_array($res);
 
		echo "<input name='nom_chofer' type='text' value='$r[0]' checked>";
?></td>
          </tr>
          <tr> 
            <td height="23"><font color="#FFFFFF">Numero Licencia:</font></td>
            <td><?php 

$sql="select chofer.licencia
from chofer, hoja_control, movil
where (chofer.idchofer=hoja_control.idchofer)and(movil.id_movil=hoja_control.id_movil)and(movil.id_movil='".$_GET['codmovil']."');";
//    echo $sql;
  $res = consultaDB($sql);			
  $r=mysql_fetch_array($res);
 
		echo "<input name='nom_chofer' type='text' value='$r[0]' checked>";
?></td>
          </tr>
          <tr> 
            <td height="22"><font color="#FFFFFF">Observaciones:</font></td>
            <td>Aporte sindicato:7 Bs. Ahorro 8 Bs</td>
          </tr>
        </table>
       
      </form> </td>
  </tr>
</table>
<div align="center">
  <input type=button value="Imprimir" name="Print11" onClick="printit()">
</div>
</body>
</html>
