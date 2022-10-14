<?php
	function conectar(){
		$servidorBD = "localhost";
	    $usuario = "root";
	    $clave = "";
		$BD = "sindicato_";
      	$enlace = mysql_connect($servidorBD,$usuario,$clave)
        or die("Existio un error al intentar conectarse al servidor de base de datos");
   		mysql_select_db($BD, $enlace)
        or die("Existio un error al intentar seleccionar la base de datos");
   return $enlace;
      	
	}
	function Obtenerfechaliteral($valor){

		$dia = substr($valor,strlen($valor)-2,strlen($valor));
		$mes = substr($valor,strlen($valor)-5,2);
		$anio = substr($valor,0,4);
		$mes=$mes+0;
		switch ($mes) {
    		 case 1:
       	 	 	$mesliteral="Enero";
      	 	  	break;
     		 case 2:
        	 	$mesliteral="Febrero";
        	  	break;
     		 case 3:
        	 	$mesliteral="Marzo";
       		 	break;
       		 case 4:
        	 	$mesliteral="Abril";
       		 	break;
       		 case 5:
        	 	$mesliteral="Mayo";
       		 	break;
       		 case 6:
        	 	$mesliteral="Junio";
       		 	break;
       		 case 7:
        	 	$mesliteral="Julio";
       		 	break;
       		 case 8:
        	 	$mesliteral="Agosto";
       		 	break;
       		 case 9:
        	 	$mesliteral="Septiembre";
       		 	break;
       		 case 10:
        	 	$mesliteral="Octubre";
       		 	break;
       		 case 11:
        	 	$mesliteral="Noviembre";
       		 	break;	
       		 case 12:
        	 	$mesliteral="Diciembre";
       		 	break;									
 	}
	return $res="$dia de $mesliteral del $anio";
	}
	function obtenernombre($valor,$fecha){
		if($valor==""){
			$nombre="Union De Jovenes Armagedon";
			$imagen="";
		}
		else{
			$enlace=conectar();
			
			$sql="SELECT * FROM USUARIO WHERE ID_USUARIO='$valor'";
			$res=mysql_query( $sql, $enlace )
   			or die( "No se pudo realizar la consulta" );
			$ress=mysql_fetch_Array($res);
   			$usu=$ress['NOMBRE'];
   			$apa=$ress['APELLIDO_PATERNO'];
   			$apa1=$ress['APELLIDO_MATERNO'];
   			$nombre="$usu $apa $apa1";
			$imagen="<a href='cerrarsession.php'><img title='cerrar session' src='imagenes/salir.gif' width='20' height='20' border='0' />";
			
		}
		return "
		<tr bgcolor='#336699'>
				<td colspan='2'>
					<table width='720' border='0'>
                      <tr>

                      <td width='600'><span class='Estilo1'>[$nombre] Usted es el visitante N:
						
                      [Fecha: $fecha] $imagen</span></td>
                        <td width='120'>
                        	<form name='clock' onsubmit='0'>
                        	<span class='Estilo1'>Hrs</span>
														<input name='face' size='13' value='' style='border: medium hidden ;' type='text'>
													</form>
                        </td>
                      </tr>
                    </table>
					</td>
			</tr>
		";
	}
	function nombre($valor){
		$enlace=conectar();
			
			$sql="SELECT * FROM USUARIO WHERE ID_USUARIO=$valor";
			$res=mysql_query( $sql, $enlace )
   			or die( "No se pudo realizar la consulta" );
			$ress=mysql_fetch_Array($res);
   			$usu=$ress['NOMBRE'];
   			$apa=$ress['APELLIDO_PATERNO'];
   			$apa1=$ress['APELLIDO_MATERNO'];
   			return $nombre="$usu $apa";
	}
	function username($valor){
		$enlace=conectar();
			
			$sql="SELECT * FROM USUARIO WHERE ID_USUARIO=$valor";
			$res=mysql_query( $sql, $enlace )
   			or die( "No se pudo realizar la consulta" );
			$ress=mysql_fetch_Array($res);
   			$usu=$ress['USERNAME'];
   			$apa=$ress['APELLIDO_PATERNO'];
   			$apa1=$ress['APELLIDO_MATERNO'];
   			return $nombre="$usu";
	}
	function maxtop(){
		$enlace=conectar();
		$sql="
		select MAX(ID_TOP) FROM TOP;
		";
		$res=mysql_query( $sql, $enlace )
   		or die( "No se pudo realizar la consulta" );
		$ress=mysql_fetch_Array($res);
   		$valor=$ress['MAX'];
   		return "$valor";
   			
	}
	function contadorimagen($valor){
		$enlace=conectar();
		$sql="
		UPDATE IMAGEN SET CONTADOR_IMAGEN=CONTADOR_IMAGEN+1 WHERE ID_IMAGEN='$valor';
		";
		$res=mysql_query( $sql, $enlace )
   		or die( "No se pudo realizar la consulta" );
		
		return 1;
	}
	function ValidarCorreo($email){
    $mail_correcto = 0;
    //compruebo unas cosas primeras
    if ((strlen($email) >= 6) && (substr_count($email,"@") == 1) && (substr($email,0,1) != "@") && (substr($email,strlen($email)-1,1) != "@")){
       if ((!strstr($email,"'")) && (!strstr($email,"\"")) && (!strstr($email,"\\")) && (!strstr($email,"\$")) && (!strstr($email," "))) {
          //miro si tiene caracter .
          if (substr_count($email,".")>= 1){
             //obtengo la terminacion del dominio
             $term_dom = substr(strrchr ($email, '.'),1);
             //compruebo que la terminación del dominio sea correcta
             if (strlen($term_dom)>1 && strlen($term_dom)<5 && (!strstr($term_dom,"@")) ){
                //compruebo que lo de antes del dominio sea correcto
                $antes_dom = substr($email,0,strlen($email) - strlen($term_dom) - 1);
                $caracter_ult = substr($antes_dom,strlen($antes_dom)-1,1);
                if ($caracter_ult != "@" && $caracter_ult != "."){
                   $mail_correcto = 1;
                }
             }
          }
       }
    }
    if ($mail_correcto)
       return 1;
    else
       return 0; 
	}	
	function Verificarfechahappy($valor){
		
		$year=date('Y');
		$limit1=$year-10;
		$limit2=$year-65;
		$ano=substr($valor,0,4);
		if(($ano>=$limit2)&&($ano<=$limit1)){
			return $r=0;
		}
		else{
			return $r=1; 
		}
		
	}
	function VerificarLogin($valor)	{
	
   	$enlace = conectar();
   	
	$slq="
	SELECT * FROM USUARIO WHERE USERNAME='$valor';
	";
	$res=mysql_query($slq,$enlace);
	$num=mysql_num_rows($res);
	if($num==0){
		return $r=0;
	}
	else {
		return $r=1;
	}
}
	function idusuario(){
	$enlace = conectar();
   	
	$slq="
	SELECT MAX(ID_USUARIO) FROM USUARIO;
	";
	$res=mysql_query($slq,$enlace);
	$num=mysql_num_rows($res);
	
	if($num==0){
		$r=1000000;
	}
	else {
		$res1=mysql_fetch_array($res);
		$r=$res1['MAX(ID_USUARIO)']+1;
		
		
	}
	return $r;
}
	function VerificarPassword($valor1,$valor2){
		$links=conectar();
		$sql="
		select * from usuario where username='$valor1' and contrasena=md5('$valor2');
		";
		$result=mysql_query($sql,$links);
		$rows=mysql_num_rows($result);
		if($rows==1){
			$nivel=mysql_fetch_array($result);
			return $nivel['tipo_usuario'];
		}
		else{
			return $r=5;
		}
		
	}
	function ObtenerID($valor1){
		$links=conectar();
		$sql="
		select * from usuario where username='$valor1'; 
		";
		$result=mysql_query($sql,$links);
		$r=mysql_fetch_array($result);
		return $r['id_usuario'];
	}
	function generarfotos($valor){
		$ext=substr($valor,$valor-3,3);
		$year=date('YmdGis');
		return $nombre="$year.$ext";
	}
	function idfotos(){
	$enlace = conectar();
   	
	$slq="
	SELECT MAX(ID_IMAGEN) FROM IMAGEN;
	";
	$res=mysql_query($slq,$enlace);
	$num=mysql_num_rows($res);
	
	if($num==0){
		$r=1;
	}
	else {
		$res1=mysql_fetch_array($res);
		$r=$res1['MAX(ID_IMAGEN)']+1;
		
		
	}
	return $r;
}
	function generaridcomentario(){
	$enlace = conectar();
   	
	$slq="
	SELECT MAX(ID_IMAGEN_COMENTARIO) FROM COMENTARIO_IMAGEN;
	";
	$res=mysql_query($slq,$enlace);
	$num=mysql_num_rows($res);
	
	if($num==0){
		$r=1;
	}
	else {
		$res1=mysql_fetch_array($res);
		$r=$res1['MAX(ID_IMAGEN_COMENTARIO)']+1;
		
		
	}
	return $r;
	}
	function obtenerconcurso($valor){
		$enlace=conectar();
		$sql="
	select * FROM CONCURSO where ID_CONCURSO='$valor';

	";
	$res=mysql_query($sql,$enlace) or die("error");
	$row=mysql_fetch_Array($res);
	return $concurso=$row['CONCURSO'];
	}
	function idpar(){
	$enlace = conectar();
   	
	$slq="
	SELECT MAX(ID_PARTICIPANTE) FROM PARTICIPANTE;
	";
	$res=mysql_query($slq,$enlace);
	$num=mysql_num_rows($res);
	
	if($num==0){
		$r=1;
	}
	else {
		$res1=mysql_fetch_array($res);
		$r=$res1['MAX(ID_PARTICIPANTE)']+1;
		
		
	}
	return $r;
}
	function idartista(){
		$enlace = conectar();
   	
	$slq="
	SELECT MAX(ID_ARTISTA) FROM ARTISTA;
	";
	$res=mysql_query($slq,$enlace);
	$num=mysql_num_rows($res);
	
	if($num==0){
		$r=1;
	}
	else {
		$res1=mysql_fetch_array($res);
		$r=$res1['MAX(ID_ARTISTA)']+1;
		
		
	}
	return $r;
	}
	function idcancion(){
		
		$enlace = conectar();
   	
	$slq="
	SELECT MAX(ID_CANCION) FROM CANCION;
	";
	$res=mysql_query($slq,$enlace);
	$num=mysql_num_rows($res);
	
	if($num==0){
		$r=1;
	}
	else {
		$res1=mysql_fetch_array($res);
		$r=$res1['MAX(ID_CANCION)']+1;
		
		
	}
	return $r;
	}
	
	function idvideo(){
	$enlace = conectar();
   	
	$slq="
	SELECT MAX(ID_VIDEO) FROM VIDEO;
	";
	$res=mysql_query($slq,$enlace);
	$num=mysql_num_rows($res);
	
	if($num==0){
		$r=1;
	}
	else {
		$res1=mysql_fetch_array($res);
		$r=$res1['MAX(ID_VIDEO)']+1;
		
		
	}
	return $r;
}
	function idalbum(){
	$enlace = conectar();
   	
	$slq="
	SELECT MAX(ID_ALBUM) FROM ALBUM;
	";
	$res=mysql_query($slq,$enlace);
	$num=mysql_num_rows($res);
	
	if($num==0){
		$r=1;
	}
	else {
		$res1=mysql_fetch_array($res);
		$r=$res1['MAX(ID_ALBUM)']+1;
		
		
	}
	return $r;
}
	function generaridcomentariovideo(){
	$enlace = conectar();
   	
	$slq="
	SELECT MAX(ID_COMENTARIO_VIDEO) FROM COMENTARIO_VIDEO;
	";
	$res=mysql_query($slq,$enlace);
	$num=mysql_num_rows($res);
	
	if($num==0){
		$r=1;
	}
	else {
		$res1=mysql_fetch_array($res);
		$r=$res1['MAX(ID_COMENTARIO_VIDEO)']+1;
		
		
	}
	return $r;
	}
	function contcomentario($valor){
		$enlace = conectar();
   	
		$slq="
		SELECT COUNT(ID_COMENTARIO) FROM COMENTARIO where ID_FORO='$valor';
	";
		$res=mysql_query($slq,$enlace);
		$res1=mysql_fetch_array($res);
		return $r=$res1['COUNT(ID_COMENTARIO)'];
	}
	function idforo(){
	$enlace = conectar();
   	
	$slq="
	SELECT MAX(ID_FORO) FROM FORO;
	";
	$res=mysql_query($slq,$enlace);
	$num=mysql_num_rows($res);
	
	if($num==0){
		$r=1;
	}
	else {
		$res1=mysql_fetch_array($res);
		$r=$res1['MAX(ID_FORO)']+1;
		
		
	}
	return $r;
}
	function idcomentario(){
	$enlace = conectar();
   	
	$slq="
	SELECT MAX(ID_COMENTARIO) FROM COMENTARIO;
	";
	$res=mysql_query($slq,$enlace);
	$num=mysql_num_rows($res);
	
	if($num==0){
		$r=1;
	}
	else {
		$res1=mysql_fetch_array($res);
		$r=$res1['MAX(ID_COMENTARIO)']+1;
		
		
	}
	return $r;
}
	function tipoaviso($valor){
		$enlace=conectar();
			
			$sql="SELECT * FROM TIPO_NOTICIA WHERE ID_TIPO_NOTICIA='$valor'";
			$res=mysql_query( $sql, $enlace )
   			or die( "No se pudo realizar la consulta" );
			$ress=mysql_fetch_Array($res);
   			$tipo=$ress['TIPO_NOTICIA'];
   			return $nombre="$tipo";
	}
	function idaviso(){
	$enlace = conectar();
   	
	$slq="
	SELECT MAX(ID_NOTICIA) FROM NOTICIA;
	";
	$res=mysql_query($slq,$enlace);
	$num=mysql_num_rows($res);
	
	if($num==0){
		$r=1;
	}
	else {
		$res1=mysql_fetch_array($res);
		$r=$res1['MAX(ID_NOTICIA)']+1;
		
		
	}
	return $r;
}

	function idsugerencia(){
	$enlace = conectar();
   	
	$slq="
	SELECT MAX(ID_SUGERENCIA) FROM SUGERENCIA;
	";
	$res=mysql_query($slq,$enlace);
	$num=mysql_num_rows($res);
	
	if($num==0){
		$r=1;
	}
	else {
		$res1=mysql_fetch_array($res);
		$r=$res1['MAX(ID_SUGERENCIA)']+1;
		
		
	}
	return $r;
}
	?>
