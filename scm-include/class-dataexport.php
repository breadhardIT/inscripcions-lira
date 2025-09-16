<?php

/* 
 * Copyright (c) 2009 Nguyen Duc Thuan <me@ndthuan.com>
 * All rights reserved.
 */

class DataExport
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
    
    
    
    public function renderDataGrid()
    {
        $data       = $this->_datarows;
        $output = '';               
        
        // construcció de la taula de dades i atributs
        $output .= '<table';

        foreach ($this->_gridAttributes as $name => $value){
            $output .= ' ' . $name . '="' . $value . '"';
        }

        $output .= '>' . "\n";

        
        if (isset($this->_datarows[0])) {
            
            // construcció de la fila de capçalera
            if (!empty($this->_headers)) {
                $output .= '<tr>' .  "\n";

                foreach ($this->_columns as $field) {
                    if (isset($this->_headers[$field])) {
                        $output .= "\t" . '<th';
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
        
        return $output;
    }	

     
    public function render()
    {
        $output = $this->renderDataGrid();
        echo $output;
    }

    public function  __toString()
    {
        $output = $this->renderDataGrid();
        return $output;
    }
}