<?php

class Datagrid {

    protected $_headers         = array();
    protected $_columns         = array();
    protected $_datarows        = array();
    protected $_cellTemplates   = array();
    protected $_cellAttributes  = array();
    protected $_cellClass       = array();
    protected $_cellEditable    = array();

    protected $_enabledData     = true;
    protected $_enabledEdit     = true;
    
    protected $_enabledNavigation = false;
    protected $_navigationRows    = 0;
    protected $_navigationPage    = 1;
    protected $_navigationAll     = 0;

    protected $_enabledSearch     = false;
    protected $_gridSearch        = array();
    
    protected $_enabledSorting  = false;
    protected $_sortableFields  = array();
    protected $_sortField       = '';
    protected $_sortOrder       = '';
    
    protected $_enabledTree     = false;
    protected $_enabledPrint     = false;



    public static function getInstance($data)
    {
        return new self($data);
    }

    public function __construct($data) {        
        
        $this->_datarows = $data;

    }
    
    public function &enableData($enabled) {
        
        $this->_enabledData = $enabled;
        return $this;
    }
    public function &enableNavigation($enabled) {
        
        $this->_enabledNavigation = $enabled;
        return $this;
    }
    public function &enableSorting($enabled)
    {
        $this->_enabledSorting = $enabled;

        return $this;
    }
    public function &enableSearch($enabled) {
        
        $this->_enabledSearch = $enabled;
        return $this;
    }
    public function &enableEdit($enabled) {
        
        $this->_enabledEdit = $enabled;
        return $this;
    }    
    public function &enableTree($enabled)
    {
        $this->_enabledTree = $enabled;

        return $this;
    }
    public function &enablePrint($enabled)
    {
        $this->_enabledPrint = $enabled;

        return $this;
    }    
    public function &setGridSearch($searchs){
        
        foreach ($searchs as $search => $setting) {
            $this->_gridSearch[$search] = $setting;
        }        
                
        return $this;
    }
    public function &setGridFields($settings)
    {
        foreach ($settings as $field => $setting)
        {
            $this->_columns[] = $field; 

            if (isset($setting['header'])) {
                $this->_headers[$field] = $setting['header'];
            }
            if (isset($setting['attributes'])) {
                $this->_cellAttributes[$field] = $setting['attributes'];
            }            
            if (isset($setting['cellTemplate'])) {
                $this->_cellTemplates[$field] = $setting['cellTemplate'];
            }
            if (isset($setting['class'])) {
                $this->_cellClass[$field] = $setting['class'];
             }   
            if (isset($setting['sortable'])) {
                if ($setting['sortable'] == 'si') $this->_sortableFields[] = $field;
            }  
            if (isset($setting['edit'])) {
                $this->_cellEditable[$field] = $setting['edit'];
            }            
        }   
        return $this;
    }       
    
    public function &setGridNavigation ($np, $nr,$na) {  
         
        if ($this->_enabledNavigation)
        {               
            if (!$np) {
                    $this->_navigationPage = 1;
            } else {$this->_navigationPage  = $np;}
            
            $this->_navigationRows  = $nr;
            $this->_navigationAll  = $na;
        }
        return $this;
    }
    public function &setGridSorting ($sf, $so) {  
         
        if ($this->_enabledSorting)
        {                          
            $this->_sortField  = $sf;
            $this->_sortOrder  = $so;
        }
        return $this;
    }    
    public static function &getGridNavigationLimits ($np, $nr) {
        
        if (!$np) {$inici = 0;}
        else {$inici = ($np - 1) * $nr; }              
        
        return $inici;
    }   
    public function &getTreetableEnabled(){
        return $this->_enabledTree;
    }
    public function &getPrinttableEnabled(){
        return $this->_enabledPrint;
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
    
    public function renderSearchTable(){

	$nColumnes = 4;
        $elementsxcolumna = 0;
        $output= '';
        
        if ($this->_enabledSearch) {
            
            // afegir camps de cerca
            $i = 1;
            $amplada = 0;
            if (isset($this->_gridSearch)) {
                $output .= '<div class="modal-body">';
                $output .= '<div class="row">';
                foreach($this->_gridSearch as $idSearch => $search) {
                    $amplada += $search['size'];
                    if ($amplada >12) {$output .= '</div><div class="row" style="margin-top:6px;">'; $amplada = $search['size'];} 
                    $output .= '<div class="col-sm-'.$search['size'].'">'
                            . '<div class="form-group">'
                            . '<label>' .$search['name'].'</label>';
                    
                    if (substr($search['type'],0,5) == 'combo'){ 
                            $consulta = DB::query($search['query'])->get();                        
                            if ($consulta) {
                                $output .= '<select name="' .$idSearch. '" class="form-control" style="margin-left: 5px;">';
                                $output .= ($search['type'] === 'combowithoutall') ? '': '<option value="">Tots</option>';    
                                foreach ($consulta as $row) {                                    
                                    $output .= '<option value="' .$row->id. '"'; 
                                    if ($search['value'] == $row->id) $output .= ' selected="selected"';      
                                    $output .= ' >' .$row->txt. '</option>';
                                }                             
                                $output .= '</select></div></div>';    
                            }    
                    } else {                   
                        $output .= '<input class="form-control"  style="margin-left: 5px;" id="'.$idSearch. '" name="'.$idSearch.'" value="' . $search['value'] .'"></label></div></div>';
                    }
                    $i++;
                }
                $output .= '</div></div>';
            }   
            
            $output.= '<div class="modal-footer"><div class="row"><div class="col-sm-12"><button type="submit" class="btn btn-primary">Cercar</button>
                       <button type="submit" class="btn btn-default">Esborrar</button></div></div></div>';
        }
        return $output;
    }
    
    public function renderHeaderTable() {
        
        $output = ''; 
        
        // afegir camps d'ordenació
        if ($this->_enabledSorting) {
            $output .= '<input type="hidden" id="__sf" name="__sf" value="'.$this->_sortField.'" />
                        <input type="hidden" id="__so" name="__so" value="'.$this->_sortOrder.'" />';
        }
            
        if (!empty($this->_headers)) {
                foreach ($this->_columns as $field) { 
                    $isSortable = in_array($field, $this->_sortableFields) ? true : false;
                    $output .= '<th '; 
                    if ($this->_enabledSorting && $isSortable) {
                        $output .= 'class="sorting_'.$this->_sortOrder.'" onclick="document.getElementById(\'datagrid_form\').setAttribute(\'action\', self.location.href);document.getElementById(\'__sf\').value=\'' . $field . '\';document.getElementById(\'__so\').value=\'' . (('' === $this->_sortOrder && '' === $this->_sortField) || $this->_sortField !== $field || ('desc' === $this->_sortOrder  && $field === $this->_sortField) ? 'asc' : 'desc') . '\'; document.getElementById(\'datagrid_form\').submit();"';
                    }
                    $output .= ' aria-label="ID">'.(isset($this->_headers[$field]) ? $this->_headers[$field] : '').'</th>';
                }    
        }          

        return $output;
    }
    
    public function renderDataTable($print='') {
                
        $output = ''; 
        $i = 1;
        $v = '';
        if ($this->_enabledData) {
            foreach ($this->_datarows as $offset => $object) {
                
                $output .= '<tr role="row"';
                if ($this->_enabledTree) {                                           
                    if ($object->parent_id == '0') {
			$output .= ' data-tt-id="' .$object->id. '"';                
                    }                    
                    else {
                        $output .= ' data-tt-id="' .$object->id. '" data-tt-parent-id="' .$object->parent_id. '"';
                    }
                }
                $output .= ($object->attr == 'folder') ? ' id="capsalera"' : '';
                $output .= ($object->attr == 'file') ? ' id="subfila"' : '';
                $output .= ($object->attr == 'subtotal') ? ' id="resum_totals"' : '';
                $output .= ($object->attr == 'total') ? ' id="totals"' : '';
                // fer que la taula sigui tipus zebra
                if ($print == 'p'){
                    if ($object->text <> '') $class = ($class=='even') ? 'odd' : 'even'; //ratllat per grups de files
                    $output .= ' class="'.$class.'">'; 
                } else {
                    $output .= (($i % 2) == 0) ? ' class="even">' : ' class="odd">';  //ratllat normal (una sí, una no)
                }    
                

                foreach ($object as $field => $value) {

                    // assegurem que només es mostren les columnes que estan definides a la matriu carregada al mètode "setGridFields"
                    if (isset($this->_headers[$field])) {       
                        $output .= '<td';

                        // aplicar atributs de la cel.la
                        if (isset($this->_cellAttributes[$field])) {
                            foreach ($this->_cellAttributes[$field] as $nameAttr => $valueAttr) {$output .= ' ' . $nameAttr . '="' . $valueAttr . '"';}
                        }                                        

                        // aplicar class CSS de la cel.la
                        if ($object->attr <> 'total') {
                            if (isset($this->_cellClass[$field])){ $output .= ' class="' .$this->_cellClass[$field]. '"';}
                        }    
                        $output .= '>';

                        // comprovar si la cel.la ha de ser editable
                        if (isset($this->_cellEditable[$field])) {                            
                            $output .= '<input type="text" id="row-'.$i.'-'.$field.'" name="row-'.$i.'-'.$field.'" class="form-control" size="4" value="';
                        }
                        
                        if (($this->_enabledTree) && ($field == 'id')) {
                            $chr = str_replace('<p>', '', $object->text);
                            $chr = str_replace('</p>', '', $chr);
                            $output .= '<span class="'.$object->attr.'">'.$chr.'</span>';
                        }else { 
                            // aplicar la plantilla sobre el valor de la cel.la
                            $data = (isset($value) ? $value : '');
                            $template   = isset($this->_cellTemplates[$field]) ? $this->_cellTemplates[$field] : '';
                            if (!empty($template) && $value <> '') {
                                $data = $data<>'' ? str_replace('%data%', $data, $template) : str_replace('%data%', ' ', $template);
                                $data = str_replace('%counter%', $rowCounter, $data);

                                $data = preg_replace_callback(
                                   '(\$(.+?)\$)', 
                                    function ($matches) use ($value) {
                                        $out = isset($value) ? $value : $matches[0];
                                        return $out;    
                                    },
                                    $data);


                                preg_match_all('#\[\[([a-z0-9_]+)(?::(.+?))?\]\]#si', $data, $matches, PREG_SET_ORDER);

                                foreach ($matches as $match) {
                                    if (isset($match[2])) {$params = explode(',', $match[2]);} 
                                    else {$params = array();}
                                    $data = str_replace($match[0], call_user_func_array($match[1], $params), $data);
                                }
                            }
                                $data = str_replace('x0% rec.', ' rec.', $data); //maquillatge pels exercicis que tenen pes = 0;
                                $output .= $data;  
                            }    
                        $output .= (isset($this->_cellEditable[$field])) ? '"></td>' : '</td>';
                    }
                }       
                $output .= '</tr>';
                $i++;
            }
        }
        return $output;
    }
    
    public function renderNavigationTable($value) {
                      
        if ($this->_enabledNavigation) {
            $totalPaginas = ceil($this->_navigationAll / $this->_navigationRows);
            
            $ini = ((($this->_navigationPage - 1) * $this->_navigationRows) + 1);
            if (($this->_navigationPage * $this->_navigationRows) > $this->_navigationAll ){$fi = $this->_navigationAll;}
            else $fi = ($this->_navigationPage * $this->_navigationRows);
            if ($fi == 0) $ini = 0;
            
            if ($value == 'total') return 'Mostrant del '.$ini.' fins '.$fi.' de '.$this->_navigationAll.' registres';

            

            $output = '<ul class="pagination">';
            if(($this->_navigationPage - 1) > 0) {
                $output .= '<li class="paginate_button previous"><a href="javascript:document.getElementById(\'datagrid_form\').setAttribute(\'action\', self.location.href); document.getElementById(\'__np\').value=\'' . ($this->_navigationPage-1) . '\'; document.getElementById(\'datagrid_form\').submit();">Anterior</a></li>';                                                        
            }
                        
            $ini = ($this->_navigationPage <= 5) ? 1 : $this->_navigationPage - 5;
            $fi = (($ini + 9) < $totalPaginas) ? $ini+9 : $totalPaginas;
            for ($i=$ini; $i<=$fi; $i++){
                $output .= '<li class="paginate_button';
                if ($this->_navigationPage == $i) $output.= ' active';
                $output .= '"><a href="javascript:document.getElementById(\'datagrid_form\').setAttribute(\'action\', self.location.href); document.getElementById(\'__np\').value=\'' . $i . '\'; document.getElementById(\'datagrid_form\').submit();">'.$i.'</a></li>';
                }
                        
                if(($this->_navigationPage + 1) <= $totalPaginas) {
                    $output .= '<li class="paginate_button next"><a href="javascript:document.getElementById(\'datagrid_form\').setAttribute(\'action\', self.location.href); document.getElementById(\'__np\').value=\'' . ($this->_navigationPage+1) . '\'; document.getElementById(\'datagrid_form\').submit();">Següent</a></li>';                            
                }
                        
            $output .= '</ul>';
            if ($value == 'navigate') return $output;    
        }
        return '';
    }
       
    public function renderDataGrid() {
        
        $output = '<form id="datagrid_form" method="post" action="' . $_SERVER['REQUEST_URI'] . '">';      
        
        if ($this->_enabledSorting) {
            $output .= '<input type="hidden" id="__sf" name="__sf" value="'.$this->_sortField.'" />
                        <input type="hidden" id="__so" name="__so" value="'.$this->_sortOrder.'" />';
        }
        
        $output .= '<div class="row">';
        $output.= $this->renderSearchTable(); 
        if ($this->_enabledData) {
            $output .= '<table id="datagrid" class="table dataTable" role="grid" aria-describedby="datagrid_info">';  
            if (!empty($this->_headers)) {
                $output .= '<thead>';
                $output .= '<tr role="row">';
                $output .= $this->renderHeaderTable();
                $output .= '</tr>';                        
                $output .= '</thead>';
            }
            $output .= '<tbody>';
            $output .= $this->renderDatatable();
            $output .= '</tbody>';
            $output .= '</table>';
        }    
        $output .= '</div><!-- /.row -->';
        if ($this->_enabledNavigation) {
            $output .= '<div class="row">';
            $output .= $this->renderNavigationTable();
            $output .= '</div>';
        }    
        $output .= '</form>';
        echo $output;
    }
    
    public function renderCarnetsGrid()
    {
        
        $output = '';        
	$ample = 280;
	$alt = 180;
        $i = 0;       
		
        foreach ($this->_datarows as $offset => $object) {

                $marginleft = (($i % 2) * ($ample)) + 0.65;
		$margintop =  ((intval($i / 2)) * ($alt)) + 8.85;
		$output .= '
                <div id="content" style="margin-left:' .$marginleft. 'pt; margin-top: '. $margintop. 'pt;">
                    <div id="requadrefoto" style="margin-left: 14pt; margin-top: 15pt;">
                        <div id="foto" style="margin-left: 2pt; margin-top: 2pt;">';

                        $filename = APP_PATH_ABS.APP_PATH_CONTENT."gestio/manager/fotos/" .$object->TPERSONA_FOTOGRAFIA;                        
                        if (file_exists($filename)) $output .= "<img class='carnet-user-img img-circle' src='" .APP_PATH.APP_PATH_CONTENT."gestio/manager/fotos/".$object->TPERSONA_FOTOGRAFIA. "' width='91' height='120'>";
                        else $output .= "<img class='carnet-user-img img-circle' src='" .APP_PATH.APP_PATH_THEME.THEME. "/img/fotografia.jpg' width='91' height='120'>";                                
                                
                $output .= '</div>
                    </div>
                    <div id="marcaaigua">					
                        <img src="'.APP_PATH.APP_PATH_THEME.THEME. '/img/logo_marcaaigua.png">								
                    </div>
                    <div id="logo" style="margin-left: 106pt; margin-top: 5pt;">
                        <img src="' .APP_PATH.APP_PATH_THEME.THEME. '/img/logo_carnet.png" width=195; height=65>
                    </div>
                    <div id="soci" style="margin-left: 14pt; margin-top: 100pt;">
                        <p style="margin-bottom:0cm;margin-bottom:.0001pt; line-height:normal">
                            <b><span style="font-size:8.0pt;color:#365F91;">';
                            //if ($row["TALTES_TIPUS"] == 'E') $output .= $object->TMESTREMODALITATSESCOLA_DESCRIPCIO. '</span></b>';
                            //if ($row["TALTES_TIPUS"] == 'S') $output .= 'Soci n&uacute;m ' .$object->TSOCI_NUMSOCI. '</span></b>';                            
                $output .= '</p>
                    </div>
                    <div id="dades" style="margin-left: 105pt; margin-top: 70pt;">
                    <p style="margin-bottom:0cm;margin-bottom:.0001pt; line-height:normal;">
                        <b><span style="font-size:10.0pt;color:#365F91;">' .$object->TPERSONA_NOM. '<br>'
                            .$object->TPERSONA_COGNOM1.
                            '&nbsp;';
                            if ($object->TPERSONA_COGNOM2== '') $output .= '&nbsp;';
                            else $output .= $object->TPERSONA_COGNOM2; 
                        $output .= '</span></b>
                    </p>
                    </div>
                    <div id="peu" style="margin-left: 0pt; margin-top: 131.5pt; color:#00D25F; background-color:#365F91;">
                        TEMPORADA ' .$object->TMESTRETEMPORADES_DESCRIPCIO.
                    '</div>
		</div>';
	
		if ((($i + 1) % 10) == 0) {$output .= '<div class="saltopagina"></div>';}   
                $i++;
            }                               
     
        echo $output;
    }
    
    
}
