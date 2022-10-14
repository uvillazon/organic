<html>
<head>
<title>Menu de Reportes</title>
<link href="../estilo.css"type=text/css rel=stylesheet></head>
<?php 
	         $fechahoy=date("d-m-Y"); 
//echo $fecha 
    		?>
<body class="sub_body">
<br>
<table width="97%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="0%"><img alt="" src="../imagenes/gblnav_left.gif" height="32" width="8" /></td>
    <td width="99%" background="../imagenes/glbnav_background.gif"><b><font class="texto"><font size="2"><b>REPORTE DE INGRESOS  </b></font></font>:</b></td>
    <td width="0%"><img alt="" src="../imagenes/glbnav_right.gif" height="32" width="8" /></td>
  </tr>
</table>
<div id="mceldaba">
  <img alt="" src="../imagenes/tl_curve_white.gif" height="6" width="6" id="tl" /> <img alt="" src="../imagenes/tr_curve_white.gif" height="6" width="6" id="tr" />
  <table width="85%" border="0" align="center">
  <tr>
    <td><br>
      <form name="mform" method="get" action="mostrar_ingresosmarzo.php">
        <strong>Opciones :</strong><br>
        <table width="100%" border="3">
          
          <tr>
            <td>Rango en Fecha de registro de Ingresos MARZO: 
              <iframe width=132 height=142 name="gToday:contrast:agenda.js" id="gToday:contrast:agenda.js" src="../calendario/rango_fechas/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;"></iframe>  </td>
            
            <td width="25%" align="center"><input name="fechaingreso5" value="" size="12">
              <a onClick="if(self.gfPop)gfPop.fStartPop(document.mform.fechaingres5,document.mform.fechaingreso6);return false;" HIDEFOCUS> </a><a onClick="if(self.gfPop)gfPop.fStartPop(document.mform.fechaingreso5,document.mform.fechaingreso6);return false;" hidefocus>
              <input name="inicio" type="submit" value=".." onClick="void(0);">
              </a></td>
            <td width="24%" align="center"><input name="fechaingreso6" value="2009-03-31" size="12">
              <a onClick="if(self.gfPop)gfPop.fEndPop(document.mform.fechaingreso5,document.mform.fechaingreso6);return false;" hidefocus>
              <input name="inicio2" type="button" value=".." onClick="void(0);">
              </a></td>
          </tr>
          
          <tr>
            <td colspan="4" align="center"><input type="submit" name="Submit" value="M O S T R A R" class="button"></td>
            </tr>
        </table>
        <br>
		<b></b>
         </form> 
		 
		 
		       <form name="mforma" method="get" action="mostrar_ingresos.php">
        <strong>Opciones :</strong><br>
        <table width="100%" border="3">
          
          <tr>
            <td>Rango en Fecha de registro de Ingresos a partir de ABRIL: 
              <iframe width=132 height=142 name="gToday:contrast:agenda.js" id="gToday:contrast:agenda.js" src="../calendario/rango_fechas/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;"></iframe>  </td>
            
            <td width="25%" align="center"><input name="fechaingreso1" value="2009-04-01" size="12">
              <a onClick="if(self.gfPop)gfPop.fStartPop(document.mforma.fechaingreso1,document.mforma.fechaingreso2);return false;" HIDEFOCUS> </a><a onClick="if(self.gfPop)gfPop.fStartPop(document.mforma.fechaingreso1,document.mforma.fechaingreso2);return false;" hidefocus>
              <input name="inicio" type="submit" value=".." onClick="void(0);">
              </a></td>
            <td width="24%" align="center"><input name="fechaingreso2" value="" size="12">
              <a onClick="if(self.gfPop)gfPop.fEndPop(document.mforma.fechaingreso1,document.mforma.fechaingreso2);return false;" hidefocus>
              <input name="inicio2" type="button" value=".." onClick="void(0);">
              </a></td>
          </tr>
          
          <tr>
            <td colspan="4" align="center"><input type="submit" name="Submit" value="M O S T R A R" class="button"></td>
            </tr>
        </table>
        <br>
		 </form> 
		 
		  <br>
		<b></b>
         </form> 
		 
		 
		       <form name="mformad" method="get" action="mostrar_ingresos_d.php">
        <strong>Opciones :</strong><br>
        <table width="100%" border="3">
          
          <tr>
            <td>Rango en Fecha de registro de Ingresos HACIENDA: 
              <iframe width=132 height=142 name="gToday:contrast:agenda.js" id="gToday:contrast:agenda.js" src="../calendario/rango_fechas/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;"></iframe>  </td>
            
            <td width="25%" align="center"><input name="fechaingreso7" value="2009-04-01" size="12">
              <a onClick="if(self.gfPop)gfPop.fStartPop(document.mformad.fechaingreso7,document.mformad.fechaingreso8);return false;" HIDEFOCUS> </a><a onClick="if(self.gfPop)gfPop.fStartPop(document.mformad.fechaingreso7,document.mformad.fechaingreso8);return false;" hidefocus>
              <input name="inicio" type="submit" value=".." onClick="void(0);">
              </a></td>
            <td width="24%" align="center"><input name="fechaingreso8" value="" size="12">
              <a onClick="if(self.gfPop)gfPop.fEndPop(document.mformad.fechaingreso7,document.mformad.fechaingreso8);return false;" hidefocus>
              <input name="inicio2" type="button" value=".." onClick="void(0);">
              </a></td>
          </tr>
          
          <tr>
            <td colspan="4" align="center"><input type="submit" name="Submit" value="M O S T R A R" class="button"></td>
            </tr>
        </table>
        <br>
		<b><a href="../index.php">Volver al Menu Principal</a></b>
         </form> 
		 
		 
		 
		 
      </td>
  </tr>
</table>
  <br>
</div>
</body>
</html>



