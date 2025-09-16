<?php
/**
 * Clase Login para validar un usuario comprobando su usuario (o email) y contraseña
 * Forma parte del paquete de tutoriales en PHP disponible en http://www.emiliort.com
 * @author Emilio Rodríguez - http://www.emiliort.com
 */


 class Login {
	

    private $link; //identificador de la conexión mysql que usamos
    
    /**
     * establecemos el método  de construccion de la clase que se llamará al crear el objeto. Conectamos a la base de datos
     * @return bool
     */
    public function __construct() {
        
        return true;        
    }
   
    //el metodo de destrucción al destruir el objeto
    public function __destruct() {
        return true;
    }
   
   
    /**
     * valida un usuario y contraseña
     * @param string $usuario
     * @param string $password
     * @return bool
     */
    public function inici($usuario, $password) {
	
        //usuario y password tienen datos?
        if (empty($usuario)) return false;
        if (empty ($password)) return false;	
		
        //2 - preparamos la consulta SQL a ejecutar utilizando sólo el usuario y evitando ataques de inyección SQL.
        $query = 'SELECT loginNomUsuari, loginPassword ';
	$query .= 'FROM scm_loginusuaris ';
	$query .= 'WHERE loginNomUsuari = "'.$usuario. '" ';		
	$query .= 'LIMIT 1 '; 
        $row = DB::query($query)->getFirst();

        //3 - extraemos el registro de este usuario
        if ($row) {
            //4 - Generamos el hash de la contraseña encriptada para comparar o lo dejamos como texto plano
            switch (SCM_PWD_ENCRIPTACIO) {
                case 'sha1'|'SHA1':
                    $hash=sha1($password);
                    break;
                case 'md5'|'MD5':
                    $hash=md5($password);
                    break;
                case 'texto'|'TEXTO':
                    $hash=$password;
                    break;
                default:
                    trigger_error('El valor de la propiedad metodo_encriptacion no es válido. Utiliza MD5 o SHA1 o TEXTO',E_USER_ERROR);
            }

            //5 - comprobamos la contraseña
            if ($hash==$row->loginPassword) {
                @session_start();
                $_SESSION['USUARIO']=array('user'=>$row->loginNomUsuari); //almacenamos en memoria el usuario
                // en este punto puede ser interesante guardar más datos en memoria para su posterior uso, como por ejemplo un array asociativo con el id, nombre, email, preferencias, ....
                return true; //usuario y contraseña validadas
            } else {
 
                @session_start();
                unset($_SESSION['USUARIO']); //destruimos la session activa al fallar el login por si existia
                return false; //no coincide la contraseña
            }
        } else {
            //El usuario no existe
            return false;
        }

    }
    
    /**
     * Veridica si el usuario está logeado
     * @return bool
     */
    public function hihaLogin () {
        @session_start(); //inicia sesion (la @ evita los mensajes de error si la session ya está iniciada)

        if (!isset($_SESSION['USUARIO'])) return false; //no existe la variable $_SESSION['USUARIO']. No logeado.
        if (!is_array($_SESSION['USUARIO'])) return false; //la variable no es un array $_SESSION['USUARIO']. No logeado.
        if (empty($_SESSION['USUARIO']['user'])) return false; //no tiene almacenado el usuario en $_SESSION['USUARIO']. No logeado.

        //cumple las condiciones anteriores, entonces es un usuario validado
		return true;
    }

	/**
     * Veridica si el usuario está logeado
     * @return bool
     */
    public function tePermisos() {
		
		global $CONFIG;
		
		@session_start(); //inicia sesion (la @ evita los mensajes de error si la session ya está iniciada)

		// cal verificar que té accés sobre la pàgina
		$usuario = $_SESSION['USUARIO']['user'];
		
                $query = 'SELECT ' .$CONFIG['campusuari']. ' ';
		$query .= 'FROM '.$CONFIG['taulausuaris']. ',' .$CONFIG['taulapermisos']. ' ';
		$query .= 'WHERE ' .$CONFIG['campIdUsuariPermisos']. ' = ' .$CONFIG['campIdUsuari']. ' ';
		$query .= 'AND '. $CONFIG['campusuari']. '="'.mysql_real_escape_string($usuario). '" ';		
		$query .= 'AND ' .$CONFIG['campIdPagina']. ' = "'.$this->nombre_pagina. '" ';				
		$query .= 'LIMIT 1 '; //la tabla y el campo se definen en los parametros globales	
		$result = mysql_query($query);
        if (!$result) {
            trigger_error('Error executant la consulta SQL: ' . mysql_error($this->link),E_USER_ERROR);
			echo $query;
        }

        $row = mysql_fetch_assoc($result);
		if ($row) return true;
    }
	
    /**
     * Vacia la sesion con los datos del usuario validado
     */
    public static function logout() {
        @session_start(); //inicia sesion (la @ evita los mensajes de error si la session ya está iniciada)
        unset($_SESSION['USUARIO']); //eliminamos la variable con los datos de usuario;
        session_write_close(); //nos asegurmos que se guarda y cierra la sesion
        return true;
    }    
}
    
?>