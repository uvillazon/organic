<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>

<!--
author: raduga http://mambasana.ru
copyright: GNU/GPL
-->

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="robots" content="index, follow">
  
  <title>Sindicato</title>
	
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<link rel="stylesheet" href="index_files/template_css.css" type="text/css">
<link rel="stylesheet" type="text/css" media="all" href="funciones/calendario/calendar-system.css" title="green" />


</head><body id="body">

<div id="logo">
<div id="top_bar">
</div></div>
           
                
                <div align="center">
<div class="moduletable-topnav">
<a href="hoja_control.php" class="topnav">Hojas de Control</a>
<a href="ingresos.php" class="topnav">Ingresos</a>
<a href="prestamo.php" class="topnav">Prestamos</a>
<a href="reporte_uno.php" class="topnav">Reportes</a>
<a href="index.php" class="topnav">Portada</a></div>
                </div> 
                <div id="clear"></div>

                  <table id="centertb" width="100%" align="center" border="0" cellpadding="0" cellspacing="0">

                  <tbody><tr>

                  <td class="leftcol" valign="top">
                  <div>
                  		<div class="module_menu">
			<div>
				<div>
					<div>
                        <h3>Menú Administracion </h3>
                        <ul class="menu">
                            <li id="current" class="active item1"><a href="socio.php"><span>Socio</span></a></li>
							<li id="current" class="item2"><a href="movil.php"><span>Movil</span></a></li>
                            <li class="item3"><a href="chofer.php"><span>Chofer</span></a></li>
                            <li class="item4"><a href="tipoprestamo.php">Tipo Prestamo </a></li>
                            <li class="item5"><a href="tipoingreso.php">Tipo Ingresos </a></li>
                            <li class="item6"><a href="tipotransaccion.php">Tipo Aportes </a></li>
                            <li class="item7"><a href="reportes/reportes_uno.php"><span>Reportes</span></a></li>
                            
                        </ul>
                    </div>
				</div>
			</div>
		</div>
			[registro]
	                  </div>
                  </td>          

             <td id="contenttb" valign="top" width="100%"> 
             <table width="100%" border="0" cellpadding="0" cellspacing="0">

                <tbody><tr>
                <td colspan="3" class="pw"></td>
                </tr>



<body class="sub_body">
		
<table width="90%" border="0" align="center">
  <tr>
    <td height="347" class="outline"><table width="90%"  border="0" align="center">
        <tr> 
          <td width="14%">&nbsp;</td>
          <td width="86%" valign="middle" align="right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
        <tr> 
          <td height="78" colspan="2" align="center"><hr class="mraya" width="100%" size="5">
            <b class="titulo">INGRESOS<br>
            DEL 
            
            :<?php echo $_GET['fechaingreso1'];?> AL :<?php echo $_GET['fechaingreso2'];?></b></td>
        </tr>
     

      <form name="#" method="post" action="ParaInsertar.php">
        <table width="678" border="1" align="center">
  <tr>
    <td width="237">INGRESO</td>
    <td width="76">Registros</td>
    <td width="174">Precio Unitario </td>
    <td width="163"> Ingreso por cuenta </td>
  </tr>
  </table>
  
  <table width="678" border="1" align="center">
    <tr>
	 <?php
	 include("../librerias/my_lib.php");
		conectarDB();			
		$sql1="select * from tipo_ingreso";		
		$serv=consultaDB($sql1);
		$row=mysql_fetch_array($serv);	 
	 $sql1="SELECT sum( i.monto_pago_ingreso )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso1']."' and i.fecha_ingreso<='".$_GET['fechaingreso2']."' and ti.tipo_ingreso LIKE 'Cambio de nombre'  ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);

$sql="SELECT ti.tipo_ingreso, ti.monto_tipo_ingreso, i.monto_pago_ingreso from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso1']."' and i.fecha_ingreso<='".$_GET['fechaingreso2']."' and ti.tipo_ingreso LIKE 'Cambio de nombre' ";
  $res = consultaDB($sql);			
  $r=mysql_fetch_array($res);
		echo "<td width='237'>";
		echo "Cambio de nombre";
        echo "</td width='76'>";
		echo "<td align='left'>";
		echo "$nu[1]";
        echo "</td>";
		echo "<td width='174' align='center'>";
		echo "$r[1]";
        echo "</td>";
		echo "<td align='center' width='163'>";
		echo "$nu[0]";
        echo "</td>";
?>
    </tr>
  </table>  

	<table width="678" border="1" align="center">
            <?php 
	 $sql1="SELECT sum( i.monto_pago_ingreso )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso1']."' and i.fecha_ingreso<='".$_GET['fechaingreso2']."' and ti.tipo_ingreso LIKE 'Permiso trabajo'  ";				
$num=consultaDB($sql1);
//$row[1]
$nu=mysql_fetch_array($num);
$sql="SELECT ti.tipo_ingreso, ti.monto_tipo_ingreso, i.monto_pago_ingreso from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso1']."' and i.fecha_ingreso<='".$_GET['fechaingreso2']."' and ti.tipo_ingreso LIKE 'Permiso trabajo'  ";
  $res = consultaDB($sql);			
  $r=mysql_fetch_array($res);
		echo "<td width='237'>";
		echo "$r[0]";
        echo "</td>";
		echo "<td width='76' align='left'>";
		echo "$nu[1]";
        echo "</td>";
		echo "<td width='174' align='center'>";
		echo "$r[2]";
        echo "</td>";
		echo "<td width='163' align='center'>";
		echo "$nu[0]";
        echo "</td>";
?>
</table>
	<table width="678" border="1" align="center">
	<tr>
            <?php 
	 $sql1="SELECT sum( i.monto_pago_ingreso )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso1']."' and i.fecha_ingreso<='".$_GET['fechaingreso2']."' and ti.tipo_ingreso LIKE 'Falta asamblea ordinaria'  ";				
$num=consultaDB($sql1);
//$row[1]
$nu=mysql_fetch_array($num);
$sql="SELECT ti.tipo_ingreso, ti.monto_tipo_ingreso, i.monto_pago_ingreso from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso1']."' and i.fecha_ingreso<='".$_GET['fechaingreso2']."' and ti.tipo_ingreso LIKE 'Falta asamblea ordinaria'  ";
  $res = consultaDB($sql);			
  $r=mysql_fetch_array($res);
		echo "<td width='237'>";
		echo "Falta asamblea";
        echo "</td>";
		echo "<td width='76' align='left'>";
		echo "$nu[1]";
        echo "</td>";
		echo "<td width='174' align='center'>";
		echo "$r[2]";
        echo "</td>";
		echo "<td width='163' align='center'>";
		echo "$nu[0]";
        echo "</td>";
?>
</tr>
</table>
	<table width="678" border="1" align="center">
	<tr>
            <?php 
	 $sql1="SELECT sum( i.monto_pago_ingreso )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso1']."' and i.fecha_ingreso<='".$_GET['fechaingreso2']."' and ti.tipo_ingreso LIKE 'Atraso asamblea'  ";				
$num=consultaDB($sql1);
//$row[1]
$nu=mysql_fetch_array($num);
$sql="SELECT ti.tipo_ingreso, ti.monto_tipo_ingreso, i.monto_pago_ingreso from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso1']."' and i.fecha_ingreso<='".$_GET['fechaingreso2']."' and ti.tipo_ingreso LIKE 'Atraso asamblea'  ";
  $res = consultaDB($sql);			
  $r=mysql_fetch_array($res);
		echo "<td width='237'>";
		echo "Atraso asamblea ordinaria";
        echo "</td>";
		echo "<td width='76' align='left'>";
		echo "$nu[1]";
        echo "</td>";
		echo "<td width='174' align='center'>";
		echo "$r[2]";
        echo "</td>";
		echo "<td width='163' align='center'>";
		echo "$nu[0]";
        echo "</td>";
?>
</tr>
 </table>   
 
 
	<table width="678" border="1" align="center">
     <tr>
	        <?php 
	 $sql1="SELECT sum( i.monto_pago_ingreso )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso1']."' and i.fecha_ingreso<='".$_GET['fechaingreso2']."' and ti.tipo_ingreso LIKE 'Atraso trabajo'  ";				
$num=consultaDB($sql1);
//$row[1]
$nu=mysql_fetch_array($num);
$sql="SELECT ti.tipo_ingreso, ti.monto_tipo_ingreso, i.monto_pago_ingreso from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso1']."' and i.fecha_ingreso<='".$_GET['fechaingreso2']."' and ti.tipo_ingreso LIKE 'Atraso trabajo'  ";
  $res = consultaDB($sql);			
  $r=mysql_fetch_array($res);
		echo "<td width='237'>";
		echo "Atraso al trabajo";
        echo "</td>";
		echo "<td width='76' align='left'>";
		echo "$nu[1]";
        echo "</td>";
		echo "<td width='174' align='center'>";
		echo "$r[2]";
        echo "</td>";
		echo "<td width='163' align='center'>";
		echo "$nu[0]";
        echo "</td>";
?>
  
    </tr>
     
</table>
<table width="678" border="1" align="center">
	<tr>
            <?php 
	 $sql1="SELECT sum( i.monto_pago_ingreso )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso1']."' and i.fecha_ingreso<='".$_GET['fechaingreso2']."' and ti.tipo_ingreso LIKE 'Alquiler de linea al sindicato'  ";				
$num=consultaDB($sql1);
//$row[1]
$nu=mysql_fetch_array($num);
$sql="SELECT ti.tipo_ingreso, ti.monto_tipo_ingreso, i.monto_pago_ingreso from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso1']."' and i.fecha_ingreso<='".$_GET['fechaingreso2']."' and ti.tipo_ingreso LIKE 'Alquiler de linea al sindicato'  ";
  $res = consultaDB($sql);			
  $r=mysql_fetch_array($res);
		echo "<td width='237'>";
		echo "Alquiler de linea al sindicato";
        echo "</td>";
		echo "<td width='76' align='left'>";
		echo "$nu[1]";
        echo "</td>";
		echo "<td width='174' align='center'>";
		echo "$r[2]";
        echo "</td>";
		echo "<td width='163' align='center'>";
		echo "$nu[0]";
        echo "</td>";
?>
</tr>
 </table>   
      </form> 
	  
  <table width="678" border="1" align="center">
  
	  <?php		
					$sql2="SELECT sum( i.monto_pago_ingreso )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso1']."' and i.fecha_ingreso<='".$_GET['fechaingreso2']."' ";
					$propiet=consultaDB($sql2);			
					$numero = mysql_num_rows($propiet);			
						$propietario=mysql_fetch_array($propiet);						
						//	echo "</tr>";						
						?>
  
    <td width="500">Suma de Ingresos:</td>
    <td width="162" align="center" b><?=$propietario[0];?></td>
    </table>
	  </td>
  </tr>
  
</table>

<div align="center">
  <input type=button value="Imprimir" name="Print11" onclick="printit()">
</div>
</body>
                                          

         
                

          <tr valign="top" align="left">
                      <td colspan="3" style="padding: 5px 0pt;">
                      <div class="main">
                      <div class="componentheading" align="center">

	Bienvenidos </div>
</div> 
                      </td>
          </tr>
          

                      </tbody></table>
                      </td>


         </tr>
</tbody></table> 
        
 [pie]               

         

</body></html>