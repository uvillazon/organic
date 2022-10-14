<html>
<head>
<title>Reporte Lavadero</title>
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
            <b class="titulo">REPORTE LAVADERO<br>
            DEL 
			<?php 
			$fecha=$_GET['fechaingreso5']; // El formato que te entrega MySQL es Y-m-d 
             $fecha=date("d-m-Y",strtotime($fecha)); 
//echo $fecha 
            $fecha2=$_GET['fechaingreso6']; // El formato que te entrega MySQL es Y-m-d 
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
	  $sql1=" select * from saldo where tipo_saldo='lavadero' AND id_saldo='11' and fecha_registro_saldo>='".$_GET['fechaingreso5']."' and fecha_registro_saldo<='".$_GET['fechaingreso6']."' ";				
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
	  $sql1=" select * from saldo where tipo_saldo='lavadero' AND id_saldo='12' and fecha_registro_saldo>='".$_GET['fechaingreso5']."' and fecha_registro_saldo<='".$_GET['fechaingreso6']."' ";				
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
			$sql1=" select * from saldo where tipo_saldo='lavadero' AND id_saldo='11' and fecha_registro_saldo>='".$_GET['fechaingreso5']."' and fecha_registro_saldo<='".$_GET['fechaingreso6']."' ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);
 
$monto1=$nu['2'];

			$sql2=" select * from saldo where tipo_saldo='lavadero' AND id_saldo='12' and fecha_registro_saldo>='".$_GET['fechaingreso5']."' and fecha_registro_saldo<='".$_GET['fechaingreso6']."' ";				
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
	  $sql1=" select * from saldo where tipo_saldo='lavadero' AND id_saldo='13' and fecha_registro_saldo>='".$_GET['fechaingreso5']."' and fecha_registro_saldo<='".$_GET['fechaingreso6']."' ";				
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
	  $sql1=" select * from saldo where tipo_saldo='lavadero' AND id_saldo='14' and fecha_registro_saldo>='".$_GET['fechaingreso5']."' and fecha_registro_saldo<='".$_GET['fechaingreso6']."' ";				
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
			$sql1=" select * from saldo where tipo_saldo='lavadero' AND id_saldo='13' and fecha_registro_saldo>='".$_GET['fechaingreso5']."' and fecha_registro_saldo<='".$_GET['fechaingreso6']."' ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);
 
$monto1=$nu['2'];

			$sql2=" select * from saldo where tipo_saldo='lavadero' AND id_saldo='14' and fecha_registro_saldo>='".$_GET['fechaingreso5']."' and fecha_registro_saldo<='".$_GET['fechaingreso6']."' ";				
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
	  $sql1=" select * from saldo where tipo_saldo='lavadero' AND id_saldo='11' and fecha_registro_saldo>='".$_GET['fechaingreso5']."' and fecha_registro_saldo<='".$_GET['fechaingreso6']."' ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);
$monto1=$nu['2'];
			$sql2=" select * from saldo where tipo_saldo='lavadero' AND id_saldo='12' and fecha_registro_saldo>='".$_GET['fechaingreso5']."' and fecha_registro_saldo<='".$_GET['fechaingreso6']."' ";				
$nume=consultaDB($sql2);
$nue=mysql_fetch_array($nume);
$monto2=$nue['2'];
$total1=$monto1+$monto2;
//
$sql3=" select * from saldo where tipo_saldo='lavadero' AND id_saldo='13' and fecha_registro_saldo>='".$_GET['fechaingreso5']."' and fecha_registro_saldo<='".$_GET['fechaingreso6']."' ";				
$numa=consultaDB($sql3);
$nua=mysql_fetch_array($numa);
 
$montoa=$nua['2'];

			$sql4=" select * from saldo where tipo_saldo='lavadero' AND id_saldo='14' and fecha_registro_saldo>='".$_GET['fechaingreso5']."' and fecha_registro_saldo<='".$_GET['fechaingreso6']."' ";				
$numb=consultaDB($sql4);
$nub=mysql_fetch_array($numb);
 
$montob=$nub['2'];
//fin
$total2=$montoa+$montob;

$total=($total1-$total2);
	
/////////////////////
		echo "<td width='456'>";
		echo "CAPITAL FISICO Y MONETARIO";
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
        
		<table width="800" border="1" align="center"   bordercolor="#000000" rules="cols" >
</table>
	
<div align="center">


  <div align="center">


<table width="172" border="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</div>
<table width="800" border="1" bordercolor="#000000" align="center" rules="cols">
  
	  <?php		
	  
	  		  $sql1=" select * from saldo where tipo_saldo='lavadero' AND id_saldo='11' and fecha_registro_saldo>='".$_GET['fechaingreso5']."' and fecha_registro_saldo<='".$_GET['fechaingreso6']."' ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);
$monto1=$nu['2'];
			$sql2=" select * from saldo where tipo_saldo='lavadero' AND id_saldo='12' and fecha_registro_saldo>='".$_GET['fechaingreso5']."' and fecha_registro_saldo<='".$_GET['fechaingreso6']."' ";				
$nume=consultaDB($sql2);
$nue=mysql_fetch_array($nume);
$monto2=$nue['2'];
$total1=$monto1+$monto2;
//
$sql3=" select * from saldo where tipo_saldo='lavadero' AND id_saldo='13' and fecha_registro_saldo>='".$_GET['fechaingreso5']."' and fecha_registro_saldo<='".$_GET['fechaingreso6']."' ";				
$numa=consultaDB($sql3);
$nua=mysql_fetch_array($numa);
 
$montoa=$nua['2'];

			$sql4=" select * from saldo where tipo_saldo='lavadero' AND id_saldo='14' and fecha_registro_saldo>='".$_GET['fechaingreso5']."' and fecha_registro_saldo<='".$_GET['fechaingreso6']."' ";				
$numb=consultaDB($sql4);
$nub=mysql_fetch_array($numb);
 
$montob=$nub['2'];
//fin
$total2=$montoa+$montob;

$total=($total1-$total2);
 
//$monto1=$nu['2'];
//$totalaporte = $query->getRow("SUM(montoaporte) as totalDiabs","ingresolubricante i, control_lubricante c","where c.tipo='0' AND i.id_control_lubricante=c.id_control_lubricante  AND i.fecha >= '".$fechaInicio."' and i.fecha <= '".$fechaFin."'");
//		 $totalAporte = $totalaporte['totalDiabs'];
     //$disponiblelu = $saldolu - $totalAporte;

$sql6="SELECT SUM(montoaporte) as totalDiabs from ingresolubricante i where i.tipo='0' AND i.fecha >= '".$_GET['fechaingreso5']."' AND i.fecha <= '".$_GET['fechaingreso6']."' ";				
$nume=consultaDB($sql6);
$nue=mysql_fetch_array($nume);
 
$totalAporte=$nue[0];
$disponiblelu = $total - $totalAporte;

//fin
//$total1=$monto1-$monto2;


//	$diferencia = ($total + $total1);

 ?>
  
    <td width="456">GANANCIA:</td>
    <td width="172" align="center" b></td>
	<td width="172" align="center" b><?=$totalAporte;?>[Bs]</td>
</table>
<table width="800" border="1" bordercolor="#000000" align="center" rules="cols">
  
	  <?php		
	  
	  		  $sql1=" select * from saldo where tipo_saldo='lavadero' AND id_saldo='11' and fecha_registro_saldo>='".$_GET['fechaingreso5']."' and fecha_registro_saldo<='".$_GET['fechaingreso6']."' ";				
$num=consultaDB($sql1);
$nu=mysql_fetch_array($num);
$monto1=$nu['2'];
			$sql2=" select * from saldo where tipo_saldo='lavadero' AND id_saldo='12' and fecha_registro_saldo>='".$_GET['fechaingreso5']."' and fecha_registro_saldo<='".$_GET['fechaingreso6']."' ";				
$nume=consultaDB($sql2);
$nue=mysql_fetch_array($nume);
$monto2=$nue['2'];
$total1=$monto1+$monto2;
//
$sql3=" select * from saldo where tipo_saldo='lavadero' AND id_saldo='13' and fecha_registro_saldo>='".$_GET['fechaingreso5']."' and fecha_registro_saldo<='".$_GET['fechaingreso6']."' ";				
$numa=consultaDB($sql3);
$nua=mysql_fetch_array($numa);
 
$montoa=$nua['2'];

			$sql4=" select * from saldo where tipo_saldo='lavadero' AND id_saldo='14' and fecha_registro_saldo>='".$_GET['fechaingreso5']."' and fecha_registro_saldo<='".$_GET['fechaingreso6']."' ";				
$numb=consultaDB($sql4);
$nub=mysql_fetch_array($numb);
 
$montob=$nub['2'];
//fin
$total2=$montoa+$montob;

$total=($total1-$total2);
 
//$monto1=$nu['2'];
//$totalaporte = $query->getRow("SUM(montoaporte) as totalDiabs","ingresolubricante i, control_lubricante c","where c.tipo='0' AND i.id_control_lubricante=c.id_control_lubricante  AND i.fecha >= '".$fechaInicio."' and i.fecha <= '".$fechaFin."'");
//		 $totalAporte = $totalaporte['totalDiabs'];
     //$disponiblelu = $saldolu - $totalAporte;

$sql6="SELECT SUM(montoaporte) as totalDiabs from ingresolubricante i where i.tipo='0' AND i.fecha >= '".$_GET['fechaingreso5']."' AND i.fecha <= '".$_GET['fechaingreso6']."' ";				
$nume=consultaDB($sql6);
$nue=mysql_fetch_array($nume);
 
$totalAporte=$nue[0];
$disponiblelu = $total - $totalAporte;

//fin
//$total1=$monto1-$monto2;


//	$diferencia = ($total + $total1);

 ?>
  
    <td width="456">DISPONIBLE MONETARIO Y PRODUCTOS:</td>
    <td width="172" align="center" b></td>
	<td width="172" align="center" b><?=$disponiblelu;?>[Bs]</td>
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
