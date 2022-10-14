<html>
<head>
<title>Reporte Cooperativa</title>
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
            <b class="titulo">REPORTE COOPERATIVA<br>
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

 <table width="800" border="1" bordercolor="#000000" align="center" rules="cols">
	<tr>
	<td height="10"  colspan="2" align="left">
	
  <b class="titulo">CAPITAL INICIAL<br></b></td></tr></table>
        
		<table width="800" border="1" align="center"   bordercolor="#000000" rules="cols" >
  <tr>
    <td width="456" height="31"></td>
	<td width="172"></td>
	<td width="172">MONTO[BS.]</td>
	</tr>
</table>
<table width="800" border="1" bordercolor="#000000" align="center" rules="cols">
    <tr>
	        <?php 
	  $sql1=" select * from saldo where tipo_saldo='cooperativa' AND id_saldo='6' and fecha_registro_saldo>='".$_GET['fechaingreso7']."' and fecha_registro_saldo<='".$_GET['fechaingreso8']."' ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);
 
$monto1=$nu['2'];

$nombre=$nu['5'];	
/////////////////////
		echo "<td width='456'>";
		echo "$nu[5]";
        echo "</td>";
		echo "<td width='172' align='left'>";
		echo "";
        echo "</td>";
		echo "<td width='172' align='center'>";
		echo "$nu[2]";
        echo "</td>";
		
?>
    </tr>
</table>
<table width="800" border="1" bordercolor="#000000" align="center" rules="cols">
    <tr>
	        <?php 
	  $sql1=" select * from saldo where tipo_saldo='cooperativa' AND id_saldo='7' and fecha_registro_saldo>='".$_GET['fechaingreso7']."' and fecha_registro_saldo<='".$_GET['fechaingreso8']."' ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);
 
$monto1=$nu['2'];

$nombre=$nu['5'];	
/////////////////////
		echo "<td width='456'>";
		echo "$nu[5]";
        echo "</td>";
		echo "<td width='172' align='left'>";
		echo "";
        echo "</td>";
		echo "<td width='172' align='center'>";
		echo "$nu[2]";
        echo "</td>";
		
?>
    </tr>
</table>	  
  <table width="800" border="1" bordercolor="#000000" align="center" rules="cols">
  
	  <?php		
			$sql1=" select * from saldo where tipo_saldo='cooperativa' AND id_saldo='6' and fecha_registro_saldo>='".$_GET['fechaingreso7']."' and fecha_registro_saldo<='".$_GET['fechaingreso8']."' ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);
 
$monto1=$nu['2'];

			$sql2=" select * from saldo where tipo_saldo='cooperativa' AND id_saldo='7' and fecha_registro_saldo>='".$_GET['fechaingreso7']."' and fecha_registro_saldo<='".$_GET['fechaingreso8']."' ";				
$nume=consultaDB($sql2);
$nue=mysql_fetch_array($nume);
 
$monto2=$nue['2'];
//fin
$total=$monto1+$monto2;

						?>
  
    <td width="456">TOTAL :</td>
    <td width="172" align="center" b></td>
	<td width="172" align="center" b><?=$total;?>[Bs]</td>
</table>
	
	<div align="center">


<table width="172" border="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</div>

 <table width="800" border="1" bordercolor="#000000" align="center" rules="cols">
	<tr>
	<td height="10"  colspan="2" align="left">
	
  <b class="titulo">DEVOLUCIONES<br></b></td></tr></table>
        
		<table width="800" border="1" align="center"   bordercolor="#000000" rules="cols" >
  <tr>
    <td width="456" height="31"></td>
	<td width="172"></td>
	<td width="172">MONTO[BS.]</td>
	</tr>
</table>
<table width="800" border="1" bordercolor="#000000" align="center" rules="cols">
    <tr>
	        <?php 
	  $sql1=" select * from saldo where tipo_saldo='cooperativa' AND id_saldo='8' and fecha_registro_saldo>='".$_GET['fechaingreso7']."' and fecha_registro_saldo<='".$_GET['fechaingreso8']."' ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);
 
$monto1=$nu['2'];

$nombre=$nu['5'];	
/////////////////////
		echo "<td width='456'>";
		echo "$nu[5]";
        echo "</td>";
		echo "<td width='172' align='left'>";
		echo "";
        echo "</td>";
		echo "<td width='172' align='center'>";
		echo "$nu[2]";
        echo "</td>";
		
?>
    </tr>
</table>
<table width="800" border="1" bordercolor="#000000" align="center" rules="cols">
    <tr>
	        <?php 
	  $sql1=" select * from saldo where tipo_saldo='cooperativa' AND id_saldo='9' and fecha_registro_saldo>='".$_GET['fechaingreso7']."' and fecha_registro_saldo<='".$_GET['fechaingreso8']."' ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);
 
$monto1=$nu['2'];

$nombre=$nu['5'];	
/////////////////////
		echo "<td width='456'>";
		echo "$nu[5]";
        echo "</td>";
		echo "<td width='172' align='left'>";
		echo "";
        echo "</td>";
		echo "<td width='172' align='center'>";
		echo "$nu[2]";
        echo "</td>";
		
?>
    </tr>
</table>	  
  <table width="800" border="1" bordercolor="#000000" align="center" rules="cols">
  
	  <?php		
			$sql1=" select * from saldo where tipo_saldo='cooperativa' AND id_saldo='8' and fecha_registro_saldo>='".$_GET['fechaingreso7']."' and fecha_registro_saldo<='".$_GET['fechaingreso8']."' ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);
 
$monto1=$nu['2'];

			$sql2=" select * from saldo where tipo_saldo='cooperativa' AND id_saldo='9' and fecha_registro_saldo>='".$_GET['fechaingreso7']."' and fecha_registro_saldo<='".$_GET['fechaingreso8']."' ";				
$nume=consultaDB($sql2);
$nue=mysql_fetch_array($nume);
 
$monto2=$nue['2'];
//fin
$total=$monto1+$monto2;

						?>
  
    <td width="456">TOTAL :</td>
    <td width="172" align="center" b></td>
	<td width="172" align="center" b><?=$total;?>[Bs]</td>
</table>
	
<div align="center">


<table width="172" border="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</div>

  
<div align="center">
<table width="800" border="1" bordercolor="#000000" align="center" rules="cols">
	<tr>
	<td height="10"  colspan="2" align="left">
	
  <b class="titulo">CAPITAL ACTUAL AL <?php echo $fecha2;?><br></b></td></tr></table>
        
		<table width="800" border="1" align="center"   bordercolor="#000000" rules="cols" >
  <tr>
    <td width="456" height="31"></td>
	<td width="172"></td>
	<td width="172">TOTAL[BS.]</td>
	</tr>
</table>
<table width="800" border="1" bordercolor="#000000" align="center" rules="cols">
    <tr>
	        <?php 
	  $sql1=" select * from saldo where tipo_saldo='cooperativa' AND id_saldo='6' and fecha_registro_saldo>='".$_GET['fechaingreso7']."' and fecha_registro_saldo<='".$_GET['fechaingreso8']."' ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);
$monto1=$nu['2'];
			$sql2=" select * from saldo where tipo_saldo='cooperativa' AND id_saldo='7' and fecha_registro_saldo>='".$_GET['fechaingreso7']."' and fecha_registro_saldo<='".$_GET['fechaingreso8']."' ";				
$nume=consultaDB($sql2);
$nue=mysql_fetch_array($nume);
$monto2=$nue['2'];
$total1=$monto1+$monto2;
//
$sql3=" select * from saldo where tipo_saldo='cooperativa' AND id_saldo='8' and fecha_registro_saldo>='".$_GET['fechaingreso7']."' and fecha_registro_saldo<='".$_GET['fechaingreso8']."' ";				
$numa=consultaDB($sql3);
$nua=mysql_fetch_array($numa);
 
$montoa=$nua['2'];

			$sql4=" select * from saldo where tipo_saldo='cooperativa' AND id_saldo='9' and fecha_registro_saldo>='".$_GET['fechaingreso7']."' and fecha_registro_saldo<='".$_GET['fechaingreso8']."' ";				
$numb=consultaDB($sql4);
$nub=mysql_fetch_array($numb);
 
$montob=$nub['2'];
//fin
$total2=$montoa+$montob;

$total=($total1-$total2);
	
/////////////////////
		echo "<td width='456'>";
		echo "CAPITAL";
        echo "</td>";
		echo "<td width='172' align='center'>";
		echo "($total1-$total2)";
        echo "</td>";
		echo "<td width='172' align='center'>";
		echo "$total";
        echo "</td>";
		
?>
    </tr>
</table>
<table width="800" border="1" bordercolor="#000000" align="center" rules="cols">
    <tr>
	        <?php 
	  $sql1="SELECT sum( p.monto_prestamo )  AS monto_total, COUNT( p.id_prestamo ) AS numero from prestamo_socio p where p.id_tipo_prestamo='2' and p.fecha_prestamo>='".$_GET['fechaingreso7']."' and p.fecha_prestamo<='".$_GET['fechaingreso8']."' ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);

/////////////////////
 $total=$nu[0];
$interes='7.00';
 $interes =($total*($interes/100));
 /////////////////////
		echo "<td width='456'>";
		echo "INTERES GANADO A COOPERATIVA AL $fecha2";
        echo "</td>";
		echo "<td width='172' align='left'>";
		echo "";
        echo "</td>";
		echo "<td width='172' align='center'>";
		echo "$interes";
        echo "</td>";
		
?>
    </tr>
</table>	  
  <table width="800" border="1" bordercolor="#000000" align="center" rules="cols">
  
	  <?php		
	  
	  
	  $sql1=" select * from saldo where tipo_saldo='cooperativa' AND id_saldo='6' and fecha_registro_saldo>='".$_GET['fechaingreso7']."' and fecha_registro_saldo<='".$_GET['fechaingreso8']."' ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);
$monto1=$nu['2'];
			$sql2=" select * from saldo where tipo_saldo='cooperativa' AND id_saldo='7' and fecha_registro_saldo>='".$_GET['fechaingreso7']."' and fecha_registro_saldo<='".$_GET['fechaingreso8']."' ";				
$nume=consultaDB($sql2);
$nue=mysql_fetch_array($nume);
$monto2=$nue['2'];
$total1=$monto1+$monto2;
//
$sql3=" select * from saldo where tipo_saldo='cooperativa' AND id_saldo='8' and fecha_registro_saldo>='".$_GET['fechaingreso7']."' and fecha_registro_saldo<='".$_GET['fechaingreso8']."' ";				
$numa=consultaDB($sql3);
$nua=mysql_fetch_array($numa);
 
$montoa=$nua['2'];

			$sql4=" select * from saldo where tipo_saldo='cooperativa' AND id_saldo='9' and fecha_registro_saldo>='".$_GET['fechaingreso7']."' and fecha_registro_saldo<='".$_GET['fechaingreso8']."' ";				
$numb=consultaDB($sql4);
$nub=mysql_fetch_array($numb);
 
$montob=$nub['2'];
//fin
$total2=$montoa+$montob;

$total=($total1-$total2);

			$sql1="SELECT sum( p.monto_prestamo )  AS monto_total, COUNT( p.id_prestamo ) AS numero from prestamo_socio p where p.id_tipo_prestamo='2' and p.fecha_prestamo>='".$_GET['fechaingreso7']."' and p.fecha_prestamo<='".$_GET['fechaingreso8']."' ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);

/////////////////////
 $totald=$nu[0];
$interes='7.00';
 $interes =($totald*($interes/100));
$porcobrar=$total+$interes;

 ?>
  
    <td width="456">TOTAL /POR COBRAR:</td>
    <td width="172" align="center" b></td>
	<td width="172" align="center" b><?=$porcobrar;?>[Bs]</td>
</table>


<table width="800" border="1" bordercolor="#000000" align="center" rules="cols">
    <tr>
	        <?php 
	   $sql1="SELECT sum( p.monto_prestamo )  AS monto_total, COUNT( p.id_prestamo ) AS numero from prestamo_socio p where p.id_tipo_prestamo='2' and p.fecha_prestamo>='".$_GET['fechaingreso7']."' and p.fecha_prestamo<='".$_GET['fechaingreso8']."' ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);

/////////////////////
 $total=$nu[0];
$interes='7.00';
 $interes =($total*($interes/100));
 $interescapital =$interes +$total;
	///
	$sql2="SELECT SUM(monto_deposito)  AS monto_total, COUNT( id_deposito)from deposito d, prestamo_socio a, tipo_prestamo b where b.interes!='0.00' and a.id_prestamo=d.id_prestamo and a.id_tipo_prestamo=b.id_tipo_prestamo and d.fecha_deposito>='".$_GET['fechaingreso7']."' and d.fecha_deposito<='".$_GET['fechaingreso8']."' ";

$nume=consultaDB($sql2);
$nue=mysql_fetch_array($nume);
$totaldepositado=$nue[0];
	$totaldeuda = $interescapital - $totaldepositado;
	
/////////////////////
		echo "<td width='456'>";
		echo "MONTO POR COBRAR /ADEUDADO";
        echo "</td>";
		echo "<td width='172' align='center'>";
		echo "";
        echo "</td>";
		echo "<td width='172' align='center'>";
		echo "$totaldeuda";
        echo "</td>";
		
?>
    </tr>
</table>
  <table width="800" border="1" bordercolor="#000000" align="center" rules="cols">
  
	  <?php		
	  
	  
	  $sql1=" select * from saldo where tipo_saldo='cooperativa' AND id_saldo='6' and fecha_registro_saldo>='".$_GET['fechaingreso7']."' and fecha_registro_saldo<='".$_GET['fechaingreso8']."' ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);
$monto1=$nu['2'];
			$sql2=" select * from saldo where tipo_saldo='cooperativa' AND id_saldo='7' and fecha_registro_saldo>='".$_GET['fechaingreso7']."' and fecha_registro_saldo<='".$_GET['fechaingreso8']."' ";				
$nume=consultaDB($sql2);
$nue=mysql_fetch_array($nume);
$monto2=$nue['2'];
$total1=$monto1+$monto2;
//
$sql3=" select * from saldo where tipo_saldo='cooperativa' AND id_saldo='8' and fecha_registro_saldo>='".$_GET['fechaingreso7']."' and fecha_registro_saldo<='".$_GET['fechaingreso8']."' ";				
$numa=consultaDB($sql3);
$nua=mysql_fetch_array($numa);
 
$montoa=$nua['2'];

			$sql4=" select * from saldo where tipo_saldo='cooperativa' AND id_saldo='9' and fecha_registro_saldo>='".$_GET['fechaingreso7']."' and fecha_registro_saldo<='".$_GET['fechaingreso8']."' ";				
$numb=consultaDB($sql4);
$nub=mysql_fetch_array($numb);
 
$montob=$nub['2'];
//fin
$total2=$montoa+$montob;

$total=($total1-$total2);

			$sql1="SELECT sum( p.monto_prestamo )  AS monto_total, COUNT( p.id_prestamo ) AS numero from prestamo_socio p where p.id_tipo_prestamo='2' and p.fecha_prestamo>='".$_GET['fechaingreso7']."' and p.fecha_prestamo<='".$_GET['fechaingreso8']."' ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);

/////////////////////
 $totald=$nu[0];
$interes='7.00';
 $interes =($totald*($interes/100));
$porcobrar=$total+$interes;

 $sql1="SELECT sum( p.monto_prestamo )  AS monto_total, COUNT( p.id_prestamo ) AS numero from prestamo_socio p where p.id_tipo_prestamo='2' and p.fecha_prestamo>='".$_GET['fechaingreso7']."' and p.fecha_prestamo<='".$_GET['fechaingreso8']."' ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);

/////////////////////
 $total=$nu[0];
$interes='7.00';
 $interes =($total*($interes/100));
 $interescapital =$interes +$total;
	///
	$sql2="SELECT SUM(monto_deposito)  AS monto_total, COUNT( id_deposito)from deposito d, prestamo_socio a, tipo_prestamo b where b.interes!='0.00' and a.id_prestamo=d.id_prestamo and a.id_tipo_prestamo=b.id_tipo_prestamo and d.fecha_deposito>='".$_GET['fechaingreso7']."' and d.fecha_deposito<='".$_GET['fechaingreso8']."' ";

$nume=consultaDB($sql2);
$nue=mysql_fetch_array($nume);
$totaldepositado=$nue[0];
	$totaldeuda = $interescapital - $totaldepositado;
	$diferencia = ($porcobrar - $totaldeuda);

 ?>
  
    <td width="456">TOTAL /DISPONIBLE:</td>
    <td width="172" align="center" b></td>
	<td width="172" align="center" b><?=$diferencia;?>[Bs]</td>
</table>


  <div align="center">


<table width="172" border="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</div>
<table width="800" border="1" align="center"   bordercolor="#000000" rules="cols" >
  <tr>
    <td width="456" height="31">PRESTAMOS</td>
	<td width="172">CANTIDAD PRESTAMOS</td>
	<td width="172">TOTAL PRESTADO[BS.]</td>
	</tr>
</table>
  

 
	<table width="800" border="1" bordercolor="#000000" align="center" rules="cols">
    <tr>
	        <?php 
	 $sql1="SELECT sum( p.monto_prestamo )  AS monto_total, COUNT( p.id_prestamo ) AS numero from prestamo_socio p where p.id_tipo_prestamo='2' and p.fecha_prestamo>='".$_GET['fechaingreso7']."' and p.fecha_prestamo<='".$_GET['fechaingreso8']."' ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);

/////////////////////
		echo "<td width='456'>";
		echo "Prestamos";
        echo "</td>";
		echo "<td width='172' align='left'>";
		echo "$nu[1]";
        echo "</td>";
		echo "<td width='172' align='center'>";
		echo "$nu[0]";
        echo "</td>";
		
?>
    </tr>
</table>





<table width="172" border="0">
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
