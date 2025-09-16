<?php


/**************************************************************************
   URL Management functions
 **************************************************************************/

function URLEncodeArray($a_array)
{
    foreach ($a_array as $m_key=>$s_str)
    {
        // only encode the value after the '='
        if (($i_pos = strpos($s_str,'=')) !== false)
            $a_array[$m_key] = substr($s_str,0,$i_pos+1).
                                urlencode(substr($s_str,$i_pos+1));
        else
            $a_array[$m_key] = urlencode($s_str);
    }
    return ($a_array);
}

function AddURLParams($s_url,$m_params,$b_encode = true)
{
    if (!empty($m_params))
    {
        if (!is_array($m_params))
            $m_params = array($m_params);
        if (strpos($s_url,'?') === false)
            $s_url .= '?';
        else
            $s_url .= '&';
        $s_url .= implode('&',($b_encode) ? URLEncodeArray($m_params) : $m_params);
    }
    return ($s_url);
}

function Redirect($url)
{
	// this is probably a good idea to ensure the session data
	// is written away
	header("Location: $url");

	// if the header doesn't work, try JavaScript.
	// if that doesn't work, provide a manual link
	$s_text .= "<script language=\"JavaScript\" type=\"text/javascript\">";
	$s_text .= "window.location.href = '$url';";
	$s_text .= "</script>";
	CreatePage($s_text);
	exit;
}
function CreatePage($text,$b_show_about = true)
{
    global  $FM_VERS,$sHTMLCharSet;

    echo "<html>\n";
    echo "<head>\n";
    if (isset($sHTMLCharSet) && $sHTMLCharSet !== "")
        echo "<META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; charset=$sHTMLCharSet\">\n";
    echo "</head>\n";
    echo "<body>\n";
    echo nl2br($text);
    echo "<p />";
    echo "</body>\n";
    echo "</html>\n";
}

function getURL(){
    $url="http://".$_SERVER['HTTP_HOST'].":".$_SERVER['SERVER_PORT'].$_SERVER['REQUEST_URI'];
    return $url;
}


/**************************************************************************
   DATE TIME functions
 **************************************************************************/

date_default_timezone_set("Europe/Madrid");
   
/** Tabla de meses */
   $meses = array ("Gener","Febrer","Mar&ccedil;","Abril","Maig","Juny","Juliol","Agost","Setembre","Octubre","Novembre","Desembre");
   $dies = array("Diumenge","Dilluns","Dimarts","Dimecres","Dijous","Divendres","Dissabte");   

/** Convertir data en format americà **/
function date2UKformat ($data, $separador) {

    if ($data == '') return '';
    
    list($dia, $mes, $any) = explode($separador, $data);
    $date = date_create($any.'/'.$mes.'/'.$dia);
    
    return date_format($date, "Y-m-d");
}

function date2SPformat ($data, $separador) {
    
    if ($data == '') return '';
    
    list($dia, $mes, $any) = explode($separador, $data);
    $date = date_create($dia.'/'.$mes.'/'.$any);
    
    return date_format($date, "d-m-Y");
}

/** obtener el intervalo de tiempo entre dos fechas **/
function interval_date($init,$finish)
{
    //formateamos las fechas a segundos tipo 1374998435
    $diferencia = strtotime($finish) - strtotime($init);
 
    //comprobamos el tiempo que ha pasado en segundos entre las dos fechas
    //floor devuelve el número entero anterior, si es 5.7 devuelve 5
    if($diferencia < 60){
        $segundos = floor($diferencia);
        
        $tiempo = "Hace " . floor($diferencia) . " segundos";
    }else if($diferencia > 60 && $diferencia < 3600){
        $tiempo = "Hace " . floor($diferencia/60) . " minutos'";
    }else if($diferencia > 3600 && $diferencia < 86400){
        $tiempo = "Hace " . floor($diferencia/3600) . " horas";
    }else if($diferencia > 86400 && $diferencia < 2592000){
        $tiempo = "Hace " . floor($diferencia/86400) . " días";
    }else if($diferencia > 2592000 && $diferencia < 31104000){
        $tiempo = "Hace " . floor($diferencia/2592000) . " meses";
    }else if($diferencia > 31104000){
        $tiempo = "Hace " . floor($diferencia/31104000) . " años";
    }else{
        $tiempo = "Error";
    }
    return $tiempo;
}



/** Convertir fecha a cadena */
function date2string ($date, $tipus)
{
   // Formato: d�a del mes (n�mero, sin ceros) /
   //          mes del a�o (n�mero, sin ceros) /
   //          a�o (cuatro d�gitos)
   // Ejemplo: 7/11/2002
   // $tipus: '0' posar zeros als numeros, '1' no posar zeros als numeros
      
	if (!$date) {
		$string = "";
	}
	else {
		if ($tipus == '0') {
			$dia = dayofdate($date);
			if ($dia < 10) $dia = '0' . $dia;		
			$mes = monthofdate($date);
			if ($mes < 10) $mes = '0' . $mes;		
			
			$string = $dia . "." . $mes . "." . yearofdate($date);
		}
		else $string = date ("j.n.Y", strtotime($date));
	}
	return ($string);
}

/** Convertir (dia, mes, año) en fecha */
function dmy2date ($dia, $mes, $anyo)
{
   $meses = array ("Gener","Febrer","Març","Abril","Maig","Juny","Juliol","Agost","Setembre","Octubre","Novembre","Desembre");
   $i=0;
   $enc=0;
   while ($i<12 && !$enc)
   {
      if ($meses[$i] == $mes)
         $enc = 1;
      else
         $i++;
   }
   $fecha = date ("Y-m-d", mktime (0, 0, 0, $i+1, $dia, $anyo));
   return ($fecha);
}

function date2label ($date) {
   
   $meses = array ("Gener","Febrer","Mar�","Abril","Maig","Juny","Juliol","Agost","Setembre","Octubre","Novembre","Desembre");
   $dies = array("Diumenge","Dilluns","Dimarts","Dimecres","Dijous","Divendres","Dissabte");   
   
   $diaSetmana = jddayofweek(cal_to_jd(CAL_GREGORIAN, date("m"),date("d"), date("Y")) , 0 );
   
   $string = $dies[$diaSetmana] . ", " . dayofdate($date) . " de " . $meses[monthofdate($date) -1] . " de " . yearofdate($date);   
   return ($string);
}

/** Obtener el d�a del mes de una fecha */
function dayofdate ($date)
{
   $dia = date ("j", strtotime($date));
   return ($dia);
}

/** Obtener el mes del a�o de una fecha */
function monthofdate ($date)
{
   $mes = date ("n", strtotime($date));
   return ($mes);
}

/** Obtener el a�o de una fecha */
function yearofdate ($date)
{
   $anyo = date ("Y", strtotime($date));
   return ($anyo);
}

/** Obtener la fecha de hoy */
function today ()
{
   $todayDate = date ("Y-m-d");
   return ($todayDate);
}

/** Obtener el n�mero de d�as de un mes dado de un a�o dado */
function daysofMonth ($month, $year)
{
   $ndays = date ("t", mktime (0, 0, 0, 1, $month, $year));
   return ($ndays);
}


/**************************************************************************
   CATEGORY functions
 **************************************************************************/

function calculCategoria ($dataNaixement, $modalitat, $temporada)
{
   // $modalitat: tipus de modalitat de l'escola, '3' Federats, altres, escolar
   // $datanaixement: data naixement del nen

   $categories = array ("","P3", "P4", "P5", "Prebenjami", "Benjami", "Alevi", "Infantil","Cadet","Juvenil","Junior","Promesa","Senior","Veterà");
   $federats = array (0,0,0,0,0,0,0,5,5,6,6,7,7,8,8,9,9,10,10,11,11,11,12,13);
   $escolar = array (0,0,0,1,2,3,4,4,5,5,6,6,7,7,8,8,9,9);
   
   	if (!$dataNaixement) {
		$string = "";
	}
	else {
                list($any_ini, $any_fi) = explode('-', $temporada);
		$dif = $any_ini - yearofdate($dataNaixement);	
		if ($modalitat == '3') $index = $federats[$dif];
		else $index = $escolar[$dif];
		$string = $categories[$index];
	}
	
	return ($string);
}

function pintarResultatsCercaWeb($llistaCamps, $llistaResultats, $llistaCampsOcults, $pagina) {

	$nColumnes = 8;

	if ($llistaCamps != '') {
		print("<div id='borde' class='borde'>");	
			print('<legend class="apartadosficha" style="width:15%; margin-top:-12px;">Criteris de cerca</legend>');		
			print('<FORM NAME="selecciona" ACTION="' . $pagina .'" method="post">');
				print ("<table width='100%'>");
				print ("<tr>");
				for($i=0; $i < count($llistaCamps); $i++) {
					print("<td class='normal'>&nbsp;" . $llistaCamps[$i] . ": <input type='text' name='" . $llistaCamps[++$i] . "' value='" . $llistaCamps[++$i] ."'></td>");
					if ($i == $nColumnes) print ("</tr><tr>");				
				}
				print ("</tr>");				
				print('<tr><td class="normal derecha" colspan="6"><a class="boto" href="javascript:filtrar();">Filtrar');
				print ("<img border='0' align='absmiddle' class='imgnoborder' src='../img/zoom_refresh.png'>\n");
				print ('</a>');
				print ("&nbsp;&nbsp;");				
				print ('<a class="boto" href="javascript:netejarForm(document.forms[0]);";>Netejar');
				print ("<img border='0' align='absmiddle' class='imgnoborder' src='../img/draw_eraser.png'>\n");
				print ("</a>\n");
				print ("</td></tr>");
				print('</table>');	
				if ($llistaCampsOcults != '') {
					for($j=0; $j < count($llistaCampsOcults); $j++) {
						print("<input type='hidden' name='" .$llistaCampsOcults[$j] . "' value='" . $llistaCampsOcults[++$j] ."'>");
					}					
				}
			print('</form>');
	}
	print("</div>");
	print("<br>");
}