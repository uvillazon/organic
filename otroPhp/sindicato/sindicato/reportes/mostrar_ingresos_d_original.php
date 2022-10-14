<html>
<head>
<title>Mostrar Ingresos por fecha</title>
<link href="../estilo.css"type=text/css rel=stylesheet>
<style media="print" type="text/css">
#imprimir {
visibility:hidden
}
</style>
<script language="JavaScript" src="../js/imprimir.js"></script>
</head>
<body class="sub_body">
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
			$fecha=$_GET['fechaingreso7']; // El formato que te entrega MySQL es Y-m-d 
             $fecha=date("d-m-Y",strtotime($fecha)); 
//echo $fecha 
            $fecha2=$_GET['fechaingreso8']; // El formato que te entrega MySQL es Y-m-d 
             $fecha2=date("d-m-Y",strtotime($fecha2)); 
			?>
            
            :<?php echo $fecha;?> AL :<?php echo $fecha2;?></b></td>
        </tr>
     
<form name="#" method="post" action="ParaInsertar.php">
        <table width="1000" border="1" bordercolor="#000000" align="center" rules="cols">
<tr>
            <?php 
	 $sql1=" select saldo_tipo_bs from saldo where tipo_saldo='ingreso' and fecha_registro_saldo>='".$_GET['fechaingreso7']."' and fecha_registro_saldo<='".$_GET['fechaingreso8']."' ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);
 $sql2=" select saldo_tipo_dolar from saldo where tipo_saldo='ingreso' and fecha_registro_saldo>='".$_GET['fechaingreso7']."' and fecha_registro_saldo<='".$_GET['fechaingreso8']."' ";				
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
					$sql2="SELECT Min(i.numero_registro) from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso7']."' and i.fecha_ingreso<='".$_GET['fechaingreso8']."' ";
					$propiet=consultaDB($sql2);			
					$numero = mysql_num_rows($propiet);			
						$propietario=mysql_fetch_array($propiet);						
						//	echo "</tr>";						
						$sql3="SELECT Max(i.numero_registro) from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso7']."' and i.fecha_ingreso<='".$_GET['fechaingreso8']."' ";
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
		</table>
		<table width="1000" border="1" align="center"   bordercolor="#000000" rules="cols" >
  <tr>
    <td width="340" height="31">INGRESO</td>
	<td width="51"></td>
    <td width="84">CANTIDAD</td>
	<td width="158">PRECIO UNITARIO</td>
    <td width="153">INGRESO[BS.]</td>
	<td width="156">INGRESO[$us.]</td>
  </tr>
</table>
  <table width="1000" border="1" bordercolor="#000000" align="center" rules="cols">
    <tr>
 
	 <?php 
	
$sql1="SELECT sum( i.monto_ingreso_dolar )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso7']."' and i.fecha_ingreso<='".$_GET['fechaingreso8']."' and i.id_tipo_ingreso='10'  ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);
$sql="SELECT ti.tipo_ingreso, ti.monto_tipo_dolar, i.monto_ingreso_dolar from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso7']."' and i.fecha_ingreso<='".$_GET['fechaingreso8']."' and i.id_tipo_ingreso='10' ";
 
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
	
$sql1="SELECT sum( i.monto_ingreso_dolar )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso7']."' and i.fecha_ingreso<='".$_GET['fechaingreso8']."' and i.id_tipo_ingreso='12'  ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);
$sql="SELECT ti.tipo_ingreso, ti.monto_tipo_dolar, i.monto_ingreso_dolar from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso7']."' and i.fecha_ingreso<='".$_GET['fechaingreso8']."' and i.id_tipo_ingreso='12' ";
 
  $res = consultaDB($sql);			
  $r=mysql_fetch_array($res);
		echo "<td width='340'>";
		echo "Venta del Sindicato Linea 131";
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
	 	
$sql1="SELECT sum( i.monto_ingreso_dolar )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso7']."' and i.fecha_ingreso<='".$_GET['fechaingreso8']."' and i.id_tipo_ingreso='1'  ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);
$sql="SELECT ti.tipo_ingreso, ti.monto_tipo_dolar, i.monto_ingreso_dolar from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso7']."' and i.fecha_ingreso<='".$_GET['fechaingreso8']."' and i.id_tipo_ingreso='1' ";
 
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
	 	
$sql1="SELECT sum( i.monto_ingreso_dolar )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso7']."' and i.fecha_ingreso<='".$_GET['fechaingreso8']."' and i.id_tipo_ingreso='11'  ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);
$sql="SELECT ti.tipo_ingreso, ti.monto_tipo_dolar, i.monto_ingreso_dolar from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso7']."' and i.fecha_ingreso<='".$_GET['fechaingreso8']."' and i.id_tipo_ingreso='11' ";
 
  $res = consultaDB($sql);			
  $r=mysql_fetch_array($res);
		echo "<td width='340'>";
		echo "Cambio de Nombre -Linea 131";
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
	 	
$sql1="SELECT sum( i.monto_ingreso_dolar )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso7']."' and i.fecha_ingreso<='".$_GET['fechaingreso8']."' and i.id_tipo_ingreso='15'  ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);
$sql="SELECT ti.tipo_ingreso, ti.monto_tipo_dolar, i.monto_ingreso_dolar from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso7']."' and i.fecha_ingreso<='".$_GET['fechaingreso8']."' and i.id_tipo_ingreso='15' ";
 
 
 
 
  $res = consultaDB($sql);			
  $r=mysql_fetch_array($res);
		echo "<td width='340'>";
		echo "Cuota venta de linea 131";
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
		echo "$nu[0] $";
	   	echo "</td>";
?>
    </tr>
</table>  
  
  
  
  
    <table width="1000" border="1" bordercolor="#000000" align="center" rules="cols">
	<tr>
            <?php 
	 $sql1="SELECT sum( i.monto_pago_ingreso )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso7']."' and i.fecha_ingreso<='".$_GET['fechaingreso8']."' and i.id_tipo_ingreso='9' ";				
$num=consultaDB($sql1);
//$row[1]
$nu=mysql_fetch_array($num);
$sql="SELECT ti.tipo_ingreso, ti.monto_tipo_ingreso, i.monto_pago_ingreso from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso7']."' and i.fecha_ingreso<='".$_GET['fechaingreso8']."' and i.id_tipo_ingreso='9'";
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
	 $sql1="SELECT sum( i.monto_pago_ingreso )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti, pertenece p, movil m, linea l where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.id_movil=p.id_movil and p.id_movil=m.id_movil and m.id_linea=l.id_linea and m.id_linea='2' and i.fecha_ingreso>='".$_GET['fechaingreso7']."' and i.fecha_ingreso<='".$_GET['fechaingreso8']."' and i.id_tipo_ingreso='3'  ";				
$num=consultaDB($sql1);
//$row[1]
$nu=mysql_fetch_array($num);
$sql="SELECT ti.tipo_ingreso, ti.monto_tipo_ingreso, i.monto_pago_ingreso from ingreso i, tipo_ingreso ti, pertenece p, movil m, linea l where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.id_movil=p.id_movil and p.id_movil=m.id_movil and m.id_linea=l.id_linea and m.id_linea='2' and i.fecha_ingreso>='".$_GET['fechaingreso7']."' and i.fecha_ingreso<='".$_GET['fechaingreso8']."' and i.id_tipo_ingreso='3'  ";



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
	 $sql1="SELECT sum( i.monto_pago_ingreso )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso7']."' and i.fecha_ingreso<='".$_GET['fechaingreso8']."' and ti.id_tipo_ingreso= '4'  ";				
$num=consultaDB($sql1);
//$row[1]
$nu=mysql_fetch_array($num);
$sql="SELECT ti.tipo_ingreso, ti.monto_tipo_ingreso, i.monto_pago_ingreso from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso7']."' and i.fecha_ingreso<='".$_GET['fechaingreso8']."' and ti.id_tipo_ingreso ='4'  ";
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
	 $sql1="SELECT sum( i.monto_pago_ingreso )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti, pertenece p, movil m, linea l  where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.id_movil=p.id_movil and p.id_movil=m.id_movil and m.id_linea=l.id_linea and l.id_linea='2' and i.fecha_ingreso>='".$_GET['fechaingreso7']."' and i.fecha_ingreso<='".$_GET['fechaingreso8']."' and ti.id_tipo_ingreso ='2'  ";				
$num=consultaDB($sql1);
//$row[1]
$nu=mysql_fetch_array($num);
$sql="SELECT ti.tipo_ingreso, ti.monto_tipo_ingreso, i.monto_pago_ingreso, ti.monto_tipo_ingreso from ingreso i, tipo_ingreso ti, pertenece p, movil m, linea l where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.id_movil=p.id_movil and p.id_movil=m.id_movil and m.id_linea=l.id_linea and l.id_linea='2' and i.fecha_ingreso>='".$_GET['fechaingreso7']."' and i.fecha_ingreso<='".$_GET['fechaingreso8']."' and ti.id_tipo_ingreso ='2'  ";
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
            <?php 
	 $sql1="SELECT sum( i.monto_pago_ingreso )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti, pertenece p, movil m, linea l  where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.id_movil=p.id_movil and p.id_movil=m.id_movil and m.id_linea=l.id_linea and l.id_linea='1' and i.fecha_ingreso>='".$_GET['fechaingreso7']."' and i.fecha_ingreso<='".$_GET['fechaingreso8']."' and ti.id_tipo_ingreso ='2'  ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);
$sql="SELECT ti.tipo_ingreso, ti.monto_tipo_ingreso, i.monto_pago_ingreso, ti.monto_tipo_ingreso from ingreso i, tipo_ingreso ti, pertenece p, movil m, linea l where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.id_movil=p.id_movil and p.id_movil=m.id_movil and m.id_linea=l.id_linea and l.id_linea='1' and i.fecha_ingreso>='".$_GET['fechaingreso7']."' and i.fecha_ingreso<='".$_GET['fechaingreso8']."' and ti.id_tipo_ingreso ='2'  ";
  $res = consultaDB($sql);			
  $r=mysql_fetch_array($res);
  /*if($r[3]='0')
  $desgloce="0";
   else 
    $desgloce=$nu[0]/$r[3];*/
   
		echo "<td width='340'>";
		echo "Permiso trabajo Linea 131";
        echo "</td>";
		echo "<td width='51'>";
		/*echo "X $desgloce dias" ;*/
		echo "" ;
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
	 $sql1="SELECT sum( i.monto_pago_ingreso )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti, pertenece p, movil m, linea l where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.id_movil=p.id_movil and p.id_movil=m.id_movil and m.id_linea=l.id_linea and m.id_linea='2' and i.fecha_ingreso>='".$_GET['fechaingreso7']."' and i.fecha_ingreso<='".$_GET['fechaingreso8']."' and i.id_tipo_ingreso='6'  ";				
$num=consultaDB($sql1);
//$row[1]
$nu=mysql_fetch_array($num);
$sql="SELECT ti.tipo_ingreso, ti.monto_tipo_ingreso, i.monto_pago_ingreso from ingreso i, tipo_ingreso ti, pertenece p, movil m, linea l where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.id_movil=p.id_movil and p.id_movil=m.id_movil and m.id_linea=l.id_linea and m.id_linea='2' and i.fecha_ingreso>='".$_GET['fechaingreso7']."' and i.fecha_ingreso<='".$_GET['fechaingreso8']."' and i.id_tipo_ingreso='6'  ";



/////////////////////
  $res = consultaDB($sql);			
  $r=mysql_fetch_array($res);
		echo "<td width='340'>";
		echo "Atraso al trabajo - Linea 131";
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
	 $sql1="SELECT sum( i.monto_pago_ingreso )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti, pertenece p, movil m, linea l where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.id_movil=p.id_movil and p.id_movil=m.id_movil and m.id_linea=l.id_linea and m.id_linea='2' and i.fecha_ingreso>='".$_GET['fechaingreso7']."' and i.fecha_ingreso<='".$_GET['fechaingreso8']."' and i.id_tipo_ingreso='5'  ";				
$num=consultaDB($sql1);
//$row[1]
$nu=mysql_fetch_array($num);
$sql="SELECT ti.tipo_ingreso, ti.monto_tipo_ingreso, i.monto_pago_ingreso from ingreso i, tipo_ingreso ti, pertenece p, movil m, linea l where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.id_movil=p.id_movil and p.id_movil=m.id_movil and m.id_linea=l.id_linea and m.id_linea='2' and i.fecha_ingreso>='".$_GET['fechaingreso7']."' and i.fecha_ingreso<='".$_GET['fechaingreso8']."' and i.id_tipo_ingreso='5'  ";



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
	 $sql1="SELECT sum( i.monto_pago_ingreso )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso7']."' and i.fecha_ingreso<='".$_GET['fechaingreso8']."' and i.id_tipo_ingreso='17' ";				
$num=consultaDB($sql1);
//$row[1]
$nu=mysql_fetch_array($num);
$sql="SELECT ti.tipo_ingreso, ti.monto_tipo_ingreso, i.monto_pago_ingreso from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso7']."' and i.fecha_ingreso<='".$_GET['fechaingreso8']."' and i.id_tipo_ingreso='17'";
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
	 	
$sql1="SELECT sum( i.monto_ingreso_dolar )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso7']."' and i.fecha_ingreso<='".$_GET['fechaingreso8']."' and i.id_tipo_ingreso='18'  ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);
$sql="SELECT ti.tipo_ingreso, ti.monto_tipo_dolar, i.monto_ingreso_dolar from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso7']."' and i.fecha_ingreso<='".$_GET['fechaingreso8']."' and i.id_tipo_ingreso='18' ";
 //ojo echo "Gastos de Representacion (Ruteo)";
  $res = consultaDB($sql);			
  $r=mysql_fetch_array($res);
		echo "<td width='340'>";
		echo "Aporte Sindical Linea 131";
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
	 	
$sql1="SELECT sum( i.monto_ingreso_dolar )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso7']."' and i.fecha_ingreso<='".$_GET['fechaingreso8']."' and i.id_tipo_ingreso='22'  ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);
$sql="SELECT ti.tipo_ingreso, ti.monto_tipo_dolar, i.monto_ingreso_dolar from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso7']."' and i.fecha_ingreso<='".$_GET['fechaingreso8']."' and i.id_tipo_ingreso='22' ";
 
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
	 $sql1="SELECT sum( i.monto_pago_ingreso )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso7']."' and i.fecha_ingreso<='".$_GET['fechaingreso8']."' and i.id_tipo_ingreso='21' ";				
$num=consultaDB($sql1);
//$row[1]
$nu=mysql_fetch_array($num);
$sql="SELECT ti.tipo_ingreso, ti.monto_tipo_ingreso, i.monto_pago_ingreso from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso7']."' and i.fecha_ingreso<='".$_GET['fechaingreso8']."' and i.id_tipo_ingreso='21'";
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
	 $sql1="SELECT sum( i.monto_pago_ingreso )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso7']."' and i.fecha_ingreso<='".$_GET['fechaingreso8']."' and i.id_tipo_ingreso='19' ";				
$num=consultaDB($sql1);
//$row[1]
$nu=mysql_fetch_array($num);
$sql="SELECT ti.tipo_ingreso, ti.monto_tipo_ingreso, i.monto_pago_ingreso from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso7']."' and i.fecha_ingreso<='".$_GET['fechaingreso8']."' and i.id_tipo_ingreso='19'";
  $res = consultaDB($sql);			
  $r=mysql_fetch_array($res);
		echo "<td width='340'>";
		echo "Sanciones Linea 132/131";
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
	 $sql1="SELECT sum( i.monto_pago_ingreso )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso7']."' and i.fecha_ingreso<='".$_GET['fechaingreso8']."' and i.id_tipo_ingreso='20' ";				
$num=consultaDB($sql1);
//$row[1]
$nu=mysql_fetch_array($num);
$sql="SELECT ti.tipo_ingreso, ti.monto_tipo_ingreso, i.monto_pago_ingreso from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso7']."' and i.fecha_ingreso<='".$_GET['fechaingreso8']."' and i.id_tipo_ingreso='20'";
  $res = consultaDB($sql);			
  $r=mysql_fetch_array($res);
		echo "<td width='340'>";
		echo "Fiesta San Miguel";
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
 $sql2="SELECT sum( i.monto_pago_ingreso )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso7']."' and i.fecha_ingreso<='".$_GET['fechaingreso8']."' ";
  $propiet=consultaDB($sql2);			
  $numero = mysql_num_rows($propiet);			
$propietario=mysql_fetch_array($propiet);						
  $sql1="SELECT sum( i.monto_pago_ingreso )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso7']."' and i.fecha_ingreso<='".$_GET['fechaingreso8']."' and i.id_tipo_ingreso='7'  ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);
$prueba=$nu[0];

$prueba2=$propietario[0];
$propieta=($prueba2 - $prueba);
						
						
						//	echo "</tr>";						
						$sql3="SELECT sum( i.monto_ingreso_dolar )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso7']."' and i.fecha_ingreso<='".$_GET['fechaingreso8']."' ";
					$propiet1=consultaDB($sql3);			
					$numero1 = mysql_num_rows($propiet1);			
						$propietario1=mysql_fetch_array($propiet1);	
						
						
						?>
  
    <td width="644">TOTAL DE INGRESOS VARIOS:</td>
    <td width="153" align="center" b><?=$propieta;?>[BS]</td>
	<td width="156" align="center" b><?=$propietario1[0];?>[$us]</td>
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
	 $sql1="SELECT sum( i.monto_pago_ingreso )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso7']."' and i.fecha_ingreso<='".$_GET['fechaingreso8']."' and ti.id_tipo_ingreso='7'  ";				
$num=consultaDB($sql1);
//$row[1]
$nu=mysql_fetch_array($num);
$sql="SELECT ti.tipo_ingreso, ti.monto_tipo_ingreso, i.monto_pago_ingreso from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso7']."' and i.fecha_ingreso<='".$_GET['fechaingreso8']."' and ti.id_tipo_ingreso='7'  ";
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
	<table width="1000" border="1" bordercolor="#000000" align="center" rules="cols">
	<tr>
	<td height="10"  colspan="2" align="left">
	
  <b class="titulo">INGRESO POR HOJAS DE CONTROL LINEA 132<br></b></td></tr></table>
<table width="1000" border="1" bordercolor="#000000" align="center" rules="cols" >
<tr align="left" >
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
	 $sql1=" select sum(tt.monto_transaccion)as aporte, COUNT( numero_hoja ) AS numero from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='2' and tt.id_tipo_transaccion='1'and t.estado='Activo'and fecha_de_compra>='".$_GET['fechaingreso7']."' and fecha_de_compra<='".$_GET['fechaingreso8']."' ";				
$num=consultaDB($sql1);
//$row[1]
$nu=mysql_fetch_array($num);
$sql2=" select tt.monto_transaccion from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and m.id_movil=h.id_movil and tt.id_tipo_transaccion='1'and t.estado='Activo' and l.id_linea='2' and fecha_de_compra>='".$_GET['fechaingreso7']."' and fecha_de_compra<='".$_GET['fechaingreso8']."' ";				
$nume=consultaDB($sql2);
//$row[1]
$num=mysql_fetch_array($nume);
		echo "<td width='250'>";
		echo "Aporte Sindical";
        echo "</td>";
		
		echo "<td width='300'>";
		echo "$num[0]";
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
	 $sql1=" select sum(tt.monto_transaccion)as aporte, COUNT( numero_hoja ) AS numero from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and l.id_linea='2' and m.id_movil=h.id_movil and tt.id_tipo_transaccion='4'and t.estado='Activo'and fecha_de_compra>='".$_GET['fechaingreso7']."' and fecha_de_compra<='".$_GET['fechaingreso8']."' ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);

$sql2=" select tt.monto_transaccion from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and l.id_linea='2' and  m.id_movil=h.id_movil and tt.id_tipo_transaccion='4'and t.estado='Activo'and fecha_de_compra>='".$_GET['fechaingreso7']."' and fecha_de_compra<='".$_GET['fechaingreso8']."' ";				
$nume=consultaDB($sql2);
$nume=mysql_fetch_array($nume);

		echo "<td width='250'>";
		echo "Aporte Pro/ Deporte";
        echo "</td>";
		
		echo "<td width='300'>";
		echo "$nume[0]";
        echo "</td>";
		echo "<td width='150' align='left'>";
		echo "$nu[1]";
        echo "</td>";
		echo "<td width='300' align='center'>";
		echo "$nu[0]";
        echo "</td>";
?>
</tr>
</table>   
<table width="1000" border="1" bordercolor="#000000" align="center" rules="cols">
	<tr>
	<td height="10"  colspan="2" align="left">
	
  <b class="titulo">INGRESO POR HOJAS DE CONTROL LINEA 131 <br>
  </b></td></tr></table>	
<table width="1000" border="1" bordercolor="#000000" align="center" rules="cols">
  <tr align="left">
<?php echo "<td width='250'>";
		echo "LINEA 131";
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
	 $sql1=" select sum(tt.monto_transaccion)as aporte, COUNT( numero_hoja ) AS numero from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='1' and tt.id_tipo_transaccion='1'and t.estado='Activo'and fecha_de_compra>='".$_GET['fechaingreso7']."' and fecha_de_compra<='".$_GET['fechaingreso8']."' ";				
$num=consultaDB($sql1);
//$row[1]
$nu=mysql_fetch_array($num);
$sql2=" select tt.monto_transaccion from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='1' and tt.id_tipo_transaccion='1'and t.estado='Activo'and fecha_de_compra>='".$_GET['fechaingreso7']."' and fecha_de_compra<='".$_GET['fechaingreso8']."' ";				
$nume=consultaDB($sql2);
//$row[1]
$num=mysql_fetch_array($nume);
		echo "<td width='250'>";
		echo "Aporte Sindical";
        echo "</td>";
		echo "<td width='300'>";
		echo "$num[0]";
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
	 $sql1=" select sum(tt.monto_transaccion)as aporte, COUNT( numero_hoja ) AS numero from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and l.id_linea='1' and m.id_movil=h.id_movil and tt.id_tipo_transaccion='4'and t.estado='Activo'and fecha_de_compra>='".$_GET['fechaingreso7']."' and fecha_de_compra<='".$_GET['fechaingreso8']."' ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);

$sql2=" select tt.monto_transaccion from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='1' and tt.id_tipo_transaccion='4'and t.estado='Activo'and fecha_de_compra>='".$_GET['fechaingreso7']."' and fecha_de_compra<='".$_GET['fechaingreso8']."' ";				
$nume=consultaDB($sql2);
$nume=mysql_fetch_array($nume);

		echo "<td width='250'>";
		echo "Aporte Pro/ Deporte";
        echo "</td>";
		echo "<td width='300'>";
		echo "$nume[0]";
        echo "</td>";
		echo "<td width='150' align='left'>";
		echo "$nu[1]";
        echo "</td>";
		echo "<td width='300' align='center'>";
		echo "$nu[0]";
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
	
  <b class="titulo">TOTAL DE INGRESOS HOJAS DE CONTROL<br>
  </b></td></tr></table>	

<table width="1000" border="1" bordercolor="#000000" align="center" rules="cols">

  
<tr>
<?php		
					$sql2="SELECT Min(i.numero_hoja) from hoja_control i where fecha_de_compra>='".$_GET['fechaingreso7']."' and fecha_de_compra<='".$_GET['fechaingreso8']."' ";
					$propiet=consultaDB($sql2);			
					$numero = mysql_num_rows($propiet);			
						$propietario=mysql_fetch_array($propiet);						
						//	echo "</tr>";						
						$sql3="SELECT Max(i.numero_hoja) from hoja_control i where fecha_de_compra>='".$_GET['fechaingreso7']."' and fecha_de_compra<='".$_GET['fechaingreso8']."' ";
					$propiet1=consultaDB($sql3);			
					$numero1 = mysql_num_rows($propiet1);			
						$propietario1=mysql_fetch_array($propiet1);	
						$sql1=" select sum(total_hoja) as totalDia, COUNT( numero_hoja ) AS numero from hoja_control where fecha_de_compra>='".$_GET['fechaingreso7']."' and fecha_de_compra<='".$_GET['fechaingreso8']."' ";				
$num=consultaDB($sql1);
//$row[1]
$nu=mysql_fetch_array($num);


						$impre=($propietario1['0'])-($propietario['0']);
						$falla=$impre-$nu['1'] +1;
						
						
						?>
<?php echo "<td width='300'>";
		echo "LINEAS(131-132)";
        echo "</td>";
		echo "<td width='400'>";
		echo "No Recibo($propietario[0]--$propietario1[0])......F.Imp.($falla)   ";
		echo "</td>";
		echo "<td width='76'>";
		echo "CANTIDAD";
        echo "</td>";
		echo "<td width='450' align='center'>";
		echo "MONTO INGRESO";
        echo "</td>";
		?></tr>
  
  
<tr>
              <?php 
	$sql1=" select sum(tt.monto_transaccion)as aporte, COUNT( numero_hoja ) AS numero from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='2' and tt.id_tipo_transaccion='1'and t.estado='Activo'and fecha_de_compra>='".$_GET['fechaingreso7']."' and fecha_de_compra<='".$_GET['fechaingreso8']."' ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);

 $sql2=" select sum(tt.monto_transaccion)as aporte, COUNT( numero_hoja ) AS numero from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='1' and tt.id_tipo_transaccion='1'and t.estado='Activo'and fecha_de_compra>='".$_GET['fechaingreso7']."' and fecha_de_compra<='".$_GET['fechaingreso8']."' ";				
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
		echo "$cantidad";
        echo "</td>";
		echo "<td width='300X' align='center'>";
		echo "$monto";
        echo "</td>";
?>
</tr>

<tr>
              <?php 
	$sql1=" select sum(tt.monto_transaccion)as aporte, COUNT( numero_hoja ) AS numero from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='2' and tt.id_tipo_transaccion='4'and t.estado='Activo'and fecha_de_compra>='".$_GET['fechaingreso7']."' and fecha_de_compra<='".$_GET['fechaingreso8']."' ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);

 $sql2=" select sum(tt.monto_transaccion)as aporte, COUNT( numero_hoja ) AS numero from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='1' and tt.id_tipo_transaccion='4'and t.estado='Activo'and fecha_de_compra>='".$_GET['fechaingreso7']."' and fecha_de_compra<='".$_GET['fechaingreso8']."' ";				
$num1=consultaDB($sql2);
$nu1=mysql_fetch_array($num1);

$cantidad=$nu['1']+ $nu1['1'];
$monto=$nu['0']+ $nu1['0'];

		echo "<td width='250'>";
		echo "PRO-DEPORTE (131-132)";
        echo "</td>";
		echo "<td width='300'>";
		//echo "$nume[0]";
        echo "</td>";
		echo "<td width='150' align='left'>";
		echo "$cantidad";
        echo "</td>";
		echo "<td width='300X' align='center'>";
		echo "$monto";
        echo "</td>";
?>
</tr>
	<tr>
            <?php 
	 $sql1=" select sum(total_hoja) as totalDia,  COUNT( numero_hoja ) AS numero from hoja_control where fecha_de_compra>='".$_GET['fechaingreso7']."' and fecha_de_compra<='".$_GET['fechaingreso8']."' ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);
$sql1=" select sum(tt.monto_transaccion)as aporte from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='2' and tt.id_tipo_transaccion='1'and t.estado='Activo'and fecha_de_compra>='".$_GET['fechaingreso7']."' and fecha_de_compra<='".$_GET['fechaingreso8']."' ";				
$num4=consultaDB($sql1);
$nu4=mysql_fetch_array($num4);

 $sql2=" select sum(tt.monto_transaccion)as aporte from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='1' and tt.id_tipo_transaccion='1'and t.estado='Activo'and fecha_de_compra>='".$_GET['fechaingreso7']."' and fecha_de_compra<='".$_GET['fechaingreso8']."' ";				
$num1=consultaDB($sql2);
$nu1=mysql_fetch_array($num1);
$monto=$nu4['0']+ $nu1['0'];

$sql1=" select sum(tt.monto_transaccion)as aporte from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='2' and tt.id_tipo_transaccion='4'and t.estado='Activo'and fecha_de_compra>='".$_GET['fechaingreso7']."' and fecha_de_compra<='".$_GET['fechaingreso8']."' ";				
$num2=consultaDB($sql1);
$nu2=mysql_fetch_array($num2);

 $sql2=" select sum(tt.monto_transaccion)as aporte from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='1' and tt.id_tipo_transaccion='4'and t.estado='Activo'and fecha_de_compra>='".$_GET['fechaingreso7']."' and fecha_de_compra<='".$_GET['fechaingreso8']."' ";				
$num3=consultaDB($sql2);
$nu3=mysql_fetch_array($num3);


$monto1=$nu2['0']+ $nu3['0'];
$total=$monto + $monto1;
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
					$sql2="SELECT Min(i.numero_registro) from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso7']."' and i.fecha_ingreso<='".$_GET['fechaingreso8']."' ";
					$propiet7=consultaDB($sql2);			
					$numero = mysql_num_rows($propiet7);			
						$propietario7=mysql_fetch_array($propiet7);						
						//	echo "</tr>";						
						$sql3="SELECT Max(i.numero_registro) from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso7']."' and i.fecha_ingreso<='".$_GET['fechaingreso8']."' ";
					$propiet8=consultaDB($sql3);			
					$numero1 = mysql_num_rows($propiet8);			
						$propietario8=mysql_fetch_array($propiet8);	
						?>
            <?php 
			$sql2="SELECT sum( i.monto_pago_ingreso )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso7']."' and i.fecha_ingreso<='".$_GET['fechaingreso8']."' ";
					$propiet=consultaDB($sql2);			
					$numero = mysql_num_rows($propiet);			
						$propietario=mysql_fetch_array($propiet);						
			$sql1="SELECT sum( i.monto_pago_ingreso )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso7']."' and i.fecha_ingreso<='".$_GET['fechaingreso8']."' and ti.id_tipo_ingreso='7'  ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);
$prueba=$nu[0];

$prueba2=$propietario[0];
$propieta=($prueba2 - $prueba);
			
			/////
	// $sql2="SELECT sum( i.monto_pago_ingreso )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso7']."' and i.fecha_ingreso<='".$_GET['fechaingreso8']."' ";
		//			$propiet=consultaDB($sql2);			
			//		$numero = mysql_num_rows($propiet);			
				//		$propietario=mysql_fetch_array($propiet);						
						//	echo "</tr>";						
						$sql3="SELECT sum( i.monto_ingreso_dolar )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso7']."' and i.fecha_ingreso<='".$_GET['fechaingreso8']."' ";
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
					$sql2="SELECT Min(i.numero_hoja) from hoja_control i where fecha_de_compra>='".$_GET['fechaingreso7']."' and fecha_de_compra<='".$_GET['fechaingreso8']."' ";
					$propiet=consultaDB($sql2);			
					$numero = mysql_num_rows($propiet);			
						$propietario=mysql_fetch_array($propiet);						
						//	echo "</tr>";						
						$sql3="SELECT Max(i.numero_hoja) from hoja_control i where fecha_de_compra>='".$_GET['fechaingreso7']."' and fecha_de_compra<='".$_GET['fechaingreso8']."' ";
					$propiet1=consultaDB($sql3);			
					$numero1 = mysql_num_rows($propiet1);			
						$propietario1=mysql_fetch_array($propiet1);	
						?>
            <?php 
	 $sql1=" select sum(total_hoja) as totalDia, COUNT( numero_hoja ) AS numero from hoja_control where fecha_de_compra>='".$_GET['fechaingreso7']."' and fecha_de_compra<='".$_GET['fechaingreso8']."' ";				
$num=consultaDB($sql1);
//$row[1]
$sql1=" select sum(tt.monto_transaccion)as aporte from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='2' and tt.id_tipo_transaccion='1'and t.estado='Activo'and fecha_de_compra>='".$_GET['fechaingreso7']."' and fecha_de_compra<='".$_GET['fechaingreso8']."' ";				
$num4=consultaDB($sql1);
$nu4=mysql_fetch_array($num4);

 $sql2=" select sum(tt.monto_transaccion)as aporte from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='1' and tt.id_tipo_transaccion='1'and t.estado='Activo'and fecha_de_compra>='".$_GET['fechaingreso7']."' and fecha_de_compra<='".$_GET['fechaingreso8']."' ";				
$num1=consultaDB($sql2);
$nu1=mysql_fetch_array($num1);
$monto=$nu4['0']+ $nu1['0'];

$sql1=" select sum(tt.monto_transaccion)as aporte from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='2' and tt.id_tipo_transaccion='4'and t.estado='Activo'and fecha_de_compra>='".$_GET['fechaingreso7']."' and fecha_de_compra<='".$_GET['fechaingreso8']."' ";				
$num2=consultaDB($sql1);
$nu2=mysql_fetch_array($num2);

 $sql2=" select sum(tt.monto_transaccion)as aporte from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='1' and tt.id_tipo_transaccion='4'and t.estado='Activo'and fecha_de_compra>='".$_GET['fechaingreso7']."' and fecha_de_compra<='".$_GET['fechaingreso8']."' ";				
$num3=consultaDB($sql2);
$nu3=mysql_fetch_array($num3);


$monto1=$nu2['0']+ $nu3['0'];
$total=$monto + $monto1;
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
					$sql2="SELECT Min(i.numero_hoja) from hoja_control i where fecha_de_compra>='".$_GET['fechaingreso7']."' and fecha_de_compra<='".$_GET['fechaingreso8']."' ";
					$propiet=consultaDB($sql2);			
					$numero = mysql_num_rows($propiet);			
						$propietario=mysql_fetch_array($propiet);						
						//	echo "</tr>";						
						$sql3="SELECT Max(i.numero_hoja) from hoja_control i where fecha_de_compra>='".$_GET['fechaingreso7']."' and fecha_de_compra<='".$_GET['fechaingreso8']."' ";
					$propiet1=consultaDB($sql3);			
					$numero1 = mysql_num_rows($propiet1);			
						$propietario1=mysql_fetch_array($propiet1);	
						?>
            <?php 
	 $sql1="SELECT sum( i.monto_pago_ingreso )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso7']."' and i.fecha_ingreso<='".$_GET['fechaingreso8']."' and ti.id_tipo_ingreso='7'  ";				
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
			 $sql1=" select sum(tt.monto_transaccion)as aporte from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='2' and tt.id_tipo_transaccion='1'and t.estado='Activo'and fecha_de_compra>='".$_GET['fechaingreso7']."' and fecha_de_compra<='".$_GET['fechaingreso8']."' ";				
$num4=consultaDB($sql1);
$nu4=mysql_fetch_array($num4);

 $sql2=" select sum(tt.monto_transaccion)as aporte from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='1' and tt.id_tipo_transaccion='1'and t.estado='Activo'and fecha_de_compra>='".$_GET['fechaingreso7']."' and fecha_de_compra<='".$_GET['fechaingreso8']."' ";				
$num1=consultaDB($sql2);
$nu1=mysql_fetch_array($num1);
$monto=$nu4['0']+ $nu1['0'];

$sql1=" select sum(tt.monto_transaccion)as aporte from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='2' and tt.id_tipo_transaccion='4'and t.estado='Activo'and fecha_de_compra>='".$_GET['fechaingreso7']."' and fecha_de_compra<='".$_GET['fechaingreso8']."' ";				
$num2=consultaDB($sql1);
$nu2=mysql_fetch_array($num2);

 $sql2=" select sum(tt.monto_transaccion)as aporte from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='1' and tt.id_tipo_transaccion='4'and t.estado='Activo'and fecha_de_compra>='".$_GET['fechaingreso7']."' and fecha_de_compra<='".$_GET['fechaingreso8']."' ";				
$num3=consultaDB($sql2);
$nu3=mysql_fetch_array($num3);


$monto1=$nu2['0']+ $nu3['0'];
$total=$monto + $monto1;


	$sql2="SELECT sum( i.monto_pago_ingreso )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso7']."' and i.fecha_ingreso<='".$_GET['fechaingreso8']."' ";
					$propiet=consultaDB($sql2);			
					$numero = mysql_num_rows($propiet);			
						$propietario=mysql_fetch_array($propiet);		
//	$suma=($nu[0]+$propietario[0]);					
    $suma=($total+$propietario[0]);					

$sql3="SELECT sum( i.monto_ingreso_dolar )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso7']."' and i.fecha_ingreso<='".$_GET['fechaingreso8']."' ";
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
			 $sql1=" select sum(tt.monto_transaccion)as aporte from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='2' and tt.id_tipo_transaccion='1'and t.estado='Activo'and fecha_de_compra>='".$_GET['fechaingreso7']."' and fecha_de_compra<='".$_GET['fechaingreso8']."' ";				
$num4=consultaDB($sql1);
$nu4=mysql_fetch_array($num4);

 $sql2=" select sum(tt.monto_transaccion)as aporte from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='1' and tt.id_tipo_transaccion='1'and t.estado='Activo'and fecha_de_compra>='".$_GET['fechaingreso7']."' and fecha_de_compra<='".$_GET['fechaingreso8']."' ";				
$num1=consultaDB($sql2);
$nu1=mysql_fetch_array($num1);
$monto=$nu4['0']+ $nu1['0'];

$sql1=" select sum(tt.monto_transaccion)as aporte from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='2' and tt.id_tipo_transaccion='4'and t.estado='Activo'and fecha_de_compra>='".$_GET['fechaingreso7']."' and fecha_de_compra<='".$_GET['fechaingreso8']."' ";				
$num2=consultaDB($sql1);
$nu2=mysql_fetch_array($num2);

 $sql2=" select sum(tt.monto_transaccion)as aporte from tipo_transaccion tt, tener t,linea l, movil m, hoja_control h where tt.id_tipo_transaccion=t.id_tipo_transaccion and t.id_linea=l.id_linea and l.id_linea=m.id_linea and m.id_movil=h.id_movil and l.id_linea='1' and tt.id_tipo_transaccion='4'and t.estado='Activo'and fecha_de_compra>='".$_GET['fechaingreso7']."' and fecha_de_compra<='".$_GET['fechaingreso8']."' ";				
$num3=consultaDB($sql2);
$nu3=mysql_fetch_array($num3);


$monto1=$nu2['0']+ $nu3['0'];
$total=$monto + $monto1;


	$sql2="SELECT sum( i.monto_pago_ingreso )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso7']."' and i.fecha_ingreso<='".$_GET['fechaingreso8']."' ";
					$propiet=consultaDB($sql2);			
					$numero = mysql_num_rows($propiet);			
						$propietario=mysql_fetch_array($propiet);		
//	$suma=($nu[0]+$propietario[0]);					
    $suma=($total+$propietario[0]);					

$sql3="SELECT sum( i.monto_ingreso_dolar )  AS monto_total, COUNT( i.id_tipo_ingreso ) AS numero from ingreso i, tipo_ingreso ti where i.id_tipo_ingreso = ti.id_tipo_ingreso and i.fecha_ingreso>='".$_GET['fechaingreso7']."' and i.fecha_ingreso<='".$_GET['fechaingreso8']."' ";
					$propiet1=consultaDB($sql3);			
					$numero1 = mysql_num_rows($propiet1);			
						$propietario1=mysql_fetch_array($propiet1);	
						//saldo anterior
						$sql1=" select saldo_tipo_bs from saldo where tipo_saldo='ingreso' and fecha_registro_saldo>='".$_GET['fechaingreso7']."' and fecha_registro_saldo<='".$_GET['fechaingreso8']."' ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);
 $sql2=" select saldo_tipo_dolar from saldo where tipo_saldo='ingreso' and fecha_registro_saldo>='".$_GET['fechaingreso7']."' and fecha_registro_saldo<='".$_GET['fechaingreso8']."' ";				
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

<div align="center">
</table>

<table width="200" border="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>




</div>

 
 
  
  

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
