<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * Description of class-utils
 *
 * @author 0001553
 */

require_once APP_PATH_ABS.APP_PATH_INCLUDE.'class/class-datagrid.php';

class Utils {

    public function  __construct($id) {            
        return $this;
    }
    
    public static function creaCombo($idCombo, $query, $multiple=false, $value='') {
 
        $consulta = DB::query($query)->get();                   
 
        $output .= '<select id="'.$idCombo. '" name="' .$idCombo. '" class="form-control select2" style="width: 100%;"';
        if ($multiple) $output .= ' multiple="multiple" ';
        $output .= '><option value="">Selecciona una opció...</option>';    
        
        if ($consulta) {
            foreach ($consulta as $row) {                                    
                $output .= '<option value="' .$row->id. '"'; 
                if ($value == $row->id) $output .= ' selected="selected"';      
                $output .= ' >' .$row->txt. '</option>';
            }                             
        }
        
        $output .= '</select>';    
        
        return $output;
}    

    public static function retornaValorsCombo($query) {

        $consulta = DB::query($query)->get();                        
        if ($consulta) {
            $output .= '<option value="">Selecciona una opció...</option>';    
            foreach ($consulta as $row) {                                    
                $output .= '<option value="' .$row->id. '"'; 
                $output .= ' >' .$row->txt. '</option>';
            }                             
        }
        return $output;
}
    
    
    
}
