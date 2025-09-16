<?php

/* 
 * Copyright (c) 2009 Nguyen Duc Thuan <me@ndthuan.com>
 * All rights reserved.
 */

class DataGrid
{    
    protected $_columns         = array();
    protected $_headers         = array();
    protected $_cellTemplates   = array();
    
    protected $_enabledSorting  = false;
    protected $_enabledSearch   = false;
    protected $_enabledActions  = false;
    protected $_enableTreetable = false;
    protected $_enabledNavigation  = false; 
    
    protected $_sortableFields  = array();
    protected $_sortQuery       = null;    
    protected $_sortQueryDefault = null;        
       
    protected $_gridSearch      = array();    
    protected $_columnsSearch   = 3;
    
    protected $_alterRowClass   = null;
    protected $_rowClass        = null;
    protected $_cellClass       = array();    
    
    protected $_datarows        = array();
    protected $_tableId         = 0;
    protected $_gridActions     = array();

    protected $_gridAttributes  = array();
    protected $_rowAttributes   = array();    
    protected $_cellAttributes  = array();    
    
    protected $_startingCounter = 0;

    protected $_navigationRows  = 0;
    protected $_navigationPage  = 1;  
    protected $_navigationInit  = 1;  
    protected $_navigationQuery = null;

    protected $_dataQuery       = null;
    protected $_dataNumberRowsQuery = 0;
    
    protected $_treetableHeader = null;
    
    protected static $_staticTableId    = 0;

    /**
     *
     * @param array $datarows
     * @return Fete_ViewControl_DataGrid
     */
    public static function getInstance($query)
    {
        return new self($query);
    }

    public function __construct($query)
    {        
        $this->_dataQuery = $query;
        $this->_tableId = ++self::$_staticTableId;
        $this->_gridAttributes['id'] = 'fdg_' . $this->_tableId;
    }

    /**
rid
     */        
    public function getData(){
        
        global $model;
        $datarows = array();
        
        // construir els criteris de cerca
        if (isset($this->_gridSearch)) {
            foreach($this->_gridSearch as $search) {
                if ($search['value'] <> '')
                    $this->_dataQuery .= " AND " .$search['id'] . "='" .$search['value']. "'";
            }            
        } 
        $consulta = $model->query($this->_dataQuery);  
        if ($consulta) {$this->_dataNumberRowsQuery = mysql_num_rows ($consulta);}
        
        
        // resta de la query: ORDER BY i navegació
        $this->_dataQuery .= ' ' .$this->_sortQuery. ' ' .$this->_navigationQuery;
        $consulta = $model->query($this->_dataQuery);                        

        if ($consulta) {
            while ($row = mysql_fetch_assoc($consulta)) {
                $datarows[] = $row;
            }

            $this->_datarows = $datarows;

            if (isset($datarows[0])) {
                foreach ($datarows[0] as $field => $value)
                {
                    $this->_columns[] = $field;
                    $this->_sortableFields[] = $field;
                }
            }
        }    
        return $this;
    }
    
    /**
     *
     * @param boolean $enabled
     * @return Fete_ViewControl_DataGrid
     */
    public function &enableSorting($enabled)
    {
        $this->_enabledSorting = $enabled;

        return $this;
    }

        /**
     *
     * @param boolean $enabled
     * @return Fete_ViewControl_DataGrid
     */
    public function &enableNavigation($enabled)
    {
        $this->_enabledNavigation = $enabled;

        return $this;
    }

     /*
     * @param boolean $enabled
     * @return Fete_ViewControl_DataGrid
     */
    public function &enableSearch($enabled)
    {
        $this->_enabledSearch = $enabled;

        return $this;
    }

    /*
     * @param boolean $enabled
     * @return Fete_ViewControl_DataGrid
     */
    public function &enableActions($enabled)
    {
        $this->_enabledActions = $enabled;

        return $this;
    }
    
    /*
     * @param boolean $enabled
     * @return Fete_ViewControl_DataGrid
     */
    public function &enableTreetable($enabled)
    {
        $this->_enableTreetable = $enabled;

        return $this;
    }    
    
    
    /**
     *
     * @param array $settings
     * @return Fete_ViewControl_DataGrid
     */
    public function &setGridFields($settings)
    {
        foreach ($settings as $field => $setting)
        {
            if (isset($setting['header'])) {
                $this->_headers[$field] = $setting['header'];
            }

            if (isset($setting['cellTemplate'])) {
                $this->_cellTemplates[$field] = $setting['cellTemplate'];
            }

            if (isset($setting['attributes'])) {
                $this->_cellAttributes[$field] = $setting['attributes'];
            }
            
            if (isset($setting['class'])) {
                $this->_cellClass[$field] = $setting['class'];
             }            
        }

        return $this;
    }

    /**
     *
     * @param array $attributes
     * @return Fete_ViewControl_DataGrid
     */
    public function &setGridAttributes($attributes)
    {
        foreach ($attributes as $name => $value)
        {
            $this->_gridAttributes[$name] = $value;
        }

        return $this;
    }

    /**
     *
     * @param string $name
     * @param string $value
     * @return Fete_ViewControl_DataGrid
     */
    public function &setGridAttribute($name, $value)
    {
        $this->_gridAttributes[$name] = $value;

        return $this;
    }

    public function &setGridNavigation ($np, $nr) {
        
        $this->_navigationRows  = $nr;
        $this->_navigationPage  = $np;  

        if ($this->_enabledNavigation)
        {    
            if (!$np) {
                    $inici = 0;
                    $this->_navigationPage = 1;
            }
            else {$inici = ($this->_navigationPage - 1) * $this->_navigationRows; }

            $this->_navigationQuery .=  "LIMIT " . $inici . ", " . $this->_navigationRows;
            $this->_navigationInit  = $inici + 1;              
        }
        return $this;
    }

    /**
     *
     * @param array $actions
     * @return Fete_ViewControl_DataGrid
     */    
    public function &setGridActions($actions){
        
        foreach ($actions as $action => $setting) {
            $this->_gridActions[$action] = $setting;
        }
                
        return $this;
    }
    
    /**
     *
     * @param array $actions
     * @return Fete_ViewControl_DataGrid
     */    
    public function &setGridSearch($searchs){
        
        foreach ($searchs as $search => $setting) {
            $this->_gridSearch[$search] = $setting;
        }        
                
        return $this;
    }
    
    /**
     * @param string $sort
     * @return Fete_ViewControl_DataGrid
     */    
    public function &setGridSort($sortfield, $sortorder, $default){
        if ($sortfield <> '') { 
            $this->_sortQuery = 'ORDER BY ' .$sortfield. ' ' .$sortorder;}
        else $this->_sortQuery = 'ORDER BY ' .$default. ' ASC';
        
        return $this;
    }
        
    
    /**
     * @param string $title
     * @return Fete_ViewControl_DataGrid
     */    
    public function &setGridTreetable($header_tt){
        if ($header_tt <> '') { 
            $this->_treetableHeader = $header_tt;
        }

        return $this;        
    }   
    
    
    /**
     *
     * @param array $attributes
     * @return DataGrid
     */
    public function &setRowAttributes($attributes)
    {
        foreach ($attributes as $name => $value)
        {
            $this->_rowAttributes[$name] = $value;
        }

        return $this;
    }
    
    /**
     *
     * @param string $field
     * @param string $template
     * @return Fete_ViewControl_DataGrid
     */
    public function &setCellTemplate($field, $template)
    {
        $this->_cellTemplates[$field] = $template;

        return $this;
    }

    /**
     *
     * @param string $field
     * @param array $attributes
     * @return Fete_ViewControl_DataGrid
     */
    public function &setCellAttributes($field, $attributes)
    {
        if (isset($this->_cellAttributes[$field])) {
            foreach ($attributes as $name => $value)
            {
                $this->_cellAttributes[$field][$name] = $value;
            }
        } else {
            $this->_cellAttributes[$field] = $attributes;
        }

        return $this;
    }

    /**
     *
     * @param string $field
     * @param string $name
     * @param string $value
     * @return Fete_ViewControl_DataGrid
     */
    public function &setCellAttribute($field, $name, $value)
    {
        if (isset($this->_cellAttributes[$field])) {
            $this->_cellAttributes[$field][$name] = $value;
        }

        $this->_cellAttributes[$field] = array($name => $value);

        return $this;
    }

    /**
     *
     * @param string $field
     * @param string $header
     * @return Fete_ViewControl_DataGrid
     */
    public function &setHeader($field, $header)
    {
        $this->_headers[$field] = $header;

        return $this;
    }

    /**
     *
     * @param string $columnName
     * @return Fete_ViewControl_DataGrid
     */
    public function &removeColumn($columnName)
    {
        $counter = 0;
        foreach ($this->_columns as $column)
        {
            if ($column === $columnName) {
                array_splice($this->_columns, $counter, 1);
                return $this;
            }
            ++$counter;
        }

        return $this;
    }

    /**
     *
     * @param string $columnName
     * @param string $cellTemplate
     * @param string $header
     * @param array $attributes
     * @return Fete_ViewControl_DataGrid
     */
    public function &addColumnBefore($columnName, $cellTemplate = '', $header = '', $attributes = array())
    {
        $this->_columns = array_merge(array($columnName), $this->_columns);
        $this->_cellTemplates[$columnName] = $cellTemplate;
        $this->_headers[$columnName] = $header;
        $this->_cellAttributes[$columnName] = $attributes;

        return $this;
    }

    /**
     *
     * @param string $columnName
     * @param string $cellTemplate
     * @param string $header
     * @param array $attributes
     * @return Fete_ViewControl_DataGrid
     */
    public function &addColumnAfter($columnName, $cellTemplate = '', $header = '', $attributes = array())
    {
        $this->_columns[] = $columnName;
        $this->_cellTemplates[$columnName] = $cellTemplate;
        $this->_headers[$columnName] = $header;
        $this->_cellAttributes[$columnName] = $attributes;

        return $this;
    }
   
    /**
     *
     * @param string $cssClass
     * @return Fete_ViewControl_DataGrid
     */
    public function &setRowClass($cssClass)
    {
        $this->_rowClass = $cssClass;

        return $this;
    }

    /**
     *
     * @param string $cssClass
     * @return Fete_ViewControl_DataGrid
     */
    public function &setAlterRowClass($cssClass)
    {
        $this->_alterRowClass = $cssClass;

        return $this;
    }

    /**
     *
     * @param integer $counter
     * @return Fete_ViewControl_DataGrid
     */
    public function &setStartingCounter($counter )
    {
        if ($counter > 0)
            $this->_startingCounter = $counter;
        else
            $this->_startingCounter = $this->_navigationInit;

        return $this;
    }

        /**
     *
     * @param integer $counter
     * @return Fete_ViewControl_DataGrid
     */
    public function &setNumberColumnsSearch($counter)
    {
        $this->_columnsSearch = $counter;

        return $this;
    }
    
    public function renderActions(){
        
        // botonera accions
        if ($this->_enabledActions) {        
            $output .= '
            <table cellspacing="4" cellpadding="3" border="0" width="100%">
            <tbody>
            <tr align="right">
                <td nowrap="" height="17" class="derecha normal" width="100%">&nbsp;</td>                    
                <td nowrap="" height="17" class="derecha normal">';
                    if (isset($this->_gridActions)) {
                        foreach($this->_gridActions as $action) {
                            $output .= '<a class="boto" href=' . $action['url'] . '>' . $action['title'] . '';
                            $output .= '<img border="0" align="absmiddle" src="' .$action['image']. '" class="imgnoborder">';
                            $output .= '</a>&nbsp;&nbsp;';
                        }    
                    }
            $output .= '</td></tr></tbody></table>';        
        }
        
        return $output;
        //- fi de la botonera d'accions
    }
    
    public function renderSearch(){
	
	$nColumnes = 3;
        $output= '';
        
        if ($this->_enabledSearch) {
            $output = '<div id="borde" class="borde">
            <legend class="apartadosficha" style="width:19%; margin-top:-12px;">Criteris de cerca</legend>            
            <table width="100%">
            <tr>';

            // afegir camps de cerca
            $i = 0;
            if (isset($this->_gridSearch)) {
                foreach($this->_gridSearch as $idSearch => $search) {
                    $i++;
                    $output .= '<td class="normal izquierda">&nbsp;' .$search['name']. ':&nbsp;&nbsp;<input type="text" name="' .$idSearch. '" value="' . $search['value'] .'"></td>';
                    if ($i == $this->_columnsSearch) $output.= '</tr><tr>';                      
                }
            }   
            
            $output.= '</tr>                       
            <tr>
            <td nowrap="" height="17" class="derecha normal" width="100%" colspan="3">&nbsp;</td>            
            <td class="normal derecha"><input type="button" value="Filtrar" onclick="document.getElementById(\'fdg_form_' . $this->_tableId . '\').setAttribute(\'action\', self.location.href); document.getElementById(\'fdg_form_' . $this->_tableId . '\').submit();">
            </td></tr>
            </table>           
            </div>
            <br>';

        }
        return $output;
    }
    
    
    public function renderDataGrid()
    {
        $sortField  = '';
        $sortOrder  = '';
        $data       = $this->_datarows;

        // ordenació de l'array de dades rebudes
        if ($this->_enabledSorting && isset($_POST['__sf'])) {
            $sortField = $_POST['__sf'];
            $sortOrder = $_POST['__so'];

           /* $dataToSort = array();
            foreach ($data as $row)
            {
                $dataToSort[] = $row[$sortField];
            }

            array_multisort($dataToSort, 'desc' === $sortOrder ? SORT_DESC : SORT_ASC, $data);*/
        }
        $output = '';       

        // preparació de les dades de sortida
        if ($this->_enabledSorting) {
            $output .= '
            <input type="hidden" id="__sf" name="__sf" value="'.$sortField.'" />
            <input type="hidden" id="__so" name="__so" value="'.$sortOrder.'" />';
        }
        
        
        // construcció de la taula de dades i atributs
        $output .= '<table';

        foreach ($this->_gridAttributes as $name => $value){
            $output .= ' ' . $name . '="' . $value . '"';
        }

        $output .= '>' . "\n";

        // treetable??
        if ($this->_enableTreetable) {
            $output .= '<caption>
            <a href="#" onclick="jQuery(\'#treetable\').treetable(\'expandAll\'); return false;">Expandeix tot</a> | 
            <a href="#" onclick="jQuery(\'#treetable\').treetable(\'collapseAll\'); return false;">Col·lapsa tot</a>
            </caption>' . "\n";        
        }
        
        if (isset($this->_datarows[0])) {
            
            // construcció de la fila de capçalera
            if (!empty($this->_headers)) {
                $output .= '<tr>' .  "\n";

                foreach ($this->_columns as $field) {
                    $isSortable = in_array($field, $this->_sortableFields) ? true : false;

                    if (isset($this->_headers[$field])) {
                        $output .= "\t" . '<th';

                        if ($this->_enabledSorting && $isSortable) {
                            $output .= ' onclick="document.getElementById(\'fdg_form_' . $this->_tableId . '\').setAttribute(\'action\', self.location.href);document.getElementById(\'__sf\').value=\'' . $field . '\';document.getElementById(\'__so\').value=\'' . (('' === $sortOrder && '' === $sortField) || $sortField !== $field || ('desc' === $sortOrder  && $field === $sortField) ? 'asc' : 'desc') . '\'; document.getElementById(\'fdg_form_' . $this->_tableId . '\').submit();"';
                        }

                        $output .= ' id="fdg_' . $this->_tableId . '_header_' . $field . '" class="fdg_' . $this->_tableId . '_header' . ($this->_enabledSorting && $isSortable ? ' fdg_sortable' : '') . ($field === $sortField ? ' fdg_sort_' . $sortOrder : '') . '">' . (isset($this->_headers[$field]) ? $this->_headers[$field] : '') . '</th>' .  "\n";
                    }
                }
                $output .= '</tr>' .  "\n";
            } // fi construcció de la fila de capçalera

            // construcció de les files de dades
            $counter = 0;
            foreach ($data as $offset => $row)
            {
                ++$counter;
                $rowCounter = $offset + $this->_startingCounter;

                $output .= '<tr';
                if ($this->_rowAttributes) {
                    foreach ($this->_rowAttributes as $name => $value)
                    {
                        $output .= ' ' . $name . '="' . $value . '"';
                    }                    
                }

                if ($this->_enableTreetable) {     
                    if ($row['id'] == '0') {
				$output .= ' data-tt-id="' .$row['parent_id']. '"';                
                    }
                    else {
                        $output .= ' data-tt-id="' .$row['parent_id']. '-' .$row['id']. '" data-tt-parent-id="' .$row['parent_id']. '"';                        
                    }
                }    
                $output .= '>' . "\n";

                foreach ($this->_columns as $field)
                {
                    // assegurem que només es mostren les columnes que estan definides a la matriu carregada al mètode "setGridFields"
                    if (isset($this->_headers[$field])) {                    
                        $data       = isset($row[$field]) ? $row[$field] : '';
                        $template   = isset($this->_cellTemplates[$field]) ? $this->_cellTemplates[$field] : '';

                        $output .= "\t" . '<td';

                        if (isset($this->_cellAttributes[$field])) {
                            foreach ($this->_cellAttributes[$field] as $name => $value)
                            {
                                $output .= ' ' . $name . '="' . $value . '"';
                            }
                        }

                        $reminder = $counter % 2;

                        if (0 === $reminder && null !== $this->_alterRowClass) {
                            $output .= ' class="' . $this->_alterRowClass . ' ' . $this->_cellClass[$field]. '"';
                        } elseif (0 < $reminder && null !== $this->_rowClass) {
                            $output .= ' class="' . $this->_rowClass . ' ' . $this->_cellClass[$field]. '"';
                        }

                        $output .= '>';

                        // mostrem unes dades o altres en funció de si es tracta de treetable o no    
                        if (($this->_enableTreetable) && ($field == 'id')) {     
                                if ($row['id'] == '0') { $output .= '<span class="folder">'.$row['text'].'</span>';}
                                else { $output .= '<span class="file"> Quota: '.$row['text'].'</span>';}                            
                        }
                        else {   
                            if (($this->_enableTreetable) && ($row['id'] == '0')) {}
                            else {    
                                // aplicar la template a les dades d'una cel·la
                                if (!empty($template)) {
                                    $data = $data<>'' ? str_replace('%data%', $data, $template) : str_replace('%data%', 'N', $template);
                                    $data = str_replace('%counter%', $rowCounter, $data);
                                    $data = preg_replace('#(\$(.+?)\$)#sie', 'isset($row["\\2"]) ? $row["\\2"] : \'\\1\'', $data);
                                    preg_match_all('#\[\[([a-z0-9_]+)(?::(.+?))?\]\]#si', $data, $matches, PREG_SET_ORDER);

                                    foreach ($matches as $match) {
                                        if (isset($match[2])) {
                                            $params = explode(',', $match[2]);
                                        } else {
                                            $params = array();
                                        }

                                        $data = str_replace($match[0], call_user_func_array($match[1], $params), $data);
                                    }
                                }
                                $output .= $data;
                            }
                        }
                        $output .= '</td>' . "\n";
                    } // fi construcció cel·les de la fila
                }
                $output .= '</tr>' . "\n"; 
            }
        }  else {
            $output .= '<TR><font class="subtitol_bold">No hi ha resultats disponibles</font></TD></TR>';                
        } // fi construcció de la fila de dades
        
        $output .= '</table>';

        if ($this->_enabledSorting) {
            //$output .= '</form>';
        }

        return $output;
    }	

    
    public function renderNavigation(){
	
        $totalRegistros = $this->_dataNumberRowsQuery;
        $totalPaginas = ceil($totalRegistros / $this->_navigationRows);

        if ($this->_enabledNavigation) {
            $output = '';
            $ini = ((($this->_navigationPage - 1) * $this->_navigationRows) + 1);
            if (($this->_navigationPage * $this->_navigationRows) > $totalRegistros ){$fi = $totalRegistros;}
            else $fi = ($this->_navigationPage * $this->_navigationRows);				

            $output .= '<input type="hidden" id="__np" name="__np" value="" />
            <table width="100%">
            <TR class="normal" width="100%"><TD CLASS="derecha normal" width="100%">
            <font class="subtitol_normal">Mostrant del ' .$ini. ' al ' .$fi. ', de ' .$totalRegistros. ' registres trobats</font>
            </TD></TR>
            <TR class="normal"><TD CLASS="centro normal">';

            if(($this->_navigationPage - 1) > 0) 
                {$output .=  '<a class="normal" href="javascript:document.getElementById(\'fdg_form_' . $this->_tableId . '\').setAttribute(\'action\', self.location.href); document.getElementById(\'__np\').value=\'' . ($this->_navigationPage - 1) . '\'; document.getElementById(\'fdg_form_' . $this->_tableId . '\').submit();">Anterior</a> ';}

            for ($i=1; $i<=$totalPaginas; $i++){
                    if ($this->_navigationPage == $i) {$output .= '<b>'.$this->_navigationPage.'</b> ';} 
                    else { $output .= '<a class="normal" href="javascript:document.getElementById(\'fdg_form_' . $this->_tableId . '\').setAttribute(\'action\', self.location.href); document.getElementById(\'__np\').value=\'' . $i . '\'; document.getElementById(\'fdg_form_' . $this->_tableId . '\').submit();">'.$i.'</a> ';}
            }

            if(($this->_navigationPage + 1) <= $totalPaginas) 
                {$output .=  '<a class="normal" href="javascript:document.getElementById(\'fdg_form_' . $this->_tableId . '\').setAttribute(\'action\', self.location.href); document.getElementById(\'__np\').value=\'' . ($this->_navigationPage + 1) . '\'; document.getElementById(\'fdg_form_' . $this->_tableId . '\').submit();">Següent</a>';}

            $output .= '</td></tr></table>';
        }
        
        return $output;
    }
    
    public function renderTreeTableScript(){
    
        global $CONFIG;

        if ($this->_enableTreetable) {     
            
            $output = '
                <link rel="stylesheet" href="' .$CONFIG['theme_dir']. 'treetable/screen.css" media="screen" />
                <link rel="stylesheet" href="' .$CONFIG['theme_dir']. 'treetable/jquery.treetable.css" />
                <link rel="stylesheet" href="' .$CONFIG['theme_dir']. 'treetable/jquery.treetable.theme.default.css" />
                <script src='.$CONFIG['theme_dir'].'js/vendor/jquery.js></script>
                <script src='.$CONFIG['theme_dir'].'js/vendor/jquery-ui.js></script>
                <script src='.$CONFIG['theme_dir'].'js/jquery.treetable.js></script>

                <script>

                  $("#treetable").treetable({ expandable: true });

                  // Highlight selected row
                  $("#treetable tbody").on("mousedown", "tr", function() {
                    $(".selected").not(this).removeClass("selected");
                    $(this).toggleClass("selected");
                  });

                  // Drag & Drop Example Code
                  $("#treetable .file, #treetable .folder").draggable({
                    helper: "clone",
                    opacity: .75,
                    refreshPositions: true, // Performance?
                    revert: "invalid",
                    revertDuration: 300,
                    scroll: true
                  });

                  $("#treetable .folder").each(function() {
                    $(this).parents("#treetable tr").droppable({
                      accept: ".file, .folder",
                      drop: function(e, ui) {
                        var droppedEl = ui.draggable.parents("tr");
                        $("#treetable").treetable("move", droppedEl.data("ttId"), $(this).data("ttId"));
                      },
                      hoverClass: "accept",
                      over: function(e, ui) {
                        var droppedEl = ui.draggable.parents("tr");
                        if(this != droppedEl[0] && !$(this).is(".expanded")) {
                          $("#treetable").treetable("expandNode", $(this).data("ttId"));
                        }
                      }
                    });
                  });

                  $("form#reveal").submit(function() {
                    var nodeId = $("#revealNodeId").val()

                    try {
                      $("#treetable").treetable("reveal", nodeId);
                    }
                    catch(error) {
                      alert(error.message);
                    }

                    return false;
                  });
                </script>';  
        }
        
        return $output;
    }
    
    public function render()
    {
        $output = $this->renderActions();
        $output .= '<form id="fdg_form_' . $this->_tableId . '" method="post" action="' . $_SERVER['REQUEST_URI'] . '">';
            $output .= $this->renderSearch();
            $output .= $this->renderDataGrid();
            $output .= $this->renderNavigation();    
        $output .= '</form> ';
        $output .= $this->renderTreeTableScript();
        echo $output;
    }

    public function  __toString()
    {
        $output = $this->renderActions();
        $output .= '<form id="fdg_form_' . $this->_tableId . '" method="post" action="' . $_SERVER['REQUEST_URI'] . '">';        
            $output .= $this->renderSearch();
            $output .= $this->renderDataGrid();
            $output .= $this->renderNavigation();
        $output .= '</form> ';  
        $output .= $this->renderTreeTableScript();        
        return $output;
    }
}