<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of querys
 *
 * @author 0001553
 */

/*
 * PERSONES
 */
$query= "SELECT TPERSONA_FOTOGRAFIA, CONCAT(TPERSONA_NOM,' ',TPERSONA_COGNOM1,' ',TPERSONA_COGNOM2) AS TPERSONA_NOM, ";
$query .= "TPERSONA_TELF1, TPERSONA_TELF2, TPERSONA_EMAIL, TPERSONA_DNI, TPERSONA_TARGETASANITARIA, TPERSONA_ID as ACCIONS_ID ";
$query .= "FROM runners_persona ";
if ( !defined('QUERY_PERSONES') ) define('QUERY_PERSONES', $query);

/*
 * QUERY_CARNETSTEMPORADA
 */
$query= "SELECT TPERSONA_FOTOGRAFIA, TPERSONA_NOM, TPERSONA_COGNOM1, TPERSONA_COGNOM2,
TPERSONA_TELF1, TPERSONA_TELF2, TPERSONA_EMAIL, TPERSONA_DNI, TPERSONA_TARGETASANITARIA, TMESTRETEMPORADES_DESCRIPCIO
FROM runners_persona, runners_mestretemporades, runners_inscripcions
WHERE TPERSONA_ID = TINSCRIPCIONS_IDPERSONA
AND TINSCRIPCIONS_IDTEMPORADA = TMESTRETEMPORADES_ID
AND TMESTRETEMPORADES_ACTIVA = 1";
if ( !defined('QUERY_CARNETSTEMPORADA') ) define('QUERY_CARNETSTEMPORADA', $query);

/*
 * QUERY_QUOTESXPERSONA
 */
$query= "SELECT TMESTRETEMPORADES_DESCRIPCIO, TMESTREQUOTES_DESCRIPCIO, TQUOTES_VENCIMENT, TQUOTES_DATACOBRAMENT, TMESTREQUOTES_IMPORT,
TMESTREBONIFICACIONS_DTE, TQUOTES_IMPORTAPAGAR, TQUOTES_IMPORTPAGAT, TQUOTES_ESTAT, TPERSONA_NOM, TPERSONA_COGNOM1, TPERSONA_COGNOM2, TMESTREBONIFICACIONS_DESCRIPCIO, TQUOTES_ID as ACCIONS_ID
FROM runners_quotes, runners_inscripcions, runners_persona, runners_mestrequotes, runners_mestretemporades, runners_mestrebonificacions     
WHERE `TQUOTES_IDINSCRIPCIO` = TINSCRIPCIONS_ID 
AND TINSCRIPCIONS_IDPERSONA = TPERSONA_ID 
and TINSCRIPCIONS_IDTEMPORADA = TMESTRETEMPORADES_ID 
AND TQUOTES_IDTIPUSQUOTA = TMESTREQUOTES_ID
AND TINSCRIPCIONS_IDBONIFICACIO = TMESTREBONIFICACIONS_ID";
if ( !defined('QUERY_QUOTESXPERSONA') ) define('QUERY_QUOTESXPERSONA', $query);

/*
 * QUERY_QUOTESXTEMPORADA
 */
$query= "SELECT TPERSONA_FOTOGRAFIA, CONCAT(TPERSONA_NOM,' ',TPERSONA_COGNOM1,' ',TPERSONA_COGNOM2) AS TPERSONA_NOM, TMESTRETEMPORADES_DESCRIPCIO, TMESTREQUOTES_DESCRIPCIO, 
TQUOTES_VENCIMENT, TQUOTES_DATACOBRAMENT, TMESTREQUOTES_IMPORT, TMESTREBONIFICACIONS_DTE, TQUOTES_IMPORTAPAGAR, TQUOTES_IMPORTPAGAT, TQUOTES_ESTAT,  TMESTREBONIFICACIONS_DESCRIPCIO, TQUOTES_ID as ACCIONS_ID      
FROM runners_quotes, runners_inscripcions, runners_persona, runners_mestrequotes, runners_mestretemporades, runners_mestrebonificacions     
WHERE TQUOTES_IDINSCRIPCIO = TINSCRIPCIONS_ID 
AND TINSCRIPCIONS_IDPERSONA = TPERSONA_ID 
and TINSCRIPCIONS_IDTEMPORADA = TMESTRETEMPORADES_ID 
AND TQUOTES_IDTIPUSQUOTA = TMESTREQUOTES_ID 
AND TINSCRIPCIONS_IDBONIFICACIO = TMESTREBONIFICACIONS_ID
AND TMESTRETEMPORADES_ACTIVA = 1";
if ( !defined('QUERY_QUOTESXTEMPORADA') ) define('QUERY_QUOTESXTEMPORADA', $query);

/*
 * QUERY_ESCOLAXPERSONA
 */
$query= "SELECT TMESTRETEMPORADES_DESCRIPCIO, TMESTREMODALITATS_DESCRIPCIO, CONCAT(TMESTRECATEGORIES_DESCRIPCIO, 
TMESTRECATEGORIES_SUBCATEGORIA) AS TMESTRECATEGORIES_DESCRIPCIO, TESCOLA_AUTORITZACIOFOTO, TESCOLA_AUTORITZACIOSORTIDA 
FROM runners_inscripcionsescola, runners_inscripcions, runners_mestretemporades, runners_mestrecategories, runners_mestremodalitatsinscripcions
WHERE TESCOLA_IDINSCRIPCIO = TINSCRIPCIONS_ID 
AND TMESTRETEMPORADES_ID = TINSCRIPCIONS_IDTEMPORADA 
AND TESCOLA_IDCATEGORIA = TMESTRECATEGORIES_ID
AND TESCOLA_IDMODALITAT = TMESTREMODALITATS_ID
AND TINSCRIPCIONS_TIPUS = 'E'";
if ( !defined('QUERY_ESCOLAXPERSONA') ) define('QUERY_ESCOLAXPERSONA', $query);

/*
 * QUERY_ESCOLAXTEMPORADA
 */
$query= "SELECT TPERSONA_FOTOGRAFIA, CONCAT(TPERSONA_COGNOM1,' ',TPERSONA_COGNOM2,' ',TPERSONA_NOM) AS TPERSONA_NOM,
TMESTRETEMPORADES_DESCRIPCIO, TMESTREMODALITATS_DESCRIPCIO, CONCAT(TMESTRECATEGORIES_DESCRIPCIO, '-', 
TMESTRECATEGORIES_SUBCATEGORIA) AS TMESTRECATEGORIES_DESCRIPCIO, TESCOLA_AUTORITZACIOFOTO, TESCOLA_AUTORITZACIOSORTIDA,  
TPERSONA_ID as ACCIONS_ID  
FROM runners_inscripcionsescola, runners_inscripcions, runners_persona, runners_mestretemporades, runners_mestrecategories, runners_mestremodalitatsinscripcions
WHERE TESCOLA_IDINSCRIPCIO = TINSCRIPCIONS_ID 
AND TINSCRIPCIONS_IDPERSONA = TPERSONA_ID
AND TINSCRIPCIONS_IDTEMPORADA = TMESTRETEMPORADES_ID
AND TESCOLA_IDCATEGORIA = TMESTRECATEGORIES_ID
AND TESCOLA_IDMODALITAT = TMESTREMODALITATS_ID
AND TINSCRIPCIONS_TIPUS = 'E'
AND TMESTRETEMPORADES_ACTIVA = 1";        
if ( !defined('QUERY_ESCOLAXTEMPORADA') ) define('QUERY_ESCOLAXTEMPORADA', $query);

/*
 * QUERY_SOCISXTEMPORADA
 */
$query= "SELECT TPERSONA_FOTOGRAFIA, CONCAT(TPERSONA_COGNOM1,' ',TPERSONA_COGNOM2,' ',TPERSONA_NOM) AS TPERSONA_NOM,
TMESTRETEMPORADES_DESCRIPCIO, TMESTREMODALITATS_DESCRIPCIO, TSOCI_NUMSOCI, TSOCI_DATAALTA, TSOCI_DATABAIXA, TPERSONA_ID as ACCIONS_ID  
FROM runners_inscripcionssoci, runners_inscripcions, runners_persona, runners_mestretemporades, runners_mestremodalitatsinscripcions
WHERE TSOCI_IDINSCRIPCIO = TINSCRIPCIONS_ID 
AND TINSCRIPCIONS_IDPERSONA = TPERSONA_ID
AND TINSCRIPCIONS_IDTEMPORADA = TMESTRETEMPORADES_ID
AND TSOCI_IDMODALITAT = TMESTREMODALITATS_ID
AND TINSCRIPCIONS_TIPUS = 'S'
AND TMESTRETEMPORADES_ACTIVA = 1";        
if ( !defined('QUERY_SOCISXTEMPORADA') ) define('QUERY_SOCISXTEMPORADA', $query);

/*
 * ATLETES X EVENT
 */
$query=" SELECT `tatletes_id`,`tatletes_nom`,`tatletes_cognom1`,`tatletes_cognom2`,`tatletes_llicencia`,YEAR(`tatletes_datanaixement`) as atletes_anynaixement, `tclubs_descripciomale`, `tinscripcions_dorsal` as tatletes_dorsal ";
$query .= "FROM `rfea_atletes`, `rfea_inscripcions`, `rfea_clubs`";
$query .= "WHERE `tatletes_id` = `tinscripcions_idAtleta` AND `tatletes_idClub` = `tclubs_id` AND tinscripcions_idEvent = ";
if ( !defined('ATLETESxEVENT') ) define('ATLETESxEVENT', $query);
/*
 * ATLETES X COMPETICIO
 */
$query=" SELECT `tatletes_id`,`tatletes_nom`,`tatletes_cognom1`,`tatletes_cognom2`,`tatletes_llicencia`,YEAR(`tatletes_datanaixement`) as atletes_anynaixement, `tclubs_descripciomale`, `tinscripcions_dorsal` as tatletes_dorsal, tevents_nom, tevents_idCategoria ";
$query .= "FROM `rfea_atletes`, `rfea_inscripcions`, `rfea_clubs`, rfea_events ";
$query .= "WHERE `tatletes_id` = `tinscripcions_idAtleta` AND `tatletes_idClub` = `tclubs_id` ";
$query .= "AND `tinscripcions_idEvent` = tevents_id ";
$query .= "ORDER BY tatletes_nom ";
if ( !defined('ATLETESxCOMPETICIO') ) define('ATLETESxCOMPETICIO', $query);
/*
 * CLUBS X COMPETICIO
 */
$query =  " SELECT tclubs_descripciomale, tclubs_id ";
$query .= "FROM `rfea_atletes`, `rfea_inscripcions`, `rfea_clubs`, rfea_competicions, rfea_events ";
$query .= "WHERE `tatletes_id` = `tinscripcions_idAtleta` AND `tatletes_idClub` = `tclubs_id` ";
$query .=  "AND `tinscripcions_idEvent` = tevents_id AND tevents_idCompeticio = tcompeticions_id AND `tcompeticions_id` = 1 ";
$query .= "GROUP BY tclubs_descripciomale";
if ( !defined('CLUBSxCOMPETICIO') ) define('CLUBSxCOMPETICIO', $query);

/*
 * DETALL CLUB X COMPETICIO
 */
$query=" SELECT `tatletes_id`,`tatletes_nom`,`tatletes_cognom1`,`tatletes_cognom2`,`tatletes_llicencia`,YEAR(`tatletes_datanaixement`) as atletes_anynaixement, `tclubs_descripciomale`, `tinscripcions_dorsal` as tatletes_dorsal, tevents_nom, tevents_idCategoria, tclubs_id ";
$query .= "FROM `rfea_atletes`, `rfea_inscripcions`, `rfea_clubs`, rfea_events, rfea_competicions ";
$query .= "WHERE `tatletes_id` = `tinscripcions_idAtleta` AND `tatletes_idClub` = `tclubs_id` ";
$query .= "AND `tinscripcions_idEvent` = tevents_id AND tevents_idCompeticio = tcompeticions_id AND `tcompeticions_id` = 1 ";
$query .= "AND tclubs_id='";
if ( !defined('DETALLCLUBXCOMPETICIO') ) define('DETALLCLUBXCOMPETICIO', $query);

/*
 * RESULTATS X EVENT
 */
$query=" SELECT @rownum:=@rownum+1 AS rownum, `tatletes_nom`,`tatletes_cognom1`,`tatletes_cognom2`,`tatletes_llicencia`,YEAR(`tatletes_datanaixement`) as atletes_anynaixement, `tclubs_descripciomale`, `tinscripcions_dorsal` as tatletes_dorsal, tresultats_marca, tresultats_targetes, tresultats_observ ";
$query .= "FROM (SELECT @rownum:=0) r,`rfea_atletes`, `rfea_inscripcions`, `rfea_clubs`, rfea_resultats ";
$query .= "WHERE `tatletes_id` = `tinscripcions_idAtleta` AND `tatletes_idClub` = `tclubs_id` AND tresultats_idAtleta = tatletes_id ";
$query .= "AND tinscripcions_idEvent = ";
if ( !defined('RESULTATSxEVENT') ) define('RESULTATSxEVENT', $query);

