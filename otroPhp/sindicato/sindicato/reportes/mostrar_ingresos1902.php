<html>
<head>
<title>Mostrar Ingresos por fecha</title>
<style media="print" type="text/css">
#imprimir {
visibility:hidden
}
</style>
<script language="JavaScript" src="../js/imprimir.js"></script>
<style type="text/css">
<!--
.Estilo1 {font-size: 14}

-->
</style>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../estilo.css" rel="stylesheet" type="text/css">

<style type="text/css">
<!--
body,td,th,tr {
	font-size: 16px;
}
td{
border:1px;
border-color:#000000;}
tr{
border:1px;
border-color:#000000;}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.Estilo2 {font-size: 16px}
-->
</style></head>
<body class="sub_body Estilo1">
		
		<span class="Estilo2"></span>
		<?php
		include("../librerias/my_lib.php");
		conectarDB();			
		$sql1="select * from tipo_ingreso";		
		$serv=consultaDB($sql1);
		$row=mysql_fetch_array($serv);		
		?>
		
  <table width="100%"  border="0">
        <tr> 
          <td height="10" colspan="2" align="center">
            <b class="titulo">INGRESOS<br>
            DEL 
			<?php 
			$fecha=$_GET['fechaingreso1']; // El formato que te entrega MySQL es Y-m-d 
             $fecha=date("d-m-Y",strtotime($fecha)); 
//echo $fecha 
            $fecha2=$_GET['fechaingreso2']; // El formato que te entrega MySQL es Y-m-d 
             $fecha2=date("d-m-Y",strtotime($fecha2)); 
			?>
            
            :<?php echo $fecha;?> AL :<?php echo $fecha2;?></b></td>
        </tr>
     
<form name="#" method="post" action="ParaInsertar.php">

<table width="1000" border="1" bordercolor="#000000" align="center" rules="cols">
<tr>
            <?php 
	 $sql1=" select saldo_tipo_bs from saldo where tipo_saldo='ingreso' and fecha_registro_saldo>='".$_GET['fechaingreso1']."' and fecha_registro_saldo<='".$_GET['fechaingreso2']."' ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);
 $sql2=" select saldo_tipo_dolar from saldo where tipo_saldo='ingreso' and fecha_registro_saldo>='".$_GET['fechaingreso1']."' and fecha_registro_saldo<='".$_GET['fechaingreso2']."' ";				
$nume=consultaDB($sql2);
$nue=mysql_fetch_array($nume);
$monto1=$nu['0'];
$monto2=$nue['0'];
		echo "<td width='650' size'2'>";
		//<b class="titulo">Ingreso por Ahorros <br></b>
		echo "<b class='titulo'>SALDO ANTERIOR<br></b> ";
        echo "</td>";
		echo "<td width='153' align='left'>";
		echo "$monto1 [Bs.]";
        
		echo "</td>";
		echo "<td width='156' align='center'>";
		echo "$monto2 [Sus]";
        echo "</td>";
?>
</tr>
</table>
        <table width="1000" border="1" bordercolor="#000000" align="center">
  <tr>
  <?php		
					$sql2="SELECT Min(i.numero_registro) from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso1']."' and i.fecha_ingreso<='".$_GET['fechaingreso2']."' ";
					$propiet=consultaDB($sql2);			
					$numero = mysql_num_rows($propiet);			
						$propietario=mysql_fetch_array($propiet);						
						//	echo "</tr>";						
						$sql3="SELECT Max(i.numero_registro) from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso1']."' and i.fecha_ingreso<='".$_GET['fechaingreso2']."' ";
					$propiet1=consultaDB($sql3);			
					$numero1 = mysql_num_rows($propiet1);			
						$propietario1=mysql_fetch_array($propiet1);	
						?>
    <td width="296" border="1" bordercolor="#000000"><span class="Estilo4">No RECIBO:</span></td>
    <td width="560" border="1" bordercolor="#000000">
      <?=$propietario[0];?>
      ------
      <?=$propietario1[0];?>    </td>
  </tr>
  </table>
		<table width="1000" border="1" align="center"   bordercolor="#000000" rules="cols" >
  <tr>
    <td width="340" height="31">INGRESO</td>
	<td width="51">.......</td>
    <td width="84">CANTIDAD</td>
	<td width="158">PRECIO UNITARIO</td>
    <td width="153">INGRESO[BS.]</td>
	<td width="156">INGRESO[$us.]</td>
  </tr>
</table>
  <table width="1000" border="1" bordercolor="#000000" align="center" rules="cols">
    <tr>
 
	 <?php 
	
$sql1="SELECT sum( i.monto_ingreso_dolar )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso1']."' and i.fecha_ingreso<='".$_GET['fechaingreso2']."' and i.id_tipo_ingreso='10'  ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);
$sql="SELECT ti.tipo_ingreso, ti.monto_tipo_dolar, i.monto_ingreso_dolar from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso1']."' and i.fecha_ingreso<='".$_GET['fechaingreso2']."' and i.id_tipo_ingreso='10' ";
 
  $res = consultaDB($sql);			
  $r=mysql_fetch_array($res);
		echo "<td width='340'>";
		echo "Venta del sindicato Linea 132";
        echo "</td width>";
		echo "<td width='51'>";
		/*echo "$nu[1]";*/
		echo "</td>";
		echo "<td width='84'>";
		echo "$nu[1]";
		echo "</td>";
		echo "<td align='center' width='158'>";
		echo "$r[1]  $";
        echo "</td>";
		echo "<td align='center' width='153'>";
		echo "</td>";
		echo "<td align='center' width='156'>";
		echo "$nu[0]   $";
       	echo "</td>";
?>
    </tr>
  </table>  

  <table width="1000" border="1" bordercolor="#000000" align="center" rules="cols">
    <tr>
 
	 <?php 
	 	
$sql1="SELECT sum( i.monto_ingreso_dolar )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso1']."' and i.fecha_ingreso<='".$_GET['fechaingreso2']."' and i.id_tipo_ingreso='1'  ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);
$sql="SELECT ti.tipo_ingreso, ti.monto_tipo_dolar, i.monto_ingreso_dolar from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso1']."' and i.fecha_ingreso<='".$_GET['fechaingreso2']."' and i.id_tipo_ingreso='1' ";
 
  $res = consultaDB($sql);			
  $r=mysql_fetch_array($res);
		echo "<td width='340'>";
		echo "Cambio de Nombre -Linea 132";
        echo "</td width>";
		echo "<td width='51'>";
		/*echo "$nu[1]";*/
		echo "</td>";
		echo "<td width='84'>";
		echo "$nu[1]";
		echo "</td>";
		echo "<td align='center' width='158'>";
		echo "$r[1]  $";
        echo "</td>";
		echo "<td align='center' width='153'>";
		echo "</td>";
		echo "<td align='center' width='156'>";
		echo "$nu[0]   $";
       	echo "</td>";
?>
    </tr>
  </table>  
  
  
  
  
    <table width="1000" border="1" bordercolor="#000000" align="center" rules="cols">
	<tr>
            <?php 
	 $sql1="SELECT sum( i.monto_pago_ingreso )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso1']."' and i.fecha_ingreso<='".$_GET['fechaingreso2']."' and i.id_tipo_ingreso='9' ";				
$num=consultaDB($sql1);
//$row[1]
$nu=mysql_fetch_array($num);
$sql="SELECT ti.tipo_ingreso, ti.monto_tipo_ingreso, i.monto_pago_ingreso from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso1']."' and i.fecha_ingreso<='".$_GET['fechaingreso2']."' and i.id_tipo_ingreso='9'";
  $res = consultaDB($sql);			
  $r=mysql_fetch_array($res);
		echo "<td width='340'>";
		echo "Permiso Asamblea";
        echo "</td>";
		echo "<td width='51'>";
		/*echo "$nu[1]";*/
		echo "</td>";
		echo "<td width='84' align='left'>";
		echo "$nu[1]";
        echo "</td>";
		echo "<td width='158' align='center'>";
		echo "$r[2]";
        echo "</td>";
		echo "<td width='153' align='center'>";
		echo "$nu[0]";
        echo "</td>";
		echo "<td align='center' width='156'>";
		echo "</td>";
?>
</tr>
</table>
	
	
	<table width="1000" border="1" bordercolor="#000000" align="center" rules="cols">
	 <tr>
	        <?php 
	  $sql1="SELECT sum( i.monto_pago_ingreso )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso1']."' and i.fecha_ingreso<='".$_GET['fechaingreso2']."' and i.id_tipo_ingreso='3' ";				
$num=consultaDB($sql1);
//$row[1]
$nu=mysql_fetch_array($num);
$sql="SELECT ti.tipo_ingreso, ti.monto_tipo_ingreso, i.monto_pago_ingreso from ingreso i, tipo_ingreso ti, pertenece p, movil m, linea l where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.id_movil=p.id_movil and p.id_movil=m.id_movil and m.id_linea=l.id_linea and m.id_linea='2' and i.fecha_ingreso>='".$_GET['fechaingreso1']."' and i.fecha_ingreso<='".$_GET['fechaingreso2']."' and i.id_tipo_ingreso='3'  ";



/////////////////////----
  $res = consultaDB($sql);			
  $r=mysql_fetch_array($res);
		echo "<td width='340'>";
		echo "Falta a Asamblea ordinaria";
        echo "</td>";
		echo "<td width='51'>";
		/*echo "$nu[1]";*/
		echo "</td>";
		echo "<td width='84' align='left'>";
		echo "$nu[1]";
        echo "</td>";
		echo "<td width='158' align='center'>";
		echo "$r[2]";
        echo "</td>";
		echo "<td width='153' align='center'>";
		echo "$nu[0]";
        echo "</td>";
		echo "<td align='center' width='156'>";
		echo "</td>";
?>
    </tr>
</table>
	<table width="1000" border="1" bordercolor="#000000" align="center" rules="cols">
	<tr>
            <?php 
	 $sql1="SELECT sum( i.monto_pago_ingreso )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso1']."' and i.fecha_ingreso<='".$_GET['fechaingreso2']."' and ti.tipo_ingreso LIKE 'Atraso asamblea'  ";				
$num=consultaDB($sql1);
//$row[1]
$nu=mysql_fetch_array($num);
$sql="SELECT ti.tipo_ingreso, ti.monto_tipo_ingreso, i.monto_pago_ingreso from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso1']."' and i.fecha_ingreso<='".$_GET['fechaingreso2']."' and ti.tipo_ingreso LIKE 'Atraso asamblea'  ";
  $res = consultaDB($sql);			
  $r=mysql_fetch_array($res);
		echo "<td width='340'>";
		echo "Atraso asamblea ordinaria";
        echo "</td>";
		echo "<td width='51'>";
		/*echo "$nu[1]";*/
		echo "</td>";
		echo "<td width='84' align='left'>";
		echo "$nu[1]";
        echo "</td>";
		echo "<td width='158' align='center'>";
		echo "$r[2]";
        echo "</td>";
		echo "<td width='153' align='center'>";
		echo "$nu[0]";
        echo "</td>";
		echo "<td align='center' width='156'>";
		echo "</td>";
?>
</tr>
 </table>  
 <table width="1000" border="1" bordercolor="#000000" align="center" rules="cols">
            <?php 
	 $sql1="SELECT sum( i.monto_pago_ingreso )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti, pertenece p, movil m, linea l  where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.id_movil=p.id_movil and p.id_movil=m.id_movil and m.id_linea=l.id_linea and l.id_linea='2' and i.fecha_ingreso>='".$_GET['fechaingreso1']."' and i.fecha_ingreso<='".$_GET['fechaingreso2']."' and ti.id_tipo_ingreso ='2'  ";				
$num=consultaDB($sql1);
//$row[1]
$nu=mysql_fetch_array($num);
$sql="SELECT ti.tipo_ingreso, ti.monto_tipo_ingreso, i.monto_pago_ingreso, ti.monto_tipo_ingreso from ingreso i, tipo_ingreso ti, pertenece p, movil m, linea l where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.id_movil=p.id_movil and p.id_movil=m.id_movil and m.id_linea=l.id_linea and l.id_linea='2' and i.fecha_ingreso>='".$_GET['fechaingreso1']."' and i.fecha_ingreso<='".$_GET['fechaingreso2']."' and ti.id_tipo_ingreso ='2'  ";
  $res = consultaDB($sql);			
  $r=mysql_fetch_array($res);
 // $desgloce=$nu[0]/$r[3];
		echo "<td width='340'>";
		echo "Permiso trabajo Linea 132";
        echo "</td>";
		echo "<td width='51'>";
		/*echo "X $desgloce dias" ;*/
		echo "</td>";
		echo "<td width='84' align='left'>";
		echo "$nu[1]";
        echo "</td>";
		echo "<td width='158' align='center'>";
		echo "$r[3]";
        echo "</td>";
		echo "<td width='153' align='center'>";
		echo "$nu[0]";
        echo "</td>";
		echo "<td align='center' width='156'>";
		echo "</td>";
?>
</table> 
    
	
<table width="1000" border="1" bordercolor="#000000" align="center" rules="cols">
     <tr>
	        <?php 
	 $sql1="SELECT sum( i.monto_pago_ingreso )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti, pertenece p, movil m, linea l where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.id_movil=p.id_movil and p.id_movil=m.id_movil and m.id_linea=l.id_linea and m.id_linea='2' and i.fecha_ingreso>='".$_GET['fechaingreso1']."' and i.fecha_ingreso<='".$_GET['fechaingreso2']."' and i.id_tipo_ingreso='5'  ";				
$num=consultaDB($sql1);
//$row[1]
$nu=mysql_fetch_array($num);
$sql="SELECT ti.tipo_ingreso, ti.monto_tipo_ingreso, i.monto_pago_ingreso from ingreso i, tipo_ingreso ti, pertenece p, movil m, linea l where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.id_movil=p.id_movil and p.id_movil=m.id_movil and m.id_linea=l.id_linea and m.id_linea='2' and i.fecha_ingreso>='".$_GET['fechaingreso1']."' and i.fecha_ingreso<='".$_GET['fechaingreso2']."' and i.id_tipo_ingreso='5'  ";



/////////////////////
  $res = consultaDB($sql);			
  $r=mysql_fetch_array($res);
		echo "<td width='340'>";
		echo "Atraso al trabajo - Linea 132";
        echo "</td>";
		echo "<td width='51'>";
		/*echo "$nu[1]";*/
		echo "</td>";
		echo "<td width='84' align='left'>";
		echo "$nu[1]";
        echo "</td>";
		echo "<td width='158' align='center'>";
		echo "$r[2]";
        echo "</td>";
		echo "<td width='153' align='center'>";
		echo "$nu[0]";
        echo "</td>";
		echo "<td align='center' width='156'>";
		echo "</td>";
?>
    </tr>
</table>
  <table width="1000" border="1" bordercolor="#000000" align="center" rules="cols">
	<tr>
            <?php 
	 $sql1="SELECT sum( i.monto_pago_ingreso )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso1']."' and i.fecha_ingreso<='".$_GET['fechaingreso2']."' and i.id_tipo_ingreso='17' ";				
$num=consultaDB($sql1);
//$row[1]
$nu=mysql_fetch_array($num);
$sql="SELECT ti.tipo_ingreso, ti.monto_tipo_ingreso, i.monto_pago_ingreso from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso1']."' and i.fecha_ingreso<='".$_GET['fechaingreso2']."' and i.id_tipo_ingreso='17'";
  $res = consultaDB($sql);			
  $r=mysql_fetch_array($res);
		echo "<td width='340'>";
		echo "Aporte Cajas de Cerveza";
        echo "</td>";
		echo "<td width='51'>";
		/*echo "$nu[1]";*/
		echo "</td>";
		echo "<td width='84' align='left'>";
		echo "$nu[1]";
        echo "</td>";
		echo "<td width='158' align='center'>";
		echo "$r[2]";
        echo "</td>";
		echo "<td width='153' align='center'>";
		echo "$nu[0]";
        echo "</td>";
		echo "<td align='center' width='156'>";
		echo "</td>";
?>
</tr>
</table>
	
<table width="1000" border="1" bordercolor="#000000" align="center" rules="cols">
    <tr>
 
	 <?php 
	 	
$sql1="SELECT sum( i.monto_ingreso_dolar )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso1']."' and i.fecha_ingreso<='".$_GET['fechaingreso2']."' and i.id_tipo_ingreso='22'  ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);
$sql="SELECT ti.tipo_ingreso, ti.monto_tipo_dolar, i.monto_ingreso_dolar from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso1']."' and i.fecha_ingreso<='".$_GET['fechaingreso2']."' and i.id_tipo_ingreso='22' ";
 
  $res = consultaDB($sql);			
  $r=mysql_fetch_array($res);
		echo "<td width='340'>";
		echo "Pago 2da Herramienta";
        echo "</td width>";
		echo "<td width='51'>";
		/*echo "$nu[1]";*/
		echo "</td>";
		echo "<td width='84'>";
		echo "$nu[1]";
		echo "</td>";
		echo "<td align='center' width='158'>";
	/*	echo "$r[1]  $";*/
	   	echo "  $";
        echo "</td>";
		echo "<td align='center' width='153'>";
		echo "</td>";
		echo "<td align='center' width='156'>";
		echo "$nu[0]   $";
       	echo "</td>";
?>
    </tr>
  </table>  
  <table width="1000" border="1" bordercolor="#000000" align="center" rules="cols">
	<tr>
            <?php 
	 $sql1="SELECT sum( i.monto_pago_ingreso )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso1']."' and i.fecha_ingreso<='".$_GET['fechaingreso2']."' and i.id_tipo_ingreso='21' ";				
$num=consultaDB($sql1);
//$row[1]
$nu=mysql_fetch_array($num);
$sql="SELECT ti.tipo_ingreso, ti.monto_tipo_ingreso, i.monto_pago_ingreso from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso1']."' and i.fecha_ingreso<='".$_GET['fechaingreso2']."' and i.id_tipo_ingreso='21'";
  $res = consultaDB($sql);			
  $r=mysql_fetch_array($res);
		echo "<td width='340'>";
		echo "Gastos Varios";
        echo "</td>";
		echo "<td width='51'>";
		/*echo "$nu[1]";*/
		echo "</td>";
		echo "<td width='84' align='left'>";
		echo "$nu[1]";
        echo "</td>";
		echo "<td width='158' align='center'>";
		echo "$r[2]";
        echo "</td>";
		echo "<td width='153' align='center'>";
		echo "$nu[0]";
        echo "</td>";
		echo "<td align='center' width='156'>";
		echo "</td>";
?>
</tr>
</table>

   <table width="1000" border="1" bordercolor="#000000" align="center" rules="cols">
	<tr>
            <?php 
	 $sql1="SELECT sum( i.monto_pago_ingreso )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso1']."' and i.fecha_ingreso<='".$_GET['fechaingreso2']."' and i.id_tipo_ingreso='25' ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);
$sql="SELECT ti.tipo_ingreso, ti.monto_tipo_ingreso, i.monto_pago_ingreso from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso1']."' and i.fecha_ingreso<='".$_GET['fechaingreso2']."' and i.id_tipo_ingreso='25'";
  $res = consultaDB($sql);			
  $r=mysql_fetch_array($res);
		echo "<td width='340'>";
		echo "Alquiler Tienda";
        echo "</td>";
		echo "<td width='51'>";
		/*echo "$nu[1]";*/
		echo "</td>";
		echo "<td width='84' align='left'>";
		echo "$nu[1]";
        echo "</td>";
		echo "<td width='158' align='center'>";
		echo "$r[2]";
        echo "</td>";
		echo "<td width='153' align='center'>";
		echo "$nu[0]";
        echo "</td>";
		echo "<td align='center' width='156'>";
		echo "</td>";
?>
</tr>
</table>
 <table width="1000" border="1" bordercolor="#000000" align="center" rules="cols">
	<tr>
            <?php 
	 $sql1="SELECT sum( i.monto_pago_ingreso )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso1']."' and i.fecha_ingreso<='".$_GET['fechaingreso2']."' and i.id_tipo_ingreso='27' ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);
$sql="SELECT ti.tipo_ingreso, ti.monto_tipo_ingreso, i.monto_pago_ingreso from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso1']."' and i.fecha_ingreso<='".$_GET['fechaingreso2']."' and i.id_tipo_ingreso='27'";
  $res = consultaDB($sql);			
  $r=mysql_fetch_array($res);
		echo "<td width='340'>";
		echo "APORTES";
        echo "</td>";
		echo "<td width='51'>";
		/*echo "$nu[1]";*/
		echo "</td>";
		echo "<td width='84' align='left'>";
		echo "$nu[1]";
        echo "</td>";
		echo "<td width='158' align='center'>";
		echo "$r[2]";
        echo "</td>";
		echo "<td width='153' align='center'>";
		echo "$nu[0]";
        echo "</td>";
		echo "<td align='center' width='156'>";
		echo "</td>";
?>
</tr>
</table>
 <table width="1000" border="1" bordercolor="#000000" align="center" rules="cols">
    <tr>
 
	 <?php 
	
$sql1="SELECT sum( i.monto_ingreso_dolar )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso1']."' and i.fecha_ingreso<='".$_GET['fechaingreso2']."' and i.id_tipo_ingreso='31'  ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);
$sql="SELECT ti.tipo_ingreso, ti.monto_tipo_dolar, i.monto_ingreso_dolar from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso1']."' and i.fecha_ingreso<='".$_GET['fechaingreso2']."' and i.id_tipo_ingreso='31' ";
 
  $res = consultaDB($sql);			
  $r=mysql_fetch_array($res);
		echo "<td width='340'>";
		echo "Venta de linea 132";
        echo "</td width>";
		echo "<td width='51'>";
		/*echo "$nu[1]";*/
		echo "</td>";
		echo "<td width='84'>";
		echo "$nu[1]";
		echo "</td>";
		echo "<td align='center' width='158'>";
		echo "$r[1]  $";
        echo "</td>";
		echo "<td align='center' width='153'>";
		echo "</td>";
		echo "<td align='center' width='156'>";
		echo "$nu[0]   $";
       	echo "</td>";
?>
    </tr>
  </table> 
 <table width="1000" border="1" bordercolor="#000000" align="center" rules="cols">
	<tr>
            <?php 
	 $sql1="SELECT sum( i.monto_pago_ingreso )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso1']."' and i.fecha_ingreso<='".$_GET['fechaingreso2']."' and i.id_tipo_ingreso='33' ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);
$sql="SELECT ti.tipo_ingreso, ti.monto_tipo_ingreso, i.monto_pago_ingreso from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso1']."' and i.fecha_ingreso<='".$_GET['fechaingreso2']."' and i.id_tipo_ingreso='33'";
  $res = consultaDB($sql);			
  $r=mysql_fetch_array($res);
		echo "<td width='340'>";
		echo "Falta a reuniones marchas y bloqueos";
        echo "</td>";
		echo "<td width='51'>";
		/*echo "$nu[1]";*/
		echo "</td>";
		echo "<td width='84' align='left'>";
		echo "$nu[1]";
        echo "</td>";
		echo "<td width='158' align='center'>";
		echo "$r[2]";
        echo "</td>";
		echo "<td width='153' align='center'>";
		echo "$nu[0]";
        echo "</td>";
		echo "<td align='center' width='156'>";
		echo "</td>";
?>
</tr>
</table>
   <table width="1000" border="1" bordercolor="#000000" align="center" rules="cols">
    <tr>
 
	 <?php 
	
$sql1="SELECT sum( i.monto_ingreso_dolar )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso1']."' and i.fecha_ingreso<='".$_GET['fechaingreso2']."' and i.id_tipo_ingreso='34'  ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);
$sql="SELECT ti.tipo_ingreso, ti.monto_tipo_dolar, i.monto_ingreso_dolar from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso1']."' and i.fecha_ingreso<='".$_GET['fechaingreso2']."' and i.id_tipo_ingreso='34' ";
 
  $res = consultaDB($sql);			
  $r=mysql_fetch_array($res);
		echo "<td width='340'>";
		echo "Aporte mes no trabajado";
        echo "</td width>";
		echo "<td width='51'>";
		/*echo "$nu[1]";*/
		echo "</td>";
		echo "<td width='84'>";
		echo "$nu[1]";
		echo "</td>";
		echo "<td align='center' width='158'>";
		echo "$r[1]  $";
        echo "</td>";
		echo "<td align='center' width='153'>";
		echo "</td>";
		echo "<td align='center' width='156'>";
		echo "$nu[0]   $";
       	echo "</td>";
?>
    </tr>
  </table> 
   <table width="1000" border="1" bordercolor="#000000" align="center" rules="cols">
    <tr>
 
	 <?php 
	
$sql1="SELECT sum( i.monto_pago_ingreso )  AS monto_total1,sum( i.monto_ingreso_dolar )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso1']."' and i.fecha_ingreso<='".$_GET['fechaingreso2']."'   ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);
$sql="SELECT ti.tipo_ingreso, ti.monto_tipo_dolar, i.monto_ingreso_dolar from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso1']."' and i.fecha_ingreso<='".$_GET['fechaingreso2']."' ";
   $res = consultaDB($sql);			
  $r=mysql_fetch_array($res);
		echo "<td width='340'>";
		echo "Total de Ingresos Varios";
        echo "</td width>";
		echo "<td width='51'>";
		
		echo "</td>";
		echo "<td width='84'>";
	//	echo "$nu[1]";
		echo "</td>";
		echo "<td align='center' width='158'>";
	//	echo "$r[1]  $";
        echo "</td>";
		echo "<td align='center' width='153'>";
	   echo "$nu[0]   BS";
		echo "</td>";
		echo "<td align='center' width='156'>";
		echo "$nu[1]   $";
       	echo "</td>";
?>
    </tr>
  </table> 
  
	<div align="center">


<table width="200" border="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</div>

  <table width="1000" border="1" bordercolor="#000000" align="center" rules="cols">
	<tr>
	<td height="10"  colspan="2" align="left">
	
  <b class="titulo">INGRESO POR ALQUILERES DEL SINDICATO<br></b></td></tr></table>
  <table width="1000" border="1" bordercolor="#000000" align="center">
	<tr>
            <?php 
	 $sql1="SELECT sum( i.monto_pago_ingreso )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso1']."' and i.fecha_ingreso<='".$_GET['fechaingreso2']."' and i.id_tipo_ingreso='7'  ";				
$num=consultaDB($sql1);
//$row[1]
$nu=mysql_fetch_array($num);
$sql="SELECT ti.tipo_ingreso, ti.monto_tipo_ingreso, i.monto_pago_ingreso from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso1']."' and i.fecha_ingreso<='".$_GET['fechaingreso2']."' and i.id_tipo_ingreso='7'  ";
  $res = consultaDB($sql);			
  $r=mysql_fetch_array($res);
		echo "<td width='340'>";
		echo "Alquiler de linea al sindicato (DIVIDENDOS)";
        echo "</td>";
		echo "<td width='51'>";
		/*echo "$nu[1]";*/
		echo "</td>";
		echo "<td width='84' align='left'>";
		echo "$nu[1]";
        echo "</td>";
		echo "<td width='158' align='center'>";
		echo "$r[2]";
        echo "</td>";
		echo "<td width='153' align='center'>";
		echo "$nu[0]";
        echo "</td>";
		echo "<td align='center' width='156'>";
		echo "</td>";
?>
</tr>
 </table>   
<div align="center">


<table width="200" border="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</div> 
  <div align="center">


<table width="200" border="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</div>
<table width="1000" border="1" bordercolor="#000000" align="center" rules="cols">
	<tr>
	<td height="10"  colspan="2" align="left">
	
  <b class="titulo">TOTAL DE INGRESOS HOJAS DE CONTROL<br>
  </b></td></tr></table>	

<table width="1000" border="1" bordercolor="#000000" align="center" rules="cols">

  
<tr>
<?php		
					$sql2="SELECT Min(i.numero_hoja) from hoja_control i where fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";
					$propiet=consultaDB($sql2);			
					$numero = mysql_num_rows($propiet);			
						$propietario=mysql_fetch_array($propiet);						
						//	echo "</tr>";						
						$sql3="SELECT Max(i.numero_hoja) from hoja_control i where fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";
					$propiet1=consultaDB($sql3);			
					$numero1 = mysql_num_rows($propiet1);			
						$propietario1=mysql_fetch_array($propiet1);	
			$sql1=" select sum(total_hoja) as totalDia, COUNT( numero_hoja ) AS numero from hoja_control where fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
$num=consultaDB($sql1);
//$row[1]
$nu=mysql_fetch_array($num);


						$impre=($propietario1['0'])-($propietario['0']);
						$falla=$impre-$nu['1'] +1;
						
						
						?>
<?php echo "<td width='300'>";
		echo "LINEAS(132)";
        echo "</td>";
		echo "<td width='400'>";
		echo "No Recibo($propietario[0]--$propietario1[0])......F.Imp.($falla)   ";
		echo "</td>";
		echo "<td width='76'>";
		echo "$nu[1]";
        echo "</td>";
		echo "<td width='450' align='center'>";
		echo "$nu[0]";
        echo "</td>";
		?></tr>
  
  
<tr>
              <?php 
	//$sql1=" select sum(tt.monto_transaccion)as aporte, COUNT( numero_hoja ) AS numero from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='2' and tt.id_tipo_transaccion='1'and t.estado='Activo'and fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
//$num=consultaDB($sql1);
	 $sql1=" select sum(h.aporte)as aporte, COUNT( numero_hoja ) AS numero from linea l, movil m, hoja_control h where l.id_linea=m.id_linea and m.id_movil=h.id_movil and  fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
$num=consultaDB($sql1);

$nu=mysql_fetch_array($num);

 $sql2=" select sum(tt.monto_transaccion)as aporte, COUNT( numero_hoja ) AS numero from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='1' and tt.id_tipo_transaccion='1'and t.estado='Activo'and fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
$num1=consultaDB($sql2);
$nu1=mysql_fetch_array($num1);

$cantidad=$nu['1']+ $nu1['1'];
$monto=$nu['0']+ $nu1['0'];


		echo "<td width='250'>";
		echo "TOTAL APORTE SINDICATO ";
        echo "</td>";
		echo "<td width='300'>";
		echo "</td>";
		echo "<td width='150' align='left'>";
	    echo "$nu[1]";
        echo "</td>";
		echo "<td width='300X' align='center'>";
		echo "$nu[0]";
        echo "</td>";
?>
</tr>

<tr>
              <?php 
//	$sql1=" select sum(tt.monto_transaccion)as aporte, COUNT( numero_hoja ) AS numero from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='2' and tt.id_tipo_transaccion='4'and t.estado='Activo'and fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
//$num=consultaDB($sql1);
$sql1=" select sum(h.adeporte)as aporte, COUNT( numero_hoja ) AS numero from linea l, movil m, hoja_control h where l.id_linea=m.id_linea and m.id_movil=h.id_movil and  fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
$num=consultaDB($sql1);

$nu=mysql_fetch_array($num);

 $sql2=" select sum(tt.monto_transaccion)as aporte, COUNT( numero_hoja ) AS numero from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='1' and tt.id_tipo_transaccion='4'and t.estado='Activo'and fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
$num1=consultaDB($sql2);
//$nu1=mysql_fetch_array($num1);

//$cantidad=$nu['1']+ $nu1['1'];
//$monto=$nu['0']+ $nu1['0'];

		echo "<td width='250'>";
		echo "PRO-DEPORTE (131-132)";
        echo "</td>";
		echo "<td width='300'>";
		//echo "$nume[0]";
        echo "</td>";
		echo "<td width='150' align='left'>";
		echo "$nu[1]";
        echo "</td>";
		echo "<td width='300X' align='center'>";
		echo "$nu[0]";
        echo "</td>";
?>
</tr>
<tr>
              <?php 
	//$sql1=" select sum(tt.monto_transaccion)as aporte, COUNT( numero_hoja ) AS numero from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='2' and tt.id_tipo_transaccion='1'and t.estado='Activo'and fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
//$num=consultaDB($sql1);
	 $sql1=" select sum(h.acumple)as aporte, COUNT( numero_hoja ) AS numero from linea l, movil m, hoja_control h where l.id_linea=m.id_linea and m.id_movil=h.id_movil and  fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' and h.acumple!='0.00'";				
$num=consultaDB($sql1);
//echo $sql1;
$nu=mysql_fetch_array($num);

 //$sql2=" select sum(tt.monto_transaccion)as aporte, COUNT( numero_hoja ) AS numero from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='2' and tt.id_tipo_transaccion='11'and t.estado='Activo' and fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
//$num1=consultaDB($sql2);
//$nu1=mysql_fetch_array($num1);

$cantidad=$nu['1']+ $nu1['1'];
$monto=$nu['0']+ $nu1['0'];


		echo "<td width='250'>";
		echo "TOTAL PRO CUMPLEAÑOS ";
        echo "</td>";
		echo "<td width='300'>";
		echo "</td>";
		echo "<td width='150' align='left'>";
	    echo "$nu[1]";
        echo "</td>";
		echo "<td width='300X' align='center'>";
		echo "$nu[0]";
        echo "</td>";
?>
</tr>
	<tr>
            <?php 
	 $sql1=" select sum(total_hoja) as totalDia,  COUNT( numero_hoja ) AS numero from hoja_control where fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);
$sql1=" select sum(tt.monto_transaccion)as aporte from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='2' and tt.id_tipo_transaccion='1'and t.estado='Activo'and fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
$num4=consultaDB($sql1);
$nu4=mysql_fetch_array($num4);

 $sql2=" select sum(tt.monto_transaccion)as aporte from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='1' and tt.id_tipo_transaccion='1'and t.estado='Activo'and fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
$num1=consultaDB($sql2);
$nu1=mysql_fetch_array($num1);
$monto=$nu4['0']+ $nu1['0'];

//$sql1=" select sum(tt.monto_transaccion)as aporte from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='2' and tt.id_tipo_transaccion='4'and t.estado='Activo'and fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
//$num2=consultaDB($sql1);
//$nu2=mysql_fetch_array($num2);

 //$sql2=" select sum(tt.monto_transaccion)as aporte from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='1' and tt.id_tipo_transaccion='4'and t.estado='Activo'and fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
//$num3=consultaDB($sql2);
//$nu3=mysql_fetch_array($num3);

$sql1=" select sum(h.aporte)as aporte, COUNT( numero_hoja ) AS numero from linea l, movil m, hoja_control h where l.id_linea=m.id_linea and m.id_movil=h.id_movil and  fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
$num=consultaDB($sql1);
$nu2=mysql_fetch_array($num);

$sql1=" select sum(h.adeporte)as aporte, COUNT( numero_hoja ) AS numero from linea l, movil m, hoja_control h where l.id_linea=m.id_linea and m.id_movil=h.id_movil and  fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
$num=consultaDB($sql1);
$nu3=mysql_fetch_array($num);

$sql1=" select sum(h.acumple)as aporte, COUNT( numero_hoja ) AS numero from linea l, movil m, hoja_control h where l.id_linea=m.id_linea and m.id_movil=h.id_movil and  fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
$num=consultaDB($sql1);
$nu4=mysql_fetch_array($num);

$monto1=$nu2['0']+ $nu3['0']+ $nu4['0'];
$total=$monto1;
		echo "<td width='300' size'2'>";
		echo "HOJAS VENDIDAS";
        echo "</td>";
		echo "<td width='200'>";
		echo "</td>";
		echo "<td width='76' align='left'>";
		echo "$nu[1]";
        echo "</td>";
		echo "<td width='450' align='center'>";
		echo "$total";
        echo "</td>";
?>
</tr>
</table>


<div align="center">
<table width="200" border="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</div>
	
<table width="1000" border="1" bordercolor="#000000" align="center">
	<tr>
	<td height="10"  colspan="2" align="left">
	
  <b class="titulo">TOTAL INGRESO HACIENDA <br>
  </b></td></tr></table>
  
<table width="1000" border="1" bordercolor="#000000" align="center" rules="cols">
  <tr align="left">
<?php echo "<td width='250'>";
		echo "LINEA 131/132";
        echo "</td>";
		echo "<td width='300'>";
		echo "No RECIBO";
        echo "</td>";
		echo "<td width='150'>";
		echo "INGRESO[BS.]";
        echo "</td>";
		echo "<td width='300' align='center'>";
		echo "INGRESO[Sus.]";
        echo "</td>";
		?></tr>


<tr> 
<?php		
					$sql2="SELECT Min(i.numero_registro) from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso1']."' and i.fecha_ingreso<='".$_GET['fechaingreso2']."' ";
					$propiet7=consultaDB($sql2);			
					$numero = mysql_num_rows($propiet7);			
						$propietario7=mysql_fetch_array($propiet7);						
						//	echo "</tr>";						
						$sql3="SELECT Max(i.numero_registro) from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso1']."' and i.fecha_ingreso<='".$_GET['fechaingreso2']."' ";
					$propiet8=consultaDB($sql3);			
					$numero1 = mysql_num_rows($propiet8);			
						$propietario8=mysql_fetch_array($propiet8);	
						?>
            <?php 
			$sql2="SELECT sum( i.monto_pago_ingreso )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso1']."' and i.fecha_ingreso<='".$_GET['fechaingreso2']."' ";
					$propiet=consultaDB($sql2);			
					$numero = mysql_num_rows($propiet);			
						$propietario=mysql_fetch_array($propiet);						
			$sql1="SELECT sum( i.monto_pago_ingreso )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso1']."' and i.fecha_ingreso<='".$_GET['fechaingreso2']."' and i.id_tipo_ingreso='7'  ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);
$prueba=$nu[0];

$prueba2=$propietario[0];
$propieta=($prueba2 - $prueba);
			
			/////
	// $sql2="SELECT sum( i.monto_pago_ingreso )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso1']."' and i.fecha_ingreso<='".$_GET['fechaingreso2']."' ";
		//			$propiet=consultaDB($sql2);			
			//		$numero = mysql_num_rows($propiet);			
				//		$propietario=mysql_fetch_array($propiet);						
						//	echo "</tr>";						
						$sql3="SELECT sum( i.monto_ingreso_dolar )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso1']."' and i.fecha_ingreso<='".$_GET['fechaingreso2']."' ";
					$propiet1=consultaDB($sql3);			
					$numero1 = mysql_num_rows($propiet1);			
						$propietario1=mysql_fetch_array($propiet1);	
		echo "<td width='250'>";
		echo "Ingresos Varios";
        echo "</td>";
		echo "<td width='300'>";
		echo "($propietario7[0]--$propietario8[0])";
        echo "</td>";
		echo "<td width='150' align='center'>";
		echo "$propieta.00";
        echo "</td>";
		echo "<td width='300' align='center'>";
		echo "$propietario1[0]";
        echo "</td>";
?>
</tr>
<tr>
<?php		
					$sql2="SELECT Min(i.numero_hoja) from hoja_control i where fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";
					$propiet=consultaDB($sql2);			
					$numero = mysql_num_rows($propiet);			
						$propietario=mysql_fetch_array($propiet);						
						//	echo "</tr>";						
						$sql3="SELECT Max(i.numero_hoja) from hoja_control i where fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";
					$propiet1=consultaDB($sql3);			
					$numero1 = mysql_num_rows($propiet1);			
						$propietario1=mysql_fetch_array($propiet1);	
						?>
            <?php 
	 $sql1=" select sum(total_hoja) as totalDia, COUNT( numero_hoja ) AS numero from hoja_control where fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
$num=consultaDB($sql1);
//$row[1]
$sql1=" select sum(tt.monto_transaccion)as aporte from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='2' and tt.id_tipo_transaccion='1'and t.estado='Activo'and fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
$num4=consultaDB($sql1);
$nu4=mysql_fetch_array($num4);

 $sql2=" select sum(tt.monto_transaccion)as aporte from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='1' and tt.id_tipo_transaccion='1'and t.estado='Activo'and fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
$num1=consultaDB($sql2);
$nu1=mysql_fetch_array($num1);
$monto=$nu4['0']+ $nu1['0'];

$sql1=" select sum(tt.monto_transaccion)as aporte from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='2' and tt.id_tipo_transaccion='4'and t.estado='Activo'and fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
$num2=consultaDB($sql1);
$nu2=mysql_fetch_array($num2);

 $sql2=" select sum(tt.monto_transaccion)as aporte from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='1' and tt.id_tipo_transaccion='4'and t.estado='Activo'and fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
$num3=consultaDB($sql2);
$nu3=mysql_fetch_array($num3);


$monto1=$nu2['0']+ $nu3['0'];
$total=$monto + $monto1;

$sql1=" select sum(h.aporte)as aporte, COUNT( numero_hoja ) AS numero from linea l, movil m, hoja_control h where l.id_linea=m.id_linea and m.id_movil=h.id_movil and  fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
$num=consultaDB($sql1);
$nu2=mysql_fetch_array($num);

$sql1=" select sum(h.adeporte)as aporte, COUNT( numero_hoja ) AS numero from linea l, movil m, hoja_control h where l.id_linea=m.id_linea and m.id_movil=h.id_movil and  fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
$num=consultaDB($sql1);
$nu3=mysql_fetch_array($num);
$sql1=" select sum(h.acumple)as aporte, COUNT( numero_hoja ) AS numero from linea l, movil m, hoja_control h where l.id_linea=m.id_linea and m.id_movil=h.id_movil and  fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
$num=consultaDB($sql1);
$nu4=mysql_fetch_array($num);

$monto1=$nu2['0']+ $nu3['0']+ $nu4['0'];
$total=$monto1;
		echo "<td width='250'>";
		echo "Hojas de Control";
        echo "</td>";
		echo "<td width='300'>";
		echo "($propietario[0]--$propietario1[0])";
        echo "</td>";
		echo "<td width='150' align='center'>";
		echo "$total.00";
        echo "</td>";
		echo "<td width='300' align='center'>";
		echo "-";
        echo "</td>";
?>
</tr>
<tr>
<?php		
					$sql2="SELECT Min(i.numero_hoja) from hoja_control i where fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";
					$propiet=consultaDB($sql2);			
					$numero = mysql_num_rows($propiet);			
						$propietario=mysql_fetch_array($propiet);						
						//	echo "</tr>";						
						$sql3="SELECT Max(i.numero_hoja) from hoja_control i where fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";
					$propiet1=consultaDB($sql3);			
					$numero1 = mysql_num_rows($propiet1);			
						$propietario1=mysql_fetch_array($propiet1);	
						?>
            <?php 
	 $sql1="SELECT sum( i.monto_pago_ingreso )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso1']."' and i.fecha_ingreso<='".$_GET['fechaingreso2']."' and i.id_tipo_ingreso='7'  ";				
$num=consultaDB($sql1);
//$row[1]
$nu=mysql_fetch_array($num);


$monto1=$nu2['0']+ $nu3['0'];
$total=$monto + $monto1;
		echo "<td width='250'>";
		echo "Ingreso por Alquileres";
        echo "</td>";
		echo "<td width='300'>";
	//	echo "($propietario[0]--$propietario1[0])";
        echo "</td>";
		echo "<td width='150' align='center'>";
		echo "$nu[0]";
        echo "</td>";
		echo "<td width='300' align='center'>";
		echo "-";
        echo "</td>";
?>
</tr>
<tr>
            <?php 
			 $sql1=" select sum(tt.monto_transaccion)as aporte from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='2' and tt.id_tipo_transaccion='1'and t.estado='Activo'and fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
$num4=consultaDB($sql1);
$nu4=mysql_fetch_array($num4);

 $sql2=" select sum(tt.monto_transaccion)as aporte from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='1' and tt.id_tipo_transaccion='1'and t.estado='Activo'and fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
$num1=consultaDB($sql2);
$nu1=mysql_fetch_array($num1);
$monto=$nu4['0']+ $nu1['0'];

$sql1=" select sum(tt.monto_transaccion)as aporte from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='2' and tt.id_tipo_transaccion='4'and t.estado='Activo'and fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
$num2=consultaDB($sql1);
$nu2=mysql_fetch_array($num2);

 $sql2=" select sum(tt.monto_transaccion)as aporte from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='1' and tt.id_tipo_transaccion='4'and t.estado='Activo'and fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
$num3=consultaDB($sql2);
$nu3=mysql_fetch_array($num3);


$monto1=$nu2['0']+ $nu3['0'];
$total=$monto + $monto1;

$sql1=" select sum(h.aporte)as aporte, COUNT( numero_hoja ) AS numero from linea l, movil m, hoja_control h where l.id_linea=m.id_linea and m.id_movil=h.id_movil and  fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
$num=consultaDB($sql1);
$nu2=mysql_fetch_array($num);

$sql1=" select sum(h.adeporte)as aporte, COUNT( numero_hoja ) AS numero from linea l, movil m, hoja_control h where l.id_linea=m.id_linea and m.id_movil=h.id_movil and  fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
$num=consultaDB($sql1);
$nu3=mysql_fetch_array($num);
$sql1=" select sum(h.acumple)as aporte, COUNT( numero_hoja ) AS numero from linea l, movil m, hoja_control h where l.id_linea=m.id_linea and m.id_movil=h.id_movil and  fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
$num=consultaDB($sql1);
$nu4=mysql_fetch_array($num);

$monto1=$nu2['0']+ $nu3['0']+ $nu4['0'];
$total=$monto1;

	$sql2="SELECT sum( i.monto_pago_ingreso )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso1']."' and i.fecha_ingreso<='".$_GET['fechaingreso2']."' ";
					$propiet=consultaDB($sql2);			
					$numero = mysql_num_rows($propiet);			
						$propietario=mysql_fetch_array($propiet);		
//	$suma=($nu[0]+$propietario[0]);					
    $suma=($total+$propietario[0]);					

$sql3="SELECT sum( i.monto_ingreso_dolar )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso1']."' and i.fecha_ingreso<='".$_GET['fechaingreso2']."' ";
					$propiet1=consultaDB($sql3);			
					$numero1 = mysql_num_rows($propiet1);			
						$propietario1=mysql_fetch_array($propiet1);	
		echo "<td width='250'>";
		echo "TOTAL ";
        echo "</td>";
		echo "<td width='300'>";
		echo "-";
        echo "</td>";
		echo "<td width='150' align='center'>";
		echo "$suma  [BS.]";
        echo "</td>";
		echo "<td width='300' align='center'>";
		echo "$propietario1[0] [Sus.]";
        echo "</td>";
?>
</tr>
<tr>
            <?php 
			 $sql1=" select sum(tt.monto_transaccion)as aporte from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='2' and tt.id_tipo_transaccion='1'and t.estado='Activo'and fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
$num4=consultaDB($sql1);
$nu4=mysql_fetch_array($num4);

 $sql2=" select sum(tt.monto_transaccion)as aporte from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='1' and tt.id_tipo_transaccion='1'and t.estado='Activo'and fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
$num1=consultaDB($sql2);
$nu1=mysql_fetch_array($num1);
$monto=$nu4['0']+ $nu1['0'];

$sql1=" select sum(tt.monto_transaccion)as aporte from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='2' and tt.id_tipo_transaccion='4'and t.estado='Activo'and fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
$num2=consultaDB($sql1);
$nu2=mysql_fetch_array($num2);

 $sql2=" select sum(tt.monto_transaccion)as aporte from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='1' and tt.id_tipo_transaccion='4'and t.estado='Activo'and fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
$num3=consultaDB($sql2);
$nu3=mysql_fetch_array($num3);


$monto1=$nu2['0']+ $nu3['0'];
$total=$monto + $monto1;

$sql1=" select sum(h.aporte)as aporte, COUNT( numero_hoja ) AS numero from linea l, movil m, hoja_control h where l.id_linea=m.id_linea and m.id_movil=h.id_movil and  fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
$num=consultaDB($sql1);
$nu2=mysql_fetch_array($num);

$sql1=" select sum(h.adeporte)as aporte, COUNT( numero_hoja ) AS numero from linea l, movil m, hoja_control h where l.id_linea=m.id_linea and m.id_movil=h.id_movil and  fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
$num=consultaDB($sql1);
$nu3=mysql_fetch_array($num);
$sql1=" select sum(h.acumple)as aporte, COUNT( numero_hoja ) AS numero from linea l, movil m, hoja_control h where l.id_linea=m.id_linea and m.id_movil=h.id_movil and  fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
$num=consultaDB($sql1);
$nu4=mysql_fetch_array($num);

$monto1=$nu2['0']+ $nu3['0']+ $nu4['0'];
$total=$monto1;

	$sql2="SELECT sum( i.monto_pago_ingreso )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso1']."' and i.fecha_ingreso<='".$_GET['fechaingreso2']."' ";
					$propiet=consultaDB($sql2);			
					$numero = mysql_num_rows($propiet);			
						$propietario=mysql_fetch_array($propiet);		
//	$suma=($nu[0]+$propietario[0]);					
    $suma=($total+$propietario[0]);					

$sql3="SELECT sum( i.monto_ingreso_dolar )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso1']."' and i.fecha_ingreso<='".$_GET['fechaingreso2']."' ";
					$propiet1=consultaDB($sql3);			
					$numero1 = mysql_num_rows($propiet1);			
						$propietario1=mysql_fetch_array($propiet1);	
						//saldo anterior
						$sql1=" select saldo_tipo_bs from saldo where tipo_saldo='ingreso' and fecha_registro_saldo>='".$_GET['fechaingreso1']."' and fecha_registro_saldo<='".$_GET['fechaingreso2']."' ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);
 $sql2=" select saldo_tipo_dolar from saldo where tipo_saldo='ingreso' and fecha_registro_saldo>='".$_GET['fechaingreso1']."' and fecha_registro_saldo<='".$_GET['fechaingreso2']."' ";				
$nume=consultaDB($sql2);
$nue=mysql_fetch_array($nume);
$monto1=$nu['0'];
$monto2=$nue['0'];
						//fin saldo anterior
						
	  $suma1= $suma+$monto1;
	    $propietario=$propietario1[0];	
		$propietario2=$propietario+$monto2;				
		echo "<td width='250'>";
		echo "TOTAL + Saldo Anterior";
        echo "</td>";
		echo "<td width='300'>";
		echo "-";
        echo "</td>";
		echo "<td width='150' align='center'>";
		echo "$suma1.00  [BS.]";
        echo "</td>";
		echo "<td width='300' align='center'>";
		echo "$propietario2.00 [Sus.]";
        echo "</td>";
?>
</tr>
<div align="center">


<table width="200" border="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</div>

  <table width="1000" border="1" bordercolor="#000000" align="center" rules="cols">
	<tr>
	<td height="10"  colspan="2" align="left">
	
  <b class="titulo">INGRESO POR AHORROS <br></b></td></tr></table>

  
  
  
<table width="1000" border="1" bordercolor="#000000" align="center" rules="cols">
  <tr align="left">
<?php echo "<td width='250'>";
		echo "LINEA 132";
        echo "</td>";
		echo "<td width='300'>";
		echo "COSTO UNITARIO";
        echo "</td>";
		echo "<td width='150'>";
		echo "CANTIDAD";
        echo "</td>";
		echo "<td width='300'>";
		echo "MONTO INGRESO";
        echo "</td>";
		?></tr>
<tr>
            <?php 
//	 $sql1=" select sum(tt.monto_transaccion)as aporte, COUNT( numero_hoja ) AS numero from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='1' and tt.id_tipo_transaccion='2' and h.total_hoja='15.00' and t.estado='Activo'and fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
//$num=consultaDB($sql1);
	 $sql1=" select sum(h.asocio)as aporte, COUNT( numero_hoja ) AS numero from linea l, movil m, hoja_control h where l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='2' and h.asocio='5.00' and fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
$num=consultaDB($sql1);

//$row[1]
$nu=mysql_fetch_array($num);
$sql2=" select tt.monto_transaccion from tipo_transaccion tt,linea l, movil m, hoja_control h where l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='2' and tt.id_tipo_transaccion='6' and fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
$nume=consultaDB($sql2);
//$row[1]
$num=mysql_fetch_array($nume);
		echo "<td width='250'>";
		echo "Ahorro Socio Diario";
        echo "</td>";
		echo "<td width='300'>";
		echo "5.00";
        echo "</td>";
		echo "<td width='150' align='left'>";
		echo "$nu[1]";
        echo "</td>";
		echo "<td width='300' align='center'>";
		echo "$nu[0]";
        echo "</td>";
?>
</tr>

<tr>
            <?php 
//	 $sql1=" select sum(tt.monto_transaccion)as aporte, COUNT( numero_hoja ) AS numero from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='1' and tt.id_tipo_transaccion='2' and h.total_hoja='15.00' and t.estado='Activo'and fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
//$num=consultaDB($sql1);
	 $sql1=" select sum(h.asocio)as aporte, COUNT( numero_hoja ) AS numero from linea l, movil m, hoja_control h where l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='2' and h.asocio='4.00' and fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
$num=consultaDB($sql1);

//$row[1]
$nu=mysql_fetch_array($num);
$sql2=" select tt.monto_transaccion from tipo_transaccion tt,linea l, movil m, hoja_control h where l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='2' and tt.id_tipo_transaccion='6' and fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
$nume=consultaDB($sql2);
//$row[1]
$num=mysql_fetch_array($nume);
		echo "<td width='250'>";
		echo "Ahorro Socio Hojas Falta";
        echo "</td>";
		echo "<td width='300'>";
		echo "4.00";
        echo "</td>";
		echo "<td width='150' align='left'>";
		echo "$nu[1]";
        echo "</td>";
		echo "<td width='300' align='center'>";
		echo "$nu[0]";
        echo "</td>";
?>
</tr>
<tr>
            <?php 
			 $sql1=" select sum(h.achofer)as aporte, COUNT( numero_hoja ) AS numero from linea l, movil m, hoja_control h where l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='2' and h.achofer='4.00' and fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
$num=consultaDB($sql1);

	// $sql1=" select sum(tt.monto_transaccion)as aporte, COUNT( numero_hoja ) AS numero from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and l.id_linea='1' and h.total_hoja='15.00' and m.id_movil=h.id_movil and tt.id_tipo_transaccion='3'and t.estado='Activo'and fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
//$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);

$sql2=" select tt.monto_transaccion from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='1' and tt.id_tipo_transaccion='3'and h.total_hoja='15.00' and t.estado='Activo'and fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
$nume=consultaDB($sql2);
$nume=mysql_fetch_array($nume);

		echo "<td width='250'>";
		echo "Ahorro Choferes Hojas Falta";
        echo "</td>";
		echo "<td width='300'>";
		echo "4.00";
        echo "</td>";
		echo "<td width='150' align='left'>";
		echo "$nu[1]";
        echo "</td>";
		echo "<td width='300' align='center'>";
		echo "$nu[0]";
        echo "</td>";
?>
</tr>
<tr>
            <?php 
	 $sql1=" select sum(total_hoja) as totalDia,  COUNT( numero_hoja ) AS numero from hoja_control h,movil m where h.id_movil=m.id_movil and m.id_linea='2' and h.total_hoja='15.00' and fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);

 $sql1=" select sum(h.achofer)as aporte, COUNT( numero_hoja ) AS numero from linea l, movil m, hoja_control h where l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='2' and fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
$num4=consultaDB($sql1);
//$sql1=" select sum(tt.monto_transaccion)as aporte from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='1' and tt.id_tipo_transaccion='2'and h.total_hoja='15.00' and t.estado='Activo'and fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
//$num4=consultaDB($sql1);
$nu4=mysql_fetch_array($num4);
$monto=$nu4['0'];

//$sql1=" select sum(tt.monto_transaccion)as aporte from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='1' and h.total_hoja='15.00' and tt.id_tipo_transaccion='3'and t.estado='Activo'and fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
//$num2=consultaDB($sql1);
 $sql1=" select sum(h.asocio)as aporte, COUNT( numero_hoja ) AS numero from linea l, movil m, hoja_control h where l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='2' and fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
$num2=consultaDB($sql1);
$nu2=mysql_fetch_array($num2);
$monto1=$nu2['0'];

// $sql1=" select sum(h.achofer)as aporte, COUNT( numero_hoja ) AS numero from linea l, movil m, hoja_control h where l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='1' and fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
//$num=consultaDB($sql1);



$total=$monto + $monto1;
		echo "<td width='250' size'2'>";
		echo "TOTAL AHORROS LINEA 132";
        echo "</td>";
		echo "<td width='300'>";
		echo "-";
		echo "</td>";
		echo "<td width='150' align='left'>";
		echo "$nu[1]";
        echo "</td>";
		echo "<td width='300' align='center'>";
		echo "$total";
        echo "</td>";
?>
</tr>
</table>
 
 <table width="1000" border="1" bordercolor="#000000" align="center" rules="cols">
<tr>
            <?php 
	 $sql1=" select sum(total_hoja) as totalDia,  COUNT( numero_hoja ) AS numero from hoja_control where total_hoja='15.00' and fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);

$sql1=" select sum(tt.monto_transaccion)as aporte from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='2' and h.total_hoja='15.00' and tt.id_tipo_transaccion='2'and t.estado='Activo'and fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
$num4=consultaDB($sql1);
$nu4=mysql_fetch_array($num4);

 $sql2=" select sum(tt.monto_transaccion)as aporte from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='1' and h.total_hoja='15.00' and tt.id_tipo_transaccion='2'and t.estado='Activo'and fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
$num1=consultaDB($sql2);
$nu1=mysql_fetch_array($num1);
$monto=$nu4['0']+ $nu1['0'];

$sql1=" select sum(tt.monto_transaccion)as aporte from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='2' and h.total_hoja='15.00' and tt.id_tipo_transaccion='3'and t.estado='Activo'and fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
$num2=consultaDB($sql1);
$nu2=mysql_fetch_array($num2);

 $sql2=" select sum(tt.monto_transaccion)as aporte from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='1' and h.total_hoja='15.00' and tt.id_tipo_transaccion='3'and t.estado='Activo'and fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
$num3=consultaDB($sql2);
$nu3=mysql_fetch_array($num3);


$monto1=$nu2['0']+ $nu3['0'];

$sql1=" select sum(h.achofer)as aporte, COUNT( numero_hoja ) AS numero from linea l, movil m, hoja_control h where l.id_linea=m.id_linea and m.id_movil=h.id_movil and fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
$num4=consultaDB($sql1);
//$sql1=" select sum(tt.monto_transaccion)as aporte from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='1' and tt.id_tipo_transaccion='2'and h.total_hoja='15.00' and t.estado='Activo'and fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
//$num4=consultaDB($sql1);
$nu4=mysql_fetch_array($num4);
$monto=$nu4['0'];

//$sql1=" select sum(tt.monto_transaccion)as aporte from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='1' and h.total_hoja='15.00' and tt.id_tipo_transaccion='3'and t.estado='Activo'and fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
//$num2=consultaDB($sql1);
 $sql1=" select sum(h.asocio)as aporte, COUNT( numero_hoja ) AS numero from linea l, movil m, hoja_control h where l.id_linea=m.id_linea and m.id_movil=h.id_movil and fecha_de_compra>='".$_GET['fechaingreso1']."' and fecha_de_compra<='".$_GET['fechaingreso2']."' ";				
$num2=consultaDB($sql1);
$nu2=mysql_fetch_array($num2);
$monto1=$nu2['0'];
$total=$monto + $monto1;
		echo "<td width='250' size'2'>";
		//<b class="titulo">Ingreso por Ahorros <br></b>
		echo "<b class='titulo'>TOTAL AHORROS<br></b> ";
        echo "</td>";
		echo "<td width='300'>";
		echo "LINEA 132";
		echo "</td>";
		echo "<td width='150' align='left'>";
		//echo "$nu[1]";
        echo "</td>";
		echo "<td width='300' align='center'>";
		echo "$total";
        echo "</td>";
?>
</tr>
</table>
</body>
<div align="center">
<label>
<input type="button" name="imprimir" id="imprimir" value="Imprimir" onClick="window.print();" />
</label>

  <!--<input type=button value="Imprimir" name="Print11" onClick="printit()">
-->
</div>
</form>
</html>
