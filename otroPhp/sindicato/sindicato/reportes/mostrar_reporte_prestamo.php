<html>
<head>
<title>Mostrar Depositos por fecha</title>
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
            <b class="titulo">PRESTAMOS<br>
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
	 $sql1=" select saldo_tipo_bs from saldo where tipo_saldo='cooperativa' and fecha_registro_saldo>='".$_GET['fechaingreso1']."' and fecha_registro_saldo<='".$_GET['fechaingreso2']."' ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);
 
$monto1=$nu['0'];
		echo "<td width='556' size'2'>";
		//<b class="titulo">Ingreso por Ahorros <br></b>
		echo "<b class='titulo'>INGRESO A COOPERATIVA<br></b> ";
        echo "</td>";
   		echo "<td width='200' align='center'>";
//		echo "$monto1 [Bs]";
        echo "</td>";

		echo "<td width='200' align='center'>";
		echo "$monto2 ..[Bs]";
        echo "</td>";
?>
</tr>
</table>
 <table width="1000" border="1" bordercolor="#000000" align="center" rules="cols">
	<tr>
	<td height="10"  colspan="2" align="left">
	
  <b class="titulo">PRESTAMOS POR DEPOSITOS<br></b></td></tr></table>
        
		<table width="1000" border="1" align="center"   bordercolor="#000000" rules="cols" >
  <tr>
    <td width="556" height="31">INGRESO</td>
	<td width="200">CANTIDAD</td>
	<td width="200">MONTO[BS.]</td>
	</tr>
</table>
  

 
	<table width="1000" border="1" bordercolor="#000000" align="center" rules="cols">
    <tr>
	        <?php 
	 $sql1="SELECT sum( p.monto_prestamo )  AS monto_total, COUNT( p.id_prestamo ) AS numero from prestamo_socio p where p.id_tipo_prestamo='2' and p.fecha_prestamo>='".$_GET['fechaingreso1']."' and p.fecha_prestamo<='".$_GET['fechaingreso2']."' ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);
	
/////////////////////
		echo "<td width='556'>";
		echo "Prestamos";
        echo "</td>";
		echo "<td width='200' align='left'>";
		echo "$nu[1]";
        echo "</td>";
		echo "<td width='200' align='center'>";
		echo "$nu[0]";
        echo "</td>";
		
?>
    </tr>
</table>
<table width="1000" border="1" bordercolor="#000000" align="center" rules="cols">
     <tr>
	        <?php
$sql1="SELECT SUM(monto_deposito)  AS monto_total, COUNT( id_deposito)from deposito d, prestamo_socio a, tipo_prestamo b where b.interes!='0.00' and a.id_prestamo=d.id_prestamo and a.id_tipo_prestamo=b.id_tipo_prestamo and d.fecha_deposito>='".$_GET['fechaingreso1']."' and d.fecha_deposito<='".$_GET['fechaingreso2']."' ";

$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);
$monto=$nu['0'];


$sql2=" select saldo_tipo_bs from saldo where tipo_saldo='cooperativa' and fecha_registro_saldo>='".$_GET['fechaingreso1']."' and fecha_registro_saldo<='".$_GET['fechaingreso2']."' ";				
$nume=consultaDB($sql2);
$nue=mysql_fetch_array($nume);
 
$monto1=$nue['0'];
///////////////////
$total=$monto;
/////////////////////
		echo "<td width='556'>";
		echo "Ingreso en Depositos /Circulante";
        echo "</td>";
		echo "<td width='200' align='left'>";
		echo "$nu[1]";
        echo "</td>";
		echo "<td width='200' align='center'>";
		echo "$total";
        echo "</td>";
		
?>
    </tr>
</table>
 
	  
  <table width="1000" border="1" bordercolor="#000000" align="center" rules="cols">
  
	  <?php		
					$sql1="SELECT sum( p.monto_prestamo )  AS monto_total, COUNT( p.id_prestamo ) AS numero from prestamo_socio p where p.id_tipo_prestamo='2' and p.fecha_prestamo>='".$_GET['fechaingreso1']."' and p.fecha_prestamo<='".$_GET['fechaingreso2']."' ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);						
$prestamo=$nu[0];

			$sql2="SELECT SUM(monto_deposito)  AS monto_total, COUNT( id_deposito)from deposito d, prestamo_socio a, tipo_prestamo b where b.interes!='0.00' and a.id_prestamo=d.id_prestamo and a.id_tipo_prestamo=b.id_tipo_prestamo and d.fecha_deposito>='".$_GET['fechaingreso1']."' and d.fecha_deposito<='".$_GET['fechaingreso2']."' ";

$nume=consultaDB($sql2);
$nue=mysql_fetch_array($nume);

$deposito=$nue[0];
//prueba con nueva forma
$sql1=" select saldo_tipo_bs from saldo where tipo_saldo='cooperativa' and fecha_registro_saldo>='".$_GET['fechaingreso1']."' and fecha_registro_saldo<='".$_GET['fechaingreso2']."' ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);
 $monto1=$nu['0'];


$deposito=$deposito;
//fin
$total=($deposito - $prestamo);

						?>
  
    <td width="556">SALDO INGRESOS DISPONIBLES:</td>
    <td width="200" align="center" b></td>
	<td width="200" align="center" b><?=$total;?>[Bs]</td>
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
	
  <b class="titulo">VENTAS DE COOPERATIVA<br></b></td></tr></table>
        
		<table width="1000" border="1" align="center"   bordercolor="#000000" rules="cols" >
  <tr>
    <td width="556" height="31">INGRESO</td>
	<td width="200">CANTIDAD</td>
	<td width="200">MONTO[BS.]</td>
	</tr>
</table>
  

 
	<table width="1000" border="1" bordercolor="#000000" align="center" rules="cols">
    <tr>
	        <?php 
	 $sql1="SELECT sum( p.monto_prestamo )  AS monto_total, COUNT( p.id_prestamo ) AS numero from prestamo_socio p where p.id_tipo_prestamo='3' and p.fecha_prestamo>='".$_GET['fechaingreso1']."' and p.fecha_prestamo<='".$_GET['fechaingreso2']."' ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);

/////////////////////
		echo "<td width='556'>";
		echo "Ventas de Cooperativa";
        echo "</td>";
		echo "<td width='200' align='left'>";
		echo "$nu[1]";
        echo "</td>";
		echo "<td width='200' align='center'>";
		echo "$nu[0].00";
        echo "</td>";
		
?>
    </tr>
</table>
<table width="1000" border="1" bordercolor="#000000" align="center" rules="cols">
     <tr>
	        <?php
$sql1="SELECT SUM(monto_deposito)  AS monto_total, COUNT( id_deposito)from deposito d, prestamo_socio a, tipo_prestamo b where b.interes='0.00' and a.id_prestamo=d.id_prestamo and a.id_tipo_prestamo=b.id_tipo_prestamo and d.fecha_deposito>='".$_GET['fechaingreso1']."' and d.fecha_deposito<='".$_GET['fechaingreso2']."' ";

$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);

/////////////////////
		echo "<td width='556'>";
		echo "Depositos";
        echo "</td>";
		echo "<td width='200' align='left'>";
		echo "$nu[1]";
        echo "</td>";
		echo "<td width='200' align='center'>";
		echo "$nu[0]";
        echo "</td>";
		
?>
    </tr>
</table>
 
	  
  <table width="1000" border="1" bordercolor="#000000" align="center" rules="cols">
  
	  <?php		
					$sql1="SELECT sum( p.monto_prestamo )  AS monto_total, COUNT( p.id_prestamo ) AS numero from prestamo_socio p where p.id_tipo_prestamo='3' and p.fecha_prestamo>='".$_GET['fechaingreso1']."' and p.fecha_prestamo<='".$_GET['fechaingreso2']."' ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);						
$prueba=$nu[0];

			$sql2="SELECT SUM(monto_deposito)  AS monto_total, COUNT( id_deposito)from deposito d, prestamo_socio a, tipo_prestamo b where b.interes='0.00' and a.id_prestamo=d.id_prestamo and a.id_tipo_prestamo=b.id_tipo_prestamo and d.fecha_deposito>='".$_GET['fechaingreso1']."' and d.fecha_deposito<='".$_GET['fechaingreso2']."' ";

$nume=consultaDB($sql2);
$nue=mysql_fetch_array($nume);

$prueba2=$nue[0];

$total=($prueba2 );
						?>
  
    <td width="556">INGRESOS POR VENTAS:</td>
    <td width="200" align="center" b></td>
	<td width="200" align="center" b><?=$total;?>[Bs]</td>
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
	<table width="200" border="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</div> 
	<table width="1000" border="1" bordercolor="#000000" align="center" rules="cols">
	<tr>
	<td height="10"  colspan="2" align="left">
	
  <b class="titulo">Montos Estimados <br>
  </b></td></tr></table>
        
		<table width="1000" border="1" align="center"   bordercolor="#000000" rules="cols" >
  <tr>
    <td width="135" height="31"></td>
	<td width="160">CANTIDAD DE PRESTAMOS</td>
	<td width="160">MONTO PRESTAMO</td>
	<td width="160">INTERES</td>
	<td width="160">INT + CAPITAL</td>
	<td width="160">MONTO ADEUDADO</td>
	
	
	</tr>
</table>
  

 
	<table width="1000" border="1" bordercolor="#000000" align="center" rules="cols">
    <tr>
	        <?php 
	 $sql1="SELECT sum( p.monto_prestamo )  AS monto_total, COUNT( p.id_prestamo ) AS numero from prestamo_socio p where p.id_tipo_prestamo='2' and p.fecha_prestamo>='".$_GET['fechaingreso1']."' and p.fecha_prestamo<='".$_GET['fechaingreso2']."' ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);

/////////////////////
 $total=$nu[0];
$interes='7.00';
 $interes =($total*($interes/100));
 $interescapital =$interes +$total;
	///
	$sql2="SELECT SUM(monto_deposito)  AS monto_total, COUNT( id_deposito)from deposito d, prestamo_socio a, tipo_prestamo b where b.interes!='0.00' and a.id_prestamo=d.id_prestamo and a.id_tipo_prestamo=b.id_tipo_prestamo and d.fecha_deposito>='".$_GET['fechaingreso1']."' and d.fecha_deposito<='".$_GET['fechaingreso2']."' ";

$nume=consultaDB($sql2);
$nue=mysql_fetch_array($nume);
$totaldepositado=$nue[0];
	$totaldeuda = $interescapital - $totaldepositado;
			
////////////////////
		echo "<td width='135'>";
		echo "PRESTAMOS";
        echo "</td>";
		echo "<td width='160' align='left'>";
		echo "$nu[1]";
        echo "</td>";
		echo "<td width='160' align='center'>";
		echo "$nu[0].00";
        echo "</td>";
		echo "<td width='160'>";
		echo "$interes";
         echo "</td>";
		echo "<td width='160'>";
		echo "$interescapital";
        echo "</td>";
		echo "<td width='160'>";
		echo "$totaldeuda";
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
	
  <b class="titulo">Montos Recaudados<br>
  </b></td></tr></table>
        
		<table width="1000" border="1" align="center"   bordercolor="#000000" rules="cols" >
  <tr>
    <td width="189" height="31"></td>
	<td width="193">CANTIDAD DE DEPOSITOS</td>
	<td width="198">MONTO DEPOSITO</td>
	<td width="196">CAPITAL RECAUDADO</td>
	<td width="190">INTERES RECAUDADO</td>
	
	
	</tr>
</table>
  

 
	<table width="1000" border="1" bordercolor="#000000" align="center" rules="cols">
    <tr>
	        <?php 
	 $sql1="SELECT sum( p.monto_prestamo )  AS monto_total, COUNT( p.id_prestamo ) AS numero from prestamo_socio p where p.id_tipo_prestamo='2' and p.fecha_prestamo>='".$_GET['fechaingreso1']."' and p.fecha_prestamo<='".$_GET['fechaingreso2']."' ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);

/////////////////////
 $total=$nu[0];
$interes='7.00';
 $interes =($total*($interes/100));
 $interescapital =$interes +$total;
	///
	$sql2="SELECT SUM(monto_deposito)  AS monto_total, COUNT( id_deposito)from deposito d, prestamo_socio a, tipo_prestamo b where b.interes!='0.00' and a.id_prestamo=d.id_prestamo and a.id_tipo_prestamo=b.id_tipo_prestamo and d.fecha_deposito>='".$_GET['fechaingreso1']."' and d.fecha_deposito<='".$_GET['fechaingreso2']."' ";

$nume=consultaDB($sql2);
$nue=mysql_fetch_array($nume);
$totaldepositado=$nue[0];

///monto ingresos a cooperativa
 $sql1=" select saldo_tipo_bs from saldo where tipo_saldo='cooperativa' and fecha_registro_saldo>='".$_GET['fechaingreso1']."' and fecha_registro_saldo<='".$_GET['fechaingreso2']."' ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);
 
$monto1=$nu['0'];
////fin  actualizar a totaldepositado haydee
	$totaldeuda = $interescapital - $totaldepositado;
$interes='7.00';
$interesr =($totaldepositado*($interes/100));

$capitalr = $totaldepositado - $interesr; 	

		
////////////////////
		echo "<td width='189'>";
		echo "DEPOSITOS";
        echo "</td>";
		echo "<td width='193' align='left'>";
		echo "$nue[1]";
        echo "</td>";
		echo "<td width='198' align='center'>";
		echo "$nue[0]";
        echo "</td>";
		echo "<td width='196'>";
		echo "$capitalr";
         echo "</td>";
		echo "<td width='190'>";
		echo "$interesr";
        echo "</td>";
		
?>
    </tr>
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
