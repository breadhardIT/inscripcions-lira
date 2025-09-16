<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * 
 * layout principal pàgines aplicació
 */

    
global $CONFIG;

header('Content-type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=export_esdeveniment.xls'); //en filename vamos a colocar el nombre con el que el archivo xls sera generado
header('Pragma: no-cache');
header('Expires: 0?');
?>

<!DOCTYPE html PUBLIC “-//W3C//DTD XHTML 1.0 Transitional//EN” “http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd”>
<html xmlns=”http://www.w3.org/1999/xhtml”>
<head>
<meta charset="UTF-8" />
<title>Llistat d'inscrits <?PHP echo $title->title ?></title>
</head>

<body>
<table width=”600? border=”0?>
<tr>
<th width=”600?>
<div style=”color:#003; text-align:center; text-shadow:#666;”><font size=”+2?>Llistat d'inscrits <?PHP echo $title->title ?><br /></font></div></th>
</tr>
</table>       

<?php echo $contenido; ?>

</body>

